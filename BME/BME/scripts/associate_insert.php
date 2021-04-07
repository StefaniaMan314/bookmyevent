<?php
include "DB.php";
if(isset($_POST['save1']))
{


    $assoc_id=$_POST['assoc_id'];
    $assoc_name=$_POST['assoc_name'];
    $role=$_POST['eventname'];


    //echo $cid."\n".$location;

    $check1=$link->query("SELECT * FROM `Associate` WHERE id='$assoc_id'");
    $rows1=mysqli_fetch_row($check1);
    //echo $rows1[0];


    if($rows1[0]>0)
    {
        $exist1="Associate already exist by ID ".$assoc_id;
        header("location:/BME/Add_User.php?exist1=".$exist1);
    }
    else
    {
      $result1=$link->query("insert into Associate( `id`, `name`, `role`) values ('$assoc_id','$assoc_name','$role')");
           $exist1="Associate Added";
    }

     if($result1)
    {
        header("location:/BME/Add_User.php?exist1=".$exist1);
    }

}


?>