<?php
 //$posts = ["q"=>"*:*","user"=>"shreenivas"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,'http://localhost:9200/blog/post/_search');
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-type: text/plain',
    'Content-length: 100'
));

  curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($posts));
  $response = curl_exec($ch);
  $result = json_decode($response);
  
  echo '<pre>';
  print_r($result);
  
$new=   $result->status;
curl_close ($ch);
  