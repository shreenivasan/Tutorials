<?php

// connect to mongodb
   $m = new MongoClient();
   echo "Connection to database successfully";
	
   // select a database
   $db = $m->test;
   echo "Database mydb selected";
   $collection = $db->mycol;
   echo "Collection selected succsessfully";
   
   // now remove the document
   $collection->remove(array("title"=>"MongoDB Tutorial 1"),false);
   echo "Documents deleted successfully";
   
   // now display the available documents
   $cursor = $collection->find();
	
   // iterate cursor to display title of documents
   echo "Updated document";
	
   foreach ($cursor as $document) {
      echo $document["title"] . "\n";
   }

