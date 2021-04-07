<?php
include "DB.php";
session_start();

$assoc_id=$_SESSION['associateId'];


if(isset($_POST['save1']))
{


    $event_id=$_GET['id'];
	
	
	$breakfast=$_POST['breakfast'];
if($breakfast=="on"){
	$breakfast='1';
}
else{
	$breakfast='0';
}
$lunch=$_POST['lunch'];
if($lunch=="on"){
	$lunch='1';
}
else{
	$lunch='0';
}
$socials=$_POST['socials'];
if($socials=="on"){
	$socials='1';
}
else{
	$socials='0';
}

$dietary=$_POST['dietary'];
	


$check1=$link->query("select type1 from `event` where slno='$event_id'") or die("Error test1: ".mysqli_error($link));
 $rows1=mysqli_fetch_row($check1);
    $type1=$rows1[0];


 $result1=$link->query("update testevent SET `breakfast`='$breakfast',`lunch`='$lunch',`socials`='$socials',`dietary`='$dietary'  WHERE AssociateID='$assoc_id'  AND event='$event_id'");
     if($result1)
    {
    if($type1=='multiple'){
         echo "<script>window.location='Event_Registration.php?id=$event_id'</script>";
     }
     else{
		 echo "<script>window.location='landing2.php?id=$event_id'</script>";
     }
    }
    
    

}


?>
