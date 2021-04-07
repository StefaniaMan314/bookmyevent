<?php include 'header.php';
session_start();
$offset=$_SESSION['utc_offset'];

$assoc_id=$_SESSION['associateId'];
 $today= date('Y-m-d');
 
 $event_id=$_GET['slno'];
 $timeslot=$_GET['time'];


$check3=$link->query("SELECT * FROM event WHERE slno = '$event_id'");
    $rows4=mysqli_fetch_row($check3);
	
		$event_name=$rows4[1];
	
	
	
$check3=$link->query("SELECT `timeslots`,CONVERT_TZ (DATE_FORMAT(`start`,'%Y-%m-%d %H:%i:%s'),'+00:00','$offset'),CONVERT_TZ (DATE_FORMAT(`end`,'%Y-%m-%d %H:%i:%s'),'+00:00','$offset'),`start`,`end`,`waitlist`,`session_name` FROM timeslot WHERE slno = '$timeslot'");
    $rows3=mysqli_fetch_row($check3);
	if($rows3[0]>=1)
    {
		$start_time=$rows3[1];
		$end_time=$rows3[2];
		$timeslots=$rows3[0];
		$waitlist=$rows3[5];
		
		 $start_time=date('Y-m-d h:i a', strtotime($start_time));
$end_time=date('Y-m-d h:i a', strtotime($end_time));


	}

$check4=$link->query("SELECT count(*) FROM testevent WHERE event = '$event_id' AND timeslot='$timeslot'");
    $rows5=mysqli_fetch_row($check4);
	
		$registered=$rows5[0];
?>
    <div id="page-wrapper">
        <div id="content-wrapper">
            <div class="card">
                <div class="card-header" style="background: #fff;">
                    <h3> <b> Delete  Timeslot </b>  </h3>
					</div>
					
                <div class="card-body" style="background: #fff;">
                    <form role="form" method="post" action="time_delete.php?time=<?php echo $timeslot?>&slno=<?php echo $event_id; ?>" onsubmit="return upperMe1()" enctype="multipart/form-data">
					  <div class="form-group">
 <h5 style="color:red;font-size:15px"> Note: Mail will be sent to registered Associates if Slot is deleted.
                                                </h5>
                                            </div>
                        <div class='row'>
                            <div class="col-lg-4">
							
						
							   <br/>
							    <br/>
                        <p> <b> Event Name  &nbsp;: </b> <?php echo $event_name?> </p>
                               
							   <p> <b> Slot  &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; : </b> <?php echo $start_time?>  - <?php echo $end_time?></p>
							    <p> <b> Timeslots  &nbsp;  &nbsp;  : </b> <?php echo $timeslots?> </p>
								  <p> <b> Waitlist  &nbsp;  &nbsp; &nbsp; &nbsp;  : </b> <?php echo $waitlist?> </p>
								  <br/>
								  <p style="color:red"> <b> Registered Associates  &nbsp;  &nbsp; &nbsp; &nbsp;  :  <?php echo $registered?> </b></p>
								  <br/>
								
                               <br/>
							   	  
							   <button type="submit" name="save2" class="btn btn-default bg-olive">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>