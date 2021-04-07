<?php
include "DB.php";


  session_start();
$id=$_GET['id'];

if($id=='10'){
$_SESSION['role']="Super Admin";
 header("location:../index.php");
}

else  if($id=='15'){
$_SESSION['role']="Administrator";
 header("location:../index.php");

}
else if($id=='20'){
$_SESSION['role']="Associate"; 
 header("location:../index.php");


}



?>
