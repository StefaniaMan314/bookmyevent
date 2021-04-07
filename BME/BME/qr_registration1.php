<?php
include 'DB.php';
session_start();
include 'cal_invite_testevent.php';

/* Event date form event table */
$offset="+05:30";
$scanner_id="nr051235";
if(isset($_POST['save2']))
{
$event_id=$_POST['event_id'];
echo $event_id;
$timeslot=$_POST['slot'];
$assoc_id=$_POST['assoc_id'];
$assoc_name=$_POST['assoc_name'];
$email=$_POST['assoc_email'];
$role=$_POST['title'];
$department=$_POST['department'];
$Organization=$_POST['Organization'];
$Executive=$_POST['executive'];
		

//$event_date=$link->query("SELECT * FROM `event` WHERE  slno=$event_id");
//$event_date1=mysqli_fetch_assoc($event_date);
//$golive=$event_date1['golive'];
//$ename=$event_date1['ename'];
//
//$date=$event_date1['edate'];
//$d1= new DateTime($date);  
//$date= $d1->format('d');   
//$month= $d1->format('M'); 
//$year= $d1->format('Y'); 
//$monthh = $month . ' ' . $year;
///*--------------*/
//
//
////$timestamp=date('Y-m-d h:ia');
//$timestamp=date('Y-m-d h:i:s');
//
//
//$check12=$link->query("SELECT `Manager_Name` FROM `Head_Count` WHERE Associate_Id='$assoc_id'");
//$rows12=mysqli_fetch_row($check12);
//$manager_name=$rows12[0];
//	
//$check12=$link->query("SELECT `Global_Assignment` FROM `Head_Count` WHERE Associate_name='$manager_name'");
//$rows12=mysqli_fetch_row($check12);
//$manager_email=$rows12[0];   
//	
//	
//$query="SELECT `timeslots`,CONVERT_TZ (DATE_FORMAT(`start`,'%Y-%m-%d %H:%i:%s'),'+00:00','$offset'),CONVERT_TZ (DATE_FORMAT(`end`,'%Y-%m-%d %H:%i:%s'),'+00:00','$offset'),`start`,`end`,`waitlist`   FROM `timeslot` WHERE `slno`='$timeslot' AND eslno='$event_id'";
//$result = $link->query($query) or die("Error0 : ".mysqli_error($link));
//$arr=  mysqli_fetch_row($result);
//$tim=$arr[0];
//$start_time=$arr[1];
//$end_time=$arr[2];
//$start_time1=$arr[3];
//$end_time1=$arr[4];
//
//$wait=$arr[5];
//$start_date=date('Y-m-d h:i a', strtotime($start_time));
//$end_date=date('Y-m-d h:i a', strtotime($end_time));
//
//$slot=$start_date.' - '.$end_date;
//
//$start_date1=date('Y-m-d h:i a', strtotime($start_time1));
//$end_date1=date('Y-m-d h:i a', strtotime($end_time1));
//
//
//$slot1=$start_date1.' - '.$end_date1;
//$check1=$link->query("select COUNT(`slno`) from `testevent` where AssociateID='$assoc_id' AND event='$event_id'");
//$rows1=mysqli_fetch_row($check1);
//if(intval($rows1[0])>=1){
// echo "<script>window.location='landing1_register.php?id=$event_id&assoc_id=$assoc_id'</script>";
//}
//else{
//    $check12=$link->query("SELECT `eslno` FROM `timeslot` WHERE `slno`='$timeslot' AND eslno='$event_id'");
//    $rows12=mysqli_fetch_row($check12);
//    $eid=$rows12[0];  
//    $check1=$link->query("select count(*) from testevent where timeslot='$timeslot' AND event='$event_id'");
//    $rows1=mysqli_fetch_row($check1);
//	
//    if(($rows1[0]>$tim))
//    {
//        $exist1="Already Full";
//        header("location:Index.php?status=Sorry, but the slot is full.");
//    }
//	else{
//			
//
//        $result1=$link->query("INSERT INTO `testevent`(`AssociateID`, `AssociateName`, `email`, `Title`, `department`, `Organization`,  `Executive`, `timeslot`, `timestamp`,`event`, `timeslot1`, `booked`, `attend`, `attend_check`) VALUES ('$assoc_id','$assoc_name','$email','$role','$department','$Organization','$Executive','$timeslot','$timestamp','$eid','$slot1','1','1','$scanner_id')") or die("Error test1: ".mysqli_error($link));
//
//		 
//           $exist1="Thank you for Registering";
//		   if($golive=='1'){
//		    $result12=$link->query("UPDATE `bme_analysis` SET `registration_count`=`registration_count`+1  WHERE month='$month' AND year='$year' ");
//			$result22=$link->query("UPDATE `bme_analysis1` SET `registrations`=`registrations`+1  WHERE ename='$ename' AND month='$monthh' ");
//		   }
//    }
//    
//    if($result1)
//    {
//    $event_date2=$link->query("SELECT CONCAT(`prefix`,`slno`) AS 'UniqueID' FROM `testevent`  where AssociateID='$assoc_id' AND event='$event_id';");
//    $event_date3=mysqli_fetch_assoc($event_date2);
//
//    $ref_id=$event_date3['UniqueID'];
//
//    $event_date=$link->query("SELECT * FROM `event` WHERE `slno`= $event_id");
//    $event_date1=mysqli_fetch_assoc($event_date);
// 
//    $event_name=$event_date1['ename'];
//    $description=$event_date1['edesc'];
//    $date=$event_date1['edate'];
//    $location1=$event_date1['Location'];
//    $date11=date($event_date1['edate']);
//    $confirm_email=$event_date1['confirm_email'];
//    $invite_msg=$event_date1['invite_msg'];
//    $qrcode_status=$event_date1['qrcode_status'];
//    $file_loc=$event_date1['file_loc'];
//    $food=$event_date1['food'];
//
//    $country=$event_date1['country'];
//    $emailbox=$event_date1['emailbox'];
//    $from_name="$emailbox";
//    $from_address="$emailbox";
//    $to_name=$assoc_name;
//    $to_address=$email;
//    $startTime=$start_date1;
//    $endTime=$end_date1;
//    $subject=$event_name;
//    $description="Thankyou For Registering the Event";
//    $location=$location1;
//    $uid=sendIcalEvent_IST($from_name, $from_address, $to_name, $to_address, $startTime, $endTime, $subject, $description, $location,$emailbox);
//    if($uid)
//    {
//    echo "Sent invite\n";
//    }
//    $arr=array();
//    $arr['assoc_id']=$assoc_id;
//    $arr['assoc_name']=$assoc_name;
//    $date1=explode(' ',$startTime);
//    $date2=explode(' ',$endTime);
//    $start1=date('h:i a', strtotime($date1[1]));
//    $end1=date('h:i a', strtotime($date2[1]));
//    $arr['ref_id']=$ref_id;
//    $arr['event_name']=$event_name;
//    $arr['manager_name']=$manager_name;
//    $arr['confirm_email']=$confirm_email;
//    $arr['location']=$location1;
//    $arr['qrcode_status']=$qrcode_status;
//    $arr['file_loc']=$file_loc;
//    $arr['country']=$country;
//    $arr['timeslot']= strtoupper($slot);  
//    //send__register_mail($manager_email,$email,$event_name,$emailbox);
//    //template_manager($arr);
//    //send_mail_manager($manager_email,$event_name);
//	   // template($arr);
//  //send_mail($manager_email,$email,$event_name,$emailbox);
//  
//    $update_result=$link->query("UPDATE `testevent` SET `uid`='$uid' WHERE `AssociateID`='$assoc_id' AND event='$event_id'");
//    if($food=='1'){
//      echo "<script>window.location='foodselect.php?id=$event_id'</script>";
//	 } else {
//		 echo "<script>window.location='landing_register.php?id=$event_id'</script>";
//	 }
//    }
//}
}
?>
