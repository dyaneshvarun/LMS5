<?php
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
	<Script src="viewReport.js"></Script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
 <script>
     $(document).ready(function(){
	$("#nod").focusout(function(){
		var nod = $("#nod").val();
		if(nod == ''){
			noderr = 1;
			dispErr("#nod","No of Days Empty");
		}else if(!$.isNumeric(nod)){
			noderr = 1;
			dispErr("#nod","Not a valid Integer");
		}else{
			noderr = 0;
			$("#datetab").find("tbody").remove();	
			$("#datetab").append("<tbody></tbody>");			
			for(var i=nod;i>0;i--){
				var temp = "<tr><td><input type='input' class='form-control datepickee datepickf' id='fdate"+i+"' required></td><td><input type='input' class='form-control' id='purpose"+i+"'></td>";
				$("#datetab tbody").append(temp);
			
			}$("#datetab tbody").append("<tr><td><input type=\"Submit\" id=\" submitButton \">");
		}
	});
 </script>


</head>

<body>
<?php require_once("header.php");?>
        
		<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Staff and Papers</h1>
                </div>
                    
            </div>
	<div class="col-sm-8">
		<form method="POST" role="form" action='periodicRep1.php' class="form-horizontal" id="fsub">
           			<div class="form-group" id="nodgp">
						<label class="control-label col-sm-3" for="from">Batch/Year: </label>
							<div class="col-sm-9">
								<?php
											
											
												echo "<td><select class='form-control' name='batch'>";
												echo "<option value ='' selected></option>";
												$sql = "select USER_NAME,CLASS_NAME from class1";
												$rs = mysqli_query($conn,$sql);
												while($row = mysqli_fetch_assoc($rs))
												{
													echo "<option value='".$row['USER_NAME']."'>".$row['user_name']."--".$row['Class_NAME']."</option>";
												}
												echo "</select>";
												
											
											?>
											
							</div>
					</div>
					<div class="form-group" id="nodgp">
						<label class="control-label col-sm-3" for="to">Number of Papers : </label>
							<div class="col-sm-9">
								<input type='input' class='form-control' id='nop'  required >
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
                                    <div class="form-group" id="output"></div>
				</form>	            
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

</body>

</html>
