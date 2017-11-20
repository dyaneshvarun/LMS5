<?php
	//session_start();

	require_once("../arc/dbconnect.php");
	require_once("functions.php");
	
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
	<script src="../jquery-ui.js"></script>
	<link rel="stylesheet" href="../jquery-ui.css">
    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

</head>

<body>
<?php require_once("header.php");?>
        <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
			<h1 class="page-header">Reports</h1><br>
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
									<select name ="sid" class="form-control "id="staffid"  >
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
							<div class="col-sm-3">
							</div>
							<div class="col-sm-4">
								<input type='submit' class='btn btn-success col-sm-12' value='Submit' id='submitButton'>
							</div>
							<div class="col-sm-1">
							</div>
							<div class="col-sm-4">
								<input type='button' value='Clear' class='col-sm-12 btn btn-danger' id='clearButton'>
							</div>
					</div>
					
				</form>
            </div>
		</div>
		<div class="container-fluid">
            <div class="panel-body">
                            <div class="panel-group" id="accordion">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#casualLeave">Casual Leave</a>
                                        </h4>
                                    </div>
                                    <div id="casualLeave" class="panel-collapse collapse in">
                                        <div class="panel-body" id='output1'>
											Please select a date.
                                        </div>
									</div>
                                </div>
                                <div class="panel panel-warning">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#RH">Restricted Holiday</a>
                                        </h4>
                                    </div>
                                    <div id="RH" class="panel-collapse collapse">
                                        <div class="panel-body" id='output2'>
												Please select the dates.
										</div>
                                    </div>
                                </div>
                                <div class="panel panel-danger">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#SCL" color='white'>Special Casual Leave</a>
                                        </h4>
                                    </div>
                                    <div id="SCL" class="panel-collapse collapse">
                                        <div class="panel-body" id='output3'>
                                            Please Select the Dates.
                                        </div>
                                    </div>
                                </div>
								<div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#OD">On Duty</a>
                                        </h4>
                                    </div>
                                    <div id="OD" class="panel-collapse collapse">
                                        <div class="panel-body" id='output4'>
                                            Please Select the Dates.
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-warning">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#ML">Medical Leave</a>
                                        </h4>
                                    </div>
                                    <div id="ML" class="panel-collapse collapse">
                                        <div class="panel-body" id='output5'>
										Please Select the Dates.
										</div>
                                    </div>
                                </div>
                                <div class="panel panel-danger">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#EL">Earned Leave</a>
                                        </h4>
                                    </div>
                                    <div id="EL" class="panel-collapse collapse">
                                        <div class="panel-body" id='output6' >
                                            Please Select the Dates.
									</div>
                                    </div>
                                </div>
                            </div>
						</div>
                        <!-- .panel-body -->    
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

</body>

</html>
