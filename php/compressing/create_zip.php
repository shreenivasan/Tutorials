<?php
ini_set("display_errors", "On");
error_reporting(E_ALL);

$dir= "./category"; 
echo "/usr/bin/zip -r shree.zip $dir"; 
shell_exec("/usr/bin/zip -r shree.zip $dir") or die("eeorr");

//if(file_exists($fileName)){
//    echo "found ==>".$fileName;
//}
//else{
//    echo " no file ===> ".$fileName;
//}

$zip_name = time().".zip";
$zip = new \ZipArchive();
$res= $zip->open($zip_name, \ZipArchive::CREATE);

//"fileName b4 ===> ".$fileName." , after ===>".str_replace(dirname(__FILE__)."/", "", $fileName);

$res2=$zip->addFile($fileName,  str_replace(dirname(__FILE__)."/", "", $fileName));
$zip->close();

die;

$directory = new \RecursiveDirectoryIterator($dir);
$iterator = new \RecursiveIteratorIterator($directory);
$files = array();
foreach ($iterator as $info) {
    $file_path = $info->getPathname();
  if ($file_path=="category/.." || $file_path=="category/." || $file_path=="category/all_categories_info/." || $file_path=="category/all_categories_info/.." ) {
      continue;
  }
  else
  {
      $files[] = $file_path;
  }
}


// Checking files are selected

foreach($files as $file)
{
    if(!file_exists("./".$file)){
        echo $file."<br>";
    }
    
$zip->addFile($file); // Adding files into zip
}
$zip->close();

echo $zip_name; die;

if(file_exists($zip_name))
{
// push to download the zip
header('Content-type: application/zip');
header('Content-Disposition: attachment; filename="'.$zip_name.'"');
readfile($zip_name);
// remove zip file is exists in temp path
unlink($zip_name);
}



?>