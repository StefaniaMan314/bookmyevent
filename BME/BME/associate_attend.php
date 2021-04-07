<?php include 'header2.php';
include 'DB.php';

session_start();
$error=$_GET['status'];
$tim=22;
 $scanner_id=$_SESSION['associateId'];
$assoc_id=$_GET['assoc_id'];
$uid=$_GET['uid'];


$check1=$link->query("select event from `testevent` where AssociateID='$assoc_id' AND  CONCAT(`prefix`,`slno`)='$uid'");
 $rows1=mysqli_fetch_row($check1);
$event_id=$rows1[0];

$check1=$link->query("select * from `eventhost` where AssociateId='$scanner_id' AND  event_id='$event_id'");
 $rows1=mysqli_fetch_row($check1);

if($rows1[0]>0){

$check1=$link->query("select COUNT(`slno`) from `testevent` where AssociateID='$assoc_id' AND event='$event_id' AND attend=1");
 $rows1=mysqli_fetch_row($check1);
if(intval($rows1[0])>=1){
 echo "<script>window.location='landing_attend.php?assoc_id=$assoc_id'</script>";
}
$check2=$link->query("select COUNT(`slno`) from `testevent` where AssociateID='$assoc_id' AND event='$event_id' ");
 $rows1=mysqli_fetch_row($check2);
if(intval($rows1[0])<=0){
 echo "<script>window.location='landing_attend1.php?assoc_id=$assoc_id&event_id=$event_id'</script>";
}

 $check1=$link->query("select AssociateName from `testevent` where AssociateID='$assoc_id'");
 $rows1=mysqli_fetch_row($check1);
$assoc_name=$rows1[0];

$check1=$link->query("select AssociateName, attend from `testevent` where AssociateID='$assoc_id' AND  CONCAT(`prefix`,`slno`)='$uid' AND booked='0'");
 $rows1=mysqli_fetch_row($check1);
$attend=$rows1[1];
if($check1)
	   {
		  
	
	   $update_result1=$link->query("UPDATE `testevent` SET `attend`='1' ,`attend_check`='$scanner_id' WHERE AssociateID='$assoc_id' AND  CONCAT(`prefix`,`slno`)='$uid' ");
	    if($update_result1)
	   {



?>
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
 </head>
 <body>
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="box-body">
                <center>
                    <h1 style='font-size:100px'><span class="fa-stack fa-lg w3-animate-zoom ">
  <i class="fa fa-circle fa-stack-2x" style='color:#29b7a5'></i>
  <i class="fa fa-check fa-stack-1x fa-inverse"></i>
</span></h1>
                    <h3 style='color:#0D94D2'>Thank you, For attending the event  <?php echo $assoc_name; ?>. </h3> 
					
<br/>
<br/>
<a class='btn btn-md btn-success' href='Index.php'>HOME</a> <a class='btn btn-md btn-warning' href='../logout.php'>EXIT</a></center>
					
            </div>
        </div>
    </div>
	 </body>
</html>
<?php } } }
else {
	
	?>
	  <div id="page-wrapper">
        <div class="container-fluid">
            <div class="box-body">
                <center>
                    <h1 style='font-size:100px'><span class="fa-stack fa-lg w3-animate-zoom ">
  <i class="fa fa-circle fa-stack-2x" style='color:#29b7a5'></i>
  <i class="fa fa-check fa-stack-1x fa-inverse"></i>
</span></h1>
                    <h3 style='color:#0D94D2'>Dear Associate, </h3>
					<br/>
					<h4> Please ask the Event Host to scan the QR code. </h4>
					
<br/>
<br/>
					
            </div>
        </div>
    </div>
	 
	<?php 
	
}?>

    