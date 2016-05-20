<?php
// get all php files within current directory where current file exists
$files = glob('../*.php');
echo '<pre>'; 
print_r($files);

//========================================================
// get all php files AND txt files
$files = glob('*.{php,txt}', GLOB_BRACE); 
print_r($files);
//========================================================


//========================================================
$files = glob('../images/a*.jpg'); 
print_r($files);
//========================================================

//========================================================
//If you want to get the full path to each file, you can just call the realpath() function on the returned values:
$files = glob('i*.php');
$files = array_map('realpath',$files); 
print_r($files);

/* output looks like:
Array
(
    [0] => C:\wamp\www\images\apple.jpg
    [1] => C:\wamp\www\images\art.jpg
)
*/
//========================================================


