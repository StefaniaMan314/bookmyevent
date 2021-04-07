<?php
include "DB.php";

$slno = $_GET['slno'];
$assoc_id = $_GET['assoc_id'];
   

    $check1=$link->query("SELECT * FROM `eventhost` WHERE slno='$slno' AND AssociateId='$assoc_id'");
    $rows1=mysqli_fetch_row($check1);
    //echo $rows1[0];


    if($rows1[0]>0)
    {
        $result1=$link->query("DELETE  FROM eventhost WHERE slno='$slno' AND AssociateId='$assoc_id'");
           $exist1="Associate Deleted";
		   
    }
     if($result1)
    {
        header("location:/BME/Add_Host.php?exist1=".$exist1);
    }




?>