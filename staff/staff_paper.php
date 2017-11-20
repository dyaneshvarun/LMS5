<?php
	require_once("../arc/dbconnect.php");
	require_once("functions.php");
	if(!isset($_SESSION['STA_ID'])){
		header("Location:login.php");
	}
	$sta_id = $_SESSION['STA_ID'];
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

</head>

<body>
<?php require_once("header.php");?>
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">STAFF PERIOD ALLOCATION</h1><br>
                        <div class="col-sm-8">
							<form method="POST" role="form" class="form-horizontal" id="fsub">
								<div class="form-group">
									<label class="control-label col-sm-3" for="lt">Class ID : </label>
									<div class="col-sm-9">
										<select class="form-control" id="lt">
											<option value="none" selected>---</option>
											<?php
												$sql = "select class_name from class";
												$rs = mysqli_query($conn,$sql);
												while($row = mysqli_fetch_assoc($rs))
												{
													echo "<option value='".$row['class_name']."'>".$row['class_name']."</option>";
												}
												
											?>
										</select>
									</div>
								</div>
							<div class="form-group">
									<label class="control-label col-sm-3" for="lt">Day Order : </label>
									<div class="col-sm-9">
										<select class="form-control" id="lt">
											<option value="none" selected>---</option>
											<option value="1">DayOrder 1 </option>
											<option value="2">DayOrder 2 </option>
											<option value="3">DayOrder 3 </option>
											<option value="4">DayOrder 4 </option>
											<option value="5">DayOrder 5 </option>
										</select>
									</div>
								</div>
							
						
								<br>
								<div class="form-group" id="nodgp">
									<label class="control-label col-sm-3" for="nod">Hour Allocaion : </label>
									<div class="col-sm-9">
										<table class="table table-bordered">
											<tr>
												<th>Hour</th>
												<th>Paper</th>
												<th>Staff</th>
											</tr>
													
											<?php
											$i =0;
											for($i=0;$i<8;$i++)
											{
												echo "<tr>";
												echo "<td> ". ($i+1) ."</td>";
												echo "<td><select class='form-control'>";
												echo "<option value ='' selected></option>";
												$sql = "select paper_name from paper";
												$rs = mysqli_query($conn,$sql);
												while($row = mysqli_fetch_assoc($rs))
												{
													echo "<option value='".$row['paper_name']."'>".$row['paper_name']."</option>";
												}
												echo "</select>
												</td>
												<td><select class='form-control'>";
												echo "<option value ='' selected></option>";
												$sql = "select staff_name from staff";
												$rs = mysqli_query($conn,$sql);
												while($row = mysqli_fetch_assoc($rs))
												{
													echo "<option value='".$row['staff_name']."'>".$row['staff_name']."</option>";
												}		
												echo "</select>
												</td>";
											}
											?>
											
										</table>
									</div>
								</div>
							<br>
								<div class="form-group">
									<div class="col-sm-offset-5">
										<button class="btn btn-primary" type="submit" value="Save & Duty Arrangement"> Submit</button>
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
	<Script src="cl.js"></Script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
	<script src="staff_paper.js"></script>
	

</body>

</html>
