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
	$sql= "SELECT HOLIDAY_DATE from PUBLIC_HOLIDAYS";
	//echo 'HI';
	echo sqlToJson($conn,$sql);
	
	
?>