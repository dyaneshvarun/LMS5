<?php
	session_start();
	require_once("../arc/dbconnect.php");
	require_once("functions.php");
	if(!isset($_SESSION['STA_ID'])){
		header("Location:login.php");
	}
	$sta_id = $_SESSION['STA_ID'];
	$sql = "SELECT SL.LEAVE_ID,SL.STAFF_ID,SPA.ALTER_DATE,SPA.HOUR,SPA.CLASS_ID FROM STAFF_LEAVE SL, STAFF_PERIOD_ALLOCATION SPA WHERE  ALTER_STAFF_ID = $sta_id AND SPA.STATUS = 0 AND SL.LEAVE_ID IN (SELECT LEAVE_ID FROM `STAFF_LEAVE_DAYS` WHERE SLDID = SPA.LEAVE_ID)";
	if(!$rs1 = mysqli_query($conn,$sql)){
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
                        <h1 class="page-header">Alterations List</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
					<div class="col-lg-12">
						<table class="table table-hover tt" id="datetab">
							<thead>
								<tr>
									<th>Leave ID</th>
									<th>Staff ID</th>
									<th>Class</th>
									<th>Date</th>
									<th>Hour</th>
									<!--th>Action</th-->
								</tr>
							</thead>
							<form method="POST" id="fsub">
							<tbody><?php
								while($row3 = mysqli_fetch_assoc($rs1)){
							?>		<tr id="inrow">
										<td><input class="form-control col-xs-2" style="width:60px;" type="text" id="lid" value="<?php echo $row3['LEAVE_ID']; ?>" disabled></td>
										<td><?php
										$sql2 = "SELECT STAFF_NAME FROM STAFF WHERE STAFF_ID=".$row3['STAFF_ID'];
										if(!$rs = mysqli_query($conn,$sql2)){
											Die (mysqli_error($conn));
										}
										$row2=mysqli_fetch_assoc($rs);
										echo $row2['STAFF_NAME']; 
										 ?></td>
										<td><input class="form-control" type="text" id="clid" value="<?php 
										$sql1 = "SELECT CLASS_NAME FROM CLASS WHERE CLASS_ID=".$row3['CLASS_ID'];
										if(!$rs = mysqli_query($conn,$sql1)){
											Die (mysqli_error($conn));
										}
										$row1=mysqli_fetch_assoc($rs);
										echo $row1['CLASS_NAME']; ?>" disabled /></td>
										<td><input class="form-control" type="text" id="adate" value="<?php echo $row3['ALTER_DATE']; ?>" disabled /></td>
										<td><input class="form-control" type="text" style="width:60px;" id="hr" value="<?php echo $row3['HOUR']; ?>" disabled /></td>
										<td><select class="form-control" id="opt">
											<option value="none">----</option>
											<option value="ACCEPT">ACCEPT</option>
											<option value="REJECT">REJECT</option>
										</select></td>
									</tr>
							<?php } ?>
							</tbody>
						</table>
						<button type="submit" class="btn btn-primary">Submit</button>
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

