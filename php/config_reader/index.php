<?php
ini_set("display_errors","1");
include_once 'ConfigReader.php';

$configobj = ConfigReader::getinstance();
$templateId = $configobj->getKey('social_login');
print_r($templateId);

