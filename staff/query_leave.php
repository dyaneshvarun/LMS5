<?php
	session_start();
	if(!$sta_id = $_SESSION['STA_ID']){
		header("Location:login.php");
		return;
	}
	require_once("../arc/dbconnect.php");
	require_once("functions.php");
	/*$memcache = new Memcache;
	if(!$cacheAvailable = $memcache->connect("127.0.0.1","11211")){
		echo "Memcaching Failed. Contact Administrator Immediately";
	}
	$key = "STAFF_INFO_".$sta_id;
	if(!$staff_info = $memcache->get($key)){
		echo "Staff Cached";
		header("Location:login.php");
	}*/
	$sql = "CALL GET_STAFF($sta_id)";
	$rs = mysqli_query($conn,$sql);
	if(!$row = mysqli_fetch_assoc($rs)){
		echo mysqli_error($conn);
	}
	$staff_info = $row;
	mysqli_close($conn);
	$conn = mysqli_connect($hostname,$username,$password,$database);
	//$key = "STAFF_LEAVE_".$sta_id;
	//if(!$staffLeave = $memcache->get($key)){
	$rows = getStaffLeave($conn,$sta_id);
	//	$memcache->set($key,$rows,MEMCACHE_COMPRESSED,1000);
	//}
	$staffLeave = $rows;
	
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
                        <h1 class="page-header">Search Leave</h1><br>
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
									<label class="control-label col-sm-3" for="date1">From Date : </label>
									<div class="col-sm-9">
										<input type="input" class="form-control" id="date1">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-3" for="date1">To Date : </label>
									<div class="col-sm-9">
										<input type="input" class="form-control" id="date2">
									</div>
								</div>
								<br><br>
								<div class="form-group">
									<div class="col-sm-offset-5">
										<button class="btn btn-primary" type="submit" value="Save & Duty Arrangement"> Search Leaves</button>
									</div>
								</div><br><br>
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
	<Script src="cl.js"></Script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
