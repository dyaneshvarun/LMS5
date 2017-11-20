<?php
	//session_start();
	require_once("../arc/dbconnect.php");
	require_once("functions.php");
	if(!isset($_SESSION['STA_ID'])){
		header("Location:login.php");
	}
	$sta_id = $_SESSION['STA_ID'];
    $res = mysqli_query($conn,"CALL GET_ADMIN($sta_id)");
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
	<Script src="periodicRep1.js"></Script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>



</head>

<body>
<?php require_once("header.php");?>
        
		<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Periodic Report</h1>
                </div>

            </div>
			<div class="col-sm-8">
                            <form method="POST" role="form" action='reportGenerate.php' class="form-horizontal" id="fsub">
           			<div class="form-group" id="nodgp">
						<label class="control-label col-sm-3" for="from">From: </label>
							<div class="col-sm-9">
								<input type='input' class='form-control datepickee datepickf' id='fdate' name='fdate' required >
							</div>
					</div>
					<div class="form-group" id="nodgp">
						<label class="control-label col-sm-3" for="to">To : </label>
							<div class="col-sm-9">
								<input type='input' class='form-control datepickee datepickf' id='tdate' name='tdate' required >
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
                                    <div class="form-group" id="output">
                                        <?php $i =1;
                                                $hello1=$php_self['fdate'];
                                                $hello=$php_self['tdate'];
                                                $hello2=$sta_id;
                                                //echo $hello,$hello1;
                                                echo '<h3> Report for the staff '.$hello2.' from '.$hello.' to '.$hello.' </h3>';
						$sql = "SELECT STAFF_ID,LEAVE_ID,LEAVE_TYPE,NOD,REASON FROM staff_leave where FR_DATE >= '".$hello1."' && TO_DATE <= '".$hello."' && STAFF_ID='".$hello2."' union SELECT STAFF_ID,LEAVE_ID,LEAVE_TYPE,NOD,REASON FROM staff_leave where TO_DATE >= '".$hello."' && FR_DATE <= '".$hello1."' ";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
								echo '<table class="table table-hover">';
                                                                echo '<tr><th> S.No</th>';
                                                                echo '<th>Leave ID</th>';
                                                                echo '<th> Leave Type </th>';
                                                                echo '<th> Number of Days </th>';
                                                                echo '<th> Reason </th>';
                                                                echo '</tr>';
							while($row = $result->fetch_assoc()) {
                                                                        echo '<tr><td>'.$i.'</td>';
									echo "<td> ".$row['LEAVE_ID']."</td>";
                                                                        echo '<td>'.$row['LEAVE_TYPE'].'</td>';
                                                                        echo '<td>'.$row['NOD'].'</td>';
                                                                        echo '<td>'.$row['REASON'].'</td>';
                                                                        echo '</tr>';
                                                                        $i = $i+1;
							}
							echo '</table>'	;}
						else 
						{
									echo "Everyone Present";
						}
				?>
                                    </div>
				</form>
            
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

</body>

</html>
