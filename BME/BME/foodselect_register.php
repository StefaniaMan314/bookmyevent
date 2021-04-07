<?php include 'header.php';
include 'phpqrcode/qrlib.php'; 

include 'DB.php';
session_start();

$event_id=$_GET['id'];
$assoc_id=$_GET['assoc_id'];


$check1=$link->query("select breakfast,lunch,socials from `event` where slno='$event_id'");
 $rows1=mysqli_fetch_row($check1);
$breakfast=$rows1[0];
$lunch=$rows1[1];
$socials=$rows1[2];

  
 
 
?>

 <div id="page-wrapper">
        <div class="container-fluid">
            
               


<div class="box">
            <div class="box-header">
			 <h3> Food Preferences</h3>
			 					<h5 style="color:#0D94D2">Note : Please check the below food preferences and Submit   </h5>
             
            </div>
            <!-- /.box-header -->
            <!-- form start -->
			  <div class="box-body">
		
            <form role="form" method="post" action="food_insert_register.php?id=<?php echo $event_id; ?>&assoc_id=<?php echo $assoc_id?>">
            	  <div class="row" >
  <div class="col-lg-1">
                <div class="form-group">
                <?php if($breakfast=='1'){ ?><input type="checkbox" name="breakfast" /> &nbsp; Breakfast
	   <?php } ?>
                </div></div>
				 <div class="col-lg-1">
                <div class="form-group">
                <?php if($lunch=='1'){ ?> <input type="checkbox" name="lunch" />  &nbsp;Lunch
		  <?php } ?>
                </div> </div>
				<div class="col-lg-1">
                <div class="form-group">
                <?php if($socials=='1'){ ?> <input type="checkbox" name="socials" />  &nbsp;Socials
		  <?php } ?>
                </div></div>
				</div>
				 <div class="row" >
  <div class="col-lg-7">
		         <div class="form-group">
                                <br/>
                                <label><b>Do you have any dietary restrictions? </b></label><br/>
                                <select style='font-size:15px;background-color:white;width:50%' class="form-control w3-border select2 w3-hover-border-blue" id="dietary" oninput="this.className = ''" name='dietary' placeholder=" " required>
                                    <option value="" selected hidden>---- Select ----</option>
                                    <option value="None">None</option>
									<option value="Vegetarian">Vegetarian</option>
                                    <option value="Dairy Free">Dairy Free</option>
										      <option value="Gluten Free">Gluten Free</option>
											  	<option value="Halal">Halal</option>
												<option value="other">other</option>
                                </select>


                            </div>
             
              <!-- /.box-body -->
             </div></div>
               <br/>
                <button type="submit" name="save1"  class="btn btn-default bg-olive">Submit</button>
				 
          <input type="button"  value="Skip"   class="btn btn-default bg-red"  id="btnHome" onClick="Javascript:window.location.href = 'landing_register.php?id=<?php echo $event_id; ?>';" />
            </form>
			
          </div> </div>

            </div>
        </div>
    
    <?php include 'footer.php'; ?>