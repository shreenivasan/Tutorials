<?php

	$path = "./ppts";

	$files = scandir($path);

	array_shift($files);
	array_shift($files);


	$data = [];

	foreach( $files as $k=>$f ){

		$file_path = $path."/".$f;

		$file_data = file_get_contents($file_path);

        	$file_data = preg_replace("/[^a-zA-Z0-9dd ]/", "", $file_data);

		$emp_code = (int)substr($file_data,(stripos($file_data, "emp code ")+9), 10);
        	$dname = substr($file_data, (strripos($file_data, "DNAME ")+5) ,(strrpos($file_data, "calibri ") - (strripos($file_data, "DNAME ")+5)));

		$data[$k]['emp_code'] = $emp_code;
		$data[$k]['emp_name'] = $dname;
	}	

	$fp = fopen("./ppts/csv_files/file-".date('YmdHis').".csv", 'w');
	fputcsv($fp, array_keys($data[0]));
   	foreach ($data as $rows) {				
		fputcsv($fp, $rows);
	}		
 	fclose($fp);		

print_r($data);
