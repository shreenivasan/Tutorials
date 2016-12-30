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

echo '-----------------<br>';
echo 'Descending Order'.'<br>';
echo '-----------------<br>'; 

$a->Query('SELECT key,value FROM myArray.animals ORDER BY key DESC');
echo '<b class=uyari>Found '.$a->num_rows().' Animal(s)</b><br>'; 
while ($Animals=$a->fetch_assoc())
{
    print_r($Animals);
}
echo '-----------------<br>'; 

echo 'Ascending Order'.'<br>';
echo '-----------------<br>'; 
$a->Query('SELECT key,value FROM myArray.animals ORDER BY value ASC');
echo '<b class=uyari>Found '.$a->num_rows().' Animal(s)</b><br>'; 
while ($Animals=$a->fetch_assoc())
{
    print_r($Animals);
}