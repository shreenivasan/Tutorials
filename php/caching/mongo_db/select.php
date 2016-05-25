<?php
 // connect to mongodb
   $m = new MongoClient();
   echo "Connection to database successfully<br>";
	
   // select a database
   $db = $m->test;
   echo "Database mydb selected<br>";
   $collection = $db->mycol;
   echo "Collection selected succsessfully<br>";

   $cursor = $collection->find();
   // iterate cursor to display title of documents
	
    foreach ($cursor as $document) 
    {
        echo $document["title"] . "<br>";
    }