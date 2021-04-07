<?php
include "DB.php";
session_start();
$offset=$_SESSION['utc_offset'];

if(isset($_POST['save1']))
{
    $event_id=$_POST['eid'];
	$session_name=$_POST['session_name'];
    $session_location=$_POST['session_location'];
    $timeslots=$_POST['timeslots'];
    $waitlist=$_POST['waitlist'];
	$event_date=explode(' - ',$_POST['reservationtime']);
    $start_date=strtotime($event_date[0]);
    $end_date=strtotime($event_date[1]);   
    
    $start_date=date('Y-m-d H:i:s',$start_date);
    $end_date=date('Y-m-d H:i:s',$end_date);


    $result1=$link->query("insert into timeslot( `start`,`end`, `eslno`,`timeslots`,`waitlist`,`session_name`,`location`) values (CONVERT_TZ ('$start_date','$offset','+00:00'),CONVERT_TZ ('$end_date','$offset','+00:00'),'$event_id','$timeslots','$waitlist','$session_name','$session_location')");
     if($result1)
    {		 
        $check1=$link->query("select ename from `event` where slno='$event_id'");
         $rows1=mysqli_fetch_row($check1);
        $event_name=$rows1[0];


        $check1=$link->query("select CONVERT_TZ (DATE_FORMAT(MIN(`start`),'%Y-%m-%d %H:%i:%s'),'+00:00','$offset') from `timeslot` where eslno='$event_id'");
         $rows1=mysqli_fetch_row($check1);
        $event_start=$rows1[0];


        $event_date= substr($event_start,0,10);


        $result2=$link->query("UPDATE `event` SET `edate`='$event_date' WHERE `slno`='$event_id' AND `ename`='$event_name'");
		
        //        $result2=$link->query("UPDATE `timeslot` SET `start`=CONVERT_TZ (`start`,'$offset','+00:00'),`end`=CONVERT_TZ (`end`,'$offset','+00:00') WHERE `eslno`='$event_id' AND `start`='$start_date1' AND `end`='$end_date1' AND `session_name`='$session_name'");
        header("location:Add_Timeslot.php?exist1=Added Successfully");
    }else{
         header("location:Add_Timeslot.php?exist1=Please try again");
     }

}


?>
