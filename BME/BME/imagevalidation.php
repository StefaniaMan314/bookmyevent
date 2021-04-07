<?php
include "DB.php";
$slno=$_GET['slno'];


if (isset($_POST["upload"])) {
    // Get Image Dimension
    $fileinfo = @getimagesize($_FILES["Filename"]["tmp_name"]);
    $width = $fileinfo[0];
    $height = $fileinfo[1];
    
    $allowed_image_extension = array(
        "png",
		"PNG",
		"JPG",
		"JPEG",
        "jpg",
        "jpeg"
    );
    
    // Get image file extension
    $file_extension = pathinfo($_FILES["Filename"]["name"], PATHINFO_EXTENSION);
    
    // Validate file input to check if is not empty
    if (! file_exists($_FILES["Filename"]["tmp_name"])) {
        $response = array(
            "type" => "error",
            "message" => "Choose image file to upload."
        );
    }    // Validate file input to check if is with valid extension
    else if (! in_array($file_extension, $allowed_image_extension)) {
        $response = array(
            "type" => "error",
            "message" => "Upload valiid images. Only PNG and JPEG are allowed."
        );
        echo $result;
    }    // Validate image file size
    else if (($_FILES["Filename"]["size"] > 2000000)) {
        $response = array(
            "type" => "error",
            "message" => "Image size exceeds 2MB"
        );
    }    // Validate image file dimension
  else {
        $target = "uploads/" . basename($_FILES["Filename"]["name"]);
		$result1=$link->query("UPDATE  event SET  file_loc='$target' WHERE slno='$slno'");
		
        if ((move_uploaded_file($_FILES["Filename"]["tmp_name"], $target)) && ($result1)) {
			
			$response = array(
                "type" => "success",
                "message" => "Image uploaded successfully. <br/>Please Reload the page"
            
     
            );
			
        } else {
            $response = array(
                "type" => "error",
                "message" => "Problem in uploading image files."
            );
        }
    }
}
?>

<html>
<head>

<style>
body{
    font-family: Arial;
    width: 550px;
}
#frm-image-upload{
    padding: 0px;
    background-color: white;
}

.form-row {
    padding: 20px;
    border-top: white 1px solid;
}

.button-row {
    padding: 10px 20px;
    border-top: white 1px solid;
}

#btn-submit {
    padding: 10px 40px;
    background: #3d9970  ;
    border: 1px solid transparent;
    color: white;
    border-radius: 2px;
}

.Filename {
    background: #FFF;
    padding: 5px;
    margin-top: 5px;
    border-radius: 2px;
    border: #8aacb7 1px solid;
}

.response {
    padding: 10px;
    margin-top: 10px;
    border-radius: 2px;
	max-width:200px;
}

.error {
    background: #fdcdcd;
    border: #ecc0c1 1px solid;
}

.success {
    background: #c5f3c3;
    border: #bbe6ba 1px solid;
}

 #myiframe { width: 300px; height: 75px ; border: #8aacb7 1px solid  }
</style>
</head>
<body>
   <div>
    <form id="frm-image-upload" action="imagevalidation.php?slno=<?php echo $slno; ?>" name='img'
        method="post" enctype="multipart/form-data">
        <div class="form-row">
            <div><b>Edit Image:</b></div>
            <div>
                <input type="file" class="Filename" name="Filename">
            </div>
        </div>

        <div class="button-row">
            <input type="submit" id="btn-submit" name="upload"
                value="Upload">
        </div>
    </form>
    </div>
	
	
	<?php if(!empty($response)) { ?>
<div class="response <?php echo $response["type"]; ?>
    " style="max-width:400px">
	<?php echo $_FILES["Filename"]["name"]; ?>
	<br/>
    <?php echo $response["message"]; ?>
</div>
<?php }?>
</body>
</html>

