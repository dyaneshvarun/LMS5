<?php
	require_once("../arc/dbconnect.php");
	//echo $date1;
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
	$class = $_GET['className'];
	$task = $_GET['task'];
	//echo $class;
	if($task==1)
	{$sql = "SELECT CLASS_ID from class where USER_NAME ='$class'" ;
	if(!$result = mysqli_query($conn,$sql)){
			echo mysqli_error($conn);exit;
	}
	$rows = array();
	while($res = mysqli_fetch_assoc($result)){
		$rows[] = $res;
		//echo $res['CLASS_ID'];
		$sql= "SELECT SA.DAY_ID AS DAY,SA.HOUR AS HOUR,P.PAPER_NAME AS PAPER,S.STAFF_NAME AS STAFF from SLOT_ALLOCATION SA,STAFF S,PAPER P where CLASS_ID ='".$res['CLASS_ID']."' and SA.PAPER_ID = P.PAPER_ID AND SA.STAFF_ID = S.STAFF_ID" ;
	
	}
	echo sqlToJson($conn,$sql);
	}
	else if($task==2)
	{
		$sql = "DELETE FROM slot_allocation where CLASS_ID = (SELECT CLASS_ID from class where USER_NAME='$class')" ;
	if(!$result = mysqli_query($conn,$sql)){
			echo mysqli_error($conn);exit;
	}
	echo 1;
	//echo sqlToJson($conn,$sql);
	}
	else if($task ==3){
		
	$day=$_GET['dayName'];
	$period=$_GET['periodName'];
		$sql = "DELETE FROM slot_allocation where CLASS_ID = (SELECT CLASS_ID from class where USER_NAME='$class') and day_id=$day and hour=$period" ;
	echo $sql;
	if(!$result = mysqli_query($conn,$sql)){
			echo mysqli_error($conn);exit;
	}
	echo 1;
	}
	else if($task==4){
		$day=$_GET['dayName'];
		$period=$_GET['periodName'];
		$staff=$_GET['staffName'];
		$paper= $_GET['paperName'];
		$sql="SELECT CLASS_ID FROM class WHERE USER_NAME='$class'";
		if(!$result = mysqli_query($conn,$sql)){
				echo mysqli_error($conn);exit;
		}
		$row = mysqli_fetch_assoc($result);
		$classID = $row['CLASS_ID'];
		$sql="SELECT PAPER_ID FROM paper WHERE PAPER_CODE='$paper'";
		if(!$result = mysqli_query($conn,$sql)){
				echo mysqli_error($conn);exit;
		}
		$row = mysqli_fetch_assoc($result);
		$paper = $row['PAPER_ID'];
		$sql = "SELECT count(*) as count FROM slot_allocation where CLASS_ID = (SELECT CLASS_ID from class where USER_NAME='$class') and day_id=$day and hour=$period" ;
		
		if(!$result = mysqli_query($conn,$sql)){
				echo mysqli_error($conn);exit;
		}
		
		$row = mysqli_fetch_assoc($result);
		if( $row['count']==0) $sql="INSERT INTO `slot_allocation`(`DAY_ID`, `CLASS_ID`, `HOUR`, `PAPER_ID`, `STAFF_ID`, `STATUS`) VALUES ($day,$classID,$period,$paper,$staff,0)";
		else if($row['count']==1) $sql="UPDATE slot_allocation SET staff_id=$staff ,paper_id=$paper where CLASS_ID = (SELECT CLASS_ID from class where USER_NAME='$class') and day_id=$day and hour=$period" ;
		else $sql="";
		if(!$result = mysqli_query($conn,$sql)){
				echo mysqli_error($conn);exit;
		}
		else echo "Done";
		echo "$sql";
	}
?>