<!DOCTYPE html>
<?php
include 'DB.php';
//$inactive = 240;
$inactive = 3240;
ini_set('session.gc_maxlifetime', $inactive);
session_start();
if (isset($_SESSION['testing']) && (time() - $_SESSION['testing'] > $inactive)) {
    // last request was more than 2 hours ago
    session_unset();     // unset $_SESSION variable for this page
    session_destroy();   // destroy session data
    header("Location:../index.php?error=Session Expired");
}
$_SESSION['testing'] = time();
if (!$_SESSION['samlNameId']) {
    $_SESSION['uri'] = $_SERVER['REQUEST_URI'];
    //    header("Location:../index.php?error=Oops!! Enter the credentials");
    header("Location:../index.php");
}
// if(!$_SESSION['fullname']){
//    header("Location:../index.php?error=Oops!! Enter the credentials");
// }

$page = $_SERVER['PHP_SELF'];
$pageprev = $_SERVER['HTTP_REFERER'];
$duh = "javascript:goBack();";
if ($pageprev != $page) {
}
$assoc_id = $_SESSION['associateId'];

$fullname = $_SESSION['fullname'];
$string = $_SESSION['role'];
$role = $_SESSION['role'];  // It has role that is assigned to associate. ** accessed in all the pages to give permissions
$company = $_SESSION['company'];
//exec("c:\WINDOWS\system32\cmd.exe /c START C:\putty.exe");

?>
<?php
if (@$_SESSION['thumbnailphoto'] != "") {
    $userimage = "data:image/jpeg;base64," . base64_encode($_SESSION['thumbnailphoto']);
} else {
    $userimage = "img/Collaborator Male_50px.png";
}
$check12 = $link->query("SELECT `role` FROM `Associate` WHERE id='$assoc_id'");
$rows12 = mysqli_fetch_row($check12);
$assoc_role = $rows12[0];
?>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" media="all" href="favicon.ico" type="image/vnd.microsoft.icon" />
    <title>BookMyEvent</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
    <link rel="stylesheet" href="plugins/ekko-lightbox/ekko-lightbox.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">
    <script src="plugins/alertify/build/alertify.min.js"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="plugins/alertify/css/alertify.min.css" />
    <!-- Default theme -->
    <link rel="stylesheet" href="plugins/alertify/themes/default.min.css" />
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="plugins/alertify/themes/semantic.min.css" />
    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="plugins/alertify/themes/bootstrap.min.css" />
    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- BootStrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>

    <style>
        .btn-primary {
            background-color: #0065A3 !important;
            border-style: none !important;
        }

        .btn-success {
            background-color: #4E832B !important;
            color: white !important;
            border-style: none !important;
        }

        .btn-secondary {
            background-color: #DEDFE0 !important;
            color: black !important;
            border-style: none !important;
        }
    </style>

    <script>
        function display_c() {
            var refresh = 1000; // Refresh rate in milli seconds
            mytime = setTimeout('display_ct()', refresh)
        }

        function display_ct() {
            var x = new Date()
            x1 = x.toTimeString();
            x2 = x1.substr(17, 40)

            var hour = x.getHours();
            var minute = x.getMinutes();
            var second = x.getSeconds();
            if (hour < 10) {
                hour = '0' + hour;
            }
            if (minute < 10) {
                minute = '0' + minute;
            }
            if (second < 10) {
                second = '0' + second;
            }
            var x3 = ' ' + hour + ':' + minute + ':' + second
            document.getElementById('ct').innerHTML = x3;
            document.getElementById('ctt').innerHTML = x2;
            display_c();
        }
    </script>
    <script>
        var d = new Date();
        x1 = d.toTimeString();
        console.log(x1);
        var n = d.getTimezoneOffset();
        var n12 = x1.substr(12, 5);
        var first = n12.substr(0, 3);
        var second = n12.substr(3, 2);
        var final = first + ':' + second
        console.log(final);
        x2 = x1.substr(17, 40);
        console.log(x2);
        //        createCookie("timezone", n, "1");

        createCookie1("timezone1", final, "1");
        createCookie2("timezone_name", x2, "1");

        function createCookie1(name, value, days) {
            var expires;
            if (days) {
                var date = new Date();

                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toGMTString();
            } else {
                expires = "";
            }
            document.cookie = escape(name) + "=" +
                escape(value) + expires + "; path=/";
        }

        function createCookie2(name, value, days) {
            var expires;
            if (days) {
                var date = new Date();

                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toGMTString();
            } else {
                expires = "";
            }
            document.cookie = escape(name) + "=" +
                escape(value) + expires + "; path=/";
        }

        // function createCookie(name, value, days) {
        //     var expires;
        //     if (days) {
        //         var date = new Date();

        //         date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        //         expires = "; expires=" + date.toGMTString();
        //     } else {
        //         expires = "";
        //     }
        //     document.cookie = escape(name) + "=" +
        //         escape(value) + expires + "; path=/";
        // }
    </script>
    <script type='text/javascript'>
        function addFields2() {
            // Number of inputs to create
            var number = document.getElementById("numberOfDependents").value;
            // Container <div> where dynamic content will be placed
            var container = document.getElementById("container");

            // Ordinals
            var ordinals = ["First", "Second", "Thrid", "Fourth", "Fifth"];

            // Clear previous contents of the container
            while (container.hasChildNodes()) {
                container.removeChild(container.lastChild);
            }

            // For each dependant, create a row
            for (i = 0; i < number; i++) {
                // Create label 
                var label = document.createElement("label");
                label.innerText = ordinals[i] + " Appt";
                container.appendChild(label);

                // Create last name
                var lastNameInput = document.createElement("input");
                lastNameInput.id = `lastName${i + 1}`;
                lastNameInput.type = "text";
                lastNameInput.className = "form-control";
                lastNameInput.placeholder = "Last Name"
                container.appendChild(lastNameInput);

                // Append a line break 
                container.appendChild(document.createElement("br"));

                // Create first name
                var firstNameInput = document.createElement("input");
                firstNameInput.id = `firstName${i + 1}`;
                firstNameInput.type = "text";
                firstNameInput.className = "form-control";
                firstNameInput.placeholder = "First Name";
                container.appendChild(firstNameInput);

                // Create row columns
                // var col1 = document.createElement("col");
                // col1.appendChild(label);

                // var col2 = document.createElement("col");
                // col2.appendChild(lastNameInput);

                // var col3 = document.createElement("col");
                // col3.appendChild(firstNameInput);

                // // Create row
                // var row = document.createElement("row");
                // row.appendChild(col1);
                // row.appendChild(col2);
                // row.appendChild(col3);

                // container.appendChild(row);

                // Append a line break 
                container.appendChild(document.createElement("br"));
            }
        }

        function addFields() {
            // Number of dependents
            var numberOfDependents = document.getElementById("numberOfDependents").value;

            // Container <div> where dynamic content will be placed
            var container = document.getElementById("container");

            // Ordinals
            var ordinals = ["First", "Second", "Thrid", "Fourth", "Fifth"];

            // Clear previous contents of the container
            while (container.hasChildNodes()) {
                container.removeChild(container.lastChild);
            }

            // Create table view
            var table = document.createElement('table');
            table.style.width = "100%";

            // For each dependant
            for (i = 0; i < numberOfDependents; i++) {
                // Create a table row 
                var tr = document.createElement('tr');

                // Create 3 table data for label, first name and last name
                var td1 = document.createElement('td');
                var td2 = document.createElement('td');
                var td3 = document.createElement('td');

                // Create label and add it to td1
                var label = document.createElement("label");
                label.innerText = ordinals[i] + " Appt";
                td1.appendChild(label);

                // Create last name and add it to td2
                var lastNameInput = document.createElement("input");
                lastNameInput.id = `lastName${i + 1}`;
                lastNameInput.type = "text";
                lastNameInput.className = "form-control";
                lastNameInput.placeholder = "Last Name"
                td2.appendChild(lastNameInput);

                // Create first name and add it to td3
                var firstNameInput = document.createElement("input");
                firstNameInput.id = `firstName${i + 1}`;
                firstNameInput.type = "text";
                firstNameInput.className = "form-control";
                firstNameInput.placeholder = "First Name";
                td3.appendChild(firstNameInput);

                // Append td to tr
                tr.appendChild(td1);
                tr.appendChild(td2);
                tr.appendChild(td3);

                // Append row to table
                table.appendChild(tr);
            }

            // Add table to container
            container.appendChild(table);
        }

        function getRegisterOption() {
            var registerOption = document.getElementById("registerOption").value;

            if (registerOption == "AssociateOnly" || registerOption == "Select") {
                document.getElementById("dependants").style.display = "none";
                document.getElementById("container").style.display = "none";
            }

            if (registerOption == "AssociateAndDependents" || registerOption == "OnlyDependants") {
                document.getElementById("dependants").style.display = "block";
                document.getElementById("container").style.display = "block";
            }
        }

        // function onClickSubmitButton() {
        //     let numberOfDependents = document.getElementById("numberOfDependents").value;

        //     let names = "";

        //     if (numberOfDependents) {
        //         for (let i = 1; i <= numberOfDependents; ++i) {
        //             let firstName = document.getElementById(`firstName${i}`).value;
        //             let lastName = document.getElementById(`lastName${i}`).value;
        //             names += `${firstName} ${lastName};`;
        //         }

        //         names = names.slice(0, -1);
        //     }

        //     //document.getElementById("registrationForm").submit();

            
        //     window.location='TimeslotDependent.php?time=123&event_id=123';
        //     alert(window.location);

        //     // var registerOption = document.getElementById("registerOption").value;
        //     // var numberOfDependents = document.getElementById("numberOfDependents").value;

        //     // var eventId = document.getElementById("eventId").value;
        //     // var time = document.getElementById("time").value;
        //     // alert(`${eventId} ${time}`);


        //     // var time = document.getElementById("time").value;
        //     // alert(time);

        //     // window.location = 'TimeslotDependent.php?time=1259&event_id=130&registerOption=AssociateAndDependents&arrayOfDependentsLength=2&arrayOfDependentNames=jam1 lakshman1; jam2 lakshman2';

        // }
    </script>
    <?php
    //    $date=date('H:i:s');
    //    $abc = -($_COOKIE["timezone"]);
    //        $_SESSION['time_zone']=intval($abc);
    //        $tz=intval($_SESSION['time_zone']);
    //        $date=date('H:i:s', strtotime("$tz minutes"));
    //        $h=floor(abs($tz)/60);
    //        if($h<10)
    //        {
    //            $h="0".$h;
    //        }
    //        $m=$tz%60;
    //        if($m<10)
    //        {
    //            $m="0".$m;
    //        }   
    //        if($tz<0){
    //        $offset="-".$h.":".$m;
    //        }else{
    //        $offset="+".$h.":".$m;
    //        }
    //        $_SESSION['utc_offset']=$offset;
    ?>
    <?php
    $offset = $_COOKIE["timezone1"];
    $_SESSION['utc_offset'] = $offset;
    $tz_name = $_COOKIE["timezone_name"];
    $_SESSION['timezone_name'] = $tz_name;
    if ($offset == "-06:00" || $offset == "-05:00") {
        date_default_timezone_set("America/Chicago");
    } else if ($offset == "+05:30") {
        date_default_timezone_set("Asia/Kolkata");
    }
    ?>

    <style>
        @media (min-width:1200px) {
            .container {
                max-width: 2000px
            }
        }

        @media (min-width:1600px) {
            .container {
                max-width: 2800px
            }
        }

        ::-webkit-scrollbar {
            width: 5px;
        }

        /* Track */

        ::-webkit-scrollbar-track {
            background: #ffffff;
        }

        /* Handle */

        ::-webkit-scrollbar-thumb {
            background: #888;
        }

        /* Handle on hover */

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        thead {
            background-image: linear-gradient(to right, #343a40 0, #6c747f 100%);
            color: white;
            text-align: center
        }

        .divscroll {
            overflow: scroll;
            height: 280px;
            display: hidden;
        }

        .divscroll1 {
            overflow: scroll;
            height: 280px;
        }

        th {
            text-align: center;
            font-size: 13px;
        }

        .sidebar-dark-primary {
            background-image: linear-gradient(to bottom, #343a40 0, #1f2634 100%);
        }

        .ctsPower {
            font-size: 7px;
            color: white;
            text-align: right;
            width: 97%;
            margin-top: 2%;
            margin-bottom: 0%;
            font-family: "Roboto", "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-style: italic;
        }

        .navbar-inverse .navbar-nav>.open>a,
        .navbar-inverse .navbar-nav>.open>a:focus,
        .navbar-inverse .navbar-nav>.open>a:hover {
            background-color: #0D94D2;
        }

        .card-header>.fa,
        .card-header>.glyphicon,
        .card-header>.ion,
        .card-header .card-title {
            display: inline-block;
            font-size: 14px;
            margin: 0;
            line-height: 1;
            padding: 3px
        }

        card-title {
            font-size: 20px;
        }

        .table>tbody>tr>td,
        .table>tbody>tr>th,
        .table>tfoot>tr>td,
        .table>tfoot>tr>th,
        .table>thead>tr>td,
        .table>thead>tr>th {
            padding: 4px;
            line-height: 1.42857143;
            vertical-align: top;
            border-top: 1px solid #ddd;
        }

        .card {
            border: 0 solid rgba(255, 255, 255);
        }

        .card-header {
            padding-bottom: 2px;
            padding-top: 2px;
            padding-left: 2px;
            padding-right: 2px;
        }

        .card-body {
            padding-bottom: 4px;
            padding-top: 4px;
            padding-left: 3px;
            padding-right: 3px;
        }

        .fa {
            color: #0D94D2
        }
    </style>
    <!-- Matomo -->
    <script type="text/javascript">
        var _paq = window._paq || [];
        /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
        _paq.push(['trackPageView']);
        _paq.push(['enableLinkTracking']);
        (function() {
            var u = "//bookmyevent.cerner.com/BME/";
            _paq.push(['setTrackerUrl', u + '../Motamo/matomo.php']);
            _paq.push(['setSiteId', '11']);
            var d = document,
                g = d.createElement('script'),
                s = d.getElementsByTagName('script')[0];
            g.type = 'text/javascript';
            g.async = true;
            g.defer = true;
            g.src = u + '../Motamo/matomo.js';
            s.parentNode.insertBefore(g, s);
        })();
    </script>
    <!-- End Matomo Code -->
</head>

<body class="sidebar-mini sidebar-collapse layout-navbar-fixed text-sm" onload="display_ct()">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom-0 text-sm">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link"> <i class="fa fas fa-clock"></i>&nbsp;
                        <span id='ct' style="font-family:Verdana,sans-serif"></span>
                        <span id='ctt' style=" font-family:Verdana, sans-serif"></span>
                    </a>
                </li>
            </ul>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Messages Dropdown Menu -->
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="index.php" class="nav-link"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fa fas fa-random"></i> Switch Role
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <div class="dropdown-divider"></div>
                        <?php if (($assoc_role == 'Super Admin')) { ?>
                            <a href="scripts/switchroles.php?id=10" class="dropdown-item">
                                <i class="fa fas fa-cogs"></i> Super Admin
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="scripts/switchroles.php?id=15" class="dropdown-item">
                                <i class="fa fas fa-user-cog"></i> Administrator
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="scripts/switchroles.php?id=20" class="dropdown-item">
                                <i class="fa fas fa-user"></i> Associate
                            </a>
                        <?php } else if ($assoc_role == 'Administrator') { ?>
                            <div class="dropdown-divider"></div>
                            <a href="scripts/switchroles.php?id=15" class="dropdown-item">
                                <i class="fa fas fa-user-cog"></i> Administrator
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="scripts/switchroles.php?id=20" class="dropdown-item">
                                <i class="fa fas fa-user"></i> Associate
                            </a>
                        <?php  } else { ?>
                            <div class="dropdown-divider"></div>
                            <a href="scripts/switchroles.php?id=20" class="dropdown-item">
                                <i class="fa fas fa-user"></i> Associate
                            </a>
                        <?php } ?>

                    </div>
                </li>
                <?php if (($_SESSION['role'] == 'Super Admin')) { ?>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="Past_Events.php" class="nav-link"><i class="fa fa-clock" aria-hidden="true"></i> Past Events</a>
                    </li>
                <?php } ?>

                <li class="nav-item d-none d-sm-inline-block">
                    <a target="_blank" href="../Manual/index.html" class="nav-link"><i class="fa fa-info-circle" aria-hidden="true"></i> Help</a>
                </li>

            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary">
            <!-- Brand Logo -->
            <a href="index.php" class="brand-link">
                <img src="dist/img/cern1.png" alt="AdminLTE Logo" class="brand-image img-circle" style="opacity: .8">
                <span class="brand-text font-weight-light">
                    <b style='font-size:19px;font-family:bahnschrift'>BookMyEvent</b>
                </span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?php echo $userimage; ?>" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"> <?php echo $_SESSION['fullname']; ?><div style='font-size:9px'><?php echo $_SESSION['role']; ?></div></a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="Profile.php" class="nav-link">
                                <i class="nav-icon fas fa-user-cog text-warning"></i>
                                <p>My Profile</p>
                            </a>
                        </li>
                        <?php if (($_SESSION['role'] == 'Super Admin')) { ?>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-cogs text-info"></i>
                                    <p>
                                        Super Admin
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="Request_Action.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Access Requests</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="Add_User.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add User</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="Admin_Profile.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Admin Profile</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="BME_analysis.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>BME Analysis</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="BME_Feedback.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>BME Suggestions</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="Mailbox_Action.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Mailbox Requests</p>
                                        </a>
                                    </li>
                                    <!--
                                <li class="nav-item">
                                    <a href="../Motamo/index.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Motamo Analysis</p>
                                    </a>
                                </li>
-->
                                    <li class="nav-item">
                                        <a href="Visitors.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Visitors</p>
                                        </a>
                                    </li>
                                </ul>
                            </li><?php } ?>
                        <?php if (($_SESSION['role'] == 'Super Admin') || ($_SESSION['role'] == 'Administrator')) { ?>
                            <li class="nav-item">
                                <a href='Add_Event.php' class="nav-link">
                                    <i class="nav-icon fas fa-calendar-plus"></i>
                                    <p>Add Event</p>
                                </a>
                            </li>
                        <?php } else { ?><li class="nav-item">
                                <a href='AccessRequest.php' class="nav-link">
                                    <i class="nav-icon fas fa-calendar-plus"></i>
                                    <p>Add Event</p>
                                </a>
                            </li> <?php } ?>
                        <?php if (($_SESSION['role'] == 'Super Admin') || ($_SESSION['role'] == 'Administrator')) { ?>

                            <li class="nav-item">
                                <a href='Add_Timeslot.php' class="nav-link">
                                    <i class="nav-icon fas fa-user-clock"></i>
                                    <p>Add Timeslot</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="Add_Mail.php" class="nav-link">
                                    <i class="nav-icon fas fa-envelope-open"></i>
                                    <p>Add Mailbox</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="Add_Host.php" class="nav-link">
                                    <i class="nav-icon fas fas fa-user-plus"></i>
                                    <p>Add Event Host</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="BME_analysis.php" class="nav-link">
                                    <i class="nav-icon fas fa-chart-pie"></i>
                                    <p>Analysis</p>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper text-sm">
            <!-- Main content -->
            <section class="content text-sm">