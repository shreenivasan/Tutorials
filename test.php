<?php

ini_set("display_errors",1);

$path = "./";
$data=[];

$i=0;
if ($handle = opendir($path)) {
    while (false !== ($file = readdir($handle))) {
        if ( ('.' === $file || '..' === $file) ){ continue; }
        elseif(is_file($file) && pathinfo($file, PATHINFO_EXTENSION)=='ppt'){
        	$file_data = file_get_contents($file);

			$file_data = preg_replace("/[^a-zA-Z0-9 ]/", "", $file_data);

#echo stripos($file_data, "calibri "); die;
#echo strpos($file_data, 'Odb6D'); die;
$start = (strpos($file_data,'Title 1dT')+9);
$end = strpos($file_data, 'CGgn');
$dname = substr($file_data, $start, ($end - $start) );
$emp_name = substr($dname, 0,strpos($dname, '   '));
$designation = substr($dname,(strpos($dname, '   ')+3 ));

		$emp_code = (int)substr($file_data,(stripos($file_data, "emp code ")+9), 10);
		$data[$i]['emp_code'] = $emp_code;
		$data[$i]['emp_name'] = $emp_name;
		$data[$i]['designation'] = $designation;
		$i++;
        }
        // do something with the file
    }
    closedir($handle);
}

echo "<pre>";
print_r($data);


$file_name = 'data.csv';
        
        $fp = fopen($file_name,'w')  or die("Unable to open file!");
        
        $csv_headers = ['Emp Code',"Emp Name","Designation"]; 

        fputcsv($fp, $csv_headers);
        foreach ($data as $rows) {				
                fputcsv($fp, $rows);
        }
        fclose($fp);
        return $file_name;