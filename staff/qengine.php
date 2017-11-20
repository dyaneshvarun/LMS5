<?php

session_start();
if(!isset($_SESSION['STA_ID'])){
	//header("Location:login.php");
	echo "Please Login to Use the Service";exit();
}


$sta_id = $_SESSION['STA_ID'];
require_once("../arc/dbconnect.php");
require_once("functions.php");
//$memcache = new Memcache;
//$cacheAvailable = $memcache->connect('127.0.0.1','11211');

$leaveType = array();
//$leaveType = $memcache->get('leave_type');
//if(!$leaveType){
$rows = getLeaveType($conn);
//$memcache->set('leave_type',$rows,MEMCACHE_COMPRESSED,1000);
//$leaveType = $memcache->get('leave_type');
$leaveType = $rows;
mysqli_close($conn);
$conn = mysqli_connect($hostname,$username,$password,$database);
$tcl = $leaveType[0];
$trh = $leaveType[5];
$tscl = $leaveType[6];

$tml = $leaveType[3];
$tel = $leaveType[2];



$staffLeave = array();
//$key = "STAFF_LEAVE_".$sta_id;
//$staffLeave = $memcache->get($key);
//if(!$staffLeave){
$rows = getStaffLeave($conn,$sta_id);
//$memcache->set($key,$rows,MEMCACHE_COMPRESSED,1000);
//}
$staffLeave = $rows;
mysqli_close($conn);
$s_cl = 0;$s_rh=0;$s_scl=0;


$s_ml=0;
$s_el=0;



$conn = mysqli_connect($hostname,$username,$password,$database);
foreach($staffLeave as $row){
	if($row['LEAVE_TYPE'] == 'CL')
		$s_cl = $row['NOD'];
	if($row['LEAVE_TYPE'] == 'RH')
		$s_rh = $row['NOD'];
	if($row['LEAVE_TYPE'] == 'SCL')
		$s_scl = $row['NOD'];

if($row['LEAVE_TYPE'] == 'ML')
{
$s_ml = $row['NOD'];
}


if($row['LEAVE_TYPE'] == 'EL')
{
$s_el = $row['NOD'];
}


}

if(!isset($_POST['op'])){
	echo "Error";
	return;
}
$op = mysqli_real_escape_string($conn,$_POST['op']);
if(isset($_GET['op'])){
	$op = mysqli_real_escape_string($conn,$_GET['op']);
}
switch($op){
	case '1':{//Get the leave information of the staff. O/P -> taken leave/total leave
		if(!$type = $_POST['type']){
			echo "Type Not Valid";
			return;
		}
		else{
			if($type == 'cl'){
				$clData = array();
				$clData['avail'] = $s_cl;
				$clData['total'] = $tcl['NOD'];
				echo json_encode($clData);
			}


			if($type == 'ml'){
				$mlData = array();
				$mlData['avail'] = $s_ml;
				$mlData['total'] = $tml['NOD'];
                     
				echo json_encode($mlData);
			}
                
               if($type == 'el'){
				$elData = array();
				$elData['avail'] = $s_el;
				$elData['total'] = $tel['NOD'];
                     
				echo json_encode($elData);
			}


			if($type == 'rh'){
				$rhData = array();
				$rhData['avail'] = $s_rh;
				$rhData['total'] = $trh['NOD'];
				echo json_encode($rhData);
			}
			if($type == 'scl'){
				$sclData = array();
				$sclData['avail'] = $s_scl;
				$sclData['total'] = $tscl['NOD'];
			}	
		}
		break;
	}
	case '2':{
		$noAlter = 0;
		if(!$lt = $_POST['lt']){
			echo "Leave Type not valid";return;
		}
		if(!$fd = $_POST['fd']){
			echo "Leave Type not valid";return;
		}
		if(!$td = $_POST['td']){
			echo "Leave Type not valid";return;
		}
		if(!$res = $_POST['re']){
			echo "Leave Type not valid";return;
		}
		if(!$addr = $_POST['ad']){
		}
		
		if(!$leaveAlter = $_POST['alterData']){
			$noAlter = 1;
		}
		
		$lt = strtoupper($lt);
		$sql = "INSERT INTO STAFF_LEAVE (STAFF_ID,FR_DATE,TO_DATE,LEAVE_TYPE,NOD,REASON,ADDRESS,STATUS) VALUES ($sta_id,'$fd','$td','$lt',GETCOUNT('$fd','$td'),'$res','$addr',0)";
		//$sql = "CALL INS_STAFF_LEAVE($sta_id,'$fd','$td','$lt')";
		if(!mysqli_query($conn,$sql)){
			echo mysqli_error($conn);
		}
		else{
			$i=-1;
			$lid = mysqli_insert_id($conn);
			if($leaveAlter != "##"){
			foreach($leaveAlter as $leavel){
				//$clas = "CALL GET_STAFF_CLASS_ID('$leavel[year]',$sta_id,$leavel[hour])";
				$i++;
				$clas = "SELECT CLASS_ID FROM CLASS where USER_NAME = '".$leaveAlter[$i]['class']."' ";
				if(!$res1 = mysqli_query($conn,$clas)){
					echo "1 : " . mysqli_error($conn);
					exit();
				}
				$row1 = mysqli_fetch_assoc($res1);
				$clas2 = $row1['CLASS_ID'];
				
				//mysqli_free_result($res1);
				$sql = "SELECT SLDID FROM STAFF_LEAVE_DAYS WHERE LEAVE_ID = '$lid' AND LEAVE_DATE = '$leavel[year]'";
				if(!$res2 = mysqli_query($conn,$sql)){
					echo "2 : " . mysqli_error($conn);
					exit();
				}
				$row1 = mysqli_fetch_assoc($res2);
				$sldid = $row1['SLDID'];
				//mysqli_free_result($res1);
				if($leavel['alterstaff'] == ''){
					$leavel['alterstaff'] = 'NULL';
					//echo $leavel[alterstaff];
				}
				
				$sql12 = "INSERT INTO STAFF_PERIOD_ALLOCATION VALUES ($sldid,$leavel[hour],$leavel[alterstaff],'$leavel[year]',0,$clas2)";
				
				if(!$res1 = mysqli_query($conn,$sql12)){
					echo $sql12;
					echo "3 : " .$leaveAlter[1]['class'] ."HI".$clas. mysqli_error($conn);
					exit();
				}
			}}
			if($noAlter == 0)echo 1;
			else echo 2;
		}
		exit;
	}
	case '3':{
		if(!$lt = $_POST['lt']){
			echo "Leave Type not valid";return;
		}
		if(!$fd = $_POST['fd']){
			echo "Leave Type not valid";return;
		}
		if(!$td = $_POST['td']){
			echo "Leave Type not valid";return;
		}
		if(!$res = $_POST['re']){
			echo "Leave Type not valid";return;
		}
		$leaveAlter = $_POST['alterData'];
		if(!$addr = $_POST['ad']){
		}
		$lt = strtoupper($lt);
		foreach($leaveAlter as $leavel){
			
		}
		//$sql = "CALL INS_STAFF_LEAVE($sta_id,'$fd','$td','$lt')";
		$sql = "INSERT INTO STAFF_LEAVE (STAFF_ID,FR_DATE,TO_DATE,LEAVE_TYPE,NOD,STATUS) VALUES ($sta_id,'$fd','$td','$lt',GETCOUNT('$fd','$td'),0)";
		if(!mysqli_query($conn,$sql)){
			echo mysqli_error($conn);
			exit();
		}
		else{
			$lid = mysqli_insert_id($conn);
			//echo $lid;
			foreach($leaveAlter as $leavel){
				//$clas = "CALL GET_STAFF_CLASS_ID('$leavel[year]',$sta_id,$leavel[hour])";
				$clas = "SELECT CLASS_ID FROM SLOT_ALLOCATION WHERE DAY_ID = (DAYOFWEEK('$leavel[year]')-1) AND STAFF_ID = $sta_id AND HOUR = $leavel[hour]";
				if(!$res1 = mysqli_query($conn,$clas)){
					echo "1 : " . mysqli_error($conn);
					exit();
				}
				$row1 = mysqli_fetch_assoc($res1);
				$clas = $row1['CLASS_ID'];
				//mysqli_free_result($res1);
				$sql = "SELECT SLDID FROM STAFF_LEAVE_DAYS WHERE LEAVE_ID = '$lid' AND LEAVE_DATE = '$leavel[year]'";
				if(!$res2 = mysqli_query($conn,$sql)){
					echo "2 : " . mysqli_error($conn);
					exit();
				}
				$row1 = mysqli_fetch_assoc($res2);
				$sldid = $row1['SLDID'];
				//mysqli_free_result($res1);
				$sql = "INSERT INTO STAFF_PERIOD_ALLOCATION VALUES ($sldid,$leavel[hour],$leavel[alterstaff],'$leavel[year]',0,$clas)";
				//$sql = "CALL INS_SLOT_ALLOCATION($sldid,$leavel[hour],$leavel[alterstaff],'$leavel[year]',0,$clas)";
				if(!$res1 = mysqli_query($conn,$sql)){
					echo "3 : " . mysqli_error($conn);
					exit();
				}
			}
			echo 1;
			//$staffLeave = array();
			//$key = "STAFF_LEAVE_".$sta_id;
			//$rows = getStaffLeave($conn,$sta_id);
			//$memcache->delete($key);
			//$memcache->set($key,$rows,MEMCACHE_COMPRESSED,1000);
		}
		break;
	}
	case '4':{
		//echo $_POST['leaveDateArray'][0];
		if(!$lt = $_POST['lt']){
			echo "Leave Type not valid";return;
		}
		if(!$leaveDateArray = $_POST['leaveDateArray']){
			echo "Leave date List Not Valid";return;
		}
		if(!$compDateArray = $_POST['compDateArray']){
			echo "Compensation Date List not Valid";return;
		}
		if(!$nod = $_POST['nod']){
			echo "Leave Type not valid";return;
		}
		if(!$res = $_POST['re']){
			echo "Leave Type not valid";return;
		}
		if(!$addr = $_POST['ad']){
			$addr = "";
		}
		$sql = "CALL INS_COMPENSATION_LEAVE($sta_id,$nod,'$res','$addr')";
		if(!mysqli_query($conn,$sql)){
			echo mysqli_error($conn);return;
		}
		print_r($leaveDateArray);
		$leave_id = mysqli_insert_id($conn);
		for($i=0;$i<$nod;$i++){
				//$ld = $leaveDateArray[leaveArray][$i];echo $nod.$i.$ld;
				//$sql = "CALL INS_COMP_DAYS($leave_id,'$leave
		}
		break;
	}
	case '5':{
		if(!$dol = $_POST['dol']){
			echo "Leave Date not provided";exit();
		}
		if(!$hr = $_POST['hr']){
			echo "Hour Not Valid";
			exit();
		}
		if(!$did = $_POST['did']){
			echo "Day ID not Provided";
			exit();
		}
		$sql = "CALL GET_AVAIL_STAFF($sta_id,$did,$hr,'$dol')";
		if(!$result = mysqli_query($conn,$sql)){
			echo mysqli_error($conn);exit;
		}
		$rows = array();
		while($res = mysqli_fetch_assoc($result)){
			$rows[] = $res;
		}
		echo json_encode($rows);
		return;
	}
	case '6':{
		if(!$did = $_POST['did']){
			echo "Leave Date Not provided";exit();
		}
		$sql = "CALL GET_HOUR_LIST($sta_id,$did)";
		//echo $sql;
		echo sqlToJson($conn,$sql);
		return;
	}
	case '7':{
		
		if(!$data = $_POST['data']){
			echo mysqli_error($conn);exit;
		}
		
		if(!$leaveIds = $_POST['leaveId']){
			echo mysqli_error($conn);exit;
		}
		$i = 0;
		foreach($data as $dat){
			$sql = "SELECT CLASS_ID from CLASS WHERE CLASS_NAME = '$dat[clsid]' ";
			//secho($sql);
			if(!$rs = mysqli_query($conn,$sql)){
					Die(mysqli_error($conn));
					exit();
			}
			$row = mysqli_fetch_assoc($rs);
			if($dat['opts'] == "ACCEPT") $stats = 1;
			else $stats = 2;
			$sql = "UPDATE STAFF_PERIOD_ALLOCATION SET STATUS = $stats WHERE CLASS_ID = '$row[CLASS_ID]' AND ALTER_DATE = '$dat[alt_date]' AND HOUR = $dat[hour]";
			if(!mysqli_query($conn,$sql)){
				Die(mysqli_error($conn));
				exit();
			}
			//Updates in Staff Leave and changes status to 2s
			/*if($stats == 2)
			{
				$sql = "UPDATE STAFF_LEAVE SET STATUS = 2 WHERE LEAVE_ID = '$leaveIds[$i]' ";
				if(!mysqli_query($conn,$sql)){
					Die(mysqli_error($conn));
					exit();
				}	
				$i++;
			}*/
		}
		echo 1;
		return;
		exit;
	}
	case '8':{
		$sql = "SELECT STAFF_ID AS ID, STAFF_NAME AS SN FROM STAFF WHERE CATEGORY = 't'";
		echo sqlToJson($conn,$sql);
		break;
	}
	case '9':{
		if(!$lt = $_POST['lt']){
			echo "Leave Type not valid";return;
		}
		if(!$fd = $_POST['fd']){
			echo "Leave Type not valid";return;
		}
		if(!$td = $_POST['td']){
			echo "Leave Type not valid";return;
		}
		if(!$res = $_POST['re']){
			echo "Leave Type not valid";return;
		}
		if(!$addr = $_POST['ad']){
		}
		
		//if(!$leaveAlter = $_POST['alterData']){
		//	echo "No alteration";//return;
		//}
		
		$sql = "INSERT INTO STAFF_LEAVE (STAFF_ID,FR_DATE,TO_DATE,LEAVE_TYPE,NOD,REASON,ADDRESS,STATUS) VALUES ($sta_id,'$fd','$td','$lt',GETCOUNT('$fd','$td'),'$res','$addr',0)";
		if(!mysqli_query($conn,$sql)){
			echo mysqli_error($conn);
			exit();
		}
		echo 1;
		break;
	}
	case '10':{
		
		$sql = "SELECT EMAILID FROM STAFF WHERE STAFF_ID =".$sta_id;
		if(!$result=mysqli_query($conn,$sql)){
			echo mysqli_error($conn);
			exit();
		}
		$rows = array();
		while($res = mysqli_fetch_assoc($result)){
			$rows[] = $res;
		}
		echo json_encode($rows);
		break;
	}
	case '11':{
		$alternateMail = $_POST['alternateStaff'];
		$rows = array();
		for($i = 0 ;$i<count($alternateMail);$i++){
			
			$sql = "SELECT EMAILID,STAFF_NAME FROM STAFF WHERE STAFF_ID =".$alternateMail[$i];
			
			if(!$result=mysqli_query($conn,$sql)){
				echo "1".$sql."  ". mysqli_error($conn);
				exit();
			}

			while($res = mysqli_fetch_assoc($result)){
				//echo $res['EMAILID'];
				$rows[] = $res;
			}
		}
		//echo '  DATA STARTS HERE';
		echo json_encode($rows);
		break;
	}
	case '12':{
		if(!$did = $_POST['did']){
			echo "Leave Date Not provided";exit();
		}
		$ses = $_POST['ses'];
		$ses1 = 'FN';
		$check = strcmp($ses,$ses1);
		//echo $check;
		if(!$check) $sql = "CALL GET_HOUR_LIST_FN($sta_id,$did)";
		else $sql = "CALL GET_HOUR_LIST_AN($did,$sta_id)";
		//echo $sql;
		echo sqlToJson($conn,$sql);
		return;
	}
	case '13':{
		$noAlter = 0;
		if(!$lt = $_POST['lt']){
			echo "Leave Type not valid";return;
		}
		if(!$fd = $_POST['fd']){
			echo "Leave Type not valid";return;
		}
		if(!$td = $_POST['td']){
			echo "Leave Type not valid";return;
		}
		if(!$res = $_POST['re']){
			echo "Leave Type not valid";return;
		}
		if(!$addr = $_POST['ad']){
		}
		
		if(!$leaveAlter = $_POST['alterData']){
			$noAlter = 1;//return;
		}
		
		$lt = strtoupper($lt);
		$sql = "INSERT INTO STAFF_LEAVE (STAFF_ID,FR_DATE,TO_DATE,LEAVE_TYPE,NOD,REASON,ADDRESS,STATUS) VALUES ($sta_id,'$fd','$td','$lt',0.5,'$res','$addr',0)";
		//$sql = "CALL INS_STAFF_LEAVE($sta_id,'$fd','$td','$lt')";
		if(!mysqli_query($conn,$sql)){
			echo mysqli_error($conn);
		}
		else{
			$i=-1;
			$lid = mysqli_insert_id($conn);
			if($leaveAlter != "##"){
			foreach($leaveAlter as $leavel){
				//$clas = "CALL GET_STAFF_CLASS_ID('$leavel[year]',$sta_id,$leavel[hour])";
				$i++;
				$clas = "SELECT CLASS_ID FROM CLASS where USER_NAME = '".$leaveAlter[$i]['class']."' ";
				if(!$res1 = mysqli_query($conn,$clas)){
					echo "1 : " . mysqli_error($conn);
					exit();
				}
				$row1 = mysqli_fetch_assoc($res1);
				$clas2 = $row1['CLASS_ID'];
				
				//mysqli_free_result($res1);
				$sql = "SELECT SLDID FROM STAFF_LEAVE_DAYS WHERE LEAVE_ID = '$lid' AND LEAVE_DATE = '$leavel[year]'";
				if(!$res2 = mysqli_query($conn,$sql)){
					echo "2 : " . mysqli_error($conn);
					exit();
				}
				$row1 = mysqli_fetch_assoc($res2);
				$sldid = $row1['SLDID'];
				//mysqli_free_result($res1);
				if($leavel['alterstaff'] == ''){
					$leavel['alterstaff'] = 'NULL';
					//echo $leavel[alterstaff];
				}
				
				$sql12 = "INSERT INTO STAFF_PERIOD_ALLOCATION VALUES ($sldid,$leavel[hour],$leavel[alterstaff],'$leavel[year]',0,$clas2)";
				
				if(!$res1 = mysqli_query($conn,$sql12)){
					echo $sql12;
					echo "3 : " .$leaveAlter[1]['class'] ."HI".$clas. mysqli_error($conn);
					exit();
				}
			}}
			if($noAlter == 0)echo 1;
			else echo 2;
			
		}
		exit;
	}
	case '14':{
		$alterData = $_POST['alter'];
	}
	case '15':{
		if(!$data = $_POST['data']){
			echo mysqli_error($conn);exit;
		}
		$results = array();
		if(!$leaveIds = $_POST['leaveId']){
			echo mysqli_error($conn);exit;
		}
		$i = 0;
		foreach($data as $dat){
			$sql = "SELECT CLASS_ID from CLASS WHERE CLASS_NAME = '$dat[clsid]' ";
			if(!$rs = mysqli_query($conn,$sql)){
					Die(mysqli_error($conn));
					exit();
			}
			$row = mysqli_fetch_assoc($rs);
			
			if($dat['opts'] == "ACCEPT")
			{
				$completeAlteration = "SELECT DISTINCT SLD.LEAVE_ID FROM `staff_period_allocation` spa ,
				`staff_leave_days` sld WHERE spa.LEAVE_ID = sld.SLDID and sld.LEAVE_ID = $leaveIds[$i] and
				spa.LEAVE_ID NOT IN (select LEAVE_ID from STAFF_PERIOD_ALLOCATION where status = 0)";
				//$results[] = sqlToJson($conn,$completeAlteration);
				if(!$result = mysqli_query($conn,$completeAlteration)){
						echo mysqli_error($conn);exit;
				}
				while($res = mysqli_fetch_assoc($result)){
					$results[] = $res;
				}
			}
			else
			{
				$completeAlteration = "UPDATE `STAFF_LEAVE` SET STATUS=2 WHERE `LEAVE_ID` = $leaveIds[$i] ;";
				//echo $completeAlteration;
				if(! $sendMail = mysqli_query($conn,$completeAlteration)){
					Die(mysqli_error($conn));
					exit();
				}
			}
			$i++;
		}
		echo json_encode($results);
		return;
		exit;
	}
	case '16':
	{
		$noAlter = 0;
		if(!$lt = $_POST['lt']){
			echo "Leave Type not valid";return;
		}
		if(!$fd = $_POST['fd']){
			echo "Leave Type not valid";return;
		}
		if(!$td = $_POST['td']){
			echo "Leave Type not valid";return;
		}
		if(!$res = $_POST['re']){
			echo "Leave Type not valid";return;
		}
		if(!$addr = $_POST['ad']){
		}
		
		if(!$leaveAlter = $_POST['alterData']){
			$noAlter = 1;
		}
		if(!$fileName = $_POST['fileName']){
			echo "Leave Type not valid";return;
		}
		$lt = strtoupper($lt);
		$sql = "INSERT INTO STAFF_LEAVE (STAFF_ID,FR_DATE,TO_DATE,LEAVE_TYPE,NOD,REASON,ADDRESS,STATUS,FILENAME) VALUES ($sta_id,'$fd','$td','$lt',GETCOUNT('$fd','$td'),'$res','$addr',0,'$fileName')";
		//$sql = "CALL INS_STAFF_LEAVE($sta_id,'$fd','$td','$lt')";
		if(!mysqli_query($conn,$sql)){
			echo mysqli_error($conn);
		}
		else{
			$i=-1;
			$lid = mysqli_insert_id($conn);
			if($leaveAlter != "##"){
			foreach($leaveAlter as $leavel){
				//$clas = "CALL GET_STAFF_CLASS_ID('$leavel[year]',$sta_id,$leavel[hour])";
				$i++;
				$clas = "SELECT CLASS_ID FROM CLASS where USER_NAME = '".$leaveAlter[$i]['class']."' ";
				if(!$res1 = mysqli_query($conn,$clas)){
					echo "1 : " . mysqli_error($conn);
					exit();
				}
				$row1 = mysqli_fetch_assoc($res1);
				$clas2 = $row1['CLASS_ID'];
				$sql = "SELECT SLDID FROM STAFF_LEAVE_DAYS WHERE LEAVE_ID = '$lid' AND LEAVE_DATE = '$leavel[year]'";
				if(!$res2 = mysqli_query($conn,$sql)){
					echo "2 : " . mysqli_error($conn);
					exit();
				}
				$row1 = mysqli_fetch_assoc($res2);
				$sldid = $row1['SLDID'];
				if($leavel['alterstaff'] == ''){
					$leavel['alterstaff'] = 'NULL';
				}
				
				$sql12 = "INSERT INTO STAFF_PERIOD_ALLOCATION VALUES ($sldid,$leavel[hour],$leavel[alterstaff],'$leavel[year]',0,$clas2)";
				
				if(!$res1 = mysqli_query($conn,$sql12)){
					echo $sql12;
					echo "3 : " .$leaveAlter[1]['class'] ."HI".$clas. mysqli_error($conn);
					exit();
				}
			}}
			if($noAlter == 0)echo 1;
			else echo 2;
		}
		exit;
	}
	case '17':
	{
		$noAlter = 0;
		if(!$lt = $_POST['lt']){
			echo "Leave Type not valid";return;
		}
		if(!$fd = $_POST['fd']){
			echo "From Date not valid";return;
		}
		if(!$td = $_POST['td']){
			echo "To Date not valid";return;
		}
		if(!$res = $_POST['re']){
			echo "Reason not valid";return;
		}
		if(!$addr = $_POST['ad']){
		}
		if(!$nod = $_POST['nod']){
		}
		if(!$leaveAlter = $_POST['alterData']){
			$noAlter = 1;
		}
		if(!$fileName = $_POST['fileName']){
			echo "File Name not valid";return;
		}
		$lt = strtoupper($lt);
		$sql = "INSERT INTO STAFF_LEAVE (STAFF_ID,FR_DATE,TO_DATE,LEAVE_TYPE,NOD,REASON,ADDRESS,STATUS,FILENAME) VALUES ($sta_id,'$fd','$td','$lt','$nod','$res','$addr',0,'$fileName')";
		//$sql = "CALL INS_STAFF_LEAVE($sta_id,'$fd','$td','$lt')";
		if(!mysqli_query($conn,$sql)){
			echo mysqli_error($conn);
		}
		else{
			$i=-1;
			$lid = mysqli_insert_id($conn);
			if($leaveAlter != "##"){
			foreach($leaveAlter as $leavel){
				//$clas = "CALL GET_STAFF_CLASS_ID('$leavel[year]',$sta_id,$leavel[hour])";
				$i++;
				$clas = "SELECT CLASS_ID FROM CLASS where USER_NAME = '".$leaveAlter[$i]['class']."' ";
				if(!$res1 = mysqli_query($conn,$clas)){
					echo "1 : " . mysqli_error($conn);
					exit();
				}
				$row1 = mysqli_fetch_assoc($res1);
				$clas2 = $row1['CLASS_ID'];
				$sql = "SELECT SLDID FROM STAFF_LEAVE_DAYS WHERE LEAVE_ID = '$lid' AND LEAVE_DATE = '$leavel[year]'";
				if(!$res2 = mysqli_query($conn,$sql)){
					echo "2 : " . mysqli_error($conn);
					exit();
				}
				$row1 = mysqli_fetch_assoc($res2);
				$sldid = $row1['SLDID'];
				if($leavel['alterstaff'] == ''){
					$leavel['alterstaff'] = 'NULL';
				}
				
				$sql12 = "INSERT INTO STAFF_PERIOD_ALLOCATION VALUES ($sldid,$leavel[hour],$leavel[alterstaff],'$leavel[year]',0,$clas2)";
				
				if(!$res1 = mysqli_query($conn,$sql12)){
					echo $sql12;
					echo "3 : " .$leaveAlter[1]['class'] ."HI".$clas. mysqli_error($conn);
					exit();
				}
			}}
			if($noAlter == 0)echo 1;
			else echo 2;
		}
		exit;
	}
	case '18':
	{
		$cpdate = $_POST['cpdate'];
		$reason = $_POST['reason'];
		$staffid = $_POST['staffid'];
		$sql = "INSERT INTO `compensation_leave_days`(`STAFF_ID`, `REASON`, `CDATE`) VALUES ($staffid,'$reason','$cpdate')";
		if(!$res = mysqli_query($conn,$sql)){
					echo "This date has already been added to your CPL . Kindly wait.";
					exit();
		}
		break;
	}
	case '19':
	{
		$staffid = $_POST['staffId'];
		$sql = "SELECT CDATE,LEAVEDATE_ID,REASON from compensation_leave_days WHERE STAFF_ID =$staffid AND STATUS = 1 AND abs(DATEDIFF(CDATE,CURDATE()))<90 ORDER BY CDATE";
		echo sqlToJson($conn,$sql);
		return;
	}
	case '20':
	{
		$leaveid = $_POST['leaveid'];
		//$i=0;
		$nod = $_POST['nod'];
		$sql="SELECT LEAVE_ID FROM STAFF_LEAVE WHERE LEAVE_TYPE='CPL' and STAFF_ID=$sta_id ORDER BY APPLY_DATE DESC LIMIT 1";
		if(!$res2 = mysqli_query($conn,$sql)){
			echo "2 : " . mysqli_error($conn);
			exit();
		}
		$row1 = mysqli_fetch_assoc($res2);
		$lid = $row1['LEAVE_ID'];
		for($i=0;$i<$nod;$i++)
		{
			$sql = "UPDATE COMPENSATION_LEAVE_DAYS SET STATUS=3,LEAVE_ID=$lid where LEAVEDATE_ID=$leaveid[$i] ";
			echo $sql;
			if(!$res = mysqli_query($conn,$sql)){
						echo "Error in Updation";
						exit();
			}
		}
		return;
	}
	case '21':{
		$ltype = $_POST['lt'];
		$sql = "SELECT LEAVE_ID FROM STAFF_LEAVE WHERE LEAVE_TYPE='".$ltype."' AND STAFF_ID=".$sta_id." ORDER BY APPLY_DATE DESC LIMIT 1";
		echo sqlToJson($conn,$sql);
		break;
	}
	default:{
		echo "Not Valid Op Code";
		return;
	}
	
}
?>
