<?php
//$sta_id = $_SESSION['STA_ID'];
require_once("../arc/dbconnect.php");
require_once("functions.php");
$purpose = $_POST['PurposesArray'];
$dates = $_POST['DateArray'];
$i=0;
for($i=0;$i<count($purpose); $i++){
$sql="INSERT INTO RESTRICTED_HOLIDAY(`DATE`,`FUNCTION_NAME`) VALUES ('". $dates[$i] ."','". $purpose[$i] ."')";
$conn = mysqli_connect($hostname,$username,$password,$database);
$rs = mysqli_query($conn,$sql);
if(!$rs) echo mysqli_error($conn);
//else //echo "Inserted";
}
?>