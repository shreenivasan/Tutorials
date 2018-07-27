<?php
ini_set("display_errors","1");
require("./Db.class.php");

$persons = $db->query("SELECT * FROM customers");
//pr($persons);

// 1. Bind more parameters
$db->bind("name","Shreenivas");
$persons   =  $db->query("SELECT * FROM customers WHERE name = :name");

//pr($persons);


// 2. Bind more parameters
$db->bindMore(array("name"=>"Shreenivas","id"=>"1"));
$person   =  $db->query("SELECT * FROM customers WHERE name = :name AND id = :id");
//pr($person);


// 3. Or just give the parameters to the method
$person   =  $db->query("SELECT * FROM customers WHERE name = :name AND id = :id ",array("name"=>"Shreenivas","id"=>"1"));
pr($person);

function pr($data)
{
    echo "<pre>";
    if(is_array($data))
    {
        print_r($data);
    }
    else if(is_string($data))
    {
       echo $data.'<br>';
       
    }
    else if(isJson($data))
    {
        print_r(json_decode($data,true));
    }else{
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    }
    
    echo "</pre>";
}

function prx($data)
{
    echo "<pre>";
    if(is_array($data))
    {
        print_r($data);
    }
    else if(is_string($data))
    {
       echo $data.'<br>';
       
    }
    else if(isJson($data))
    {
        print_r(json_decode($data,true));
    }else{
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    }
    
    echo "</pre>"; die;
}

?>
