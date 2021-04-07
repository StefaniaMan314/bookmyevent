<?php

include "DB.php";
include 'cal_invite_testevent.php';
session_start();
$assoc_id=$_SESSION['associateId'];
$Organization=$_SESSION['company'];

$assoc_name=$_SESSION['fullname'];
$assoc_email=$_SESSION['email'];
$today= date('Y-m-d');

$mailbox=$_POST['mailbox'];
	  


  $arr=array();
	  $arr['assoc_id']=$assoc_id;
      $arr['assoc_name']=$assoc_name;
	  $arr['assoc_email']=$assoc_email;
      $arr['today']=$today;
      $arr['mailbox']=$mailbox;

$check1="INSERT INTO `emailbox`(`assoc_id`, `assoc_name`,`date`,`mail_address`,`assoc_Org`, `assoc_mail`) VALUES ('$assoc_id','$assoc_name','$today','$mailbox','$Organization','$assoc_email')";
$result = $link->query($check1) or die("Error0 : ".mysqli_error($link));

 template_mailbox_associate($arr);
 send_mail_mailbox_associate($assoc_email,$assoc_name);
 
 
 
  template_mailbox_team($arr); 
  send_mail_mailbox_team($assoc_email,$assoc_name);

 echo "<script>window.location='/BME/Add_Mail.php'</script>";
?>