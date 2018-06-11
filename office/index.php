<?php
	session_start();
	error_reporting(E_ERROR | E_PARSE);
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
    $sql = "SELECT COUNT(*) C from compensation_leave_days cld,staff where staff.staff_id = cld.staff_id and cld.status=0 order by APPLY_DATE";
	if(!$rs = mysqli_query($conn,$sql)){
		Die (mysqli_error($conn));
	}
	$rows1 = mysqli_fetch_assoc($rs);
	$cplReviews = $rows1['C'];
    $declined = 0;
	$sql="SELECT * FROM STAFF_LEAVE WHERE STAFF_LEAVE.STATUS=2";
	if(!$rs = mysqli_query($conn,$sql)){
		Die (mysqli_error($conn));
	}
	else{
		$declined = mysqli_num_rows($rs);
	}
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
	$sql = "CALL AWAITING_RESPONSE()";
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

    <title>Office Dashboard | IST Leave System</title>

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
                    <h1 class="page-header">Office Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
                
				
                
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-search fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo "#"; ?></div>
                                    <div>Accepted Response</div>
                                </div>
                            </div>
                        </div>
                        <a href="periodicRep.php">
                            <div class="panel-footer">
                                <span class="pull-left">Accepted Leave List</span>
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
                                    <i class="fa fa-star-half-full fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $cplReviews; ?></div>
                                    <div>CPL </div>
                                </div>
                            </div>
                        </div>
                        <a href="compensation.php">
                            <div class="panel-footer">
                                <span class="pull-left">Credits Response</span>
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
                                    <i class="fa fa-search fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">#</div>
                                    <div>Leaves </div>
                                </div>
                            </div>
                        </div>
                        <a href="leavelist.php">
                            <div class="panel-footer">
                                <span class="pull-left">Leave List</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            <div class="col-lg-12">
                <div class="col-lg-7">
                </div>
                <!-- /.col-lg-8 -->
                <!--div class="col-lg-5">
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
				</div-->
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
