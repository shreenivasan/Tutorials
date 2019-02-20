<?php

$fileName = "/var/www/html/app.log";

$i = 1;
$data = [];

if ($file = fopen($fileName, "r")) {
    while(!feof($file)) {
        $line = fgets($file);       
        
        $last_occur_tmp = strpos($line,"'",40);
        $api = substr($line, 41,$last_occur_tmp- 41);
        
        if( $api == 'add_property'){
            #$data[] = $line;
            
            $date = substr($line, 1,19);
            $json_pos = strpos($line, ",",$last_occur_tmp+2);
            $json_post_last = strripos($line, ']}');           
            $str_len = ($json_pos+3); 
            $json =  substr($line, $str_len, (($json_post_last+2)-$str_len) );
            
            #echo $json; die;
            
            $json = json_decode($json, true);
            if( ! empty( $json ) && !empty($json['Output']['response_code']) && $json['Output']['response_code'] == '200' ){
                $data[] = ["added_on"=>$date,"property_code"=> $json['Output']['data']['property_code'], "platform"=>$json['header']['HTTP_USER_AGENT'][0] ]; 
            }
            //echo "<pre>\n\n";
            
        }
        
    }
    fclose($file);
}

$servername = "localhost";
$username = "db";
$password = "";
$dbname = "easyday_realestate";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

foreach( $data as $row ){
    $sql = "UPDATE property_details SET platform_str = '".$row['platform']."',created_on = '".$row['added_on']."'  WHERE property_code = '".$row['property_code']."'";
    
    echo $sql."\n";
    
}

die;

if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>