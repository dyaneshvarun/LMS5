<?php
	
	require_once("../arc/dbconnect.php");
	if(isset($_POST['op'])){
		$op = mysqli_real_escape_string($conn,$_POST['op']);
		switch($op){
			case 1:
			{
				if(isset($_POST['si'])){
					$sid = mysqli_real_escape_string($conn,$_POST['si']);
				}else{echo 99;break;}
				if(isset($_POST['em'])){
					$email = mysqli_real_escape_string($conn,$_POST['em']);
				}else{echo 99;break;}
				if(isset($_POST['pa'])){
					$pass = mysqli_real_escape_string($conn,$_POST['pa']);
				}else{echo 99;break;}
				
				$q = "CALL CHECK_ACTIVATION($sid,'$email',@cou)";
				$rs = mysqli_query($conn,$q);
				$rs = mysqli_query($conn,"SELECT @cou AS COU");
				$row = mysqli_fetch_assoc($rs);
				$count = $row['COU'];
				if($count == 0){
					echo 1;
					break;
				}
				else if($count == 1){
					$hashpass = md5($pass);
					if(mysqli_query($conn,"CALL STAFF_ACTIVATION($sid,'$hashpass','".$_POST['em']."')")){
						echo 0;
					}
					else{
						echo mysqli_error($conn);
					}
				}
				else{
					echo 99;
					break;
				}
			}
		}
	}
	else{
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	<script src="../bower_components/jquery/dist/jquery.min.js"></script>
    <title>Staff Account Activation</title>
	<script src="activate.js"></script>
    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

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
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Activate Your Account</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" id="fsub" method="POST">
                            <fieldset>
								<div class="form-group" id="sidd">
									<input class="form-control" placeholder="Staff ID" name="staff_id" id="sid" autofocus>
								</div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" name="email" type="email" id="email">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" id="pass" name="password" type="password" value="">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Confirm Password" id="cpass" name="cpassword" type="password" value="">
                                </div>
                                
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="submit" id="sub" class="btn btn-lg btn-success btn-block">Activate</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
<?php

}

?>
