<?php
	//session_start();
	require_once("../arc/dbconnect.php");
	require_once("functions.php");
	if(!isset($_SESSION['STA_ID'])){
		header("Location:login.php");
	}
	$sta_id = $_SESSION['STA_ID'];
	$sql = "SELECT LEAVEDATE_ID as ID,CLD.STAFF_ID,STAFF_NAME,CDATE,REASON from compensation_leave_days cld,staff where staff.staff_id = cld.staff_id and cld.status=0 order by APPLY_DATE";
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

    <title>Admin Dashboard | IST Leave System</title>

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
                        <h1 class="page-header">CPL Clearance</h1>
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
									<th>Date</th>
									<th>Reason</th>
									<th>Action</th>
									
								</tr>
							</thead>
							<form method="POST" id="fsub">
							<tbody><?php
								while($row = mysqli_fetch_assoc($rs)){
							?>		<tr>
										<td><?php echo $row['ID']; ?></td>
										<td><?php echo $row['STAFF_ID']; ?></td>
										<td><?php echo $row['STAFF_NAME']; ?></td>
										<td><?php echo $row['CDATE']; ?></td>
										<td><?php echo $row['REASON']; ?></td>
										<td><select class="form-control leavestat" id="<?php echo $row['ID']; ?>">
											<option value="none">----</option>
											<option value="ACCEPT">ACCEPT</option>
											<option value="REJECT">REJECT</option>
										</select></td>
										<!--td><input type="radio" class="leavestat" id="<?php echo $row['ID']; ?>" value="none" name="<?php echo $row['ID']?>" checked></td>
										<td><input type="radio" class="leavestat" id="<?php echo $row['ID']; ?>" value="ACCEPT" name="<?php echo $row['ID']?>"></td>
										<td><input type="radio" class="leavestat" id="<?php echo $row['ID']; ?>" value="REJECT" name="<?php echo $row['ID']?>">
										</td-->
									</tr>
							<?php } ?>
							</tbody>
						</table>
						<button type="submit" class="btn btn-success">Submit</button>
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
    <script src="cplresponse.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>

