<?php
include 'DB.php';
include "cal_invite_cancel_test.php";
include 'cal_invite_testevent.php';


  if(isset($_GET['assoc_id']) && isset($_GET['event_id'])  && isset($_GET['timeslot']))
  {
    $assoc_id=$_GET['assoc_id'];
$event_id=$_GET['event_id'];
      $timeslot=$_GET['timeslot'];
    $result1=$link->query("SELECT * FROM `testevent` WHERE `AssociateID`='$assoc_id' AND event='$event_id' AND timeslot='$timeslot'");
    $arr_result=  mysqli_fetch_assoc($result1);
	 $uid=$arr_result['uid'];  // unique identifier of calendar invite
    $assoc_name=$arr_result['AssociateName'];
    $email=$arr_result['email'];
	
	$event_date=$link->query("SELECT * FROM `event` WHERE `slno`=$event_id");
    $event_date1=mysqli_fetch_assoc($event_date);
    $event_name=$event_date1['ename'];
$description=$event_date1['edesc'];
 $golive=$event_date1['golive'];

$date=$event_date1['edate'];
$d1= new DateTime($date);  
$date= $d1->format('d');   
$month= $d1->format('M'); 
 $year= $d1->format('Y'); 
$monthh = $month . ' ' . $year;
$location1=$event_date1['Location'];
$from_address=$event_date1['emailbox'];

    $date11=date($event_date1['edate']);
   
    // echo $uid."\n";
    $check1=$link->query("SELECT `timeslots`,`start`,`end`,`waitlist`,`eslno`,`location` FROM `timeslot` WHERE `slno`='$timeslot'");
     $rows1=mysqli_fetch_row($check1);
    $tim=$rows1[0];
    $start_time=$rows1[1];
    $end_time=$rows1[2];
$wait=$rows1[3];
$timeslot_location=$rows1[5];

   $date=$event_date1['edate']; 


$start_date1=date('Y-m-d h:i a', strtotime($start_time));
$end_date1=date('Y-m-d h:i a', strtotime($end_time));


	
	
    /* For calendar */
    $from_name=$event_date1['emailbox'];

    $to_name=$assoc_name;
    $to_address=$email;
    $startTime=$start_date1;
    $endTime=$end_date1;
    $subject=$event_name;
    $description="Your registration is cancelled.";
    $location=$location1;
	echo $endTime;
    $status=sendIcalEvent_IST_cancel($from_name, $from_address, $to_name, $to_address, $startTime, $endTime, $subject, $description, $timeslot_location, $uid);
	
    /*End*/
    if($status)
    {
      // echo "Cancelled invite\n";
    }
$result1=$link->query("INSERT INTO `cancel1`( `assoc_name`, `event_name`) VALUES ('$assoc_id','$event_name')");
    $result1=$link->query("DELETE FROM `testevent` WHERE `AssociateID`='$assoc_id' AND  event='$event_id' AND timeslot='$timeslot'");
	if($golive=='1'){
	
 $result12=$link->query("UPDATE `bme_analysis` SET `registration_count`=`registration_count`-1  WHERE month='$month' AND year='$year' ");
 $result22=$link->query("UPDATE `bme_analysis1` SET `registrations`=`registrations`-1  WHERE ename='$event_name' AND month='$monthh' ");
	}
    if($result1)
   {
       header("location:/BME/index.php?status=Your registration has been cancelled");
	 $result1=$link->query("SELECT * FROM  `testevent` WHERE `booked`='0' LIMIT 1 ");
	 $wait_result1=mysqli_fetch_assoc($result1);
	$assoc_id =$wait_result1['AssociateID'];
	 $assoc_name=$wait_result1['AssociateName'];
	 $email=$wait_result1['email'];
	   if($result1)
	   {
		    
	   $update_result1=$link->query("UPDATE `testevent` SET `booked`='1' WHERE `booked`='0' AND  event='$event_id' LIMIT 1 ");
	    if($update_result1)
	   {
	    $event_date=$link->query("SELECT * FROM `event` WHERE `slno`= $event_id");
 $event_date1=mysqli_fetch_assoc($event_date);
$event_name=$event_date1['ename'];
$description=$event_date1['edesc'];
$date=$event_date1['edate'];
$location1=$event_date1['Location'];
$emailbox=$event_date1['emailbox'];
      $from_name="$emailbox";
     $from_address="$emailbox";
      $to_name=$assoc_name;
      $to_address=$email;
      $startTime=$date." ".$start_time;
      $endTime=$date." ".$end_time;
      $subject=$event_name;
      $description="Its time for the event";
      $location=$location1;
       $ref_id="";
       $assoc_id="";
      $uid=sendIcalEvent_IST($from_name, $from_address, $to_name, $to_address, $startTime, $endTime, $subject, $description, $location,$emailbox,$ref_id,$assoc_id);
            
//      $uid=sendIcalEvent_IST($from_name, $from_address, $to_name, $to_address, $startTime, $endTime, $subject, $description, $timeslot_location,$emailbox,$ref_id,$assoc_id);
      if($uid)
      {
        echo "Sent invite\n";
      }
      $arr=array();
      $arr['assoc_name']=$assoc_name;
    $date1=explode(' ',$startTime);
         $date2=explode(' ',$endTime);
         $start1=date('h:i a', strtotime($date1[1]));
    $end1=date('h:i a', strtotime($date2[1]));
	$arr['event_name']=$event_name;
	$arr['location']=$timeslot_location;
     $arr['timeslot']= strtoupper($date1[0]." ".$start1." - ".$end1);
      template($arr);
      send_mail($email,$event_name);
      $update_result=$link->query("UPDATE `testevent` SET `uid`='$uid' WHERE `AssociateID`='$assoc_id' AND event='$event_id'");
      echo "<script>window.location='/BME/landing2.php'</script>";
	   }}
   }
    
   
  }
?>
