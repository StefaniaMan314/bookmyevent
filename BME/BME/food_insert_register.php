<?php
include "DB.php";
session_start();




if(isset($_POST['save1']))
{


    $event_id=$_GET['id'];
	$assoc_id=$_GET['assoc_id'];
	
	
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
	





 $result1=$link->query("update testevent SET `breakfast`='$breakfast',`lunch`='$lunch',`socials`='$socials',`dietary`='$dietary'  WHERE AssociateID='$assoc_id'  AND event='$event_id'");
     if($result1)
    {
        header("location:landing_register.php?id=$event_id");
    }

}


?>