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
	<script src="cancelReq.js"></script>
</head>

<body>
<?php require_once("header.php");?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Cancel Request Page</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
			<div class="col-sm-8">
                <form method="POST" role="form" class="form-horizontal" action='' method='POST' id="fsub">
           			<div class="form-group" id="nodgp">
						<label class="control-label col-sm-3" for="year">Request ID </label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="lid">
							</div>
					</div>
					<div class="form-group" id="nodgp">
							<div class="col-sm-9">
								<input type="submit" class="form-control btn btn-success" >
							</div>
					</div>
				</form>
            
        </div>
            
    </div>
     

</body>

</html>
