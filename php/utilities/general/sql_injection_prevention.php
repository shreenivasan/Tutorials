<?php
function clean($input) 
{
    $output = (string) $input;
    // if magic quotes is on then use strip slashes
    if (get_magic_quotes_gpc()) 
    {
        $output = stripslashes($output);
    }
    $output = htmlentities($output, ENT_QUOTES, 'UTF-8');    
    return $output;
}

$text = "\' \" <script>alert(1)</script>";
echo $text = clean($text);