<?php
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION['STA_ID'])){
	header("Location:login.php");
}

function getLeaveType($conn){
	$sql = "SELECT * FROM LEAVE_TYPE";
	$res = mysqli_query($conn,$sql);
	$rows = array();
	while($row = mysqli_fetch_assoc($res)){
		$rows[]=$row;
	}
	return $rows;
}

function getStaffLeave($conn,$sta_id){
	$sql = "SELECT * FROM `STAFF_LEAVE_TYPE` WHERE STAFF_ID = '". $sta_id."'";
	if(!$res = mysqli_query($conn,$sql))
	{
		mysqli_error($conn);
	}$rows = array();
	while($row = mysqli_fetch_assoc($res)){
		$rows[]=$row;
	}
	return $rows;
}
function getStaffLeave1($sta_id){
	$sql = "SELECT * FROM `STAFF_LEAVE_TYPE` WHERE STAFF_ID = '". $sta_id."'";
	$conn = "";
	if($conn=="")require_once("../arc/dbconnect.php");
	if(!$res = mysqli_query($conn,$sql))
	{
		mysqli_error($conn);
	}$rows = array();
	while($row = mysqli_fetch_assoc($res)){
		$rows[]=$row;
	}
	return $rows;
}

function sqlToJson($conn,$sql){
	if(!$result = mysqli_query($conn,$sql)){
			echo mysqli_error($conn);exit;
	}
	$rows = array();
	while($res = mysqli_fetch_assoc($result)){
		$rows[] = $res;
	}
	return json_encode($rows);
}
?>
