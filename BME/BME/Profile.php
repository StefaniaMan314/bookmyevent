<?php 
include 'header.php';
session_start();
$error=$_GET['status'];
$assoc_id=$_SESSION['associateId'];
$assoc_company=$_SESSION['company'];
$assoc_executive=$_SESSION['executive'];

$query = "SELECT * FROM `event` WHERE `creator`='$assoc_id' ";
$result = mysqli_query($connect, $query);
$count = mysqli_num_rows($result);

$query2 = "SELECT * FROM `testevent` WHERE `AssociateID`='$assoc_id' ";
$result2 = mysqli_query($connect, $query2);
$count1 = mysqli_num_rows($result2);

$query3 = "SELECT * FROM `Dash_Visitors` WHERE `Asso_ID`='$assoc_id' ";
$result3 = mysqli_query($connect, $query3);
$count3 = mysqli_num_rows($result3);

$query4 = "SELECT * FROM `cancel1` WHERE `assoc_name`='$assoc_id' ";
$result4 = mysqli_query($connect, $query4);
$count4 = mysqli_num_rows($result4);
?>
<style>


</style>
<div class="container-fluid">
    <br />
    <div class='row'>
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary elevation-1">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle" src="<?php echo $userimage; ?>" alt="User profile picture">
                    </div>

                    <h3 class="profile-username text-center" style='color:#0D94D2'><?php echo $_SESSION['fullname']; ?></h3>

                    <p class="text-muted text-center"><?php echo $_SESSION['role']; ?></p>

                    <ul class="list-group mb-3">
                        <li class="list-group-item">
                            <b>Events Created</b> <a class="float-right"><?php echo $count; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>Events Registered</b> <a class="float-right"><?php echo $count1; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>Registrations Cancelled</b> <a class="float-right"><?php echo $count4; ?></a>
                        </li>
                    </ul>
                    <center>
                        <a href='Add_Event.php' class="btn btn-app btn-lg w3-round-xlarge" style='color:#fff;background-color:#0D94D2'>
                            <i class="fas fa-calendar-plus"></i> Add Event
                        </a><a href='BME_analysis.php' class="btn btn-app btn-lg w3-round-xlarge" style='color:#fff;background-color:#7BC143'>
                            <i class="fas fa-chart-pie"></i> Analysis
                        </a><a href='Suggestions.php' class="btn btn-app btn-lg w3-round-xlarge" style='color:#fff;background-color:#F58025'>
                            <i class="fas fa-comment-dots"></i> Feedback
                        </a></center>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Registrations</a></li>
                        <li class="nav-item"><a class="nav-link" href="#upcoming" data-toggle="tab">Events Upcoming</a></li>
                        <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Events Created</a></li>
                        <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Past Registrations</a></li>
                        <li class="nav-item"><a class="nav-link" href="#attended" data-toggle="tab">Events Attended</a></li>
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="active tab-pane" id="activity">

                            <div class="divscroll">
                                <br />
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
	$query1="SELECT t.`AssociateName`,t.`Title`,t.`timeslot`,e.`ename`,e.`edate`,e.`Location`,t.`event`,t.`timeslot1`  FROM `testevent` t ,`event` e where t.AssociateID='$assoc_id' AND e.`slno`=t.`event` AND e.`edate` >='$today'  ORDER BY e.`ename` DESC";
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
                        <div class="tab-pane" id="attended">
                            <div class="divscroll">
                                <br />
                                <table class="table table-bordered  table-hover table-condensed">
                                    <thead>
                                        <tr>
                                            <th>Event Name</th>
                                            <th>Event Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
																										$today= date('Y-m-d');
$query1="SELECT t.`AssociateName`,t.`Title`,t.`timeslot`,e.`ename`,e.`edate`,e.`Location`,t.`event`,t.`booked` FROM `testevent` t ,`event` e where t.AssociateID='$assoc_id' AND e.`slno`=t.`event` AND t.`booked`='1' AND  e.`edate`<='$today' AND  t.`attend`='1' ORDER BY e.`ename` DESC";
		$result1=mysqli_query($link,$query1) or die();
while($arr1=  mysqli_fetch_assoc($result1)){ 
   $ename=$arr1['ename'];
	$elocation=$arr1['Location'];
	$edate=$arr1['edate'];
	$timeslot=$arr1['timeslot'];
	$eslno=$arr1['event'];
if($arr1['AssociateName']!=''){
$query="SELECT * FROM `timeslot` WHERE slno='$timeslot'";
$result = $link->query($query) or die("Error0 : ".mysqli_error($link));
$arr=  mysqli_fetch_row($result); ?>
                                        <?php
    $date1=$arr1['timeslot'];
    $test1=$arr1['AssociateName'];
    $start=date('h:i a', strtotime($arr[1]));
    $end=date('h:i a', strtotime($arr[2]));
    $timeslot=$start.' - '.$end;
?>
                                        <tr>
                                            <td><?php echo $ename; ?></td>


                                            <td><?php echo $edate; ?></td>
                                            <td><a class='btn btn-sm bg-olive' onclick="alertify.confirm('Please Confirm', 'You are trying to give a feedback.', function(){ window.location='feedback.php?event_id=<?php echo $eslno; ?>'}
                , function(){ });"> FEEDBACK </a></td>
                                        </tr>
                                        <?php  }}?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="upcoming">
                            <div class="divscroll">
                                <br />
                                <table class="table table-bordered  table-hover table-condensed">
                                    <thead>
                                        <th> Event Name </th>
                                        <th> Event Date </th>
                                        <th> Location </th>
                                        <th> Edit </th>
                                        <th> Delete </th>

                                    </thead>
                                    <tbody>




                                        <?php 
		$event_date=$link->query("SELECT * FROM `event` WHERE creator = '$assoc_id'  AND  edate>= '$today' ORDER BY slno DESC  ");
while($create_count=mysqli_fetch_assoc($event_date)){
	$event_id=$create_count['slno'];
$event_name=$create_count['ename'];
$edate=$create_count['edate'];
$location=$create_count['Location'];



					?>


                                        <td> <?php echo $event_name ?> </td>


                                        <td> <?php echo $edate ?> </td>

                                        <td> <?php echo $location ?> </td>







                                        <td>

                                            <a class='btn btn-default bg-olive' onclick="alertify.confirm('Please Confirm', 'You are trying to Edit the Event <b><?php echo $event_name;?></b>.', function(){ window.location='EditEvent.php?slno=<?php echo $event_id; ?>'}
                , function(){ });">Edit</a> </td>
                                        <td> <?php if($edate<=$today) {?>

                                            Event delete Disabled
                                            <?php } else { ?>
                                            <a class='btn btn-sm btn-danger' onclick="alertify.confirm('Please Confirm', 'You are trying to delete the event <?php echo $event_name;?>.', function(){ window.location='Event_Delete.php?slno=<?php echo $event_id; ?>'}
                , function(){ });">DELETE</a>

                                            <?php } ?>
                                        </td>

                                    </tbody>

                                    <?php } ?>



                                </table>

                            </div>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="timeline">

                            <div class="divscroll">
                                <br />
                                <table class="table table-bordered  table-hover table-condensed">
                                    <thead>
                                        <th> Event Name </th>
                                        <th> Event Date </th>

                                        <th> Action </th>

                                    </thead>
                                    <tbody>




                                        <?php 
		$event_date=$link->query("SELECT * FROM `event` WHERE creator = '$assoc_id' ORDER BY slno DESC  ");
while($create_count=mysqli_fetch_assoc($event_date)){
	$event_id=$create_count['slno'];
$event_name=$create_count['ename'];
$edate=$create_count['edate'];
$location=$create_count['Location'];



					?>
                                    <tbody>

                                        <td> <?php echo $event_name ?> </td>


                                        <td> <?php echo $edate ?> </td>


                                        <td>

                                            <button type="button" class='btn btn-default bg-olive' onclick="location.href='AnalysisTabs.php?id=<?php echo $event_id; ?>'">View</button>



                                        </td>

                                    </tbody>

                                    <?php } ?>



                                </table>

                            </div>
                        </div>
                        <!-- /.tab-pane -->

                        <div class="tab-pane" id="settings">

                            <div class="divscroll">
                                <br />
                                <table class="table table-bordered  table-hover table-condensed">
                                    <thead>
                                        <tr>
                                            <th>Event Name</th>
                                            <th>Event Date</th>
                                            <th>Timeslot</th>

                                        </tr>
                                    </thead>
                                    <?php 
		$event_date=$link->query("SELECT * FROM `testevent` WHERE AssociateID = '$assoc_id' AND booked='1' ");
while($create_count=mysqli_fetch_assoc($event_date)){
$timeslot=$create_count['timeslot1'];
$event_id=$create_count['event'];

$event_create3=$link->query("SELECT * FROM `event` WHERE slno = '$event_id' AND edate<= '$today' ");
while($register_count2=mysqli_fetch_assoc($event_create3)){
$event_name=$register_count2['ename'];
$date=$register_count2['edate'];

					?>
                                    <tbody>

                                        <tr>
                                            <td>
                                                <?php echo $event_name ?>
                                            </td>
                                            <td>
                                                <?php echo $date ?>
                                            </td>
                                            <td>
                                                <?php echo $timeslot ?>
                                            </td>
                                            <?php } ?>
                                        </tr>

                                    </tbody>
                                    <?php } ?>

                                </table>

                            </div>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
    </div>
</div>
<?php 
include 'footer.php';
?>
