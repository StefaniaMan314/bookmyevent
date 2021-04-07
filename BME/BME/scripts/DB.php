<?php
date_default_timezone_set("Asia/Kolkata");

  $link = mysqli_connect("localhost","root","cernces6435","BME1");
  // Check connection
  if (mysqli_connect_errno())
    {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    $link2 = mysqli_connect("localhost","root","cernces6435","BME1");
    // Check connection
    if (mysqli_connect_errno())
      {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }

  $audit = mysqli_connect("localhost","root","cernces6435","BME1");
  if (mysqli_connect_errno())
    {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $oncall = mysqli_connect("localhost","root","cernces6435","BME1");
    // Check connection
    if (mysqli_connect_errno())
      {
      echo "oncall Failed to connect to MySQL: " . mysqli_connect_error();
      }
$connect = mysqli_connect("localhost","root","cernces6435","BME1");
$link1 = mysqli_connect("localhost","root","cernces6435","BME1");
$events_demo=array('Automation to Enable CI/CD','Emerging Markets','Analytics in Action','Culture','Firsthand Volunteers','Infra Technocrats','CTS Nonpareil
','Dev Gurus','Amazon Web Services','Lead The Way');
$descriptions_demo=array('Welcome to the world of Continuous Advancement, to enable continuous client value through the timely, simplified, and reliable delivery of superior-quality solutions and services.
Do you like solving problems, writing awesome code, or doing patch backs, manual testing and running after VDIs?
Come join us this Monday (29th January 2018) and watch how we increase speed to market, decrease overall costs with increased solution quality.','One of the most popular town hall questions over the years has been When are we entering the Indian market? The answer to that is Now!. From establishing the initial proof points with Cerner Smart Health, to signing up the first Indian client, to delivering futuristic prototypes, its all happening at the Emerging Markets kiosks. Come, join us and be a part of the India journey!','The Analytics in Action floor walk event will provide attendees with a glimpse into the world of Big Data and Analytics. We provide a quick overview of the growing importance of Analytics across domains and the manner in which different organizations are investing in the Digitalization story. The focus of the event is to not only cover theoretical examples but instead provide associates the opportunity to get an interactive experience of the power of analytics and the different ways in which these are being leveraged across Cerner India. Attendees will also get an opportunity to match wits against Machine Learning intelligence as part of the floor walk.','They say that the journey is the destination and Cerner India has been on a quest to build learning opportunities that enable and empower associates. The culture of learning event gives you a glimpse at some of the initiatives that have provided associates with the opportunity to engage and learn.','Make a difference in your community, come Volunteer for First Hand, India!','Description_6','Description_7','Description_8','Description_9','Description_10');
$dates_demo=array('2019-07-16','2019-07-17','2019-07-18','2019-07-19','2019-07-20','2019-07-21','2019-07-22','2019-07-23','2019-07-24','2019-07-25');
$locations_demo=array('H2 L6','H2 L4','H2 L5','H2 L7','H2 L9','C2 L6','C2 L7','H2 L10','C2 L6','H2 L8');
$images_demo=array('imgs/automation5.png','imgs/emerging4.png','imgs/analytics7.png','imgs/culture6.png','firsthand.png','imgs/Infra Technocrats.png','imgs/ctsnon.png','imgs/dev_gurus.png','imgs/aws.png','imgs/leadership.png');
$session_count=array('15','20','10','15','15','20','20','20','15','20');
$start_demo=array('11:30:00','12:00:00','12:30:00','13:00:00','13:30:00','14:00:00','14:30:00','15:00:00');
$end_demo=array('12:30:00','13:00:00','13:30:00','14:00:00','14:30:00','15:00:00','15:30:00','16:00:00');


//echo "DB file\n";
?>
