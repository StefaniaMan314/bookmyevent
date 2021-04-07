<?php include 'header.php';
session_start();
$assoc_id=$_SESSION['associateId'];
$assoc_name=$_SESSION['fullname'];

?>
        <style rel="stylesheet">
        /* TEMPLATE STYLES */
        
        main {
            padding-top: 1rem;
            padding-bottom: 2rem;
        }
        
        .extra-margins {
            margin-top: 1rem;
            margin-bottom: 2.5rem;
        }
        
        .navbar {
            background-color: #0D94D2;
        }
        
        footer.page-footer {
            background-color: #0D94D2;
            margin-top: 2rem;
        }
        
        .btn-success {
            background-color: #81c44c;
        }
        
        .btn-info {
            background-color: #0d94d2;
        }
        
        @import url(//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css);
        fieldset {
            margin: 0;
            padding: 0;
        }
        /****** Style Star Rating Widget *****/
        
        .rating {
            border: none;
            float: left;
        }
        
        .rating > input {
            display: none;
        }
        
        .rating > label:before {
            margin: 5px;
            font-size: 3em;
            font-family: FontAwesome;
            display: inline-block;
            content: "\f005";
        }
        
        .rating > .half:before {
            content: "\f089";
            position: absolute;
        }
        
        .rating > label {
            color: #ddd;
            float: right;
        }
        /***** CSS Magic to Highlight Stars on Hover *****/
        
        .rating > input:checked ~ label,
        /* show gold star when clicked */
        
        .rating:not(:checked) > label:hover,
        /* hover current star */
        
        .rating:not(:checked) > label:hover ~ label {
            color: #ffae00;
        }
        /* hover previous stars in list */
        
        .rating > input:checked + label:hover,
        /* hover current star when changing rating */
        
        .rating > input:checked ~ label:hover,
        .rating > label:hover ~ input:checked ~ label,
        /* lighten current selection */
        
        .rating > input:checked ~ label:hover ~ label {
            color: #ffc300;
        }
    </style>
	
	
	 <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
				<div class="alert myBackground" style='background-color:white;'>
                        <div class='row'>
                            <div class='col-lg-8' >
                                <h3 style='color:#0D94D2;font-size:23px'>Feedback Page</h3> </div>
                        </div>
                    </div>
                    <div class='card'>
                        <div class='card-header'>
                          
                        <div class="card-body">
                            
							<h3> Thanks for your feedback! </h3>
                               <br/>
							   <br/>
									 <button name="submit" type="submit"  onclick="location.href='Suggestions.php'" class="btn btn-primary btn-raised btn-block btn-flat" style="width:10em;" id="submit_button">Submit another </button>
                               
                        </div>
                    </div>
                </div>
            </div>
        </div>
	<?php
		$connect = mysqli_connect("localhost", "root", "cernces6435", "BME1");	
		$query = "SELECT * FROM `suggestions` WHERE `assoc_id`='$assoc_id' ";
$result = mysqli_query($connect, $query);
$count = mysqli_num_rows($result);

	?>
<!--	<div class='col-lg-6' style='background-color:white;'>
	<div class="alert myBackground" style='background-color:white;'>
                        <div class='row'>
                           
                                <h3 style='color:#0D94D2;font-size:23px'>Your Suggestions : <b><?php echo $count; ?></b></h3> 
                        </div>
                    </div>
	<?php
	if(mysqli_num_rows($result) > 0)
{
 while($row = mysqli_fetch_assoc($result)) 
 { 
?>
	 
		
	 <h5> <br/>Feedback Date:</b> <?php echo $row['feeddate']; ?>
									 <br/>
									 Rating:</b> <?php echo $row['rating']; ?>
									 
								
									<br/>
									Comments:</b> <?php echo $row['comments']; ?> 
                            </h5>


		<?php 
 }
} else {?>
No records found 

<?php } ?>
</div> -->
	
	
	<?php include 'footer.php'; ?>