<?php
ini_set("display_errors","On");
echo '<pre>';
$myArray=array(
                'animals' =>array('cat'=>'Miyavv','dog'=>'Hav hav','snake'=>'sSSSssSssss','bird'=>'Cik Cik Cik'),
                'a big animal'=>'dinosaur',
                'its smaller then 100'=>90                
            );
echo '-----------------<br>';
echo 'Original'.'<br>';
echo '-----------------<br>'; 
print_r($myArray);
echo '<br>';       
include_once 'lib/D3Linq.php';
$a=new D3Linq();

$a->Query("DELETE FROM myArray.animals WHERE value LIKE '%cik cik%'");
print_r($myArray);
