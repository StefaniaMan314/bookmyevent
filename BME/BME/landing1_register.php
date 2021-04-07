<?php include 'header.php';
include 'DB.php';
include 'phpqrcode/qrlib.php'; 

session_start();


$event_id=$_GET['id'];
$assoc_id=$_GET['assoc_id'];


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


$check1=$link->query("select timeslot,CONCAT(`prefix`,`slno`)  from `testevent` where AssociateID='$assoc_id' AND event='$event_id'");
 $rows1=mysqli_fetch_row($check1);
$timeslot=$rows1[0];
$ref_id=$rows1[1];

  $text = "https://bookmyevent.cerner.com/BME/associate_attend.php?uid=$ref_id&assoc_id=$assoc_id";  
   
 $path = 'images/'; 
 $file = $path.uniqid().".png"; 
  
$ecc = 'M'; 
$pixel_Size = 7; 
$frame_Size = 7; 
  
// Generates QR Code and Stores it in directory given 
QRcode::png($text, $file, $ecc, $pixel_Size, $frame_size); 
?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="box-body">
                <center>
                    <h1 style='font-size:50px'><span class="fa-stack fa-lg w3-animate-zoom ">
  <i class="fa fa-circle fa-stack-2x" style='color:#29b7a5'></i>
  <i class="fa fa-check fa-stack-1x fa-inverse"></i>
</span></h1>
                    <h3 style='color:#0D94D2'>Thank you, but the Associate have already registered. </h3> 
					
					<?php  if($qrcode_status=='1'){
		 
		 ?>
		  <p style='font-size:20px;'> QR code has been sent to the associate in mail,
		 Please scan  the  QR code to mark the attendance.
   
		 </p>
		 <?php } 
		 else {?>
		 
		 <div class='col-lg-12'>
					
					 </div>
		 
		 <?php  } ?>
		 			 <br/>
					 		 <br/>
					<?php  if($food=='1'){
						?>
						<input type="button"  value="Update Food Preferences "   class="btn btn-default bg-olive"  id="btnHome" onClick="Javascript:window.location.href = 'foodselect_register.php?id=<?php echo $event_id; ?>&assoc_id=<?php echo $assoc_id; ?>';" />
					<?php } ?>
					 <br/>
		
<br/>

					
					
					
					<a class='btn btn-md btn-success' href='index.php'>HOME</a></center>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>