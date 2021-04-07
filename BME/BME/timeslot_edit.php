<?php include 'header.php';
session_start();
$offset=$_SESSION['utc_offset'];

$assoc_id=$_SESSION['associateId'];
 $today= date('Y-m-d');
 
 $slno=$_GET['slno'];
 $time=$_GET['time'];



$check3=$link->query("SELECT `timeslots`,CONVERT_TZ (DATE_FORMAT(`start`,'%Y-%m-%d %H:%i:%s'),'+00:00','$offset'),CONVERT_TZ (DATE_FORMAT(`end`,'%Y-%m-%d %H:%i:%s'),'+00:00','$offset'),`start`,`end`,`waitlist`,`session_name`,`location`   FROM timeslot WHERE slno = '$time'");
    $rows3=mysqli_fetch_row($check3);
	if($rows3[0]>=1)
    {
		
		$session_name=$rows3[6];
		
		$timeslots=$rows3[0];
		$waitlist=$rows3[5];
		$timeslot_location=$rows3[7];
		
		$start_date=$rows3[1];
		$end_date=$rows3[2];
 $start_date=date('Y-m-d h:i a', strtotime($start_date));
$end_date=date('Y-m-d h:i a', strtotime($end_date));

   
    $timeslot=$start_date.'  -  '.$end_date;
	}
	
?>
    <div id="page-wrapper">
        <div id="content-wrapper">
            <div class="card">
                <div class="card-header" style="background: #fff;">
                    <h3>Edit  Timeslot     </h3>
					<h5 style="color:#0D94D2"><?php echo $timeslot; ?>   </h5>
					</div>
                <div class="card-body" style="background: #fff;">
                    <form role="form" method="post" action="time_update.php?time=<?php echo $time?>" onsubmit="return upperMe1()" enctype="multipart/form-data">
          
							             <div class='row'>
                            <div class="col-lg-4">
                              <div class="form-group">
								<br/>
                                    <label><b>Event Name</b></label>
                                    <?php
                                $query = $link->query("SELECT * FROM event WHERE creator='$assoc_id' AND slno='$slno'");
                                   $rowCount = $query->num_rows;
                                ?>
                                        <!--It works with onchange event-->
                                        <select style='font-size:15px;background-color:white;' class="form-control w3-border select2 w3-hover-border-blue" name="eid" id="country1" required>
                                           
                                            <?php
                                  if($rowCount > 0){
                                  while($row = $query->fetch_assoc()){

                                  echo '<option value="'.$row['slno'].'">'.$row['ename'].'</option>';
                                  }
                                }else{
                                  echo '<option value="">Event not available</option>';
                                  }
                              ?>
                                        </select>
                                </div>
							
							      
									<div class="form-group">
						
                                    <label><b>Session Name </b></label>
									
                                    <input style='font-size:15px;background-color:white;' class="form-control w3-border  w3-hover-border-blue" name="session_name" placeholder=" " value="<?php echo $session_name; ?>" required>
									</div>
									
									<div class="form-group">
						
                                    <label><b>Session Location </b></label>
									
                                    <input style='font-size:15px;background-color:white;' class="form-control w3-border  w3-hover-border-blue" name="session_location" placeholder=" " value="<?php echo $timeslot_location; ?>" required>
									</div>
									
								
                                         <div class='row'>
                                    <div class="col-lg-12">
						
									
									
                                        <div class="form-group">
                                            <label><b>Start Time</b></label><br/>
											<div class="col-lg-4">
											<input  style='font-size:15px;background-color:white;width :100%' name="start_date" id="datepicker" placeholder="Start Date"  required>
	
                                        </div>
										<div class="col-lg-4">
                                           <select style='font-size:15px;background-color:white;width :100%' class="form-control w3-border select2 w3-hover-border-blue" name='starthour' required>
										    <option value="" selected hidden>Hour</option>
										   <?php
for ($i = 0; $i <= 23; $i++) {
   
	echo '<option value="'.$i.'">'.$i.'</option>';
}

?>
                                            </select>
                                        </div>
											<div class="col-lg-4">
                                           <select style='font-size:15px;background-color:white;width :100%' class="form-control w3-border select2 w3-hover-border-blue" name='startmin' required>
										   <option value="" selected hidden>Minute</option>
										   <?php
for ($i = 0; $i <= 59; $i++) {
   
	echo '<option value="'.$i.'">'.$i.'</option>';
}

?>
                                            </select>
                                        </div>
									
										</div>
                                    </div>
								    </div>
									   <div class='row'>
                           <div class="col-lg-12">
                                        <div class="form-group">
											<br/>
                                            <label><b>End Time</b></label><br/>
													<div class="col-lg-4">
											<input  style='font-size:15px;background-color:white;width :100%' name="end_date" id="datepicker1" placeholder="End Date" required>
	
                                        </div>
										<div class="col-lg-4">
                                           <select style='font-size:15px;background-color:white;width :100%' class="form-control w3-border select2 w3-hover-border-blue" name='endhour' required>
										    <option value="" selected hidden>Hour</option>
										   <?php
for ($i = 0; $i <= 23; $i++) {
   
	echo '<option value="'.$i.'">'.$i.'</option>';
}

?>
                                            </select>
                                        </div>
											<div class="col-lg-4">
                                           <select style='font-size:15px;background-color:white;width :100%' class="form-control w3-border select2 w3-hover-border-blue" name='endmin' required>
										   <option value="" selected hidden>Minute</option>
										   <?php
for ($i = 0; $i <= 59; $i++) {
   
	echo '<option value="'.$i.'">'.$i.'</option>';
}

?>
                                            </select>
                                        </div>
									
										</div>
                                    </div>
                                </div>
								
                                 <div class="form-group">
									<br/>
                                    <label><b>Registrations</b></label>
									
                                    <input style='font-size:15px;background-color:white;' class="form-control w3-border  w3-hover-border-blue" name="timeslots" placeholder="No of registrations"  value="<?php echo $timeslots; ?>"required> </div>
									<div class="form-group">
                                    <label><b>Waitlist Registrations</b></label>
                                    <input style='font-size:15px;background-color:white;' class="form-control w3-border  w3-hover-border-blue" name="waitlist" placeholder="No of registrations for waitlist" value="<?php echo $waitlist; ?>" required> 
									</div>
                               <br/>
							   <button type="submit" name="save2" class="btn btn-default bg-olive">Submit</button>
                            </div>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>