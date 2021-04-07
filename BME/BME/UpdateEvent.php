<?php
include "DB.php";
include 'cal_invite_testevent.php';
include "cal_invite_cancel_test.php";
session_start();
$assoc_id=$_SESSION['associateId'];
$assoc_name=$_SESSION['fullname'];
$offset=$_SESSION['utc_offset'];




$slno=$_GET['slno'];

$ename=$_POST['ename'];
$edesc=$_POST['edesc'];
$edate=$_POST['edate'];
$date_final=date('Y-m-d',strtotime($edate));
$Location=$_POST['Location'];
$confirm_email=$_POST['confirm_email'];
$file=$_POST['Filename'];
$golivenew=$_POST['golive'];
$qrcode_status=$_POST['qrcode_status'];
$invite_msg=$_POST['invite_msg'];
if(empty($invite_msg)){
	$invite_msg="Its time for the event.";
}


$d1= new DateTime($date_final);  
$date= $d1->format('d');   
$month= $d1->format('M'); 
 $year= $d1->format('Y'); 
$monthh = $month . ' ' . $year;



 $event_details=$link->query("SELECT * FROM `event` WHERE `slno`=$slno");
    $event_details1=mysqli_fetch_assoc($event_details);
    $event_name=$event_details1['ename'];
$description=$event_details1['edesc'];
$event_date=$event_details1['edate'];
$event_location=$event_details1['Location'];
$date11=date($event_details1['edate']);
$goliveold=$event_details1['golive'];
$emailbox=$event_details1['emailbox'];

$d1= new DateTime($date11);  
$dateold= $d1->format('d');   
$monthold= $d1->format('M'); 
 $yearold= $d1->format('Y'); 
$monthhold = $month . ' ' . $year;

	


    $result1=$link->query("UPDATE  event SET ename ='$ename', edesc = '$edesc', edate = '$date_final',Location='$Location',golive='$golivenew',confirm_email='$confirm_email',invite_msg='$invite_msg',qrcode_status='$qrcode_status' WHERE slno='$slno'");
	$result12=$link->query("UPDATE `bme_analysis1` SET `ename`=`$ename`, date='$date',month='$monthh'  WHERE ename='$event_name' AND month='monthhold'");
	
	
    
	
//print_r($_POST);

		
	if(($goliveold=='0') && ($golivenew=='1')) {
		
		$query = $link->query("SELECT * FROM bme_analysis WHERE month='$month' AND year='$year'");
        $rowCount = $query->num_rows;
		 if($rowCount > 0){
		
		$result12=$link->query("UPDATE `bme_analysis` SET `event_count`=`event_count`+1  WHERE month='$month' AND year='$year' ");
		 $result6=$link->query("insert into bme_analysis1( `date`, `month`,`ename`,`registrations`) values ('$date','$monthh','$ename','0')");
		 }
		 else{
			 $result12=$link->query("insert `bme_analysis`(`month`,`year`,`event_count`,`registration_count`) values ('$month','$year','1','0')");
			 $result6=$link->query("insert into bme_analysis1( `date`, `month`,`ename`,`registrations`) values ('$date','$monthh','$ename','0')");
		 }
		
		
	}
	
	 if (($goliveold=='1') && ($golivenew=='0')) {
		 
	$event_details=$link->query("SELECT * FROM `bme_analysis` WHERE WHERE month='$monthold' AND year='$yearold'");
    $event_details1=mysqli_fetch_assoc($event_details);
    $eventscount=$event_details1['event_count'];
	
	if(eventscount > 0){
		
		$result12=$link->query("UPDATE `bme_analysis` SET `event_count`=`event_count`-1  WHERE month='$monthold' AND year='$yearold' ");
		 $result6=$link->query("DELETE from  bme_analysis1 WHERE ename='$ename' ");
		
	}
	
	else {
		$result12=$link->query("DELETE from  `bme_analysis`  WHERE month='$monthold' AND year='$yearold' ");
		 $result6=$link->query("DELETE from  bme_analysis1 WHERE ename='$ename' ");
		
	}
		
		
	}

	
	
	header("location:index.php?exist1= Event Updated");
 ?>
