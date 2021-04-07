<?php

include "DB.php";
include 'cal_invite_testevent.php';
session_start();
$slno=$_POST['slno'];
$approver_assoc_id=$_SESSION['associateId'];
 $today= date('Y-m-d');



$Rejectjustification=$_POST['Rejectjustification'];


 $event_date=$link->query("SELECT * FROM `bme_access` WHERE  slno='$slno'");
 $event_date1=mysqli_fetch_assoc($event_date);
 $assoc_id=$event_date1['assoc_id'];
 $assoc_name=$event_date1['assoc_name'];
  $from_date=$event_date1['from_date'];
   $to_date=$event_date1['to_date'];
    $justification=$event_date1['justification'];
    $assoc_mail=$event_date1['assoc_mail'];



 $arr=array();
	  $arr['assoc_id']=$assoc_id;
      $arr['assoc_name']=$assoc_name;
 $arr['assoc_mail']=$assoc_mail;
  $arr['from_date']=$from_date;
   $arr['to_date']=$to_date;
    $arr['justification']=$justification;
  $arr['Rejectjustification']=$Rejectjustification;
  
  
  
 template_access_reject($arr);
 send_mail_access_reject($assoc_mail,$assoc_name);

$result1=$link->query("UPDATE  bme_access SET action_by='$approver_assoc_id' , action_On='$today', reject_justification='$Rejectjustification'  WHERE  assoc_id='$assoc_id' AND slno='$slno'");

 echo "<script>window.location='/BME/Request_Action.php'</script>";
?>