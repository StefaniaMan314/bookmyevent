<?php
include "DB.php";
include 'cal_invite_testevent.php';

include "cal_invite_cancel_test.php";



 $slno=$_GET['slno'];




	

 
		
			$event_date=$link->query("SELECT * FROM `event` WHERE `slno`=$slno");
    $event_date1=mysqli_fetch_assoc($event_date);
    $event_name=$event_date1['ename'];
$description=$event_date1['edesc'];
$golive=$event_date1['golive'];
$date=$event_date1['edate'];
$d1= new DateTime($date);  
$month= $d1->format('M'); 
$year= $d1->format('Y');
$location1=$event_date1['Location'];
$from_address=$event_date1['emailbox'];

    $date11=date($event_date1['edate']);
	
		
		  $result1=$link->query("SELECT  count(*)  FROM `testevent` WHERE `event`='$slno' ");
		  $rows1=mysqli_fetch_row($result1);
if(intval($rows1[0])>=1){
	$count=$rows1[0];
	$result1=$link->query("SELECT  *  FROM `testevent` WHERE `event`='$slno'  ");
   while( $arr_result=  mysqli_fetch_assoc($result1)){
      $email=$arr_result['email'];
	  $timeslot=$arr_result['timeslot'];
	    $uid=$arr_result['uid'];
		    $assoc_name=$arr_result['AssociateName'];
			
		
		$check3=$link->query("SELECT * FROM timeslot WHERE slno = '$timeslot' AND eslno='$slno'");
    $rows3=mysqli_fetch_row($check3);
	if($rows3[0]>=1)
    {
		$start_time=$rows3[1];
		$end_time=$rows3[2];
		$start_date=$rows3[7];
			$end_date=$rows3[8];

	
	}
	
	
		$from_name="Cerner Events";

    $to_name=$assoc_name;
    $to_address=$email;
    $startTime=$start_date." ".$start_time;
    $endTime=$end_date." ".$end_time;
    $subject=$event_name;
    $description="Sorry, The Event you reistered  is Deleted. <br/> Kindly Please wait for the next update.";
    $location=$location1;
    $status=sendIcalEvent_IST_cancel($from_name, $from_address, $to_name, $to_address, $startTime, $endTime, $subject, $description, $location, $uid);
	
		$result1=$link->query("DELETE  FROM   timeslot  WHERE slno = '$timeslot' AND eslno='$slno' ");
			$result2=$link->query("DELETE  FROM   testevent  WHERE timeslot = '$timeslot' AND event='$slno' ");	
$result3=	$link->query("DELETE  FROM   eventhost  WHERE  event_id='$slno' ");		
$result4=	$link->query("DELETE  FROM   event  WHERE  slno='$slno' ");		
    /*End*/
   }
  
   if(($status) && ($result1) && ($result2) && ($result3) && ($result4) )
    {
	
 if($golive=='1'){
	 $result12=$link->query("UPDATE `bme_analysis` SET `event_count`=`event_count`-1  WHERE month='$month' AND year='$year' ");
  $result13=$link->query("UPDATE `bme_analysis` SET `registration_count`=`registration_count`-$count  WHERE month='$month' AND year='$year' ");
  $result4=	$link->query("DELETE  FROM   bme_analysis1  WHERE  ename='$event_name' ");	
 }
     header("location:/BME/adminprofile.php?exist1=Mails sent");
    } 
}
	
 else{
	 $result1=$link->query("DELETE  FROM   timeslot  WHERE slno = '$timeslot' AND eslno='$slno' ");
	 $result3=	$link->query("DELETE  FROM   eventhost  WHERE  event_id='$slno' ");	
	 $result4=	$link->query("DELETE  FROM   event  WHERE  slno='$slno' ");	
	 if($golive=='1'){
	 $result12=$link->query("UPDATE `bme_analysis` SET `event_count`=`event_count`-1  WHERE month='$month' AND year='$year' ");
 }
	  
	  
	 if(($result1)  && ($result3)  && ($result4))
    {
	  header("location:/BME/Profile.php?exist1=Event Deleted");
 }
 }
	

?>