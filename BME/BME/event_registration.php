<?php
include 'header.php';
include 'phpqrcode/qrlib.php';
session_start();
$offset = $_SESSION['utc_offset'];
$assoc_id = $_SESSION['associateId'];

$event_id = $_GET['id'];

$today = date('Y-m-d');
$check3 = $link->query("SELECT ename,slno, `edesc`, `edate`,Location, `file_loc`,`golive`,`creator`,`type1`  FROM `event` WHERE  slno='$event_id'");
$rows3 = mysqli_fetch_row($check3);
$event_day = $rows3[3];
$type1 = $rows3[8];


//$dom = new DomDocument;


//$registerOption = $dom->getElementById('registerOption');

//$numberOfDependents = $dom->getElementById('numberOfDependents');



//Getting last and first names function
// function getNames($dom, $noOfDependents) {
//     $names = '';

//     for ($i = 0; $i < $noOfDependents - 1; $i++) {
//          $names .= $dom->getElementById("lastName" . ($i + 1)) . " " . $dom->getElementById("firstName" . ($i + 1)) . ";";
//        // $names .= $_POST["lastName" . ($i + 1)] . " " . $_POST["firstName" . ($i + 1)] . ";";
//     }

//     $names .= $_POST["lastName" . ($noOfDependents)] . " " . $_POST["firstName" . ($noOfDependents)];

//     return $names;
// }


// Getting associate name
$associateData = $link->query("SELECT `name` FROM `Associate` WHERE id = '$assoc_id'");
$associateDataRow = mysqli_fetch_row($associateData);
$associateName = $associateDataRow[0];

if (($event_day >= $today)) {


    $check1 = $link->query("select COUNT(`slno`) from `testevent` where AssociateID='$assoc_id' AND event='$event_id'");
    $rows1 = mysqli_fetch_row($check1);
    if (intval($rows1[0]) >= 1 && $type1 != 'multiple') {
        echo "<script>window.location='landing1.php?id=$event_id'</script>";
    }

    $today = date('Y-m-d');
    $check3 = $link->query("SELECT ename,slno, `edesc`, `edate`,Location, `file_loc`,`golive`,`creator`,`type1`  FROM `event` WHERE  edate>='$today' AND slno='$event_id'");
    $rows3 = mysqli_fetch_row($check3);
    $event = $rows3[0];
    $description = $rows3[2];
    $day = $rows3[3];
    $location = $rows3[4];
    $eimage = $rows3[5];
    $golive = $rows3[6];
    $creator_id = $rows3[7];
    $type1 == $rows3[8];
    $check1 = $link->query("select CONVERT_TZ (DATE_FORMAT(MIN(`start`),'%Y-%m-%d %H:%i:%s'),'+00:00','$offset') from `timeslot` where eslno='$event_id'");
    $rows1 = mysqli_fetch_row($check1);
    $event_start = $rows1[0];
    $check3 = $link->query("SELECT * FROM event WHERE slno = '$event_id'");
    $rows3 = mysqli_fetch_row($check3);
    if ($rows3[0] >= 1) {
        $event_id = $rows3[0];
        $event_name = $rows3[1];
    }


    $text = "https://bookmyevent.cerner.com/BME/qr_registration.php?event_id=$event_id&event_name=$event_name";

    $path = 'eventqr/';
    $file = $path . uniqid() . ".png";

    $ecc = 'S';
    $pixel_Size = 5;
    $frame_Size = 5;

    // Generates QR Code and Stores it in directory given 
    QRcode::png($text, $file, $ecc, $pixel_Size, $frame_size);
?>
    <div class="container-fluid">
        <br />
        <div class='card'>
            <div class='card-header'>
                <h4 style='color:#0D94D2'><strong><?php echo $event; ?></strong></h4>
                <?php
                $check3 = $link->query("SELECT COUNT(*)  FROM `eventhost` WHERE AssociateId = '$assoc_id' AND event_id='$event_id' AND event_name='$event_name'");
                $rows3 = mysqli_fetch_row($check3);
                if (($rows3[0] >= 1) || ($_SESSION['role'] == 'Super Admin')) { ?>
                    <div class="card-tools">
                        <span data-toggle="tooltip" title="3 New Messages" class="badge bg-primary">3</span>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle">
                            <i class="fas fa-comments"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                        </button>
                    </div><?php } ?>
            </div>
            <div class='card-body'>
                <div class='row'>
                    <div class='col-lg-10'>
                        <strong><i class="fa fas fa-book mr-1"></i> Event Description</strong>
                        <p class="text-muted">
                            <?php echo $description; ?>
                        </p>
                        <div class='row'>
                            <div class='col-lg-3'>
                                <strong><i class="fa fas fa-user-cog"></i> Event By: </strong><?php echo $creator_id; ?>
                                <p class="text-muted"></p>
                            </div>
                            <div class='col-lg-3'>
                                <strong><i class="fa fas fa-map-marker-alt mr-1"></i> Location: </strong><?php echo $location; ?>
                                <p class="text-muted"></p>
                            </div>
                            <div class='col-lg-3'>
                                <strong><i class="fa fas fa-calendar-check"></i> When: </strong><?php echo $day;
                                                                                                $d1 = new DateTime($day);
                                                                                                echo " (" . $d1->format('D') . ")"; ?>
                                <p class="text-muted">

                                </p>
                            </div>
                            <?php
                            $check3 = $link->query("SELECT COUNT(*)  FROM `eventhost` WHERE AssociateId = '$assoc_id' AND event_id='$event_id' AND event_name='$event_name'");
                            $rows3 = mysqli_fetch_row($check3);
                            if (($rows3[0] >= 1) || ($_SESSION['role'] == 'Super Admin')) { ?>
                                <div class='col-lg-3'>
                                    <strong><i class="fa fas fa-qrcode"></i> QR code- </strong>
                                    <br />
                                    <div class="filtr-item col-lg-4" data-category="3" data-sort="red sample">
                                        <a href="<?php echo $file;  ?>" data-toggle="lightbox" data-title="QR code">
                                            <img src="<?php echo $file;  ?>" class="img-fluid mb-2" alt="red sample" width="70%" />
                                        </a>
                                    </div>
                                    <span>(Click to view and scan it for Walk-In registrations)</span>
                                </div><?php } ?>
                        </div>
                    </div>
                    <div class='col-lg-2'>
                        <div class="filtr-item" data-category="1" data-sort="white sample">
                            <a href="<?php echo $eimage; ?>" data-toggle="lightbox" data-title="<?php echo $event; ?>- image">
                                <div class='w3-round-large'>
                                    <img src="<?php echo $eimage; ?>" class="img-fluid mb-2" alt="white sample" />
                                </div>
                                <center><span>(Click to view)</span></center>
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='card'>
            <div class='card-header'>
                <h5 style="color:red;font-size:14px">Note: All timeslots are displayed as per your timezone (GMT <?php echo $offset; ?> hours ) </h5>
            </div>
            <div class='card-body'>
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <th style='text-align:center;'>Session </th>
                        <th style='text-align:center;'>Session Name</th>
                        <th style='text-align:center;'>Location</th>
                        <th style='text-align:center;'>Start Time</th>
                        <th style='text-align:center;'>End Time</th>
                        <th style='text-align:center;'>Register</th>
                        <th style='text-align:center;'>Available Registrations</th>
                        <th style='text-align:center;'>Available Waitlist</th>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        $query = "SELECT `slno`, CONVERT_TZ (DATE_FORMAT(`start`,'%Y-%m-%d %H:%i:%s'),'+00:00','$offset'),CONVERT_TZ (DATE_FORMAT(`end`,'%Y-%m-%d %H:%i:%s'),'+00:00','$offset'), `eslno`, `timeslots`, `waitlist`, `session_name`, `location` FROM `timeslot` WHERE eslno='$event_id' AND slno NOT IN (SELECT `timeslot` FROM `testevent` WHERE `event`='$event_id' AND `AssociateID`='$assoc_id') AND DATE(`end`)>='$today' ORDER BY start ";
                        $result = $link->query($query) or die("Error_test1 : " . mysqli_error($link));
                        ?>
                        <?php

                        while ($arr = mysqli_fetch_row($result)) {
                            $i++;
                            $tim = $arr[4];
                            $wait = $arr[5];
                            $start_date = $arr[1];
                            $end_date = $arr[2];
                            $start_date = date('Y-m-d h:i a', strtotime($start_date));
                            $end_date = date('Y-m-d h:i a', strtotime($end_date));
                            $session_name = $arr[6];
                            $timeslot_location = $arr[7];


                        ?>
                            <?php $check2 = $link->query("select count(slno) from testevent where timeslot='$arr[0]'");
                            $rows2 = mysqli_fetch_row($check2); ?>
                            <?php $check3 = $link->query("select count(slno) from testevent where timeslot='$arr[0]' AND booked='0'");
                            $rows3 = mysqli_fetch_row($check3); ?>
                            <tr>
                                <td style='font-size:13px;text-align:center;'> <b><?php echo $i; ?> </b>
                                </td>
                                <td style='font-size:13px;text-align:center;'> <b><?php echo  $session_name; ?> </b>
                                </td>
                                <td style='font-size:13px;text-align:center;'>
                                    <?php echo $timeslot_location; ?>
                                </td>
                                <td style='font-size:13px;text-align:center;'>
                                    <?php $d1 = new DateTime($start_date);
                                    echo $d1->format(' M d Y - h:i a'); ?>
                                </td>
                                <td style='font-size:13px;text-align:center;'>

                                    <?php $d1 = new DateTime($end_date);
                                    echo $d1->format(' M d Y - h:i a'); ?>
                                </td>
                                <td style='font-size:13px;text-align:center;'>

                                    <?php
                                    $vall = $rows2[0];
                                    $total = $tim;
                                    $availwait = $rows3[0];                             ?> &nbsp;
                                    <?php if ($rows2[0] < $tim) { ?>

                                        <!-- <script>
                                            function onClickSubmitButton() {
                                                let numberOfDependents = document.getElementById("numberOfDependents").value;

                                                let names = "";

                                                if (numberOfDependents) {
                                                    for (let i = 1; i <= numberOfDependents; ++i) {
                                                        let firstName = document.getElementById(`firstName${i}`).value;
                                                        let lastName = document.getElementById(`lastName${i}`).value;
                                                        names += `${firstName} ${lastName};`;
                                                    }

                                                    names = names.slice(0, -1);
                                                }

                                                //document.getElementById("registrationForm").submit();


                                                // window.location = 'TimeslotDependent.php?time=123&event_id=123';
                                                // alert(window.location);

                                                var registerOption = document.getElementById("registerOption").value;
                                                var numberOfDependents = document.getElementById("numberOfDependents").value;

                                                var eventId = document.getElementById("eventId").value;
                                                // var time = document.getElementById("time").value;
                                                // alert(`${eventId} ${time}`);


                                                var time = document.getElementById("time").value;
                                                // alert(time);

                                                // window.location = 'TimeslotDependent.php?event_id=130&time=1234';
                                                return `TimeslotDependent.php?time=${time}&event_id=${eventId}&registerOption=${registerOption}&arrayOfDependentsLength=${numberOfDependents}$arrayOfDependentNames=${names}`;

                                            }
                                        </script> -->

                                        <a class='btn btn-sm btn-success' data-bs-toggle="modal" data-bs-target="#registerModal">Register</a>

                                        <!-- Modal -->
                                        <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true" style="text-align: left">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content" style="text-align: left">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="registerModalLabel">Register for <?php echo $event_name ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Form -->
                                                        <form id="registerForm">
                                                            <!-- Associate name -->
                                                            <div class="form-group" id="associate">
                                                                <label for="associateName">Associate Name</label>
                                                                <input readonly type="text" class="form-control" id="associateName" placeholder="Associate Lastname, Firstname" value="<?php echo $associateName; ?>">
                                                            </div>
                                                            <br>

                                                            <!-- Register options -->
                                                            <div class="form-group" id="register">
                                                                <label for="register">Who are you registering for?</label>
                                                                <select id="registerOption" class="form-control" onclick="getRegisterOption()">
                                                                    <option selected>Select</option>
                                                                    <option value="AssociateOnly">Associate Only</option>
                                                                    <option value="AssociateAndDependents">Associate And Dependents</option>
                                                                    <option value="OnlyDependants">Only Dependants</option>
                                                                </select>
                                                            </div>
                                                            <br>

                                                            <!-- Dependants -->
                                                            <div class="form-group" id="dependants" style="display: none;">
                                                                <label for="associateDependants">How many additional family members are you registering? (Immediate family only)</label>
                                                                <select id="numberOfDependents" class="form-control" onclick="addFields()">
                                                                    <option selected>Select Number of Additional Appts</option>
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                    <option value="5">5</option>
                                                                </select>
                                                            </div>

                                                            <div id="container"></div>

                                                            <input type="text" style="display: none;" id="eventId" value="<?php echo $event_id; ?>">
                                                            <input type="text" style="display: none;" id="time" value="<?php echo $arr[0]; ?>">

                                                            <!-- Buttons -->
                                                            <!-- <div style="text-align: right;"> -->
                                                                <!-- Cancel -->
                                                                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="margin: 0.8rem; padding: 5px 30px 5px 30px;">Cancel</button> -->
                                                                
                                                                <!-- Submit -->
                                                                <!-- <button type="reset" class="btn btn-primary" style="margin: 0.8rem; padding: 5px 30px 5px 30px;" onclick="function onSubmit() {
                                                                        let time = document.getElementById('time').value;
                                                                        let eventId = document.getElementById('eventId').value;
                                                                        let registerOption = document.getElementById('registerOption').value;
                                                                        let numberOfDependents = document.getElementById('numberOfDependents').value;
                                                                        let names = '';

                                                                        if (numberOfDependents) {
                                                                            for (let i = 1; i <= numberOfDependents; ++i) {
                                                                                let firstName = document.getElementById(`firstName${i}`).value;
                                                                                let lastName = document.getElementById(`lastName${i}`).value;
                                                                                names += `${firstName} ${lastName};`;
                                                                            }

                                                                            names = names.slice(0, -1);
                                                                        }

                                                                        console.log(`time: ${time}`);
                                                                        console.log(`eventId: ${tieventIdme}`);
                                                                        console.log(`registerOption: ${registerOption}`);
                                                                        console.log(`numberOfDependents: ${numberOfDependents}`);
                                                                        console.log(`names: ${names}`);

                                                                        alert(`TimeslotDependent.php?time=${time}&event_id=${eventId}&registerOption=${registerOption}&arrayOfDependentsLength=${numberOfDependents}$arrayOfDependentNames=${names}`);
                                                                        window.location = `TimeslotDependent.php?time=${time}&event_id=${eventId}&registerOption=${registerOption}&arrayOfDependentsLength=${numberOfDependents}$arrayOfDependentNames=${names}`;
                                                                        return false;
                                                                    }">
                                                                        Submit
                                                                </button> -->
                                                            <!-- </div> -->
                                                        </form>

                                                        <div style="text-align: right;">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="margin: 0.8rem; padding: 5px 30px 5px 30px;">Cancel</button>

                                                            <!-- Submit -->
                                                            <button type="submit" class="btn btn-primary" style="margin: 0.8rem; padding: 5px 30px 5px 30px;" onclick="(function() {
                                                                            let time = document.getElementById('time').value;
                                                                            let eventId = document.getElementById('eventId').value;
                                                                            let registerOption = document.getElementById('registerOption').value;
                                                                            let numberOfDependents = document.getElementById('numberOfDependents').value;
                                                                            let names = '';

                                                                            if (numberOfDependents) {
                                                                                for (let i = 1; i <= numberOfDependents; ++i) {
                                                                                    let firstName = document.getElementById(`firstName${i}`).value;
                                                                                    let lastName = document.getElementById(`lastName${i}`).value;
                                                                                    names += `${firstName} ${lastName};`;
                                                                                }

                                                                                names = names.slice(0, -1);
                                                                            }

                                                                            // console.log(`time: ${time}`);
                                                                            // console.log(`eventId: ${tieventIdme}`);
                                                                            // console.log(`registerOption: ${registerOption}`);
                                                                            // console.log(`numberOfDependents: ${numberOfDependents}`);
                                                                            // console.log(`names: ${names}`);

                                                                            // alert(`TimeslotDependent.php?time=${time}&event_id=${eventId}&registerOption=${registerOption}&arrayOfDependentsLength=${numberOfDependents}$arrayOfDependentNames=${names}`);
                                                                            window.location = `TimeslotDependent.php?time=${time}&event_id=${eventId}&registerOption=${registerOption}&arrayOfDependentsLength=${numberOfDependents}&arrayOfDependentNames=${names}`;
                                                                            // return false;
                                                                        })()">
                                                                            Submit
                                                            </button>
                                                        </div>                    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- <a class='btn btn-sm btn-success' onclick="alertify.confirm('Please Confirm:', 'You are trying to register for <?php $d1 = new DateTime($start_date);
                                                                                                                                                            echo $d1->format(' M d Y - h:i a'); ?> batch', function(){ window.location='timeslot.php?time=<?php echo $arr[0]; ?>&event_id=<?php echo $event_id; ?>'} -->
                                        <!-- , function(){ });">
                                Register
                            </a>  -->
                                        &nbsp;&nbsp;



                                    <?php } else if (($rows2[0] = $tim) && ($wait > 0)) { ?> <a class='btn btn-sm btn-success' style='background-color:#FFA500' onclick="alertify.confirm('Please Confirm', 'You are trying to register for  <?php $d1 = new DateTime($start_date);
                                                                                                                                                                                                                                        echo $d1->format(' M d Y - h:i a'); ?> batch Waitlist', function(){ window.location='timeslot_testevent1.php?time=<?php echo $arr[0]; ?>&event_id=<?php echo $event_id; ?>'}
                , function(){ });">
                                            Register Waitlist
                                        </a> &nbsp;&nbsp;

                                    <?php } else { ?> <a class='btn btn-sm btn-primary' style='background-color:#ce1111' href='#'>Slot is full</a>&nbsp;&nbsp;
                                </td>
                            <?php } ?>
                            <td style='font-size:13px;text-align:center;'> <b>

                                    <?php if ($rows2[0] < $tim) { ?> <?php echo $total - $vall; ?> out of
                                        <?php echo $tim; ?> slots </b>


                            <?php } else if (($rows2[0] = $tim)) { ?>
                                Slot is Full
                            <?php } ?></td>
                            <td style='text-align:center;'>
                                <a class='label label-primary'>
                                    <?php echo  $wait - $availwait; ?>
                                </a>
                            </td>
                            </tr>
                        <?php
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php } else { ?>
    <h3 style="text-align:center"> Sorry, Event is not Live to register. </h3>
<?php } ?>
<?php
include 'footer.php';
?>