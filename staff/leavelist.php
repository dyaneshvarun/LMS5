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
	$key = "STAFF_INFO_".$sta_id;*/
	if(!$staff_info = $memcache->get($key)){
		echo "Staff Cached";
		header("Location:login.php");
	}
	$key = "STAFF_LEAVE_".$sta_id;
	if(!$staffLeave = $memcache->get($key)){
		$rows = getStaffLeave($conn,$sta_id);
		$memcache->set($key,$rows,MEMCACHE_COMPRESSED,1000);
	}
	$sql = "SELECT * FROM STAFF_LEAVE WHERE STAFF_ID = $sta_id";
	$res = mysqli_query($conn, $sql);
	
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
                        <h1 class="page-header">View Leave List</h1><br>
                        <div class="col-sm-8">
							<table class="table table-hover">
							<thead>
								<tr>
									<th>Leave ID</th>
									<th>Staff ID</th>
									<th>Staff Name</th>
									<th>Leave Type</th>
									<th>No. of Days</th>
									<th>Status</th>
								</tr>
							</thead>
							<form method="POST" id="fsub">
							<tbody><?php
								while($row = mysqli_fetch_assoc($res)){
									if($row['STATUS'] == 1){
										$cla = "success";
									}
									else if($row['STATUS'] == 2){
										$cla = 'danger';
									}
							?>		<tr class='<?php echo $cla; ?>'>
										<td><a href="view_leave.php?lid=<?php echo $row['LEAVE_ID']; ?>" /><?php echo $row['LEAVE_ID']; ?></td>
										<td><?php echo $row['STAFF_ID']; ?></td>
										<td><?php echo $row['STAFF_NAME']; ?></td>
										<td><?php echo $row['LEAVE_TYPE']; ?></td>
										<td><?php echo $row['NOD']; ?></td>
										<td><?php if($row['STATUS'] == 1) echo 'ACCEPTED';
													else if ($row['STATUS'] == 2) echo 'REJECTED';
													else echo 'AWAITING';
											?></td>
									</tr>
							<?php } ?>
							</tbody>
						</table>
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
