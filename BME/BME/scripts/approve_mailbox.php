<?php

include "DB.php";
include 'cal_invite_testevent.php';
session_start();
$slno=$_GET['slno'];
$approver_assoc_id=$_SESSION['associateId'];


 $today= date('Y-m-d');

$justification=$_POST['justification'];


 $event_date=$link->query("SELECT * FROM `emailbox` WHERE  slno='$slno'");
 $event_date1=mysqli_fetch_assoc($event_date);
 $assoc_id=$event_date1['assoc_id'];
 $assoc_name=$event_date1['assoc_name'];
  $requested_date=$event_date1['date'];
   $mailbox=$event_date1['mail_address'];
     $assoc_mail=$event_date1['assoc_mail'];
   
    

$result1=$link->query("UPDATE  emailbox SET status='1' , action_by='$approver_assoc_id' , action_On='$today' WHERE  slno='$slno'");
//$result1=$link->query("INSERT INTO Associate ('id','name'role') VALUES ('$assoc_id','$assoc_name','Administrator')");


 $arr=array();
	  $arr['assoc_id']=$assoc_id;
      $arr['assoc_name']=$assoc_name;
 $arr['assoc_mail']=$assoc_mail;
  $arr['requested_date']=$requested_date;
   $arr['mailbox']=$mailbox;
   
	




 template_mailbox_approve($arr);
 send_mail_mailbox_approve($assoc_mail,$assoc_name);
 


 echo "<script>window.location='/BME/Mailbox_Action.php'</script>";
?>