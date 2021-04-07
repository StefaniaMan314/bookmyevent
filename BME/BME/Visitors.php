<?php 
include 'header.php';
session_start();
$error=$_GET['status'];
$assoc_id=$_SESSION['associateId'];
$assoc_company=$_SESSION['company'];
$assoc_executive=$_SESSION['executive'];
 $today= date('Y-m-d');
$query="SELECT * FROM Dash_Visitors ORDER BY slno DESC LIMIT 200";
		$result=mysqli_query($link,$query) or die();
$arr=  mysqli_fetch_row($result);
?>
<div class="container-fluid">
    <br />
    <?php if($_SESSION['role']=='Super Admin'){ ?>
    <div class='row'>
        <div class='col-lg-12'>
            <div class='card'>
                <div class='card-header'>
                    <h5 style='color:#0D94D2'><strong>Visitors</strong></h5>
                </div>
                <div class='card-body'>
                    <div class="table-responsive">
                        <table id="example2" class="table table-bordered  table-hover table-condensed">
                            <thead>
                                <tr>
                                    <th style="font-weight:bold">Associate Name</th>
                                    <th style="font-weight:bold">Associate ID</th>
                                    <th style="font-weight:bold">Manager Name</th>
                                    <th style="font-weight:bold">Department</th>
                                    <th style="font-weight:bold">Executive</th>
                                    <th style="font-weight:bold">Date</th>
                                    <th style="font-weight:bold">Time</th>
                                    <th style="font-weight:bold">Role</th>
                                    <th style="font-weight:bold">Country</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($arr=mysqli_fetch_row($result)){
									$query1="SELECT Manager_Name,Department,Executive FROM `Head_Count`  WHERE Associate_Id='$arr[1]'";
		$result1=mysqli_query($link,$query1) or die();
$arr1=  mysqli_fetch_row($result1);
$manager_name=$arr1[0];
$department=$arr1[1];
$executive=$arr1[2];


									
									?>
                                <tr>
                                    <td>
                                        <?php echo $arr[2];?>
                                    </td>
                                    <td>
                                        <?php echo $arr[1];?>
                                    </td>
                                    <td>
                                        <?php echo $manager_name;?>
                                    </td>
                                    <td>
                                        <?php echo $department;?>
                                    </td>
                                    <td>
                                        <?php echo $executive;?>
                                    </td>
                                    <td>
                                        <?php echo $arr[3];?>
                                    </td>
                                    <td>
                                        <?php echo $arr[4];?>
                                    </td>
                                    <td>
                                        <?php echo $arr[5];?>
                                    </td>
                                    <td>
                                        <?php echo $arr[6];?>
                                    </td>
                                </tr>
                                <?php

}?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div><?php } ?>
</div>
<?php 
include 'footer.php';
?>
