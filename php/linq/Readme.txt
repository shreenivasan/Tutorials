LINQ is Language integrated query is feature by which we find elements of array by custom query like sql

e.g.
    // sample array
    $myArray=array(
        'animals'=>array('cat'=>'Miyavv','dog'=>'Hav hav','snake'=>'sSSSssSssss','bird'=>'Cik Cik Cik'),
        'a big animal'=>'dinosaur',
        'its smaller then 100'=>90
       );

       // find array elements which contains value like "cik cik"
        $a->Query("SELECT key  Animal Name,value As Sound  FROM myArray.animals WHERE value LIKE '%cik cik%' ");
                 echo '<b class=uyari>Found '.$a->num_rows().' Animal(s)</b><br>'; 
                while ($cikCikAnimals=$a->fetch_object()){
                     print_r($cikCikAnimals);
                }
