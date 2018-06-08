<?php 
$str = '00:00:00';
echo date('H i s A', strtotime(date('Y-m-d '.$str)));