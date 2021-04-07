<?php include 'header.php';
session_start();
$assoc_id=$_SESSION['associateId'];
$assoc_name=$_SESSION['fullname'];
 $today= date('Y-m-d');
 $slno=$_GET['slno'];
  $assoc_id=$_GET['assoc_id'];
  
  
   $event_date=$link->query("SELECT * FROM suggestions WHERE slno='$slno' AND assoc_id='$assoc_id'");
	$event_date1=mysqli_fetch_assoc($event_date);
$assoc_name=$event_date1['assoc_name'];
$feeddate=$event_date1['feeddate'];
$comments=$event_date1['comments'];
$developer=$event_date1['developer'];
$status=$event_date1['status'];

?>

<style>

.btn-app {
    border-radius: 3px;
    position: relative;
    padding: 4px 2px;
    margin: 5px 0 -2px -4px;
    min-width: 80px;
    height: 17px;
    text-align: center;
    color: green;
    border: 1px solid #black;
    background-color: #ffffff;
    font-size: 10px;
}

</style>
    <div id="page-wrapper" >
        <div id="content-wrapper">
            <div class="card">
                <div class="card-header" style="background: #fff;">
                    <h3>Feedback Edit</h3></div>
                <div class="card-body" style="background: #fff;">
                    <form role="form" method="post" action="scripts/update_feedback.php" onsubmit="return upperMe1()" enctype="multipart/form-data">
                        
                            <div class="col-lg-4">
                                <div class="form-group">
                                    
                                    <input type="hidden" name="ID" value="<?=$slno;?>"> </div>
									<div class="form-group">
                                    
                                    <input type="hidden" name="assoc_id" value="<?=$assoc_id;?>"> </div>
                                <div class="form-group">
                                   
                                    <h5 style='font-size:15px;'> Associate ID :  <?php echo $assoc_id; ?> </h5> </div>
                                <div class="form-group">
                                    
                                     <h2 style='font-size:15px;'> Associate Name :  <?php echo $assoc_name; ?> </h2> </div>
									  <div class="form-group">
                                    
                                     <h2 style='font-size:15px;'> Date :  <?php echo $feeddate; ?> </h2> </div>
									 	  <div class="form-group">
                                    
                                     <h2 style='font-size:15px;'> Comments : <br/> <?php echo $comments; ?> </h2> </div>
                      		   <div class="form-group">
							   <br/>
							   <label>   Developer Name : </label>
							 
							 
                    <input style='font-size:15px;background-color:white;' class="form-control  w3-border  w3-hover-border-blue" id="developer" name="developer" value="<?=$developer;?>"placeholder="" required>
                </div>
				
				       <div class="form-group">
                                <br/>
                                <label><b>Change Status</b></label>
                                <select style='font-size:15px;background-color:white;width:50%' class="form-control w3-border select2 w3-hover-border-blue" id="status" oninput="this.className = ''" name='status' placeholder=" " required>
                                    <option value="" selected hidden>---- Select ----</option>
                                    <option value="In Progress">In Progress</option>
                                    <option value="Resolved">Resolved</option>

                                </select>


                            </div>
							
							
                                <button type="submit" name="save1" class="btn btn-default bg-olive">UPDATE</button>
                            </div>
                      
                    </form>
                </div>
            </div>
       <br/>
	   <br/>
                    <div class="card">
                        <div class="card-body" style="background: #fff;">
                            <div class="table-responsive">
                               
                                    <table id="example1"class="table table-bordered  table-hover table-condensed">
                                        <thead>
                                            <tr>
                                                
                                                <th>Associate Name</th>
                                                <th>Associate ID</th>
                                                <th>Date </th>
                                                <th>Comments</th>
												   <th>Status</th>
												<?php if($_SESSION['role']=='Super Admin'){ ?>    <th> Developer Assigned  </th> <?php } ?>
												<th>Edit</th>
                                            </tr>
                                        </thead>
                                        <tbody>	
																										<?php 
																										
$query="SELECT * FROM `suggestions` ";
$result = $link->query($query) or die("Error0 : ".mysqli_error($link));
while($arr=  mysqli_fetch_assoc($result)){ 
$slno=$arr['slno'];
    $associd=$arr['assoc_id'];
    $assoc_name=$arr['assoc_name'];
	 $date=$arr['feeddate'];
    $comments=$arr['comments'];
	   $developer=$arr['developer'];
	    $status=$arr['status'];
   
?>
                                                                                        <tr>
                                                                                            <td><?php echo $associd; ?></td>
                                                                                            <td>
                                                                                              <?php echo $assoc_name; ?>
                                                                                            </td>
                                                                                            <td>
                                                                                                <?php echo $date; ?>
                                                                                            </td>
                                                                                            <td><?php echo $comments; ?></td>
																							 <td> <?php 
																							 echo $status;
																							 ?>
																							 
																							 
																							 
																							 
																							 </td>
                                                                                    <?php if($_SESSION['role']=='Super Admin'){ ?>  <td> <?php   echo $developer; ?></td> <?php  }?> 
																					    <td>
                                       <button type="button" class='btn btn-sm bg-olive' onclick="location.href='Feedback_Edit.php?slno=<?php echo $slno; ?>&assoc_id=<?php echo $associd; ?>'">Edit</button>
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
    <?php include 'footer.php'; ?>