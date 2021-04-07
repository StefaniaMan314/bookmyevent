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
 

}
else   {
	echo "Please select slot";
	} ?>
  <div class="row">
  <div class="col-lg-3"> </div>

      <div class="col-lg-6">
          <p id="hid" style="float:right; margin-right:25px;">
            
          </p>
          <br />
          <br />
          <div class="table-responsive">
              <table id="example1" class="table table-bordered  table-hover table-condensed">
                  <thead>
                      <tr>
					  <th>Slno</th>
                          <th> <b>Event  Name </b></th>
                          <th>Event Date</th>
                          <th>Registrations Count</th>
                    
                      </tr>
                  </thead>
                  <tbody>

	<?php 
	  $i=0;
  $query = " SELECT * FROM bme_analysis1  WHERE month='$slot'  ORDER BY slno ASC";
$result = mysqli_query($connect, $query);

 while($arr1 = mysqli_fetch_row($result))
 { 
     
  
	

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
                             <?php echo $arr1[1];?> -  <?php echo $arr1[2];?>
                          </td>
                          <td>
                              <?php echo $arr1[4];?>
                          </td>
                          
                      </tr>

 <?php } ?>
</tbody>
              </table>
          </div>
      </div>
	   <div class="col-lg-3"> </div>
  </div>
