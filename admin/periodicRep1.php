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
				<?php $i =1;
                                                $hello1=$_POST['fdate'];
                                                $hello=$_POST['tdate'];
                                                //echo $hello,$hello1;
                                                echo '<h3> Report for the days   '.$hello1.'  to '.$hello.' </h3>';
	$sql = "SELECT * FROM staff_leave,STAFF where STAFF.STAFF_ID=STAFF_LEAVE.STAFF_ID AND STAFF_LEAVE.STATUS =1 AND FR_DATE >= '".$hello1."' && TO_DATE <= '".$hello."'  union SELECT * FROM staff_leave,STAFF where STAFF.STAFF_ID=STAFF_LEAVE.STAFF_ID AND STAFF_LEAVE.STATUS =1  AND TO_DATE >= '".$hello."' && FR_DATE <= '".$hello1."' ";
							
                        $result = $conn->query($sql);
						if ($result->num_rows > 0) {
								echo '<table class="table table-hover">';
                                                                echo '<tr><th> S.No</th>';
                                                                echo '<th> Leave ID </th>';
                                                                echo '<th>Staff ID</th>';
                                                                echo '<th>Staff Name</th>';
                                                                echo '<th> Leave Type </th>';
                                                                echo '<th class="col-md-3"> From Data </th>';
                                                                echo '<th class="col-md-3"> To Date </th>';
                                                                echo '<th> Number of Days </th>';
                                                                echo '<th> Reason </th>';
                                                                echo '</tr>';
							while($row = $result->fetch_assoc()) {
                                                                        echo '<tr><td>'.$i.'</td>';
									echo "<td> <a href='view_leave.php?lid=".$row['LEAVE_ID']."'>".$row['LEAVE_ID']."</a></td>";
                                                                        echo "<td> ".$row['STAFF_ID']."</td>";
                                                                        echo "<td> ".$row['STAFF_NAME']."</td>";
                                                                        echo '<td>'.$row['LEAVE_TYPE'].'</td>';
                                                                        echo '<td>'.$row['FR_DATE'].'</td>';
                                                                        echo '<td>'.$row['TO_DATE'].'</td>';
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