<?php

include "DB.php";
include 'cal_invite_testevent.php';
session_start();
$slno=$_POST['slno'];
$approver_assoc_id=$_SESSION['associateId'];
 $today= date('Y-m-d');



$Rejectjustification=$_POST['Rejectjustification'];


 $event_date=$link->query("SELECT * FROM `emailbox` WHERE  slno='$slno'");
 $event_date1=mysqli_fetch_assoc($event_date);
 $assoc_id=$event_date1['assoc_id'];
 $assoc_name=$event_date1['assoc_name'];
  $requested_date=$event_date1['date'];
   $mailbox=$event_date1['mail_address'];
     $assoc_mail=$event_date1['assoc_mail'];
	 $reject_justification=$event_date1['reject_justification'];


  
   $arr=array();
	  $arr['assoc_id']=$assoc_id;
      $arr['assoc_name']=$assoc_name;
 $arr['assoc_mail']=$assoc_mail;
  $arr['requested_date']=$requested_date;
   $arr['mailbox']=$mailbox;
    $arr['Rejectjustification']=$Rejectjustification;
   
  
 template_mailbox_reject($arr);
 send_mail_mailbox_reject($assoc_mail,$assoc_name);

$result1=$link->query("UPDATE  emailbox SET action_by='$approver_assoc_id' , action_On='$today', reject_justification='$Rejectjustification'  WHERE  assoc_id='$assoc_id' AND slno='$slno'");

 echo "<script>window.location='/BME/Mailbox_Action.php'</script>";
?>