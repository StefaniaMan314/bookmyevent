<?php 
include 'DB.php';
$role=$_GET['role'];

$query="DELETE FROM `headremove` WHERE Role='$role'";
$result=$link->query($query) or die("Error : ".mysqli_error($link));
//header("location:headReport1.php?page=1");
?>