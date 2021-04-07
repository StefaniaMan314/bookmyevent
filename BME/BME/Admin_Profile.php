<?php include 'header.php';
include 'DB.php';
session_start();
 $today= date('Y-m-d');
$assoc_id=$_SESSION['associateId'];
$assoc_name=$_SESSION['fullname'];
$manager=$_SESSION['manager'];
$role=$_SESSION['role'];
if (@$_SESSION['thumbnailphoto'] != "") {
    $userimage = "data:image/jpeg;base64," . base64_encode($_SESSION['thumbnailphoto']);
} else {
    $userimage = "img/Collaborator Male_50px.png";
}

$query1=("SELECT * FROM `event` where   edate < '$today' ORDER BY edate DESC");
		$result1=mysqli_query($link,$query1) or die();
$arr1=  mysqli_fetch_row($result1);

	$connect = mysqli_connect("localhost", "root", "cernces6435", "BME1");	
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

 if($_SESSION['role']=='Super Admin')  { 
?>
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
                <div class="card-header"><b>Upcoming Events </b></div>
                <div class="card-body">
                    <div class="table-responsive">

                        <table id='example1' class="table table-bordered  table-hover table-condensed">
                            <thead>
                                <tr>
                                    <th> Event Name </th>
                                    <th> Event Date </th>
                                    <th> Location </th>
                                    <th> Edit </th>
                                    <th> Delete </th>
                                </tr>
                            </thead>
                            <?php 
$event_date=$link->query("SELECT * FROM `event` WHERE  edate>= '$today' ORDER BY slno DESC  ");
while($create_count=mysqli_fetch_assoc($event_date)){
	$event_id=$create_count['slno'];
$event_name=$create_count['ename'];
$edate=$create_count['edate'];
$location=$create_count['Location'];?>

                            <tr>
                                <td> <?php echo $event_name ?> </td>
                                <td> <?php echo $edate ?> </td>
                                <td> <?php echo $location ?> </td>
                                <td>
                                    <a class='btn btn-sm btn-default bg-olive' onclick="alertify.confirm('Please Confirm', 'You are trying to Edit the Event <b><?php echo $event_name;?></b>.', function(){ window.location='EditEvent.php?slno=<?php echo $event_id; ?>'}
                , function(){ });">Edit</a> </td>
                                <td> <?php if($edate<=$today) {?>

                                    Event delete Disabled
                                    <?php } else { ?>
                                    <a class='btn btn-sm btn-danger' onclick="alertify.confirm('Please Confirm', 'You are trying to delete the event <?php echo $event_name;?>.', function(){ window.location='event_delete.php?slno=<?php echo $event_id; ?>'}
                , function(){ });">DELETE</a>

                                    <?php } ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header"> <b> Past Events </b></div>
                <div class="card-body">
                    <div class="table-responsive">

                        <table id='example3' class="table table-bordered  table-hover table-condensed">
                            <thead>
                                <tr>
                                    <th> Event Name </th>
                                    <th> Event Date </th>
                                    <th> Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
$event_date=$link->query("SELECT * FROM `event` WHERE  edate< '$today' ORDER BY slno DESC  ");
while($create_count=mysqli_fetch_assoc($event_date)){
	$event_id=$create_count['slno'];
$event_name=$create_count['ename'];
$edate=$create_count['edate'];
$location=$create_count['Location'];
					?>
                                <tr>
                                    <td> <?php echo $event_name ?> </td>
                                    <td> <?php echo $edate ?> </td>
                                    <td> <button type="button" class='btn btn-sm btn-default bg-olive' onclick="location.href='AnalysisTabs.php?id=<?php echo $event_id; ?>'">View</button>
                                    </td>

                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<?php include 'footer.php' ?>
