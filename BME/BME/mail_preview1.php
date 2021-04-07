<?php

include 'DB.php';
session_start();
$fullname=$_SESSION['fullname'];

$mailcontent=$_POST['mailcontent'];
$cal_invite=$_POST['cal_invite'];

?>
<iframe frameborder="0" src="external_mail_preview1.php?mailcontent=<?php echo $mailcontent ?>&cal_invite=<?php echo $cal_invite ?>" style="width:100%;height:400px"></iframe>
