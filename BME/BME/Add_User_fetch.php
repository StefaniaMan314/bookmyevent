<?php
include "DB.php";

$assoc_id=$_GET['id'];
//$assoc_id='mn051264';
if($assoc_id!=''){
$query1="SELECT `Business_Unit`,`Department`,`Associate_Name`,`Global_Assignment` FROM `Head_Count` WHERE `Associate_Id`='$assoc_id'";
$result1 = $link->query($query1) or die("Error0 : ".mysqli_error($link));
// $arr1=array();
$details=[];
$arr1= mysqli_fetch_row($result1);
//$details=array("b_unit"=>$arr1[0],"dept"=>$arr1[0]);
 // $details->b_unit=$arr1[0];
 // $details->dept=$arr1[1];

    array_push($details, [
      'b_unit'=>$arr1[0],
      'dept'=>$arr1[1],
      'name'=>$arr1[2],
      'email'=>$arr1[3]
    ]);

//echo "BLR";
echo json_encode($details);
//echo $details->bunit;
}


 ?>
