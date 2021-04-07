<?php
// date_default_timezone_set("Asia/Kolkata");
function sendIcalEvent_IST_cancel($from_name, $from_address, $to_name, $to_address, $startTime, $endTime, $subject, $description, $timeslot_location, $uid)
{
  // echo "Inside function\n";
    $domain = 'cerner.com';
    $message = "<html>\n";
    $message .= "<body>\n";
    $message .= '<p>Greetings '.$to_name.',</p>';
    $message .= '<p>'.$description.'</p>';
    $message .= "</body>\n";
    $message .= "</html>\n";

    $ical = 'BEGIN:VCALENDAR' . "\r\n" .
    'PRODID:-//Microsoft Corporation//Outlook 10.0 MIMEDIR//EN' . "\r\n" .
    // 'X-WR-RELCALID:20180119T530001951961925@cerner.com' . "\r\n" .
    'VERSION:2.0' . "\r\n" .
    'METHOD:CANCEL' . "\r\n" .
    'BEGIN:VTIMEZONE' . "\r\n" .
    'TZID:UTC' . "\r\n" .
    'BEGIN:STANDARD' . "\r\n" .
    'DTSTART:20190426T190000' . "\r\n" .
    // 'RRULE:FREQ=YEARLY;INTERVAL=1;BYDAY=1SU;BYMONTH=11' . "\r\n" .
    'TZOFFSETFROM:+0000' . "\r\n" .
    'TZOFFSETTO:+0000' . "\r\n" .
    'TZNAME:IST' . "\r\n" .
    'END:STANDARD' . "\r\n" .
    'END:VTIMEZONE' . "\r\n" .
    'BEGIN:VEVENT' . "\r\n" .
    'ORGANIZER;CN="'.$from_name.'":MAILTO:'.$from_address. "\r\n" .
    'ATTENDEE;CN="'.$to_name.'";ROLE=REQ-PARTICIPANT;RSVP=TRUE:MAILTO:'.$to_address. "\r\n" .
    'LAST-MODIFIED:' . date("Ymd\TGis") . "\r\n" .
    'UID:'.$uid."\r\n" .
    'DTSTAMP:'.date("Ymd\TGis"). "\r\n" .
    'DTSTART;TZID="UTC":'.date("Ymd\THis", strtotime($startTime)). "\r\n" .
    'DTEND;TZID="UTC":'.date("Ymd\THis", strtotime($endTime)). "\r\n" .
    'TRANSP:OPAQUE'. "\r\n" .
    'SEQUENCE:2'. "\r\n" .    //Sequence as 2 for cancelling the invite
    'STATUS:CANCELLED'. "\r\n" .
    'SUMMARY:' . $subject . "\r\n" .
    'LOCATION:' . $timeslot_location . "\r\n" .
    'CLASS:PUBLIC'. "\r\n" .
    'PRIORITY:5'. "\r\n" .
    'BEGIN:VALARM' . "\r\n" .
    'TRIGGER:-PT15M' . "\r\n" .
    'ACTION:DISPLAY' . "\r\n" .
    'DESCRIPTION:Reminder' . "\r\n" .
    'END:VALARM' . "\r\n" .
    'END:VEVENT'. "\r\n" .
    'END:VCALENDAR'. "\r\n";
    // $message .= 'Content-Type: text/calendar;name="meeting.ics";method=REQUEST'."\n";
    // $message .= "Content-Transfer-Encoding: 8bit\n\n";
    // $message .= $ical;

    include_once './PHPMailer/PHPMailerAutoload.php';
    $mail = new PHPMailer;
    $mail->addCustomHeader('MIME-version',"1.0");
   $mail->AddStringAttachment($ical, "event.ics", "7bit", "text/calendar; charset=utf-8; method=CANCEL");
    $mail->addCustomHeader('Content-type',"text/html; charset=UTF-8");
    $mail->addCustomHeader('Content-Transfer-Encoding',"7bit");
    $mail->addCustomHeader('X-Mailer',"Microsoft Office Outlook 12.0");
    $mail->addCustomHeader("Content-class: urn:content-classes:calendarmessage");

    // Set PHPMailer to use the sendmail transport
    $mail->IsSMTP();
    $mail->Host="smtplb.cerner.com";
//    $mail->isSendmail();
    $mail->setFrom('BookMyEvent@cerner.com');
    $mail->addAddress($to_address);
    $mail->Subject = $subject;
   
    $mail->Body=$message;
    $mail->Ical = $ical;
    // $mail->msgHTML(file_get_contents('template.html'), dirname(__FILE__));
 $mail->SMTPAutoTLS = false;   // TO bypass the connection error(added on 2019-03-04)
    $mail->AltBody = 'Test';
    //Attach an image file

    //send the message, check for errors
    if(!$mail->send())
    {
      echo "Mailer Error: " . $mail->ErrorInfo;
    }
    else {
		$exist1="Emails Sent";
		 header("location:Profile.php?".$exist1);

		 }

}

function sendIcalEvent_IST_eventchange($from_name, $from_address, $to_name, $to_address, $startTime, $endTime, $subject, $description, $location, $uid)
{
  // echo "Inside function\n";
    $domain = 'cerner.com';
    // $uid=date("Ymd\TGis").rand()."@".$domain;
    //Create Email Headers
   // $mime_boundary = "----Event Booking----".MD5(TIME());

   // $headers = "From: ".$from_name." <".$from_address.">\n";
    //$headers .= "Reply-To: ".$from_name." <".$from_address.">\n";
    //$headers .= "MIME-Version: 1.0\n";
    //$headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
    //$headers .= "Content-class: urn:content-classes:calendarmessage\n";

    //Create Email Body (HTML)
   // $message = "--$mime_boundary\r\n";
    //$message .= "Content-Type: text/html; charset=UTF-8\n";
    //$message .= "Content-Transfer-Encoding: 8bit\n\n";
    $message = "<html>\n";
    $message .= "<body>\n";
    $message .= '<p>Greetings '.$to_name.',</p>';
    $message .= '<p>'.$description.'</p>';
    $message .= "</body>\n";
    $message .= "</html>\n";
    //$message .= "--$mime_boundary\r\n";

    $ical = 'BEGIN:VCALENDAR' . "\r\n" .
    'PRODID:-//Microsoft Corporation//Outlook 10.0 MIMEDIR//EN' . "\r\n" .
    // 'X-WR-RELCALID:20180119T530001951961925@cerner.com' . "\r\n" .
    'VERSION:2.0' . "\r\n" .
    'METHOD:REQUEST' . "\r\n" .
    'BEGIN:VTIMEZONE' . "\r\n" .
    'TZID:UTC' . "\r\n" .
    'BEGIN:STANDARD' . "\r\n" .
    'DTSTART:20190426T190000' . "\r\n" .
    // 'RRULE:FREQ=YEARLY;INTERVAL=1;BYDAY=1SU;BYMONTH=11' . "\r\n" .
    'TZOFFSETFROM:+0000' . "\r\n" .
    'TZOFFSETTO:+0000' . "\r\n" .
    'TZNAME:IST' . "\r\n" .
    'END:STANDARD' . "\r\n" .
    'END:VTIMEZONE' . "\r\n" .
    'BEGIN:VEVENT' . "\r\n" .
    'ORGANIZER;CN="'.$from_name.'":MAILTO:'.$from_address. "\r\n" .
    'ATTENDEE;CN="'.$to_name.'";ROLE=REQ-PARTICIPANT;RSVP=TRUE:MAILTO:'.$to_address. "\r\n" .
    'LAST-MODIFIED:' . date("Ymd\TGis") . "\r\n" .
    'UID:'.$uid."\r\n" .
    'DTSTAMP:'.date("Ymd\TGis"). "\r\n" .
    'DTSTART;TZID="UTC":'.date("Ymd\THis", strtotime($startTime)). "\r\n" .
    'DTEND;TZID="UTC":'.date("Ymd\THis", strtotime($endTime)). "\r\n" .
    'TRANSP:OPAQUE'. "\r\n" .
    'SEQUENCE:2'. "\r\n" .    //Sequence as 2 for updating the invite
    // 'STATUS:CANCELLED'. "\r\n" .
    'SUMMARY:' . $subject . "\r\n" .
    'LOCATION:' . $location . "\r\n" .
    'CLASS:PUBLIC'. "\r\n" .
    'PRIORITY:5'. "\r\n" .
    'BEGIN:VALARM' . "\r\n" .
    'TRIGGER:-PT15M' . "\r\n" .
    'ACTION:DISPLAY' . "\r\n" .
    'DESCRIPTION:Reminder' . "\r\n" .
    'END:VALARM' . "\r\n" .
    'END:VEVENT'. "\r\n" .
    'END:VCALENDAR'. "\r\n";
    //$message .= 'Content-Type: text/calendar;name="meeting.ics";method=REQUEST'."\n";
    //$message .= "Content-Transfer-Encoding: 8bit\n\n";
    //$message .= $ical;

    
	 include_once './PHPMailer/PHPMailerAutoload.php';
    $mail = new PHPMailer;
    $mail->addCustomHeader('MIME-version',"1.0");
   $mail->AddStringAttachment($ical, "event.ics", "7bit", "text/calendar; charset=utf-8; method=REQUEST");
    $mail->addCustomHeader('Content-type',"text/html; charset=UTF-8");
    $mail->addCustomHeader('Content-Transfer-Encoding',"7bit");
    $mail->addCustomHeader('X-Mailer',"Microsoft Office Outlook 12.0");
    $mail->addCustomHeader("Content-class: urn:content-classes:calendarmessage");

    // Set PHPMailer to use the sendmail transport
    $mail->IsSMTP();
    $mail->Host="smtplb.cerner.com";
//    $mail->isSendmail();
    $mail->setFrom('BookMyEvent@cerner.com');
    $mail->addAddress($to_address);
    $mail->Subject = $subject;
   
    $mail->Body=$message;
    $mail->Ical = $ical;
    // $mail->msgHTML(file_get_contents('template.html'), dirname(__FILE__));
 $mail->SMTPAutoTLS = false;   // TO bypass the connection error(added on 2019-03-04)
    $mail->AltBody = 'Test';
    //Attach an image file

    //send the message, check for errors
    if(!$mail->send())
    {
      echo "Mailer Error: " . $mail->ErrorInfo;
    }
    else {
		$exist1="Emails Sent";
		 header("location:Profile.php?".$exist1);

		 }
		 
}

function sendIcalEvent_IST_timechange($from_name, $from_address, $to_name, $to_address, $startTime, $endTime, $subject, $description, $timeslot_location, $uid)
{
  // echo "Inside function\n";
    $domain = 'cerner.com';
    // $uid=date("Ymd\TGis").rand()."@".$domain;
    //Create Email Headers
   // $mime_boundary = "----Event Booking----".MD5(TIME());

   // $headers = "From: ".$from_name." <".$from_address.">\n";
    //$headers .= "Reply-To: ".$from_name." <".$from_address.">\n";
    //$headers .= "MIME-Version: 1.0\n";
    //$headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
    //$headers .= "Content-class: urn:content-classes:calendarmessage\n";

    //Create Email Body (HTML)
   // $message = "--$mime_boundary\r\n";
    //$message .= "Content-Type: text/html; charset=UTF-8\n";
    //$message .= "Content-Transfer-Encoding: 8bit\n\n";
    $message = "<html>\n";
    $message .= "<body>\n";
    $message .= '<p>Greetings '.$to_name.',</p>';
    $message .= '<p>'.$description.'</p>';
    $message .= "</body>\n";
    $message .= "</html>\n";
    //$message .= "--$mime_boundary\r\n";

    $ical = 'BEGIN:VCALENDAR' . "\r\n" .
    'PRODID:-//Microsoft Corporation//Outlook 10.0 MIMEDIR//EN' . "\r\n" .
    // 'X-WR-RELCALID:20180119T530001951961925@cerner.com' . "\r\n" .
    'VERSION:2.0' . "\r\n" .
    'METHOD:REQUEST' . "\r\n" .
    'BEGIN:VTIMEZONE' . "\r\n" .
    'TZID:UTC' . "\r\n" .
    'BEGIN:STANDARD' . "\r\n" .
    'DTSTART:20190426T190000' . "\r\n" .
    // 'RRULE:FREQ=YEARLY;INTERVAL=1;BYDAY=1SU;BYMONTH=11' . "\r\n" .
    'TZOFFSETFROM:+0000' . "\r\n" .
    'TZOFFSETTO:+0000' . "\r\n" .
    'TZNAME:IST' . "\r\n" .
    'END:STANDARD' . "\r\n" .
    'END:VTIMEZONE' . "\r\n" .
    'BEGIN:VEVENT' . "\r\n" .
    'ORGANIZER;CN="'.$from_name.'":MAILTO:'.$from_address. "\r\n" .
    'ATTENDEE;CN="'.$to_name.'";ROLE=REQ-PARTICIPANT;RSVP=TRUE:MAILTO:'.$to_address. "\r\n" .
    'LAST-MODIFIED:' . date("Ymd\TGis") . "\r\n" .
    'UID:'.$uid."\r\n" .
    'DTSTAMP:'.date("Ymd\TGis"). "\r\n" .
    'DTSTART;TZID="UTC":'.date("Ymd\THis", strtotime($startTime)). "\r\n" .
    'DTEND;TZID="UTC":'.date("Ymd\THis", strtotime($endTime)). "\r\n" .
    'TRANSP:OPAQUE'. "\r\n" .
    'SEQUENCE:2'. "\r\n" .    //Sequence as 2 for updating the invite
    // 'STATUS:CANCELLED'. "\r\n" .
    'SUMMARY:' . $subject . "\r\n" .
    'LOCATION:' . $timeslot_location . "\r\n" .
    'CLASS:PUBLIC'. "\r\n" .
    'PRIORITY:5'. "\r\n" .
    'BEGIN:VALARM' . "\r\n" .
    'TRIGGER:-PT15M' . "\r\n" .
    'ACTION:DISPLAY' . "\r\n" .
    'DESCRIPTION:Reminder' . "\r\n" .
    'END:VALARM' . "\r\n" .
    'END:VEVENT'. "\r\n" .
    'END:VCALENDAR'. "\r\n";
    //$message .= 'Content-Type: text/calendar;name="meeting.ics";method=REQUEST'."\n";
    //$message .= "Content-Transfer-Encoding: 8bit\n\n";
    //$message .= $ical;

    
	 include_once './PHPMailer/PHPMailerAutoload.php';
    $mail = new PHPMailer;
    $mail->addCustomHeader('MIME-version',"1.0");
   $mail->AddStringAttachment($ical, "event.ics", "7bit", "text/calendar; charset=utf-8; method=REQUEST");
    $mail->addCustomHeader('Content-type',"text/html; charset=UTF-8");
    $mail->addCustomHeader('Content-Transfer-Encoding',"7bit");
    $mail->addCustomHeader('X-Mailer',"Microsoft Office Outlook 12.0");
    $mail->addCustomHeader("Content-class: urn:content-classes:calendarmessage");

    // Set PHPMailer to use the sendmail transport
    $mail->IsSMTP();
    $mail->Host="smtplb.cerner.com";
//    $mail->isSendmail();
    $mail->setFrom('BookMyEvent@cerner.com');
    $mail->addAddress($to_address);
    $mail->Subject = $subject;
   
    $mail->Body=$message;
    $mail->Ical = $ical;
    // $mail->msgHTML(file_get_contents('template.html'), dirname(__FILE__));
 $mail->SMTPAutoTLS = false;   // TO bypass the connection error(added on 2019-03-04)
    $mail->AltBody = 'Test';
    //Attach an image file

    //send the message, check for errors
    if(!$mail->send())
    {
      echo "Mailer Error: " . $mail->ErrorInfo;
    }
    else {
		$exist1="Emails Sent";
		 header("location:Profile.php?".$exist1);

		 }
		 
}

function sendIcalEvent_IST_cancellearning($from_name, $from_address, $to_name, $to_address, $startTime, $endTime, $subject, $description, $timeslot_location, $uid)
{
  // echo "Inside function\n";
    $domain = 'cerner.com';
    $message = "<html>\n";
    $message .= "<body>\n";
    $message .= '<p>Greetings '.$to_name.',</p>';
    $message .= '<p>'.$description.'</p>';
    $message .= "</body>\n";
    $message .= "</html>\n";

    $ical = 'BEGIN:VCALENDAR' . "\r\n" .
    'PRODID:-//Microsoft Corporation//Outlook 10.0 MIMEDIR//EN' . "\r\n" .
    // 'X-WR-RELCALID:20180119T530001951961925@cerner.com' . "\r\n" .
    'VERSION:2.0' . "\r\n" .
    'METHOD:CANCEL' . "\r\n" .
    'BEGIN:VTIMEZONE' . "\r\n" .
    'TZID:UTC' . "\r\n" .
    'BEGIN:STANDARD' . "\r\n" .
    'DTSTART:20190426T190000' . "\r\n" .
    // 'RRULE:FREQ=YEARLY;INTERVAL=1;BYDAY=1SU;BYMONTH=11' . "\r\n" .
    'TZOFFSETFROM:+0000' . "\r\n" .
    'TZOFFSETTO:+0000' . "\r\n" .
    'TZNAME:IST' . "\r\n" .
    'END:STANDARD' . "\r\n" .
    'END:VTIMEZONE' . "\r\n" .
    'BEGIN:VEVENT' . "\r\n" .
    'ORGANIZER;CN="'.$from_name.'":MAILTO:'.$from_address. "\r\n" .
    'ATTENDEE;CN="'.$to_name.'";ROLE=REQ-PARTICIPANT;RSVP=TRUE:MAILTO:'.$to_address. "\r\n" .
    'LAST-MODIFIED:' . date("Ymd\TGis") . "\r\n" .
    'UID:'.$uid."\r\n" .
    'DTSTAMP:'.date("Ymd\TGis"). "\r\n" .
	'DTSTART;TZID="India Standard Time":'.date("Ymd\THis", strtotime($startTime)). "\r\n" .
    'DTEND;TZID="India Standard Time":'.date("Ymd\THis", strtotime($endTime)). "\r\n" .
    'TRANSP:OPAQUE'. "\r\n" .
    'SEQUENCE:2'. "\r\n" .    //Sequence as 2 for cancelling the invite
    'STATUS:CANCELLED'. "\r\n" .
    'SUMMARY:' . $subject . "\r\n" .
    'LOCATION:' . $timeslot_location . "\r\n" .
    'CLASS:PUBLIC'. "\r\n" .
    'PRIORITY:5'. "\r\n" .
    'BEGIN:VALARM' . "\r\n" .
    'TRIGGER:-PT15M' . "\r\n" .
    'ACTION:DISPLAY' . "\r\n" .
    'DESCRIPTION:Reminder' . "\r\n" .
    'END:VALARM' . "\r\n" .
    'END:VEVENT'. "\r\n" .
    'END:VCALENDAR'. "\r\n";
    // $message .= 'Content-Type: text/calendar;name="meeting.ics";method=REQUEST'."\n";
    // $message .= "Content-Transfer-Encoding: 8bit\n\n";
    // $message .= $ical;

    include_once './PHPMailer/PHPMailerAutoload.php';
    $mail = new PHPMailer;
    $mail->addCustomHeader('MIME-version',"1.0");
   $mail->AddStringAttachment($ical, "event.ics", "7bit", "text/calendar; charset=utf-8; method=CANCEL");
    $mail->addCustomHeader('Content-type',"text/html; charset=UTF-8");
    $mail->addCustomHeader('Content-Transfer-Encoding',"7bit");
    $mail->addCustomHeader('X-Mailer',"Microsoft Office Outlook 12.0");
    $mail->addCustomHeader("Content-class: urn:content-classes:calendarmessage");

    // Set PHPMailer to use the sendmail transport
    $mail->IsSMTP();
    $mail->Host="smtplb.cerner.com";
//    $mail->isSendmail();
    $mail->setFrom('BookMyEvent@cerner.com');
    $mail->addAddress($to_address);
    $mail->Subject = $subject;
   
    $mail->Body=$message;
    $mail->Ical = $ical;
    // $mail->msgHTML(file_get_contents('template.html'), dirname(__FILE__));
 $mail->SMTPAutoTLS = false;   // TO bypass the connection error(added on 2019-03-04)
    $mail->AltBody = 'Test';
    //Attach an image file

    //send the message, check for errors
    if(!$mail->send())
    {
      echo "Mailer Error: " . $mail->ErrorInfo;
    }
    else {
		$exist1="Emails Sent";
		 header("location:Profile.php?".$exist1);

		 }

}

?>
