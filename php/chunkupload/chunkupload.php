<?php
session_start();
ini_set("display_errors", "On");

if(isset($_REQUEST['action']) && $_REQUEST['action']!="" && $_REQUEST['action']=="upload")
{
    $currentId=$_REQUEST['cid'];
    $fileName = isset($_REQUEST['fname']) ?$_REQUEST['fname'] : "";        
    $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
    $totalRequest = isset($_REQUEST['totalRequest']) ? $_REQUEST['totalRequest'] : "";
    $file_path_str="chunk_file_upload";

    $_SESSION[$file_path_str][$currentId] = "";
    $count = isset($_REQUEST['count']) ? $_REQUEST['count'] : "";
    $md5_file_name = md5($fileName).".".$fileType;

    $_SESSION[$file_path_str][$currentId] = 'uploaded/'.$md5_file_name;
    if($totalRequest >= $count) 
    {
        $file = file_get_contents('php://input');
        $fp   = fopen($_SESSION[$file_path_str][$currentId],"a");
        fwrite( $fp, base64_decode($file) );
        fclose($fp);
        if($fileName != "") 
        {
            echo 'uploaded/'.pathinfo($_SESSION[$file_path_str][$currentId], PATHINFO_BASENAME);
            exit;
        }            

    } 
    else 
    {
        if (!empty($_SESSION[$file_path_str])) 
            {
               @unlink($_SESSION[$file_path_str][$currentId]);
               $_SESSION[$file_path_str][$currentId] = "";
            }
        echo "image_size_exeeded";
        exit;
    }
}


if(isset($_REQUEST['action']) && $_REQUEST['action']!="" && $_REQUEST['action']=="deleteFile")
{
    $file_path=  (string)(isset($_POST['file_path'])?$_POST['file_path']:'');
    foreach ($_SESSION['chunk_file_upload'] as $key=>$value)
    {

        $val=end(split("/", $value));
        $file_path=end(split("/", $file_path));

        if($val==$file_path)
        {
            unset($_SESSION['chunk_file_upload'][$key]);
        }
    }
}