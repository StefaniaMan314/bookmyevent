<?php include 'header.php';
session_start();
$assoc_id=$_SESSION['associateId'];
$assoc_name=$_SESSION['fullname'];
$today= date('Y-m-d');
 
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
                <h3>Add Mailbox</h3>
            </div>
            <div class="card-body" style="background: #fff;">
                <div class="row">
                    <div class="col-lg-5">
                        <form role="form" method="post" action="scripts/requestMailbox.php" onsubmit="return upperMe1()" enctype="multipart/form-data">



                            <div class="form-group">

                                <h5 style='font-size:15px;'> Associate ID : <?php echo $assoc_id; ?> </h5>
                            </div>
                            <div class="form-group">

                                <h2 style='font-size:15px;'> Associate Name : <?php echo $assoc_name; ?> </h2>
                            </div>
                            <div class="form-group">

                                <h2 style='font-size:15px;'> Date : <?php echo $today; ?> </h2>
                            </div>
                            <div class="form-group">
                                <br />
                                <label> Mail Address : </label>
                                <h5 style="color:#0D94D2">Note: Make sure there are no spaces before / throughout the mail address you enter. </h5>

                                <input style='font-size:15px;background-color:white;' type="email" class="form-control  w3-border  w3-hover-border-blue" id="mailbox" name="mailbox" placeholder="" required>
                            </div>
                            <button type="submit" name="save1" class="btn btn-default bg-olive">REQUEST MAILBOX</button>


                        </form>
                    </div>
                    <div class="col-lg-5">
                        <img src="accessMailboxflow.PNG" width="100%" height="500px" />
                    </div>
                    <div class="col-lg-2">
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

<div id="page-wrapper">
    <div id="content-wrapper">
        <br />
        <div class="card" style="background: #fff;">
            <div class='row'>
                <div class='col-lg-12'>
                    <h3 style='color:#0D94D2;font-size:20px'> &nbsp; My Mailbox Requests</h3>
                </div>
            </div>
            <div class="card-body" style="background: #fff;">

                <div class="table-responsive">
                    <table class="table table-bordered  table-hover table-condensed" style="text-align:center">
                        <thead style="text-align:center">
                            <tr>


                                <th style="text-align:center">Associate ID</th>
                                <th style="text-align:center">Associate Name</th>
                                <th style="text-align:center">Requested Date</th>
                                <th style="text-align:center">Mailbox</th>
                                <th style="text-align:center">Status</th>
                            </tr>
                        </thead>
                        <tbody style="text-align:center">
                            <?php 

$query2="SELECT * FROM `emailbox` WHERE assoc_id='$assoc_id' ORDER BY slno ASC ";
$result2 = $link->query($query2) or die("Error0 : ".mysqli_error($link));
while($arr2=  mysqli_fetch_row($result2)){
	$creator_id=$arr2[1];
	$status=$arr2[6];
	$action_by=$arr2[7];
                              ?>

                            <tr>





                                <td>
                                    <?php echo $arr2[1];?>
                                </td>

                                <td>
                                    <?php echo $arr2[2];?>
                                </td>
                                <td>
                                    <?php echo $arr2[3];?>
                                </td>
                                <td>
                                    <?php echo $arr2[4];?>
                                </td>

                                <td style="color:red">
                                    <?php if(($status=='0') && ($action_by=='')){ 
																						echo "Pending";
																							 } else if ($status=='1') {
																								 echo "Approved";
																							 }else{ echo "Rejected"; }																								 ?>

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
