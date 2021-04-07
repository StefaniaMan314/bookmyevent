<?php include 'header.php';
session_start();
$assoc_id=$_SESSION['associateId'];
$assoc_name=$_SESSION['fullname'];

?>
<link rel="stylesheet" href="dist/css/adminlte.min.css">
<style rel="stylesheet">
        /* TEMPLATE STYLES */
        
 
        
        .extra-margins {
            margin-top: 1rem;
            margin-bottom: 2.5rem;
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
	<div class="container-fluid">
    <br />
    <div class="row">
        <div class="col-lg-8">
            <div class="alert myBackground" style='background-color:white;'>
                <div class='row'>
                    <div class='col-lg-8'>
                        <h3 style='color:#0D94D2;font-size:23px'> Suggestions for BookMyEvent</h3>
                    </div>
                </div>
            </div>
            <div class='card'>
                <div class='card-header'>

                    <div class="card-body">


                        <form action="scripts/feedbck.php" method="post" class='w3-container'>


                            <div class='row'>

                                <div class="form-group">
                                    <label>1. Rate your experience with BookMyEvent </label>
                                    <br />
                                    <fieldset class="rating" name="rating" required>
                                        <input type="radio" id="star5" name="rating" value="5" />
                                        <label class="full" for="star5" title="Awesome"></label>
                                        <input type="radio" id="star4half" name="rating" value="4.5" />
                                        <label class="half" for="star4half" title="Extremely Satisfied"></label>
                                        <input type="radio" id="star4" name="rating" value="4" />
                                        <label class="full" for="star4" title="Very Satisfied"></label>
                                        <input type="radio" id="star3half" name="rating" value="3.5" />
                                        <label class="half" for="star3half" title="Very Satisfied"></label>
                                        <input type="radio" id="star3" name="rating" value="3" />
                                        <label class="full" for="star3" title="Somewhat Satisfied"></label>
                                        <input type="radio" id="star2half" name="rating" value="2.5" />
                                        <label class="half" for="star2half" title="Somewhat Satisfied"></label>
                                        <input type="radio" id="star2" name="rating" value="2" />
                                        <label class="full" for="star2" title="Not Very Satisfied"></label>
                                        <input type="radio" id="star1half" name="rating" value="1.5" />
                                        <label class="half" for="star1half" title="Not Very Satisfied"></label>
                                        <input type="radio" id="star1" name="rating" value="1" />
                                        <label class="full" for="star1" title="Not At All Satisfied"></label>
                                        <input type="radio" id="starhalf" name="rating" value="0.5" />
                                        <label class="half" for="starhalf" title="Not At All Satisfied"></label>
                                    </fieldset>
                                </div>

                            </div>

                            <div class='row'>
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label>2. Any Feedback/Improvement Suggestions</label>
                                        <br />
                                        <br />
                                        <textarea class="form-control" rows="3" placeholder="Comments (if any)" name='comment' id='textarea' required></textarea>
                                    </div>
                                </div>
                            </div>
                            <br />
                            <button name="submit" type="submit" class="btn btn-primary btn-raised btn-block btn-flat" style="width:10em;" id="submit_button">Submit</button>
                            <input type="hidden" name="event_num" value='<?php echo $event_num; ?>' />
                            <input type="hidden" name="event_name" value='<?php echo $event_name; ?>' />
                            <input type="hidden" name="inc" value='<?php echo $inc; ?>'>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body" style="background: #fff;">
                    <div class="table-responsive">
                        <h3 style='color:#0D94D2;font-size:23px'>Earlier Suggestions </h3>
                    </div>
                    <br />
                    <table id="example1" class="table table-bordered  table-hover table-condensed">
                        <thead>
                            <tr>
                                <th>Associate Name</th>
                                <th>Associate ID</th>
                                <th>Date </th>
                                <th>Comments</th>
                                <th>Status</th>
                                <th> Developer Assigned </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
																										
$query="SELECT * FROM `suggestions` WHERE assoc_id='$assoc_id'";
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

                            </tr>

                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
	</div>


    <?php include 'footer.php'; ?>
