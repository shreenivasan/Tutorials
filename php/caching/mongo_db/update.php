<?php
    // connect to mongodb
   $m = new MongoClient();
   echo "Connection to database successfully";
	
   // select a database
   $db = $m->test;
   echo "Database mydb selected<br>";
   $collection = $db->mycol;
   echo "Collection selected succsessfully<br>";

   // now update the document
   $collection->update(array("title"=>"MongoDB"), 
      array('$set'=>array("title"=>"MongoDB Tutorial 1")));
   echo "Document updated successfully<br>";
	
   // now display the updated document
   $cursor = $collection->find();
	
   // iterate cursor to display title of documents
   echo "Updated document<br>";
	
   foreach ($cursor as $document) {
      echo $document["title"] . "<br>";
   }
