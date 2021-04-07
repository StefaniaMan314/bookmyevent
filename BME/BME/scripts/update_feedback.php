<?php
include 'DB.php';
 $today= date('Y-m-d');
 
 
if(isset($_POST['save1']))
{
    $ud_ID = $_POST["ID"];
    $developer = $_POST["developer"];
	$status=$_POST["status"];
	$assoc_id=$_POST["assoc_id"];
    
   $check1=$link->query("SELECT * FROM `suggestions` WHERE slno='$ud_ID' AND assoc_id='$assoc_id'");
    $rows1=mysqli_fetch_row($check1);
    echo $rows1[0];


    if($rows1[0]>0)
    {
        $result1=$link->query("UPDATE suggestions  SET status = '$status', developer = '$developer'   WHERE slno='$ud_ID' AND assoc_id='$assoc_id'");
           $exist1="Details Updated";
    }  
		    if($result1)
    {
        header("location:/BME/BME_Feedback.php?exist1=".$exist1);
    }

}
?>