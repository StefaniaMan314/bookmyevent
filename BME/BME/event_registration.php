<?php 
include 'header.php';
include 'phpqrcode/qrlib.php';
session_start();
$offset=$_SESSION['utc_offset'];
$assoc_id=$_SESSION['associateId'];

$event_id=$_GET['id'];

$today= date('Y-m-d');
   $check3=$link->query("SELECT ename,slno, `edesc`, `edate`,Location, `file_loc`,`golive`,`creator`,`type1`  FROM `event` WHERE  slno='$event_id'");
    $rows3=mysqli_fetch_row($check3);
$event_day=$rows3[3];
$type1=$rows3[8];
$event_type=$rows3[8];


if(($event_day>=$today)) {
	
$registered='No';
$check1=$link->query("select COUNT(`slno`) from `testevent` where AssociateID='$assoc_id' AND event='$event_id'");
 $rows1=mysqli_fetch_row($check1);
if(intval($rows1[0])>=1 && $type1!='multiple'){
 echo "<script>window.location='landing1.php?id=$event_id'</script>";
}
if(intval($rows1[0])>0){
    $registered='Yes';
}else{
    $registered='No';
}

$today= date('Y-m-d');
$check3=$link->query("SELECT ename,slno, `edesc`, `edate`,Location, `file_loc`,`golive`,`creator`,`type1`  FROM `event` WHERE  edate>='$today' AND slno='$event_id'");
$rows3=mysqli_fetch_row($check3);
$event=$rows3[0];
$description=$rows3[2];
$day=$rows3[3];
$location=$rows3[4];
$eimage=$rows3[5];
$golive=$rows3[6];
$creator_id=$rows3[7];
$type1==$rows3[8];
$check1=$link->query("select CONVERT_TZ (DATE_FORMAT(MIN(`start`),'%Y-%m-%d %H:%i:%s'),'+00:00','$offset') from `timeslot` where eslno='$event_id'");
 $rows1=mysqli_fetch_row($check1);
$event_start=$rows1[0];
$check3=$link->query("SELECT * FROM event WHERE slno = '$event_id'");
    $rows3=mysqli_fetch_row($check3);
	if($rows3[0]>=1)
    {
		$event_id=$rows3[0];
		$event_name=$rows3[1];

    }


 $text = "https://bookmyevent.cerner.com/BME/qr_registration.php?event_id=$event_id&event_name=$event_name";  
   
   $path = 'eventqr/'; 
$file = $path.uniqid().".png"; 
  
$ecc = 'S'; 
$pixel_Size = 5; 
$frame_Size = 5; 
  
// Generates QR Code and Stores it in directory given 
QRcode::png($text, $file, $ecc, $pixel_Size, $frame_size); 
?>
<div class="container-fluid">
    <br />
    <div class='card'>
        <div class='card-header'>
            <h4 style='color:#0D94D2'><strong><?php echo $event; ?></strong><?php 
   $check3=$link->query("SELECT COUNT(*)  FROM `eventhost` WHERE AssociateId = '$assoc_id' AND event_id='$event_id' AND event_name='$event_name'");
    $rows3=mysqli_fetch_row($check3);
	if(($rows3[0]>=1) || ($_SESSION['role']=='Super Admin')) 
    { ?> <span class='float-right'>
                    <a class='btn btn-primary btn-sm' href="external_mail.php?event_id=<?php echo $event_id; ?>" target="_blank"><b style='color:#ffffff'> Send External Mail</b></a> &nbsp;

                    <a class='btn btn-primary btn-sm' href="EditEvent.php?slno=<?php echo $event_id; ?>" target="_blank"><b style='color:#ffffff'>Edit Event</b></a>&nbsp;

                    <a class='btn btn-primary btn-sm' href="AnalysisTabs.php?id=<?php echo $event_id; ?>" target="_blank"><b style='color:#ffffff'>View Report</b></a></span>



                <?php } ?></h4>

        </div>
        <div class='card-body'>
            <div class='row'>
                <div class='col-lg-10'>
                    <strong><i class="fa fas fa-book mr-1"></i> Event Description</strong>
                    <p class="text-muted">
                        <?php echo $description; ?>
                    </p>
                    <div class='row'>
                        <div class='col-lg-3'>
                            <strong><i class="fa fas fa-user-cog"></i> Event By: </strong><?php echo $creator_id; ?>
                            <p class="text-muted"></p>
                        </div>
                        <div class='col-lg-3'>
                            <strong><i class="fa fas fa-map-marker-alt mr-1"></i> Where: </strong><?php echo $location; ?>
                            <p class="text-muted"></p>
                        </div>
                        <div class='col-lg-3'>
                            <strong><i class="fa fas fa-calendar-check"></i> When: </strong><?php echo $day; $d1= new DateTime( $day); echo " (".$d1->format('D').")"; ?>
                            <p class="text-muted">

                            </p>
                        </div>
                        <?php 
   $check3=$link->query("SELECT COUNT(*)  FROM `eventhost` WHERE AssociateId = '$assoc_id' AND event_id='$event_id' AND event_name='$event_name'");
    $rows3=mysqli_fetch_row($check3);
	if(($rows3[0]>=1) || ($_SESSION['role']=='Super Admin')) 
    { ?>
                        <div class='col-lg-3'>
                            <strong><i class="fa fas fa-qrcode"></i> QR code- </strong>
                            <br />
                            <div class="filtr-item col-lg-4" data-category="3" data-sort="red sample">
                                <a href="<?php echo $file;  ?>" data-toggle="lightbox" data-title="QR code">
                                    <img src="<?php echo $file;  ?>" class="img-fluid mb-2" alt="red sample" width="70%" />
                                </a>
                            </div>
                            <span>(Click to view and scan it for Walk-In registrations)</span>
                        </div><?php } ?>
                    </div>
                </div>
                <div class='col-lg-2'>
                    <div class="filtr-item" data-category="1" data-sort="white sample">
                        <a href="<?php echo $eimage; ?>" data-toggle="lightbox" data-title="<?php echo $event; ?>- image">
                            <div class='w3-round-large'>
                                <img src="<?php echo $eimage; ?>" class="img-fluid mb-2" alt="white sample" /></div>
                            <center><span>(Click to view)</span></center>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if($event_type=='multiple' && $registered=='Yes'){?>
    <div class='card'>
        <div class='card-header'>
            <h5 style="color:#0D94D2;font-size:14px"><b>Your Registrations </b></h5>
        </div>
        <div class='card-body'>
            <table class="table table-bordered  table-hover table-condensed">
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Associate Name</th>
                        <th>Associate Role</th>
                        <th>Date and Time</th>

                        <th>Action</th>
                    </tr>
                </thead>
                <tbody> <?php 
	$query1="SELECT t.`AssociateName`,t.`Title`,t.`timeslot`,e.`ename`,e.`edate`,e.`Location`,t.`event`,t.`timeslot1`  FROM `testevent` t ,`event` e where t.AssociateID='$assoc_id' AND e.`slno`=t.`event` AND e.`edate` >='$today' AND e.`slno`='$event_id' ORDER BY e.`ename` DESC";
		$result1=mysqli_query($link,$query1) or die();
while($arr1=  mysqli_fetch_assoc($result1)){ 
   $ename=$arr1['ename'];
	$elocation=$arr1['Location'];
	$edate=$arr1['edate'];
	$timeslot=$arr1['timeslot'];
    $timeslot_12=$arr1['timeslot'];
	$eslno=$arr1['event'];
	$timeslot1=$arr1['timeslot1'];
	$event_date=$edate;
if($arr1['AssociateName']!=''){
$query="SELECT `timeslots`,CONVERT_TZ (DATE_FORMAT(`start`,'%Y-%m-%d %H:%i:%s'),'+00:00','$offset'),CONVERT_TZ (DATE_FORMAT(`end`,'%Y-%m-%d %H:%i:%s'),'+00:00','$offset'),`start`,`end`,`waitlist` FROM `timeslot` WHERE slno='$timeslot'";
$result = $link->query($query) or die("Error0 : ".mysqli_error($link));
$arr=  mysqli_fetch_row($result); ?>
                    <?php
    $date1=$arr1['timeslot'];
    $test1=$arr1['AssociateName'];
    $start=$arr[1];
    $end=$arr[2];
	
	 $start_date=date('Y-m-d h:i a', strtotime($start));
$end_date=date('Y-m-d h:i a', strtotime($end));


    $timeslot=$start_date.' - '.$end_date;
?>
                    <tr>
                        <td>
                            <?php echo $ename; ?>
                        </td>
                        <td>
                            <?php echo $arr1['AssociateName']; ?>
                        </td>
                        <td>
                            <?php echo $arr1['Title']; ?>
                        </td>

                        <td>
                            <?php echo $timeslot; ?>
                        </td>
                        <td><a class='btn btn-sm btn-danger' onclick="alertify.confirm('Please Confirm', 'You are trying to Cancel your registration.', function(){ window.location='scripts/testevent_cancel.php?assoc_id=<?php echo $assoc_id; ?>&event_id=<?php echo $eslno; ?>&timeslot=<?php echo $timeslot_12; ?>'}
                , function(){ });">CANCEL</a></td>
                    </tr>
                    <?php  }}?>

                    <?php 
	$query1="SELECT t.`AssociateName`,t.`Title`,t.`timeslot`,e.`ename`,e.`edate`,e.`Location`,t.`event`,t.`timeslot1`  FROM `learningevent` t ,`event` e where t.AssociateID='$assoc_id' AND e.`slno`=t.`event` AND e.`edate` >='$today'  ORDER BY e.`ename` DESC";
		$result1=mysqli_query($link,$query1) or die();
while($arr1=  mysqli_fetch_assoc($result1)){ 
   $ename=$arr1['ename'];
	$elocation=$arr1['Location'];
	$edate=$arr1['edate'];
	$timeslot=$arr1['timeslot'];
    $timeslot_12=$arr1['timeslot'];
	$eslno=$arr1['event'];
	$timeslot1=$arr1['timeslot1'];
	$event_date=$edate;
if($arr1['AssociateName']!=''){
$query="SELECT `timeslots`,`start`,`end`,`start`,`end`,`waitlist` FROM `timeslot` WHERE slno='$timeslot'";
$result = $link->query($query) or die("Error0 : ".mysqli_error($link));
$arr=  mysqli_fetch_row($result); ?>
                    <?php
    $date1=$arr1['timeslot'];
    $test1=$arr1['AssociateName'];
    $start=$arr[1];
    $end=$arr[2];
	
	 $start_date=date('Y-m-d h:i a', strtotime($start));
$end_date=date('Y-m-d h:i a', strtotime($end));


    $timeslot=$start_date.' - '.$end_date;
?>
                    <tr>
                        <td>
                            <?php echo $ename; ?>
                        </td>
                        <td>
                            <?php echo $arr1['AssociateName']; ?>
                        </td>
                        <td>
                            <?php echo $arr1['Title']; ?>
                        </td>

                        <td>
                            <?php echo $timeslot; ?>
                        </td>
                        <td><a class='btn btn-sm btn-danger' onclick="alertify.confirm('Please Confirm', 'You are trying to Cancel your registration.', function(){ window.location='testevent_cancel1.php?assoc_id=<?php echo $assoc_id; ?>&event_id=<?php echo $eslno; ?>&timeslot=<?php echo $timeslot_12; ?>'}
                , function(){ });">CANCEL</a></td>
                    </tr>
                    <?php  }}?>
                </tbody>
            </table>
        </div>
    </div>
    <?php } ?>
    <div class='card'>
        <div class='card-header'>
            <h5 style="color:red;font-size:14px">Note: All timeslots are displayed as per your timezone (GMT <?php echo $offset; ?> hours ) </h5>
        </div>
        <div class='card-body'>
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <th style='text-align:center;'>Session </th>
                    <th style='text-align:center;'>Session Name</th>
                    <th style='text-align:center;'>Location</th>
                    <th style='text-align:center;'>Start Time</th>
                    <th style='text-align:center;'>End Time</th>
                    <th style='text-align:center;'>Register</th>
                    <th style='text-align:center;'>Available Registrations</th>
                    <th style='text-align:center;'>Available Waitlist</th>
                </thead>
                <tbody>
                    <?php
                                $i=0;
$query="SELECT `slno`, CONVERT_TZ (DATE_FORMAT(`start`,'%Y-%m-%d %H:%i:%s'),'+00:00','$offset'),CONVERT_TZ (DATE_FORMAT(`end`,'%Y-%m-%d %H:%i:%s'),'+00:00','$offset'), `eslno`, `timeslots`, `waitlist`, `session_name`, `location` FROM `timeslot` WHERE eslno='$event_id' AND slno NOT IN (SELECT `timeslot` FROM `testevent` WHERE `event`='$event_id' AND `AssociateID`='$assoc_id') AND DATE(`end`)>='$today' ORDER BY start ";
$result = $link->query($query) or die("Error_test1 : ".mysqli_error($link));
?>
                    <?php

						while($arr=mysqli_fetch_row($result)){
    $i++;
    $tim=$arr[4];
	$wait=$arr[5];
	$start_date=$arr[1];
    $end_date=$arr[2];
$start_date=date('Y-m-d h:i a', strtotime($start_date));
$end_date=date('Y-m-d h:i a', strtotime($end_date));
	$session_name=$arr[6];
		$timeslot_location=$arr[7];


                                ?>
                    <?php $check2=$link->query("select count(slno) from testevent where timeslot='$arr[0]'");
                                    $rows2=mysqli_fetch_row($check2); ?>
                    <?php  $check3=$link->query("select count(slno) from testevent where timeslot='$arr[0]' AND booked='0'");
                                    $rows3=mysqli_fetch_row($check3); ?>
                    <tr>
                        <td style='font-size:13px;text-align:center;'> <b><?php  echo $i; ?> </b>
                        </td>
                        <td style='font-size:13px;text-align:center;'> <b><?php echo  $session_name; ?> </b>
                        </td>
                        <td style='font-size:13px;text-align:center;'>
                            <?php echo $timeslot_location; ?>
                        </td>
                        <td style='font-size:13px;text-align:center;'>
                            <?php  $d1= new DateTime( $start_date); echo $d1->format(' M d Y - h:i a'); ?>
                        </td>
                        <td style='font-size:13px;text-align:center;'>

                            <?php  $d1= new DateTime( $end_date); echo $d1->format(' M d Y - h:i a'); ?>
                        </td>
                        <td style='font-size:13px;text-align:center;'>

                            <?php
    $vall=$rows2[0];
      $total=$tim;
                   $availwait =$rows3[0];                             ?> &nbsp;
                            <?php if($rows2[0]<$tim){ ?> <a class='btn btn-sm btn-success' onclick="alertify.confirm('Please Confirm', 'You are trying to register for <?php $d1= new DateTime( $start_date); echo $d1->format(' M d Y - h:i a'); ?> batch', function(){ window.location='timeslot.php?time=<?php echo $arr[0]; ?>&event_id=<?php echo $event_id; ?>'}
                , function(){ });">
                                Register
                            </a> &nbsp;&nbsp;



                            <?php } else if(($rows2[0]=$tim) && ($wait>0)) { ?> <a class='btn btn-sm btn-success' style='background-color:#FFA500' onclick="alertify.confirm('Please Confirm', 'You are trying to register for  <?php $d1= new DateTime( $start_date); echo $d1->format(' M d Y - h:i a'); ?> batch Waitlist', function(){ window.location='timeslot_testevent1.php?time=<?php echo $arr[0]; ?>&event_id=<?php echo $event_id; ?>'}
                , function(){ });">
                                Register Waitlist
                            </a> &nbsp;&nbsp;

                            <?php } else  { ?> <a class='btn btn-sm btn-primary' style='background-color:#ce1111' href='#'>Slot is full</a>&nbsp;&nbsp;</td>
                        <?php } ?>
                        <td style='font-size:13px;text-align:center;'> <b>

                                <?php if($rows2[0]<$tim){ ?> <?php echo $total-$vall;?> out of
                                <?php echo $tim;?> slots </b>


                            <?php } else if(($rows2[0]=$tim)) { ?>
                            Slot is Full
                            <?php } ?></td>
                        <td style='text-align:center;'>
                            <a class='label label-primary'>
                                <?php echo  $wait-$availwait;?>
                            </a>
                        </td>
                    </tr>
                    <?php
} ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php } else{ ?>
<h3 style="text-align:center"> Registration can't be completed!! Event is closed. </h3>
<?php } ?>
<?php 
include 'footer.php';
?>
