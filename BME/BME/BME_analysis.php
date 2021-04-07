<?php 
include 'header.php';
session_start();
$error=$_GET['status'];
$assoc_id=$_SESSION['associateId'];
$assoc_company=$_SESSION['company'];
$assoc_executive=$_SESSION['executive'];

?>
<div class="container-fluid">
    <br />
    <div class='row'>
        <div class="col-lg-12"><iframe frameborder="0" scrolling="no" src="BME_analysis_graph.php" style="width:100%;height:400px"></iframe></div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 style='color:#0D94D2;font-size:20px'> &nbsp; All Events</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">

                        <table id="example2" class="table table-bordered  table-hover table-condensed" style='font-size:13px'>
                            <thead>
                                <tr>

                                    <th>Slno</th>
                                    <th> <b>Event Name </b></th>
                                    <th>Event Date</th>
                                    <th>Registrations Count</th>



                                </tr>
                            </thead>
                            <tbody>
                                <?php 
																$i=0;										
																										
$query="SELECT * FROM bme_analysis1   ORDER BY slno DESC ";
$result = $link->query($query) or die("Error0 : ".mysqli_error($link));
while($arr=  mysqli_fetch_assoc($result)){ 

$slno=$arr['slno'];
    $date=$arr['date'];
    $month=$arr['month'];
	 $ename=$arr['ename'];
    $registrations=$arr['registrations']; 
	$i++;
	   ?>
                                <tr>

                                    <td><?php echo $i; ?></td>
                                    <td>
                                        <?php echo $ename; ?>
                                    </td>
                                    <td>
                                        <?php echo $date; ?> - <?php echo $month; ?>
                                    </td>
                                    <td>
                                        <?php 
																							 echo $registrations;
																							 ?>

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
<?php include "footer.php" ?>
