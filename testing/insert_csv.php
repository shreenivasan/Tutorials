<?php

ini_set("display_errors", 1);

$csv_file = "stores_final.csv";

$handle = fopen($csv_file, "r");
$data = array();
$line = 0;
while (($row = fgetcsv($handle, 0, ",")) !== FALSE) {
    if ($line == 0) {
        $data["header"] = $row;
    } else {
        $tmp = array();
        foreach ($data["header"] as $col => $heading) {
            $tmp[$heading] = $row[$col];
        }
        $data["data"][] = $tmp;
        unset($tmp);
    }
    $line++;
}
fclose($handle);

#echo "<pre>";print_r($data); die;

$column_names = "";

foreach ($data['header'] as $v) {
    $column_names.=$v . ",";
}

$column_names = rtrim($column_names, ",");

$servername = "localhost";
$username = "db";
$password = "";
$dbname = "test";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO products ($column_names)
VALUES ";
$sql_temp = "";
foreach ($data['data'] as $csv) {
    $sql_temp.="<br>";
    $sql_temp.="(";
    foreach($data['header'] as $v){
         $sql_temp.="'".$csv[$v]."',";
    }
    $sql_temp = rtrim($sql_temp, ",");
    $sql_temp.="),";
}

$sql_temp = rtrim($sql_temp, ",");
echo $sql . $sql_temp;
die;