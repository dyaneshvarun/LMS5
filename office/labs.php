<?php
	require_once("../arc/dbconnect.php");
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
	$task = $_GET['task'];
	if($task==1)
	{
	$lab = $_GET['labName'];
	$class = $_GET['className'];
	$sql= "SELECT STAFF_NAME from STAFF where STAFF_ID = (SELECT DISTINCT STAFF_ID from slot_allocation where CLASS_ID = (SELECT CLASS_ID FROM CLASS WHERE USER_NAME = '$class') and PAPER_ID = (SELECT PAPER_ID FROM PAPER WHERE PAPER_CODE='$lab'))";
	echo sqlToJson($conn,$sql);
	}
	else if($task==2)
	{
	$lab = $_GET['labName'];
	$class = $_GET['className'];
	$sql= "SELECT STAFF_NAME,STAFF_ID from STAFF where STAFF_ID IN (SELECT DISTINCT STAFF_ID from lab_allocation where CLASS_ID = (SELECT CLASS_ID FROM CLASS WHERE USER_NAME = '$class') and PAPER_ID = (SELECT PAPER_ID FROM PAPER WHERE PAPER_CODE='$lab'))";
	echo sqlToJson($conn,$sql);
	}
	else if($task==3)
	{
		$lab = $_GET['labName'];
		$class = $_GET['className'];
		$staff = $_GET['staffName'];
		$sql = "DELETE FROM LAB_ALLOCATION WHERE STAFF_ID=$staff AND CLASS_ID = (SELECT CLASS_ID FROM CLASS WHERE USER_NAME = '$class') and PAPER_ID = (SELECT PAPER_ID FROM PAPER WHERE PAPER_CODE='$lab')";
		if(!$result = mysqli_query($conn,$sql)){
				echo mysqli_error($conn);exit;
		}
	}
	else if($task==4)
	{
		$day = $_GET['dayName'];
		$sp =$_GET['start'];
		$ep = $_GET['end'];
		$paper = $_GET['courseName'];
		$class = $_GET['className'];
		$staff = $_GET['staffName'];
		for($i=$sp;$i<=$ep;$i++){
			$sql="INSERT INTO lab_allocation(DAY_ID, CLASS_ID, HOUR, PAPER_ID, STAFF_ID) VALUES ($day,$class,$i,$paper,$staff)";
			//echo $sql;
			if(!$result = mysqli_query($conn,$sql)){
				echo mysqli_error($conn);exit;
			}
		}
	}
	else if($task==5)
	{
	$lab = $_GET['labName'];
	$class = $_GET['className'];
	$sql= "SELECT MIN(HOUR) H1,MAX(HOUR) H2,DAY_ID,PAPER_ID,CLASS_ID from SLOT_ALLOCATION where CLASS_ID = (SELECT CLASS_ID FROM CLASS WHERE USER_NAME = '$class') and PAPER_ID = (SELECT PAPER_ID FROM PAPER WHERE PAPER_CODE='$lab')";
	echo sqlToJson($conn,$sql);
	}
	
?>