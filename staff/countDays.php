<?
	session_start();
	require_once("../arc/dbconnect.php");
	require_once("functions.php");
	if(!isset($_SESSION['STA_ID'])){
		header("Location:login.php");
	}
	$sta_id = $_SESSION['STA_ID'];
    mysqli_close($conn);
    $conn = mysqli_connect($hostname,$username,$password,$database);
	$staffid = $_POST['staff'];
	$sql="SELECT * FROM STAFF_LEAVE_TYPE WHERE STAFF_ID=".$staffid;
	if(!$res=mysqli_query($conn,$sql)){
			echo mysqli_error($conn);
		}
		
	$rows = mysqli_fetch_assoc($res);
	echo json_encode($rows);
?>