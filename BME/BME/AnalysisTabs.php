<?php include 'header.php';
include "DB.php"; 
session_start();
$offset=$_SESSION['utc_offset'];
 $today= date('Y-m-d');


$event_id=$_GET['id'];


	  $event_date=$link->query("SELECT * FROM event WHERE slno='$event_id'");
	$event_date1=mysqli_fetch_assoc($event_date);
$event_name=$event_date1['ename'];
$qrcode_status=$event_date1['qrcode_status'];
$event_date=$event_date1['edate'];

$food=$event_date1['food'];
$breakfast=$event_date1['breakfast'];
$lunch=$event_date1['lunch'];
$socials=$event_date1['socials'];

$location=$event_date1['Location'];


$assoc_id=$_SESSION['associateId'];
 $assoc_company=$_SESSION['company'];
 $assoc_executive=$_SESSION['executive'];
 $query=("SELECT COUNT(*) FROM `testevent` where  event='$event_id' ");
		$result=mysqli_query($link,$query) or die();
$arr=  mysqli_fetch_row($result);
$count=$arr[0];
$registration_cost=$count*(2.5);


$query1=("SELECT * FROM `testevent` where  event='$event_id' ");
		$result1=mysqli_query($link,$query1) or die();
$arr1=  mysqli_fetch_row($result1);

 $today= date('Y-m-d');
 
    ?>


<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>


<style>
    html,
    body {
        width: 100%;
        height: 100%;
        margin: 0px;
    }

    #chartdiv1 {
        width: 100%;
        height: 900px;
    }



    #chartdiv2 {
        width: 100%;
        height: 900px;
    }

    #chartdiv3 {
        width: 100%;
        height: 900px;
    }

    #chartdiv4 {
        width: 100%;
        height: 900px;
    }

    .amcharts-chart-div a {
        display: none !important;
    }

</style>
<?php $check3=$link->query("SELECT COUNT(*)  FROM `eventhost` WHERE AssociateId = '$assoc_id' AND event_id='$event_id'");
    $rows3=mysqli_fetch_row($check3);
	if(($rows3[0]>=1) || ($_SESSION['role']=='Super Admin') ) 
    {  ?>

<div class="row">
    <div class="col-lg-7">
        <h3>
            <?php echo $event_name; ?>
            - Event Analysis </h3>
        <h5>Location: <?php echo $location; ?></h5>
    </div>
    <div class="col-lg-5">
        <h3> Total Registrations: <?php echo $count; ?> </h3>
        <h4> Total Cost Saved : <b style="color:red">$<?php echo $registration_cost; ?> </b>($2.5 per registration) </h4>
    </div>
</div>
<div class="row">
    <br />
    <br />
    <div class="col-lg-12">
        <!-- Custom Tabs -->

        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">All Registrations</a></li>
                    <li class="nav-item"><a class="nav-link" href="#upcoming" data-toggle="tab">Department</a></li>
                    <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Organization</a></li>
                    <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Executive</a></li>
                    <li class="nav-item"><a class="nav-link" href="#attended" data-toggle="tab">Title</a></li>
                    <li class="nav-item"><a class="nav-link" href="#sessions" data-toggle="tab">Sessions</a></li>
                    <li class="nav-item"><a class="nav-link" href="#food" data-toggle="tab">Food Registrations</a></li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                        <p id="hid" style="float:right; margin-right:25px;">
                            <a href="registrations_testevent.php?id=<?php echo $event_id; ?>" target="_blank" title="Export as Excel File"><img src="./img/xls.png" width="25" height="25" /></a>
                        </p>
                        <br />
                        <br />
                        <br />
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered  table-hover table-condensed">
                                <thead>
                                    <tr>
                                        <th>Slno</th>
                                        <th>Associate Name</th>
                                        <th>Associate ID</th>
                                        <th>Email Id</th>
                                        <th>Title</th>
                                        <th>Department</th>
                                        <th>Organization</th>
                                        <th>Executive</th>
                                        <th>Time Slot</th>
                                        <th>Registered On</th>
                                        <?php if($event_date  >= $today) { ?>
                                        <?php if(( $_SESSION['role']=='Super Admin')) {?>
                                        <th> Unregister </th><?php } ?>
                                        <?php } ?>
                                        <?php if($qrcode_status=='1'){ ?> <th>Attended</th> <?php  }?>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
								
								$i=0; 
								if($arr1[2]!=''){ do{
    $query="SELECT  `timeslots`,CONVERT_TZ (DATE_FORMAT(`start`,'%Y-%m-%d %H:%i:%s'),'+00:00','$offset'),CONVERT_TZ (DATE_FORMAT(`end`,'%Y-%m-%d %H:%i:%s'),'+00:00','$offset'),`start`,`end`,`waitlist` FROM `timeslot` WHERE slno='$arr1[9]'";
$result = $link->query($query) or die("Error0 : ".mysqli_error($link));
$arr=  mysqli_fetch_row($result);
   
    $start=$arr[1];
    $end=$arr[2];
   
    $start_date=date('Y-m-d h:i a', strtotime($start));
$end_date=date('Y-m-d h:i a', strtotime($end));


    $timeslot=$start_date.' - '.$end_date;
	$attend_status=$arr1[15];
if(($event_date>=$today) && ($attend_status=='0')){
	$attend='Not yet';
}
else if(($event_date< $today) && ($attend_status=='0')){
	$attend='Attendance not updated';
}
else if($attend_status=='1'){
	$attend='Yes';
}
	$i++;
                                ?>
                                    <tr>
                                        <td>
                                            <?php echo $i;?>
                                        </td>
                                        <td>
                                            <?php echo $arr1[3];?>
                                        </td>
                                        <td>
                                            <?php echo $arr1[2];?>
                                        </td>
                                        <td>
                                            <?php echo $arr1[4];?>
                                        </td>
                                        <td>
                                            <?php echo $arr1[5];?>
                                        </td>
                                        <td>
                                            <?php echo $arr1[6];?>
                                        </td>
                                        <td>
                                            <?php echo $arr1[7];?>
                                        </td>
                                        <td>
                                            <?php echo $arr1[8];?>
                                        </td>
                                        <td>
                                            <?php echo $timeslot;?>
                                        </td>
                                        <td>
                                            <?php echo $arr1[10];?>
                                        </td>
                                        <?php if($event_date  >= $today) { ?>
                                        <?php if(( $_SESSION['role']=='Super Admin')) {?>
                                        <td>

                                            <iframe frameborder="0" scrolling="no" ; style="overflow:hidden;" src="unregisterframe.php?slno=<?php echo $arr1[1]; ?>&assoc_id=<?php echo $arr1[2]; ?>&event_id=<?php echo $event_id; ?>" width="150px" height="60px"> </iframe>

                                        </td><?php } ?>
                                        <?php } ?>
                                        <?php if($qrcode_status=='1'){ ?> <td style="color:red">

                                            <b> <?php echo $attend; ?> </b> </td> <?php } ?>


                                    </tr>
                                    <?php

}while($arr1=mysqli_fetch_row($result1));}?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="attended">

                        <div class="row">
                            <div class="col-lg-5">
                                <div class="table-responsive">

                                    <table id="example5" class="table table-bordered  table-hover table-condensed">
                                        <thead>
                                            <tr>
                                                <?php  $query1=("SELECT Title,count(Title) AS 'count' FROM `testevent` where  event='$event_id'  GROUP BY `Title` ORDER BY count DESC ");
		$result1=mysqli_query($link,$query1) or die();
$arr1=  mysqli_fetch_row($result1); ?>
                                                <th>Title</th>
                                                <th>Count</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if($arr1[0]!=''){ do{
                                ?>
                                            <tr>

                                                <td>
                                                    <?php echo $arr1[0];?>
                                                </td>
                                                <td>
                                                    <?php echo $arr1[1];?>
                                                </td>

                                            </tr>
                                            <?php

}while($arr1=mysqli_fetch_row($result1));}?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div id="chartdiv1"></div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="upcoming">
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="table-responsive">

                                    <table id="example11" class="table table-bordered  table-hover table-condensed">
                                        <thead>
                                            <tr>
                                                <?php  $query1=("SELECT Department,count(Department) AS 'count' FROM `testevent` where  event='$event_id'  GROUP BY `Department`  ORDER BY count DESC  ");
		$result1=mysqli_query($link,$query1) or die();
$arr1=  mysqli_fetch_row($result1); ?>
                                                <th>Department</th>
                                                <th>Count</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if($arr1[0]!=''){ do{
                                ?>
                                            <tr>

                                                <td>
                                                    <?php echo $arr1[0];?>
                                                </td>
                                                <td>
                                                    <?php echo $arr1[1];?>
                                                </td>

                                            </tr>
                                            <?php

}while($arr1=mysqli_fetch_row($result1));}?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div id="chartdiv2"></div>
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="timeline">

                        <div class="row">
                            <div class="col-lg-5">
                                <div class="table-responsive">

                                    <table id="example4" class="table table-bordered  table-hover table-condensed">
                                        <thead>
                                            <tr>
                                                <?php  $query1=("SELECT Organization,count(Organization) AS 'count' FROM `testevent` where  event='$event_id'  GROUP BY Organization  ORDER BY count DESC ");
		$result1=mysqli_query($link,$query1) or die();
$arr1=  mysqli_fetch_row($result1); ?>
                                                <th>Organization</th>
                                                <th>Count</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if($arr1[0]!=''){ do{
                                ?>
                                            <tr>

                                                <td>
                                                    <?php echo $arr1[0];?>
                                                </td>
                                                <td>
                                                    <?php echo $arr1[1];?>
                                                </td>

                                            </tr>
                                            <?php

}while($arr1=mysqli_fetch_row($result1));}?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div id="chartdiv3"></div>
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="settings">

                        <div class="row">

                            <div class="col-lg-5">
                                <div class="table-responsive">

                                    <table id="example3" class="table table-bordered  table-hover table-condensed">
                                        <thead>
                                            <tr>
                                                <?php  $query1=("SELECT Executive,count(Executive) AS 'count' FROM `testevent` where  event='$event_id'  GROUP BY `Executive`  ORDER BY count DESC ");
		$result1=mysqli_query($link,$query1) or die();
$arr1=  mysqli_fetch_row($result1); ?>
                                                <th>Executive</th>
                                                <th>Count</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if($arr1[0]!=''){ do{
                                ?>
                                            <tr>

                                                <td>
                                                    <?php echo $arr1[0];?>
                                                </td>
                                                <td>
                                                    <?php echo $arr1[1];?>
                                                </td>

                                            </tr>
                                            <?php

}while($arr1=mysqli_fetch_row($result1));}?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div id="chartdiv4"></div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="sessions">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <input type="hidden" name="event_id" id="event_id" value="<?php echo $event_id ?>" />
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label><b>Registrations View &nbsp;</b></label>

                                    <?php
                                $query = $link->query("SELECT * FROM timeslot WHERE eslno='$event_id'");
                                $rowCount = $query->num_rows;
                                ?>
                                    <!--It works with onchange event-->
                                    <select style='font-size:15px;background-color:white;width:50%' class="form-control w3-border select2 w3-hover-border-blue" name="slot" id="slot" required>
                                        <option value=" " hidden>Select Session</option>
                                        <?php
                                  if($rowCount > 0){
                                  while($row = $query->fetch_assoc()){

                                  echo '<option value="'.$row['slno'].'">'.$row['session_name'].'</option>';
                                  }
                                }else{
                                  echo '<option value="">Session not available</option>';
                                  }
                              ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <br />

                        <div class='row'>
                            <div class='col-lg-12'>


                                <div id='tab1'> </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="food">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <input type="hidden" name="event_id" id="event_id" value="<?php echo $event_id ?>" />
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label><b>Food Registrations &nbsp;</b></label>



                                    <select style="width:50%" class="form-control w3-border select2 w3-hover-border-blue" id="foodsession" oninput="this.className = ''" name='foodsession' placeholder=" " required>
                                        <option value="" selected hidden>- Select -</option>
                                        <?php if($breakfast=='1'){  ?><option value="breakfast">Breakfast</option> <?php } ?>
                                        <?php if($lunch=='1'){  ?><option value="lunch">Lunch</option> <?php } ?>
                                        <?php if($socials=='1'){  ?><option value="socials">Socials</option> <?php } ?>


                                    </select>


                                </div>
                            </div>
                        </div>

                        <br />

                        <div class='row'>
                            <div class='col-lg-12'>


                                <div id='tab2'> </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div><!-- /.card-body -->
        </div>


    </div>


</div>
<script>
    $(function() {
        $("#slot").on('change', function() {
            var event_id = document.getElementById('event_id').value;
            var slot = document.getElementById('slot').value;
            if (slot) {
                $.ajax({
                    type: 'POST',
                    url: 'fetchsession.php',
                    data: {
                        event_id: event_id,
                        slot: slot

                    },
                    success: function(html) {
                        $('#tab1').html(html);
                    }
                });
            }
        });
    });

    $(function() {
        $("#foodsession").on('change', function() {
            var event_id = document.getElementById('event_id').value;
            var foodsession = document.getElementById('foodsession').value;
            if (foodsession) {
                $.ajax({
                    type: 'POST',
                    url: 'fetchfoodreg.php',
                    data: {
                        event_id: event_id,
                        foodsession: foodsession

                    },
                    success: function(html) {
                        $('#tab2').html(html);
                    }
                });
            }
        });
    });

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

    var chart = AmCharts.makeChart("chartdiv1", {
        "type": "serial",
        "theme": "light",
        "dataProvider": [
            <?php $sql2="SELECT `Title`,COUNT(`Title`) as countas FROM `testevent` WHERE `Title`!='' AND event='$event_id' GROUP BY `Title` ORDER BY countas DESC";
        $result2 = mysqli_query($link,$sql2);

        while ($roww2 = mysqli_fetch_array($result2))
		{
			$assoc_title=mysqli_real_escape_string($link, $roww2[0]); 
                $title_count=$roww2[1];
            
                ?> {
                "country": "<?php echo $assoc_title; ?>",
                "visits": "<?php echo $title_count; ?>"
            },
            <?php } ?>
        ],
        "graphs": [{
            "fillAlphas": 1,
            "lineAlpha": 0.2,
            "type": "column",
            "valueField": "visits",
            "balloonText": "<p style='font-size:15px;'> [[country]] : [[visits]] associates</p>"

        }],
        "categoryField": "country",
        "rotate": true
    });


    var chart = AmCharts.makeChart("chartdiv2", {
        "type": "serial",
        "theme": "light",
        "dataProvider": [
            <?php $sql2="SELECT `Department`,COUNT(`Department`) as countas FROM `testevent` WHERE `Department`!='' AND event='$event_id' GROUP BY `Department` ORDER BY countas DESC";
        $result2 = mysqli_query($link,$sql2);

        while ($roww2 = mysqli_fetch_array($result2))
		{
			$assoc_title=mysqli_real_escape_string($link, $roww2[0]); 
                $title_count=$roww2[1];
            
                ?> {
                "country": "<?php echo $assoc_title; ?>",
                "visits": "<?php echo $title_count; ?>"
            },
            <?php } ?>
        ],
        "graphs": [{
            "fillAlphas": 1,
            "lineAlpha": 0.2,
            "type": "column",
            "valueField": "visits",
            "balloonText": "<p style='font-size:15px;'> [[country]] : [[visits]] associates</p>"

        }],
        "categoryField": "country",
        "rotate": true
    });


    var chart = AmCharts.makeChart("chartdiv4", {
        "type": "serial",
        "theme": "light",
        "dataProvider": [
            <?php $sql2="SELECT `Executive`,COUNT(`Executive`) as countas FROM `testevent` WHERE `Executive`!='' AND event='$event_id' GROUP BY `Executive` ORDER BY countas DESC";
        $result2 = mysqli_query($link,$sql2);

        while ($roww2 = mysqli_fetch_array($result2))
		{
			$assoc_title=mysqli_real_escape_string($link, $roww2[0]); 
                $title_count=$roww2[1];
            
                ?> {
                "country": "<?php echo $assoc_title; ?>",
                "visits": "<?php echo $title_count; ?>"
            },
            <?php } ?>
        ],
        "graphs": [{
            "fillAlphas": 1,
            "lineAlpha": 0.2,
            "type": "column",
            "valueField": "visits",
            "balloonText": "<p style='font-size:15px;'> [[country]] : [[visits]] associates</p>"

        }],
        "categoryField": "country",
        "rotate": true
    });


    var chart = AmCharts.makeChart("chartdiv3", {
        "type": "serial",
        "theme": "light",
        "dataProvider": [
            <?php $sql2="SELECT `Organization`,COUNT(`Organization`) as countas FROM `testevent` WHERE `Organization`!='' AND event='$event_id' GROUP BY `Organization` ORDER BY countas DESC";
        $result2 = mysqli_query($link,$sql2);

        while ($roww2 = mysqli_fetch_array($result2))
		{
			$assoc_title=mysqli_real_escape_string($link, $roww2[0]); 
                $title_count=$roww2[1];
            
                ?> {
                "country": "<?php echo $assoc_title; ?>",
                "visits": "<?php echo $title_count; ?>"
            },
            <?php } ?>

        ],
        "graphs": [{
            "fillAlphas": 1,
            "lineAlpha": 0.2,
            "type": "column",
            "valueField": "visits",
            "balloonText": "<p style='font-size:15px;'> [[country]] : [[visits]] associates</p>"

        }],
        "categoryField": "country",
        "rotate": true
    });

    // end am4core.ready()

</script>


<?php  }  else {?>
<h3 style="text-align:center"> Sorry, You don't have access to view this Event's Analysis. </h3>
<?php } ?>
</body>
<?php include 'footer.php'; ?>
