<?php
	//session_start();
	require_once("../arc/dbconnect.php");
	require_once("functions.php");
	if(!isset($_SESSION['STA_ID'])){
		header("Location:login.php");
	}
	$sta_id = $_SESSION['STA_ID'];
	/*$memcache = new Memcache;
	$cacheAvailable = $memcache->connect('127.0.0.1','11211');
	$key = "ADMIN_INFO_".$sta_id;
	/*if(!$staff_info = $memcache->get($key)){
		header("Location:login.php");
		
	}*/
	$sql = "SELECT LEAVE_ID,LEAVE_TYPE,NOD,SL.STAFF_ID,STAFF_NAME,FR_DATE,TO_DATE,REASON,SL.STATUS FROM STAFF_LEAVE SL,STAFF S WHERE S.STAFF_ID = SL.STAFF_ID ";
	if(!$rs = mysqli_query($conn,$sql)){
		Die (mysqli_error($conn));
	}
	/*else{
		while($row = mysqli_fetch_assoc($rs)){
			echo $row['STAFF_NAME'];
		}
	}*/
	mysqli_close($conn);
    $conn = mysqli_connect($hostname,$username,$password,$database);
	$res = mysqli_query($conn,"CALL GET_ADMIN($sta_id)");
    $row = mysqli_fetch_assoc($res);
    $staff_info = $row;
    //print_r($row);
    mysqli_close($conn);
    $conn = mysqli_connect($hostname,$username,$password,$database);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Staff Dashboard | IST Leave System</title>
	
    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="../dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
 <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>
    <script src="awaiting_response.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
	<link rel="stylesheet"href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css"></link>
	<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
	<script>
	$(document).ready(function() {$('#datetab').DataTable();} );
	</script>
</head>

<body>
<?php require_once("header.php");?>
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Leave List</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
					<div class="col-lg-12">
						<table class="table table-hover" id="datetab">
							<thead>
								<tr>
									<th>Leave ID</th>
									<th>Staff ID</th>
									<th>Staff Name</th>
									<th>Leave Type</th>
									<th>From Date</th>
									<th>To Date</th>
									<th>Status</th>
									<th>No. of Days</th>
									<!--th>Action</th-->
								</tr>
							</thead>
							<form method="POST" id="fsub">
							<tbody><?php
								while($row = mysqli_fetch_assoc($rs)){
									if($row['STATUS'] == 0){
										$stat = "WAITING";
										$cla = "warning";
									}else if($row['STATUS'] == 1){
										$stat = "ACCEPTED";
										$cla = "success";
									}else if($row['STATUS'] == 2){
										$stat = "REJECTED";
										$cla = "danger";
									}else if($row['STATUS'] == 4){
										$stat = "CANCELLED";
										$cla = "danger";
									}
									else{
										$stat = "UNDEFINED";
									}
							?>		<tr class="<?php echo $cla; ?>">
										<td><a href="view_leave.php?lid=<?php echo $row['LEAVE_ID']; ?>" /><?php echo $row['LEAVE_ID']; ?></td>
										<td><?php echo $row['STAFF_ID']; ?></td>
										<td><?php echo $row['STAFF_NAME']; ?></td>
										<td><?php echo $row['LEAVE_TYPE']; ?></td>
										<td><?php echo $row['FR_DATE']; ?></td>
										<td><?php echo $row['TO_DATE']; ?></td>
										<td><?php echo $stat ?></td>
										<td><?php echo $row['NOD']; ?></td>
										
									</tr>
							<?php } ?>
							</tbody>
						</table>
						<!--button type="submit" class="btn btn-primary">Submit</button-->
					</div>
					</form>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

   
	
</body>

</html>

