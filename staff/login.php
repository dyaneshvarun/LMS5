<?php
	session_start();
	require_once("../arc/dbconnect.php");
	if(isset($_POST['op'])){
		$op = mysqli_real_escape_string($conn,$_POST['op']);
		switch($op){
			case 1:
			{
				if(isset($_POST['em'])){
					$email = mysqli_real_escape_string($conn,$_POST['em']);
				}
				else{echo 99;return;};
				if(isset($_POST['pa'])){
					$pass = mysqli_real_escape_string($conn,$_POST['pa']);
				}
				else{echo 99;return;};
				$hashpass = md5($pass);
				if(!$res = mysqli_query($conn,"CALL CHECK_LOGIN('$email','$hashpass',@STA_ID)")){
					echo mysqli_error($conn);
				}
				if(!$res = mysqli_query($conn,"SELECT @STA_ID AS STA_ID")){
					echo "1" . mysqli_error($conn);
				}
				if(!$row = mysqli_fetch_assoc($res)){
					echo "2" . mysqli_error($conn);
				}
				$sta_id = $row['STA_ID']; 
				if($sta_id == 0){
					$rip = $_SERVER['REMOTE_ADDR'];
					$rs = mysqli_query($conn,"CALL INS_LOGINLOG('$email','$rip','FAILURE')");
					echo 0;
					return;
				}
				else{
					$rip = $_SERVER['REMOTE_ADDR'];
					if(!$rs = mysqli_query($conn,"CALL INS_LOGINLOG('$email','$rip','SUCCESS')")){
						echo mysqli_error($conn);
					}
					$_SESSION['STA_ID'] = $sta_id;
					$sql = "CALL GET_STAFF($sta_id)";
					$rs = mysqli_query($conn,$sql);
					if(!$row = mysqli_fetch_assoc($rs)){
						echo mysqli_error($conn);
					}
					$key = "STAFF_INFO_" . $sta_id;
					//$memcache = new Memcache;
					//$cacheAvailable = $memcache->connect("127.0.0.1","11211");
					//$memcache->set($key,$row);
					echo $sta_id;
					return;
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

    <title>IST Leave System | Staff Portal Login</title>

    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
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
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="POST" id="fsub">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" name="email" type="email" id="email" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" id="pass" name="password" type="password" value="">
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="submit" class="btn btn-lg btn-success btn-block">Login</button>
                            </fieldset>
                        </form>
						
                    </div>
                </div><a href = "activate.php">Activate Staff</a>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    <script src="login.js"></script>

</body>

</html>
<?php

}

?>
