<?php

session_start();
if(!isset($_SESSION['STA_ID'])){
	header("Location:login.php");
}


$sta_id = $_SESSION['STA_ID'];
require_once("../arc/dbconnect.php");
require_once("functions.php");
//$memcache = new Memcache;
//$cacheAvailable = $memcache->connect('127.0.0.1','11211');

$leaveType = array();
//$leaveType = $memcache->get('leave_type');
//if(!$leaveType){
$rows = getLeaveType($conn);
	//$memcache->set('leave_type',$rows,MEMCACHE_COMPRESSED,1000);
	//$leaveType = $memcache->get('leave_type');
$leaveType = $rows;

$tcl = $leaveType[0];
$trh = $leaveType[1];
$tscl = $leaveType[2];

$staffLeave = array();
//$key = "STAFF_LEAVE_".$sta_id;
//$staffLeave = $memcache->get($key);
//if(!$staffLeave){
$rows = getStaffLeave($conn,$sta_id);
	//$memcache->set($key,$rows,MEMCACHE_COMPRESSED,1000);
$staffLeave = $rows;
//$staffLeave = $memcache->get($key);
$staffLeave = $rows;
foreach($staffLeave as $row){
	if($row['LEAVE_TYPE'] == 'CL')
		$s_cl = $row['NOD'];
	if($row['LEAVE_TYPE'] == 'RH')
		$s_rh = $row['NOD'];
	if($row['LEAVE_TYPE'] == 'SCL')
		$s_scl = $row['NOD'];
}

if(!isset($_POST['op'])){
	echo "Error";
	return;
}
$op = mysqli_real_escape_string($conn,$_POST['op']);
switch($op){
	case '1':{//Leave accept/reject
		if(!$lid = $_POST['lid']){
			echo "Leave ID Not Valid";
			return;
		}
		if(!$lstat = $_POST['lstat']){
			echo "Status Not Valid";
			return;
		}
		$sql = "SELECT STAFF_ID FROM STAFF_LEAVE WHERE LEAVE_ID = $lid";
		if(!$res=mysqli_query($conn,$sql)){
			echo mysqli_error($conn);return;
		}
		$row = mysqli_fetch_assoc($res);
		$key = "STAFF_LEAVE_".$row['STAFF_ID'];
		if($lstat == 1){
			$sql = "CALL ACCEPT_LEAVE($lid)";
			if(!mysqli_query($conn,$sql)){
				echo mysqli_error($conn);return;
			}
			echo 0;
		}
		if($lstat == 2){
			$sql = "CALL REJECT_LEAVE($lid)";
			if(!mysqli_query($conn,$sql)){
				echo mysqli_error($conn);return;
			}
			echo 0;
		}
		if($lstat == 4){
			$sql = "CALL CANCEL_LEAVE($lid)";
			if(!mysqli_query($conn,$sql)){
				echo mysqli_error($conn);return;
			}
			echo 1;
		}
		return;
		//break;
	}
	case '12':{//Leave accept
		$lid=$_POST['lid'];
		$sql="SELECT * FROM STAFF_LEAVE,STAFF WHERE LEAVE_ID =". $lid ." AND STAFF.STAFF_ID = STAFF_LEAVE.STAFF_ID";
		if(!$res=mysqli_query($conn,$sql))
			echo mysqli_error($conn);
		while($row=mysqli_fetch_assoc($res)){
		require('../phpmailer/mailsend1.php');
		$mail = new PHPMailer(true);
		$email = $row['EMAILID'] ;
		$name = $row['STAFF_NAME'];
		$subject = "Leave Accepted for Leave ID ".$lid;
		$content = "Your Leave ID ".$lid." is accepted . Leave Type: ".$row['LEAVE_TYPE']." From Date : ".$row['FR_DATE'] ." To Date :".$row['TO_DATE'];
		sendLeaveMail($mail,$email,$name,$content,$subject);
		}
		break;
	}
	case '13':{//Leave REJECT
		$lid=$_POST['lid'];
		$sql="SELECT * FROM STAFF_LEAVE,STAFF WHERE LEAVE_ID =". $lid ." AND STAFF.STAFF_ID = STAFF_LEAVE.STAFF_ID";
		if(!$res=mysqli_query($conn,$sql))
			echo mysqli_error($conn);
		while($row=mysqli_fetch_assoc($res)){
		require('../phpmailer/mailsend1.php');
		$mail = new PHPMailer(true);
		$email = $row['EMAILID'] ;
		$name = $row['STAFF_NAME'];
		$subject = "Leave Declined for Leave ID ".$lid;
		$content = "Your Leave ID ".$lid." is declined . Leave Type: ".$row['LEAVE_TYPE']." From Date : ".$row['FR_DATE'] ." To Date :".$row['TO_DATE'];
		sendLeaveMail($mail,$email,$name,$content,$subject);
		}
		break;
	}
	case '14':
	{
		$lid=$_POST['lid'];
		$stat = $_POST['lstat'];
		$sql = "UPDATE compensation_leave_days SET status=$stat where leavedate_id = $lid";
		if(!$res=mysqli_query($conn,$sql))
			echo mysqli_error($conn);
		break;
	}
	case '15':{
		$doc = $_POST['docToWrite'];
		$str = $_POST['stringToWrite'];
		if (json_decode($str) != null)
		{
		 $file = fopen($doc,'w+');
		 fwrite($file, $str);
		 fclose($file);
		 echo "Written to file !";
		}
		else
		{
			echo "ERROR Writing JSON File";
		}
		break;
	}
	case '22':{
		$attr = $_POST['attr'];
		$table = $_POST['table'];
		$arr = explode(',',$attr);
		$sql = "SELECT ".$attr." FROM ".$table;
		echo sqlToJson($conn,$sql);
		break;
	}
	default:{
		echo "Not Valid Op Code";
		return;
	}
}
?>
