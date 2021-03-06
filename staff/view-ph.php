<?php
	session_start();
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

    <title>Staff Dashboard | IST Leave System</title>

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
	<Script src="public-holidays.js"></Script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

  <!-- Table Data Sort -->
	<link rel="stylesheet"href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css"></link>
	<script src="//code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
	<script>
	$(document).ready(function() {$('#datetab').DataTable();} );
	</script>
    
</head>

<body>
<?php require_once("header.php");?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Public Holidays</h1>
                </div>
                <div class="col-sm-9">
										<table class="table table-bordered" id="datetab">
											<thead>
												<tr >
													<th class='col-md-4'>Date</th>
													<th>Purpose Of Holiday</th>
												</tr>
											</thead>
											<tbody>
													<?php
														$sql = 'Select * from PUBLIC_HOLIDAYS';
														$rs = mysqli_query($conn,$sql);
														
														while($row = mysqli_fetch_assoc($rs))
														{
															echo "<tr><td> $row[HOLIDAY_DATE]</td>";
															echo "<td> $row[FUNCTION_NAME]</td></tr>";
														}
													?>
											</tbody>
										</table>
									</div>
        </div>
				
        </div><!-- /#page-wrapper -->

    
	</div>
    <!-- /#wrapper -->

</body>

</html>

	