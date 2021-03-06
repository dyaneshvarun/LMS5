<?php
	session_start();
	require_once("../arc/dbconnect.php");
	require_once("functions.php");
	if(!isset($_SESSION['STA_ID'])){
		header("Location:login.php");
	}
	$sta_id = $_SESSION['STA_ID'];
	$sql = "SELECT * FROM STAFF_PERIOD_ALLOCATION WHERE ALTER_STAFF_ID =". $sta_id." AND (STATUS=1 OR STATUS=2) order by alter_date desc";
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
    <link href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
	<!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
<?php require_once("header.php");?>
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Accepted/Declined Alteration List</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
					<div class="col-lg-12">
						<table class="table table-hover tt" id="myTable">
							<thead>
								<tr>
									<th>Date</th>
									<th>Staff</th>
									<th>Class</th>
									<th>Hour</th>
									<th>Status</th>
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
									}else{
										$stat = "UNDEFINED";
									}
							?>		<tr id="inrow" class="<?php echo $cla; ?>">
										<td><?php echo date('d-m-Y',strtotime($row['ALTER_DATE'])); ?></td>
										<td class="staName"><?php echo $row['ALTER_STAFF_ID']; ?></td>
										<td class="claName"><?php echo $row['CLASS_ID'];?></td>
										<td><?php echo $row['HOUR']; ?></td>
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
	<script src="acceptedAlter.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>

