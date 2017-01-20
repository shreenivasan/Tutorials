<?php
session_start();
$postdata = json_encode(array("session_id"=>session_id(),"ip_address"=>$_SERVER['REMOTE_ADDR']));
$port    = 7777;

//$host_array=array('192.168.12.240','192.168.12.242','192.168.12.241');
$host_array=array('10.0.1.4');

foreach ($host_array as $key=>$host)
{
    echo $host."<br>";
    $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    
    if(!$sock)
    {
        continue;
    }
    
    $result = socket_connect($sock, $host, $port);  
    
    if(!$result)
    {
        continue;
    }
    
    socket_write($sock, $postdata);
    $result = socket_read ($sock, 1024);
    
    $result=  json_decode($result,true);

    if(in_array($result['message'], array('success','failed')))
    {
        break;
    }
}

print_r($result); die;