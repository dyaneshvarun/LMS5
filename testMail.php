<?php
require('phpmailer/mailsend1.php');
$mail = new PHPMailer(false);
//$email = $_POST['toEmail'];
$email = "hod@auist.net";
$name = $_POST['toName'];
$subject = $_POST['subject'];
//$toList[$email]=$name;
$content = $_POST['content'];
sendLeaveMail($mail,$email,$name,$content,$subject);
?>