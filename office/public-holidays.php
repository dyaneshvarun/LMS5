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
	if(!$staff_info = $memcache->get($key)){
		header("Location:login.php");
		
	}*/
    
    
	$leave_count = 0;
	//echo $cacheAvailable;
	$sql = "SELECT * 
			FROM STAFF S, STAFF_LEAVE SL, STAFF_LEAVE_DAYS LD
			WHERE LEAVE_DATE =  '2016-03-29'
			AND SL.LEAVE_ID = LD.LEAVE_ID
			AND S.STAFF_ID = SL.STAFF_ID AND LD.STATUS = 2";
	if(!$rs = mysqli_query($conn,$sql)){
		Die (mysqli_error($conn));
	}
	else{
		$leave_count = mysqli_num_rows($rs);
	}
	$sql = "SELECT * FROM STAFF_LEAVE WHERE STATUS = 0";
	if(!$rs = mysqli_query($conn,$sql)){
		Die (mysqli_error($conn));
	}
	else{
		$ar_count = mysqli_num_rows($rs);
	}
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

    <title>Admin Dashboard | IST Leave System</title>

    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

    <!-- MetisMenu CSS -->
    <!--link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="../dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <!--link href="../bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>
	<Script src="public-holidays.js"></Script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <!--script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</head>

<body>
<?php require_once("header.php");?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Public Holidays</h1>
                </div>
                <!-- /.col-lg-12 -->
            
			<div class="col-sm-8">
				<form method="POST" role="form" class="form-horizontal" id="fsub">
           			<div class="form-group" id="nodgp">
						<label class="control-label col-sm-3" for="year">Year : </label>
							<div class="col-sm-9">
								<input type="year" class="form-control" id="year">
							</div>
					</div>
					<div class="form-group" id="nodgp">
						<label class="control-label col-sm-3" for="nod">No of days : </label>
							<div class="col-sm-9">
								<input type="number" min=1 max=50 class="form-control" id="nod">
							</div>
					</div>
					<div class="form-group" id="nodgp">
									<label class="control-label col-sm-3" for="nod">Date Information </label>
									<div class="col-sm-9">
										<table class="table table-bordered" id="datetab">
											<thead>
												<tr>
													<th>Date</th>
													<th>Purpose Of Holiday</th>
												</tr>
											</thead>
											<tbody>
												
											</tbody>
										</table>
									</div>
									
					</div>
					
				</form>
				
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

</body>

</html>
