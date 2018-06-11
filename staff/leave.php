<?php
	session_start();
	require_once("../arc/dbconnect.php");
	require_once("functions.php");
	if(!isset($_SESSION['STA_ID'])){
		header("Location:login.php");
	}
	$sta_id = $_SESSION['STA_ID'];
	$sql = "SELECT * FROM STAFF_LEAVE WHERE STAFF_ID  = $sta_id ORDER BY LEAVE_ID DESC";
	if(!$rs = mysqli_query($conn,$sql)){
		Die (mysqli_error($conn));
	}
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
					<form method="POST" id="fsub">
						<table class="table table-hover tt" id="datetab">
							<thead>
								<tr>
									<th>Leave ID</th>
									<th>From Date</th>
									<th>To Date</th>
									<th>Applied Date</th>
									<th>Leave Type</th>
									<th>No of Days</th>
									<th>Status</th>
								</tr>
							</thead>
							
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
									else if($row['STATUS'] == 5){
										$stat = "AUTO REJECTED";
										$cla = "info";
									}
									else{
										$stat = "UNDEFINED";
									}
							?>		<tr id="inrow" class="<?php echo $cla; ?>">
										<td><a href="view_leave.php?lid=<?php echo $row['LEAVE_ID'];?>"><?php echo $row['LEAVE_ID'];?></td>
										<td><?php echo $row['FR_DATE']; ?></td>
										<td><?php echo $row['TO_DATE'];?></td>
										<td><?php echo $row['APPLY_DATE']; ?></td>
										<td><?php echo $row['LEAVE_TYPE']; ?></td>
										<td><?php echo $row['NOD']; ?></td>
										<td><?php echo $stat; ?></td>
									</tr>
							<?php } ?>
							</tbody>
						</table>
					</div>
					</form>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>
    <script src="awaiting_response.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>

