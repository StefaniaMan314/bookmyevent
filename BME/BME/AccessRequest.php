<?php include 'header.php';
include 'DB.php';
session_start();
$assoc_id=$_SESSION['associateId'];
$assoc_name=$_SESSION['fullname'];
$Organization=$_SESSION['company'];

 $today= date('Y-m-d');
 
	  $result1=$link->query("SELECT  count(*)  FROM `Associate` WHERE `id`='$assoc_id' AND role='Administrator' ");
		  $rows1=mysqli_fetch_row($result1);
if((intval($rows1[0])==0) ||  ($_SESSION['role']=='Super Admin')){
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

    }

</style>
<div id="container-fluid">
    <br />
    <div class="card">
        <div class="card-header">
            <h3 style="color:#0D94D2"> <b>Request Access for Creating Event</b></h3>
        </div>
        <div class="card-body" style="background: #fff;">

            <div class="row">
                <div class="col-lg-5">
                    <form role="form" method="post" action="scripts/requestAccessMail.php" onsubmit="return upperMe1()" enctype="multipart/form-data">

                        <div class="form-group">

                            <label> Associate ID : <?php echo $assoc_id; ?> </label> </div>
                        <div class="form-group">

                            <label> Associate Name : <?php echo $assoc_name; ?> </label> </div>

                        <div class="form-group" id="divaccess">

                            <select style='font-size:20px;width:70%' class="form-control w3-border select2 w3-hover-border-blue" oninput="this.className = ''" name='access' onchange="Selecttype(this);" placeholder=" " required>
                                <option value="yes">---- Permanent Access ----</option>
                                <option id="yes" value="1">Yes</option>
                                <option id="no" value="0">No</option>

                            </select>


                        </div>



                        <div class="form-group" id="DivCheck7" style="display:none;">
                            <label> Select dates for Access : </label> <br />
                            <br />
                            <input name="fromdate" id="datepicker" placeholder="From Date" /> &nbsp; to &nbsp;
                            <input name="todate" id="datepicker1" placeholder="To Date" />
                        </div>

                        <div class="form-group">
                            <br />
                            <label>How many events are you planning to host in next 12 months? </label>
                            <input style='background-color:white' class="form-control w3-border  w3-hover-border-blue" name="eventscount" placeholder=" " required>
                        </div>

                        <div class="form-group">

                            <label> Justification: </label>


                            <input style="width:100%;height:70px" name="justification" required>

                        </div>
                        <button type="submit" name="save1" class="btn btn-default bg-olive"> REQUEST ACCESS</button>


                    </form>
                </div>
                <div class="col-lg-5">
                    <img src="accessRequestflow.PNG" width="100%" height="500px" />
                </div>

            </div>
        </div>

    </div>
    <br />
    <div class="card">
        <div class='row'>
            <div class='col-lg-12'>
                <h3 style='color:#0D94D2;font-size:20px'> &nbsp; My Access Requests</h3>
            </div>
        </div>
        <div class="card-body" style="background: #fff;">
            <div class="table-responsive">

                <table class="table table-bordered  table-hover table-condensed" style='font-size:13px'>
                    <thead>
                        <tr>

                            <th>Associate Name</th>
                            <th>Associate ID</th>
                            <th>Organization</th>
                            <th>Justification</th>
                            <th>Requested On</th>
                            <th>From Date </th>
                            <th>To Date</th>

                            <th>Status</th>
                            <th>Rejection Justification</th>



                        </tr>
                    </thead>
                    <tbody>
                        <?php 
																										
$query="SELECT * FROM `bme_access` WHERE assoc_id='$assoc_id' ";
$result = $link->query($query) or die("Error0 : ".mysqli_error($link));
while($arr=  mysqli_fetch_assoc($result)){ 
$slno=$arr['slno'];
    $associd=$arr['assoc_id'];
    $assoc_name=$arr['assoc_name'];
	 $from_date=$arr['from_date'];
    $to_date=$arr['to_date'];
	   $justification=$arr['justification'];
	    $status=$arr['status'];
		$Organization=$arr['Organization'];
		$requested_date=$arr['Requested_On'];
		 $action_by=$arr['action_by'];
		 $reject_justification=$arr['reject_justification'];

   //location.href='RejectAccess.php?slno=<?php echo $slno; ?>
                        <tr>

                            <td><?php echo $assoc_name; ?></td>
                            <td>
                                <?php echo $assoc_id; ?>
                            </td>
                            <td>
                                <?php echo $Organization; ?>
                            </td>
                            <td>
                                <?php 
																							 echo $justification;
																							 ?>

                            </td>
                            <td>
                                <?php echo $requested_date; ?>
                            </td>
                            <td>
                                <?php echo $from_date; ?>
                            </td>
                            <td><?php echo $to_date; ?></td>

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
</div>




<script>
    function Selecttype(Accesstype) {
        if (Accesstype) {
            admOptionValue = document.getElementById("no").value;
            if (admOptionValue == Accesstype.value) {

                document.getElementById("DivCheck7").style.display = "block";
            } else {
                document.getElementById("DivCheck7").style.display = "none";


            }
        } else {
            document.getElementById("DivCheck7").style.display = "none";

        }


    }

</script>
<?php } ?>
<?php  include 'footer.php'; ?>
