<?php
 include 'header.php';
session_start();

$slno=$_GET['slno'];

$check3=$link->query("SELECT slno, `id`, `name`,role FROM Associate WHERE slno = '$slno'");
    $rows3=mysqli_fetch_row($check3);
	if($rows3[0]>=1)
    {
       $associd=$rows3[1];
	$assocname=$rows3[2];
$role=$rows3[3];
		   
    }



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
            <div class="card">
                <div class="card-header" style="background: #fff;">
                    <h3>Edit User</h3></div>
                <div class="card-body" style="background: #fff;">
                    <form role="form" method="post" action="scripts/update_user.php"  enctype="multipart/form-data">
                        
                            <div class="col-lg-4">
                                <label>
                                    <h4 class='card-title'><b>Associate Details</b></h4> </label>
									  <div class="form-group">
                                    
                                    <input type="hidden" name="ID" value="<?=$slno;?>"> </div>
                                <div class="form-group">
                                    <label><b>Associate ID (Example:SC036783)</b></label>
                                    <input style='font-size:15px;background-color:white;' class="form-control text-uppercase w3-border  w3-hover-border-blue" id="assoc_id" name="ud_associd" value="<?=$associd;?>" placeholder="" required> </div>
                                <div class="form-group">
                                    <label><b>Associate Name (Example:Cooper,Sheldon)</b></label>
                                    <input style='font-size:15px;background-color:white;' class="form-control w3-border  w3-hover-border-blue" id="assoc_id" name="ud_name" value="<?=$assocname;?>" placeholder="" required> </div>
                           		   <div class="form-group">
                    <label><b>Role</b></label>
                    <?php
                                $query = $link->query("SELECT DISTINCT(ename),slno FROM event  ORDER BY slno DESC");
                                $rowCount = $query->num_rows;
                                ?>
                    <select style='font-size:15px;background-color:white;' class="form-control w3-border select2 w3-hover-border-blue" name="eventname" id="assoc_id" required>
                        <option value="" selected hidden>Select Role</option>
						  <option value="Super Admin">Super Admin</option>
						    <option value="Administrator">Administrator</option>
							   <option value="Associate">Associate</option>
                        <?php
                                  if($rowCount > 0){
                                  while($row = $query->fetch_assoc()){

                                  echo '<option value="'.$row['ename'].'">'.$row['ename'].'</option>';
                                  }
                                }else{
                                  echo '<option value="">event not available</option>';
                                  }
                              ?>
                    </select>
                </div>
                                <button type="submit" name="save1" class="btn btn-default bg-olive">UPDATE USER</button>
                            </div>
                      
                    </form>
                </div>
            </div>
        </div>
    </div> 
	
	<div>
	<div id="page-wrapper">
            <div class="container-fluid">
		   <div class="card-table" style="background: #fff;">
                    <br/>
                    <br/>
                    
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered  table-hover table-condensed" style="text-align:center">
                            <thead style="text-align:center">
                                <tr>
								 <th style="text-align:center">Edit</th>
                                    <th style="text-align:center">Delete</th>
									<th style="text-align:center">Associate ID</th>
                                    <th style="text-align:center">Associate Name</th>
                                    <th style="text-align:center">Role</th>
                                </tr>
                            </thead>
                            <tbody style="text-align:center">
                               <?php 

$query2="SELECT * FROM `Associate` ORDER BY name";
$result2 = $link->query($query2) or die("Error0 : ".mysqli_error($link));
while($arr2=  mysqli_fetch_row($result2)){
                              ?> 
							  
                                    <tr> 
                                        <td>
                                            <a class="btn btn-app" style="width:80px;height:25px" onclick="alertify.confirm('Please Confirm', 'You are trying to edit the Associate <?php echo $arr2[2];?>.', function(){ window.location='Edit_Host.php?slno=<?php echo $arr2[0]; ?>'}
                , function(){ });">
                <i class="fa fa-edit"></i>
              </a>
                                        </td>
                                        
                                           <td style="text-align:center"><a class='btn btn-sm btn-danger' onclick="alertify.confirm('Please Confirm', 'You are trying to delete the Associate <?php echo $arr2[2];?>.', function(){ window.location='scripts/deleteuser.php?slno=<?php echo $arr2[0]; ?>&assoc_id=<?php echo $arr2[1]; ?>'}
                , function(){ });">DELETE</a></td>
                                        
										
                                        <td>
                                            <?php echo $arr2[1];?>
                                        </td>
										 
                                        <td>
                                            <?php echo $arr2[2];?>
                                        </td>
                                        <td>
                                            <?php echo $arr2[3];?>
                                        </td>
										  
                                    </tr>
							  <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>
				</div>
        </div>
	</div>
	<?php include 'footer.php'; ?>