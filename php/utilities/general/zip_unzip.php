<?php

function create_zip($files = array(),$destination = '',$overwrite = false) {  
    //if the zip file already exists and overwrite is false, return false  
    if(file_exists($destination) && !$overwrite) { return false; }  
    //vars  
    $valid_files = array();  
    //if files were passed in...  
    if(is_array($files)) {  
        //cycle through each file  
        foreach($files as $file) {  
            //make sure the file exists  
            if(file_exists($file)) {  
                $valid_files[] = $file;  
            }  
        }  
    }  
    //if we have good files...  
    if(count($valid_files)) {  
        //create the archive  
        $zip = new ZipArchive();  
        if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {  
            return false;  
        }  
        //add the files  
        foreach($valid_files as $file) {  
            $zip->addFile($file,$file);  
        }  
        //debug  
        //echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;  
          
        //close the zip -- done!  
        $zip->close();  
          
        //check to make sure the file exists  
        return file_exists($destination);  
    }  
    else  
    {  
        return false;  
    }  
}
function unzip($location,$newLocation)
{
        if(exec("unzip $location",$arr)){
            mkdir($newLocation);
            for($i = 1;$i< count($arr);$i++){
                $file = trim(preg_replace("~inflating: ~","",$arr[$i]));
                copy($location.'/'.$file,$newLocation.'/'.$file);
                unlink($location.'/'.$file);
            }
            return TRUE;
        }else{
            return FALSE;
        }
}

$files=array('memory.php', 'compression.php');  
create_zip($files, 'test.zip', true); 


unzip('test.zip',''); //File would be unzipped in unziped/test folder