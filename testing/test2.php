<?php
session_set_cookie_params(0);
session_start();
if(isset($_COOKIE['mycookie'])){
    echo $_COOKIE['mycookie']."<<<<<<<<<";
}
else{
    echo "cookie not exists";
}
setcookie("mycookie","mycookie",0);
//setcookie("mycookie",NULL);

//session_destory();
?>
