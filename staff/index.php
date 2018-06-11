<?php
	session_start();
	require_once("../arc/dbconnect.php");
	require_once("functions.php");
	if(!isset($_SESSION['STA_ID'])){
		header("Location:login.php");
	}
	function checkLevel($val){
		if($val <= 50){
			return " progress-bar-success";
		}else if($val >50 && $val <=75){
			return " progress-bar-warning";
		}
		else{
			return " progress-bar-danger";
		}
	}
	$sta_id = $_SESSION['STA_ID'];
	$sql = "CALL GET_STAFF($sta_id)";
    $rs = mysqli_query($conn,$sql);
    if(!$row = mysqli_fetch_assoc($rs)){
        echo mysqli_error($conn);
    }
    $staff_info = $row;
	$leaveType = array();
    mysqli_close($conn);
    $conn = mysqli_connect($hostname,$username,$password,$database);
	$rows = getLeaveType($conn);
	$leaveType = $rows;
	if($staff_info['CATEGORY']=="RT" || $staff_info['CATEGORY']=="RNT" )
		$cl = $leaveType[0];
	if($staff_info['CATEGORY']=="TF" )
		$cl = $leaveType[9];
	if($staff_info['CATEGORY']=="RS20" )
		$cl = $leaveType[8];
	if($staff_info['CATEGORY']=="RS30" || $staff_info['CATEGORY']=="RSO")
		$cl = $leaveType[7];
	$rh = $leaveType[5];
	$scl = $leaveType[6];
	$staffLeave = array();
	$rows = getStaffLeave($conn,$sta_id);
	$staffLeave = $rows;
	$s_cl=0;$s_rh =0;$s_scl=0;
	foreach($staffLeave as $row){
		if($row['LEAVE_TYPE'] == 'CL' && $staff_info["CATEGORY"]=="RT")
			$s_cl = $row['NOD'];
		else if($row['LEAVE_TYPE'] == 'CL' && $staff_info["CATEGORY"]=="RNT")
			$s_cl = $row['NOD'];
		else if($row['LEAVE_TYPE'] == 'CL6' && $staff_info["CATEGORY"]=="TF")
			$s_cl = $row['NOD'];
		else if($row['LEAVE_TYPE'] == 'CL20' && $staff_info["CATEGORY"]=="RS20")
			$s_cl = $row['NOD'];
		else if($row['LEAVE_TYPE'] == 'CL30' && $staff_info["CATEGORY"]=="RS30")
			$s_cl = $row['NOD'];
		//OT and NT remaining
		if($row['LEAVE_TYPE'] == 'RH')
			$s_rh = $row['NOD'];
		if($row['LEAVE_TYPE'] == 'SCL')
			$s_scl = $row['NOD'];
	}
	$clper = ($s_cl / $cl['NOD'])*100;
	$rhper = ($s_rh / $rh['NOD'])*100;
	$sclper = ($s_scl / $scl['NOD'])*100;
	$sql = "SELECT COUNT(*) C FROM STAFF_LEAVE WHERE STAFF_ID = $sta_id";


    //CHANGED CODE
    $sessql=mysqli_query($conn,"SELECT STAFF_NAME FROM STAFF WHERE STAFF_ID='$sta_id'");
    $sessrow=mysqli_fetch_array($sessql,MYSQLI_ASSOC);
    $loginsession=$sessrow['STAFF_NAME'];


    //CHANGED CODE ENDS
	if(!$res1 = mysqli_query($conn,$sql)){
		mysqli_error($conn);
	}
	$rows1 = mysqli_fetch_array($res1);
	$ltcount = $rows1['C'];
	$sql = "SELECT * FROM STAFF_PERIOD_ALLOCATION WHERE ALTER_STAFF_ID = $sta_id AND STATUS = 0";
	if(!$res1 = mysqli_query($conn,$sql)){
		mysqli_error($conn);
	}
	$arcount = mysqli_num_rows($res1);
	$sql = "SELECT * FROM STAFF_PERIOD_ALLOCATION WHERE ALTER_STAFF_ID = $sta_id AND (STATUS = 2 or STATUS =1) ";
	//$sql = "SELECT LEAVE_ID FROM STAFF_LEAVE WHERE STAFF_ID = $sta_id AND STATUS = 2";
	if(!$res1 = mysqli_query($conn,$sql)){
		mysqli_error($conn);
	}
	$dlcount = mysqli_num_rows($res1);
	$sql = "SELECT STAFF_NAME AS SN FROM STAFF WHERE STAFF_ID = ".$sta_id;
	if(!$res1 = mysqli_query($conn,$sql)){
		mysqli_error($conn);
	}
	while($sn = mysqli_fetch_assoc($res1))
	{
		$name = $sn['SN'];
	};
	
	$datetime = new DateTime(null, new DateTimeZone('IST'));
	$datetime->modify('-180 days');
	$NinetyDaysBefore = $datetime->format('Y-m-d');
	$sql = "SELECT COUNT(*) AS CPL from COMPENSATION_LEAVE_DAYS WHERE STATUS = 1 AND STAFF_ID=$sta_id AND CDATE>'$NinetyDaysBefore'";
	$rs = mysqli_query($conn,$sql);
	if(!$row = mysqli_fetch_assoc($rs)){
		echo mysqli_error($conn);
	}
	$credits = $row;
?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Staff Dashboard | IST Leave System  </title>

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
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Staff Dashboard</h1>
					<h3> Welcome ,  <?php echo $name; ?></h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"> <?php echo $credits['CPL']?></div>
                                    <div>CPL</div>
                                </div>
                            </div>
                        </div>
                        <a href="cplview.php">
                            <div class="panel-footer">
                                <span class="pull-left">CPL Credits</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $ltcount; ?></div>
                                    <div>View Leaves</div>
                                </div>
                            </div>
                        </div>
                        <a href="leave.php">
                            <div class="panel-footer">
                                <span class="pull-left">Leave Status</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-shopping-cart fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $arcount; ?></div>
                                    <div>Awaiting Alterations</div>
                                </div>
                            </div>
                        </div>
                        <a href="awaiting_response.php">
                            <div class="panel-footer">
                                <span class="pull-left">Alterations given to me</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-support fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $dlcount; ?></div>
                                    <div>Compensations</div>
                                </div>
                            </div>
                        </div>
                        <a href="acceptedAlter.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-7">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Leave Availability
                        </div>
                        <div class="panel-body">
							<h4>Casual Leave (CL)</h4>
							<div class="progress progress-striped">
								<div class="progress-bar <?php echo checkLevel($clper);?>" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo 100-(($s_cl / $cl['NOD'])*100);?>%">
									<span> <?php echo ($cl['NOD']-$s_cl) . " / " . $cl['NOD'];
										?></span>
                                </div>
								
                            </div>
							<?php if($staff_info['CATEGORY']=="RT" || $staff_info['CATEGORY']=="RNT")
							{
							echo "<h4>Restricted Holiday (RH)</h4><div class='progress progress-striped'>
								<div class='progress-bar ". checkLevel($rhper)."' role='progressbar' aria-valuenow='60' aria-valuemin='0' aria-valuemax='100' style='width:". (100-(($s_rh / $rh['NOD'])*100))."%;'><span>".($rh['NOD']-$s_rh) . " / " . $rh['NOD']."</span> </div></div>";
								echo "<h4>Special Casual Holiday (RH)</h4><div class='progress progress-striped'>
								<div class='progress-bar ". checkLevel($sclper)."' role='progressbar ' aria-valuenow='60' aria-valuemin='0' aria-valuemax='100' style='width:". (100-(($s_scl / $scl['NOD'])*100))."%;'><span>".($scl['NOD']-$s_scl) . " / " . $scl['NOD']."</span> </div></div>";
							}
                               
							?>
                        </div>
                    </div>
                </div>
                <!-- /.col-lg-8 -->
                <div class="col-lg-5">
					<div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Last Login
                        </div>
                        <div class="panel-body">
							<div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>IP Address</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php 
												$sql = "CALL GET_LOGININFO('$staff_info[EMAILID]')";
												$rs = mysqli_query($conn,$sql);
												while($row = mysqli_fetch_assoc($rs)){
										?>
													<tr class="<?php if($row['STATUS'] == "SUCCESS") echo 'success'; else echo 'danger'; ?>">
														<td><?php echo $row['TIME'];?></td>
														<td><?php echo $row['IPADDR'];?></td>
														<td><?php echo strtolower($row['STATUS']);?></td>
													</tr>
										<?php } ?>                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
				</div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
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

    <!-- Morris Charts JavaScript -->
    <!-- <script src="../bower_components/raphael/raphael-min.js"></script>
    <script src="../bower_components/morrisjs/morris.min.js"></script>
    <script src="../js/morris-data.js"></script> -->

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
