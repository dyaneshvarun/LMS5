<?php
	session_start();
	require_once("../arc/dbconnect.php");
	require_once("functions.php");
	if(!isset($_SESSION['STA_ID'])){
		header("Location:login.php");
	}
	$sta_id = $_SESSION['STA_ID'];
    mysqli_close($conn);
    $conn = mysqli_connect($hostname,$username,$password,$database);
	$i =1;
    $hello1=$_POST['fdate'];
    $hello=$_POST['tdate'];
    $hello2=$_POST['nod'];
	$sql = "SELECT * FROM staff_leave where STATUS =1 AND LEAVE_TYPE = '".$_POST['op']."' AND FR_DATE >= '".$hello1."' && TO_DATE <= '".$hello."' && STAFF_ID='".$hello2."' union SELECT * FROM staff_leave where STATUS =1 AND LEAVE_TYPE = '".$_POST['op']."' AND TO_DATE >= '".$hello."' && FR_DATE <= '".$hello1."' ";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
								echo '<table class="table table-hover">';
                                                                echo '<tr><th> S.No</th>';
                                                                echo '<th>Leave ID</th>';
                                                                //echo '<th> Leave Type </th>';
																echo '<th>From Date</th>';
																echo '<th>To Date</th>';
                                                                echo '<th> Number of Days </th>';
                                                                echo '<th> Reason </th>';
                                                                echo '</tr>';
							while($row = $result->fetch_assoc()) {
                                                                        echo '<tr><td>'.$i.'</td>';
																		echo "<td><a href='view_leave.php?lid=$row[LEAVE_ID]'> ".$row['LEAVE_ID']."</a></td>";
                                                                        //echo '<td>'.$row['LEAVE_TYPE'].'</td>';
																		echo "<td> ".$row['FR_DATE']."</td>";
																		echo "<td> ".$row['TO_DATE']."</td>";
                                                                        echo '<td>'.$row['NOD'].'</td>';
                                                                        echo '<td>'.$row['REASON'].'</td>';
                                                                        echo '</tr>';
                                                                        $i = $i+1;
							}
							echo '</table>'	;}
						else 
						{
									echo "No leave Taken";
						}
    ?>