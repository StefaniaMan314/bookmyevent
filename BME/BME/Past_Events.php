<?php 
include 'header.php';
session_start();
$error=$_GET['status'];
$assoc_id=$_SESSION['associateId'];
$assoc_company=$_SESSION['company'];
$assoc_executive=$_SESSION['executive'];
$today= date('Y-m-d');
if(isset($_GET['page']))
{
    $reportPage=$_GET['page'];
    $_SESSION['index_id']=$reportPage;
}
else
{
    if(isset($_SESSION['index_id']))
    {$reportPage=$_SESSION['index_id'];}
    else{
    $reportPage='live';}
}
$offset=$_SESSION['utc_offset'];
?>
<style>
    .fa-circle1 {
        animation: fa-beat 3s ease infinite;
    }

    @keyframes fa-beat {
        0% {
            transform: scale(1);
        }

        10% {
            transform: scale(1.25);
        }

        20% {
            transform: scale(1);
        }

        30% {
            transform: scale(1.25);
        }

        40% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.25);
        }

        60% {
            transform: scale(1);
        }

        70% {
            transform: scale(1.25);
        }

        80% {
            transform: scale(1);
        }

        90% {
            transform: scale(1.25);
        }

        100% {
            transform: scale(1);
        }
    }

</style>
<script>
    $(function() {
        $("#clear").on('click', function() {
            document.getElementById("tab").style.display = "none";
            document.getElementById("tab1").style.display = "block";
            $("#search_param").val(" ");
        });
        $("#search").on('click', function() {
            document.getElementById("tab1").style.display = "none";
            var search_param = $('#search_param').val();
            if (search_param && search_param != '') {
                $.ajax({
                    type: 'POST',
                    url: 'Past_Events_fetch.php',
                    data: {
                        search_param: search_param
                    },
                    success: function(html) {
                        $('#tab').html(html);
                        document.getElementById("tab1").style.display = "none";
                        document.getElementById("tab").style.display = "block";
                    }
                });
            }
        });
    });

</script>
<div class="container-fluid">
    <div class='row'>
        <div class='col-lg-4'>
            <img src="BME_sse.png" width="50%" />
        </div>
        <div class='col-lg-4' style='float-right'><br />

        </div>
        <div class='col-lg-4'>
            <br />
            <div class="input-group input-group-sm  elevation-1">
                <input type="text" id='search_param' class="form-control w3-round" type="search" placeholder="Search events" aria-label="Search">
                <span class="input-group-append">
                    <button type="button" id='search' class="btn btn-primary"><i style='color:#fff' class="fa fa-search" aria-hidden="true"></i></button>
                    <button type="button" id='clear' class="btn btn-default"><i style='color:#ff0000' class="fa fa-times" aria-hidden="true"></i></button>
                </span>
            </div>
        </div>
    </div>
    <div id="tab" style='display:none;'></div>
    <div class='section' id='tab1'>
        <div class='row'>
            <?php 
    $query ="SELECT * FROM event WHERE edate < '$today' AND golive=1 ORDER BY edate DESC ";
    $result = mysqli_query($connect, $query);
    if(mysqli_num_rows($result) > 0)
    {
     while($row = mysqli_fetch_array($result))
     { 
    $event_id = $row['slno'];
    $event_name =  $row['ename'];
         $query1 ="SELECT SUM(`timeslots`) FROM `timeslot` WHERE `eslno`='$event_id'";
    $result1 = mysqli_query($connect, $query1);
    $row1 = mysqli_fetch_array($result1);
         $total=$row1[0];
         $query1 ="SELECT COUNT(`slno`) FROM `testevent` WHERE `event`='$event_id'";
    $result1 = mysqli_query($connect, $query1);
    $row1 = mysqli_fetch_array($result1);
         $some=$row1[0];
         $per=round((intval($some)/intval($total))*100,2);
         if($per<=80){
             $color_p="bg-success";
         }else{
             $color_p="bg-danger";
         }
         $d1= new DateTime( $row['edate']);  $date11=$d1->format('D, M d Y');
 ?>
            <div class="col-lg-3">
                <a href="Event_Registration.php?id=<?php echo $row['slno']; ?>">
                    <div class="card elevation-2" style=" border: 0px solid white;border-radius: 5px ;">
                        <div class='row'>
                            <div class="col-lg-12">
                                <center> <img style=" border: 0px solid #a6a6a6;border-radius: 5px ;" height="100px" width="100%" src="<?php echo $row['file_loc']; ?>" />
                                </center>
                            </div>
                        </div>
                        <div class='row'>
                            <div class="col-lg-12">
                                <h3 title='Not Live' style='color:#0D94D2;font-size:15px;font-weight:bold'><b>&nbsp;<i class="fa fa-circle" style='color:#FFA500;font-size:15px'></i><?php echo substr($row['ename'],0,35); ?> </b> &nbsp;</h3>
                                <h4 style='color:#d1410c;font-size:13px;font-weight:bold '>&nbsp; <b style='color:#0D94D2'>Date:</b> &nbsp; &nbsp; <?php  echo $date11; ?> </h4>
                                <h5 style='color:black;font-size:13px;font-weight:bold '>&nbsp; <b style='color:#0D94D2'> Location: </b>&nbsp; <?php echo substr($row['Location'],0,20);?> - <?php echo $row['country']; ?></h5>
                                <div title='<?php echo $per; ?>% Registrations Complete' class="progress progress-xxs w3-round elevation-1">
                                    <div class="progress-bar <?php echo $color_p; ?>" role="progressbar" aria-valuenow=" <?php echo $per; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $per; ?>%">
                                        <span class="sr-only">60% Complete (warning)</span>
                                    </div>
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a> </div>
            <?php  
     } 
    }?>
            <?php 
    $query ="SELECT * FROM event WHERE edate < '$today' AND golive=0 ORDER BY edate ASC ";
    $result = mysqli_query($connect, $query);
    if(mysqli_num_rows($result) > 0)
    {
     while($row = mysqli_fetch_array($result))
     { 
    $event_id = $row['slno'];
    $event_name =  $row['ename'];
         $query1 ="SELECT SUM(`timeslots`) FROM `timeslot` WHERE `eslno`='$event_id'";
    $result1 = mysqli_query($connect, $query1);
    $row1 = mysqli_fetch_array($result1);
         $total=$row1[0];
         $query1 ="SELECT COUNT(`slno`) FROM `testevent` WHERE `event`='$event_id'";
    $result1 = mysqli_query($connect, $query1);
    $row1 = mysqli_fetch_array($result1);
         $some=$row1[0];
         $per=round((intval($some)/intval($total))*100,2);
         if($per<=80){
             $color_p="bg-success";
         }else{
             $color_p="bg-danger";
         }
         $d1= new DateTime( $row['edate']);  $date11=$d1->format('D, M d Y');
 ?>

            <?php 
$check2=$connect->query("SELECT COUNT(*)  FROM `eventhost` WHERE AssociateId = '$assoc_id' AND event_id='$event_id' ");
$rows3=mysqli_fetch_row($check2);
if(($rows3[0]>=1) || ($_SESSION['role']=='Super Admin')){
?>
            <div class="col-lg-3">
                <a href="Event_Registration.php?id=<?php echo $row['slno']; ?>">
                    <div class="card elevation-2" style=" border: 0px solid white;border-radius: 5px ;">
                        <div class='row'>
                            <div class="col-lg-12">
                                <center> <img style=" border: 0px solid #a6a6a6;border-radius: 5px ;" height="100px" width="100%" src="<?php echo $row['file_loc']; ?>" />
                                </center>
                            </div>
                        </div>

                        <div class='row'>
                            <div class="col-lg-12">
                                <h3 title='Not Live' style='color:#0D94D2;font-size:15px;font-weight:bold'><b>&nbsp;<i class="fa fa-circle" style='color:#FFA500;font-size:15px'></i> <?php echo substr($row['ename'],0,35); ?> </b> &nbsp;</h3>
                                <h4 style='color:#d1410c;font-size:13px;font-weight:bold '>&nbsp; <b style='color:#0D94D2'>Date:</b> &nbsp; &nbsp; <?php  echo $date11; ?> </h4>
                                <h5 style='color:black;font-size:13px;font-weight:bold '>&nbsp; <b style='color:#0D94D2'> Location: </b>&nbsp; <?php echo substr($row['Location'],0,20);?> - <?php echo $row['country']; ?></h5>
                                <div title='<?php echo $per; ?>% Registrations Complete' class="progress progress-xxs w3-round elevation-1">
                                    <div class="progress-bar <?php echo $color_p; ?>" role="progressbar" aria-valuenow=" <?php echo $per; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $per; ?>%">
                                        <span class="sr-only">60% Complete (warning)</span>
                                    </div>
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a> </div>
            <?php } 
     } 
    }?>
        </div>
    </div>
</div>
<?php 
include 'footer.php';
?>
