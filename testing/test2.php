<?php
include('class1.php');
include('class2.php');
$objA1 = new \A1\A();
echo $objA1->test();

$objA2 = new A2\A();
echo $objA2->test();
?>
