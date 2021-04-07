<?php
include 'DB.php';
include 'cal_invite_testevent.php';
session_start();
/* Event date form event table */
$offset=$_SESSION['utc_offset'];
$timeslot=$_GET['time'];
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
$Executive=$_SESSION['executive'];
$department=$_SESSION['department'];

$timestamp=date('Y-m-d h:ia');

 $check12=$link->query("SELECT `Manager_Name` FROM `Head_Count` WHERE Associate_Id='$assoc_id'");
 $rows12=mysqli_fetch_row($check12);
    $manager_name=$rows12[0];
	
 $check12=$link->query("SELECT `Global_Assignment` FROM `Head_Count` WHERE Associate_name='$manager_name'");
 $rows12=mysqli_fetch_row($check12);
    $manager_email=$rows12[0];   
	
	
 $query="SELECT `timeslots`,CONVERT_TZ (`start`,'+00:00','$offset'),CONVERT_TZ (`end`,'+00:00','$offset'),`start_date`,`end_date`,`waitlist`,`start`,`end`,`session_name`   FROM `timeslot` WHERE `slno`='$timeslot' AND eslno='$event_id'";
$result = $link->query($query) or die("Error0 : ".mysqli_error($link));
$arr=  mysqli_fetch_row($result);
$tim=$arr[0];
$start_time=$arr[1];
$end_time=$arr[2];
$start_time1=$arr[6];
$end_time1=$arr[7];
$session_name=$arr[8];
	$start_date=$arr[3];
		$end_date=$arr[4];
$wait=$arr[5];
    $start1=explode(':',$arr[1]);
    $start=$start1[0].':'.$start1[1];
    $end1=explode(':',$arr[2]);
    $end=$end1[0].':'.$end1[1];
     $start=date('h:i a', strtotime($start));
    $end=date('h:i a', strtotime($end));
    $slot=$start_date.'  '.$start.' - '.$end_date.'  '.$end;
$check1=$link->query("select COUNT(`slno`) from `testevent` where AssociateID='$assoc_id' AND event='$event_id'");
 $rows1=mysqli_fetch_row($check1);
if(intval($rows1[0])>=1){
 echo "<script>window.location='landing1.php?id=$event_id'</script>";
}
else{
    $check12=$link->query("SELECT `eslno` FROM `timeslot` WHERE `slno`='$timeslot' AND eslno='$event_id'");
 $rows12=mysqli_fetch_row($check12);
    $eid=$rows12[0];
    $check1=$link->query("select count(*) from testevent where timeslot='$timeslot' AND event='$event_id'");
    $rows1=mysqli_fetch_row($check1);
	
    if(($rows1[0]>$tim))
    {
        $exist1="Already Full";
        header("location:Index.php?status=Sorry, but the slot is full.");
    }
	else
		{
      $result1=$link->query("INSERT INTO `testevent`(`AssociateID`, `AssociateName`, `email`, `Title`, `department`, `Organization`,  `Executive`, `timeslot`, `timestamp`,`event`, `timeslot1`, `booked`) VALUES ('$assoc_id','$assoc_name','$email','$role','$department','$Organization','$Executive','$timeslot','$timestamp','$eid','$slot','1')");
           $exist1="Thank you for Registering";
    }

    
     if($result1)
    {
	
	 $event_date2=$link->query("SELECT CONCAT(`prefix`,`slno`) AS 'UniqueID' FROM `testevent`  where AssociateID='$assoc_id' AND event='$event_id';");
 $event_date3=mysqli_fetch_assoc($event_date2);

$ref_id=$event_date3['UniqueID'];

    $event_date=$link->query("SELECT * FROM `event` WHERE `slno`= $event_id");
 $event_date1=mysqli_fetch_assoc($event_date);
 
$event_name=$event_date1['ename'];
$description=$event_date1['edesc'];
$date=$event_date1['edate'];
$location1=$event_date1['Location'];
$date11=date($event_date1['edate']);
$confirm_email=$event_date1['confirm_email'];
$invite_msg=$event_date1['invite_msg'];
$qrcode_status=$event_date1['qrcode_status'];
$file_loc=$event_date1['file_loc'];
$food=$event_date1['food'];

$country=$event_date1['country'];
$emailbox=$event_date1['emailbox'];
      $from_name="$emailbox";
      $from_address="$emailbox";
      $to_name=$assoc_name;
      $to_address=$email;
      $startTime=$start_date." ".$start_time1;
      $endTime=$end_date." ".$end_time1;
      $subject=$event_name;
      $description=$invite_msg;
      $location=$location1;
      $uid=sendIcalEvent_IST($from_name, $from_address, $to_name, $to_address, $startTime, $endTime, $subject, $description, $location,$emailbox);
      if($uid)
      {
        echo "Sent invite\n";
      }
      $arr=array();
	  $arr['assoc_id']=$assoc_id;
      $arr['assoc_name']=$assoc_name;
    $date1=explode(' ',$startTime);
         $date2=explode(' ',$endTime);
         $start1=date('h:i a', strtotime($date1[1]));
    $end1=date('h:i a', strtotime($date2[1]));
	$arr['ref_id']=$ref_id;
	$arr['event_name']=$event_name;
	//$arr['session_name']=$session_name;
	$arr['manager_name']=$manager_name;
	$arr['confirm_email']=$confirm_email;
	$arr['location']=$location1;
		$arr['qrcode_status']=$qrcode_status;
		$arr['file_loc']=$file_loc;
		$arr['country']=$country;
     $arr['timeslot']= strtoupper($slot);
      template($arr);
  send_mail($manager_email,$email,$event_name,$emailbox);
	  //template_manager($arr);
      
	  //send_mail_manager($manager_email,$event_name);
     $update_result=$link->query("UPDATE `testevent` SET `uid`='$uid' WHERE `AssociateID`='$assoc_id' AND event='$event_id'");
    
 if($food=='1'){
      echo "<script>window.location='foodselect.php?id=$event_id'</script>";
	 } else {
		 echo "<script>window.location='landing2.php?id=$event_id'</script>";
	 }
    }}



?>
