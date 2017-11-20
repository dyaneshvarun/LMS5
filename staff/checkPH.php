<?php
	require_once("../arc/dbconnect.php");$date1 = $_POST['date1'];
	//echo $date1;
	$sql= "SELECT HOLIDAY_DATE from PUBLIC_HOLIDAYS WHERE HOLIDAY_DATE = '$date1'";
	$res= mysqli_query($conn,$sql);
	echo mysqli_num_rows($res);
?>