<?php
include 'DB.php';
if(isset($_POST['save1']))
{
  
	$ud_ID = $_POST["ID"];
    $ud_associd = $_POST["assoc_id"];
    $ud_assocname =$_POST["assoc_name"];
    $event = $_POST["eventname"];
 

 
$check3=$link->query("SELECT ename FROM event WHERE slno = '$event'");
    $rows3=mysqli_fetch_row($check3);
	 
$event_name=$rows3[0];

		   

      $result1=$link->query("UPDATE eventhost  SET AssociateId = '$ud_associd', name = '$ud_assocname', event_id = '$event', event_name='$event_name'   WHERE slno='$ud_ID'");
           $exist1="Details Updated";
		   
		    if($result1)
    {
        header("location:/BME/Add_Host.php?exist1=".$exist1);
    }

}
?>