<?php
	session_start();
    require_once("../arc/dbconnect.php");
	require_once("functions.php");
	if(!$sta_id = $_SESSION['STA_ID']){
		header("Location:login.php");
		return;
	}
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
	<style>
		.modal {
			display:    none;
			position:   fixed;
			z-index:    1000;
			top:        0;
			left:       0;
			height:     100%;
			width:      100%;
			background: rgba( 255, 255, 255, .8 ) 
						url('ajax-loader.gif') 
						50% 50% 
						no-repeat;
		}
		.modal-content {
			background-color: #fefefe;
			margin: 15% auto; /* 15% from the top and centered */
			padding: 20px;
			border: 1px solid #888;
			width: 80%; /* Could be more or less, depending on screen size */
		}
		body.loading {
			overflow: hidden;  
		}
		body.loading .modal {
			display: block;
		}
	</style>
    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../jquery-ui.css">

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
                        <h1 class="page-header">Half Day Leave Application</h1><br>
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
									<label class="control-label col-sm-3" for="lt">Leave Type : </label>
									<div class="col-sm-9">
										<select class="form-control" id="lt" disabled>
											<option value="none" >---</option>
											<option value="cl" id="lt1" selected >Casual Holiday</option>
										</select>
									</div>
								</div>
								
								<div class="form-group" id = 'hideme'>
									<div class="col-sm-3"h4>Leave Statistics</h4></div>
									<label class="control-label col-sm-2" for="name">Availed : </label>
									<div class="col-sm-2">
										<input type="input" class="form-control" id="tot" value="0" disabled>
									</div>
									<label class="control-label col-sm-2" for="name">Balance : </label>
									<div class="col-sm-2">
										<input type="input" class="form-control" id="bal" value="0" disabled>
									</div>
								</div>
								<div class="form-group" id="nodgp">
									<label class="control-label col-sm-3" for="nod">No of days : </label>
									<div class="col-sm-9">
										<input type="input" class="form-control" value='0.5' id="nod" disabled>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-3" for="name">Session : </label>
									<div class="col-sm-9">
									<select name="session" id = 'session' class="form-control">
										<option value="FN" >Forenoon </option>
										<option value="AN" >Afternoon </option>
										</select>
										</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-3" for="date1">Date : </label>
									<div class="col-sm-9">
										<input type="input" class="form-control" id="date1">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-3" for="vacation">Vacation : </label>
									<div class="col-sm-9">
										<input type="checkbox" class="checkbox col-lg-1" id="vacation" >
									</div>
								</div>
								<div class="form-group" id="altertitle1">
									<label class="control-label col-sm-offset-2 col-sm-8" for="date1" id='head1'><h3>Duty Alteration </h3></label>
								</div>
								<br>
								
								<div class="form-group">
									<label class="control-label col-sm-3" for="res">Reason : </label>
									<div class="col-sm-9">
										<input type="input" class="form-control" id="res" >
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-5" for="addr">If. Permission is required to go out of station furnish details with Address for communication : </label>
									<div class="col-sm-7">
										<textarea class="form-control" id="addr" col=10 rows=5 ></textarea>
									</div>
								</div><br>
								<div class="form-group">
									<div class="col-sm-offset-5">
										<button class="btn btn-primary" type="submit" value="Save & Duty Arrangement"> Submit Leave</button>
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
	<Script src="hcl.js"></Script>
	<script src="leaveAccess.js"></script>
	<script src="../jquery-ui.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
	<div class="modal" id="modal">
		<div class="modal-content">
				<center><h2>Please wait....</h2>
				<img src="ajax-loader.gif"></img></center>
				<!-- Place at bottom of page -->
		</div>
	</div>
</body>

</html>
