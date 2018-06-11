<?php
	//session_start();
	require_once("../arc/dbconnect.php");
	require_once("functions.php");
	if(!isset($_SESSION['STA_ID'])){
		header("Location:login.php");
	}
	$sta_id = $_SESSION['STA_ID'];
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
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../jquery-ui.css">
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
    <link href="../dist/css/timeline.css" rel="stylesheet">
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="../bower_components/morrisjs/morris.css" rel="stylesheet">
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>
    <script src="../jquery-ui.js"></script>
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>
    <script src="../dist/js/sb-admin-2.js"></script>
	<script src="labs.js"></script>
</head>

<body>
<?php require_once("header.php");?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Lab Allocation</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
			<div class="col-sm-8">
                            <form >
           			<div class="form-group" id="nodgp">
						<label class="control-label col-sm-3" for="Class">Class </label>
							<div class="col-sm-9">
								<input list="class" class="form-control" id="classID">
								<datalist id="class"  >
											<option value="none" selected>---</option>
											<?php
												$sql = "select class_name,user_name from CLASS";
												$rs = mysqli_query($conn,$sql);
												while($row = mysqli_fetch_assoc($rs))
												{
													echo "<option value='".$row['user_name']."'>".$row['class_name']."</option>";
												}
												
											?>
								</datalist>
							</div>
					</div>
					<div class="form-group" id="nodgp">
						<label class="control-label col-sm-3" for="Course">Course </label>
							<div class="col-sm-9">
								<input list="labs" class="form-control" id="labsID" name='labsID' >
								<datalist id="labs" >
											<option value="none" selected>---</option>
											<?php
												$sql = "select * from PAPER";
												$rs = mysqli_query($conn,$sql);
												while($row = mysqli_fetch_assoc($rs))
												{
													echo "<option value='".$row['PAPER_CODE']."'>".$row['PAPER_CODE']." - ".$row['PAPER_NAME']."</option>";
												}
												
											?>
								</datalist>
							</div>
					</div>
					
					<br/><br/>
					<div class="form-group col-lg-12" id="nodgp">
							<div class="col-sm-5"></div>
							<div class="col-sm-4">
								<input type="button" value="View" class="form-control btn btn-success" id='submitButton' >
							</div>
					</div>
				</form>
				
        </div>
        <!-- /#page-wrapper -->
		<div id="input" class="col-sm-6">
			<h3>Staff Addition</h3>
			<hr/>
			<div class="col-lg-10 form-inline form-group">
				<label class="col-sm-4">Start Period : </label>
				<input type ="text" class="form-control col-lg-8" id="sp" disabled>
			</div>
			<div class="col-lg-10 form-inline form-group">
				<label class="col-sm-4">End Period : </label>
				<input type ="text" class="form-control col-lg-8" id="ep" disabled>
			</div>
			<div class="col-lg-10 form-inline form-group">
				<label class="col-sm-4">Staff ID : </label>
				<input list="staff21" class="form-control col-lg-8" id="staffI" >
				<datalist id="staff21" >
					<option value="none" selected>---</option>
					<?php
						$sql = "select STAFF_NAME,STAFF_ID from STAFF";
						$rs = mysqli_query($conn,$sql);
						while($row = mysqli_fetch_assoc($rs))
						{
							echo "<option value='".$row['STAFF_ID']."'>".$row['STAFF_NAME']."</option>";
						}
						
					?>
				</datalist>
			</div>
			<div class="col-lg-10 form-inline form-group">
				<label class="col-sm-4">Course ID: </label>
				<input list="labs1" class="form-control col-lg-8" id="courseI" disabled>
				<datalist id="labs1" >
					<option value="none" selected>---</option>
					<?php
						$sql = "select * from PAPER";
						$rs = mysqli_query($conn,$sql);
						while($row = mysqli_fetch_assoc($rs))
						{
							echo "<option value='".$row['PAPER_ID']."'>".$row['PAPER_CODE']." - ".$row['PAPER_NAME']."</option>";
						}
						
					?>
				</datalist>
			</div>
			<div class="col-lg-10 form-inline form-group">
				<label class="col-sm-4">Class ID: </label>
				<input list="class1" class="form-control col-lg-8" id="classI" disabled>
				<datalist id="class1" >
					<option value="none" selected>---</option>
					<?php
						$sql = "select * from CLASS";
						$rs = mysqli_query($conn,$sql);
						while($row = mysqli_fetch_assoc($rs))
						{
							echo "<option value='".$row['CLASS_ID']."'>".$row['CLASS_NAME']."  ".$row['USER_NAME']."</option>";
						}
						
					?>
				</datalist>
			</div>
			<div class="col-lg-10 form-inline form-group">
				<label class="col-sm-4">Day ID: </label>
				<input list="days" class="form-control col-lg-8" id="dayI" disabled>
				<datalist id="days" >
					<option value="none" selected>---</option>
					<?php
						$sql = "select * from DAY_ORDER";
						$rs = mysqli_query($conn,$sql);
						while($row = mysqli_fetch_assoc($rs))
						{
							echo "<option value='".$row['DAY_ID']."'>".$row['DAY']."</option>";
						}
						
					?>
				</datalist>
			</div>
			<div class="col-lg-10">
				<button class="btn btn-success col-lg-6" id="AddButton">Add</button>
			</div>
		</div>
		<div id="output" class="col-sm-6">
			<h3>Staff View</h3>
			<hr/>
			<table class="table table-striped table-hovered">
			<tr><th>Lab Incharge :</th><th><p id ="labIncharge"></p></th><td></td></tr>
			<tr><td>Other Staff(s) :</td><td></td><td></td></tr>
			<?php
				for($i=1;$i<=5;$i++)
				{
					echo "<tr>";
					echo "<td></td>";
					echo "<td><p id ='staff$i'></p></td>";
					//echo "<td><button class='btn btn-success' id='add$i'>Add</button></td>";
					//echo "<td><button class='btn btn-warning' id='update$i'>Update</button></td>";
					echo "<td><button class='btn btn-danger deleteB' id='delete$i' value='$i'>Delete</button></td>";
					echo "</tr>";
				}
			?>
		</div>
		
    </div>
     

</body>

</html>
