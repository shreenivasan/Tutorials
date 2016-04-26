<?php
    $m = new MongoClient();
    echo "Connection to database successfully";
	
   // select a database
   $db = $m->test;
   echo "Database test selected";
   $collection = $db->createCollection("mycol");
   echo "Collection created succsessfully";

