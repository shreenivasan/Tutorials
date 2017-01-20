<?php
//echo $url="http://".$_SERVER['SERVER_NAME']."/testing.php";die;
 $url="https://trend3.pepperfry.com/testing.php";
            $postdata = json_encode(array("session_id"=>session_id(),"ip_address"=>$_SERVER['REMOTE_ADDR']));
	    $ch = curl_init(); // initialize the curl
	    curl_setopt($ch, CURLOPT_URL,$url); // set the url
	    curl_setopt($ch,CURLOPT_POSTFIELDS, $postdata);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    $result = curl_exec($ch); //execute the request
            echo curl_error($ch);
	    $close=curl_close($ch); // close curl connection
           // sleep(3);
            echo $result; die;
            