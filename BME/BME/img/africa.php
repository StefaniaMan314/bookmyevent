<!DOCTYPE html>
<html>
<?php include 'DB.php';
   
    $query="SELECT * FROM driveCountries";
$result = $link->query($query) or die("Error0 : ".mysqli_error($link));
$arr=  mysqli_fetch_row($result);
    $query23="SELECT COUNT(*) FROM driveCountries";
$result23 = $link->query($query23) or die("Error0 : ".mysqli_error($link));
$arr23=  mysqli_fetch_row($result23);
   ?>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>CTS- Asset Manager</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- jvectormap -->
        <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
        <!-- Material Design -->
        <link rel="stylesheet" href="dist/css/bootstrap-material-design.min.css">
        <link rel="stylesheet" href="dist/css/ripples.min.css">
        <link rel="stylesheet" href="dist/css/MaterialAdminLTE.min.css">
        <!-- MaterialAdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="dist/css/skins/all-md-skins.min.css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
        <style>
            .myBackground {
                background-color: rgba(255, 255, 255, 0.3);
                color: inherit;
            }
            
            .rtnow {
                box-shadow: 2px 2px 2px #888888
            }
            
            .box-title {
                color: #0D94D2;
                font-weight: bolder;
                /*color: #7C2B83;*/
            }
        </style>
    </head>

    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <div class="content-wrapper">
                <section class="content">
                    <!-- /.row -->
                    <!-- /.row -->
                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <div class="col-md-8">
                            <!-- MAP & BOX PANE -->
                            <div class="box myBackground rtnow">
                                <div class="box-header">
                                    <h3 class="box-title">One-Drive Global Report</h3>
                                    <div class='pull-right'>
                                        <p id="hid" style="float:right; margin-right:25px;">
                                            <a href="testCountry.php" title="Refresh"><img src="img/Restart_48px.png" width="25" height="25" /></a>
                                        </p>
                                    </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body no-padding">
                                    <div class="row">
                                        <div class="col-md-9 col-sm-8">
                                            <div class="pad">
                                                <!-- Map will be created here -->
                                                <div id="world-map-markers" style="height: 420px;"></div>
                                            </div>
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-md-3 col-sm-4">
                                            <div class="pad box-pane-right" style="height: 127px;background-color:#7BC143;color:white">
                                                <div class="description-block margin-bottom">
                                                    <?php 
                            $query1="select Count(*) from euc1_global";
$result1 = $link->query($query1) or die("Error0 : ".mysqli_error($link));
$arr1=  mysqli_fetch_row($result1); 
                            ?>
                                                        <div class="sparkbar pad" style='font-size:20px' data-color="#fff">Total Users: <b><?php echo $arr1[0]; ?></b> </div>
                                                        <?php 
                            $query1="select Count(*) from euc1_global where Drive='Yes'";
$result1 = $link->query($query1) or die("Error0 : ".mysqli_error($link));
$arr1=  mysqli_fetch_row($result1); 
                            ?> <span class="description-text" style='color:green;'><b>Using One-Drive: <?php echo $arr1[0]; ?></b></span>
                                                            <?php 
                            $query1="select Count(*) from euc1_global where Drive='No'";
$result1 = $link->query($query1) or die("Error0 : ".mysqli_error($link));
$arr1=  mysqli_fetch_row($result1); 
                            ?>
                                                                <br/><span class="description-text" style='color:#e60000;'><b>Not Using One-Drive: <?php echo $arr1[0]; ?></b></span></div>
                                                <!-- /.description-block -->
                                            </div>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <!-- /.row -->
                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
                        <!-- /.col -->
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        </div>
        <!-- ./wrapper -->
        <!-- jQuery 2.2.3 -->
        <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <!-- Material Design -->
        <script src="dist/js/material.min.js"></script>
        <script src="dist/js/ripples.min.js"></script>
        <script>
            $.material.init();
        </script>
        <!-- FastClick -->
        <script src="plugins/fastclick/fastclick.js"></script>
        <!-- AdminLTE App -->
        <script src="dist/js/app.min.js"></script>
        <!-- Sparkline -->
        <script src="plugins/sparkline/jquery.sparkline.min.js"></script>
        <!-- jvectormap -->
        <script src="plugins/world/jquery-jvectormap.js"></script>
        <script src="plugins/world/jquery-jvectormap-us-aea.js"></script>
        <!-- SlimScroll 1.3.0 -->
        <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <!-- ChartJS 1.0.1 -->
        <script src="plugins/chartjs/Chart.min.js"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <!-- AdminLTE for demo purposes -->
        <script src="dist/js/demo.js"></script>
        <script>
            $(function () {
                $('#map').vectorMap({
                    map: 'us_aea'
                });
            });
        </script>
    </body>

</html>