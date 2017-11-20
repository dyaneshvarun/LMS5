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
        $dsgn=$_POST['dsgn'];
        //CHANGES
       
        $cat=$_POST['cate'];
        //CHANGES
        echo $staffID;
        echo $staffName;
        //CHANGES
        $sql ='INSERT INTO staff(`STAFF_ID`, `STAFF_NAME`, `DESIGNATION`, `USERNAME`, `PASSWORD`,`EMAILID`,`STATUS`,`CATEGORY`) VALUES ('.$staffID.',"'.$staffName.'","'.$dsgn.'","'.$staffID.'","'.$staffID.'","default@gmail.com",0,"'.$cat.'")';
       //CHANGES
       echo $staffID;
        echo 'hi';
        if (mysqli_query($conn, $sql))
        {
            
            header("Location:insert-staff.php");
        }
        else
            echo mysqli_error($conn);
?>  