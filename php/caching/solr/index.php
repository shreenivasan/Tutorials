<?php
ini_set("display_errors", "on");
include_once './includes/config.php';
include_once './libs/solrIndexer.php';

$solr=new SolrIndexer();

//$solr->deleteDocument(array(2,16));

$solr->addDocument($doc = array("test"));



function pr($data)
{
    //echo "<br> FILE NAME ".__FILE__." , Line no ".__LINE__."<br>";
    if(is_array($data))
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }
    else if(is_string($data))
    {
       echo "<pre>";
       echo $data;
       echo "</pre>";
    }
    else if(is_array($data) && is_string(json_encode($data)))
    {
       echo "<pre>";
       print_r(json_decode($data,true));
       echo "</pre>";
    }elseif(is_object($data)){
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
    }
}


