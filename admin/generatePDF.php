<?php
session_start();
require_once("../arc/dbconnect.php");
if(!isset($_SESSION['STA_ID'])){
	header("Location:login.php");
}

$fro = $_POST['fro'];
$to  = $_POST['to'];

//require('fpdf181/fpdf.php');
require('mypdf.php');

$pdf=new MYPDF('P','mm','A4');
$pdf->SetAuthor('DIST');
$pdf->SetTitle('DIST');
//set font for the entire document
$pdf->SetFont('Helvetica','B',10);
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
$pdf->Cell(110,10,'PERIODIC LEAVE REPORT',1,0,'C',0);
$pdf->Ln(10);
$pdf->SetXY(50,55);
$pdf->Cell(110,10,'LEAVE PERIOD :'.date('d-m-Y',strtotime($fro)).' to '.date('d-m-Y',strtotime($to)),0,0,'C',0);
$pdf->Ln(10);
$pdf->Rect(5, 5, 200, 287, 'D');
$pdf->AliasNbPages();
$pdf->SetMargins($pdf->left, $pdf->top, $pdf->right); 

//Take Data from SQL
$sql="CALL GET_PERIODIC_REPORT('$fro','$to')";
$data = array();
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
	$data[] = $row;
}
$header = array("S.No","ID","Staff Name","LT","From","To","NOD","Reason");
//echo "<br>".$data[1]["STAFF_NAME"]."<br>";
$pdf->FancyTable($header,$data);  
$pdf->Output('LeaveReport.pdf','I');
?>
