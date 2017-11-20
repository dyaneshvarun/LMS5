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
	<Script src="staffperiodicRep1.js"></Script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.debug.js"></script>
	<script src = 'printReport.js'> 
	
</script> 
</head>

<body>
<?php require_once("header.php");?>
        
		<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Staff Wise Periodic Report</h1>
                </div>

            </div>
			<div class="col-sm-8">
				<form method="POST" role="form" class="form-horizontal" action='staffwiseperiodicRep1.php' id="fsub">
           			<div class="form-group" id="nodgp">
						<label class="control-label col-sm-3" for="from">From: </label>
							<div class="col-sm-9">
								<input type='input' class='form-control datepickee datepickf' id='fdate' required >
							</div>
					</div>
					<div class="form-group" id="nodgp">
						<label class="control-label col-sm-3" for="to">To : </label>
							<div class="col-sm-9">
								<input type='input' class='form-control datepickee datepickf' id='tdate' required >
							</div>
					</div>
					<div class="form-group" id="nodgp">
					             
									<label class="control-label col-sm-3" for="nod">Staff id & name:</label>
									<div class="col-sm-9">
									<select name ="sid" class="form-control "id="staffid" >
										<?php 
											$sql = "SELECT STAFF_ID,STAFF_NAME FROM staff";
											$result = $conn->query($sql);
											if ($result->num_rows > 0) {
												while($row = $result->fetch_assoc()) {
													echo "<option id=".$row['STAFF_ID']." value ='".$row['STAFF_ID']."'>".$row['STAFF_ID']."--".$row['STAFF_NAME']."</option>"; 
												}
											} else {
													echo "Error. Please Check.";
											}
										?>
									</select>
								</div>
									
								</div>
					<div class="form-group" id="nodgp">
							
							<div class="col-sm-4">
								<input type='submit' class='btn btn-success col-sm-12' value='Submit' id='submitButton'>
							</div>
							<div class="col-sm-4">
								<input type='button' class='btn btn-success col-sm-12' value='Submit' id='fsubb'>
							</div>
							<div class="col-sm-4">
								<input type='button' value='Clear' class='col-sm-12 btn btn-danger' id='clearButton'>
							</div>
					</div>
						<div class="form-group" id="output1"></div>
				</form>
            
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

</body>

</html>
