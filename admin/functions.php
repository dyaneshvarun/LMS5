<?php
  if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
if(!isset($_SESSION['STA_ID'])){
	header("Location:login.php");
}

function getLeaveType($conn){
	$sql = 'SELECT * FROM LEAVE_TYPE';
	$res = mysqli_query($conn,$sql);
	$rows = array();
	while($row = mysqli_fetch_assoc($res)){
		$rows[]=$row;
	}
	return $rows;
}

function getStaffLeave($conn,$sta_id){
	$sql = "SELECT * FROM STAFF_LEAVE_TYPE WHERE STAFF_ID = $sta_id";
	$res = mysqli_query($conn,$sql);
	$rows = array();
	while($row = mysqli_fetch_assoc($res)){
		$rows[]=$row;
	}
	return $rows;
}
?>
