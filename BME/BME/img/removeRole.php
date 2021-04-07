<?php 
include 'DB.php';
$role=$_GET['role'];
$num=$_GET['num'];
$query="INSERT INTO `headremove`(`role`, `count`) VALUES ('$role','$num')";
$result=$link->query($query) or die("Error : ".mysqli_error($link));
//header("location:headReport1.php?page=1");
?>