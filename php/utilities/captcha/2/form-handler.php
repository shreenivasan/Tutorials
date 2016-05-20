<?php
if(isset($_POST)) 
    { 
        session_start(); 
        if($_POST['captcha'] != $_SESSION['digit']) 
        {
            echo "N";
        }
        else
        {
            echo "Y";
        }
        //session_destroy();        
    }

