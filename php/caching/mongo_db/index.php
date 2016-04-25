<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>C MongoDB Insert</title>
    </head>
    <body>
<?php
echo '<pre>';
// Connect to the MongoD with defaults which are localhost and port 27017)  
$m = new MongoClient();
echo '<br />Connection var dump below <br />';
var_dump($m);
// Use a DataBase (will be created if it doesn't exist)
echo '<br />database var dump below <br />';
$db = $m->demodb;
var_dump($db);
// Use a Collection (will be created if it doesn't exist)
$coll = $db->democoll;
echo '<br />Collection var dump below <br />';
var_dump($coll);
$coll->insert(array(
    'key1' => 'Another Row',
    'AnArray' => array(
        'embedded array value 1', 
        'embedded array value 2'
    ),
    'embeddedDoc1' => array(
        'embedDoc1Key1' => 'Embedded text in Doc1',
        'embedDoc1Key2' => 'More text for fun'
    )
    ));
    echo '<h2 style="color:red">Below is our Document</h2>';
$myDoc = $coll->findOne(array('key1' => 'Another Row'));
print_r($myDoc);
echo '</pre>';
?>
    </body>
</html>