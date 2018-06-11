<?php
	require_once("../arc/dbconnect.php");
	require_once("functions.php");
	if(!isset($_SESSION['STA_ID'])){
		header("Location:login.php");
	}
	$sta_id = $_SESSION['STA_ID'];
	$conn = mysqli_connect($hostname,$username,$password,$database);
	for($i=0;$i<8;$i++)
	{
		$PAPERID = 'paperID'.$i;
		$STAFFID = 'staffID'.$i;
		//echo  $PAPERID;
		if($_POST[$STAFFID]!=-1)
		{$sql='call `INSERT-SLOT` ("'.$_POST['classID'].'",'.$_POST['dayorder'].','. ($i+1) .',"'.$_POST[$PAPERID].'",'.$_POST[$STAFFID].')';
		$rs=mysqli_query($conn,$sql);
		if(!$rs) echo mysqli_error($conn);
		}
		
	}header("Location:staff_paper.php");
?>