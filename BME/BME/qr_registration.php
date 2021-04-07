<?php include 'header.php';
include 'DB.php';

session_start();
$offset=$_SESSION['utc_offset'];
$error=$_GET['status'];
$tim=22;
 $scanner_id=$_SESSION['associateId'];
$event_id=$_GET['event_id'];
$event_name=$_GET['event_name'];
//$event_id='39';
//$event_name='TESTT';

 $today= date('Y-m-d');
 
 		

	?>





<div class="container-fluid">
    <br />
    <div class="card">
        <div class="card-body">
            <?php 
		
$check1=$link->query("select * from `event` where slno='$event_id' AND  ename='$event_name' AND edate>='$today'");
 $rows1=mysqli_fetch_row($check1);
if($rows1[0]>0){
	$event_name=$rows1[1];
	$event_date=$rows1[3];
	?>
            <div class="row">

                <div class="col-lg-8">
                    <br />

                    <h5 style="font-size:18px;font-weight:bold"> Event Name: <?php echo $event_name; ?> </h5>

                </div>

            </div>


            <form role="form" id="msform" method="post" action="qr_registration.php?id=<?php echo $event_id; ?>" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-1">
                        <div class="form-group">
                            <input type="hidden" id="event_id" name="event_id" value="<?php echo $event_id; ?>">
                            <label style="font-weight:bold"><b>Associate ID: </b></label>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <input style='font-size:15px;background-color:white;width:100%' class="form-control w3-border  w3-hover-border-blue" name="assoc_id" placeholder=" " required>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <button style="background-color:green;color:white" type="submit" name="save1" class="btn btn-default bg-olive">Search</button>
                    </div>
                </div>

            </form>

            <?php } ?>
            <?php 
if(isset($_POST['save1']))
{
	
$assoc_id=$_POST['assoc_id'];
$event_id=$_POST['event_id'];

$check3=$link->query("SELECT * FROM Head_Count WHERE Associate_Id = '$assoc_id'");
    $rows3=mysqli_fetch_row($check3);
	if($rows3[0]>=1)
    {
		$assoc_name=$rows3[1];
$email=$rows3[7];
$title=$rows3[5];
$Organization=$rows3[10];
$department=$rows3[11];
$executive=$rows3[13];
?>

            <div class="row">

                <div class="col-lg-12">
                    <form role="form" id="msform" method="post" action="qr_registration1.php" enctype="multipart/form-data">

                        <div class="form-group">
                            <input type="hidden" id="event_id" name="event_id" value="<?php echo $event_id; ?>">
                        </div>
                        <div class="form-group">
                            <input type="hidden" id="assoc_email" name="assoc_email" value="<?php echo $email; ?>">
                        </div>
                        <div class="form-group">
                            <br />
                            <label><b>Associate ID :</b></label>

                            <input style='font-size:15px;background-color:white;border:none' name="assoc_id" value="<?php echo $assoc_id; ?>" readonly>
                        </div>


                        <div class="form-group">

                            <label><b>Associate Name :</b></label>

                            <input style='font-size:15px;background-color:white;border:none' name="assoc_name" value="<?php echo $assoc_name; ?>" readonly>
                        </div>
                        <div class="form-group">

                            <label><b>Title:</b></label>

                            <input style='font-size:15px;background-color:white;border:none' name="title" value="<?php echo $title; ?>	 " readonly>
                        </div>

                        <div class="form-group">

                            <label><b>Department:</b></label>

                            <input style='font-size:15px;background-color:white;border:none' name="department" value="<?php echo $department; ?>" readonly>
                        </div>

                        <div class="form-group">

                            <label><b>Organization:</b></label>

                            <input style='font-size:15px;background-color:white;border:none' name="Organization" value="<?php echo $Organization; ?>	 " readonly>
                        </div>
                        <div class="form-group">

                            <label><b>Executive:</b></label>

                            <input style='font-size:15px;background-color:white;border:none' name="executive" value="<?php echo $executive; ?>" readonly>
                        </div>


                        <div class="form-group">
                            <label><b>Select Timeslot</b></label>
                            <?php
                                $query = $link->query("SELECT `slno`, CONVERT_TZ (DATE_FORMAT(`start`,'%Y-%m-%d %H:%i:%s'),'+00:00','$offset'),CONVERT_TZ (DATE_FORMAT(`end`,'%Y-%m-%d %H:%i:%s'),'+00:00','$offset') FROM timeslot WHERE eslno='$event_id'");
                                $rowCount = $query->num_rows;
                                ?>
                            <!--It works with onchange event-->
                            <select style='font-size:15px;background-color:white;' class="form-control w3-border select2 w3-hover-border-blue" name="slot" id="slot" required>
                                <option value="" selected hidden>Select Timeslot</option>
                                <?php
                                  if($rowCount > 0){
                                  while($row = $query->fetch_row()){

                                  echo '<option value="'.$row[0].'">'.$row[1].'</option>';
                                  }
                                }else{
                                  echo '<option value="">Timeslot not available</option>';
                                  }
                              ?>
                            </select>
                        </div>



                        <br /><button style="background-color:green;color:white" type="submit" name="save2" class="btn btn-default bg-olive">REGISTER ASSOCIATE</button>
                    </form>

                </div>
            </div>


            <?php 
    }

else { 
?>
            <h4 style="color:red"> <?php echo $assoc_id; ?> - Associate ID not found. </h4>

            <?php
}} ?>


        </div>
    </div>
    <?php 
    include 'footer.php';
?>
