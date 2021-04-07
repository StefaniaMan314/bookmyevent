<?php
 include 'header.php';
session_start();
$assoc_id=$_SESSION['associateId'];
$slno=$_GET['slno'];
$check3=$link->query("SELECT * FROM eventhost WHERE slno = '$slno'");
$rows3=mysqli_fetch_assoc($check3);
$associd=$rows3['AssociateId'];
$assocname=$rows3['name'];
$event_id=$rows3['event_id'];
$event_name=$rows3['event_name'];


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
                <h3>Add Event Host</h3>
            </div>
            <div class="card-body" style="background: #fff;">
                <form role="form" method="post" action="scripts/update_host.php" onsubmit="return upperMe1()" enctype="multipart/form-data">

                    <div class="col-lg-4">
                        <label>
                            <h4 class='card-title'><b>Associate Details</b></h4>
                        </label>
                        <div class="form-group">

                            <input type="hidden" name="ID" value="<?=$slno;?>"> </div>
                        <div class="form-group">
                            <label><b>Associate ID (Example:SC036783)</b></label>
                            <input style='font-size:15px;background-color:white;' class="form-control text-uppercase w3-border  w3-hover-border-blue" id="assoc_id" name="assoc_id" placeholder="" value="<?=$associd;?>" required> </div>
                        <div class="form-group">
                            <label><b>Associate Name (Example:Cooper,Sheldon)</b></label>
                            <input style='font-size:15px;background-color:white;' class="form-control w3-border  w3-hover-border-blue" id="assoc_id" name="assoc_name" placeholder="" value="<?=$assocname;?>" required> </div>

                        <div class="form-group">
                            <label><b>Event Name</b></label>
                            <?php
                                $query = $link->query("SELECT DISTINCT(ename),slno FROM event WHERE creator='$assoc_id' ORDER BY slno DESC");
                                $rowCount = $query->num_rows;
                                ?>
                            <select style='font-size:15px;background-color:white;' class="form-control w3-border select2 w3-hover-border-blue" name="eventname" id="assoc_id" required>
                                <option value="" selected hidden>Select Event</option>
                                <?php
                                  if($rowCount > 0){
                                  while($row = $query->fetch_assoc()){

                                  echo '<option value="'.$row['slno'].'">'.$row['ename'].'</option>';
                                  }
                                }else{
                                  echo '<option value="">event not available</option>';
                                  }
                              ?>
                            </select>
                        </div>

                        <button type="submit" name="save1" class="btn btn-default bg-olive">Update User</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<div>
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="card" style="background: #fff;">
                <br />
                <br />

                <div class="table-responsive">
                    <table id="example1" class="table table-bordered  table-hover table-condensed" style="text-align:center">
                        <thead style="text-align:center">
                            <tr>
                                <th style="text-align:center">Edit</th>
                                <th style="text-align:center">Delete</th>
                                <th style="text-align:center">Associate ID</th>
                                <th style="text-align:center">Associate Name</th>
                                <th style="text-align:center">Event Name</th>
                            </tr>
                        </thead>
                        <tbody style="text-align:center">
                            <?php 

$query2="SELECT * FROM `eventhost` ORDER BY name";
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

                                <td style="text-align:center"><a class='btn btn-sm btn-danger' onclick="alertify.confirm('Please Confirm', 'You are trying to delete the Associate <?php echo $arr2[2];?>.', function(){ window.location='scripts/deletehost.php?slno=<?php echo $arr2[0]; ?>&assoc_id=<?php echo $arr2[1]; ?>'}
                , function(){ });">DELETE</a></td>


                                <td>
                                    <?php echo $arr2[1];?>
                                </td>

                                <td>
                                    <?php echo $arr2[2];?>
                                </td>
                                <td>
                                    <?php echo $arr2[4];?>
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
