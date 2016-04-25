<?php
$m = new MongoClient();
$db = $m->demodb;
$coll = $db->democoll;
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

