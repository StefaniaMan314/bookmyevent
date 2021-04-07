<?php include 'header.php';
session_start();
$assoc_id=$_SESSION['associateId'];
 $today= date('Y-m-d');
 
 $event_id=$_GET['slno'];


$check3=$link->query("SELECT * FROM event WHERE slno = '$event_id'");
    $rows4=mysqli_fetch_row($check3);
	
		$event_name=$rows4[1];
		$event_date=$rows4[3];
	
	
	
$check3=$link->query("SELECT count(*) FROM timeslot WHERE eslno = '$event_id'");
    $rows3=mysqli_fetch_row($check3);
	$timeslot_count=$rows3[0];
    
$check4=$link->query("SELECT count(*) FROM testevent WHERE event = '$event_id' ");
    $rows5=mysqli_fetch_row($check4);
	
		$registered_count=$rows5[0];

		
	
?>
  <div class="container-fluid">
            <div class="card">
                <div class="card-header" style="background: #fff;">
                    <h3> <b> Delete  Event </b>  </h3>
										
						 <div class='row'>
						   <br/>
						 
     <div class="col-lg-12">						
	<label style="color:red"> Note:  Mail will be sent to all the Registered asociates (If Deleted)
                     </label>
                   </div>   
                 
                </div>
					</div>
                <div class="card-body" style="background: #fff;">
                    <form role="form" method="post" action="scripts/delete_event.php?slno=<?php echo $event_id?>" onsubmit="return upperMe1()" enctype="multipart/form-data">
                        <div class='row'>
						
							   <br/>
							    <br/>
                            <div class="col-lg-2">
							
						
                        <p> <b> Event Name  &nbsp; </b> </p> </div>
                               <div class="col-lg-10">
									  
									   <p>  :&nbsp; <?php echo $event_name ?> </p>
									  
									  </div>
									  
									    </div> 
										
										     <div class='row'>
						
							
                            <div class="col-lg-2">
							
						
                        <p> <b> Event Date  &nbsp; </b> </p> </div>
                               <div class="col-lg-3">
									  
									   <p>  :&nbsp; <?php echo $event_date ?> </p>
									  
									  </div>
									  
									    </div> 
										     <div class='row'>
						
							
                            <div class="col-lg-2">
							
						
                        <p> <b> Number of Timeslots  </b> </p> </div>
                               <div class="col-lg-10">
									  
									   <p>  :&nbsp; <?php echo $timeslot_count ?> </p>
									  
									  </div>
									  
									    </div> 
										
										
							<div class='row'>
						
							  <br/>
                            <div class="col-lg-2">
							
						
                        <p style="color:red"> <b > Registered Associates    </b> </p> </div>
                               <div class="col-lg-1">
									  
									   <p style="color:red">  :&nbsp; <?php echo $registered_count ?> </p>
									  
									  </div>
									  
									    </div> 
							   
								 
								
                              <br/>
							   	    
				
							 &nbsp;  <button type="submit" name="save2" class="btn btn-default bg-olive">Submit</button>
                           
                    
                    </form>
					  </div>
                </div>
           
        </div>
    
    <?php include 'footer.php'; ?>