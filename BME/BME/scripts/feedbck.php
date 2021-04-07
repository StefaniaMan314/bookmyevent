<?php
include 'DB.php';
session_start();
$assoc_id=$_SESSION['associateId'];
$assoc_name=$_SESSION['fullname'];
//$event_num=$_GET['slot'];

$feed1=$_POST["rating"];
$comment=$_POST["comment"];
$comment=addslashes($comment);
$today= date('Y-m-d');
    $query="INSERT INTO `suggestions`(`assoc_id`, `assoc_name`,  `feeddate`, `rating`, `comments`,`notification_status`) VALUES ('$assoc_id','$assoc_name','$today','$feed1','$comment','0')";
$result = $link->query($query) or die("Error0 : ".mysqli_error($link));
header("location:/BME/Suggestionss.php?status=Thank you for your Suggestions."); 

?>


