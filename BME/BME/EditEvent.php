<?php include 'header.php';
session_start();
$assoc_id=$_SESSION['associateId'];
$assoc_name=$_SESSION['fullname'];




$slno=$_GET['slno'];

$check3=$link->query("SELECT * FROM event WHERE slno = '$slno'");
    $rows3=mysqli_fetch_row($check3);
	if($rows3[0]>=1)
    {
		$event_name=$rows3[1];
$edesc=$rows3[2];
$edate=$rows3[3];
$location=$rows3[4];
$creator=$rows3[5];
$golive=$rows3[6];
$filename=$rows3[7];
$file_loc=$rows3[8];
$confirm_email=$rows3[9];
$invite_msg=$rows3[10];
if(empty($invite_msg)){
	$invite_msg="Its time for the event. carry your qr code to the event.";
}
$email_box=$rows3[13];
$country=$rows3[12];
$qrcode_status=$rows3[11];



    }

	
?>

<div class="container-fluid">
    <br />
    <div class="card">
        <div class="card-header p-2">
            <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Event</a></li>
                <li class="nav-item"><a class="nav-link" href="#upcoming" data-toggle="tab">Timeslot</a></li>
            </ul>
        </div><!-- /.card-header -->
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane active" id="activity">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label><b> Event Image </b></label>
                                <a href="<?php echo $file_loc; ?>" data-toggle="lightbox" data-title="<?php echo $event; ?>- image">
                                    <div class='w3-round-large'>
                                        <img src="<?php echo $file_loc; ?>" class="img-fluid mb-2" alt="white sample" /></div>
                                    <center><span>(Click to view)</span></center>
                                </a>
                            </div>
                            <div>
                                <iframe frameborder="0" scrolling="no" ; style="overflow:hidden;" src="imagevalidation.php?slno=<?php echo $slno; ?>" width="350px" height="500px"> </iframe>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <form role="form" id="regForm" method="post" action="UpdateEvent.php?slno=<?php echo $slno; ?>" enctype="multipart/form-data">

                                <div class="form-group">


                                    <h5 style="color:red;font-size:15px"> Note: Mail will be sent to registered Associates if Date/Location are updated.
                                    </h5>
                                </div>


                                <div class="form-group">
                                    <label><b>Event Name</b></label>
                                    <p><input placeholder=" " oninput="this.className = ''" name="ename" value="<?=$event_name;?>"></p>
                                </div>
                                <div class="form-group">
                                    <label><b>Event Description</b></label><br />
                                    <textarea style="min-width:100%;max-width:100%;font-size:15px" oninput="this.className = ''" name="edesc"> <?php echo $edesc;?> </textarea>
                                </div>
                                <div class='row'>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label><b>Date</b></label>
                                            <p> <input name="edate" id="datepicker" placeholder="Event Date" value="<?=$edate;?>"></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label><b>Event Location</b></label>
                                            <p><input placeholder=" " rows="5" cols="10" oninput="this.className = ''" name="Location" value="<?=$location;?>"></p>
                                        </div>
                                    </div>
                                </div>


                                <!-- <div class="form-group">
                                 <label><b>Select Mailbox</b></label>  
								 
                                    <?php
                                $query = $link->query("SELECT * FROM emailbox");
                                $rowCount = $query->num_rows;
                                ?>
                                       
                                        <select style='font-size:15px;background-color:white;width:100%' class="form-control w3-border select2 w3-hover-border-blue" name="emailbox" id="emailbox" required>
                                            <option value="" selected hidden>Select Mailbox</option>
                                            <?php
                                  if($rowCount > 0){
                                  while($row = $query->fetch_assoc()){

                                  echo '<option value="'.$row['mail_address'].'">'.$row['mail_address'].'</option>';
                                  }
                                }else{  
                                  echo '<option value="">Mailbox not available</option>';
                                  }
                              ?>
                                        </select>
                                </div>   -->

                                <div class="form-group">
                                    <label><b>Confirmation Email Message </b></label><br />
                                    <textarea style="min-width:100%;height:100px;max-width:100%;font-size:15px" oninput="this.className = ''" name="confirm_email"> <?php  echo $confirm_email; ?></textarea>

                                </div>
                                <div class="form-group">
                                    <label><b>Cal Invite Email Message </b></label><br />
                                    <textarea style="min-width:100%;height:100px;max-width:100%;font-size:15px" oninput="this.className = ''" name="invite_msg"><?php  echo $invite_msg; ?> </textarea>
                                </div>


                                <div class='row'>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label><b>Go Live</b></label><br />
                                            <select style='font-size:15px;background-color:white;width:70%' oninput="this.className = ''" class="form-control w3-border select2 w3-hover-border-blue" id="golive" oninput="this.className = ''" name='golive' placeholder=" " required>
                                                <?php  if($golive==0) { ?> <option value="<?=$golive;?>"> No </option>
                                                <option value="1">Yes</option>
                                                <?php } else { ?>
                                                <option value="<?=$golive;?>"> Yes </option>
                                                <option value="0">No</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label><b>QR Code</b></label><br />
                                            <select style='font-size:15px;background-color:white;width:70%' oninput="this.className = ''" class="form-control w3-border select2 w3-hover-border-blue" id="qrcode_status" oninput="this.className = ''" name='qrcode_status' placeholder=" " required>
                                                <?php  if($qrcode_status==0) { ?> <option value="<?=$qrcode_status;?>"> No </option>
                                                <option value="1">Yes</option>
                                                <?php } else { ?>
                                                <option value="<?=$qrcode_status;?>"> Yes </option>
                                                <option value="0">No</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>




                                <button type="submit" name="save1" class="btn btn-default bg-olive"> Update </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="upcoming">
                    <h1 style="text-align:left;font-size:20px;font-weight:bold">Edit Timeslot</h1>

                    <h3 style="text-align:left;color:#0D94D2;"> <b> <?php echo $event_name; ?></b></h3>

                    <div class="table-responsive">
                        <table id='example1' class="table table-bordered table-hover table-striped">
                            <thead>
                                <th style='text-align:center;'>Session</th>
                                <th style='text-align:center;'>Location</th>
                                <th style='text-align:center;'>Start Time</th>
                                <th style='text-align:center;'>End Time</th>
                                <th style='text-align:center;'>Action</th>
                                <th style='text-align:center;'>Available Registrations</th>
                                <th style='text-align:center;'>Available Waitlist</th>

                            </thead>
                            <tbody>
                                <?php
                                $i=0;
$query="SELECT `timeslots`,CONVERT_TZ (DATE_FORMAT(`start`,'%Y-%m-%d %H:%i:%s'),'+00:00','$offset'),CONVERT_TZ (DATE_FORMAT(`end`,'%Y-%m-%d %H:%i:%s'),'+00:00','$offset'),`start`,`end`,`waitlist`,`session_name` ,`slno`,`location` FROM `timeslot` WHERE eslno='$slno' ORDER BY start ";
$result = $link->query($query) or die("Error0 : ".mysqli_error($link));
 ?>
                                <?php while($arr=mysqli_fetch_row($result)){
    $i++;
    $tim=$arr[0];
	
	$wait=$arr[5];
	$start_date=$arr[1];
		$end_date=$arr[2];

	$session_name=$arr[6];
	$session_location=$arr[8];

	
	 $start_date=date('Y-m-d h:i a', strtotime($start_date));
$end_date=date('Y-m-d h:i a', strtotime($end_date));

   
    $timeslot=$start_date.'  -  '.$end_date;
	

                                ?>
                                <?php $check2=$link->query("select count(slno) from testevent where timeslot='$arr[7]'");
                                    $rows2=mysqli_fetch_row($check2); ?>
                                <?php  $check3=$link->query("select count(slno) from testevent where timeslot='$arr[7]' AND booked='0'");
                                    $rows3=mysqli_fetch_row($check3); ?>
                                <tr>
                                    <td style='font-size:15px;text-align:center;'> <b><?php echo $i; ?></b>
                                        <br /> </td>
                                    <td style='font-size:15px;text-align:center;'>
                                        <?php echo $session_location; ?>
                                    </td>
                                    <td style='font-size:15px;text-align:center;'>
                                        <?php echo $start_date; ?>
                                    </td>
                                    <td style='font-size:15px;text-align:center;'>

                                        <?php echo $end_date; ?>
                                    </td>
                                    <td style='font-size:15px;text-align:center;'>

                                        <?php
    $vall=$rows2[0];
      $total=$tim;
                   $availwait =$rows3[0];                             ?> &nbsp;
                                        <a class='btn btn-sm btn-primary' onclick="alertify.confirm('Please Confirm', 'You are trying to edit the timeslot <?php echo $timeslot; ?> batch', function(){ window.location='timeslot_edit.php?time=<?php echo $arr[7]; ?>&slno=<?php echo $slno; ?>'}
                , function(){ });">
                                            Edit
                                        </a> &nbsp;&nbsp;
                                        <a class='btn btn-sm btn-danger' onclick="alertify.confirm('Please Confirm', 'You are trying to <b> delete </b> the timeslot <?php echo $timeslot; ?> batch', function(){ window.location='timeslot_delete.php?time=<?php echo $arr[7]; ?>&slno=<?php echo $slno; ?>'}
                , function(){ });">
                                            Delete
                                        </a> &nbsp;&nbsp;

                                    </td>
                                    <td style='font-size:15px;text-align:center;'> <b>

                                            <?php if($rows2[0]<$tim){ ?> <?php echo $total-$vall;?> out of
                                            <?php echo $tim;?> slots


                                            <?php } else if(($rows2[0]=$tim) && ($wait>0)) { ?>
                                            Slot is Full
                                            <?php } ?> </b> </td>
                                    <td style='text-align:center;'>
                                        <a class='label label-primary'>
                                            <?php echo  $wait-$availwait;?>
                                        </a>
                                    </td>


                                </tr>
                                <?php
}?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function openCity(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }

</script>
<?php include 'footer.php'; ?>
