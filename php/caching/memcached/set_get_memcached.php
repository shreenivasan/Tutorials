<?php
$mem = new Memcached();
$mem->addServer("127.0.0.1", 11211);

/*Function to set into memcached
 * Params : param 1 = key to set, param 2 = value to be set , param3 = memcached class instance
 * Return type : 1 if set otherwise 0
 */
function set_key($key='',$value='',&$mem)
{
    return $mem->set($key, $value, 10)?1:0;
}

/*Function to get from memcached
 * Params : param 1 = key to get,param 2 = memcached class instance
 * Return type : Returns value if exists otherwise 0
 */
function get_key($key='',&$mem)
{
    return $mem->get($key)?$mem->get($key):0;
}

$key='test_key';
$value='test_value';

/* set into memcached */
if(set_key($key,$value,$mem))
{
    echo ' Value '.$value.' is set into memcached as key '.$key;
}
else 
{
    echo '<br>Unable to set data';
}

echo '<br>';
/* get from memcached */
echo get_key($key,$mem);