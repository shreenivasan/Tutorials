<?php
include_once './Apache/Solr/Service.php';
class SolrIndexer 
{
    protected $_solr;
    protected $_host;
    protected $_core;
    public    $ping = 1;
    private $_collection;
    public function __construct($host,$port,$collection,$core_name)
    {
        $this->_solr = new \Apache_Solr_Service($host, '8983',$core_name,$collection);
      
        $this->_host='127.0.0.1';
        $this->_core=$core_name;
        $this->_collection = $collection;
        if(!$this->_solr->ping())
        {
            $this->ping =0;
            for($p=0;$p<3;$p++)
            {
                usleep(5);
                if($this->_solr->ping())
                {
                    $this->ping =1;
                    break;
                }
            }
        }
          echo '<pre>';print_r($this->ping ); die;
        if($this->ping ==0)
        {
            echo 'no ping';
        }
    }
    
    public function addDocument($doc)
	{
		$start = round(microtime(true), 4);		
		if(!is_array($doc))
		{
			//throw new exception('Document must be in array format');
			show_error('Solr Error', 'Document must be in array format');
			return 0;
		}

		$document = new \Apache_Solr_Document();

		foreach($doc as $k=>$v)
		{
			$document->$k=$v;
		}
		//pr($document); die('solr');
		try
		{
  			$response=$this->_solr->addDocument($document);
			if($response->responseHeader->status==0)
			{
				//$commit=$this->_solr->commit();							//commit to see the deletes and the document
				//$optimize=$this->_solr->optimize();							//merges multiple segments into one
				//if($commit->responseHeader->status==0)
				if(true){
					$end = round(microtime(true), 4);
					$total = round($end - $start, 4);
					system_log(array('function' =>  'addDocument', 'event' => 'SOLR' ,'proctime' => $total));
					return 1;
				}else
					show_error('Solr Error', 'Document Committing Error');
			}
			else
			{
				show_error('Solr Error', 'Document Indexing Error');
			}
		}
		catch(\Exception $e)
		{
			show_error('Solr Error', $e->getTrace());
			return 0;
		}
	}
    
}