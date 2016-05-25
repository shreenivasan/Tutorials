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

$a->Query("SELECT key ,value  FROM myArray.animals WHERE value LIKE '%ci%' ");
echo '<b class=uyari>Found '.$a->num_rows().' Animal(s)</b><br>'; 
while ($cikCikAnimals=$a->fetch_object())
{
     print_r($cikCikAnimals);
}
