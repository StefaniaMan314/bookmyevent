<?php


$emailbox="BookMyEvent@cerner.com";
      $from_name="BookMyEvent@cerner.com";
      $from_address="BookMyEvent@cerner.com";
      $to_name='Priyanka';
      $to_address='priyanka.bandaru@cerner.com';
      $startTime='2020-01-22 17:16:18';
      $endTime='2020-01-22 18:16:18';
      $subject='Test Invite';
      $description='Test Message';
      $location='C2-5th Floor';

      
	  
	  $assoc_id="PB073127";
	  $ref_id='UID001';
	  
	   $text = "https://bookmyevent.cerner.com/BME/associate_attend.php?uid=$ref_id&assoc_id=$assoc_id"; 
   
$path = 'images/'; 
$file = $path.uniqid().".png"; 
  
$ecc = 'S'; 
$pixel_Size = 5; 
$frame_Size = 5; 
  
// Generates QR Code and Stores it in directory given 
QRcode::png($text, $file, $ecc, $pixel_Size, $frame_size); 




?>