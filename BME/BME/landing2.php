<?php include 'header.php';
include 'phpqrcode/qrlib.php'; 

session_start();
 $assoc_id=$_SESSION['associateId'];
$assoc_name=$_SESSION['fullname'];
$event_id=$_GET['id'];

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
<div class="container-fluid">
    <div class="card-body">
        <center>
            <h1 style='font-size:60px;'><span class="fa-stack fa-lg w3-animate-zoom ">
                    <i class="fas fa-circle fa-stack-2x" style='color:#29b7a5;height:30px'></i>
                    <i class="fas fa-check fa-stack-1x" style='color:#ffffff'></i>
                </span></h1>
            <h3 style='color:#0D94D2'>Thank you for registering.</h3>
            <h5 style='color:#6A737B'>You will shortly receive a confirmation email.</h5>

            <?php  if($qrcode_status=='1'){
		 
		 ?>
            <p style='font-size:15px;'> Please take a snapshot of the below QR code. Make sure you carry it to the event.
                <?php echo "<center><img src='".$file."' width='170px'></center>";   ?>
            </p>
            <?php } 
		 else {?>

            <div class='col-lg-12'>

            </div>

            <?php  } ?>

            <br />

            <a class='btn btn-md btn-success' href='index.php'>HOME</a> <button type="button" class='btn btn-sm btn-danger' onclick="location.href='scripts/testevent_cancel.php?assoc_id=<?php echo $assoc_id; ?>&event_id=<?php echo $event_id; ?>&timeslot=<?php echo $timeslot; ?>'">CANCEL REGISTRATION</button>
        </center>
    </div>
</div>
<?php include 'footer.php'; ?>
