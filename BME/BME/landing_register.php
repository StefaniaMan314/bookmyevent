<?php include 'header.php';
include 'phpqrcode/qrlib.php'; 

include 'DB.php';
session_start();

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


  
 
 
?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="box-body">
                <center>
                    <h1 style='font-size:50px;'><span class="fa-stack fa-lg w3-animate-zoom ">
  <i class="fa fa-circle fa-stack-2x" style='color:#29b7a5;height:30px'></i>
  <i class="fa fa-check fa-stack-1x fa-inverse" ></i>
</span></h1>
                    <h3 style='color:#0D94D2'>Thank you for registering.</h3>
                    <h5 style='color:#6A737B'>Associate will shortly receive a confirmation email.</h5>
					
					<?php  if($qrcode_status=='1'){
		 
		 ?>
		 <p style='font-size:20px;'> Associate's attendance has also been marked.
   
		 </p> 
		 <?php } 
		 else {?>
		 
		 <div class='col-lg-12'>
					
					 </div>
		 
		 <?php  } ?>
		 
		 <br/>

					<a class='btn btn-md btn-success' href='index.php'>HOME</a> </center>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>