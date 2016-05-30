<?php
ini_set("display_errors", "On");

$con=  mysql_connect("localhost","root","") or die(mysql_error());
mysql_select_db("test") or die(mysql_error());
$results=  mysql_query("select * from ts_faqs limit 5") or die(mysql_error());
$faqs=array();

/*Indexing mysql data to solr search*/
/*
 * Step 1) Download & install 
 * Step 2) in terminal set PWD to downloaded location
 * Step 3) start solr service using command  "bin/solr start" or restart using command "bin/solr restart"
 * Step 4) create instance in solr e.g. "faqs"
 * Step 5) To create instance copy a folder from solr-x.x.x/server/solr/configsets/basic_configs to solr-x.x.x/server/solr/ location 
 *         & rename it to instance name (e.g. "faqs").
 * Step 6) Add Fields in solr-x.x.x/server/solr/faqs/conf/schema.xml file which you need to search
 * Step 7) Now using following lines of code you can index mysql table rows to solr search
 *   */

$str='<add>';
while($faq=  mysql_fetch_assoc($results))
{
    $status=$faq['status']=='Y'?"1":"0";
    $android=$faq['android']=='Y'?'1':'0';
    $desktop=$faq['desktop']=='Y'?'1':'0';
    $wap=$faq['wap']=='Y'?'1':'0';
    $ios=$faq['ios']=='Y'?'1':'0';
    
    
    $str.='<doc>';
    $str.='<field name="id">'.$faq['id'].'</field>';
    $str.='<field name="question">'.addslashes($faq['question']).'</field>';
    $str.='<field name="answer">'.addslashes(htmlentities($faq['answer'])).'</field>';
    $str.='<field name="status">'.$status.'</field>';
    $str.='<field name="android">'.$android.'</field>';
    $str.='<field name="desktop">'.$desktop.'</field>';
    $str.='<field name="wap">'.$wap.'</field>';
    $str.='<field name="ios">'.$ios.'</field>';
    $str.='</doc>'; 
    
}
$str.='</add>';

echo "curl http://localhost:8983/solr/faqs/update?commit=true -H 'Content-Type: text/xml' --data-binary '".$str."'"; die;

echo exec("curl http://localhost:8983/solr/faqs/update?commit=true -H 'Content-Type: text/xml' --data-binary '".$str."'");