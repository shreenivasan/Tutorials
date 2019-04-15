<?php
ini_set("display_errors", 1);

$csv_file = "bf.csv";

$handle= fopen($csv_file,"r");
        $data= array();
        $line=0;
        while (($row = fgetcsv( $handle, 0, ",")) !== FALSE) {
                if($line==0){
                        $data["header"] = $row;
                } else {
                        $tmp = array();
                        foreach($data["header"] as $col => $heading) {
                                $tmp[$heading] = $row[$col];
                        }
                        $data["data"][] = $tmp;
                        unset($tmp);
                }
                $line++;
        }
        fclose($handle);

        echo "<pre>";
        //print_r($data); die;
        
        //die;
        

$servername = "localhost";
$username = "db";
$password = "";
$dbname = "all_inventory";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$table_name = 'products';
#$col_names = "".implode(",", $data["header"])."";

$header_cols = ['category','style','ean_code','description','mc_code','color','size','mrp','artical_no'];
$col_names = "".implode(",", $header_cols )."";

#echo $col_names; die;

$sql = "INSERT INTO $table_name ($col_names)
VALUES ";
$sql_temp = "";
foreach($data['data'] as $csv){
    $sql_temp.="<br>";
    
    $mrp = $csv['mrp']!='#N/A'  ? (int)$csv['mrp'] : 0;
    
    $sql_temp.="('".trim($csv['category'])."','".trim($csv['style'])."','".trim($csv['ean_code'])."','".trim($csv['description'])."','".trim($csv['mc_code'])."','".trim($csv['color'])."','".trim($csv['size'])."','".($mrp)."','".trim($csv['artical_no'])."'),";
}

$sql_temp = rtrim($sql_temp, ",");
echo $sql.$sql_temp; die;


if ($conn->multi_query($sql) === TRUE) {
    echo "New records created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
