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
	$credits = $row['CPL'];
	$sql="SELECT * FROM COMPENSATION_LEAVE_DAYS WHERE STAFF_ID=$sta_id ORDER BY CDATE DESC";
	$rs1 = mysqli_query($conn,$sql);
	$sql = "CALL GET_STAFF($sta_id)";
	$rs = mysqli_query($conn,$sql);
	if(!$row = mysqli_fetch_assoc($rs)){
		echo mysqli_error($conn);
	}
	$staff_info = $row;
	mysqli_close($conn);
	
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
                        <h1 class="page-header">Your CPL Credits</h1><br>
                        <div class="col-lg-12">
							<div class="panel panel-primary">
								<div class="panel-heading">CPL Details</div>
								<div class="panel-body">
								CPL Credits Available : <?php echo $credits?>
								<!--br/>Date from which valid : <?php //echo $NinetyDaysBefore ?> -->
								</div>
							</div>
							<table class="table table-hover">
								<tr><th>S.No</th>
								<th>Leave Date</th>
								<th>Valid till</th>
								<th>Reason</th>
								<th>Apply Date</th>
								<th>Status</th>
								<th class="col-lg-2">Utilized for Leave ID</th></tr>
								<?php
									$i=0;
									$DaysCount = 24*3600*180; //180 days
									while($row = mysqli_fetch_assoc($rs1)){
										$stat = "";
										$clas = "";$leaveID="";
										if($row['STATUS'] == 0){
											$stat = "Waiting";
											$clas = "warning";
										}
										else if($row['STATUS'] == 1){
											$stat = "+1 Accepted";
											$clas = "success";
										}
										else if($row['STATUS'] == 2){
											$stat = "Rejected";
											$clas = "danger";
										}
										else if($row['STATUS'] == 3){
											$stat = "Utilized";
											$clas = "info";
											$leaveID ="<a href='view_leave.php?lid=".$row['LEAVE_ID']."'>$row[LEAVE_ID]</a>";
										}
										if($row['CDATE']<$NinetyDaysBefore && $row['STATUS']==1) 
										{
											$stat= " - Date Expired";
											$clas= "danger";
										}
										echo "<tr class=$clas>";
										$i=$i+1;
										$validity = date('d-m-Y',strtotime($row['CDATE']) + $DaysCount);
										echo "<td>$i</td>";
										echo "<td>".date('d-m-Y',strtotime($row['CDATE']) )."</td>";
										echo "<td>$validity</td>";
										echo "<td>$row[REASON]</td>";
										echo "<td>".date('d-m-Y',strtotime($row[APPLY_DATE]))."</td>";
										echo "<td>$stat</td>";
										echo "<td>$leaveID</td>";
										echo "</tr>";
									}
								?>
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
	<Script src="cplcredits.js"></Script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
