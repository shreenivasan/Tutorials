<?php
ini_set("display_errors", "On");
$con=  mysql_connect("192.168.0.43","eadmin","e@dm!n@123") or die(mysql_error());
mysql_select_db("trendsutra3") or die(mysql_error());
$results=  mysql_query("select * from ts_faqs") or die(mysql_error());
$faqs=array();
$i=0;
while($faq=  mysql_fetch_assoc($results))
{
    $faqs[$i]['id']=$faq['id'];
    $faqs[$i]['question']=$faq['question'];
    $faqs[$i]['answer']=$faq['answer'];
    $faqs[$i]['status']=$faq['status']=='Y'?1:0;
    $faqs[$i]['android']=$faq['android']=='Y'?1:0;
    $faqs[$i]['desktop']=$faq['desktop']=='Y'?1:0;
    $faqs[$i]['wap']=$faq['wap']=='Y'?1:0;
    $faqs[$i]['ios']=$faq['ios']=='Y'?1:0;
    //$faqs=$faq;
    $i++;
}
echo '<pre>';
print_r($faqs);
die;