<?php
	//session_start();
	require_once("../arc/dbconnect.php");
	require_once("functions.php");
	if(!isset($_SESSION['STA_ID'])){
		header("Location:login.php");
	}
	$sta_id = $_SESSION['STA_ID'];
	$sql = "CALL AWAITING_RESPONSE()";
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
	<link href="loadingcss.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

</head>

<body>
<?php require_once("header.php");?>
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Awaiting Reponse List</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
					<input type="button" class="btn btn-success" value="All" id="buttonAll">
					<input type="button" class="btn btn-info" value="Teaching" id="buttonT">
					<input type="button" class="btn btn-info" value="Non Teaching" id="buttonNT">
					<input type="button" class="btn btn-info" value="Research Scholors" id="buttonRS">
					<div class="col-lg-12">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Leave ID</th>
									<th>Staff Name</th>
									<th>Category</th>
									<th>Leave Type</th>
									<th>From Date</th>
									<th>To Date</th>
									<th>No. of Days</th>
									<th>Accept</th>
									<th>Reject</th>
									<th>None</th>
								</tr>
							</thead>
							<form method="POST" id="fsub">
							<tbody><?php
								if(mysqli_num_rows($rs)==0) {echo'<script>alert("No awaiting Responses");window.location.replace("index.php");</script>';}
								while($row = mysqli_fetch_assoc($rs)){
							?>		<tr class="leaves">
										<!--td ><a class="lid" href="view_leave.php?lid=<?php echo $row['LEAVE_ID']; ?>" /><?php echo $row['LEAVE_ID']; ?></td-->
										<td ><a class="lid" onclick="getData(<?php echo $row['LEAVE_ID']; ?>)" /><?php echo $row['LEAVE_ID']; ?></td>
										<!--td ><a class="lid" data-toggle="modal" data-target="#exampleModalLong" /><?php echo $row['LEAVE_ID']; ?></td-->
										<td><?php echo $row['STAFF_NAME']; ?></td>
										<td id="sid"><?php echo $row['STAFF_ID']; ?></td>
										<td><?php echo $row['LEAVE_TYPE']; ?></td>
										<td><?php echo $row['FR_DATE']; ?></td>
										<td><?php echo $row['TO_DATE']; ?></td>
										<td><?php echo $row['NOD']; ?></td>
										<td id="a"><input type="radio" class="leavestat" value="ACCEPT" id="<?php echo $row['LEAVE_ID']; ?>" name="<?php echo $row['LEAVE_ID']; ?>" ></td>
										<td id="r"><input type="radio" class="leavestat" value="REJECT" id="<?php echo $row['LEAVE_ID']; ?>" name="<?php echo $row['LEAVE_ID']; ?>"></td>
										<td><input type="radio" class="leavestat" value="N" id="<?php echo $row['LEAVE_ID']; ?>" name="<?php echo $row['LEAVE_ID']; ?>" checked></td>
									</tr>
							<?php } ?>
							</tbody>
						</table>
						<input type="button" value="Check all Accept Radio Buttons" class="btn btn-info" id="caarb">
						<input type="button" value="Check all Reject Radio Buttons" class="btn btn-info" id="carrb">
						<button type="submit" class="btn btn-success">Submit</button>
						</form>
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
    <script src="awaiting_response1.js" type="text/javascript"></script>
	
    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
	<script src="loadingjs.js" type="text/javascript"></script>

</body>
<!-- Modal testing-->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" >
  <div class="modal-dialog" role="document" style="width:70%">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><b>Leave Details</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!---Content-->
			<table class="table table-hover">
				<tr><td>Reason</td><td id="mreason"></td></tr>
				<tr><td>Address</td><td id="maddress"></td></tr>
				<tr><td>File *</td><td id="mfile"></td></tr>
				<tr><td>Apply Date</td><td id="mad"></td></tr>
			</table>
			<div id="reschedule">
			</div>
		 * (if applicable)
		<!--Content gets over-->
      </div>
      <div class="modal-footer">
	    
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</html>

