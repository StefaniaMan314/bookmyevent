<?php
include 'DB.php';
include 'cal_invite_testevent.php';
session_start();
/* Event date form event table */
$offset=$_SESSION['utc_offset'];
$event_id=$_GET['event_id'];
$event_date=$link->query("SELECT * FROM `event` WHERE  slno=$event_id");
 $event_date1=mysqli_fetch_assoc($event_date);
$date=$event_date1['edate'];
/*--------------*/
$assoc_id=$_SESSION['associateId'];
$assoc_name=$_SESSION['fullname'];
$email=$_SESSION['email'];
$role=$_SESSION['title'];
$Organization=$_SESSION['company'];
$department=$_SESSION['department'];
$Executive=$_SESSION['executive'];
$timeslot=$_GET['time'];
$timestamp=date('Y-m-d h:i:s');
$query="SELECT `timeslots`,CONVERT_TZ (DATE_FORMAT(`start`,'%Y-%m-%d %H:%i:%s'),'+00:00','$offset'),CONVERT_TZ (DATE_FORMAT(`end`,'%Y-%m-%d %H:%i:%s'),'+00:00','$offset'),`start`,`end`,`waitlist`,`location`   FROM `timeslot` WHERE `slno`='$timeslot' AND eslno='$event_id'";
$result = $link->query($query) or die("Error test : ".mysqli_error($link));
$arr=  mysqli_fetch_row($result);
$tim=$arr[0];
$start_time=$arr[1];
$end_time=$arr[2];
$start_time1=$arr[3];
$end_time1=$arr[4];
$timeslot_location=$arr[6];
$wait=$arr[5];
    $start_date=date('Y-m-d h:i a', strtotime($start_time));
$end_date=date('Y-m-d h:i a', strtotime($end_time));

$slot=$start_date.' - '.$end_date;

$start_date1=date('Y-m-d h:i a', strtotime($start_time1));
$end_date1=date('Y-m-d h:i a', strtotime($end_time1));


    $slot1=$start_date1.' - '.$end_date1;
	
	

$check1=$link->query("select COUNT(`slno`) from `testevent` where AssociateID='$assoc_id' AND event='$event_id'");
 $rows1=mysqli_fetch_row($check1);
if(intval($rows1[0])>=1){
 echo "<script>window.location='landing2.php'</script>";
}
else{
	
	$check12=$link->query("SELECT `Manager_Name` FROM `Head_Count` WHERE Associate_Id REGEXP '$assoc_id'") or die("Error 234 : ".mysqli_error($link));
 $rows12=mysqli_fetch_row($check12);
    $manager_name=$rows12[0];
	
	$manager_name=mysqli_real_escape_string($link,$manager_name);
 $check12=$link->query("SELECT `Global_Assignment` FROM `Head_Count` WHERE Associate_name='$manager_name'")or die("Error qwertt : ".mysqli_error($link));
 $rows12=mysqli_fetch_row($check12);
    $manager_email=$rows12[0];   
	
	
    $check12=$link->query("SELECT `eslno` FROM `timeslot` WHERE `slno`='$timeslot' AND eslno='$event_id'");
 $rows12=mysqli_fetch_row($check12);
    $eid=$rows12[0];
    $check1=$link->query("select count(*) from testevent where timeslot='$timeslot' AND event='$event_id'");
    $rows1=mysqli_fetch_row($check1);
	
    if(($rows1[0]>$tim) && $wait=0 )
    {
        $exist1="Already Full";
        header("location:Index.php?status=Sorry, but the slot is full.");
    }
	else
		{
      $result1=$link->query("INSERT INTO `testevent`(`AssociateID`, `AssociateName`, `email`, `Title`, `Organization`,`Executive`,`department`, `timeslot`, `timestamp`,`event`, `timeslot1`, `booked`) VALUES ('$assoc_id','$assoc_name','$email','$role','$Organization','$Executive','$department','$timeslot','$timestamp','$eid','$slot1',0)")  or die("Error test_uid: ".mysqli_error($link));
           $exist1="Thank you for Registering Waitlist";
    }

    
     if($result1)
    {
		 $check4=$link->query("SELECT count(slno) FROM `testevent` WHERE  `timeslot`=$timeslot  AND booked='0'");
 $check_waitnum=mysqli_fetch_row($check4);
 $wait_num =$check_waitnum[0]; 
 
    $event_date=$link->query("SELECT * FROM `event` WHERE `slno`= $event_id");
     $event_date1=mysqli_fetch_assoc($event_date);

    $event_name=$event_date1['ename'];
    $description=$event_date1['edesc'];
    $date=$event_date1['edate'];
    $location1=$event_date1['Location'];
	$emailbox=$event_date1['emailbox'];
      $from_name="Cerner India Events";
      $from_address="Cerner_India_Events@cerner.com";
      $to_name=$assoc_name;
      $to_address=$email;
      $startTime=$date." ".$start_time;
      $endTime=$date." ".$end_time;
      $subject=$event_name;
      $description="Its time for the event";
      $location=$location1;
      //$uid=sendIcalEvent_IST($from_name, $from_address, $to_name, $to_address, $startTime, $endTime, $subject, $description, $location);
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
	$arr['wait_num']=$wait_num;
	$arr['event_name']=$event_name;
	$arr['location']=$timeslot_location;
     $arr['timeslot']=$slot;
      template_wait($arr);
      send_mail($manager_email,$email,$event_name,$emailbox);
     // $update_result=$link->query("UPDATE `testevent` SET `uid`='$uid' WHERE `AssociateID`='$assoc_id' AND event='$event_id'");
      echo "<script>window.location='landing2.php'</script>";
    }}
?>
