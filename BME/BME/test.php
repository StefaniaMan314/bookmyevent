<?php
// define variables and set to empty values
$nameErr = $emailErr = $genderErr = $websiteErr = "";
$name = $email = $gender = $comment = $website = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
      $nameErr = "Only letters and white space allowed";
    }
  }
  
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }
  }
    
  if (empty($_POST["website"])) {
    $website = "";
  } else {
    $website = test_input($_POST["website"]);
    // check if URL address syntax is valid (this regular expression also allows dashes in the URL)
    if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
      $websiteErr = "Invalid URL";
    }
  }

  if (empty($_POST["comment"])) {
    $comment = "";
  } else {
    $comment = test_input($_POST["comment"]);
  }

  if (empty($_POST["gender"])) {
    $genderErr = "Gender is required";
  } else {
    $gender = test_input($_POST["gender"]);
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
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

    }

</style>


<div class="card">
        <div class="card-header">
            <h3 style="color:#0D94D2"> <b>Register for EventName </b></h3>
        </div>
        <div class="card-body" style="background: #fff;">

            <div class="row">
                <div class="col-lg-5">
                    <form role="form" method="post" action="scripts/requestAccessMail.php" onsubmit="return upperMe1()" enctype="multipart/form-data">

                        <div class="form-group">

                            <label> Associate Name : <?php echo $assoc_id; ?> </label> </div>
                        <div class="form-group">

                            <label> How many additional family members are you registering? (Immediate family only) : <?php echo $assoc_name; ?> </label> </div>

                        <div class="form-group" id="divaccess">

                            <select style='font-size:20px;width:70%' class="form-control w3-border select2 w3-hover-border-blue" oninput="this.className = ''" name='access' onchange="Selecttype(this);" placeholder=" " required>
                                <option value="yes">Select count from dropdown</option>
                                <option id="1" value="1">1</option>
                                <option id="2" value="0">2</option>
                                <option id="3" value="0">3</option>
                                <option id="4" value="0">4</option>
                                <option id="5" value="0">5</option>
                                <option id="6" value="0">6</option>
                                <option id="7" value="0">7</option>
                                <option id="8" value="0">8</option>


                            </select>


                        </div>

                        <div>

                        <label> Dependent Names(s) : </label> <br />
                            <br />
                            <input name="fromdate" id="datepicker" placeholder="From Date" /> &nbsp; to &nbsp;
                            <input name="todate" id="datepicker1" placeholder="To Date" />
                        

                        </div>

                      

                    
                        
                        <button type="cancel" name="cancel" class="btn btn-default bg-olive">Cancel</button>
                        <button type="submit" name="save1" class="btn btn-default bg-olive">Submit</button>


                    </form>
                </div>
            </div>
        </div>

    </div>



<?php?>