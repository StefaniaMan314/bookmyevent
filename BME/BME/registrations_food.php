<?php
session_start();
$offset=$_SESSION['utc_offset'];
$event_id=$_GET['id'];
$foodsession=$_GET['foodsession'];


$DB_Server = "localhost"; // MySQL Server
$DB_Username = "root"; // MySQL Username
$DB_Password = "cernces6435"; // MySQL Password
$DB_DBName = "BME1"; // MySQL Database Name
//$DB_TBLName = "testevent"; // MySQL Table Name
 
/***** DO NOT EDIT BELOW LINES *****/
// Create MySQL connection
//Select t.`AssociateID`, t.`AssociateName`, t.`email`, t.`Title`, t.`department`, t.`Organization`,t.`Executive`,CONVERT_TZ(ts.`start`,'+00:00','$offset') AS start,CONVERT_TZ(ts.`end`,'+00:00','$offset') AS end,ts.`session_name` AS Session FROM `testevent` t,`timeslot` ts WHERE  t.$foodsession='1' AND  t.event='$event_id' AND t.booked='1' 
$sql = "Select  `AssociateID`, `AssociateName`, `email`, `Title`, `department`, `timeslot1` AS Timeslot , `dietary`  FROM `testevent` WHERE $foodsession='1' AND event='$event_id' AND booked='1'";
$Connect = @mysqli_connect($DB_Server, $DB_Username, $DB_Password,$DB_DBName) or die("Failed to connect to MySQL:<br />" . mysql_error() . "<br />" . mysql_errno());
// Select database
//$Db = @mysql_select_db($DB_DBName, $Connect) or die("Failed to select database:<br />" . mysql_error(). "<br />" . mysql_errno());
// Execute query
$result = @mysqli_query($Connect,$sql) or die("Failed to execute query:<br />" . mysql_error(). "<br />" . mysql_errno());
 
 $query1=("SELECT * FROM `timeslot` where  slno='$slot' ");
		$result1=mysqli_query($Connect,$query1);
$arr1=  mysqli_fetch_row($result1);
$session_name=$arr1[6];


 $query1=("SELECT * FROM `event` where  slno='$event_id' ");
		$result1=mysqli_query($Connect,$query1);
$arr1=  mysqli_fetch_row($result1);
$event_name=$arr1[1];


 $xls_filename = $foodsession.date('Y-m-d').'.xls'; // Define Excel (.xls) file name


// Header info settings
header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=$xls_filename");
header("Pragma: no-cache");
header("Expires: 0");
 
/***** Start of Formatting for Excel *****/
// Define separator (defines columns in excel &amp; tabs in word)
$sep = "\t"; // tabbed character
 function mysqli_field_name($result, $field_offset)
{
    $properties = mysqli_fetch_field_direct($result, $field_offset);
    return is_object($properties) ? $properties->name : null;
}
// Start of printing column names as names of MySQL fields
for ($i = 0; $i<mysqli_num_fields($result); $i++) {
  echo mysqli_field_name($result, $i) . "\t";
}
print("\n");
// End of printing column names
 
// Start while loop to get data
while($row = mysqli_fetch_row($result))
{
  $schema_insert = "";
  for($j=0; $j<mysqli_num_fields($result); $j++)
  {
    if(!isset($row[$j])) {
      $schema_insert .= "NULL".$sep;
    }
    elseif ($row[$j] != "") {
      $schema_insert .= "$row[$j]".$sep;
    }
    else {
      $schema_insert .= "".$sep;
    }
  }
  $schema_insert = str_replace($sep."$", "", $schema_insert);
  $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
  $schema_insert .= "\t";
  print(trim($schema_insert));
  print "\n";
}
?>