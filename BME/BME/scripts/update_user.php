<?php
include 'DB.php';
if(isset($_POST['save1']))
{
    $ud_ID = $_POST["ID"];
    $ud_associd = $_POST["ud_associd"];
    $ud_assocname =$_POST["ud_name"];
    $ud_role = $_POST["eventname"];
   


      $result1=$link->query("UPDATE Associate  SET id = '$ud_associd', name = '$ud_assocname', role = '$ud_role'    WHERE slno='$ud_ID'");
           $exist1="Details Updated";
		   
		    if($result1)
    {
        header("location:/BME/Add_User.php?exist1=".$exist1);
    }

}
?>