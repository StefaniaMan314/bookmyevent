<?php
include 'DB.php';
include 'cal_invite_testevent.php';
session_start();
/* Event date form event table */
$offset = $_SESSION['utc_offset'];
$timeslot = $_GET['time'];
$timeslot_tslno = $_GET['time'];
$event_id = $_GET['event_id'];
$event_date = $link->query("SELECT * FROM `event` WHERE  slno=$event_id");
$event_date1 = mysqli_fetch_assoc($event_date);
$golive = $event_date1['golive'];
$ename = $event_date1['ename'];
$ename = mysqli_real_escape_string($link, $ename);
$type1 = $event_date1['type1'];

$date = $event_date1['edate'];
$d1 = new DateTime($date);
$date = $d1->format('d');
$month = $d1->format('M');
$year = $d1->format('Y');
$monthh = $month . ' ' . $year;
/*--------------*/
$assoc_id = $_SESSION['associateId'];
$assoc_name = $_SESSION['fullname'];
$assoc_name = mysqli_real_escape_string($link, $assoc_name);
$email = $_SESSION['email'];
$role = $_SESSION['title'];
$Organization = $_SESSION['company'];
$Executive = $_SESSION['executive'];
$department = $_SESSION['department'];

$timestamp = date('Y-m-d h:i:s');

$registerOption = $_GET['registerOption'];
$arrayOfDependentsLength = $_GET['arrayOfDependentsLength'];

$arrayOfDependentNames = $_GET["arrayOfDependentNames"];
$arrayOfDependentNames = explode(';', $arrayOfDependentNames);

//Getting last and first names function
// function getNames() {
//     $names = '';

//     for ($i = 0; $i < $arrayOfDependentsLength - 1; $i++) {
//         // $names .= $dom->getElementById("lastName" . ($i + 1)) . " " . $dom->getElementById("firstName" . ($i + 1)) . ";";
//         $names .= $_GET['lastName' . ($i + 1)] . " " . $_GET['firstName' . ($i + 1)] . ";";
//     }

//     $names .= $_GET['lastName' . ($arrayOfDependentsLength)] . " " . $_GET['firstName' . ($_GET['numberOfDependents'])];

//     return $names;
// }



//  echo '<script language="javascript">';
//  echo 'alert(' . $arrayOfDependentNames . ')';
//  echo '</script>';
 
// $arrayOfDependentNames = explode(';', getNames());

$check12 = $link->query("SELECT `Manager_Name` FROM `Head_Count` WHERE Associate_Id REGEXP '$assoc_id'") or die("Error 234 : " . mysqli_error($link));
$rows12 = mysqli_fetch_row($check12);
$manager_name = $rows12[0];

$manager_name = mysqli_real_escape_string($link, $manager_name);
$check12 = $link->query("SELECT `Global_Assignment` FROM `Head_Count` WHERE Associate_name='$manager_name'") or die("Error qwertt : " . mysqli_error($link));
$rows12 = mysqli_fetch_row($check12);
$manager_email = $rows12[0];


$query = "SELECT `timeslots`,CONVERT_TZ (DATE_FORMAT(`start`,'%Y-%m-%d %H:%i:%s'),'+00:00','$offset'),CONVERT_TZ (DATE_FORMAT(`end`,'%Y-%m-%d %H:%i:%s'),'+00:00','$offset'),`start`,`end`,`waitlist`,`location`   FROM `timeslot` WHERE `slno`='$timeslot' AND eslno='$event_id'";
$result = $link->query($query) or die("Error test : " . mysqli_error($link));
$arr =  mysqli_fetch_row($result);
$tim = $arr[0];
$start_time = $arr[1];
$end_time = $arr[2];
$start_time1 = $arr[3];
$end_time1 = $arr[4];
$timeslot_location = $arr[6];
$wait = $arr[5];
$start_date = date('Y-m-d h:i a', strtotime($start_time));
$end_date = date('Y-m-d h:i a', strtotime($end_time));

$slot = $start_date . ' - ' . $end_date;

$start_date1 = date('Y-m-d h:i a', strtotime($start_time1));
$end_date1 = date('Y-m-d h:i a', strtotime($end_time1));


$slot1 = $start_date1 . ' - ' . $end_date1;
$check1 = $link->query("select COUNT(`slno`) from `testevent` where AssociateID='$assoc_id' AND event='$event_id'") or die("Error test1: " . mysqli_error($link));
$rows1 = mysqli_fetch_row($check1);
if (intval($rows1[0]) >= 1 && $type1 != 'multiple') {
    echo "<script>window.location='landing1.php?id=$event_id'</script>";
} else {
    $ename = mysqli_real_escape_string($link, $ename);
    $check12 = $link->query("SELECT `eslno` FROM `timeslot` WHERE `slno`='$timeslot' AND eslno='$event_id'") or die("Error test1: " . mysqli_error($link));
    $rows12 = mysqli_fetch_row($check12);
    $eid = $rows12[0];
    $check1 = $link->query("select count(*) from testevent where timeslot='$timeslot' AND event='$event_id'") or die("Error test1: " . mysqli_error($link));
    $rows1 = mysqli_fetch_row($check1);

    if (($rows1[0] > $tim)) {
        $exist1 = "Already Full";
        header("location:Index.php?status=" . " registerOption= " . $registerOption . " arrayOfDependentsLength= " . $arrayOfDependentsLength . " names= " . $arrayOfDependentNames);
        // header("location:Index.php?status=Sorry, but the slot is full.");
    } else {
        $Organization = mysqli_real_escape_string($link, $Organization);
        $Organization = mysqli_real_escape_string($link, $department);
        $Executive = mysqli_real_escape_string($link, $Executive);

        if ($registerOption == "AssociateAndDependents" || $registerOption == "OnlyDependants") {
            for ($i = 0; $i < $arrayOfDependentsLength; $i++) {

                $result1 = $link->query(
                    "INSERT INTO `testevent`(`AssociateID`, `AssociateName`, `email`, `Title`, `department`, `Organization`,  `Executive`, `timeslot`, `timestamp`,`event`, `timeslot1`, `booked`)" .
                    "VALUES ('$assoc_id','$arrayOfDependentNames[$i]','$email','$role','$department','$Organization','$Executive','$timeslot','$timestamp','$eid','$slot1','1')"
                );

                $exist1 = "Thank you for Registering";

                if ($golive == '1') {
                    $result12 = $link->query("UPDATE `bme_analysis` SET `registration_count`=`registration_count`+1  WHERE month='$month' AND year='$year' ") or die("Error test1: " . mysqli_error($link));
                    $result22 = $link->query("UPDATE `bme_analysis1` SET `registrations`=`registrations`+1  WHERE ename='$ename' AND month='$monthh' ") or die("Error test1: " . mysqli_error($link));
                }
            }
        }

        if ($registerOption == "AssociateAndDependents" || $registerOption == "AssociateOnly") {
            $result1 = $link->query("INSERT INTO `testevent`(`AssociateID`, `AssociateName`, `email`, `Title`, `department`, `Organization`,  `Executive`, `timeslot`, `timestamp`,`event`, `timeslot1`, `booked`) VALUES ('$assoc_id','$assoc_name','$email','$role','$department','$Organization','$Executive','$timeslot','$timestamp','$eid','$slot1','1')");
            $exist1 = "Thank you for Registering";
            if ($golive == '1') {
                $result12 = $link->query("UPDATE `bme_analysis` SET `registration_count`=`registration_count`+1  WHERE month='$month' AND year='$year' ") or die("Error test1: " . mysqli_error($link));
                $result22 = $link->query("UPDATE `bme_analysis1` SET `registrations`=`registrations`+1  WHERE ename='$ename' AND month='$monthh' ") or die("Error test1: " . mysqli_error($link));
            }
        }
    }



    if ($result1) {

        $event_date2 = $link->query("SELECT CONCAT(`prefix`,`slno`) AS 'UniqueID' FROM `testevent`  where AssociateID='$assoc_id' AND event='$event_id';") or die("Error test1: " . mysqli_error($link));
        $event_date3 = mysqli_fetch_assoc($event_date2);

        $ref_id = $event_date3['UniqueID'];

        $event_date = $link->query("SELECT * FROM `event` WHERE `slno`= $event_id") or die("Error test1: " . mysqli_error($link));
        $event_date1 = mysqli_fetch_assoc($event_date);

        $event_name = $event_date1['ename'];
        $description = $event_date1['edesc'];
        $date = $event_date1['edate'];
        $location1 = $event_date1['Location'];
        $date11 = date($event_date1['edate']);
        $confirm_email = $event_date1['confirm_email'];
        $invite_msg = $event_date1['invite_msg'];
        $qrcode_status = $event_date1['qrcode_status'];
        $file_loc = $event_date1['file_loc'];
        $food = $event_date1['food'];

        $country = $event_date1['country'];
        $emailbox = $event_date1['emailbox'];
        $from_name = "$emailbox";
        $from_address = "$emailbox";
        $to_name = $assoc_name;
        $to_address = $email;
        $startTime = $start_date1;
        $endTime = $end_date1;
        $subject = $event_name;
        $description = $invite_msg;
        $location = $location1;

        $confirm_email_header = "<p>Thank you for registering to attend Women's Forum - Power Forward; Valuing Differences, Creating Unity Breakout Session on Wednesday, March 24th, 2021, from 9:30am-10:00am.</p>
			<p>Starting at 9:30am CST, our Breakout sessions will kick off using the TeamsLIVE platform. Based on your registration, we have provided you with a separate Link you will use to access your BREAKOUT SESSION. All Breakout sessions will run from 9:30am-10:00am CST. Once the breakout session has concluded, please use the General Session Link to continue your attendance.</p>";
        //$confirm_email_footer="<p>For General Session Live Broadcast Instructions:</p><p>For an optimal broadcast experience, we recommend to follow the steps out lined <a target='_blank' href='https://www.mediaplatform.com/broadcaster-audience-viewing-requirements/'><u></u></a>here.</p><p>Note: The broadcast is not accessible over VPN. Please disconnect from the VPN before accessing. Internet Explorer is not supported. Please use Google Chrome, Firefox, or Microsoft Edge.</p><p>Throughout today's event, please anonymously react to the information you see by clicking the icons at the bottom left corner of this video. Your candid feedback helps us make these events better.</p><p>If you're experiencing technical issues, please post that feedback in the <a target='_blank' href='https://www.yammer.com/cerner.net/#/threads/inGroup?type=in_group&feedId=6129680384&view=all'><u>Broadcast at Cerner's Yammer community</u></a> or contact Associate Support for assistance at 1-HELP (US: 816-201-4357; Non-US: 866-434-1542) if you need help.</p>";
        if ($timeslot_tslno == '1548') {

            $confirm_email_link = "<ol><li><a target='_blank' href='https://nam10.safelinks.protection.outlook.com/ap/t-59584e83/?url=https%3A%2F%2Fteams.microsoft.com%2Fl%2Fmeetup-join%2F19%253ameeting_YjFlMWEzNTMtNzg3NS00ZTY1LTliNzYtNWU2OWMzMmU1NGM4%2540thread.v2%2F0%3Fcontext%3D%257b%2522Tid%2522%253a%2522fbc493a8-0d24-4454-a815-f4ca58e8c09d%2522%252c%2522Oid%2522%253a%2522fcaaf387-5391-47b6-b84d-6dfa99887e9a%2522%252c%2522IsBroadcastMeeting%2522%253atrue%257d%26btype%3Da%26role%3Da&data=04%7C01%7CStephen.Greer%40cerner.com%7C10bbc0d998cd4770501f08d8e2879890%7Cfbc493a80d244454a815f4ca58e8c09d%7C0%7C0%7C637508419299443432%7CUnknown%7CTWFpbGZsb3d8eyJWIjoiMC4wLjAwMDAiLCJQIjoiV2luMzIiLCJBTiI6Ik1haWwiLCJXVCI6Mn0%3D%7C1000&sdata=IsvCCdnqVVkUpLsR9gzO0p59cGNOQa%2FIJBtNb6AIcog%3D&reserved=0'><u>Breaking - Brenna Quinn</u></a></li></ol>";
            $description = $confirm_email_header . " " . $confirm_email_link;
            $subject = "Breakout Session - Women's Forum - Power Forward: Valuing Differences, Creating Unity";
        } else if ($timeslot_tslno == '1549') {
            $confirm_email_link = "<ol><li><a target='_blank' href='https://nam10.safelinks.protection.outlook.com/ap/t-59584e83/?url=https%3A%2F%2Fteams.microsoft.com%2Fl%2Fmeetup-join%2F19%253ameeting_OTcyYzA3OTgtYTVkMy00NzE3LWE0OTAtOTYxNDI1OWIxMDc4%2540thread.v2%2F0%3Fcontext%3D%257b%2522Tid%2522%253a%2522fbc493a8-0d24-4454-a815-f4ca58e8c09d%2522%252c%2522Oid%2522%253a%2522fcaaf387-5391-47b6-b84d-6dfa99887e9a%2522%252c%2522IsBroadcastMeeting%2522%253atrue%257d%26btype%3Da%26role%3Da&data=04%7C01%7CStephen.Greer%40cerner.com%7C10bbc0d998cd4770501f08d8e2879890%7Cfbc493a80d244454a815f4ca58e8c09d%7C0%7C0%7C637508419299453430%7CUnknown%7CTWFpbGZsb3d8eyJWIjoiMC4wLjAwMDAiLCJQIjoiV2luMzIiLCJBTiI6Ik1haWwiLCJXVCI6Mn0%3D%7C1000&sdata=n4%2FY1xH0NmbpvevUmimsWyx8OQefMClaEYQSYoV2YXQ%3D&reserved=0'><u>Bridging - Kimberly Gerard</u></a></li></ol>";
            $description = $confirm_email_header . " " . $confirm_email_link;
            $subject = "Breakout Session - Women's Forum - Power Forward: Valuing Differences, Creating Unity";
        } else if ($timeslot_tslno == '1547') {
            $confirm_email_link = "<ol><li><a target='_blank' href='https://nam10.safelinks.protection.outlook.com/ap/t-59584e83/?url=https%3A%2F%2Fteams.microsoft.com%2Fl%2Fmeetup-join%2F19%253ameeting_MzkwMWEzYWMtMjUxMS00NWFhLWE5NGItMzhjMDg4ZDg4YzI5%2540thread.v2%2F0%3Fcontext%3D%257b%2522Tid%2522%253a%2522fbc493a8-0d24-4454-a815-f4ca58e8c09d%2522%252c%2522Oid%2522%253a%2522fcaaf387-5391-47b6-b84d-6dfa99887e9a%2522%252c%2522IsBroadcastMeeting%2522%253atrue%257d%26btype%3Da%26role%3Da&data=04%7C01%7CStephen.Greer%40cerner.com%7C10bbc0d998cd4770501f08d8e2879890%7Cfbc493a80d244454a815f4ca58e8c09d%7C0%7C0%7C637508419299453430%7CUnknown%7CTWFpbGZsb3d8eyJWIjoiMC4wLjAwMDAiLCJQIjoiV2luMzIiLCJBTiI6Ik1haWwiLCJXVCI6Mn0%3D%7C1000&sdata=w0bLNBJMFDifvpbVWvmsqc5OFxcggsnBvz6Ajv%2Bft5c%3D&reserved=0'><u>Bonding - Maria Houchins</u></a></li></ol>";
            $description = $confirm_email_header . " " . $confirm_email_link;
            $subject = "Breakout Session - Women's Forum - Power Forward: Valuing Differences, Creating Unity";
        } else if ($timeslot_tslno == '1550') {
            $confirm_email_link = "<ol><li><a target='_blank' href='https://nam10.safelinks.protection.outlook.com/ap/t-59584e83/?url=https%3A%2F%2Fteams.microsoft.com%2Fl%2Fmeetup-join%2F19%253ameeting_OTczMjM0ZjItZDc0Mi00ZGM5LWI5MjAtZTEwYWU2Y2FkNzg1%2540thread.v2%2F0%3Fcontext%3D%257b%2522Tid%2522%253a%2522fbc493a8-0d24-4454-a815-f4ca58e8c09d%2522%252c%2522Oid%2522%253a%2522fcaaf387-5391-47b6-b84d-6dfa99887e9a%2522%252c%2522IsBroadcastMeeting%2522%253atrue%257d%26btype%3Da%26role%3Da&data=04%7C01%7CStephen.Greer%40cerner.com%7C10bbc0d998cd4770501f08d8e2879890%7Cfbc493a80d244454a815f4ca58e8c09d%7C0%7C0%7C637508419299463426%7CUnknown%7CTWFpbGZsb3d8eyJWIjoiMC4wLjAwMDAiLCJQIjoiV2luMzIiLCJBTiI6Ik1haWwiLCJXVCI6Mn0%3D%7C1000&sdata=aqjJOrI4U5200g1eW2XqZX4BFB92SL1dsdleLK9zDxE%3D&reserved=0'><u>Belonging - Andrea Hendricks</u></a></li></ol>";
            $description = $confirm_email_header . " " . $confirm_email_link;
            $subject = "Breakout Session - Women's Forum - Power Forward: Valuing Differences, Creating Unity";
        } else if ($timeslot_tslno == '1551') {
            $description = "<p>Thank you for registering to attend Women's Forum - Power Forward; Valuing Differences, Creating Unity on Wednesday, March 24th, 2021. Our General Session kicks off promptly at 8:00 am CST with a Mindful Empowerment Exercise. Please access the General Session Broadcast event <a target='_blank' href='https://broadcast.cerner.com/#/event/60359a01d0cf960377f7d0e0'><u>here</u></a>. </p>
				<p><b><u>For General Session Live Broadcast Instructions:</u></b></p><p>For an optimal broadcast experience, we recommend to follow the steps out lined <a target='_blank' href='https://www.mediaplatform.com/broadcaster-audience-viewing-requirements/'><u>here</u></a>.</p><p><b>Note:</b> The broadcast is not accessible over VPN. Please disconnect from the VPN before accessing. Internet Explorer is not supported. Please use Google Chrome, Firefox, or Microsoft Edge.</p><p>Throughout today's event, please anonymously react to the information you see by clicking the icons at the bottom left corner of this video. Your candid feedback helps us make these events better.</p><p>If you're experiencing technical issues, please post that feedback in the <a target='_blank' href='https://www.yammer.com/cerner.net/#/threads/inGroup?type=in_group&feedId=6129680384&view=all'><u>Broadcast at Cerner's Yammer community</u></a> or contact Associate Support for assistance at 1-HELP (US: 816-201-4357; Non-US: 866-434-1542) if you need help.</p>";
        } else {
            $description = $description;
        }

        $uid = sendIcalEvent_IST($from_name, $from_address, $to_name, $to_address, $startTime, $endTime, $subject, $description, $timeslot_location, $emailbox, $ref_id, $assoc_id);
        if ($uid) {
            echo "Sent invite\n";
        } else {
            echo "no UID";
        }
        $arr = array();
        $arr['assoc_id'] = $assoc_id;
        $arr['assoc_name'] = $assoc_name;
        $date1 = explode(' ', $startTime);
        $date2 = explode(' ', $endTime);
        $start1 = date('h:i a', strtotime($date1[1]));
        $end1 = date('h:i a', strtotime($date2[1]));
        $arr['ref_id'] = $ref_id;
        $arr['event_name'] = $event_name;
        $arr['manager_name'] = $manager_name;
        $arr['confirm_email'] = $confirm_email;
        $arr['location'] = $timeslot_location;
        $arr['qrcode_status'] = $qrcode_status;
        $arr['file_loc'] = $file_loc;
        $arr['country'] = $country;
        $arr['timeslot_tslno'] = $timeslot_tslno;
        $arr['timeslot'] = strtoupper($slot);
        template($arr);
        send_mail($manager_email, $email, $event_name, $emailbox);
        //template_manager($arr);

        //send_mail_manager($manager_email,$event_name);
        $update_result = $link->query("UPDATE `testevent` SET `uid`='$uid' WHERE `AssociateID`='$assoc_id' AND event='$event_id' AND timeslot='$timeslot'") or die("Error test_uid: " . mysqli_error($link));

        if ($food == '1') {
            echo "<script>window.location='foodselect.php?id=$event_id'</script>";
        } else {
            if ($type1 == 'multiple') {
                echo "<script>window.location='Event_Registration.php?id=$event_id'</script>";
            } else {
                echo "<script>window.location='landing2.php?id=$event_id'</script>";
            }
        }
    }
}
