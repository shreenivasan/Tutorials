<?php

ini_set("display_errors", "on");
    
    function send_mail($to)
    {
        
        try
        {
            
        $email_subject='s';
        $email_body='s';
        require("class.phpmailer.php");
        $mailer = new PHPMailer();
        $mailer->SetLanguage("en", 'includes/phpMailer/language/');
        
        $mailer->IsSMTP();
        $mailer->Host = 'ssl://smtp.gmail.com:587';
        $mailer->SMTPAuth = TRUE;
        $mailer->Username = 'dummyd947@gmail.com'; // Change this to your gmail adress
        $mailer->Password = 'dummyd947@gmail'; // Change this to your gmail password
        $mailer->From = 'Dummy ';
        $mailer->FromName = 'Sandip foundation'; // This is the from name in the email, you can put anything you like here
        $mailer->Body = $email_body;
        $mailer->Subject =$email_subject;    
        $mailer->AddAddress($to);  // This is where you put the email adress of the person you want to mail
        
        $mailer->Send();
        echo 'mail sent';
        }
        catch (phpmailerException $e)
        {
            echo $e->errorMessage(); 
        }
        catch (Exception $e) 
        {
          echo $e->getMessage(); 
        }
    }
    
send_mail("shreenivas.madagundi@gmail.com");