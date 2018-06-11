<?php
	//session_start();
	require_once("../arc/dbconnect.php");
	require_once("functions.php");
	if(!isset($_SESSION['STA_ID'])){
		header("Location:login.php");
	}
	$sta_id = $_SESSION['STA_ID'];
	if(!isset($_GET['lid'])){
		echo "Please Supply a valid Leave ID";
		exit();
	}
	$lid = $_GET['lid'];
	$sql = "SELECT * FROM STAFF_LEAVE WHERE LEAVE_ID = $lid";
	if(!$res = mysqli_query($conn,$sql)){
		Die(mysqli_error($conn));
	}
	$row = mysqli_fetch_assoc($res);
	
	$sql = "SELECT * FROM STAFF_PERIOD_ALLOCATION WHERE LEAVE_ID IN (SELECT SLDID FROM `STAFF_LEAVE_DAYS` WHERE LEAVE_ID = $lid)";
	if(!$res1 = mysqli_query($conn,$sql)){
		Die(mysqli_error($conn));
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
                    <div class=" col-lg-offset-2 col-lg-8">
                        <h1 class="page-header">Leave List</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
					
                <div class="row">
					<div class="col-lg-offset-2 col-lg-8">
						<h3>Leave Information</h3>
						<table class="table">
							<tr>
								<td>Leave ID :</td>
								<td><?php echo $row['LEAVE_ID']; ?></td>
							</tr>
							<tr>
								<td>From Date : </td>
								<td><?php echo $row['FR_DATE']; ?></td>
							</tr>
							<tr>
								<td>To Date : </td>
								<td><?php echo $row['TO_DATE']; ?></td>
							</tr>
							<tr>
								<td>No of Days : </td>
								<td><?php echo $row['NOD']; ?></td>
							</tr>
							<tr>
								<td>Leave Type : </td>
								<td><?php echo $row['LEAVE_TYPE']; ?></td>
							</tr>
							<tr>
								<td>Applied Date : </td>
								<td><?php echo $row['APPLY_DATE']; ?></td>
							</tr>
							<?php if($row['LEAVE_TYPE'] == "SCL" || $row['LEAVE_TYPE'] =="OD")
							{
							echo "<tr>
								<td>Attached File : </td>
								<td><a href=../staff/uploads/$row[FILENAME]><button class='btn btn-success' >FILE</button></a></td>
							</tr>" ;
							}
							?>
						</table>
						<h3>Alternate Staffs</h3><br>
						<table class="table">
							<thead>
								<th>Date</th>
								<th>Hour</th>
								<th>Class</th>
								<th>Staff Name</th>
								<th>Status</th>
							</thead>
							<tbody>
							<?php
								while($row1 = mysqli_fetch_assoc($res1)){
									if($row1['STATUS'] == 0){
										$stat = "Waiting";
										$clas = "warning";
									}
									else if($row1['STATUS'] == 1){
										$stat = "Accepted";
										$clas = "success";
									}
									else if($row1['STATUS'] == 2){
										$stat = "Rejected";
										$clas = "danger";
									}
									echo"<tr class='".$clas."'>";
									echo "<td>".$row1['ALTER_DATE']."</td>";
									echo "<td>".$row1['HOUR']."</td>";
									$sql2="SELECT CLASS_NAME from CLASS where CLASS_ID =".$row1['CLASS_ID'];
									$res2=mysqli_query($conn,$sql2);
									$row2 = mysqli_fetch_assoc($res2);
									echo "<td>".$row2['CLASS_NAME']."</td>";
									$sql2="SELECT STAFF_NAME from STAFF where STAFF_ID =".$row1['ALTER_STAFF_ID'];
									$res3=mysqli_query($conn,$sql2);
									$row3 = mysqli_fetch_assoc($res3);
									echo "<td>".$row3['STAFF_NAME']."</td>";
									echo "<td>".$stat."</td>";
									echo "</tr>";
								}
							?>
							
						</table>
						<div>
						<!--?php
							if($row['LEAVE_TYPE']=="CL") $x = "tablePdfCL.php";
							else if($row['LEAVE_TYPE']=="RH") $x = "tablePdfCL.php";
							else if($row['LEAVE_TYPE']=="SCL") $x = "tablePdfCL.php";
							else if($row['LEAVE_TYPE']=="ML") $x = "tablePdfML.php";
							else if($row['LEAVE_TYPE']=="EL") $x = "tablePdfML.php";
							else if($row['LEAVE_TYPE']=="OD") $x = "tablePdfOD.php";
							
						?>
						<form method="GET" action="<?php echo $x;?>">
							<input type="hidden" name='LT' value="<?php echo $row['LEAVE_TYPE']?>"> 
							<input type="hidden" name='LID' value="<?php echo $row['LEAVE_ID']?>"> 
							<input class= "form-control btn btn-success"type="submit" value="GET PDF">
						</form-->
					</div>
					</div>
					
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


