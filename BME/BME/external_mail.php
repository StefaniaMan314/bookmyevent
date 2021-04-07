<?php include 'header.php';
session_start();
$assoc_id=$_SESSION['associateId'];
$assoc_name=$_SESSION['fullname'];
$offset=$_SESSION['utc_offset'];
$event_num = $_GET['event_id'];


   $check3=$link->query("SELECT ename,slno, `edesc`, `edate`,Location, `file_loc`,`golive`,`creator`,`type1`  FROM `event` WHERE slno='$event_num'");
    $rows3=mysqli_fetch_row($check3);
	$event=$rows3[0];
	$description=$rows3[2];
$day=$rows3[3];
$location=$rows3[4];
	$eimage=$rows3[5];
$golive=$rows3[6];
$creator_id=$rows3[7];
$type1==$rows3[8];
?>
<script>
    $(document).ready(function() {

        $('#preview').attr('disabled', 'disabled');
        $('#mailcontent').on('input', function() {

            if ($('#mailcontent').val() && $('#name').val()) {
                $('#preview').removeAttr('disabled');
            } else {
                $('#preview').attr('disabled', 'disabled');
            }
        });

        $('#name').on('input', function() {

            if ($('#mailcontent').val() && $('#name').val()) {
                $('#preview').removeAttr('disabled');
            } else {
                $('#preview').attr('disabled', 'disabled');
            }
        });
        var x = document.getElementById("preview_show");
        x.style.display = "none";
        $('#preview').on('click', function() {
            $event_id = $('#event_id').val();
            $name = $('#name').val();
            $mailcontent = $('#mailcontent').val();
            console.log($event_id)
            console.log($name)
            console.log($mailcontent)

            $.ajax({
                type: 'POST',
                url: 'mail_preview1.php',
                data: {
                    "event_id": $event_id,
                    "name": $name,
                    "mailcontent": $mailcontent
                },
                success: function(html) {
                    $('#preview_show').load("template10.html");

                    x.style.display = "block";


                }
            });
        });

    });

</script>
<br />
<br />
<div class="row">
    <!-- left column -->
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="card card-primary">

            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" method="post" action="external_mail1.php" onsubmit="return upperMe1()" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="form-group">

                        <input type="hidden" class="form-control" name="event_id" id="event_id" value="<?php echo $event_num; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Event Name</label>
                        <input type="text" class="form-control" name="event_name1" id="event_name1" value="<?php echo $event; ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter name">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" name="emailaddress" id="emailaddress" placeholder="Enter email">
                    </div>


                    <div class="form-group">
                        <label for="exampleInputEmail1">Content</label>
                        <textarea type="text" class="form-control" name="mailcontent" id="mailcontent" placeholder="Enter Mail Content"></textarea>
                    </div>
                    <button type="submit" name="save1" class="btn btn-default bg-olive">Send</button>
                    <button type="button" id="preview" class="btn btn-primary">Preview</button>

                </div>
            </form>
        </div>
    </div>
    <div class="col-md-6" id="preview_show">

    </div>
</div>




<?php include 'footer.php'; ?>
