<?php
ini_set("display_errors", "On");
echo $_SERVER['HTTP_REFERER']; die;
static $static=1;

echo $static;


$static++;
die;

//reverse only alphabhates in a given string

$a='@a$f';
$b=array();

foreach (str_split($a) as $key=>$value)
{
    if(ctype_alpha($value))
    {
        $a_temp[]=$value;
    }
}

$a_temp=  array_reverse($a_temp);
$i=0;

foreach (str_split($a) as $key=>$value)
{
    if(ctype_alpha($value))
    {
        $b[]=$a_temp[$i];
        $i++;
    }
    else
    {
        $b[]=$value;
    }    
}
echo $a;
echo '<br>';
echo (implode("", $b));