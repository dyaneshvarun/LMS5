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
	<script src="timetable.js"></script>
</head>

<body>
<?php require_once("header.php");?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Options -- Timetable</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
			<div class="col-sm-8">
                            <form >
           			<div class="form-group" id="nodgp">
						<label class="control-label col-sm-3" for="Class">Class </label>
							<div class="col-sm-9">
								<select class="form-control" id="classID" name='classID' >
											<option value="none" selected>---</option>
											<?php
												$sql = "select class_name,user_name from CLASS";
												$rs = mysqli_query($conn,$sql);
												while($row = mysqli_fetch_assoc($rs))
												{
													echo "<option value='".$row['user_name']."'>".$row['class_name']."</option>";
												}
												
											?>
								</select>
							</div>
					</div>
					<br/><br/>
					<div class="form-group col-lg-12" id="nodgp">
							<div class="col-sm-3">
							</div>
							<br/>
							<div class="col-sm-4">
								<input type="button" value="View" class="form-control btn btn-success" id='submitButton' >
							</div>
							<div class="col-sm-4">
								<input type="button" value="Delete" class="form-control btn btn-danger" id='deleteButton' >
							</div>
					</div>
				</form>
				
        </div>
        <!-- /#page-wrapper -->
		<br/><br/><br/>
		<div class="row" id = "output">
			<table class="table table-striped table-hovered">
			<tr>
				<th>Day/Period</th>
				<th>1</th>
				<th>2</th>
				<th>3</th>
				<th>4</th>
				<th>5</th>
				<th>6</th>
				<th>7</th>
				<th>8</th>
			</tr>
			<?php
				for($i=1;$i<=5;$i++)
				{	echo "<tr>";
					for($j=0;$j<=8;$j++)
					{
						if($j==0)
						{
							switch($i)
							{
								case 1: echo "<th>Monday</th>";break;
								case 2: echo "<th>Tuesday</th>";break;
								case 3: echo "<th>Wednesday</th>";break;
								case 4: echo "<th>Thursday</th>";break;
								case 5: echo "<th>Friday</th>";break;
							}
							continue;
						}
						echo "<td><p id='staff$i$j'></p>";
						echo "</td>";
					}
					echo "</tr>";
				}
			?>
			</table>
        </div>	
	
		
		<div class="row col-lg-8">
			<h1>Update Timetable</h1><hr/>
			<div class="form-group" id="nodgp">
						<label class="control-label col-sm-3" for="year">Class Name </label>
							<div class="col-sm-9">
								<select class="form-control" id="UclassID" name='UclassID' >
											<option value="none" selected>---</option>
											<?php
												$sql = "select class_name,user_name from CLASS";
												$rs = mysqli_query($conn,$sql);
												while($row = mysqli_fetch_assoc($rs))
												{
													echo "<option value='".$row['user_name']."'>".$row['class_name']."</option>";
												}
												
											?>
								</select>
							</div>
			</div>
			<div class="form-group" id="nodgp">
						<label class="control-label col-sm-3" for="year">Day</label>
							<div class="col-sm-9">
								<select class="form-control" id="UdayID" name='dayID' >
											<option value="none" selected>---</option>
											<option value="1">Monday</option>
											<option value="2">Tuesday</option>
											<option value="3">Wednesday</option>
											<option value="4">Thursday</option>
											<option value="5">Friday</option>
								</select>
							</div>
			</div>
			<div class="form-group" id="nodgp">
						<label class="control-label col-sm-3" for="year">Period </label>
							<div class="col-sm-9">
								<select class="form-control" id="Uperiod" name='period' >
											<option value="none" selected>---</option>
											<?php
												$x = 1;
												while($x <= 8)
												{
													echo "<option value='".$x."'>".$x."</option>";
													$x++;
												}
												
											?>
								</select>
							</div>
			</div>
			<div class="form-group" id="nodgp">
						<label class="control-label col-sm-3" for="year">Subject ID </label>
							<div class="col-sm-9">
								<input list="papers" class="form-control" id="UpaperID" name='paperID' >
								<datalist id="papers">
											<option value="none" selected>---</option>
											<?php
												$sql = "select paper_code,paper_name from paper";
												$rs = mysqli_query($conn,$sql);
												while($row = mysqli_fetch_assoc($rs))
												{
													echo "<option value='".$row['paper_code']."'>".$row['paper_name']."</option>";
												}
												
											?>
								</datalist>
							</div>
			</div>
			<div class="form-group" id="nodgp">
						<label class="control-label col-sm-3" for="year">Staff ID </label>
							<div class="col-sm-9">
								<input list="staff" class="form-control" id="UstaffID" name='staffID' >
								<datalist id="staff">
											<option value="none" selected>---</option>
											<?php
												$sql = "select staff_id,staff_name from staff";
												$rs = mysqli_query($conn,$sql);
												while($row = mysqli_fetch_assoc($rs))
												{
													echo "<option value='".$row['staff_id']."'>".$row['staff_name']."</option>";
												}
												
											?>
								</datalist>
							</div>
			</div>
			<div class="row col-lg-12" id="nodgp">
				**Type	none in subject ID/Staff ID	if you want to update the period as free
			</div>
			<div class="form-group" id="nodgp">
							
							<div class="col-sm-3">
							</div>
							<div class="col-sm-4">
								<input type="button" value="Update" class="form-control btn btn-success" id='updateButton' >
							</div>
					</div>
		</div>
    </div>
     

</body>

</html>
