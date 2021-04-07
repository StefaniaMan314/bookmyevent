<?php 
include 'header.php';
session_start();
$error=$_GET['status'];
$assoc_id=$_SESSION['associateId'];
$assoc_company=$_SESSION['company'];
$assoc_executive=$_SESSION['executive'];
?>
<style>
    * {
        margin: 0;
        padding: 0
    }

    html {
        height: 100%
    }

    #grad1 {
        background-color: : #9C27B0;
    }

    #msform {
        text-align: center;
        position: relative;
        margin-top: 20px
    }

    #msform fieldset .form-card {
        background: white;
        border: 0 none;
        border-radius: 0px;
        box-shadow: 0 2px 2px 2px rgba(0, 0, 0, 0.2);
        padding: 20px 40px 30px 40px;
        box-sizing: border-box;
        width: 94%;
        margin: 0 3% 20px 3%;
        position: relative
    }

    #msform fieldset {
        background: white;
        border: 0 none;
        border-radius: 0.5rem;
        box-sizing: border-box;
        width: 100%;
        margin: 0;
        padding-bottom: 20px;
        position: relative
    }

    #msform fieldset:not(:first-of-type) {
        display: none
    }

    #msform fieldset .form-card {
        text-align: left;
        color: #9E9E9E
    }

    #msform input,
    #msform textarea {
        padding: 0px 8px 4px 8px;
        border: none;
        border-bottom: 1px solid #ccc;
        border-radius: 0px;
        margin-bottom: 25px;
        margin-top: 2px;
        width: 100%;
        box-sizing: border-box;
        font-family: montserrat;
        color: #2C3E50;
        font-size: 16px;
        letter-spacing: 1px
    }

    #msform input:focus,
    #msform textarea:focus {
        -moz-box-shadow: none !important;
        -webkit-box-shadow: none !important;
        box-shadow: none !important;
        border: none;
        font-weight: bold;
        border-bottom: 2px solid skyblue;
        outline-width: 0
    }

    #msform .action-button {
        width: 100px;
        background: #0D94D2;
        font-weight: bold;
        color: white;
        border: 0 none;
        border-radius: 0px;
        cursor: pointer;
        padding: 10px 5px;
        margin: 10px 5px
    }

    #msform .action-button:hover,
    #msform .action-button:focus {
        box-shadow: 0 0 0 2px white, 0 0 0 3px skyblue
    }

    #msform .action-button-previous {
        width: 100px;
        background: #616161;
        font-weight: bold;
        color: white;
        border: 0 none;
        border-radius: 0px;
        cursor: pointer;
        padding: 10px 5px;
        margin: 10px 5px
    }

    #msform .action-button-previous:hover,
    #msform .action-button-previous:focus {
        box-shadow: 0 0 0 2px white, 0 0 0 3px #616161
    }

    select.list-dt {
        border: none;
        outline: 0;
        border-bottom: 1px solid #ccc;
        padding: 2px 5px 3px 5px;
        margin: 2px
    }

    select.list-dt:focus {
        border-bottom: 2px solid skyblue
    }

    .card {
        z-index: 0;
        border: none;
        border-radius: 0.5rem;
        position: relative
    }

    .fs-title {
        font-size: 25px;
        color: #2C3E50;
        margin-bottom: 10px;
        font-weight: bold;
        text-align: left
    }

    #progressbar {
        margin-bottom: 30px;
        overflow: hidden;
        color: lightgrey
    }

    #progressbar .active {
        color: #000000
    }

    #progressbar li {
        list-style-type: none;
        font-size: 12px;
        width: 33%;
        float: left;
        position: relative
    }

    #progressbar #account:before {
        font-family: FontAwesome;
        content: "\f133"
    }

    #progressbar #personal:before {
        font-family: FontAwesome;
        content: "\f0e0"
    }

    #progressbar #payment:before {
        font-family: FontAwesome;
        content: "\f00c"
    }

    #progressbar #confirm:before {
        font-family: FontAwesome;
        content: "\f00c"
    }

    #progressbar li:before {
        width: 50px;
        height: 50px;
        line-height: 45px;
        display: block;
        font-size: 18px;
        color: #ffffff;
        background: lightgray;
        border-radius: 50%;
        margin: 0 auto 10px auto;
        padding: 2px
    }

    #progressbar li:after {
        content: '';
        width: 100%;
        height: 2px;
        background: lightgray;
        position: absolute;
        left: 0;
        top: 25px;
        z-index: -1
    }

    #progressbar li.active:before,
    #progressbar li.active:after {
        background-image: linear-gradient(to bottom, #7BC143 0, #BDE0A1 100%);
    }

    .radio-group {
        position: relative;
        margin-bottom: 25px
    }

    .radio {
        display: inline-block;
        width: 204;
        height: 104;
        border-radius: 0;
        background: lightblue;
        box-shadow: 0 2px 2px 2px rgba(0, 0, 0, 0.2);
        box-sizing: border-box;
        cursor: pointer;
        margin: 8px 2px
    }

    .radio:hover {
        box-shadow: 2px 2px 2px 2px rgba(0, 0, 0, 0.3)
    }

    .radio.selected {
        box-shadow: 1px 1px 2px 2px rgba(0, 0, 0, 0.1)
    }

    .fit-image {
        width: 100%;
        object-fit: cover
    }

</style>
<script>
    $(function() {

        var current_fs, next_fs, previous_fs; //fieldsets
        var opacity;

        $(".next").click(function() {

            current_fs = $(this).parent();
            next_fs = $(this).parent().next();

            //Add Class Active
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

            //show the next fieldset
            next_fs.show();
            //hide the current fieldset with style
            current_fs.animate({
                opacity: 0
            }, {
                step: function(now) {
                    // for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    next_fs.css({
                        'opacity': opacity
                    });
                },
                duration: 600
            });
        });

        $(".previous").click(function() {

            current_fs = $(this).parent();
            previous_fs = $(this).parent().prev();

            //Remove class active
            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

            //show the previous fieldset
            previous_fs.show();

            //hide the current fieldset with style
            current_fs.animate({
                opacity: 0
            }, {
                step: function(now) {
                    // for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    previous_fs.css({
                        'opacity': opacity
                    });
                },
                duration: 600
            });
        });

        $('.radio-group .radio').click(function() {
            $(this).parent().find('.radio').removeClass('selected');
            $(this).addClass('selected');
        });

    });

    function validateForm() {
        var x = document.forms["msform"]["ename"].value;
        if (x.trim() == "" || x == "" || x == null) {
            alertify.alert('Details needed!!', 'Please fill out Event name in Event Details menu', function() {
                alertify.set('notifier', 'position', 'top-right');
                alertify.error('Please fill out Event name in Event Details menu');
            });
            return false;
        }

        var y = document.forms["msform"]["edesc"].value;
        if (y.trim() == "" || y == "" || y == null) {
            alertify.alert('Details needed!!', 'Please fill out Event Description in Event Details menu', function() {
                alertify.set('notifier', 'position', 'top-right');
                alertify.error('Please fill out emailbox Description in Event Details menu');
            });
            return false;
        }

        var z = document.forms["msform"]["edate"].value;
        if (z == "" || z == null) {
            alertify.alert('Details needed!!', 'Please fill out Event Date in Event Details menu', function() {
                alertify.set('notifier', 'position', 'top-right');
                alertify.error('Please fill out Event Date in Event Details menu');
            });
            return false;
        }

        var xx = document.forms["msform"]["country"].value;
        if (xx == "" || xx == null) {
            alertify.alert('Details needed!!', 'Please fill out Country field in Event Details menu', function() {
                alertify.set('notifier', 'position', 'top-right');
                alertify.error('Please fill out Country field in Event Details menu');
            });
            return false;
        }

        var xx = document.forms["msform"]["emailbox"].value;
        if (p == "" || p == null) {
            alertify.alert('Details needed!!', 'Please fill out Event name in Event Details menu', function() {
                alertify.set('notifier', 'position', 'top-right');
                alertify.error('Please fill out emailbox name in Event Details menu');
            });
            return false;
        }


    }

    function SelectLocation(Eventtype) {
        if (Eventtype) {
            admOptionValue = document.getElementById("Locationtype").value;
            if (admOptionValue == Eventtype.value) {
                document.getElementById("div_location").style.display = "block";
            } else {
                document.getElementById("div_location").style.display = "none";
            }
        } else {
            document.getElementById("div_location").style.display = "none";
        }
    }

    function SelectFood(Eventtype) {
        if (Eventtype) {
            admOptionValue = document.getElementById("yes").value;
            if (admOptionValue == Eventtype.value) {
                document.getElementById("div_food").style.display = "block";
            } else {
                document.getElementById("div_food").style.display = "none";
            }
        } else {
            document.getElementById("div_food").style.display = "none";
        }
    }

    function SelectConfirmation(confirmmsg) {
        if (confirmmsg) {
            admOptionValue = document.getElementById("customize_msg").value;
            if (admOptionValue == confirmmsg.value) {
                document.getElementById("confirm_email").style.display = "block";
            } else {
                document.getElementById("confirm_email").style.display = "none";
            }
        } else {
            document.getElementById("confirm_email").style.display = "none";
        }
    }


    function SelectInvite(calmsg) {
        if (calmsg) {
            admOptionValue = document.getElementById("customize_msg").value;
            if (admOptionValue == calmsg.value) {
                document.getElementById("cal_invite").style.display = "block";
            } else {
                document.getElementById("cal_invite").style.display = "none";
            }
        } else {
            document.getElementById("cal_invite").style.display = "none";
        }
    }

</script>
<script>
    $(document).ready(function() {
        $('#preview').on('click', function() {
            $mailcontent = $('#confirm_email').val();
            $cal_invite = $('#cal_invite').val();
            if ($mailcontent == '') {
                $mailcontent = 'Thank you for registering the event';
            }
            if ($cal_invite == '') {
                $cal_invite = 'Its time for the event';
            }
            $.ajax({
                type: 'POST',
                url: 'mail_preview1.php',
                data: {
                    "cal_invite": $cal_invite,
                    "mailcontent": $mailcontent
                },
                success: function(html) {
                    $('#preview_show').html(html);
                }
            });
        });

    });

</script>
<!-- MultiStep Form -->
<div class="container-fluid" id="grad1">
    <div class="row justify-content-center mt-0">
        <div class="col-11 col-sm-12 col-md-7 col-lg-8 text-center p-0 mt-3 mb-2">
            <div class="card px-0 pt-4 pb-0 mt-3 mb-3 w3-round-large">
                <h2 style='color:#0D94D2'><strong> <i class="fas fa-calendar-plus"></i> Create new Event</strong>
                    <span class='float-right'><a class="btn btn-default" target='_blank' href='https://bookmyevent.cerner.com/Manual/Add_Event.html'>
                            <i class="fas fa-info-circle w3-circle"></i> Help!
                        </a>&nbsp;</span>
                </h2>
                <div class="row">
                    <div class="col-md-12 mx-0">
                        <form role="form" id="msform" method="post" action="event_insert.php" enctype="multipart/form-data">
                            <!-- progressbar -->
                            <ul id="progressbar">
                                <li class="active" id="account"><strong>Event Details</strong></li>
                                <li id="personal"><strong>E-Mail Content</strong></li>
                                <li id="payment"><strong>Event Logo/Go Live </strong></li>

                            </ul> <!-- fieldsets -->
                            <fieldset>
                                <div class="form-card">
                                    <h2 class="fs-title">Event Details</h2>
                                    <div class='row'>
                                        <div class='col-lg-10'>
                                            <?php
                                $query = $link->query("SELECT * FROM emailbox WHERE assoc_id='$assoc_id' AND status='1'");
                                $rowCount = $query->num_rows;
                                ?>
                                            <!--It works with onchange event-->
                                            <select style='background-color:white;width:100%;color:#767c8b;font-family: montserrat;font-size: 16px;letter-spacing: 1px;' class="list-dt select2" name="emailbox" id="emailbox">
                                                <option value="" selected hidden>Select Mailbox</option>
                                                <?php
                                  if($rowCount > 0){
                                  while($row = $query->fetch_assoc()){

                                  echo '<option value="'.$row['mail_address'].'">'.$row['mail_address'].'</option>';
                                  }
                                }
                                  echo '<option value="BookMyEvent@cerner.com">BookMyEvent@cerner.com</option>';
                                  
                              ?>
                                            </select></div>
                                        <div class='col-lg-2'>
                                            <center><a href='Add_Mail.php' class='btn btn-primary' style='color:#fff'>Add Mailbox</a></center>
                                        </div>
                                    </div><br /><br />
                                    <input type="text" id="ename" name="ename" placeholder="Event Name" />
                                    <textarea style="max-width:100%;color:#767c8b;font-family: montserrat;font-size: 16px;letter-spacing: 1px;" name="edesc" placeholder="Event Description(Max 800 characters)"></textarea>
                                    <input name="edate" id="datepicker" placeholder="Event Date">
                                    <select style='background-color:white;width:100%;color:#767c8b;font-family: montserrat;font-size: 16px;letter-spacing: 1px;' class="list-dt select2" id='type1' name='type1' placeholder="">
                                        <option value='single'>Single Session Registration</option>
                                        <option value='multiple'>Multiple Session Registration</option>
                                    </select><br /><br />

                                    <?php
                                $query = $link->query("SELECT DISTINCT(Country) FROM `Head_Count` ORDER BY Country");
                                $rowCount = $query->num_rows;
                                ?>
                                    <!--It works with onchange event-->
                                    <select style='background-color:white;width:100%;color:#767c8b;font-family: montserrat;font-size: 16px;letter-spacing: 1px;' class="list-dt select2" name="country" id="country">
                                        <option value="" selected hidden>Select Country</option>
                                        <?php
                                  if($rowCount > 0){
                                  while($row = $query->fetch_assoc()){

                                  echo '<option value="'.$row['Country'].'">'.$row['Country'].'</option>';
                                  }
                                }else{
                                  echo '<option value="">Country not available</option>';
                                  }
                                  
                              ?>
                                    </select><br /><br />
                                    <select style='background-color:white;width:100%;color:#767c8b;font-family: montserrat;font-size: 16px;letter-spacing: 1px;' class="list-dt select2" onchange="SelectLocation(this);" placeholder="">
                                        <option id="online_event">Online Event</option>
                                        <option id="Locationtype">Venue Event</option>
                                    </select>
                                    <div id="div_location" style="display:none;"><br /><br />
                                        <input id="Venue_type" name="Location" placeholder="Enter Detail Location" />
                                        <select style='background-color:white;width:100%;color:#767c8b;font-family: montserrat;font-size: 16px;letter-spacing: 1px;' class="list-dt select2" name='food' onchange="SelectFood(this);" placeholder=" ">
                                            <option value="0">----Food Included----</option>
                                            <option id="yes" value="1">Yes</option>
                                            <option id="no" value="0">No</option>

                                        </select><br />
                                        <div id="div_food" style="display:none;"><br />
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <center>
                                                        <label>Breakfast</label></center>
                                                    <input type="checkbox" name="breakfast" />
                                                </div>
                                                <div class="col-lg-4">
                                                    <center>
                                                        <label>Lunch</label></center>
                                                    <input type="checkbox" name="lunch" />
                                                </div>
                                                <div class="col-lg-4">
                                                    <center>
                                                        <label>Socials</label></center>
                                                    <input type="checkbox" name="socials" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="button" name="next" class="next action-button" value="Next Step" />
                            </fieldset>
                            <fieldset>
                                <div class="form-card">
                                    <h2 class="fs-title">E-Mail/Cal Invite Content</h2>
                                    <select style='background-color:white;width:100%;color:#767c8b;font-family: montserrat;font-size: 16px;letter-spacing: 1px;' class="list-dt select2" onchange="SelectConfirmation(this);" placeholder="">

                                        <option id="no_msgtype">---Select Message Type for E-Mail Content---</option>
                                        <option id="default_msg">Default Message</option>
                                        <option id="customize_msg">Customize Message</option>
                                    </select><br /><br />
                                    <textarea style='display:none;background-color:white;max-width:100%;height:100px;color:#767c8b;font-family: montserrat;font-size: 16px;letter-spacing: 1px;' id="confirm_email" name="confirm_email" placeholder="Enter Message(Max 800 characters) "></textarea>
                                    <select style='background-color:white;width:100%;color:#767c8b;font-family: montserrat;font-size: 16px;letter-spacing: 1px;' class="list-dt select2" onchange="SelectInvite(this);" placeholder="">

                                        <option id="">---Select Message Type for Cal Invite---</option>
                                        <option id="default_msg">Default Message</option>
                                        <option id="customize_msg">Customize Message</option>
                                    </select>
                                    <textarea style='display:none;background-color:white;max-width:100%;height:100px;color:#767c8b;font-family: montserrat;font-size: 16px;letter-spacing: 1px;' id="cal_invite" name="cal_invite" placeholder="Enter Message(Max 800 characters)"></textarea>
                                </div>
                                <input type="button" name="previous" class="previous action-button-previous" value="Previous" />

                                <input type="button" id='preview' class="action-button" style="background-color:#F58025" data-toggle="modal" data-target="#modal-lg" value='Preview' />
                                <input type="button" name="next" class="next action-button" value="Next Step" />
                            </fieldset>
                            <fieldset>
                                <div class="form-card">
                                    <h2 class="fs-title">Event Logo</h2>
                                    <input type="file" name="Filename" oninput="this.className = ''" style="height:50px" required />
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <center>
                                                <label>QR Code</label></center>
                                            <input type="checkbox" value='yes' name="qrcode_status" />
                                        </div>
                                        <div class="col-lg-6">
                                            <center>
                                                <label>Go Live</label></center>
                                            <input type="checkbox" value='yes' name="go_live" />
                                        </div>
                                    </div>
                                </div> <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                                <input type="submit" id='submit' onclick="return validateForm()" name="make_payment" class="action-button" value="Submit" />
                            </fieldset>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Preview</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="preview_show">
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<?php 
include 'footer.php';
?>
