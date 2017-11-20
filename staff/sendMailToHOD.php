<?php
session_start();
if(!isset($_SESSION['STA_ID'])){
	echo "Please Login to Use the Service";exit();
}
$sta_id = $_SESSION['STA_ID'];
//echo "Inside PHP" ;
require_once("../arc/dbconnect.php");
require_once("functions.php");
require('../phpmailer/mailsend1.php');
$lid = $_POST['lid'];

//echo "LID is ".$lid;
if($lid >0){
$mail = new PHPMailer(false);
$sql = "SELECT STAFF_NAME,LEAVE_TYPE,NOD,FR_DATE,TO_DATE FROM STAFF_LEAVE,STAFF WHERE LEAVE_ID =". $lid ." AND STAFF.STAFF_ID = STAFF_LEAVE.STAFF_ID";
//echo $sql;
if(!$res=mysqli_query($conn,$sql)) echo mysqli_error($conn);
while($row=mysqli_fetch_assoc($res)){
$email = "hod@auist.net";//HOD MAIL
$name = "HOD_IST";
$subject = "Review Leave #".$lid;
$content = "Leave Applied by <b> $row[STAFF_NAME] from $row[FR_DATE] to $row[TO_DATE] </b> <br/>Leave ID :  <b>$lid </b> <br/>Number of Days :  <b>$row[NOD]</b><br/>Leave Type :  <b>$row[LEAVE_TYPE]</b><br/>Kindly review the leave at Website";
sendLeaveMail($mail,$email,$name,$content,$subject);
}
}
?>