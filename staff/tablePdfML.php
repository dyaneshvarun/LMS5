<?php
// create pdf

session_start();
require_once("../arc/dbconnect.php");
if(!isset($_SESSION['STA_ID'])){
	header("Location:login.php");
}
require('mypdf.php');
$con = mysql_connect("localhost","istleaveadmin","lms@78");
if (!$con)
  {
  die('1 Could not connect: ' . mysql_error());
  }
 
mysql_select_db("NEWSYS", $con);
$staffid=$_SESSION['STA_ID'];
$staff_table="select * from STAFF where staff_id =".$staffid;

$result = mysql_query($staff_table);
$row = mysql_fetch_array($result);

$staffname=$row[1];
$designation=$row[2];
$staff_leave='select * from STAFF_LEAVE where leave_id= '.$_GET['LID'].' and  staff_id='.$staffid;
$result1 = mysql_query($staff_leave);
$row1 = mysql_fetch_array($result1);
$leavetype=mysql_real_escape_string($row1[5]);
$leaveid=$row1[0];
$nod=$row1[6];
$fromdate=$row1[3];
$todate=$row1[4];
/*
$staff_leave_type="select * from STAFF_LEAVE_TYPE where leave_type ='".$leavetype."'"."and staff_id=".$staffid;
$result2 = mysql_query($staff_leave_type);
if(!$row2 = mysql_fetch_array($result2))
{
die('2 Could not connect: ' . mysql_error());
}
$availed=$row2[2]-$nod;
*/
$leave_typ="select * from LEAVE_TYPE where type_id ='".$leavetype."'";
$result3 = mysql_query($leave_typ);
if(!$row3 = mysql_fetch_array($result3))
{
die('3 Could not connect: ' . mysql_error());
}
//$balanced=$row3[2]-$nod-$availed;
$leavetypename=$row3[1];

$staff_leave_days1="select * from STAFF_LEAVE_DAYS where leave_id =".$leaveid;
$result8= mysql_query($staff_leave_days1);
$leavedays=" ";
while($row8 = mysql_fetch_array($result8))
{
	if($leavedays==" ")
	$leavedays=$leavedays.$row8[2];
	else
	$leavedays=$leavedays.','.$row8[2];
}
$pdf=new MYPDF('P','mm','A4');
$pdf->SetAuthor('DIST');
$pdf->SetTitle('DIST');

//set font for the entire document
$pdf->SetFont('Helvetica','B',20);
//$pdf->SetTextColor(50,60,100);
$pdf->SetTextColor(0);
//set up a page
 $pdf->AddPage('P'); 
//$pdf->SetDisplayMode(real,'default');

//insert an image and make it a link
$pdf->Image('logo.png',5,5,200,40);

//display the title with a border around it
$pdf->SetXY(50,45);

$pdf->SetDrawColor(0);
$pdf->Cell(110,10,$leavetypename.' APPLICATION',1,0,'C',0);

$pdf->Ln(10);

$pdf->Rect(5, 5, 200, 287, 'D');
$pdf->AliasNbPages();
$pdf->SetMargins($pdf->left, $pdf->top, $pdf->right); 

// create table
$columns = array();      
   
// header col
$col = array();
$col[] = array('text' => 'STAFF DETAILS', 'width' => '190', 'height' => '5', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '135,206,250', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$columns[] = $col;
// data col
$col = array();
$col[] = array('text' => 'NAME', 'width' => '95', 'height' => '5', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => $staffname, 'width' => '95', 'height' => '5', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$columns[] = $col;
// data col
$col = array();
$col[] = array('text' => 'DESIGNATION', 'width' => '95', 'height' => '5', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => $designation, 'width' => '95', 'height' => '5', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$columns[] = $col;
// data col
$col = array();
$col[] = array('text' => 'STAFFID', 'width' => '95', 'height' => '5', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => $staffid, 'width' => '95', 'height' => '5', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$columns[] = $col;
// Draw Table   
$pdf->WriteTable($columns);

$pdf->Ln(10);

// create table
$columns = array();      
   
// header col
$col = array();
$col[] = array('text' => 'LEAVE DETAILS', 'width' => '190', 'height' => '5', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '135,206,250', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$columns[] = $col;
// data col
/*
$col = array();
$col[] = array('text' => 'LEAVE TYPE', 'width' => '95', 'height' => '5', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => $leavetypename, 'width' => '95', 'height' => '5', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$columns[] = $col;
// data col
$col = array();
$col[] = array('text' => 'AVAILED', 'width' => '95', 'height' => '5', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => $availed, 'width' => '95', 'height' => '5', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$columns[] = $col;
// data col
$col = array();
$col[] = array('text' => 'BALANCED', 'width' => '95', 'height' => '5', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => $balanced, 'width' => '95', 'height' => '5', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$columns[] = $col;
// data col
*/
$col = array();
$col[] = array('text' => 'NO OF DAYS', 'width' => '95', 'height' => '5', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => $nod.'('.$leavedays.')', 'width' => '95', 'height' => '5', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$columns[] = $col;
// data col
$col = array();
$col[] = array('text' => 'FROM DATE', 'width' => '95', 'height' => '5', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => $fromdate, 'width' => '95', 'height' => '5', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$columns[] = $col;
// data col
$col = array();
$col[] = array('text' => 'TO DATE', 'width' => '95', 'height' => '5', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => $todate, 'width' => '95', 'height' => '5', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$columns[] = $col;
// Draw Table   
$pdf->WriteTable($columns);
$pdf->Rect(5, 5, 200, 287, 'D');

$pdf->Ln(10);

// create table
$columns = array();      
   
$columns = array();      
   $reason=$row1[7];
// header col
$col = array();
$col[] = array('text' => 'STAFF ALTERATION', 'width' => '190', 'height' => '5', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '135,206,250', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$columns[] = $col;
$col = array();
$col[] = array('text' => '', 'width' => '190', 'height' => '15', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$columns[] = $col;
// Draw Table   
$pdf->WriteTable($columns);
$pdf->Ln(10);

// create table
$columns = array();      
   $reason=$row1[7];
// header col
$col = array();
$col[] = array('text' => 'REASON', 'width' => '190', 'height' => '5', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '135,206,250', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$columns[] = $col;
$col = array();
$col[] = array('text' => $reason, 'width' => '190', 'height' => '15', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$columns[] = $col;

// Draw Table   
$pdf->WriteTable($columns);

$pdf->Ln(10);

// create table
$columns = array();      
   $permitted=$row1[8];
// header col
$col = array();
$col[] = array('text' => 'If. Permission is required to go out of station furnish details with Address for
communication', 'width' => '190', 'height' => '5', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '135,206,250', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$columns[] = $col;
$col = array();
$col[] = array('text' => $permitted, 'width' => '190', 'height' => '30', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$columns[] = $col;

// Draw Table   
$pdf->WriteTable($columns);

$pdf->Ln(10);

// create table
$columns = array();      
   
// header col
$col = array();
$col[] = array('text' => 'APPROVED', 'width' => '60', 'height' => '5', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '135,206,250', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => 'NOT APPROVED', 'width' => '60', 'height' => '5', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '135,206,250', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => 'HOD SIGNATURE', 'width' => '70', 'height' => '5', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '135,206,250', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$columns[] = $col;
$col = array();
$col[] = array('text' => '', 'width' => '60', 'height' => '12', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => '', 'width' => '60', 'height' => '12', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => '', 'width' => '70', 'height' => '12', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');


$columns[] = $col;

// Draw Table   
$pdf->WriteTable($columns);
$pdf->Rect(5, 5, 200, 287, 'D');


// Show PDF   
$pdf->Output('CASUAL_LEAVE.pdf','I');
?>
