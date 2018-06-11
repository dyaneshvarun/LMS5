<?php
        require_once("../arc/dbconnect.php");
	require_once("functions.php");
	if(!isset($_SESSION['STA_ID'])){
		header("Location:login.php");
	}
	$sta_id = $_SESSION['STA_ID'];
         mysqli_close($conn);
        $conn = mysqli_connect($hostname,$username,$password,$database);
        $staffID=$_POST['staffID'];
        $staffName=$_POST['staffName'];
        echo $staffName;
        $sql ='INSERT INTO paper(`PAPER_CODE`, `PAPER_NAME`) VALUES ("'.$staffID.'","'.$staffName.'")';
       echo $staffID;
        echo 'hi';
        if (mysqli_query($conn, $sql))
            header("Location:insert-course.php");
        else
            echo mysqli_error($conn);
?>  