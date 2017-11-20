<?php

	$hostname = "localhost";
	$username = "istleaveadmin";
	$password = "lms@78";
	$database = "newsys";
	
	$conn = mysqli_connect($hostname,$username,$password,$database);
	
	if(!$conn){
		Die("Database Failed : " . mysqli_error());
	}
	//$q = "CALL CHECK_ACTIVATION(5,'talk2ritchie@gmail.com',@cou)";
	//$rs = mysqli_query($conn,$q);
	//$rs = mysqli_query($conn,"SELECT @cou AS COU");
	//$row = mysqli_fetch_assoc($rs);
	//echo $row['COU'];
	
?>
