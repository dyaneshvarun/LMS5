<?php
	require_once("../arc/dbconnect.php");
	$sql = "SELECT STAFF_ID FROM STAFF";
	$result = $conn->query($sql);
	$i=0;
	$staffs=array();
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$staffs[$i++]= $row['STAFF_ID'];
			//echo $staffs[$i-1];
			//echo "\n  ";
		}
	} else {
		echo "0 results";
	}
	//echo $i;
	for($j=0;$j<$i;$j++)
	{
		$sql="INSERT INTO STAFF_LEAVE_TYPE VALUES($staffs[$j],'CPL',0)";
		echo $staffs[$j];
		if(!$res = mysqli_query($conn,$sql)){
						echo "Error in Updation";
						exit();
		}
	}
?>