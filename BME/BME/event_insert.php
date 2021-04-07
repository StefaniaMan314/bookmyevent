<?php
include "DB.php";

session_start();
$offset=$_SESSION['utc_offset'];
$assoc_id=$_SESSION['associateId'];
$assoc_name=$_SESSION['fullname'];
$assoc_name=mysqli_real_escape_string($link,$assoc_name);
$target = "uploads/";
$fileName = $_FILES['Filename']['name'];
$fileTarget = $target.$fileName;
$tempFileName = $_FILES["Filename"]["tmp_name"];
$result = move_uploaded_file($tempFileName,$fileTarget);


$ename=$_POST['ename'];
$ename=mysqli_real_escape_string($link,$ename);
$edesc=$_POST['edesc'];
$edesc=mysqli_real_escape_string($link,$edesc);
$edate=$_POST['edate'];
$country=$_POST['country'];

$type1=$_POST['type1'];
if(empty($_POST['country'])){
	   $country=' ';
   }
  
$date_final=date('Y-m-d',strtotime($edate));
$d1= new DateTime($date_final);
$date= $d1->format('d');   
$month= $d1->format('M'); 
 $year= $d1->format('Y'); 
$monthh = $month . ' ' . $year;
 
$Location=$_POST['Location'];
$emailbox=$_POST['emailbox'];

if(empty($_POST['emailbox'])){
	   $emailbox='BookMyEvent@cerner.com';
   }
   
   
if(empty($_POST['Location'])){
	   $Location='Online event';
   }
$confirm_email=$_POST['confirm_email'];
if(empty($_POST['confirm_email'])){
	   $confirm_email='Thank you for registering the event';
   }
$cal_invite=$_POST['cal_invite'];
if(empty($_POST['cal_invite'])){
	   $cal_invite='Its time for the event, Please carry your qr code to the event.';
   }
$file=$_POST['Filename'];
if($_POST['qrcode_status']=='yes'){
$qrcode_status="1";
}else{
    $qrcode_status="0";
}
if($_POST['go_live']=='yes'){
$golive="1";
}else{
    $golive="0";
}
if($_POST['food']=="1"){
$food=1;
}else{
    $food=0;
}
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
if($breakfast=='0' && $lunch=='0' && $socials=='0'){
    $food=0;
}

//INSERT INTO `event`( `edate`) VALUES (CONVERT_TZ('2018-12-19 12:15:00','-08:00','+00:00'))


$check1=$link->query("SELECT COUNT(*) FROM `event` WHERE ename='$ename' AND `golive`=1")  or die("Error0 : ".mysqli_error($link));
    $rows1=mysqli_fetch_row($check1);
    //echo $rows1[0];
    if($rows1[0]>0)
    {
        $exist1="Event already exist by Name ".$ename;
        header("location:Add_Event.php?exist1=".$exist1);
    }
    else
    {
        echo $date_final;
       $result1=$link->query("insert into event(`ename`, `edesc`, `edate`,`location`,`creator`,`golive`,`filename`,`file_loc`,`confirm_email`,`invite_msg`,`qrcode_status`,`country`,`emailbox`,`food`,`breakfast`,`lunch`,`socials`,`timezone`,`type1`) values ('$ename','$edesc',CONVERT_TZ('$date_final','$offset','+00:00'),'$Location','$assoc_id','$golive','$fileName','$fileTarget','$confirm_email','$cal_invite','$qrcode_status','$country','$emailbox','$food','$breakfast','$lunch','$socials','$offset','$type1')") or die("Error0 : ".mysqli_error($link));
	   

		$exist1="Event Added";
    }

	if(($result1) && ($golive=='1'))
		
    {
		$check1=$link->query("SELECT * FROM `bme_analysis` WHERE month='$month' AND year='$year'");
    $rows1=mysqli_fetch_row($check1);



    if($rows1[0]>0)
    {
        $result3=$link->query("UPDATE `bme_analysis` SET `event_count`=`event_count`+1  WHERE month='$month' AND year='$year' ");
    }
    else
    {
		
 $result4=$link->query("insert into bme_analysis( `month`, `year`,`event_count`) values ('$month','$year','1')");
 
 
	}
	
	
	$check2=$link->query("SELECT * FROM `bme_analysis1` WHERE ename='$ename' AND month='$monthh' AND date='$date'");
    $rows2=mysqli_fetch_row($check2);



    if($rows2[0]<=0)
    {
        $result6=$link->query("insert into bme_analysis1( `date`, `month`,`ename`,`registrations`) values ('$date','$monthh','$ename','0')");
    }
	
	
		
	}
	
	
	
     if($result1 )
    {
		
		$check1="SELECT slno FROM `event` WHERE ename='$ename'";
		$result = $link->query($check1) or die("Error0 : ".mysqli_error($link));
		$arr=  mysqli_fetch_row($result);
		$event_id=$arr[0];
		
		$result2=$link->query("insert into eventhost( `AssociateId`, `name`,`event_id`,`event_name`) values ('$assoc_id','$assoc_name','$event_id','$ename')");
        header("location:Add_Timeslot.php?exist1=".$exist1);
    }
	

	
	
	
	
 ?>
