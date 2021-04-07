<?php
include '../phpqrcode/qrlib.php'; 

// date_default_timezone_set("Asia/Kolkata");
//Main Stuff
    //Main cal invite for registraion
        function sendIcalEvent_IST($from_name, $from_address, $to_name, $to_address, $startTime, $endTime, $subject, $description, $timeslot_location,$emailbox,$ref_id,$assoc_id)
        {  

              //$text = "$ref_id - $assoc_id - $assoc_name "; 
           $text = "https://bookmyevent.cerner.com/BME/associate_attend.php?uid=$ref_id&assoc_id=$assoc_id"; 

           $path = 'images/'; 
        $file = $path.uniqid().".png"; 

        $ecc = 'S'; 
        $pixel_Size = 5; 
        $frame_Size = 5; 

        // Generates QR Code and Stores it in directory given 
        QRcode::png($text, $file, $ecc, $pixel_Size, $frame_size); 
          //echo "Inside function\n";
            $domain = 'cerner.com';
            $uid=date("Ymd\TGis", strtotime($startTime)).rand()."@".$domain;   

            //Create Email Headers
            // $mime_boundary = "----Event Booking----".MD5(TIME());
            //
            // $headers = "From: ".$from_name." <".$from_address.">\n";
            // $headers .= "Reply-To: ".$from_name." <".$from_address.">\n";
            // $headers .= "MIME-Version: 1.0\n";
            // $headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
            // $headers .= "Content-class: urn:content-classes:calendarmessage\n";

            //Create Email Body (HTML)
            // $message = "--$mime_boundary\r\n";
            // $message .= "Content-Type: text/html; charset=UTF-8\n";
            // $message .= "Content-Transfer-Encoding: 8bit\n\n";
            $message = "<html>\n";
            $message .= "<body>\n";
            $message .= '<p>Greetings '.$to_name.', <br/> '.$description.'
            <br/>  
            <br/>  
            <br/>  
             You can also cancel this registration, Please click <a href="https://bookmyevent.cerner.com/BME/myprofile.php">here</a> 
        <br/>
        <br/>
        Regards,
                    <br/>Cerner Events	</p>';

            $message .= "</body>\n";
            $message .= "</html>\n";
            // $message .= "--$mime_boundary\r\n";

            $ical = 'BEGIN:VCALENDAR' . "\r\n" .
            'PRODID:-//Microsoft Corporation//Outlook 10.0 MIMEDIR//EN' . "\r\n" .
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
            'SEQUENCE:1'. "\r\n" .
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

            include_once '../PHPMailer/PHPMailerAutoload.php';
            $mail = new PHPMailer;
            $mail->addCustomHeader('MIME-version',"1.0");
            $mail->addCustomHeader('Content-type',"text/calendar; name=event.ics; method=REQUEST; charset=UTF-8;");
            $mail->addCustomHeader('Content-type',"text/html; charset=UTF-8");
            $mail->addCustomHeader('Content-Transfer-Encoding',"7bit");
            $mail->addCustomHeader('X-Mailer',"Microsoft Office Outlook 12.0");
            $mail->addCustomHeader("Content-class: urn:content-classes:calendarmessage");
            // Set PHPMailer to use the sendmail transport
            $mail->IsSMTP();
            $mail->Host="smtplb.cerner.com";
            // $mail->isSendmail();
            $mail->SMTPAutoTLS = false;   // TO bypass the connection error(added on 2019-03-04)
            $mail->setFrom($emailbox);
            $mail->addAddress($to_address);
            $mail->Subject = $subject;
            $mail->Body=$message;
            $mail->Ical = $ical;
            // $mail->msgHTML(file_get_contents('template.html'), dirname(__FILE__));

            $mail->AltBody = 'Test';
            //Attach an image file

            //send the message, check for errors
            if(!$mail->send())
            {
              echo "Mailer Error: " . $mail->ErrorInfo;
            }
            else {
              return $uid;
              echo "Invite sent\n";
            }

            // $mailsent = mail($to_address, $subject, $message, $headers);
            //
            //return ($mailsent)?($uid):(NULL);
        }
        function template($arr)
        {
          //To record the output of this page ob_start() & ob_get_contents() are used
          ob_start(); // Start output buffering
          $assoc_name=$arr['assoc_name'];
           $assoc_id=$arr['assoc_id'];
          $timeslot=$arr['timeslot'];
          $event_name=$arr['event_name'];
          //$session_name=$arr['session_name'];
            $location=$arr['location'];
            $ref_id=$arr['ref_id'];
                $qrimage=$arr['qrimage'];
        $confirm_email=$arr['confirm_email'];
        $qrcode_status=$arr['qrcode_status'];
        $file_loc=$arr['file_loc'];
        $country=$arr['country'];
           ?>
<?php

           //$text = "$ref_id - $assoc_id - $assoc_name "; 
           $text = "https://bookmyevent.cerner.com/BME/associate_attend.php?uid=$ref_id&assoc_id=$assoc_id"; 

           $path = 'images/'; 
        $file = $path.uniqid().".png"; 

        $ecc = 'S'; 
        $pixel_Size = 5; 
        $frame_Size = 5; 

        // Generates QR Code and Stores it in directory given 
        QRcode::png($text, $file, $ecc, $pixel_Size, $frame_size); 



           ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">

<head>
    <!--[if gte mso 9]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]-->
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <meta content="width=device-width" name="viewport" />
    <!--[if !mso]><!-->
    <meta content="IE=edge" http-equiv="X-UA-Compatible" />
    <!--<![endif]-->
    <title></title>
    <!--[if !mso]><!-->
    <link href="https://fonts.googleapis.com/css?family=Abril+Fatface" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css" />
    <!--<![endif]-->
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
        }

        table,
        td,
        tr {
            vertical-align: top;
            border-collapse: collapse;
        }

        * {
            line-height: inherit;
        }

        a[x-apple-data-detectors=true] {
            color: inherit !important;
            text-decoration: none !important;
        }

    </style>
    <style id="media-query" type="text/css">
        @media (max-width: 620px) {

            .block-grid,
            .col {
                min-width: 400px !important;
                max-width: 100% !important;
                display: block !important;
            }

            .block-grid {
                width: 100% !important;
            }

            .col {
                width: 100% !important;
            }

            .col>div {
                margin: 0 auto;
            }

            img.fullwidth,
            img.fullwidthOnMobile {
                max-width: 100% !important;
            }

            .no-stack .col {
                min-width: 0 !important;
                display: table-cell !important;
            }

            .no-stack.two-up .col {
                width: 50% !important;
            }

            .no-stack .col.num4 {
                width: 33% !important;
            }

            .no-stack .col.num8 {
                width: 66% !important;
            }

            .no-stack .col.num4 {
                width: 33% !important;
            }

            .no-stack .col.num3 {
                width: 25% !important;
            }

            .no-stack .col.num6 {
                width: 50% !important;
            }

            .no-stack .col.num9 {
                width: 75% !important;
            }

            .video-block {
                max-width: none !important;
            }

            .mobile_hide {
                min-height: 0px;
                max-height: 0px;
                max-width: 0px;
                display: none;
                overflow: hidden;
                font-size: 0px;
            }

            .desktop_hide {
                display: block !important;
                max-height: none !important;
            }
        }

    </style>
</head>

<body class="clean-body" style="margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #ffffff;">
    <!--[if IE]><div class="ie-browser"><![endif]-->
    <table bgcolor="#ffffff" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="table-layout: fixed; vertical-align: top; min-width: 400px; Margin: 0 auto; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; width: 100%;" valign="top" width="100%">
        <tbody>
            <tr style="vertical-align: top;" valign="top">
                <td style="word-break: break-word; vertical-align: top;" valign="top">
                    <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td align="center" style="background-color:#ffffff"><![endif]-->
                    <div style="background-color:transparent;">
                        <div class="block-grid" style="Margin: 0 auto; min-width: 400px; max-width: 700px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #E9EAEB;">
                            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#E9EAEB;">
                                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:700px"><tr class="layout-full-width" style="background-color:#ffffff"><![endif]-->
                                <!--[if (mso)|(IE)]><td align="center" width="600" style="background-color:#ffffff;width:700px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
                                <div class="col num12" style="min-width: 400px; max-width: 700px; display: table-cell; vertical-align: top; width: 700px;">
                                    <div style="width:100% !important;">
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                                            <!--<![endif]-->

                                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top: 0px; padding-bottom: 0px; font-family: Arial, sans-serif"><![endif]-->
                                            <!--
                                                    <div style="color:#000000;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;">
                                                        <div style="line-height: 1.2; font-size: 12px; color: #000000; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;"><br />
                                                            <p style="font-size: 24px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 29px; margin: 0;"><span style="font-size: 24px;"><strong>Event Name</strong></span></p>
                                                        </div>
                                                    </div>
        -->

                                            <!--[if mso]></td></tr></table><![endif]-->

                                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 40px; padding-left: 40px; padding-top: 10px; padding-bottom: 10px; font-family: Arial, sans-serif"><![endif]-->
                                            <div style="color:#555555;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.5;padding-top:10px;padding-right:40px;padding-bottom:10px;padding-left:40px;">
                                                <div style="line-height: 1.5; font-size: 12px; color: #555555; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 18px;">
                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;">Dear <?php echo $assoc_name; ?>, <br /><br /><?php echo $confirm_email; ?>.</span></p>
                                                    <br />
                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;"><b>Lets’s meet on:</b> <?php echo $timeslot; ?></span></p>
                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;"><b>Venue:</b> <?php echo $location; ?> - <?php echo $country; ?></span></p>
                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;">Please carry the below QR code to the event</span></p>


                                                </div>
                                            </div>
                                            <div align="center" class="img-container center fixedwidth" style="padding-right: 0px;padding-left: 0px;">
                                                <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px"><td style="padding-right: 0px;padding-left: 0px;" align="center"><![endif]-->
                                                <div style="font-size:1px;line-height:20px"> </div><img align="center" alt="Alternate text" border="0" class="center fixedwidth" src="<?php echo $file; ?>" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; width: 100%; max-width: 330px; display: block;" title="Alternate text" width="330" />
                                                <div style="font-size:1px;line-height:20px"> </div>
                                                <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;">You can also cancel this registration, Please click <a href="https://bookmyevent.cerner.com/BME/myprofile.php">here</a>.</span></p>
                                                <!--[if mso]></td></tr></table><![endif]-->
                                            </div>
                                            <!--[if mso]></td></tr></table><![endif]-->
                                            <!--[if (!mso)&(!IE)]><!-->
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                            </div>
                        </div>
                    </div>
                    <div style="background-color:transparent;">
                        <div class="block-grid" style="Margin: 0 auto; min-width: 400px; max-width: 700px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #E9EAEB;">
                            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#E9EAEB;">
                                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:700px"><tr class="layout-full-width" style="background-color:#ffffff"><![endif]-->
                                <!--[if (mso)|(IE)]><td align="center" width="600" style="background-color:#ffffff;width:700px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
                                <div class="col num12" style="min-width: 400px; max-width: 700px; display: table-cell; vertical-align: top; width: 700px;">
                                    <div style="width:100% !important;">
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                                            <!--<![endif]-->
                                            <div align="center" class="img-container center fixedwidth" style="padding-right: 5px;padding-left: 5px;">
                                                <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px"><td style="padding-right: 5px;padding-left: 5px;" align="center"><![endif]-->
                                                <div style="font-size:1px;line-height:10px"> </div><a href="#" style="outline:none" tabindex="-1" target="_blank"> <img align="center" alt="Your Logo" border="0" class="center fixedwidth" src="BME_sse.png" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; width: 100%; max-width: 200px; display: block;" title="Your Logo" width="200" /></a>
                                                <div style="font-size:1px;line-height:10px"> </div>
                                                <!--[if mso]></td></tr></table><![endif]-->
                                            </div>
                                            <div style="font-size:16px;text-align:center;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif">
                                                <div style="height-top: 20px;"> </div>
                                            </div>
                                            <!--[if (!mso)&(!IE)]><!-->
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                            </div>
                        </div>
                    </div>
                    <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                </td>
            </tr>
        </tbody>
    </table>
    <!--[if (IE)]></div><![endif]-->
</body>

</html>
<?php
          file_put_contents('template1.html', ob_get_clean());// Store the contents into the specified file "here it is Demo1.html"
          ob_end_flush(); // Flush the output buffer and turn off output buffering
        }
        //for waitlist associates
        function template_wait($arr)
        {
          //To record the output of this page ob_start() & ob_get_contents() are used
          ob_start(); // Start output buffering
          $assoc_name=$arr['assoc_name'];
          $timeslot=$arr['timeslot'];
          $event_name=$arr['event_name'];
            $location=$arr['location'];
            $wait_num=$arr['wait_num'];
           ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">

<head>
    <!--[if gte mso 9]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]-->
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <meta content="width=device-width" name="viewport" />
    <!--[if !mso]><!-->
    <meta content="IE=edge" http-equiv="X-UA-Compatible" />
    <!--<![endif]-->
    <title></title>
    <!--[if !mso]><!-->
    <link href="https://fonts.googleapis.com/css?family=Abril+Fatface" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css" />
    <!--<![endif]-->
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
        }

        table,
        td,
        tr {
            vertical-align: top;
            border-collapse: collapse;
        }

        * {
            line-height: inherit;
        }

        a[x-apple-data-detectors=true] {
            color: inherit !important;
            text-decoration: none !important;
        }

    </style>
    <style id="media-query" type="text/css">
        @media (max-width: 620px) {

            .block-grid,
            .col {
                min-width: 400px !important;
                max-width: 100% !important;
                display: block !important;
            }

            .block-grid {
                width: 100% !important;
            }

            .col {
                width: 100% !important;
            }

            .col>div {
                margin: 0 auto;
            }

            img.fullwidth,
            img.fullwidthOnMobile {
                max-width: 100% !important;
            }

            .no-stack .col {
                min-width: 0 !important;
                display: table-cell !important;
            }

            .no-stack.two-up .col {
                width: 50% !important;
            }

            .no-stack .col.num4 {
                width: 33% !important;
            }

            .no-stack .col.num8 {
                width: 66% !important;
            }

            .no-stack .col.num4 {
                width: 33% !important;
            }

            .no-stack .col.num3 {
                width: 25% !important;
            }

            .no-stack .col.num6 {
                width: 50% !important;
            }

            .no-stack .col.num9 {
                width: 75% !important;
            }

            .video-block {
                max-width: none !important;
            }

            .mobile_hide {
                min-height: 0px;
                max-height: 0px;
                max-width: 0px;
                display: none;
                overflow: hidden;
                font-size: 0px;
            }

            .desktop_hide {
                display: block !important;
                max-height: none !important;
            }
        }

    </style>
</head>

<body class="clean-body" style="margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #ffffff;">
    <!--[if IE]><div class="ie-browser"><![endif]-->
    <table bgcolor="#ffffff" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="table-layout: fixed; vertical-align: top; min-width: 400px; Margin: 0 auto; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; width: 100%;" valign="top" width="100%">
        <tbody>
            <tr style="vertical-align: top;" valign="top">
                <td style="word-break: break-word; vertical-align: top;" valign="top">
                    <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td align="center" style="background-color:#ffffff"><![endif]-->
                    <div style="background-color:transparent;">
                        <div class="block-grid" style="Margin: 0 auto; min-width: 400px; max-width: 700px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #E9EAEB;">
                            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#E9EAEB;">
                                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:700px"><tr class="layout-full-width" style="background-color:#ffffff"><![endif]-->
                                <!--[if (mso)|(IE)]><td align="center" width="600" style="background-color:#ffffff;width:700px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
                                <div class="col num12" style="min-width: 400px; max-width: 700px; display: table-cell; vertical-align: top; width: 700px;">
                                    <div style="width:100% !important;">
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                                            <!--<![endif]-->

                                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top: 0px; padding-bottom: 0px; font-family: Arial, sans-serif"><![endif]-->
                                            <!--
                                                    <div style="color:#000000;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;">
                                                        <div style="line-height: 1.2; font-size: 12px; color: #000000; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;"><br />
                                                            <p style="font-size: 24px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 29px; margin: 0;"><span style="font-size: 24px;"><strong>Event Name</strong></span></p>
                                                        </div>
                                                    </div>
        -->

                                            <!--[if mso]></td></tr></table><![endif]-->

                                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 40px; padding-left: 40px; padding-top: 10px; padding-bottom: 10px; font-family: Arial, sans-serif"><![endif]-->
                                            <div style="color:#555555;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.5;padding-top:10px;padding-right:40px;padding-bottom:10px;padding-left:40px;">
                                                <div style="line-height: 1.5; font-size: 12px; color: #555555; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 18px;">
                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;">Dear <?php echo $assoc_name; ?>,<br /></span></p>
                                                    <br />
                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;">Thank you for registering for <?php echo $event_name; ?></b></span></p>
                                                    <br />
                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;"><b>Time Slot:<b> <?php echo $timeslot; ?></span></p>

                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;">You are Waitlisted. We will notify you once your registration is confirmed.</span></p>

                                                    <br />
                                                </div>
                                            </div>
                                            <!--[if mso]></td></tr></table><![endif]-->
                                            <!--[if (!mso)&(!IE)]><!-->
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                            </div>
                        </div>
                    </div>
                    <div style="background-color:transparent;">
                        <div class="block-grid" style="Margin: 0 auto; min-width: 400px; max-width: 700px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #E9EAEB;">
                            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#E9EAEB;">
                                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:700px"><tr class="layout-full-width" style="background-color:#ffffff"><![endif]-->
                                <!--[if (mso)|(IE)]><td align="center" width="600" style="background-color:#ffffff;width:700px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
                                <div class="col num12" style="min-width: 400px; max-width: 700px; display: table-cell; vertical-align: top; width: 700px;">
                                    <div style="width:100% !important;">
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                                            <!--<![endif]-->
                                            <div align="center" class="img-container center fixedwidth" style="padding-right: 5px;padding-left: 5px;">
                                                <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px"><td style="padding-right: 5px;padding-left: 5px;" align="center"><![endif]-->
                                                <div style="font-size:1px;line-height:10px"> </div><a href="#" style="outline:none" tabindex="-1" target="_blank"> <img align="center" alt="Your Logo" border="0" class="center fixedwidth" src="BME_sse.png" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; width: 100%; max-width: 200px; display: block;" title="Your Logo" width="200" /></a>
                                                <div style="font-size:1px;line-height:10px"> </div>
                                                <!--[if mso]></td></tr></table><![endif]-->
                                            </div>
                                            <div style="font-size:16px;text-align:center;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif">
                                                <div style="height-top: 20px;"> </div>
                                            </div>
                                            <!--[if (!mso)&(!IE)]><!-->
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                            </div>
                        </div>
                    </div>
                    <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                </td>
            </tr>
        </tbody>
    </table>
    <!--[if (IE)]></div><![endif]-->
</body>

</html>
<?php
          file_put_contents('template1.html', ob_get_clean());// Store the contents into the specified file "here it is Demo1.html"
          ob_end_flush(); // Flush the output buffer and turn off output buffering
        }
        function send_mail($manager_email,$email,$event_name,$emailbox)
        {
          include_once '../PHPMailer/PHPMailerAutoload.php';
          $mail = new PHPMailer;
          $mail->CharSet = 'utf-8';
          // Set PHPMailer to use the sendmail transport
          $mail->IsSMTP();
          $mail->Host="smtplb.cerner.com";
          // $mail->isSendmail();
            $mail->SMTPAutoTLS = false;   // TO bypass the connection error(added on 2019-03-04)
          $mail->setFrom($emailbox);
          $mail->addAddress($email);
         // $mail->addCC($manager_email);

          $mail->Subject = $event_name;
          $mail->msgHTML(file_get_contents('template1.html'), dirname(__FILE__));
          // $mail->AddAttachment("cts_expo1.ics");
          //Replace the plain text body with one created manually
          $mail->AltBody = $event_name;
          //Attach an image file

          //send the message, check for errors
          if(!$mail->send())
          {
            echo "Mailer Error: " . $mail->ErrorInfo;
          }
          else {
           //echo "Template sent\n";
          }

        }
    //End Main cal invite for registraion

    function template_reminder($arr)
    {
      //To record the output of this page ob_start() & ob_get_contents() are used
      ob_start(); // Start output buffering
      $assoc_name=$arr['assoc_name'];
       $assoc_id=$arr['assoc_id'];
      $timeslot=$arr['timeslot'];
      $event_name=$arr['event_name'];
        $location=$arr['location'];
        $ref_id=$arr['ref_id'];
            $qrimage=$arr['qrimage'];

       ?>
<?php
       $text = "https://bookmyevent.cerner.com/BME/associate_attend.php?uid=$ref_id&assoc_id=$assoc_id"; 
       $path = 'images/'; 
    $file = $path.uniqid().".png"; 

    $ecc = 'S'; 
    $pixel_Size = 10; 
    $frame_Size = 10; 

    // Generates QR Code and Stores it in directory given 
    QRcode::png($text, $file, $ecc, $pixel_Size, $frame_size); 



       ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">

<head>
    <!--[if gte mso 9]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]-->
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <meta content="width=device-width" name="viewport" />
    <!--[if !mso]><!-->
    <meta content="IE=edge" http-equiv="X-UA-Compatible" />
    <!--<![endif]-->
    <title></title>
    <!--[if !mso]><!-->
    <link href="https://fonts.googleapis.com/css?family=Abril+Fatface" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css" />
    <!--<![endif]-->
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
        }

        table,
        td,
        tr {
            vertical-align: top;
            border-collapse: collapse;
        }

        * {
            line-height: inherit;
        }

        a[x-apple-data-detectors=true] {
            color: inherit !important;
            text-decoration: none !important;
        }

    </style>
    <style id="media-query" type="text/css">
        @media (max-width: 620px) {

            .block-grid,
            .col {
                min-width: 400px !important;
                max-width: 100% !important;
                display: block !important;
            }

            .block-grid {
                width: 100% !important;
            }

            .col {
                width: 100% !important;
            }

            .col>div {
                margin: 0 auto;
            }

            img.fullwidth,
            img.fullwidthOnMobile {
                max-width: 100% !important;
            }

            .no-stack .col {
                min-width: 0 !important;
                display: table-cell !important;
            }

            .no-stack.two-up .col {
                width: 50% !important;
            }

            .no-stack .col.num4 {
                width: 33% !important;
            }

            .no-stack .col.num8 {
                width: 66% !important;
            }

            .no-stack .col.num4 {
                width: 33% !important;
            }

            .no-stack .col.num3 {
                width: 25% !important;
            }

            .no-stack .col.num6 {
                width: 50% !important;
            }

            .no-stack .col.num9 {
                width: 75% !important;
            }

            .video-block {
                max-width: none !important;
            }

            .mobile_hide {
                min-height: 0px;
                max-height: 0px;
                max-width: 0px;
                display: none;
                overflow: hidden;
                font-size: 0px;
            }

            .desktop_hide {
                display: block !important;
                max-height: none !important;
            }
        }

    </style>
</head>

<body class="clean-body" style="margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #ffffff;">
    <!--[if IE]><div class="ie-browser"><![endif]-->
    <table bgcolor="#ffffff" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="table-layout: fixed; vertical-align: top; min-width: 400px; Margin: 0 auto; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; width: 100%;" valign="top" width="100%">
        <tbody>
            <tr style="vertical-align: top;" valign="top">
                <td style="word-break: break-word; vertical-align: top;" valign="top">
                    <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td align="center" style="background-color:#ffffff"><![endif]-->
                    <div style="background-color:transparent;">
                        <div class="block-grid" style="Margin: 0 auto; min-width: 400px; max-width: 700px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #E9EAEB;">
                            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#E9EAEB;">
                                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:700px"><tr class="layout-full-width" style="background-color:#ffffff"><![endif]-->
                                <!--[if (mso)|(IE)]><td align="center" width="600" style="background-color:#ffffff;width:700px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
                                <div class="col num12" style="min-width: 400px; max-width: 700px; display: table-cell; vertical-align: top; width: 700px;">
                                    <div style="width:100% !important;">
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                                            <!--<![endif]-->

                                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top: 0px; padding-bottom: 0px; font-family: Arial, sans-serif"><![endif]-->
                                            <!--
                                                    <div style="color:#000000;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;">
                                                        <div style="line-height: 1.2; font-size: 12px; color: #000000; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;"><br />
                                                            <p style="font-size: 24px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 29px; margin: 0;"><span style="font-size: 24px;"><strong>Event Name</strong></span></p>
                                                        </div>
                                                    </div>
        -->

                                            <!--[if mso]></td></tr></table><![endif]-->

                                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 40px; padding-left: 40px; padding-top: 10px; padding-bottom: 10px; font-family: Arial, sans-serif"><![endif]-->
                                            <div style="color:#555555;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.5;padding-top:10px;padding-right:40px;padding-bottom:10px;padding-left:40px;">
                                                <div style="line-height: 1.5; font-size: 12px; color: #555555; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 18px;">
                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;">Dear <?php echo $assoc_name; ?>,<br /></span></p>
                                                    <br />
                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;">This is a reminder mail for the event - <b><?php echo $event_name; ?></b></span></p>
                                                    <br />
                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;"><b>Lets’s meet on:<b> <?php echo $timeslot; ?></span></p>

                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;"><b>Venue:</b> <?php echo $location; ?></span></p>

                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;">Please carry the below QR code to the event</span></p>

                                                    <br />
                                                </div>
                                            </div>
                                            <div align="center" class="img-container center fixedwidth" style="padding-right: 0px;padding-left: 0px;">
                                                <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px"><td style="padding-right: 0px;padding-left: 0px;" align="center"><![endif]-->
                                                <div style="font-size:1px;line-height:20px"> </div><img align="center" alt="Alternate text" border="0" class="center fixedwidth" src="<?php echo $file; ?>" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; width: 100%; max-width: 330px; display: block;" title="Alternate text" width="330" />
                                                <div style="font-size:1px;line-height:20px"> </div>
                                                <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;">You can also cancel this registration, Please click <a href="https://bookmyevent.cerner.com/BME/myprofile.php">here</a>.</span></p>
                                                <!--[if mso]></td></tr></table><![endif]-->
                                            </div>
                                            <!--[if mso]></td></tr></table><![endif]-->
                                            <!--[if (!mso)&(!IE)]><!-->
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                            </div>
                        </div>
                    </div>
                    <div style="background-color:transparent;">
                        <div class="block-grid" style="Margin: 0 auto; min-width: 400px; max-width: 700px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #E9EAEB;">
                            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#E9EAEB;">
                                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:700px"><tr class="layout-full-width" style="background-color:#ffffff"><![endif]-->
                                <!--[if (mso)|(IE)]><td align="center" width="600" style="background-color:#ffffff;width:700px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
                                <div class="col num12" style="min-width: 400px; max-width: 700px; display: table-cell; vertical-align: top; width: 700px;">
                                    <div style="width:100% !important;">
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                                            <!--<![endif]-->
                                            <div align="center" class="img-container center fixedwidth" style="padding-right: 5px;padding-left: 5px;">
                                                <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px"><td style="padding-right: 5px;padding-left: 5px;" align="center"><![endif]-->
                                                <div style="font-size:1px;line-height:10px"> </div><a href="#" style="outline:none" tabindex="-1" target="_blank"> <img align="center" alt="Your Logo" border="0" class="center fixedwidth" src="BME_sse.png" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; width: 100%; max-width: 200px; display: block;" title="Your Logo" width="200" /></a>
                                                <div style="font-size:1px;line-height:10px"> </div>
                                                <!--[if mso]></td></tr></table><![endif]-->
                                            </div>
                                            <div style="font-size:16px;text-align:center;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif">
                                                <div style="height-top: 20px;"> </div>
                                            </div>
                                            <!--[if (!mso)&(!IE)]><!-->
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                            </div>
                        </div>
                    </div>
                    <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                </td>
            </tr>
        </tbody>
    </table>
    <!--[if (IE)]></div><![endif]-->
</body>

</html>
<?php
      file_put_contents('template1.html', ob_get_clean());// Store the contents into the specified file "here it is Demo1.html"
      ob_end_flush(); // Flush the output buffer and turn off output buffering
    }

    //updating Event
        function template_updateevent($arr)
        {
          //To record the output of this page ob_start() & ob_get_contents() are used
          ob_start(); // Start output buffering

          $email=$arr['email'];
          $event_name=$arr['event_name'];
            $location=$arr['location'];
            $change_atttribute=$arr['change_atttribute'];
        $event_date=$arr['event_date'];
           ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">

<head>
    <!--[if gte mso 9]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]-->
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <meta content="width=device-width" name="viewport" />
    <!--[if !mso]><!-->
    <meta content="IE=edge" http-equiv="X-UA-Compatible" />
    <!--<![endif]-->
    <title></title>
    <!--[if !mso]><!-->
    <link href="https://fonts.googleapis.com/css?family=Abril+Fatface" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css" />
    <!--<![endif]-->
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
        }

        table,
        td,
        tr {
            vertical-align: top;
            border-collapse: collapse;
        }

        * {
            line-height: inherit;
        }

        a[x-apple-data-detectors=true] {
            color: inherit !important;
            text-decoration: none !important;
        }

    </style>
    <style id="media-query" type="text/css">
        @media (max-width: 620px) {

            .block-grid,
            .col {
                min-width: 400px !important;
                max-width: 100% !important;
                display: block !important;
            }

            .block-grid {
                width: 100% !important;
            }

            .col {
                width: 100% !important;
            }

            .col>div {
                margin: 0 auto;
            }

            img.fullwidth,
            img.fullwidthOnMobile {
                max-width: 100% !important;
            }

            .no-stack .col {
                min-width: 0 !important;
                display: table-cell !important;
            }

            .no-stack.two-up .col {
                width: 50% !important;
            }

            .no-stack .col.num4 {
                width: 33% !important;
            }

            .no-stack .col.num8 {
                width: 66% !important;
            }

            .no-stack .col.num4 {
                width: 33% !important;
            }

            .no-stack .col.num3 {
                width: 25% !important;
            }

            .no-stack .col.num6 {
                width: 50% !important;
            }

            .no-stack .col.num9 {
                width: 75% !important;
            }

            .video-block {
                max-width: none !important;
            }

            .mobile_hide {
                min-height: 0px;
                max-height: 0px;
                max-width: 0px;
                display: none;
                overflow: hidden;
                font-size: 0px;
            }

            .desktop_hide {
                display: block !important;
                max-height: none !important;
            }
        }

    </style>
</head>

<body class="clean-body" style="margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #ffffff;">
    <!--[if IE]><div class="ie-browser"><![endif]-->
    <table bgcolor="#ffffff" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="table-layout: fixed; vertical-align: top; min-width: 400px; Margin: 0 auto; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; width: 100%;" valign="top" width="100%">
        <tbody>
            <tr style="vertical-align: top;" valign="top">
                <td style="word-break: break-word; vertical-align: top;" valign="top">
                    <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td align="center" style="background-color:#ffffff"><![endif]-->
                    <div style="background-color:transparent;">
                        <div class="block-grid" style="Margin: 0 auto; min-width: 400px; max-width: 700px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #E9EAEB;">
                            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#E9EAEB;">
                                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:700px"><tr class="layout-full-width" style="background-color:#ffffff"><![endif]-->
                                <!--[if (mso)|(IE)]><td align="center" width="600" style="background-color:#ffffff;width:700px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
                                <div class="col num12" style="min-width: 400px; max-width: 700px; display: table-cell; vertical-align: top; width: 700px;">
                                    <div style="width:100% !important;">
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                                            <!--<![endif]-->

                                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top: 0px; padding-bottom: 0px; font-family: Arial, sans-serif"><![endif]-->
                                            <!--
                                                    <div style="color:#000000;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;">
                                                        <div style="line-height: 1.2; font-size: 12px; color: #000000; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;"><br />
                                                            <p style="font-size: 24px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 29px; margin: 0;"><span style="font-size: 24px;"><strong>Event Name</strong></span></p>
                                                        </div>
                                                    </div>
        -->

                                            <!--[if mso]></td></tr></table><![endif]-->

                                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 40px; padding-left: 40px; padding-top: 10px; padding-bottom: 10px; font-family: Arial, sans-serif"><![endif]-->
                                            <div style="color:#555555;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.5;padding-top:10px;padding-right:40px;padding-bottom:10px;padding-left:40px;">
                                                <div style="line-height: 1.5; font-size: 12px; color: #555555; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 18px;">
                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;">Dear Associate,<br /></span></p>
                                                    <br />
                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;">There are some changes in <?php echo $change_atttribute;  ?> of the event <?php echo $event_name;  ?></span></p>
                                                    <br />
                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;"><b>Event Date:</b> <?php echo $event_date; ?></span></p>

                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;"><b>Location:</b> <?php echo $location; ?></span></p>

                                                    <br />
                                                </div>
                                            </div>
                                            <!--[if mso]></td></tr></table><![endif]-->
                                            <!--[if (!mso)&(!IE)]><!-->
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                            </div>
                        </div>
                    </div>
                    <div style="background-color:transparent;">
                        <div class="block-grid" style="Margin: 0 auto; min-width: 400px; max-width: 700px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #E9EAEB;">
                            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#E9EAEB;">
                                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:700px"><tr class="layout-full-width" style="background-color:#ffffff"><![endif]-->
                                <!--[if (mso)|(IE)]><td align="center" width="600" style="background-color:#ffffff;width:700px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
                                <div class="col num12" style="min-width: 400px; max-width: 700px; display: table-cell; vertical-align: top; width: 700px;">
                                    <div style="width:100% !important;">
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                                            <!--<![endif]-->
                                            <div align="center" class="img-container center fixedwidth" style="padding-right: 5px;padding-left: 5px;">
                                                <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px"><td style="padding-right: 5px;padding-left: 5px;" align="center"><![endif]-->
                                                <div style="font-size:1px;line-height:10px"> </div><a href="#" style="outline:none" tabindex="-1" target="_blank"> <img align="center" alt="Your Logo" border="0" class="center fixedwidth" src="BME_sse.png" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; width: 100%; max-width: 200px; display: block;" title="Your Logo" width="200" /></a>
                                                <div style="font-size:1px;line-height:10px"> </div>
                                                <!--[if mso]></td></tr></table><![endif]-->
                                            </div>
                                            <div style="font-size:16px;text-align:center;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif">
                                                <div style="height-top: 20px;"> </div>
                                            </div>
                                            <!--[if (!mso)&(!IE)]><!-->
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                            </div>
                        </div>
                    </div>
                    <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                </td>
            </tr>
        </tbody>
    </table>
    <!--[if (IE)]></div><![endif]-->
</body>

</html>
<?php
          file_put_contents('template1.html', ob_get_clean());// Store the contents into the specified file "here it is Demo1.html"
          ob_end_flush(); // Flush the output buffer and turn off output buffering
        }

        function send_mail_updateevent($assoc_email,$event_name)
        {
          include_once '../PHPMailer/PHPMailerAutoload.php';
          $mail = new PHPMailer;
          $mail->CharSet = 'utf-8';
          // Set PHPMailer to use the sendmail transport
          $mail->IsSMTP();
          $mail->Host="smtplb.cerner.com";
          // $mail->isSendmail();
            $mail->SMTPAutoTLS = false;   // TO bypass the connection error(added on 2019-03-04)
          $mail->setFrom('BookMyEvent@cerner.com');
          $mail->addAddress($assoc_email);
         // $mail->addCC($manager_email);

          $mail->Subject = $event_name;
          $mail->msgHTML(file_get_contents('template1.html'), dirname(__FILE__));
          // $mail->AddAttachment("cts_expo1.ics");
          //Replace the plain text body with one created manually
          $mail->AltBody = $event_name;
          //Attach an image file

          //send the message, check for errors
          if(!$mail->send())
          {
            echo "Mailer Error: " . $mail->ErrorInfo;
          }
          else {
               header("location:myprofile.php?exist1=Mails sent");
          }

        }
    //End updating Event
//Main Stuff

//Request
    //Request Access
        function template_access_associate($arr)
        {
          //To record the output of this page ob_start() & ob_get_contents() are used
          ob_start(); // Start output buffering


         $assoc_id= $arr['assoc_id'];
              $assoc_name=$arr['assoc_name'];
         $assoc_email=$arr['assoc_email'];
          $fromdate_final=$arr['fromdate_final'];
          $todate_final= $arr['todate_final'];
          $justification= $arr['justification'];


           ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">

<head>
    <!--[if gte mso 9]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]-->
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <meta content="width=device-width" name="viewport" />
    <!--[if !mso]><!-->
    <meta content="IE=edge" http-equiv="X-UA-Compatible" />
    <!--<![endif]-->
    <title></title>
    <!--[if !mso]><!-->
    <link href="https://fonts.googleapis.com/css?family=Abril+Fatface" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css" />
    <!--<![endif]-->
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
        }

        table,
        td,
        tr {
            vertical-align: top;
            border-collapse: collapse;
        }

        * {
            line-height: inherit;
        }

        a[x-apple-data-detectors=true] {
            color: inherit !important;
            text-decoration: none !important;
        }

    </style>
    <style id="media-query" type="text/css">
        @media (max-width: 620px) {

            .block-grid,
            .col {
                min-width: 400px !important;
                max-width: 100% !important;
                display: block !important;
            }

            .block-grid {
                width: 100% !important;
            }

            .col {
                width: 100% !important;
            }

            .col>div {
                margin: 0 auto;
            }

            img.fullwidth,
            img.fullwidthOnMobile {
                max-width: 100% !important;
            }

            .no-stack .col {
                min-width: 0 !important;
                display: table-cell !important;
            }

            .no-stack.two-up .col {
                width: 50% !important;
            }

            .no-stack .col.num4 {
                width: 33% !important;
            }

            .no-stack .col.num8 {
                width: 66% !important;
            }

            .no-stack .col.num4 {
                width: 33% !important;
            }

            .no-stack .col.num3 {
                width: 25% !important;
            }

            .no-stack .col.num6 {
                width: 50% !important;
            }

            .no-stack .col.num9 {
                width: 75% !important;
            }

            .video-block {
                max-width: none !important;
            }

            .mobile_hide {
                min-height: 0px;
                max-height: 0px;
                max-width: 0px;
                display: none;
                overflow: hidden;
                font-size: 0px;
            }

            .desktop_hide {
                display: block !important;
                max-height: none !important;
            }
        }

    </style>
</head>

<body class="clean-body" style="margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #ffffff;">
    <!--[if IE]><div class="ie-browser"><![endif]-->
    <table bgcolor="#ffffff" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="table-layout: fixed; vertical-align: top; min-width: 400px; Margin: 0 auto; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; width: 100%;" valign="top" width="100%">
        <tbody>
            <tr style="vertical-align: top;" valign="top">
                <td style="word-break: break-word; vertical-align: top;" valign="top">
                    <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td align="center" style="background-color:#ffffff"><![endif]-->
                    <div style="background-color:transparent;">
                        <div class="block-grid" style="Margin: 0 auto; min-width: 400px; max-width: 700px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #E9EAEB;">
                            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#E9EAEB;">
                                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:700px"><tr class="layout-full-width" style="background-color:#ffffff"><![endif]-->
                                <!--[if (mso)|(IE)]><td align="center" width="600" style="background-color:#ffffff;width:700px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
                                <div class="col num12" style="min-width: 400px; max-width: 700px; display: table-cell; vertical-align: top; width: 700px;">
                                    <div style="width:100% !important;">
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                                            <!--<![endif]-->

                                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top: 0px; padding-bottom: 0px; font-family: Arial, sans-serif"><![endif]-->
                                            <!--
                                                    <div style="color:#000000;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;">
                                                        <div style="line-height: 1.2; font-size: 12px; color: #000000; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;"><br />
                                                            <p style="font-size: 24px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 29px; margin: 0;"><span style="font-size: 24px;"><strong>Event Name</strong></span></p>
                                                        </div>
                                                    </div>
        -->

                                            <!--[if mso]></td></tr></table><![endif]-->

                                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 40px; padding-left: 40px; padding-top: 10px; padding-bottom: 10px; font-family: Arial, sans-serif"><![endif]-->
                                            <div style="color:#555555;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.5;padding-top:10px;padding-right:40px;padding-bottom:10px;padding-left:40px;">
                                                <div style="line-height: 1.5; font-size: 12px; color: #555555; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 18px;">
                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;">Dear <?php echo $assoc_name; ?>,<br /></span></p>
                                                    <br />
                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;"><?php echo $assoc_name; ?> You have requested for accessing and hosting the event in BookMyEvent.</span></p>
                                                    <br />
                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;"><b>Associate ID:</b> <?php echo $assoc_id; ?></span></p>

                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;"><b>Associate Name:</b> <?php echo $assoc_name; ?></span></p>

                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;"><b>Access Dates:</b> <?php echo $fromdate_final; ?> to <?php echo $todate_final; ?> </span></p>

                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;"><b>Justification:</b> <?php echo $justification; ?> </span></p>
                                                    <br />
                                                </div>
                                            </div>

                                            <!--[if mso]></td></tr></table><![endif]-->
                                            <!--[if (!mso)&(!IE)]><!-->
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                            </div>
                        </div>
                    </div>
                    <div style="background-color:transparent;">
                        <div class="block-grid" style="Margin: 0 auto; min-width: 400px; max-width: 700px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #E9EAEB;">
                            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#E9EAEB;">
                                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:700px"><tr class="layout-full-width" style="background-color:#ffffff"><![endif]-->
                                <!--[if (mso)|(IE)]><td align="center" width="600" style="background-color:#ffffff;width:700px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
                                <div class="col num12" style="min-width: 400px; max-width: 700px; display: table-cell; vertical-align: top; width: 700px;">
                                    <div style="width:100% !important;">
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                                            <!--<![endif]-->
                                            <div align="center" class="img-container center fixedwidth" style="padding-right: 5px;padding-left: 5px;">
                                                <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px"><td style="padding-right: 5px;padding-left: 5px;" align="center"><![endif]-->
                                                <div style="font-size:1px;line-height:10px"> </div><a href="#" style="outline:none" tabindex="-1" target="_blank"> <img align="center" alt="Your Logo" border="0" class="center fixedwidth" src="BME_sse.png" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; width: 100%; max-width: 200px; display: block;" title="Your Logo" width="200" /></a>
                                                <div style="font-size:1px;line-height:10px"> </div>
                                                <!--[if mso]></td></tr></table><![endif]-->
                                            </div>
                                            <div style="font-size:16px;text-align:center;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif">
                                                <div style="height-top: 20px;"> </div>
                                            </div>
                                            <!--[if (!mso)&(!IE)]><!-->
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                            </div>
                        </div>
                    </div>
                    <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                </td>
            </tr>
        </tbody>
    </table>
    <!--[if (IE)]></div><![endif]-->
</body>

</html>

<?php
          file_put_contents('template4.html', ob_get_clean());
          ob_end_flush(); // Flush the output buffer and turn off output buffering
        }

        function template_access_team($arr)
        {
          //To record the output of this page ob_start() & ob_get_contents() are used
          ob_start(); // Start output buffering


         $assoc_id= $arr['assoc_id'];
              $assoc_name=$arr['assoc_name'];
         $assoc_email=$arr['assoc_email'];
          $fromdate_final=$arr['fromdate_final'];
          $todate_final= $arr['todate_final'];
          $justification= $arr['justification'];


           ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">

<head>
    <!--[if gte mso 9]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]-->
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <meta content="width=device-width" name="viewport" />
    <!--[if !mso]><!-->
    <meta content="IE=edge" http-equiv="X-UA-Compatible" />
    <!--<![endif]-->
    <title></title>
    <!--[if !mso]><!-->
    <link href="https://fonts.googleapis.com/css?family=Abril+Fatface" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css" />
    <!--<![endif]-->
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
        }

        table,
        td,
        tr {
            vertical-align: top;
            border-collapse: collapse;
        }

        * {
            line-height: inherit;
        }

        a[x-apple-data-detectors=true] {
            color: inherit !important;
            text-decoration: none !important;
        }

    </style>
    <style id="media-query" type="text/css">
        @media (max-width: 620px) {

            .block-grid,
            .col {
                min-width: 400px !important;
                max-width: 100% !important;
                display: block !important;
            }

            .block-grid {
                width: 100% !important;
            }

            .col {
                width: 100% !important;
            }

            .col>div {
                margin: 0 auto;
            }

            img.fullwidth,
            img.fullwidthOnMobile {
                max-width: 100% !important;
            }

            .no-stack .col {
                min-width: 0 !important;
                display: table-cell !important;
            }

            .no-stack.two-up .col {
                width: 50% !important;
            }

            .no-stack .col.num4 {
                width: 33% !important;
            }

            .no-stack .col.num8 {
                width: 66% !important;
            }

            .no-stack .col.num4 {
                width: 33% !important;
            }

            .no-stack .col.num3 {
                width: 25% !important;
            }

            .no-stack .col.num6 {
                width: 50% !important;
            }

            .no-stack .col.num9 {
                width: 75% !important;
            }

            .video-block {
                max-width: none !important;
            }

            .mobile_hide {
                min-height: 0px;
                max-height: 0px;
                max-width: 0px;
                display: none;
                overflow: hidden;
                font-size: 0px;
            }

            .desktop_hide {
                display: block !important;
                max-height: none !important;
            }
        }

    </style>
</head>

<body class="clean-body" style="margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #ffffff;">
    <!--[if IE]><div class="ie-browser"><![endif]-->
    <table bgcolor="#ffffff" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="table-layout: fixed; vertical-align: top; min-width: 400px; Margin: 0 auto; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; width: 100%;" valign="top" width="100%">
        <tbody>
            <tr style="vertical-align: top;" valign="top">
                <td style="word-break: break-word; vertical-align: top;" valign="top">
                    <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td align="center" style="background-color:#ffffff"><![endif]-->
                    <div style="background-color:transparent;">
                        <div class="block-grid" style="Margin: 0 auto; min-width: 400px; max-width: 700px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #E9EAEB;">
                            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#E9EAEB;">
                                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:700px"><tr class="layout-full-width" style="background-color:#ffffff"><![endif]-->
                                <!--[if (mso)|(IE)]><td align="center" width="600" style="background-color:#ffffff;width:700px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
                                <div class="col num12" style="min-width: 400px; max-width: 700px; display: table-cell; vertical-align: top; width: 700px;">
                                    <div style="width:100% !important;">
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                                            <!--<![endif]-->

                                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top: 0px; padding-bottom: 0px; font-family: Arial, sans-serif"><![endif]-->
                                            <!--
                                                    <div style="color:#000000;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;">
                                                        <div style="line-height: 1.2; font-size: 12px; color: #000000; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;"><br />
                                                            <p style="font-size: 24px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 29px; margin: 0;"><span style="font-size: 24px;"><strong>Event Name</strong></span></p>
                                                        </div>
                                                    </div>
        -->

                                            <!--[if mso]></td></tr></table><![endif]-->

                                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 40px; padding-left: 40px; padding-top: 10px; padding-bottom: 10px; font-family: Arial, sans-serif"><![endif]-->
                                            <div style="color:#555555;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.5;padding-top:10px;padding-right:40px;padding-bottom:10px;padding-left:40px;">
                                                <div style="line-height: 1.5; font-size: 12px; color: #555555; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 18px;">
                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;">Hi,<br /></span></p>
                                                    <br />
                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;"><?php echo $assoc_name; ?> has requested for accessing the application BookMyEvent.</span></p>
                                                    <br />
                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;"><b>Associate ID:</b> <?php echo $assoc_id; ?></span></p>

                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;"><b>Associate Name:</b> <?php echo $assoc_name; ?></span></p>

                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;"><b>Access Dates:</b> <?php echo $fromdate_final; ?> to <?php echo $todate_final; ?> </span></p>

                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;"><b>Justification:</b> <?php echo $justification; ?> </span></p>
                                                    <br />
                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;">Please click <a href="https://bookmyevent.cerner.com/BME/Request_Action.php">here</a> to approve this request.</span></p>
                                                </div>
                                            </div>

                                            <!--[if mso]></td></tr></table><![endif]-->
                                            <!--[if (!mso)&(!IE)]><!-->
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                            </div>
                        </div>
                    </div>
                    <div style="background-color:transparent;">
                        <div class="block-grid" style="Margin: 0 auto; min-width: 400px; max-width: 700px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #E9EAEB;">
                            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#E9EAEB;">
                                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:700px"><tr class="layout-full-width" style="background-color:#ffffff"><![endif]-->
                                <!--[if (mso)|(IE)]><td align="center" width="600" style="background-color:#ffffff;width:700px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
                                <div class="col num12" style="min-width: 400px; max-width: 700px; display: table-cell; vertical-align: top; width: 700px;">
                                    <div style="width:100% !important;">
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                                            <!--<![endif]-->
                                            <div align="center" class="img-container center fixedwidth" style="padding-right: 5px;padding-left: 5px;">
                                                <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px"><td style="padding-right: 5px;padding-left: 5px;" align="center"><![endif]-->
                                                <div style="font-size:1px;line-height:10px"> </div><a href="#" style="outline:none" tabindex="-1" target="_blank"> <img align="center" alt="Your Logo" border="0" class="center fixedwidth" src="BME_sse.png" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; width: 100%; max-width: 200px; display: block;" title="Your Logo" width="200" /></a>
                                                <div style="font-size:1px;line-height:10px"> </div>
                                                <!--[if mso]></td></tr></table><![endif]-->
                                            </div>
                                            <div style="font-size:16px;text-align:center;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif">
                                                <div style="height-top: 20px;"> </div>
                                            </div>
                                            <!--[if (!mso)&(!IE)]><!-->
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                            </div>
                        </div>
                    </div>
                    <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                </td>
            </tr>
        </tbody>
    </table>
    <!--[if (IE)]></div><![endif]-->
</body>

</html>
<?php
          file_put_contents('template5.html', ob_get_clean());
          ob_end_flush(); // Flush the output buffer and turn off output buffering
        }
        function send_mail_access_associate($assoc_email,$assoc_name)
        {
          include_once '../PHPMailer/PHPMailerAutoload.php';
          $mail = new PHPMailer;
          $mail->CharSet = 'utf-8';
          // Set PHPMailer to use the sendmail transport
          $mail->IsSMTP();
          $mail->Host="smtplb.cerner.com";
          // $mail->isSendmail();
            $mail->SMTPAutoTLS = false;   // TO bypass the connection error(added on 2019-03-04)
          $mail->setFrom("BookMyEvent@cerner.com");
          $mail->addAddress($assoc_email);
         // $mail->addCC($manager_email);

          $mail->Subject = "BookMyEvent Access: Pending";
          $mail->msgHTML(file_get_contents('template4.html'), dirname(__FILE__));

          $mail->AltBody = $assoc_name;

          if(!$mail->send())
          {
            echo "Mailer Error: " . $mail->ErrorInfo;
          }
          else {
           //echo "Template sent\n";
          }

        }

        function send_mail_access_team($assoc_email,$assoc_name)
        {
          include_once '../PHPMailer/PHPMailerAutoload.php';
          $mail = new PHPMailer;
          $mail->CharSet = 'utf-8';
          // Set PHPMailer to use the sendmail transport
          $mail->IsSMTP();
          $mail->Host="smtplb.cerner.com";
          // $mail->isSendmail();
            $mail->SMTPAutoTLS = false;   // TO bypass the connection error(added on 2019-03-04)
          $mail->setFrom("BookMyEvent@cerner.com");
            $mail->addAddress("Vijay.Krishna@Cerner.com");
          $mail->addCC("Manjunath.Nese@cerner.com");
         $mail->addCC("Nagesh.R2@cerner.com");
          $mail->addCC("priyanka.bandaru@cerner.com");

          $mail->Subject = "BookMyEvent Access: Pending";
          $mail->msgHTML(file_get_contents('template5.html'), dirname(__FILE__));

          $mail->AltBody = $assoc_name;

          if(!$mail->send())
          {
            echo "Mailer Error: " . $mail->ErrorInfo;
          }
          else {
           //echo "Template sent\n";
          }

        }
    //End Request Access

    //Request access Approval mail
        function template_access_approve($arr)
        {
          //To record the output of this page ob_start() & ob_get_contents() are used
          ob_start(); // Start output buffering


         $assoc_id= $arr['assoc_id'];
              $assoc_name=$arr['assoc_name'];
         $assoc_email=$arr['assoc_email'];
          $from_date=$arr['from_date'];
          $to_date= $arr['to_date'];
          $justification= $arr['justification'];
            $assoc_mail= $arr['assoc_mail'];

           ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">

<head>
    <!--[if gte mso 9]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]-->
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <meta content="width=device-width" name="viewport" />
    <!--[if !mso]><!-->
    <meta content="IE=edge" http-equiv="X-UA-Compatible" />
    <!--<![endif]-->
    <title></title>
    <!--[if !mso]><!-->
    <link href="https://fonts.googleapis.com/css?family=Abril+Fatface" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css" />
    <!--<![endif]-->
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
        }

        table,
        td,
        tr {
            vertical-align: top;
            border-collapse: collapse;
        }

        * {
            line-height: inherit;
        }

        a[x-apple-data-detectors=true] {
            color: inherit !important;
            text-decoration: none !important;
        }

    </style>
    <style id="media-query" type="text/css">
        @media (max-width: 620px) {

            .block-grid,
            .col {
                min-width: 400px !important;
                max-width: 100% !important;
                display: block !important;
            }

            .block-grid {
                width: 100% !important;
            }

            .col {
                width: 100% !important;
            }

            .col>div {
                margin: 0 auto;
            }

            img.fullwidth,
            img.fullwidthOnMobile {
                max-width: 100% !important;
            }

            .no-stack .col {
                min-width: 0 !important;
                display: table-cell !important;
            }

            .no-stack.two-up .col {
                width: 50% !important;
            }

            .no-stack .col.num4 {
                width: 33% !important;
            }

            .no-stack .col.num8 {
                width: 66% !important;
            }

            .no-stack .col.num4 {
                width: 33% !important;
            }

            .no-stack .col.num3 {
                width: 25% !important;
            }

            .no-stack .col.num6 {
                width: 50% !important;
            }

            .no-stack .col.num9 {
                width: 75% !important;
            }

            .video-block {
                max-width: none !important;
            }

            .mobile_hide {
                min-height: 0px;
                max-height: 0px;
                max-width: 0px;
                display: none;
                overflow: hidden;
                font-size: 0px;
            }

            .desktop_hide {
                display: block !important;
                max-height: none !important;
            }
        }

    </style>
</head>

<body class="clean-body" style="margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #ffffff;">
    <!--[if IE]><div class="ie-browser"><![endif]-->
    <table bgcolor="#ffffff" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="table-layout: fixed; vertical-align: top; min-width: 400px; Margin: 0 auto; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; width: 100%;" valign="top" width="100%">
        <tbody>
            <tr style="vertical-align: top;" valign="top">
                <td style="word-break: break-word; vertical-align: top;" valign="top">
                    <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td align="center" style="background-color:#ffffff"><![endif]-->
                    <div style="background-color:transparent;">
                        <div class="block-grid" style="Margin: 0 auto; min-width: 400px; max-width: 700px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #E9EAEB;">
                            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#E9EAEB;">
                                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:700px"><tr class="layout-full-width" style="background-color:#ffffff"><![endif]-->
                                <!--[if (mso)|(IE)]><td align="center" width="600" style="background-color:#ffffff;width:700px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
                                <div class="col num12" style="min-width: 400px; max-width: 700px; display: table-cell; vertical-align: top; width: 700px;">
                                    <div style="width:100% !important;">
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                                            <!--<![endif]-->

                                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top: 0px; padding-bottom: 0px; font-family: Arial, sans-serif"><![endif]-->
                                            <!--
                                                    <div style="color:#000000;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;">
                                                        <div style="line-height: 1.2; font-size: 12px; color: #000000; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;"><br />
                                                            <p style="font-size: 24px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 29px; margin: 0;"><span style="font-size: 24px;"><strong>Event Name</strong></span></p>
                                                        </div>
                                                    </div>
        -->

                                            <!--[if mso]></td></tr></table><![endif]-->

                                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 40px; padding-left: 40px; padding-top: 10px; padding-bottom: 10px; font-family: Arial, sans-serif"><![endif]-->
                                            <div style="color:#555555;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.5;padding-top:10px;padding-right:40px;padding-bottom:10px;padding-left:40px;">
                                                <div style="line-height: 1.5; font-size: 12px; color: #555555; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 18px;">
                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;">Dear <?php echo $assoc_name; ?>, <br /></p>

                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;">Your request for accesing BookMyEvent application has been Approved.</span></p>
                                                    <br />
                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;">You can now host the event.</span></p>
                                                </div>
                                            </div>

                                            <!--[if mso]></td></tr></table><![endif]-->
                                            <!--[if (!mso)&(!IE)]><!-->
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                            </div>
                        </div>
                    </div>
                    <div style="background-color:transparent;">
                        <div class="block-grid" style="Margin: 0 auto; min-width: 400px; max-width: 700px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #E9EAEB;">
                            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#E9EAEB;">
                                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:700px"><tr class="layout-full-width" style="background-color:#ffffff"><![endif]-->
                                <!--[if (mso)|(IE)]><td align="center" width="600" style="background-color:#ffffff;width:700px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
                                <div class="col num12" style="min-width: 400px; max-width: 700px; display: table-cell; vertical-align: top; width: 700px;">
                                    <div style="width:100% !important;">
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                                            <!--<![endif]-->
                                            <div align="center" class="img-container center fixedwidth" style="padding-right: 5px;padding-left: 5px;">
                                                <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px"><td style="padding-right: 5px;padding-left: 5px;" align="center"><![endif]-->
                                                <div style="font-size:1px;line-height:10px"> </div><a href="#" style="outline:none" tabindex="-1" target="_blank"> <img align="center" alt="Your Logo" border="0" class="center fixedwidth" src="BME_sse.png" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; width: 100%; max-width: 200px; display: block;" title="Your Logo" width="200" /></a>
                                                <div style="font-size:1px;line-height:10px"> </div>
                                                <!--[if mso]></td></tr></table><![endif]-->
                                            </div>
                                            <div style="font-size:16px;text-align:center;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif">
                                                <div style="height-top: 20px;"> </div>
                                            </div>
                                            <!--[if (!mso)&(!IE)]><!-->
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                            </div>
                        </div>
                    </div>
                    <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                </td>
            </tr>
        </tbody>
    </table>
    <!--[if (IE)]></div><![endif]-->
</body>

</html>
<?php
          file_put_contents('template6.html', ob_get_clean());
          ob_end_flush(); // Flush the output buffer and turn off output buffering
        }

        function send_mail_access_approve($assoc_mail,$assoc_name)
        {
          include_once '../PHPMailer/PHPMailerAutoload.php';
          $mail = new PHPMailer;
          $mail->CharSet = 'utf-8';
          // Set PHPMailer to use the sendmail transport
          $mail->IsSMTP();
          $mail->Host="smtplb.cerner.com";
          // $mail->isSendmail();
            $mail->SMTPAutoTLS = false;   // TO bypass the connection error(added on 2019-03-04)
          $mail->setFrom("BookMyEvent@cerner.com");
          $mail->addAddress($assoc_mail);
         // $mail->addCC($manager_email);

          $mail->Subject = "BookMyEvent Access: Approved";
          $mail->msgHTML(file_get_contents('template6.html'), dirname(__FILE__));

          $mail->AltBody = $assoc_name;

          if(!$mail->send())
          {
            echo "Mailer Error: " . $mail->ErrorInfo;
          }
          else {
           //echo "Template sent\n";
          }

        }
    //End Request access Approval mail

    //Request access rejection mail
        function template_access_reject($arr)
        {
          //To record the output of this page ob_start() & ob_get_contents() are used
          ob_start(); // Start output buffering


         $assoc_id= $arr['assoc_id'];
         $assoc_name=$arr['assoc_name'];
         $assoc_email=$arr['assoc_email'];
         $from_date=$arr['from_date'];
         $to_date= $arr['to_date'];
         $justification= $arr['justification'];
         $Rejectjustification= $arr['Rejectjustification'];
         $assoc_mail= $arr['assoc_mail'];

           ?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
</head>

<body style='font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;'>
    <p style='font-size:13px;'>Hi
        <?php echo $assoc_name; ?>,</p>

    <p style='font-size:13px;'>Your request for BookMyEvent Access has been Rejected.
        <br />
        <br />
        <?php echo $Rejectjustification; ?>

    </p>


    <br />
    <br />
    <p style='font-size:13px;'>Thanks,
        <br />SSE_ES_DevTeam</p>
    <br />



</body>

</html>
<?php
          file_put_contents('template7.html', ob_get_clean());
          ob_end_flush(); // Flush the output buffer and turn off output buffering
        }

        function send_mail_access_reject($assoc_mail,$assoc_name)
        {
          include_once '../PHPMailer/PHPMailerAutoload.php';
          $mail = new PHPMailer;
          $mail->CharSet = 'utf-8';
          // Set PHPMailer to use the sendmail transport
          $mail->IsSMTP();
          $mail->Host="smtplb.cerner.com";
          // $mail->isSendmail();
            $mail->SMTPAutoTLS = false;   // TO bypass the connection error(added on 2019-03-04)
          $mail->setFrom("BookMyEvent@cerner.com");
          $mail->addAddress($assoc_mail);
         // $mail->addCC($manager_email);

          $mail->Subject = "BookMyEvent Access: Rejected";
          $mail->msgHTML(file_get_contents('template7.html'), dirname(__FILE__));

          $mail->AltBody = $assoc_name;

          if(!$mail->send())
          {
            echo "Mailer Error: " . $mail->ErrorInfo;
          }
          else {
           //echo "Template sent\n";
          }

        }
    //End Request access rejection mail

    //Request Mailbox mail
        function template_mailbox_associate($arr)
        {
          //To record the output of this page ob_start() & ob_get_contents() are used
          ob_start(); // Start output buffering
         $assoc_id= $arr['assoc_id'];
              $assoc_name=$arr['assoc_name'];
         $assoc_email=$arr['assoc_email'];
          $mailbox=$arr['mailbox'];
          $today= $arr['today'];



           ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">

<head>
    <!--[if gte mso 9]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]-->
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <meta content="width=device-width" name="viewport" />
    <!--[if !mso]><!-->
    <meta content="IE=edge" http-equiv="X-UA-Compatible" />
    <!--<![endif]-->
    <title></title>
    <!--[if !mso]><!-->
    <link href="https://fonts.googleapis.com/css?family=Abril+Fatface" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css" />
    <!--<![endif]-->
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
        }

        table,
        td,
        tr {
            vertical-align: top;
            border-collapse: collapse;
        }

        * {
            line-height: inherit;
        }

        a[x-apple-data-detectors=true] {
            color: inherit !important;
            text-decoration: none !important;
        }

    </style>
    <style id="media-query" type="text/css">
        @media (max-width: 620px) {

            .block-grid,
            .col {
                min-width: 400px !important;
                max-width: 100% !important;
                display: block !important;
            }

            .block-grid {
                width: 100% !important;
            }

            .col {
                width: 100% !important;
            }

            .col>div {
                margin: 0 auto;
            }

            img.fullwidth,
            img.fullwidthOnMobile {
                max-width: 100% !important;
            }

            .no-stack .col {
                min-width: 0 !important;
                display: table-cell !important;
            }

            .no-stack.two-up .col {
                width: 50% !important;
            }

            .no-stack .col.num4 {
                width: 33% !important;
            }

            .no-stack .col.num8 {
                width: 66% !important;
            }

            .no-stack .col.num4 {
                width: 33% !important;
            }

            .no-stack .col.num3 {
                width: 25% !important;
            }

            .no-stack .col.num6 {
                width: 50% !important;
            }

            .no-stack .col.num9 {
                width: 75% !important;
            }

            .video-block {
                max-width: none !important;
            }

            .mobile_hide {
                min-height: 0px;
                max-height: 0px;
                max-width: 0px;
                display: none;
                overflow: hidden;
                font-size: 0px;
            }

            .desktop_hide {
                display: block !important;
                max-height: none !important;
            }
        }

    </style>
</head>

<body class="clean-body" style="margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #ffffff;">
    <!--[if IE]><div class="ie-browser"><![endif]-->
    <table bgcolor="#ffffff" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="table-layout: fixed; vertical-align: top; min-width: 400px; Margin: 0 auto; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; width: 100%;" valign="top" width="100%">
        <tbody>
            <tr style="vertical-align: top;" valign="top">
                <td style="word-break: break-word; vertical-align: top;" valign="top">
                    <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td align="center" style="background-color:#ffffff"><![endif]-->
                    <div style="background-color:transparent;">
                        <div class="block-grid" style="Margin: 0 auto; min-width: 400px; max-width: 700px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #E9EAEB;">
                            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#E9EAEB;">
                                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:700px"><tr class="layout-full-width" style="background-color:#ffffff"><![endif]-->
                                <!--[if (mso)|(IE)]><td align="center" width="600" style="background-color:#ffffff;width:700px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
                                <div class="col num12" style="min-width: 400px; max-width: 700px; display: table-cell; vertical-align: top; width: 700px;">
                                    <div style="width:100% !important;">
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                                            <!--<![endif]-->

                                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top: 0px; padding-bottom: 0px; font-family: Arial, sans-serif"><![endif]-->
                                            <!--
                                                    <div style="color:#000000;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;">
                                                        <div style="line-height: 1.2; font-size: 12px; color: #000000; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;"><br />
                                                            <p style="font-size: 24px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 29px; margin: 0;"><span style="font-size: 24px;"><strong>Event Name</strong></span></p>
                                                        </div>
                                                    </div>
        -->

                                            <!--[if mso]></td></tr></table><![endif]-->

                                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 40px; padding-left: 40px; padding-top: 10px; padding-bottom: 10px; font-family: Arial, sans-serif"><![endif]-->
                                            <div style="color:#555555;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.5;padding-top:10px;padding-right:40px;padding-bottom:10px;padding-left:40px;">
                                                <div style="line-height: 1.5; font-size: 12px; color: #555555; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 18px;">
                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;">Dear <?php echo $assoc_name; ?>,<br /></span></p>
                                                    <br />
                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;"> You have requested for accessing a Mailbox in BookMyEvent.</span></p>
                                                    <br />
                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;"><b>Associate ID:</b> <?php echo $assoc_id; ?></span></p>

                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;"><b>Associate Name:</b> <?php echo $assoc_name; ?></span></p>

                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;"><b>Requested Date:</b> <?php echo $today; ?> </span></p>

                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;"><b>Mailbox:</b> <?php echo $mailbox; ?> </span></p>
                                                    <br />
                                                </div>
                                            </div>

                                            <!--[if mso]></td></tr></table><![endif]-->
                                            <!--[if (!mso)&(!IE)]><!-->
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                            </div>
                        </div>
                    </div>
                    <div style="background-color:transparent;">
                        <div class="block-grid" style="Margin: 0 auto; min-width: 400px; max-width: 700px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #E9EAEB;">
                            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#E9EAEB;">
                                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:700px"><tr class="layout-full-width" style="background-color:#ffffff"><![endif]-->
                                <!--[if (mso)|(IE)]><td align="center" width="600" style="background-color:#ffffff;width:700px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
                                <div class="col num12" style="min-width: 400px; max-width: 700px; display: table-cell; vertical-align: top; width: 700px;">
                                    <div style="width:100% !important;">
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                                            <!--<![endif]-->
                                            <div align="center" class="img-container center fixedwidth" style="padding-right: 5px;padding-left: 5px;">
                                                <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px"><td style="padding-right: 5px;padding-left: 5px;" align="center"><![endif]-->
                                                <div style="font-size:1px;line-height:10px"> </div><a href="#" style="outline:none" tabindex="-1" target="_blank"> <img align="center" alt="Your Logo" border="0" class="center fixedwidth" src="BME_sse.png" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; width: 100%; max-width: 200px; display: block;" title="Your Logo" width="200" /></a>
                                                <div style="font-size:1px;line-height:10px"> </div>
                                                <!--[if mso]></td></tr></table><![endif]-->
                                            </div>
                                            <div style="font-size:16px;text-align:center;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif">
                                                <div style="height-top: 20px;"> </div>
                                            </div>
                                            <!--[if (!mso)&(!IE)]><!-->
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                            </div>
                        </div>
                    </div>
                    <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                </td>
            </tr>
        </tbody>
    </table>
    <!--[if (IE)]></div><![endif]-->
</body>

</html>
<?php
          file_put_contents('template4.html', ob_get_clean());
          ob_end_flush(); // Flush the output buffer and turn off output buffering
        }

        function send_mail_mailbox_associate($assoc_email,$assoc_name)
        {
          include_once '../PHPMailer/PHPMailerAutoload.php';
          $mail = new PHPMailer;
          $mail->CharSet = 'utf-8';
          // Set PHPMailer to use the sendmail transport
          $mail->IsSMTP();
          $mail->Host="smtplb.cerner.com";
          // $mail->isSendmail();
            $mail->SMTPAutoTLS = false;   // TO bypass the connection error(added on 2019-03-04)
          $mail->setFrom("BookMyEvent@cerner.com");
          $mail->addAddress($assoc_email);
         // $mail->addCC($manager_email);

          $mail->Subject = "BookMyEvent Mailbox Access: Pending";
          $mail->msgHTML(file_get_contents('template4.html'), dirname(__FILE__));

          $mail->AltBody = $assoc_name;

          if(!$mail->send())
          {
            echo "Mailer Error: " . $mail->ErrorInfo;
          }
          else {
           //echo "Template sent\n";
          }

        }

        function template_mailbox_team($arr)
        {
          //To record the output of this page ob_start() & ob_get_contents() are used
          ob_start(); // Start output buffering


         $assoc_id= $arr['assoc_id'];
              $assoc_name=$arr['assoc_name'];
         $assoc_email=$arr['assoc_email'];
         $mailbox=$arr['mailbox'];
          $today= $arr['today'];	

           ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">

<head>
    <!--[if gte mso 9]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]-->
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <meta content="width=device-width" name="viewport" />
    <!--[if !mso]><!-->
    <meta content="IE=edge" http-equiv="X-UA-Compatible" />
    <!--<![endif]-->
    <title></title>
    <!--[if !mso]><!-->
    <link href="https://fonts.googleapis.com/css?family=Abril+Fatface" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css" />
    <!--<![endif]-->
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
        }

        table,
        td,
        tr {
            vertical-align: top;
            border-collapse: collapse;
        }

        * {
            line-height: inherit;
        }

        a[x-apple-data-detectors=true] {
            color: inherit !important;
            text-decoration: none !important;
        }

    </style>
    <style id="media-query" type="text/css">
        @media (max-width: 620px) {

            .block-grid,
            .col {
                min-width: 400px !important;
                max-width: 100% !important;
                display: block !important;
            }

            .block-grid {
                width: 100% !important;
            }

            .col {
                width: 100% !important;
            }

            .col>div {
                margin: 0 auto;
            }

            img.fullwidth,
            img.fullwidthOnMobile {
                max-width: 100% !important;
            }

            .no-stack .col {
                min-width: 0 !important;
                display: table-cell !important;
            }

            .no-stack.two-up .col {
                width: 50% !important;
            }

            .no-stack .col.num4 {
                width: 33% !important;
            }

            .no-stack .col.num8 {
                width: 66% !important;
            }

            .no-stack .col.num4 {
                width: 33% !important;
            }

            .no-stack .col.num3 {
                width: 25% !important;
            }

            .no-stack .col.num6 {
                width: 50% !important;
            }

            .no-stack .col.num9 {
                width: 75% !important;
            }

            .video-block {
                max-width: none !important;
            }

            .mobile_hide {
                min-height: 0px;
                max-height: 0px;
                max-width: 0px;
                display: none;
                overflow: hidden;
                font-size: 0px;
            }

            .desktop_hide {
                display: block !important;
                max-height: none !important;
            }
        }

    </style>
</head>

<body class="clean-body" style="margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #ffffff;">
    <!--[if IE]><div class="ie-browser"><![endif]-->
    <table bgcolor="#ffffff" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="table-layout: fixed; vertical-align: top; min-width: 400px; Margin: 0 auto; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; width: 100%;" valign="top" width="100%">
        <tbody>
            <tr style="vertical-align: top;" valign="top">
                <td style="word-break: break-word; vertical-align: top;" valign="top">
                    <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td align="center" style="background-color:#ffffff"><![endif]-->
                    <div style="background-color:transparent;">
                        <div class="block-grid" style="Margin: 0 auto; min-width: 400px; max-width: 700px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #E9EAEB;">
                            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#E9EAEB;">
                                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:700px"><tr class="layout-full-width" style="background-color:#ffffff"><![endif]-->
                                <!--[if (mso)|(IE)]><td align="center" width="600" style="background-color:#ffffff;width:700px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
                                <div class="col num12" style="min-width: 400px; max-width: 700px; display: table-cell; vertical-align: top; width: 700px;">
                                    <div style="width:100% !important;">
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                                            <!--<![endif]-->

                                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top: 0px; padding-bottom: 0px; font-family: Arial, sans-serif"><![endif]-->
                                            <!--
                                                    <div style="color:#000000;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;">
                                                        <div style="line-height: 1.2; font-size: 12px; color: #000000; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;"><br />
                                                            <p style="font-size: 24px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 29px; margin: 0;"><span style="font-size: 24px;"><strong>Event Name</strong></span></p>
                                                        </div>
                                                    </div>
        -->

                                            <!--[if mso]></td></tr></table><![endif]-->

                                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 40px; padding-left: 40px; padding-top: 10px; padding-bottom: 10px; font-family: Arial, sans-serif"><![endif]-->
                                            <div style="color:#555555;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.5;padding-top:10px;padding-right:40px;padding-bottom:10px;padding-left:40px;">
                                                <div style="line-height: 1.5; font-size: 12px; color: #555555; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 18px;">
                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;">Hi,<br /></span></p>
                                                    <br />
                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;"><?php echo $assoc_name; ?> has requested for accessing a mailbox in BookMyEvent.</span></p>
                                                    <br />
                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;"><b>Associate ID:</b> <?php echo $assoc_id; ?></span></p>

                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;"><b>Associate Name:</b> <?php echo $assoc_name; ?></span></p>

                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;"><b>Requested Date:</b> <?php echo $today; ?> </span></p>

                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;"><b>Mailbox:</b> <?php echo $mailbox; ?> </span></p>
                                                    <br />
                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;">Please click <a href="https://bookmyevent.cerner.com/BME/Mailbox_Action.php">here</a> to approve this request.</span></p>


                                                </div>
                                            </div>

                                            <!--[if mso]></td></tr></table><![endif]-->
                                            <!--[if (!mso)&(!IE)]><!-->
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                            </div>
                        </div>
                    </div>
                    <div style="background-color:transparent;">
                        <div class="block-grid" style="Margin: 0 auto; min-width: 400px; max-width: 700px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #E9EAEB;">
                            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#E9EAEB;">
                                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:700px"><tr class="layout-full-width" style="background-color:#ffffff"><![endif]-->
                                <!--[if (mso)|(IE)]><td align="center" width="600" style="background-color:#ffffff;width:700px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
                                <div class="col num12" style="min-width: 400px; max-width: 700px; display: table-cell; vertical-align: top; width: 700px;">
                                    <div style="width:100% !important;">
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                                            <!--<![endif]-->
                                            <div align="center" class="img-container center fixedwidth" style="padding-right: 5px;padding-left: 5px;">
                                                <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px"><td style="padding-right: 5px;padding-left: 5px;" align="center"><![endif]-->
                                                <div style="font-size:1px;line-height:10px"> </div><a href="#" style="outline:none" tabindex="-1" target="_blank"> <img align="center" alt="Your Logo" border="0" class="center fixedwidth" src="BME_sse.png" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; width: 100%; max-width: 200px; display: block;" title="Your Logo" width="200" /></a>
                                                <div style="font-size:1px;line-height:10px"> </div>
                                                <!--[if mso]></td></tr></table><![endif]-->
                                            </div>
                                            <div style="font-size:16px;text-align:center;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif">
                                                <div style="height-top: 20px;"> </div>
                                            </div>
                                            <!--[if (!mso)&(!IE)]><!-->
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                            </div>
                        </div>
                    </div>
                    <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                </td>
            </tr>
        </tbody>
    </table>
    <!--[if (IE)]></div><![endif]-->
</body>

</html>
<?php
          file_put_contents('template5.html', ob_get_clean());
          ob_end_flush(); // Flush the output buffer and turn off output buffering
        }

        function send_mail_mailbox_team($assoc_email,$assoc_name)
        {
          include_once '../PHPMailer/PHPMailerAutoload.php';
          $mail = new PHPMailer;
          $mail->CharSet = 'utf-8';
          // Set PHPMailer to use the sendmail transport
          $mail->IsSMTP();
          $mail->Host="smtplb.cerner.com";
          // $mail->isSendmail();
            $mail->SMTPAutoTLS = false;   // TO bypass the connection error(added on 2019-03-04)
          $mail->setFrom("BookMyEvent@cerner.com");
          $mail->addAddress("Vijay.Krishna@Cerner.com");
          $mail->addCC("Manjunath.Nese@cerner.com");
         $mail->addCC("Nagesh.R2@cerner.com");
		 $mail->addCC("prapul.a@cerner.com");
          $mail->addCC("priyanka.bandaru@cerner.com");

          $mail->Subject = "BookMyEvent Mailbox Access: Pending";
          $mail->msgHTML(file_get_contents('template5.html'), dirname(__FILE__));

          $mail->AltBody = $assoc_name;

          if(!$mail->send())
          {
            echo "Mailer Error: " . $mail->ErrorInfo;
          }
          else {
           //echo "Template sent\n";
          }

        }
    //End Request Mailbox mail
//Request

//Mailbox
    //Approval Mailbox mail
        function template_mailbox_approve($arr)
        {
          //To record the output of this page ob_start() & ob_get_contents() are used
          ob_start(); // Start output buffering


         $assoc_id= $arr['assoc_id'];
              $assoc_name=$arr['assoc_name'];
            $assoc_mail= $arr['assoc_mail'];
             $requested_date= $arr['requested_date'];
        $mailbox=$arr['mailbox'];

           ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">

<head>
    <!--[if gte mso 9]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]-->
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <meta content="width=device-width" name="viewport" />
    <!--[if !mso]><!-->
    <meta content="IE=edge" http-equiv="X-UA-Compatible" />
    <!--<![endif]-->
    <title></title>
    <!--[if !mso]><!-->
    <link href="https://fonts.googleapis.com/css?family=Abril+Fatface" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css" />
    <!--<![endif]-->
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
        }

        table,
        td,
        tr {
            vertical-align: top;
            border-collapse: collapse;
        }

        * {
            line-height: inherit;
        }

        a[x-apple-data-detectors=true] {
            color: inherit !important;
            text-decoration: none !important;
        }

    </style>
    <style id="media-query" type="text/css">
        @media (max-width: 620px) {

            .block-grid,
            .col {
                min-width: 400px !important;
                max-width: 100% !important;
                display: block !important;
            }

            .block-grid {
                width: 100% !important;
            }

            .col {
                width: 100% !important;
            }

            .col>div {
                margin: 0 auto;
            }

            img.fullwidth,
            img.fullwidthOnMobile {
                max-width: 100% !important;
            }

            .no-stack .col {
                min-width: 0 !important;
                display: table-cell !important;
            }

            .no-stack.two-up .col {
                width: 50% !important;
            }

            .no-stack .col.num4 {
                width: 33% !important;
            }

            .no-stack .col.num8 {
                width: 66% !important;
            }

            .no-stack .col.num4 {
                width: 33% !important;
            }

            .no-stack .col.num3 {
                width: 25% !important;
            }

            .no-stack .col.num6 {
                width: 50% !important;
            }

            .no-stack .col.num9 {
                width: 75% !important;
            }

            .video-block {
                max-width: none !important;
            }

            .mobile_hide {
                min-height: 0px;
                max-height: 0px;
                max-width: 0px;
                display: none;
                overflow: hidden;
                font-size: 0px;
            }

            .desktop_hide {
                display: block !important;
                max-height: none !important;
            }
        }

    </style>
</head>

<body class="clean-body" style="margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #ffffff;">
    <!--[if IE]><div class="ie-browser"><![endif]-->
    <table bgcolor="#ffffff" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="table-layout: fixed; vertical-align: top; min-width: 400px; Margin: 0 auto; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; width: 100%;" valign="top" width="100%">
        <tbody>
            <tr style="vertical-align: top;" valign="top">
                <td style="word-break: break-word; vertical-align: top;" valign="top">
                    <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td align="center" style="background-color:#ffffff"><![endif]-->
                    <div style="background-color:transparent;">
                        <div class="block-grid" style="Margin: 0 auto; min-width: 400px; max-width: 700px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #E9EAEB;">
                            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#E9EAEB;">
                                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:700px"><tr class="layout-full-width" style="background-color:#ffffff"><![endif]-->
                                <!--[if (mso)|(IE)]><td align="center" width="600" style="background-color:#ffffff;width:700px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
                                <div class="col num12" style="min-width: 400px; max-width: 700px; display: table-cell; vertical-align: top; width: 700px;">
                                    <div style="width:100% !important;">
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                                            <!--<![endif]-->

                                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top: 0px; padding-bottom: 0px; font-family: Arial, sans-serif"><![endif]-->
                                            <!--
                                                    <div style="color:#000000;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;">
                                                        <div style="line-height: 1.2; font-size: 12px; color: #000000; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;"><br />
                                                            <p style="font-size: 24px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 29px; margin: 0;"><span style="font-size: 24px;"><strong>Event Name</strong></span></p>
                                                        </div>
                                                    </div>
        -->

                                            <!--[if mso]></td></tr></table><![endif]-->

                                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 40px; padding-left: 40px; padding-top: 10px; padding-bottom: 10px; font-family: Arial, sans-serif"><![endif]-->
                                            <div style="color:#555555;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.5;padding-top:10px;padding-right:40px;padding-bottom:10px;padding-left:40px;">
                                                <div style="line-height: 1.5; font-size: 12px; color: #555555; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 18px;">
                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;">Dear <?php echo $assoc_name; ?>, <br /></p>

                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;">Your request for accesing Mailbox in BookMyEvent application has been Approved.</span></p>
                                                    <br />
                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;">You can now use the Mailbox in Creating Event</span></p>
                                                    <br />
                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;"><b>Mailbox:</b> <?php echo $mailbox; ?> </span></p>
                                                </div>
                                            </div>

                                            <!--[if mso]></td></tr></table><![endif]-->
                                            <!--[if (!mso)&(!IE)]><!-->
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                            </div>
                        </div>
                    </div>
                    <div style="background-color:transparent;">
                        <div class="block-grid" style="Margin: 0 auto; min-width: 400px; max-width: 700px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #E9EAEB;">
                            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#E9EAEB;">
                                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:700px"><tr class="layout-full-width" style="background-color:#ffffff"><![endif]-->
                                <!--[if (mso)|(IE)]><td align="center" width="600" style="background-color:#ffffff;width:700px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
                                <div class="col num12" style="min-width: 400px; max-width: 700px; display: table-cell; vertical-align: top; width: 700px;">
                                    <div style="width:100% !important;">
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                                            <!--<![endif]-->
                                            <div align="center" class="img-container center fixedwidth" style="padding-right: 5px;padding-left: 5px;">
                                                <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px"><td style="padding-right: 5px;padding-left: 5px;" align="center"><![endif]-->
                                                <div style="font-size:1px;line-height:10px"> </div><a href="#" style="outline:none" tabindex="-1" target="_blank"> <img align="center" alt="Your Logo" border="0" class="center fixedwidth" src="BME_sse.png" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; width: 100%; max-width: 200px; display: block;" title="Your Logo" width="200" /></a>
                                                <div style="font-size:1px;line-height:10px"> </div>
                                                <!--[if mso]></td></tr></table><![endif]-->
                                            </div>
                                            <div style="font-size:16px;text-align:center;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif">
                                                <div style="height-top: 20px;"> </div>
                                            </div>
                                            <!--[if (!mso)&(!IE)]><!-->
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                            </div>
                        </div>
                    </div>
                    <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                </td>
            </tr>
        </tbody>
    </table>
    <!--[if (IE)]></div><![endif]-->
</body>

</html>
<?php
          file_put_contents('template6.html', ob_get_clean());
          ob_end_flush(); // Flush the output buffer and turn off output buffering
        }

        function send_mail_mailbox_approve($assoc_mail,$assoc_name)
        {
          include_once '../PHPMailer/PHPMailerAutoload.php';
          $mail = new PHPMailer;
          $mail->CharSet = 'utf-8';
          // Set PHPMailer to use the sendmail transport
          $mail->IsSMTP();
          $mail->Host="smtplb.cerner.com";
          // $mail->isSendmail();
            $mail->SMTPAutoTLS = false;   // TO bypass the connection error(added on 2019-03-04)
          $mail->setFrom("BookMyEvent@cerner.com");
          $mail->addAddress($assoc_mail);
         // $mail->addCC($manager_email);

          $mail->Subject = "BookMyEvent Mailbox Access: Approved";
          $mail->msgHTML(file_get_contents('template6.html'), dirname(__FILE__));

          $mail->AltBody = $assoc_name;

          if(!$mail->send())
          {
            echo "Mailer Error: " . $mail->ErrorInfo;
          }
          else {
           //echo "Template sent\n";
          }

        }
    //End Approval Mailbox mail

    //Rejection Mailbox mail
        function template_mailbox_reject($arr)
        {
          //To record the output of this page ob_start() & ob_get_contents() are used
          ob_start(); // Start output buffering


         $assoc_id= $arr['assoc_id'];
              $assoc_name=$arr['assoc_name'];
            $assoc_mail= $arr['assoc_mail'];
             $requested_date= $arr['requested_date'];
        $mailbox=$arr['mailbox'];
               $Rejectjustification= $arr['Rejectjustification'];
           ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">

<head>
    <!--[if gte mso 9]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]-->
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <meta content="width=device-width" name="viewport" />
    <!--[if !mso]><!-->
    <meta content="IE=edge" http-equiv="X-UA-Compatible" />
    <!--<![endif]-->
    <title></title>
    <!--[if !mso]><!-->
    <link href="https://fonts.googleapis.com/css?family=Abril+Fatface" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css" />
    <!--<![endif]-->
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
        }

        table,
        td,
        tr {
            vertical-align: top;
            border-collapse: collapse;
        }

        * {
            line-height: inherit;
        }

        a[x-apple-data-detectors=true] {
            color: inherit !important;
            text-decoration: none !important;
        }

    </style>
    <style id="media-query" type="text/css">
        @media (max-width: 620px) {

            .block-grid,
            .col {
                min-width: 400px !important;
                max-width: 100% !important;
                display: block !important;
            }

            .block-grid {
                width: 100% !important;
            }

            .col {
                width: 100% !important;
            }

            .col>div {
                margin: 0 auto;
            }

            img.fullwidth,
            img.fullwidthOnMobile {
                max-width: 100% !important;
            }

            .no-stack .col {
                min-width: 0 !important;
                display: table-cell !important;
            }

            .no-stack.two-up .col {
                width: 50% !important;
            }

            .no-stack .col.num4 {
                width: 33% !important;
            }

            .no-stack .col.num8 {
                width: 66% !important;
            }

            .no-stack .col.num4 {
                width: 33% !important;
            }

            .no-stack .col.num3 {
                width: 25% !important;
            }

            .no-stack .col.num6 {
                width: 50% !important;
            }

            .no-stack .col.num9 {
                width: 75% !important;
            }

            .video-block {
                max-width: none !important;
            }

            .mobile_hide {
                min-height: 0px;
                max-height: 0px;
                max-width: 0px;
                display: none;
                overflow: hidden;
                font-size: 0px;
            }

            .desktop_hide {
                display: block !important;
                max-height: none !important;
            }
        }

    </style>
</head>

<body class="clean-body" style="margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #ffffff;">
    <!--[if IE]><div class="ie-browser"><![endif]-->
    <table bgcolor="#ffffff" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="table-layout: fixed; vertical-align: top; min-width: 400px; Margin: 0 auto; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; width: 100%;" valign="top" width="100%">
        <tbody>
            <tr style="vertical-align: top;" valign="top">
                <td style="word-break: break-word; vertical-align: top;" valign="top">
                    <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td align="center" style="background-color:#ffffff"><![endif]-->
                    <div style="background-color:transparent;">
                        <div class="block-grid" style="Margin: 0 auto; min-width: 400px; max-width: 700px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #E9EAEB;">
                            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#E9EAEB;">
                                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:700px"><tr class="layout-full-width" style="background-color:#ffffff"><![endif]-->
                                <!--[if (mso)|(IE)]><td align="center" width="600" style="background-color:#ffffff;width:700px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
                                <div class="col num12" style="min-width: 400px; max-width: 700px; display: table-cell; vertical-align: top; width: 700px;">
                                    <div style="width:100% !important;">
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                                            <!--<![endif]-->

                                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top: 0px; padding-bottom: 0px; font-family: Arial, sans-serif"><![endif]-->
                                            <!--
                                                    <div style="color:#000000;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;">
                                                        <div style="line-height: 1.2; font-size: 12px; color: #000000; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;"><br />
                                                            <p style="font-size: 24px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 29px; margin: 0;"><span style="font-size: 24px;"><strong>Event Name</strong></span></p>
                                                        </div>
                                                    </div>
        -->

                                            <!--[if mso]></td></tr></table><![endif]-->

                                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 40px; padding-left: 40px; padding-top: 10px; padding-bottom: 10px; font-family: Arial, sans-serif"><![endif]-->
                                            <div style="color:#555555;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.5;padding-top:10px;padding-right:40px;padding-bottom:10px;padding-left:40px;">
                                                <div style="line-height: 1.5; font-size: 12px; color: #555555; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 18px;">
                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;">Dear <?php echo $assoc_name; ?>, <br /></p>

                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;">Your request for accesing Mailbox in BookMyEvent application has been Rejected</span></p>
                                                    <br />
                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;">Mailbox: <?php echo $mailbox; ?></span></p>
                                                    <br />
                                                    <p style="font-size: 16px; line-height: 1.5; word-break: break-word;mso-line-height-alt: 24px; margin: 0;"><span style="font-size: 16px;"><?php echo $Rejectjustification; ?></span></p>
                                                </div>
                                            </div>

                                            <!--[if mso]></td></tr></table><![endif]-->
                                            <!--[if (!mso)&(!IE)]><!-->
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                            </div>
                        </div>
                    </div>
                    <div style="background-color:transparent;">
                        <div class="block-grid" style="Margin: 0 auto; min-width: 400px; max-width: 700px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #E9EAEB;">
                            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#E9EAEB;">
                                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:700px"><tr class="layout-full-width" style="background-color:#ffffff"><![endif]-->
                                <!--[if (mso)|(IE)]><td align="center" width="600" style="background-color:#ffffff;width:700px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
                                <div class="col num12" style="min-width: 400px; max-width: 700px; display: table-cell; vertical-align: top; width: 700px;">
                                    <div style="width:100% !important;">
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                                            <!--<![endif]-->
                                            <div align="center" class="img-container center fixedwidth" style="padding-right: 5px;padding-left: 5px;">
                                                <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px"><td style="padding-right: 5px;padding-left: 5px;" align="center"><![endif]-->
                                                <div style="font-size:1px;line-height:10px"> </div><a href="#" style="outline:none" tabindex="-1" target="_blank"> <img align="center" alt="Your Logo" border="0" class="center fixedwidth" src="BME_sse.png" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; width: 100%; max-width: 200px; display: block;" title="Your Logo" width="200" /></a>
                                                <div style="font-size:1px;line-height:10px"> </div>
                                                <!--[if mso]></td></tr></table><![endif]-->
                                            </div>
                                            <div style="font-size:16px;text-align:center;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif">
                                                <div style="height-top: 20px;"> </div>
                                            </div>
                                            <!--[if (!mso)&(!IE)]><!-->
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                            </div>
                        </div>
                    </div>
                    <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                </td>
            </tr>
        </tbody>
    </table>
    <!--[if (IE)]></div><![endif]-->
</body>

</html>

<?php
          file_put_contents('template6.html', ob_get_clean());
          ob_end_flush(); // Flush the output buffer and turn off output buffering
        }

        function send_mail_mailbox_reject($assoc_mail,$assoc_name)
        {
          include_once '../PHPMailer/PHPMailerAutoload.php';
          $mail = new PHPMailer;
          $mail->CharSet = 'utf-8';
          // Set PHPMailer to use the sendmail transport
          $mail->IsSMTP();
          $mail->Host="smtplb.cerner.com";
          // $mail->isSendmail();
            $mail->SMTPAutoTLS = false;   // TO bypass the connection error(added on 2019-03-04)
          $mail->setFrom("BookMyEvent@cerner.com");
          $mail->addAddress($assoc_mail);
         // $mail->addCC($manager_email);

          $mail->Subject = "BookMyEvent Mailbox Access: Rejected";
          $mail->msgHTML(file_get_contents('template6.html'), dirname(__FILE__));

          $mail->AltBody = $assoc_name;

          if(!$mail->send())
          {
            echo "Mailer Error: " . $mail->ErrorInfo;
          }
          else {
           //echo "Template sent\n";
          }

        }
    //End Rejection Mailbox mail
//Mailbox

//Patashala
    // For Patashala purpose regitrations report after event
        function template_registrations($arr)
        {
          //To record the output of this page ob_start() & ob_get_contents() are used
          ob_start(); // Start output buffering

          $email=$arr['email'];
          $event_name=$arr['event_name'];
            $location=$arr['location'];

           ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
</head>

<body style='font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;'>

    <p style='font-size:13px;'> SSE PATHASHALA Registrations.
        <br />
        Event Name: <?php echo $event_name;  ?><br />
        Location : <?php echo $location;  ?>
        <br />
        <br />
        Registrations file is attached.
    </p>
    <br>

    <p style='font-size:13px;'>Regards,
        <br />Cerner Events</p>
    <br />
</body>

</html>
<?php
          file_put_contents('template1.html', ob_get_clean());// Store the contents into the specified file "here it is Demo1.html"
          ob_end_flush(); // Flush the output buffer and turn off output buffering
        }

        function send_mail_registrations($email,$event_name)
        {
          include_once '../PHPMailer/PHPMailerAutoload.php';
          $mail = new PHPMailer;
          $mail->CharSet = 'utf-8';
          // Set PHPMailer to use the sendmail transport
          $mail->IsSMTP();
          $mail->Host="smtplb.cerner.com";
          // $mail->isSendmail();
            $mail->SMTPAutoTLS = false;   // TO bypass the connection error(added on 2019-03-04)
          $mail->setFrom('BookMyEvent@cerner.com');
          $mail->addAddress($email);
         // $mail->addCC($manager_email);
          $file = 'BME.xls';
          $mail->AddAttachment( $file, 'BME.xls' );
          $mail->Subject = $event_name;
          $mail->msgHTML(file_get_contents('template1.html'), dirname(__FILE__));
          // $mail->AddAttachment("cts_expo1.ics");
          //Replace the plain text body with one created manually
          $mail->AltBody = $event_name;
          //Attach an image file

          //send the message, check for errors
          if(!$mail->send())
          {
            echo "Mailer Error: " . $mail->ErrorInfo;
          }
          else {
           //echo "Template sent\n";
          }

        }
    //End For Patashala purpose regitrations report after event
//Patashala

//Misc
    //misc testing
        function sendIcalEvent_ISTlearning($from_name, $from_address, $to_name, $to_address, $startTime, $endTime, $subject, $description, $timeslot_location,$emailbox)
        {  
          //echo "Inside function\n";
            $domain = 'cerner.com';
            $uid=date("Ymd\TGis", strtotime($startTime)).rand()."@".$domain;   

            //Create Email Headers
            // $mime_boundary = "----Event Booking----".MD5(TIME());
            //
            // $headers = "From: ".$from_name." <".$from_address.">\n";
            // $headers .= "Reply-To: ".$from_name." <".$from_address.">\n";
            // $headers .= "MIME-Version: 1.0\n";
            // $headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
            // $headers .= "Content-class: urn:content-classes:calendarmessage\n";

            //Create Email Body (HTML)
            // $message = "--$mime_boundary\r\n";
            // $message .= "Content-Type: text/html; charset=UTF-8\n";
            // $message .= "Content-Transfer-Encoding: 8bit\n\n";
            $message = "<html>\n";
            $message .= "<body>\n";
            $message .= '<p>Greetings '.$to_name.', <br/> '.$description.'
            <br/>  
            <br/>  
            <br/>  
             You can also cancel this registration, Please click <a href="https://bookmyevent.cerner.com/BME/myprofile.php">here</a> 
        <br/>
        <br/>
        Regards,
                    <br/>Cerner Events	</p>';

            $message .= "</body>\n";
            $message .= "</html>\n";
            // $message .= "--$mime_boundary\r\n";

            $ical = 'BEGIN:VCALENDAR' . "\r\n" .
            'PRODID:-//Microsoft Corporation//Outlook 10.0 MIMEDIR//EN' . "\r\n" .
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
            'DTSTART;TZID="India Standard Time":'.date("Ymd\THis", strtotime($startTime)). "\r\n" .
            'DTEND;TZID="India Standard Time":'.date("Ymd\THis", strtotime($endTime)). "\r\n" .
            'TRANSP:OPAQUE'. "\r\n" .
            'SEQUENCE:1'. "\r\n" .
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

            include_once '../PHPMailer/PHPMailerAutoload.php';
            $mail = new PHPMailer;
            $mail->addCustomHeader('MIME-version',"1.0");
            $mail->addCustomHeader('Content-type',"text/calendar; name=event.ics; method=REQUEST; charset=UTF-8;");
            $mail->addCustomHeader('Content-type',"text/html; charset=UTF-8");
            $mail->addCustomHeader('Content-Transfer-Encoding',"7bit");
            $mail->addCustomHeader('X-Mailer',"Microsoft Office Outlook 12.0");
            $mail->addCustomHeader("Content-class: urn:content-classes:calendarmessage");
            // Set PHPMailer to use the sendmail transport
            $mail->IsSMTP();
            $mail->Host="smtplb.cerner.com";
            // $mail->isSendmail();
            $mail->SMTPAutoTLS = false;   // TO bypass the connection error(added on 2019-03-04)
            $mail->setFrom($emailbox);
            $mail->addAddress($to_address);
            $mail->Subject = $subject;
            $mail->Body=$message;
            $mail->Ical = $ical;
            // $mail->msgHTML(file_get_contents('template.html'), dirname(__FILE__));

            $mail->AltBody = 'Test';
            //Attach an image file

            //send the message, check for errors
            if(!$mail->send())
            {
              echo "Mailer Error: " . $mail->ErrorInfo;
            }
            else {
              return $uid;
              echo "Invite sent\n";
            }

            // $mailsent = mail($to_address, $subject, $message, $headers);
            //
            //return ($mailsent)?($uid):(NULL);
        }
        function sendIcalEvent_ISTmentor($from_name, $from_address, $to_name, $to_address, $startTime, $endTime, $subject, $description, $timeslot_location,$emailbox)
        {  

          //echo "Inside function\n";
            $domain = 'cerner.com';
            $uid=date("Ymd\TGis", strtotime($startTime)).rand()."@".$domain;   

            //Create Email Headers
            // $mime_boundary = "----Event Booking----".MD5(TIME());
            //
            // $headers = "From: ".$from_name." <".$from_address.">\n";
            // $headers .= "Reply-To: ".$from_name." <".$from_address.">\n";
            // $headers .= "MIME-Version: 1.0\n";
            // $headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
            // $headers .= "Content-class: urn:content-classes:calendarmessage\n";

            //Create Email Body (HTML)
            // $message = "--$mime_boundary\r\n";
            // $message .= "Content-Type: text/html; charset=UTF-8\n";
            // $message .= "Content-Transfer-Encoding: 8bit\n\n";
            $message = "<html>\n";
            $message .= "<body>\n";
            $message .= '<p>Greetings '.$to_name.', <br/> '.$description.'

            <br/>  
            <br/>
        <br/>
        Regards,
                    <br/>Cerner Events	</p>';

            $message .= "</body>\n";
            $message .= "</html>\n";
            // $message .= "--$mime_boundary\r\n";

            $ical = 'BEGIN:VCALENDAR' . "\r\n" .
            'PRODID:-//Microsoft Corporation//Outlook 10.0 MIMEDIR//EN' . "\r\n" .
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
            'DTSTART;TZID="India Standard Time":'.date("Ymd\THis", strtotime($startTime)). "\r\n" .
            'DTEND;TZID="India Standard Time":'.date("Ymd\THis", strtotime($endTime)). "\r\n" .
            'TRANSP:OPAQUE'. "\r\n" .
            'SEQUENCE:1'. "\r\n" .
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

            include_once '../PHPMailer/PHPMailerAutoload.php';
            $mail = new PHPMailer;
            $mail->addCustomHeader('MIME-version',"1.0");
            $mail->addCustomHeader('Content-type',"text/calendar; name=event.ics; method=REQUEST; charset=UTF-8;");
            $mail->addCustomHeader('Content-type',"text/html; charset=UTF-8");
            $mail->addCustomHeader('Content-Transfer-Encoding',"7bit");
            $mail->addCustomHeader('X-Mailer',"Microsoft Office Outlook 12.0");
            $mail->addCustomHeader("Content-class: urn:content-classes:calendarmessage");
            // Set PHPMailer to use the sendmail transport
            $mail->IsSMTP();
            $mail->Host="smtplb.cerner.com";
            // $mail->isSendmail();
            $mail->SMTPAutoTLS = false;   // TO bypass the connection error(added on 2019-03-04)
            $mail->setFrom($emailbox);
            $mail->addAddress($to_address);
            $mail->Subject = $subject;
            $mail->Body=$message;
            $mail->Ical = $ical;
            // $mail->msgHTML(file_get_contents('template.html'), dirname(__FILE__));

            $mail->AltBody = 'Test';
            //Attach an image file

            //send the message, check for errors
            if(!$mail->send())
            {
              echo "Mailer Error: " . $mail->ErrorInfo;
            }
            else {
              return $uid;
              echo "Invite sent\n";
            }

            // $mailsent = mail($to_address, $subject, $message, $headers);
            //
            //return ($mailsent)?($uid):(NULL);
        }
    //End misc testing
//Misc
?>
