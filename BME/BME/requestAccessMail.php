<?php

include "DB.php";
include 'cal_invite_testevent.php';
session_start();
$assoc_id=$_SESSION['associateId'];
$Organization=$_SESSION['company'];

$assoc_name=$_SESSION['fullname'];
$assoc_email=$_SESSION['email'];
  $today= date('Y-m-d');

   $eventscount=$_POST['eventscount'];
	  
$fromdate=$_POST['fromdate'];
$fromdate_final=date('Y-m-d',strtotime($fromdate));



$todate=$_POST['todate'];
$todate_final=date('Y-m-d',strtotime($todate));

if(empty($_POST['fromdate'])){
	$fromdate_final=$today;
}
 
 if(empty($_POST['todate'])){
 
 $today= date('Y-m-d');
$today1 = strtotime($today);
$new_date = strtotime('+ 1 year', $today1);
$todate_final= date('Y-m-d', $new_date);

 }
$justification=$_POST['justification'];


  $arr=array();
	  $arr['assoc_id']=$assoc_id;
      $arr['assoc_name']=$assoc_name;
 $arr['assoc_email']=$assoc_email;
  $arr['fromdate_final']=$fromdate_final;
   $arr['todate_final']=$todate_final;
    $arr['justification']=$justification;

$result1=$link->query("INSERT INTO `bme_access`(`assoc_id`, `assoc_name`, `assoc_mail`,`from_date`, `to_date`, `justification`,`Organization`,`Requested_On`,`upcoming_events`) VALUES ('$assoc_id','$assoc_name','$assoc_email','$fromdate_final','$todate_final','$justification','$Organization','$today','$eventscount')");



 template_access_associate($arr);
 send_mail_access_associate($assoc_email,$assoc_name);
 
 
 
  template_access_team($arr); 
  send_mail_access_team($assoc_email,$assoc_name);

echo "<script>window.location='index.php'</script>";
?>
