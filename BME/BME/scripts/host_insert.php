<?php
include "DB.php";

if(isset($_POST['save1']))
{


    $assoc_id=$_POST['assoc_id'];
    $assoc_name=$_POST['assoc_name'];
    $event_id=$_POST['eventname'];



$check2=$link->query("select ename FROM `event` WHERE slno='$event_id'");
 $rows2=mysqli_fetch_row($check2);
$event_name=$rows2[0];

  

    $check1=$link->query("SELECT * FROM `eventhost` WHERE AssociateId='$assoc_id' AND eventid='$event_id'");
    $rows1=mysqli_fetch_row($check1);
    //echo $rows1[0];


    if($rows1[0]>0)
    {
        $exist1="Associate already exist by ID ".$assoc_id;
        header("location:AddHost.php?exist1=".$exist1);
    }
    else
    {
      $result1=$link->query("insert into eventhost( `AssociateId`, `name`, `event_id`,`event_name`) values ('$assoc_id','$assoc_name','$event_id','$event_name')");
           $exist1="Associate Added";
    }

     if($result1)
    {
        header("location:/BME/Add_Host.php?exist1=".$exist1);
    }

}


?>