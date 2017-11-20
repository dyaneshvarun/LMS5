<?php
	//session_start();
	require_once("../arc/dbconnect.php");
	require_once("functions.php");
	if(!isset($_SESSION['STA_ID'])){
		header("Location:login.php");

	}
	$sta_id = $_SESSION['STA_ID'];
	$sql="Select C.CLASS_NAME AS CN , S.STAFF_NAME AS ASN ,S.STAFF_ID AS SID, SLD.LEAVE_ID AS ID ,SPA.HOUR AS H FROM STAFF_LEAVE_DAYS AS SLD,STAFF S,CLASS C,STAFF_PERIOD_ALLOCATION SPA WHERE SPA.CLASS_ID=C.CLASS_ID AND SPA.ALTER_DATE=CURRENT_DATE AND SPA.ALTER_STAFF_ID = S.STAFF_ID AND SLD.SLDID = SPA.LEAVE_ID";
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
                        <h1 class="page-header">Today's Staff Altered List</h1>
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
									<th>Staff Name</th>
									<th>Altered Staff Name</th>
									<th>Class</th>
									<th>Hour</th>
								</tr>
							</thead>
							<tbody><?php
								while($row = mysqli_fetch_assoc($rs)){
							?>		<tr>
										<td><?php echo " <a href ='view_leave.php?lid=".$row['ID']."'>".$row['ID']."</a>"; ?></td>
										<td><?php echo $row['SN']; ?></td>
										<td><?php echo $row['ASN']; ?></td>
										
										<td><?php echo $row['CN']; ?></td>
										<td><?php echo $row['H']; ?></td>
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
