<?php
	//session_start();
	require_once("../arc/dbconnect.php");
	require_once("functions.php");
	if(!isset($_SESSION['STA_ID'])){
		header("Location:login.php");
	}
	$sta_id = $_SESSION['STA_ID'];
	$sql = "CALL TODAY_LEAVE()";
	if(!$rs = mysqli_query($conn,$sql)){
		Die (mysqli_error($conn));
	}
    mysqli_close($conn);
    $conn = mysqli_connect($hostname,$username,$password,$database);
	$res = mysqli_query($conn,"CALL GET_ADMIN($sta_id)");
    $row = mysqli_fetch_assoc($res);
    $staff_info = $row;
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
</head>

<body>
<?php require_once("header.php");?>
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Today's Staff Leave List</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
					<div class="col-lg-12">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Leave ID</th>
									<th>Staff ID</th>
									<th>Staff Name</th>
									<th>Leave Type</th>
									<th>No. of Days</th>
								</tr>
							</thead>
							<tbody><?php
								while($row = mysqli_fetch_assoc($rs)){
							?>		<tr>
										<td><?php echo " <a href ='view_leave.php?lid=".$row['LEAVE_ID']."'>".$row['LEAVE_ID']."</a>"; ?></td>
										<td><?php echo $row['STAFF_ID']; ?></td>
										<td><?php echo $row['STAFF_NAME']; ?></td>
										
										<td><?php echo $row['LEAVE_TYPE']; ?></td>
										<td><?php echo $row['NOD']; ?></td>
									</tr>
							<?php } ?>
							</tbody>
						</table>
					</div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
