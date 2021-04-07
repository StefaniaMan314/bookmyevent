 <?php 
include 'DB.php';
include "cal_invite_cancel_test.php";

session_start();
$slno=$_GET['slno'];
$assoc_id=$_GET['assoc_id'];
$event_id=$_GET['event_id'];

 $check1=$link->query("SELECT count(*) FROM `testevent` WHERE slno='$slno' AND AssociateID='$assoc_id' AND event='$event_id'");
    $rows1=mysqli_fetch_row($check1);
    //echo $rows1[0];


    if($rows1[0]>0)
    {

    $result1=$link->query("SELECT * FROM `testevent` WHERE `AssociateID`='$assoc_id' AND event='$event_id'");
    $arr_result=  mysqli_fetch_assoc($result1);
    $timeslot=$arr_result['timeslot'];
	$event_date=$link->query("SELECT * FROM `event` WHERE `slno`=$event_id");
    $event_date1=mysqli_fetch_assoc($event_date);
    $event_name=$event_date1['ename'];
$description=$event_date1['edesc'];
$date=$event_date1['edate'];
$golive=$event_date1['golive'];
$location1=$event_date1['Location'];
    $date11=date($event_date1['edate']);
    $uid=$arr_result['uid'];  // unique identifier of calendar invite
    $assoc_name=$arr_result['AssociateName'];
    $email=$arr_result['email'];
    // echo $uid."\n";
    $check1=$link->query("SELECT `timeslots`,`start`,`end`,`waitlist`,`location` FROM `timeslot` WHERE `slno`='$timeslot'");
     $rows1=mysqli_fetch_row($check1);
    $tim=$rows1[0];
    $start_time=$rows1[1];
    $end_time=$rows1[2];
$wait=$rows1[3];
$timeslot_location=$rows1[4];
   $date=$event_date1['edate'];
 
$d1= new DateTime($date);  
$date= $d1->format('d');   
$month= $d1->format('M'); 
 $year= $d1->format('Y'); 
$monthh = $month . ' ' . $year;

    /* For calendar */
    $from_name="Cerner India Events";
    $from_address="Cerner_India_Events@cerner.com";
    $to_name=$assoc_name;
    $to_address=$email;
    $startTime=$date11." ".$start_time;
    $endTime=$date11." ".$end_time;
    $subject=$event_name;
    $description="Sorry, Your registration has been cancelled by host. ";
    $location=$location1;
    $status=sendIcalEvent_IST_cancel($from_name, $from_address, $to_name, $to_address, $startTime, $endTime, $subject, $description, $timeslot_location, $uid);
	
    /*End*/
    if($status)
    {
      // echo "Cancelled invite\n";
    }
$result1=$link->query("INSERT INTO `cancel1`( `assoc_name`, `event_name`) VALUES ('$assoc_id','$event_name')");
    $result1=$link->query("DELETE FROM `testevent` WHERE `AssociateID`='$assoc_id' AND  event='$event_id'");
if($golive=='1'){
	
 $result12=$link->query("UPDATE `bme_analysis` SET `registration_count`=`registration_count`-1  WHERE month='$month' AND year='$year' ");
 $result22=$link->query("UPDATE `bme_analysis1` SET `registrations`=`registrations`-1  WHERE ename='$event_name' AND month='$monthh' ");
	}

   
  }
 ?>
      <h3 style="text-align:center;color:#FF0000">  Unregistered Associate</h3>
 