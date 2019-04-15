<?php

ini_set("display_errors",1);

$file_data = file_get_contents("./emp.ppt");

$file_data = preg_replace("/[^a-zA-Z0-9dd ]/", "", $file_data);

#echo stripos($file_data, "calibri "); die;
#echo strpos($file_data, 'Odb6D'); die;

echo $emp_code = (int)substr($file_data,(stripos($file_data, "emp code ")+9), 10);  
echo "<br>";
echo $dname = substr($file_data, (strripos($file_data, "DNAME ")+5) ,(strrpos($file_data, "calibri ") - (strripos($file_data, "DNAME ")+5)));


die;
$old_version = 'composer.json';
$new_version = 'composer.lock';

xdiff_file_diff($old_version, $new_version, 'my_script.diff', 2);

////$a = [ [1,2,11] , [4,5,6] , [8,9,10]];
//$a = [ [1,2, 4, 4] , 
//       [1,4, 5, 6] , 
//       [8,9,10,11],
//       [1,3,10,11]
//    ];
//$n = 4;//nxn matrix
//$d = $s = 0; //initialize both diagonal sum to 0
//
//for ($i = 0; $i < $n; $i++) {
//        $d += $a[$i][$i];
//        $s += $a[$i][$n - $i - 1]; 
//    }
//
//var_dump($d);//primary diagonal total
//var_dump($s);//secondary diagonal total
//
//echo '---------------------------------------------------';
//echo '<br><br>';
//$a = [1,2,2,4,5,6,5,4];
////Output => 01011000
//$str = '';
//
//foreach ($a as $k=> $v){
//    
//    if(in_array($v ,array_slice($a , ($k+1), count($a)-1 ) )){
//        $str .='1';
//    }else{
//        $str .='0';
//    }
//}
//
//echo $str;

#echo '---------------------------------------------------';

//$filePath1 = 'composer.json';
//$filePath2 = 'composer.lock';
//$filePath3 = 'composer.json';
////echo $toolPath . ' '.$filePath1.' '.$filePath2; die;
//shell_exec( 'meld' . ' '.$filePath1.' '.$filePath2.' '.$filePath3 );

//=================================
ini_set("display_errors",true);
$im = imagecreatetruecolor(55, 30);
$white = imagecolorallocate($im, 255, 255, 255);


