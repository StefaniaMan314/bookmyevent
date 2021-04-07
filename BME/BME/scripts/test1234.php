<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
</head>

<body style='font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;'>
    <p style='font-size:13px;'>Hi,</p>

    <p style='font-size:13px;'> <?php echo $assoc_name; ?> has requested for accessing the application BookMyEvent.
    </p>
    <h5> Associate ID: <?php echo $assoc_id; ?> </h5>
    <h5>Associate Name: <?php echo $assoc_name; ?> </h5>
    <h5>Access Dates: <?php echo $fromdate_final; ?> to <?php echo $todate_final; ?> </h5>
    <h5>Justification: <?php echo $justification; ?> </h5>


    <br />
    Please click <a href="https://bookmyevent.cerner.com/BME/RequestAction.php">here</a> to approve this request.
    <br />
    <p style='font-size:13px;'>Thanks,
        <br />SSE_ES_DevTeam</p>
    <br />


</body>

</html>