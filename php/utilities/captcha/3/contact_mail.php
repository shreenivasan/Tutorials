<?php
session_start();
if($_POST["captcha"]==$_SESSION["captcha_code"]){
	$toEmail = "admin@phppot_samples.com";
	$mailHeaders = "From: " . $_POST["userName"] . "<". $_POST["userEmail"] .">\r\n";
	if(mail($toEmail, $_POST["subject"], $_POST["content"], $mailHeaders)) {
	print "<p class='success'>Contact Mail Sent.</p>";
	} else {
	print "<p class='Error'>Problem in Sending Mail.</p>";
	}
} else {
print "<p class='Error'>Enter Correct Captcha Code.</p>";
}
?>