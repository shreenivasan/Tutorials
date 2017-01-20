<?php
ini_set("display_errors", "on");
include_once 'solr_lib.php';
$hostname='127.0.0.1';
$core_name='fe_faqs';
$port_no='8983';
$solr=new SolrIndexer($hostname,$port_no,$core_name,'fe_faqs');
echo '<pre>';
print_r($solr); die;

