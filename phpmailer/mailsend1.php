<?php
  if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
if(!isset($_SESSION['STA_ID'])){
	header("Location:login.php");
}
$con = mysql_connect("localhost","istleaveadmin","lms@78");

require_once 'PHPMailerAutoload.php';
 function sendLeaveMail($mail,$toEmail,$toName,$content,$subject)
 {
$results_messages = array();
 

$mail->CharSet = 'utf-8';
ini_set('default_charset', 'UTF-8');
 
class phpmailerAppException extends phpmailerException {}
 
try {

$mail->isSMTP();
$mail->SMTPDebug  = 0;
$mail->Host       = "smtp.gmail.com";
$mail->Port       = "465";
$mail->SMTPSecure = "ssl";
$mail->SMTPAuth   = true;
$mail->Username   = "istleavesystem@gmail.com";
$mail->Password   = "istleavesystem";
$mail->addReplyTo("istleavesystem@gmail.com", "Leave Management System");
$mail->setFrom("noreply@istleavesystem.com", "Leave Management System");
//foreach($toList as $email => $name)
//{
	$to = $toEmail;
	if(!PHPMailer::validateAddress($to)) {
	  throw new phpmailerAppException("Email address " . $to . " is invalid -- aborting!");
	}
	$mail->addCC("dyaneshvarun@gmail.com","Testing App");
//}
//$mail->addAddress("dyaneshvarun123@gmail.com", "DV");
$mail->Subject  = $subject.$toEmail;
$body = $content;
$mail->WordWrap = 78;
$mail->msgHTML($body, dirname(__FILE__), true); //Create message bodies and embed images
//$mail->addStringAttachment($pdf->Output("S",'OrderDetails.pdf'),'Leave File Generated',$encoding = 'base64', $type = 'application/pdf');  // optional name
//$mail->addAttachment('images/phpmailer.png', 'phpmailer.png');  // optional name
 
try {
  $mail->send();
  $results_messages[] = "Message has been sent using SMTP";
  //$pdf->Output('CASUAL_LEAVE.pdf','I');
}
catch (phpmailerException $e) {
  throw new phpmailerAppException('Unable to send to: ' . $to. ': '.$e->getMessage());
}
}
catch (phpmailerAppException $e) {
  $results_messages[] = $e->errorMessage();
}
 
if (count($results_messages) > 0) {
  //echo "<h2>Run results</h2>\n";
  //echo "<ul>\n";
foreach ($results_messages as $result) {
  //echo "<li>$result</li>\n";
}
//echo "</ul>\n";
}
 }
?>