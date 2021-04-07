<?php include 'header.php';
session_start();
$error=$_GET['status'];
$assoc_id=$_SESSION['associateId'];


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
    <div id="page-wrapper">
        <div id="content-wrapper">
            <?php if(isset($error)) { ?>
                <div class="alert myBackground3" role="alert"> <strong style='color:#de4b39;font-size:15px'> <i class="icon fa fa-ban"></i> <?php echo $error; ?></strong>
                    <br/> <a class='btn btn-sm btn-success' href='index.php'>Return to HOME page</a></div>
                <?php } ?>
                    <div class="alert myBackground">
                      
                    </div>
                    <div class="card">
					  <div class='row'>
                            <div class='col-lg-12'>
                                <h3 style='color:#0D94D2;font-size:20px'> &nbsp; Pending Mailbox Requests</h3> </div>
                        </div>
                        <div class="card-body" style="background: #fff;">
                            <div class="table-responsive">
                               
                                    <table  class="table table-bordered  table-hover table-condensed" style='font-size:13px'>
                                        <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Associate Name</th>
                                                <th>Associate ID</th>
												<th>Organization</th>
												<th>Requested On</th>
                                                <th>Requested Mailbox</th>
												<th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>	
																										<?php 
																										
$query="SELECT * FROM `emailbox` WHERE status='0' AND `action_by` IS NULL";
$result = $link->query($query) or die("Error0 : ".mysqli_error($link));
while($arr=  mysqli_fetch_assoc($result)){ 
$slno=$arr['slno'];
    $associd=$arr['assoc_id'];
    $assoc_name=$arr['assoc_name'];
	  $mailbox=$arr['mail_address'];
	    $status=$arr['status'];
		$Organization=$arr['assoc_Org'];
		$requested_date=$arr['date'];
		
   //location.href='scripts/reject_access.php?slno=<?php echo $slno; ?>
                                                                                        <tr>
																						<td> <a class="btn btn-default bg-olive" onclick="location.href='scripts/approve_mailbox.php?slno=<?php echo $slno; ?>'" > Approve </a> &nbsp;<a class='btn btn-sm btn-danger' onclick="Selecttype();">Reject </a></td>
                                                                                            <td><?php echo $assoc_name; ?></td>
                                                                                            <td>
                                                                                              <?php echo $associd; ?>
                                                                                            </td>
																							<td>
                                                                                                <?php echo $Organization; ?>
                                                                                            </td>
																							<td>
                                                                                                <?php echo $requested_date; ?>
                                                                                            </td>
                                                                                            <td>
                                                                                                <?php echo $mailbox; ?>
                                                                                            </td>
                                                                                          
																							 <td style="color:#0D94D2"> 
																						Pending
																							 
																							 </td>
                                                                                   
																					    <td>
																						<?php 
																							 echo $justification;
																							 ?>
                                   
                                        </td>
                                                                                        </tr>

<?php } ?>                                                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
								<div  class ="card" id="DivCheck7" style="display:none;width:60%">
		 <div class="card-body">
		 <form role="form" method="post" action="scripts/reject_mailbox.php" onsubmit="return upperMe1()" enctype="multipart/form-data">
		 <div class="form-group">
 <input type="hidden" name="slno" id="slno" value="<?php echo $slno ?>" />
</div>	
		 <div class="form-group" >
							   
							   <label> <b>Justification : </b></label> <br/>
							 <br/>
							 
                    <input style="width:50%;height:100px"   name="Rejectjustification" required>
					
					<button  type="submit" class="btn btn-default bg-olive"  > Submit </button> 
					
                </div> </form></div></div>
						 <?php if($_SESSION['role']=='Super Admin'){ ?>
						  <div class="card">
						   <div class='row'>
                            <div class='col-lg-12'>
                                <h3 style='color:#0D94D2;font-size:20px'> &nbsp; Approved/Rejected   Requests</h3> </div>
                        </div>
                        <div class="card-body" style="background: #fff;">
                            <div class="table-responsive">
                               
                                    <table class="table table-bordered  table-hover table-condensed" style='font-size:13px'>
                                        <thead>
                                            <tr>
                                                
                                                <th>Associate Name</th>
                                                <th>Associate ID</th>
												 <th>Organization</th>
												 	
												  <th>Requested On</th>
                                            <th>Requested Mailbox</th>
												 <th>Action By </th>
												 
												   <th>Status</th>
												  <th>Rejection Justification</th>
												
											
                                            </tr>
                                        </thead>
                                        <tbody>	
																										<?php 
																										
$query="SELECT * FROM `emailbox` WHERE  action_by!='' AND action_by IS NOT NULL ";
$result = $link->query($query) or die("Error0 : ".mysqli_error($link));
while($arr=  mysqli_fetch_assoc($result)){ 
$slno=$arr['slno'];
    $associd=$arr['assoc_id'];
    $assoc_name=$arr['assoc_name'];
	
    $mailbox=$arr['mail_address'];
	    $status=$arr['status'];
		$Organization=$arr['assoc_Org'];
		$requested_date=$arr['date'];
		 $action_by=$arr['action_by'];
		  $reject_justification=$arr['reject_justification'];
		  if($reject_justification==''){
			  $reject_justification='Not Rejected';
			  
		  }
		
		 $event_date=$link->query("SELECT * FROM `Head_Count` WHERE  Associate_Id='$action_by'");
 $event_date1=mysqli_fetch_assoc($event_date);
 $Associate_Name=$event_date1['Associate_Name'];
   //location.href='RejectAccess.php?slno=<?php echo $slno; ?>
                                                                                        <tr>
																						
                                                                                            <td><?php echo $assoc_name; ?></td>
                                                                                            <td>
                                                                                              <?php echo $associd; ?>
                                                                                            </td>
																							<td>
                                                                                                <?php echo $Organization; ?>
                                                                                            </td>
																								
																																	<td>
                                                                                                <?php echo $requested_date; ?>
                                                                                            </td>
																							<td>
                                                                                                <?php echo $mailbox; ?>
                                                                                            </td>
                                                                                            
                                                                                          
																							   <td>
                                                                                                <?php echo $Associate_Name; ?>
                                                                                            </td>
																							 <td style="color:red"> 
																							 <?php if(($status=='0') && ($action_by=='')){ 
																						echo "Pending";
																							 } else if ($status=='1') {
																								 echo "Approved";
																							 }else{ echo "Rejected"; }																								 ?>
																							 
																							 </td>
                                                                                 <td><?php echo $reject_justification; ?></td>
																				
                                                                                        </tr>

<?php } ?>                                                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
						 
						 
						 
						 <?php } ?>
						 
						 
						 
						
                    </div>
        </div>

<script>
        function Selecttype() {
      
                    
					 document.getElementById("DivCheck7").style.display = "block";
                
			
			
        }
		
		</script>
    <?php include 'footer.php' ?>