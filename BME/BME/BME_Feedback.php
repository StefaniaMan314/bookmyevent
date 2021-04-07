<?php include 'header.php';
session_start();
$error=$_GET['status'];
$assoc_id=$_SESSION['associateId'];


$query3=("SELECT * FROM `event` where  slno='$event_id' ");
		$result1=mysqli_query($link,$query3) or die();
$arr3=  mysqli_fetch_row($result1);
$creator_id=$arr3[5];
$event_name=$arr3[1];

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
                        <div class='row'>
                            <div class='col-lg-12'>
                                <h3 style='color:#0D94D2;font-size:23px'>BME  Suggestions</h3> </div>
                        </div>
                    </div>
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
												    <th> Developer Assigned  </th>
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
                                                                                     <td> <?php   echo $developer; ?></td> 
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

    <?php include 'footer.php' ?>