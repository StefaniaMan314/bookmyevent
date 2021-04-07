<?php 
include 'header.php';
session_start();
$error=$_GET['status'];
$assoc_id=$_SESSION['associateId'];
$assoc_company=$_SESSION['company'];
$assoc_executive=$_SESSION['executive'];
 $today= date('Y-m-d');
?>
<div class="container-fluid" id="grad1">
    <div class="row justify-content-center mt-0">
        <div class="col-11 col-sm-12 col-md-7 col-lg-8 p-0 mt-3 mb-2">
            <div class="card w3-round-large" style='padding-left:5px;padding-right:5px;padding-bottom:15px;'>
                <h2 style='color:#0D94D2' class='text-center '><strong> <i class="fas fa-user-clock"></i> Add Timeslot</strong></h2>
                <p class='text-center '>Repeat this step to add all the event timeslots</p>
                <div class="row">
                    <div class="col-md-12">
                        <form role="form" method="post" action="time_insert.php" onsubmit="return upperMe1()" enctype="multipart/form-data">
                            <?php if ($_SESSION['role']=='Super Admin') { ?>
                            <div class="form-group">
                                <label><b>Event Name</b></label>
                                <?php
                                $query = $link->query("SELECT * FROM event WHERE edate>='$today'");
                                $rowCount = $query->num_rows;
                                ?>
                                <!--It works with onchange event-->
                                <select style='font-size:15px;background-color:white;' class="form-control" name="eid" id="country1" required>
                                    <option value="" selected hidden>Select Event</option>
                                    <?php
                                  if($rowCount > 0){
                                  while($row = $query->fetch_assoc()){

                                  echo '<option value="'.$row['slno'].'">'.$row['ename'].'</option>';
                                  }
                                }else{
                                  echo '<option value="">No Event in the list</option>';
                                  }
                              ?>
                                </select>
                            </div><?php } else { ?>
                            <div class="form-group">
                                <label><b>Event Name</b></label>
                                <?php
                                $query = $link->query("SELECT * FROM event WHERE creator='$assoc_id' AND edate>='$today'");
                                $rowCount = $query->num_rows;
                                ?>
                                <!--It works with onchange event-->
                                <select style='font-size:15px;background-color:white;' class="form-control w3-border select2 w3-hover-border-blue" name="eid" id="country1" required>
                                    <option value="" selected hidden>Select Event</option>
                                    <?php
                                  if($rowCount > 0){
                                  while($row = $query->fetch_assoc()){

                                  echo '<option value="'.$row['slno'].'">'.$row['ename'].'</option>';
                                  }
                                }else{
                                  echo '<option value="">No Event in the list</option>';
                                  }
                              ?>
                                </select>
                            </div>
                            <?php } ?>
                            <div class="form-group">
                                <label><b>Session Name </b></label>
                                <input style='font-size:15px;background-color:white;' class="form-control w3-border  w3-hover-border-blue" name="session_name" placeholder=" " required>
                            </div>
                            <div class="form-group">
                                <label><b>Session Location </b></label>
                                <input style='font-size:15px;background-color:white;' class="form-control w3-border  w3-hover-border-blue" name="session_location" placeholder=" " required>
                            </div>
                            <div class="form-group">
                                <label>Start to End time</label>

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-clock"></i></span>
                                    </div>
                                    <input type="text" class="form-control float-right" name='reservationtime' id="reservationtime" required />
                                </div>
                                <!-- /.input group -->
                            </div>
                            <div class="form-group">
                                <label><b>Registrations</b></label>
                                <input style='font-size:15px;background-color:white;' class="form-control w3-border  w3-hover-border-blue" name="timeslots" placeholder="No of registrations" required> </div>
                            <div class="form-group">
                                <label><b>Waitlist Registrations</b></label>
                                <input style='font-size:15px;background-color:white;' class="form-control w3-border  w3-hover-border-blue" name="waitlist" placeholder="No of registrations for waitlist" required>
                            </div>
                            <button type="submit" name="save1" class="btn btn-default bg-olive">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
include 'footer.php';
?>
