<?php include 'header.php';
include 'phpqrcode/qrlib.php'; 

session_start();
 $assoc_id=$_SESSION['associateId'];
$assoc_name=$_SESSION['fullname'];
$event_id=$_GET['id'];
$offset=$_SESSION['utc_offset'];

$event_date=$link->query("SELECT * FROM `event` WHERE `slno`= $event_id");
 $event_date1=mysqli_fetch_assoc($event_date);
 
$event_name=$event_date1['ename'];
$description=$event_date1['edesc'];
$date=$event_date1['edate'];
$location1=$event_date1['Location'];
$date11=date($event_date1['edate']);
$confirm_email=$event_date1['confirm_email'];
$invite_msg=$event_date1['invite_msg'];
$qrcode_status=$event_date1['qrcode_status'];
$file_loc=$event_date1['file_loc'];
$food=$event_date1['food'];
$creator_id=$event_date1['creator'];


$check1=$link->query("select timeslot,CONCAT(`prefix`,`slno`)  from `testevent` where AssociateID='$assoc_id' AND event='$event_id'");
 $rows1=mysqli_fetch_row($check1);
$timeslot=$rows1[0];
$ref_id=$rows1[1];

  $text = "https://bookmyevent.cerner.com/BME/associate_attend.php?uid=$ref_id&assoc_id=$assoc_id";  
   
 $path = 'images/'; 
 $file = $path.uniqid().".png"; 
  
$ecc = 'S'; 
$pixel_Size = 5; 
$frame_Size = 5; 
  
// Generates QR Code and Stores it in directory given 
QRcode::png($text, $file, $ecc, $pixel_Size, $frame_size); 


$check1=$link->query("select CONVERT_TZ (DATE_FORMAT(MIN(`start`),'%Y-%m-%d %H:%i:%s'),'+00:00','$offset') from `timeslot` where eslno='$event_id'");
 $rows1=mysqli_fetch_row($check1);
$event_start=$rows1[0];

$today= date('Y-m-d');


$check3=$link->query("SELECT * FROM event WHERE slno = '$event_id'");
    $rows3=mysqli_fetch_row($check3);
	if($rows3[0]>=1)
    {
		$event_id=$rows3[0];
		$event_name=$rows3[1];
		$event_day = $rows3[3];

    }

if(($event_day>=$today)) {
	
	
 $text = "https://bookmyevent.cerner.com/BME/qr_registration.php?event_id=$event_id&event_name=$event_name";  
   
   $path = 'eventqr/'; 
$filee = $path.uniqid().".png"; 
  
$ecc = 'S'; 
$pixel_Size = 5; 
$frame_Size = 5; 
  
// Generates QR Code and Stores it in directory given 
QRcode::png($text, $filee, $ecc, $pixel_Size, $frame_size); 


?>
<style>
    .fa1-blue {
        color: #0D94D2;
    }

    .w3-light-green1 {
        background-color: #FFFFFF;
    }

</style>

<div class="container-fluid">
    <br />
    <div class='card'>
        <div class='card-header'>
            <h4 style='color:#0D94D2'><strong><?php echo $event_name; ?></strong></h4>
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
                            <strong><i class="fa fas fa-map-marker-alt mr-1"></i> Where: </strong><?php echo $location1; ?>
                            <p class="text-muted"></p>
                        </div>
                        <div class='col-lg-3'>
                            <strong><i class="fa fas fa-calendar-check"></i> When: </strong><?php echo $day; $d1= new DateTime( $day); echo " (".$d1->format('D').")"; ?>
                            <p class="text-muted">

                            </p>
                        </div>
                        <div class='col-lg-3'>
                            <strong><i class="fa fas fa-qrcode"></i> QR code- </strong>
                            <br />
                            <div class="filtr-item col-lg-4" data-category="3" data-sort="red sample">
                                <a href="<?php echo $file;  ?>" data-toggle="lightbox" data-title="QR code">
                                    <img src="<?php echo $file;  ?>" class="img-fluid mb-2" alt="red sample" width="70%" />
                                </a>
                            </div>
                            <span>(Click to view and scan it for Walk-In registrations)</span>
                        </div>
                    </div>
                </div>
                <div class='col-lg-2'>
                    <div class="filtr-item" data-category="1" data-sort="white sample">
                        <a href="<?php echo $file_loc; ?>" data-toggle="lightbox" data-title="<?php echo $event; ?>- image">
                            <div class='w3-round-large'>
                                <img src="<?php echo $file_loc; ?>" class="img-fluid mb-2" alt="Event Image" /></div>
                            <center><span>(Click to view)</span></center>
                        </a>

                    </div>
                </div>
            </div>
            <div class='row'>
                <div class='col-lg-12'>
                    <center>

                        <h3 style='color:#0D94D2;font-size:18px'>Thank you, but you have already registered. </h3>

                        <?php  if($qrcode_status=='1'){
		 
		 ?>
                        <p style='font-size:18px;'> Please take a snapshot of the below QR code. Make sure you carry it to the event.
                            <?php echo "<center><img src='".$file."'></center>";   ?>
                        </p>
                        <?php } 
		 else {?>

                        <div class='col-lg-12'>

                        </div>

                        <?php  } ?>

                        <br />
                        <?php  if($food=='1'){
						?>
                        <input type="button" value="Update Food Preferences " class="btn btn-default bg-olive" id="btnHome" onClick="Javascript:window.location.href = 'foodselect.php?id=<?php echo $event_id; ?>';" />
                        <?php } ?>




                        <a class='btn btn-sm btn-success' href='index.php'>HOME</a> <button type="button" class='btn btn-sm btn-danger' onclick="location.href='scripts/testevent_cancel.php?assoc_id=<?php echo $assoc_id; ?>&event_id=<?php echo $event_id; ?>&timeslot=<?php echo $timeslot; ?>'">CANCEL REGISTRATION</button>
                    </center>
                    <h5>Other Sessions</h5>
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <th style='text-align:center;'>Session </th>
                            <th style='text-align:center;'>Session Name</th>
                            <th style='text-align:center;'>Location</th>
                            <th style='text-align:center;'>Start Time</th>
                            <th style='text-align:center;'>End Time</th>

                            <th style='text-align:center;'>Available Registrations</th>
                            <th style='text-align:center;'>Available Waitlist</th>
                        </thead>
                        <tbody>
                            <?php
                                $i=0;
$query="SELECT `slno`, CONVERT_TZ (DATE_FORMAT(`start`,'%Y-%m-%d %H:%i:%s'),'+00:00','$offset'),CONVERT_TZ (DATE_FORMAT(`end`,'%Y-%m-%d %H:%i:%s'),'+00:00','$offset'), `eslno`, `timeslots`, `waitlist`, `session_name` FROM `timeslot` WHERE eslno='$event_id' ORDER BY start ";
$result = $link->query($query) or die("Error_test1 : ".mysqli_error($link));
$arr=  mysqli_fetch_row($result); ?>
                            <?php do{
    $i++;
    $tim=$arr[4];
	$wait=$arr[5];
	$start_date=$arr[1];
    $end_date=$arr[2];
$start_date=date('Y-m-d h:i a', strtotime($start_date));
$end_date=date('Y-m-d h:i a', strtotime($end_date));
	$session_name=$arr[6];

                                ?>
                            <?php $check2=$link->query("select count(slno) from testevent where timeslot='$arr[0]'");
                                    $rows2=mysqli_fetch_row($check2); ?>
                            <?php  $check3=$link->query("select count(slno) from testevent where timeslot='$arr[0]' AND booked='0'");
                                    $rows3=mysqli_fetch_row($check3); ?>
                            <tr>
                                <td style='font-size:15px;text-align:center;'> <b><?php  echo $i; ?> </b>
                                </td>
                                <td style='font-size:15px;text-align:center;'> <b><?php echo  $session_name; ?> </b>
                                </td>
                                <td style='font-size:15px;text-align:center;'>
                                    <?php echo $location1; ?>
                                </td>
                                <td style='font-size:15px;text-align:center;'>
                                    <?php  $d1= new DateTime( $start_date); echo $d1->format(' M d Y - h:i a'); ?>
                                </td>
                                <td style='font-size:15px;text-align:center;'>

                                    <?php  $d1= new DateTime( $end_date); echo $d1->format(' M d Y - h:i a'); ?>
                                </td>


                                <td style='font-size:15px;text-align:center;'> <b>

                                        <?php $vall=$rows2[0];
      $total=$tim;
                   $availwait =$rows3[0];            
				   
				   if($rows2[0]<$tim){ ?> <?php echo $total-$vall;?> out of
                                        <?php echo $tim;?> slots </b>


                                    <?php } else if(($rows2[0]=$tim) && ($wait>0)) { ?>
                                    Slot is Full
                                    <?php } ?></td>
                                <td style='text-align:center;'>
                                    <a class='label label-primary'>
                                        <?php echo  $wait-$availwait;?>
                                    </a>
                                </td>
                            </tr>
                            <?php
}while($arr=mysqli_fetch_row($result));?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php  }  else { ?>
<div class="container-fluid">
    <h3 style="text-align:center"> Sorry, Event is not Live to register. </h3>
</div>
<?php } ?> <?php include 'footer.php'; ?>
