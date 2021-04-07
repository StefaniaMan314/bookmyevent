
<?php
include "DB.php";

$slno = $_GET['slno'];
$assoc_id = $_GET['assoc_id'];
$event_id=$_GET['event_id'];
   
   
    $check1=$link->query("SELECT count(*) FROM `testevent` WHERE slno='$slno' AND AssociateID='$assoc_id'");
    $rows1=mysqli_fetch_row($check1);
    //echo $rows1[0];
	
	if($rows1[0]>0)
    {
$query1=("SELECT * FROM `testevent` where  AssociateID='$assoc_id' AND event='$event_id' ");
		$result1=mysqli_query($link,$query1) or die();
$arr1=  mysqli_fetch_row($result1);
$assoc_name=$arr1[3];
	}

    ?>
   
   <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
            <!-- Font Awesome -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
            <!-- Ionicons -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
            <!-- Theme style -->
            <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
			 <script src="https://code.highcharts.com/highcharts-3d.js"></script>
            <!-- Daterange picker -->
            <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
            <!-- bootstrap wysihtml5 - text editor -->
            <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
            <link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">
            <!-- JavaScript -->
            <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.0/build/alertify.min.js"></script>
            <!-- CSS -->
            <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.0/build/css/alertify.min.css" />
            <!-- Default theme -->
            <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.0/build/css/themes/default.min.css" />
            <!-- Semantic UI theme -->
            <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.0/build/css/themes/semantic.min.css" />
            <!-- Bootstrap theme -->
            <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.0/build/css/themes/bootstrap.min.css" />
            <link rel="stylesheet" href="w3.css">
            <link rel="stylesheet" href="plugins/select2/select2.min.css">
            <script src="tableToExcel.js"></script>
				            
			<div style="text-align:center"> 
			
			<button type="button" class='btn btn-sm btn-danger' onclick="location.href='unregister.php?slno=<?php echo $slno; ?>&assoc_id=<?php echo $assoc_id; ?>&event_id=<?php echo $event_id; ?>'">UNREGISTER</button>
			
				
				
				
				

 