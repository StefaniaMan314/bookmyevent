<?php include 'header.php';
session_start();
 $today= date('Y-m-d');
$assoc_id=$_SESSION['associateId'];
$assoc_name=$_SESSION['fullname'];
$manager=$_SESSION['manager'];
$role=$_SESSION['role'];
if (@$_SESSION['thumbnailphoto'] != "") {
    $userimage = "data:image/jpeg;base64," . base64_encode($_SESSION['thumbnailphoto']);
} else {
    $userimage = "img/Collaborator Male_50px.png";
}

$query1=("SELECT * FROM `event` where   edate < '$today' ORDER BY edate DESC");
		$result1=mysqli_query($link,$query1) or die();
$arr1=  mysqli_fetch_row($result1);

	$connect = mysqli_connect("localhost", "root", "cernces6435", "BME1");	
		$query = "SELECT * FROM `event` WHERE `creator`='$assoc_id' ";
$result = mysqli_query($connect, $query);
$count = mysqli_num_rows($result);

$query2 = "SELECT * FROM `testevent` WHERE `AssociateID`='$assoc_id' ";
$result2 = mysqli_query($connect, $query2);
$count1 = mysqli_num_rows($result2);

$query3 = "SELECT * FROM `Dash_Visitors` WHERE `Asso_ID`='$assoc_id' ";
$result3 = mysqli_query($connect, $query3);
$count3 = mysqli_num_rows($result3);

$query4 = "SELECT * FROM `cancel1` WHERE `assoc_name`='$assoc_id' ";
$result4 = mysqli_query($connect, $query4);
$count4 = mysqli_num_rows($result4);

 if($_SESSION['role']=='Super Admin')  { 
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

table{
	font-size:13px;
}

.box {
    position: relative;
    border-radius: 1px;
    background: white;
    border-top: 0px solid white;
    margin-bottom: 20px;
    width: 100%;
}
	

     ::-webkit-scrollbar {
                width: 5px;
            }
            /* Track */
           
            ::-webkit-scrollbar-track {
                background: #ffffff;
            }
            /* Handle */
           
            ::-webkit-scrollbar-thumb {
                background: #888;
            }
            /* Handle on hover */
           
            ::-webkit-scrollbar-thumb:hover {
                background: #555;
            }
           


</style>
  
 <div class="row">
 <div class="col-lg-6">
       
          <div class="card card-widget widget-user-2">
          
            <div class="widget-user-header bg-aqua-active">
              <div class="widget-user-image">
                <img class="img-circle" src="<?php echo $userimage; ?>" alt="User Avatar">
              </div>
          
              <h3 class="widget-user-username"><?php echo $assoc_name; ?></h3>
              <h5 class="widget-user-desc"><?php echo $role;  ?></h5>
			
            </div>
            <div class="card-footer no-padding">
              <ul class="nav nav-stacked" style='padding-left:1px;font-size:12px'>
			   <!--<li><a> <b>Visits </b> <span class="pull-right badge bg-green"><?php echo $count3; ?></span></a>
			   </li>-->
                <li><a><b> Events Created </b><span class="pull-right badge bg-blue"><?php echo $count; ?></span></a></li>
                <li><a><b> Events Registered </b> <span class="pull-right badge bg-aqua"><?php echo $count1; ?></span></a></li>
         
                 <li><a><b> Registrations Cancelled </b><span class="pull-right badge bg-red"><?php echo $count4; ?></span></a></li>
              </ul>
            </div>
          </div>
       
        </div>
		<div class="col-lg-6">
		<div class="row">
		
					<div class="col-lg-3" >
		<br/>
		<br/>
		 <a href="Add_Event.php" style="background: #fff;height:50px">
		
               <center> <button class="w3-button w3-circle w3-teal" style="height:50px;width:50px">+</button> <h3 style="color:black">Add Event </h3> </center>
              </a>
			 
			  </div>

		</div>
		</div>
		</div>
 
                 
				 <div class="row">
				  <div class="card">
					<div class="col-lg-6" >
					<div class='card'>
					<div class="card-body " >
				
                    <h3 style='color:#0D94D2;font-size:23px'>
        Upcoming  Events    </b>
                    </h3>
				
 
							
							
 <div class="divscroll" style='height:400px'>
<br/>							<table  class="table table-bordered  table-hover table-condensed">
									<thead>
									<th> Event Name  </th>
									<th> Event Date   </th>
									<th> Location  </th>
									<th> Edit  </th>
									<th> Delete  </th>
										
									</thead>
									<tbody>
									
                                 
                                    
                        
							<?php 
		$event_date=$link->query("SELECT * FROM `event` WHERE  edate>= '$today' ORDER BY slno DESC  ");
while($create_count=mysqli_fetch_assoc($event_date)){
	$event_id=$create_count['slno'];
$event_name=$create_count['ename'];
$edate=$create_count['edate'];
$location=$create_count['Location'];



					?>
					
					 
                            <td>   <?php echo $event_name ?> </td>
                                       
                                       
                                   <td>  <?php echo $edate ?> </td>
                                     
                                  <td> <?php echo $location ?>  </td>
									
                                   
					
								
          
		
									
									<td>
								
									<a class='btn btn-default bg-olive' onclick="alertify.confirm('Please Confirm', 'You are trying to Edit the Event <b><?php echo $event_name;?></b>.', function(){ window.location='Edit_Event.php?slno=<?php echo $event_id; ?>'}
                , function(){ });">Edit</a> </td>
		<td> <?php if($edate<=$today) {?>
		
		Event delete Disabled 
		<?php } else { ?>
				  <a class='btn btn-sm btn-danger' onclick="alertify.confirm('Please Confirm', 'You are trying to delete the event <?php echo $event_name;?>.', function(){ window.location='Event_Delete.php?slno=<?php echo $event_id; ?>'}
                , function(){ });">DELETE</a> 
				
		<?php } ?>
									</td>

				</tbody>
									
							 <?php } ?>
							
                       
									
									</table>
						 
                   </div>
					
                
            </div></div>
			</div>
			
			
					<div class="col-lg-6" >
					<div class='card'>
					<div class="card-body " >
				
				
                    <h3 style='color:#0D94D2;font-size:23px'>
        Past  Events    </b>
                    </h3>
				
 
							
							
  <div class="divscroll" style='height:400px'>
<br/>							<table  class="table table-bordered  table-hover table-condensed">
									<thead>
									<th> Event Name  </th>
									<th> Event Date   </th>
									
									<th> Action  </th>
										
									</thead>
									<tbody>
									
                                 
                                    
                        
							<?php 
		$event_date=$link->query("SELECT * FROM `event` WHERE  edate< '$today' ORDER BY slno DESC  ");
while($create_count=mysqli_fetch_assoc($event_date)){
	$event_id=$create_count['slno'];
$event_name=$create_count['ename'];
$edate=$create_count['edate'];
$location=$create_count['Location'];



					?>
					<tbody>
					 
                            <td>   <?php echo $event_name ?> </td>
                                       
                                       
                                   <td>  <?php echo $edate ?> </td>
                                     
   
									<td>
								
									<button type="button" class='btn btn-default bg-olive' onclick="location.href='AnalysisTabs.php?id=<?php echo $event_id; ?>'">View</button>
									
									
							
									</td>

				</tbody>
									
							 <?php } ?>
							
                       
									
									</table>
						 
                   </div>
					
                
            </div>
			</div>
					</div>
					</div>
						</div>
					
						

<br/>
 <?php } ?>
       <?php include 'footer.php' ?>
			