<?php

class Memcache
{
    /**
     * Default Values
     */
    const DEFAULT_HOST = '127.0.0.1';
    const DEFAULT_PORT =  11211;
    const DEFAULT_PERSISTENT = true;
    const DEFAULT_WEIGHT  = 1;
    const DEFAULT_TIMEOUT = 3;
    const DEFAULT_RETRY_INTERVAL = 15;
    const DEFAULT_STATUS = true;
    const DEFAULT_FAILURE_CALLBACK = null;
	const DEFAULT_EXPIRY_LIMIT = 0;
    
    const PREFIX_KEY      = 'pf:k:';
   

    /**
     * Available options
     *
     * =====> (array) servers :
     * an array of memcached server ; each memcached server is described by an associative array :
     * 'host' => (string) : the name of the memcached server
     * 'port' => (int) : the port of the memcached server
     * 'persistent' => (bool) : use or not persistent connections to this memcached server
     * 'weight' => (int) : number of buckets to create for this server which in turn control its
     *                     probability of it being selected. The probability is relative to the total
     *                     weight of all servers.
     * 'timeout' => (int) : value in seconds which will be used for connecting to the daemon. Think twice
     *                      before changing the default value of 1 second - you can lose all the
     *                      advantages of caching if your connection is too slow.
     * 'retry_interval' => (int) : controls how often a failed server will be retried, the default value
     *                             is 15 seconds. Setting this parameter to -1 disables automatic retry.
     * 'status' => (bool) : controls if the server should be flagged as online.
     * 'failure_callback' => (callback) : Allows the user to specify a callback function to run upon
     *                                    encountering an error. The callback is run before failover
     *                                    is attempted. The function takes two parameters, the hostname
     *                                    and port of the failed server.
     *
     * =====> (boolean) compression :
     * true if you want to use on-the-fly compression
     *
     * =====> (boolean) compatibility :
     * true if you use old memcache server or extension
     *
     * @var array available options
     */
    private $_options = array(
        'servers' => array(array(
            'host' => self::DEFAULT_HOST,
            'port' => self::DEFAULT_PORT,
            'persistent' => self::DEFAULT_PERSISTENT,
            'weight'  => self::DEFAULT_WEIGHT,
            'timeout' => self::DEFAULT_TIMEOUT,
            'retry_interval' => self::DEFAULT_RETRY_INTERVAL,
            'status' => self::DEFAULT_STATUS,
            'failure_callback' => self::DEFAULT_FAILURE_CALLBACK,
            'ttl' => self::DEFAULT_EXPIRY_LIMIT,
        )),
        'compression' => false,
        'compatibility' => false,
    );

    /**
     * Memcache object
     *
     * @var mixed memcache object
     */
    private $_memcache = null;

    /**
     * Namespce Separator
     */
    public $namespacePrefix = self::PREFIX_KEY;
    
    /**
     * Memcache Key Namespace 
     */
    private $_namespace;
    
    /**
     * Constructor
     *
     * @param array $options associative array of options
     * @throws Exception
     */
    public function __construct(array $options = array())
    {
    	
    	//$this->_options[Memd::OPT_COMPRESSION] = false;
    	if (!extension_loaded('memcached')) {
            show_error('Memcache Server','The memcached extension must be loaded for using!');
        }else{
			 $this->_configureOptions($options);
		     if (isset($this->_options['servers'])) {
		     	$value= $this->_options['servers'];
		        if (isset($value['host'])) {
		        	// in this case, $value seems to be a simple associative array (one server only)
		            $value = array(0 => $value); // let's transform it into a classical array of associative arrays
		        }
		         $this->setOption('servers', $value);
		     }
		        
		      $this->_memcache = new Memd;
		      $this->_memcache->setOptions(array(Memd::OPT_COMPRESSION => false, Memd::OPT_HASH => Memd::DISTRIBUTION_CONSISTENT));
		      //$this->_memcache->setOptions(array());
		      
		      foreach ($this->_options['servers'] as $server) {
		      	if (!array_key_exists('port', $server)) {
		        	$server['port'] = self::DEFAULT_PORT;
		        }
		        if (!array_key_exists('weight', $server)) {
		        	$server['weight'] = self::DEFAULT_WEIGHT;
		        }
		      }
		        
		      $this->getResource()->addServer($server['host'],$server['port'], $server['weight']);
		}
       
    }

    private function _configureOptions($options) {
    	while (list($name, $value) = each($options)) {
    		$this->setOption($name, $value);
    	}
    }
    
    private function setOption($name, $value)
    {
    	if (!is_string($name)) {
    		show_error('Memcache Server', "Incorrect option name : $name");
    	}
    	$name = strtolower($name);
    	if (array_key_exists($name, $this->_options)) {
    		$this->_options[$name] = $value;
    	}
    	
    }

    public function getOptions($key) {
    	if(isset($this->_options[$key])) {
    		return $this->_options[$key];
    	} else {
    		return null;
    	}
    }
    
    public function getStats() {
    	return $this->getResource()->getStats();
    }
    
    public function getResource() {
    	return $this->_memcache;
    }
    
    public function getAvailableSpace() {
    	$stats = $this->getStats();
    	$mem = array_pop($stats);
    	return $mem['limit_maxbytes'] - $mem['bytes'];
    }
    
    public function getTotalSpace() {
    	$stats = $this->getStats();
    	$mem = array_pop($stats);
    	return $mem['limit_maxbytes'];
    }

    public function setNamespace($namespace) {
    	//$this->_namespace = $namespace.":";
		$this->_namespace = $namespace;
    } 
    
    public function getNamespace() {
    	return $this->_namespace;
    }
        
    public function getItem( $normalizedKey,  $casToken = null) {
    	//echo $normalizedKey."<br/>";
    	//Author Salim : Cache Enable disable setting
    	$start = round(microtime(true), 4);
    	if(MEMCACHE_ENABLE){
    		$normalizedKey = $this->sanitizeKey($normalizedKey);
    		$memc        = $this->getResource();
    		$internalKey = $this->namespacePrefix . $this->getNamespace() .$normalizedKey; 
    		
    		if (func_num_args() > 1) {
    			$result = $memc->get($internalKey, null, $casToken);
    		} else {
    			$result = $memc->get($internalKey);
    		}
    		
			//pr($result);
    		$success = true;
    		if ($result === false || $result === null) {
    			//echo "dead"; exit;
    			$rsCode = $memc->getResultCode();
    			if ($rsCode == Memd::RES_NOTFOUND) {
    				$result = null;
    				$success = false;
    				
    			} elseif ($rsCode) {
    				$success = false;
    				show_error('Memcached', $memc->getResultMessage());
    			}
    		}
    		 
    	}else{
    		$result = array();
    	}
    	$end = round(microtime(true), 4);
    	$total = round($end - $start, 4);
    	system_log(array('function' =>  'getItem', 'event' => 'MEMCACHE' ,'proctime' => $total));
    	return $result;
    }
    
    public function getItems( $normalizedKeys, $maintainPrefix=false) {	
    	//Author Salim : Cache Enable disable setting
    	$start = round(microtime(true), 4);
    	if(MEMCACHE_ENABLE){
    		$memc = $this->getResource();    		
		$customKeys = array();
    		foreach ($normalizedKeys as  $normalizedKey) {				
				$orignalKey = $normalizedKey;
	    			$normalizedKey = $this->sanitizeKey($normalizedKey);
				$normalizedKey = $this->namespacePrefix . $this->getNamespace() . $normalizedKey;
				$customKeys[]  = $normalizedKey;				
    		}
    		
    		$result = $memc->getMulti($customKeys);
    		if ($result === false) {
    			throw $this->getExceptionByResultCode($memc->getResultCode());
    		}
    		 
    		// remove namespace prefix from result
    		if ($result && !$maintainPrefix) {
    			$tmp            = array();
    			$nsPrefixLength = strlen($this->namespacePrefix.$this->getNamespace());
    			foreach ($result as $internalKey => & $value) {
    				$tmp[ substr($internalKey, $nsPrefixLength) ] = json_decode($value, true);
    			}
    			$result = $tmp;
    		}
    		
    	}else{
    		$result = array();
    	}
    	$end = round(microtime(true), 4);
    	$total = round($end - $start, 4);    
    	system_log(array('function' =>  'getItems', 'event' => 'MEMCACHE' ,'proctime' => $total));
    	return $result;
    }
    
    public function getMetadatas(array & $normalizedKeys)
    {
    	$memc = $this->getResource();
    
    	foreach ($normalizedKeys as & $normalizedKey) {
    		$normalizedKey = $this->namespacePrefix . $this->getNamespace() . $normalizedKey;
    	}
    
    	$result = $memc->getMulti($normalizedKeys);
    	if ($result === false) {
    		throw $this->getExceptionByResultCode($memc->getResultCode());
    	}
    
    	// remove namespace prefix and use an empty array as metadata
    	if ($this->namespacePrefix !== '') {
    		$tmp            = array();
    		$nsPrefixLength = strlen($this->namespacePrefix.$this->getNamespace());
    		foreach (array_keys($result) as $internalKey) {
    			$tmp[ substr($internalKey, $nsPrefixLength) ] = array();
    		}
    		$result = $tmp;
    	}
    
    	return $result;
    }
    
    /* writing */
    
    public function setItem( $normalizedKey,  $value, $expiry = null)
    {
    	$start = round(microtime(true), 4);
		if(MEMCACHE_ENABLE){
			$normalizedKey = $this->sanitizeKey($normalizedKey);
	    	$memc       = $this->getResource();
	    	$expiration = $this->expirationTime($expiry);
	    	//$expiration = $this->expirationTime();
	    	if (!$memc->set($this->namespacePrefix . $this->getNamespace() . $normalizedKey, $value, $expiration)) {
	    		throw $this->getExceptionByResultCode($memc->getResultCode());
	    	}
		}else{
			return false;
		}
		$end = round(microtime(true), 4);
		$total = round($end - $start, 4);
		system_log(array('function' =>  'setItem', 'event' => 'MEMCACHE' ,'proctime' => $total));
    
    	return true;
    }
    
    public function setItems(array & $normalizedKeyValuePairs, $expiry = null)
    {
    	$start = round(microtime(true), 4);
		if(MEMCACHE_ENABLE){
			$memc       = $this->getResource();
			$expiration = $this->expirationTime($expiry);
			$namespacedKeyValuePairs = array();
			$customKeys = array();			
	    	foreach ($normalizedKeyValuePairs as $normalizedKey => & $value) {
	    		$sanitizedNormalizedKey = $this->sanitizeKey($normalizedKey);
	    		$namespacedKeyValuePairs[ $this->namespacePrefix . $this->getNamespace() .  $sanitizedNormalizedKey ] = & $value;			
	    		$customKeys[$this->namespacePrefix . $this->getNamespace() .  $sanitizedNormalizedKey] = $value;
	    	}	    	
			if(!$memc->setMulti($customKeys, $expiration)){
				throw $this->getExceptionByResultCode($memc->getResultCode());
			}	    	
		}else{			
			return array();
		}
		$end = round(microtime(true), 4);
		$total = round($end - $start, 4);
		system_log(array('function' =>  'setItems', 'event' => 'MEMCACHE' ,'proctime' => $total));
    	return array();
    }
    
   
    public function addItem(& $normalizedKey, & $value)
    {
    	$normalizedKey = $this->sanitizeKey($normalizedKey);
    	$memc       = $this->getResource();
    	$expiration = $this->expirationTime();
    	if (!$memc->add($this->namespacePrefix . $this->getNamespace() . $normalizedKey, $value, $expiration)) {
    		$rsCode = $memc->getResultCode();
    		if ($rsCode == Memd::RES_NOTSTORED) {
    			return false;
    		}
    		throw $this->getExceptionByResultCode($rsCode);
    	}
    
    	return true;
    }
    
    public function replaceItem(& $normalizedKey, & $value)
    {
    	$normalizedKey = $this->sanitizeKey($normalizedKey);
    	$memc       = $this->getResource();
    	$expiration = $this->expirationTime();
    	if (!$memc->replace($this->namespacePrefix . $this->getNamespace() . $normalizedKey, $value, $expiration)) {
    		$rsCode = $memc->getResultCode();
    		if ($rsCode == Memd::RES_NOTSTORED) {
    			return false;
    		}
    		throw $this->getExceptionByResultCode($rsCode);
    	}
    
    	return true;
    }
    
    public function checkAndSetItem(& $token, & $normalizedKey, & $value)
    {
    	$normalizedKey = $this->sanitizeKey($normalizedKey);
    	$memc       = $this->getResource();
    	$expiration = $this->expirationTime();
    	$result     = $memc->cas($token, $this->namespacePrefix . $this->getNamespace() . $normalizedKey, $value, $expiration);
    
    	if ($result === false) {
    		$rsCode = $memc->getResultCode();
    		if ($rsCode !== 0 && $rsCode != Memd::RES_DATA_EXISTS) {
    			throw $this->getExceptionByResultCode($rsCode);
    		}
    	}
    
    
    	return $result;
    } 

    public function removeItem(& $normalizedKey)
    {
    	$normalizedKey = $this->sanitizeKey($normalizedKey);
    	$memc   = $this->getResource();
    	$result = $memc->delete($this->namespacePrefix . $this->getNamespace() .  $normalizedKey);
    
    	if ($result === false) {
    		$rsCode = $memc->getResultCode();
    		if ($rsCode == Memd::RES_NOTFOUND) {
    			return false;
    		} elseif ($rsCode != Memd::RES_SUCCESS) {
    			throw $this->getExceptionByResultCode($rsCode);
    		}
    	}
    
    	return true;
    }
    
    public function removeItems(array & $normalizedKeys)
    {
    	$memc = $this->getResource();
    
    	foreach ($normalizedKeys as & $normalizedKey) {
    		$normalizedKey = $this->sanitizeKey($normalizedKey);
    		$normalizedKey = $this->namespacePrefix . $normalizedKey;
    	}
    
    	$rsCodes = $memc->deleteMulti($normalizedKeys);
    
    	$missingKeys = array();
    	foreach ($rsCodes as $key => $rsCode) {
    		if ($rsCode !== true && $rsCode != Memd::RES_SUCCESS) {
    			if ($rsCode != Memd::RES_NOTFOUND) {
    				throw $this->getExceptionByResultCode($rsCode);
    			}
    			$missingKeys[] = $key;
    		}
    	}
    
    	// remove namespace prefix
    	if ($missingKeys && $this->namespacePrefix !== '') {
    		$nsPrefixLength = strlen($this->namespacePrefix.$this->getNamespace());
    		foreach ($missingKeys as & $missingKey) {
    			$missingKey = substr($missingKey, $nsPrefixLength);
    		}
    	}
    
    	return $missingKeys;
    }
    
    public function incrementItem(& $normalizedKey, & $value)
    {
    	$memc        = $this->getResource();
    	$internalKey = $this->namespacePrefix . $this->getNamespace() . $this->sanitizeKey($normalizedKey);
    	$value       = (int) $value;
    	$newValue    = $memc->increment($internalKey, $value);
    
    	if ($newValue === false) {
    		$rsCode = $memc->getResultCode();
    
    		// initial value
    		if ($rsCode == Memd::RES_NOTFOUND) {
    			$newValue = $value;
    			$memc->add($internalKey, $newValue, $this->expirationTime());
    			$rsCode = $memc->getResultCode();
    		}
    
    		if ($rsCode) {
    			throw $this->getExceptionByResultCode($rsCode);
    		}
    	}
    
    	return $newValue;
    }
    
    public function decrementItem(& $normalizedKey, & $value)
    {
    	$memc        = $this->getResource();
    	$internalKey = $this->namespacePrefix . $this->getNamespace() . $this->sanitizeKey($normalizedKey);
    	$value       = (int) $value;
    	$newValue    = $memc->decrement($internalKey, $value);
    
    	if ($newValue === false) {
    		$rsCode = $memc->getResultCode();
    
    		// initial value
    		if ($rsCode == Memd::RES_NOTFOUND) {
    			$newValue = -$value;
    			$memc->add($internalKey, $newValue, $this->expirationTime());
    			$rsCode = $memc->getResultCode();
    		}
    
    		if ($rsCode) {
    			throw $this->getExceptionByResultCode($rsCode);
    		}
    	}
    
    	return $newValue;
    }
    
    
    private function expirationTime($expiry)
    {
    	$expiry = (int)$expiry;
    	$ttl = $this->getOptions('ttl');
    	if(empty($expiry)) {
    		$ttl = time() + 604800;
    	} else {
    		$ttl = time() + $expiry;
    	}
    	return $ttl;
    }
    
    private function getExceptionByResultCode($code)
    {
    	switch ($code) {
    		case Memd::RES_SUCCESS:
    			throw new \Exception("The result code '{$code}' (SUCCESS) isn't an error");
    		default:
    			return new \Exception($this->getResource()->getResultMessage());
    	}
    }
    
    public function flush()
    {
    	// log this
    	$memc = $this->getResource();
    	if (!$memc->flush()) {
    		throw $this->getExceptionByResultCode($memc->getResultCode());
    	}
    	return true;
    }
    
    private function sanitizeKey(& $normalizedKey) {
    	return str_replace(" ", "_", $normalizedKey);
    } 
    
    public function close(){
    	//$this->_memcache->quit();
    }
    
    public function __destruct(){
    	//$this->_memcache->quit();
    }
    
    public function setExpiration($lifetime) {
    	$this->_options['ttl'] = $lifetime;
    }
    
}

