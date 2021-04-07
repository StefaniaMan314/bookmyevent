<?php

include "DB.php";
include 'cal_invite_testevent.php';
session_start();
$slno=$_GET['slno'];
$approver_assoc_id=$_SESSION['associateId'];


 $today= date('Y-m-d');

$justification=$_POST['justification'];


 $event_date=$link->query("SELECT * FROM `bme_access` WHERE  slno='$slno'");
 $event_date1=mysqli_fetch_assoc($event_date);
 $assoc_id=$event_date1['assoc_id'];
 $assoc_name=$event_date1['assoc_name'];
  $from_date=$event_date1['from_date'];
   $to_date=$event_date1['to_date'];
    $justification=$event_date1['justification'];
    $assoc_mail=$event_date1['assoc_mail'];

$result1=$link->query("UPDATE  bme_access SET status='1' , action_by='$approver_assoc_id' , action_On='$today' WHERE  slno='$slno'");
//$result1=$link->query("INSERT INTO Associate ('id','name'role') VALUES ('$assoc_id','$assoc_name','Administrator')");

 $result1=$link->query("SELECT  count(*)  FROM `Associate` WHERE `id`='$assoc_id'  ");
		  $rows1=mysqli_fetch_row($result1);
if((intval($rows1[0])==0)){
	
$result2=$link->query("INSERT INTO `Associate`(`id`, `name`, `role`) VALUES ('$assoc_id','$assoc_name','Administrator')");
}else{
	$result1=$link->query("UPDATE  Associate SET role='Administrator'  WHERE  id='$assoc_id'");
}
 $arr=array();
	  $arr['assoc_id']=$assoc_id;
      $arr['assoc_name']=$assoc_name;
 $arr['assoc_mail']=$assoc_mail;
  $arr['from_date']=$from_date;
   $arr['to_date']=$to_date;
    $arr['justification']=$justification;
	




 template_access_approve($arr);
 send_mail_access_approve($assoc_mail,$assoc_name);
 


 echo "<script>window.location='/BME/Request_Action.php'</script>";
?>