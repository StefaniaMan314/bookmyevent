  <?php
  $connect = mysqli_connect("localhost", "root", "cernces6435", "BME1");
  session_start();
  $offset=$_SESSION['utc_offset'];

  ?>
  <style>
      img.center {
          display: block;
          margin-left: 40px;
          margin-right: auto;
      }



      .a1 {
          font-size: 13px;
          /* Start the shake animation and make the animation last for 0.5 seconds */
      }

      .zoom {
          zoom: 80%;
          -moz-transform: scale(1);
          -moz-transform-origin: 0 0;
      }

      .description-block>.description-header {
          font-size: 13px;
      }



      div.div-container h3:hover {
          text-decoration: none !important;
      }

      q4 {
          width: 100%;
          object-fit: contain;
      }

  </style>

      <?php
if(isset($_POST["slot"]))
{
	
 $slot =  $_POST["slot"];
 $event_id =$_POST["event_id"];

}
else   {
	echo "Please select slot";
	} ?>
  <div class="row">

      <div class="box-body" style="background: #FFFFFF;">
          <p id="hid" style="float:right; margin-right:25px;">
              <a href="registrations_session.php?id=<?php echo $event_id; ?>&slot=<?php echo $slot; ?>" target="_blank" title="Export as Excel File"><img src="./img/xls.png" width="25" height="25" />
              </a>
          </p>
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
                          <th>Session Name</th>
                          <th>Registered On</th>
                      </tr>
                  </thead>
                  <tbody>

	<?php 
	  $i=0;
  $query = " SELECT * FROM testevent  WHERE timeslot='$slot' AND event='$event_id' AND booked='1'  ORDER BY slno ASC";
$result = mysqli_query($connect, $query);

 while($arr1 = mysqli_fetch_row($result))
 { 
     
  
	
	
	
    $query1="SELECT `timeslots`,CONVERT_TZ (DATE_FORMAT(`start`,'%Y-%m-%d %H:%i:%s'),'+00:00','$offset'),CONVERT_TZ (DATE_FORMAT(`end`,'%Y-%m-%d %H:%i:%s'),'+00:00','$offset'),`start`,`end`,`waitlist`,`session_name`  FROM `timeslot` WHERE slno='$slot'";
$result1 = mysqli_query($connect, $query1);
$arr=  mysqli_fetch_row($result1);
$session_name=$arr[6];
$start=$arr[1];
    $end=$arr[2];
   
    $start_date=date('Y-m-d h:i a', strtotime($start));
$end_date=date('Y-m-d h:i a', strtotime($end));


    $timeslot=$start_date.' - '.$end_date;
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
                              <?php echo $session_name;?>
                          </td>
                          <td>
                              <?php echo $arr1[10];?>
                          </td>
                      </tr>

 <?php } ?>
</tbody>
              </table>
          </div>
      </div>
  </div>
