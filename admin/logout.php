<?php
	session_start();
	$_SESSION['STA_ID'] = 0;
	session_unset();
	session_destroy();
	header("Location:login.php");
?>
