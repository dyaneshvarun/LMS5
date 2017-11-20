<?php
	session_start();
	if(!$sta_id = $_SESSION['STA_ID']){
		header("Location:login.php");
		return;
	}
	require_once("../arc/dbconnect.php");
	require_once("functions.php");
	$datetime = new DateTime(null, new DateTimeZone('IST'));
	$datetime->modify('-180 days');
	$NinetyDaysBefore = $datetime->format('Y-m-d');
	$sql = "SELECT COUNT(*) AS CPL from COMPENSATION_LEAVE_DAYS WHERE STATUS = 1 AND STAFF_ID=$sta_id AND CDATE>'$NinetyDaysBefore'";
	$rs = mysqli_query($conn,$sql);
	if(!$row = mysqli_fetch_assoc($rs)){
		echo mysqli_error($conn);
	}
	$credits = $row;
	$sql = "CALL GET_STAFF($sta_id)";
	$rs = mysqli_query($conn,$sql);
	if(!$row = mysqli_fetch_assoc($rs)){
		echo mysqli_error($conn);
	}
	$staff_info = $row;
	mysqli_close($conn);
	$conn = mysqli_connect($hostname,$username,$password,$database);
	$key = "STAFF_LEAVE_".$sta_id;
	$rows = getStaffLeave($conn,$sta_id);
	$staffLeave = $rows;
	foreach($staffLeave as $row){
	if($row['LEAVE_TYPE'] == 'CL')
		$s_cl = $row['NOD'];
	if($row['LEAVE_TYPE'] == 'RH')
		$s_rh = $row['NOD'];
	if($row['LEAVE_TYPE'] == 'SCL')
		$s_scl = $row['NOD'];
	}
	mysqli_close($conn);
	$conn = mysqli_connect($hostname,$username,$password,$database);
	$leaveType = array();
	$rows = getLeaveType($conn);
	$leaveType = $rows;
	$tcl = $leaveType[0];
	$trh = $leaveType[1];
	$tscl = $leaveType[2];
	
	
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Staff Dashboard 2 | IST Leave System</title>

    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

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
                        <h1 class="page-header">CPL Credits Addition</h1><br>
                        <div class="col-sm-8">
							<form method="POST" role="form" class="form-horizontal" id="fsub">
								<div class="form-group">
									<label class="control-label col-sm-3" for="name">Name : </label>
									<div class="col-sm-9">
										<input type="input" class="form-control" id="name" value="<?php echo $staff_info['STAFF_NAME'];?>" disabled>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-3" for="desg">Designation : </label>
									<div class="col-sm-9">
										<input type="input" class="form-control" id="desg" value="<?php echo $staff_info['DESIGNATION'];?>" disabled>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-3" for="sid">ID : </label>
									<div class="col-sm-9">
										<input type="input" class="form-control" id="sid" value="<?php echo $staff_info['STAFF_ID'];?>" disabled>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-3" for="credits">CPL Credits Gained : </label>
									<div class="col-sm-9">
										<input type="input" class="form-control" id="credits" value="<?php echo $credits['CPL'];?>" disabled>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-3" for="Date">Date: </label>
									<div class="col-sm-9">
										<input type="text" class="form-control" id="date1" format="dd/mm/yyyy">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-3" for="reason">Reason : </label>
									<div class="col-sm-9">
										<input type="input" class="form-control" id="reason">
									</div>
								</div>
								<div class="form-group col-sm-9">
										<p class="col-sm-4"></p>
										<input type="submit" class="btn btn-success col-sm-8" id="submitButton">
								</div>
							</form>
                        </div>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>
	<Script src="cplcredits.js"></Script>
	<script src="../jquery-ui.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
