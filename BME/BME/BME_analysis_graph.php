<!DOCTYPE html>
<html>
<?php 
include "DB.php";
?>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://www.amcharts.com/lib/4/core.js"></script>
    <script src="https://www.amcharts.com/lib/4/charts.js"></script>
    <script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
    <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
    <script src="https://www.amcharts.com/lib/3/serial.js"></script>
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">

    <script>
        $(function() {
            $("#slot").on('change', function() {

                var slot = document.getElementById('slot').value;
                if (slot) {
                    $.ajax({
                        type: 'POST',
                        url: 'fetchevents.php',
                        data: {

                            slot: slot

                        },
                        success: function(html) {
                            $('#tab1').html(html);
                        }
                    });
                }
            });
        });
        // end am4core.ready()
        var chartData = [<?php $sql2="SELECT `slno`,`month`,`year`,`event_count`,`registration_count` FROM `bme_analysis`  ORDER BY slno";
        $result2 = mysqli_query($link,$sql2);

        while ($roww2 = mysqli_fetch_array($result2))
		{
			$month=mysqli_real_escape_string($link, $roww2[1]); 
                $year=$roww2[2];
				  $event_count=$roww2[3];
				    $registration_count=$roww2[4];
            
                ?> {
                "period": "<?php echo substr($month,0,3); ?> \n  <?php echo $year; ?>",
                "E v e n t s": "<?php echo $event_count; ?>",
                "R e g i s t r a t i o n s": "<?php echo $registration_count; ?>"

            }, <?php } ?>


        ];
        var chart = AmCharts.makeChart("chartdiv6", {
            "type": "serial",
            "theme": "none",


            "dataProvider": chartData,

            "addClassNames": true,
            "startR e g i s t r a t i o n s": 1,
            //"color": "#FFFFFF",
            "marginLeft": 0,

            "categoryField": "period",
            "categoryAxis": {
                "parseperiods": true,
                "autoGridCount": false,
                "gridCount": 50,
                "gridAlpha": 0.1,
                "gridColor": "#FFFFFF",
                "axisColor": "#555555",

            },

            "valueAxes": [{
                "id": "a1",
                "title": "R e g i s t r a t i o n s",
                "gridAlpha": 0,
                "axisAlpha": 0,
                "gridColor": "#FFFFFF"
            }, {
                "id": "a2",
                "position": "right",
                "gridAlpha": 0,
                "axisAlpha": 0,
                "labelsEnabled": false
            }, {
                "id": "a3",
                "title": "E v e n t s",
                "position": "right",
                "gridAlpha": 0,
                "axisAlpha": 0,
                "gridColor": "#FFFFFF",
                "inside": true,
                "R e g i s t r a t i o n s": "mm",
                "R e g i s t r a t i o n sUnits": {
                    "DD": "d. ",
                    "hh": "h ",
                    "mm": "min",
                    "ss": ""
                }
            }],
            "graphs": [{
                "id": "g1",
                "valueField": "R e g i s t r a t i o n s",
                "title": "Registrations",
                "type": "column",
                "fillAlphas": 0.9,
                "valueAxis": "a1",
                "balloonText": "[[value]] Registrations",
                "legendValueText": "[[value]]  ",
                "legendPeriodValueText": "total: [[value.sum]] ",
                "lineColor": "#0D94D2",
                "alphaField": "alpha"
            }, {
                "id": "g3",
                "title": "Events",
                "valueField": "E v e n t s",
                "type": "line",
                "valueAxis": "a3",
                "lineColor": "#7BC143",
                "balloonText": "[[value]] Events ",
                "lineThickness": 3,
                "legendValueText": "[[value]] ",
                "legendPeriodValueText": "total: [[value.sum]] ",
                "bullet": "square",
                "bulletBorderColor": "#7BC143",
                "bulletBorderThickness": 1,
                "bulletBorderAlpha": 1,
                "dashLengthField": "dashLength",
                "animationPlayed": false
            }],

            "chartCursor": {
                "zoomable": false,

                "cursorAlpha": 0,
                "valueBalloonsEnabled": false
            },
            "legend": {
                "bulletType": "round",
                "equalWidths": false,
                "valueWidth": 120,
                "useGraphSettings": true,
                //"color": "#FFFFFF"
            }
        });

    </script>
    <style>
        /* Style the tab */
        .tab {
            overflow: hidden;
            border: 1px solid white;
            background-color: white;
        }

        /* Style the buttons inside the tab */
        .tab button {
            background-color: white;
            border-style: solid;
            border-color: #259ED6 #E1E3E5 white #E1E3E5;
            float: left;

            border-width: 3px 2px 2px 1px;
            cursor: pointer;
            padding: 14px 16px;
            transition: 0.3s;
            font-size: 17px;
            font-color: #F4FAFD;
        }

        /* Change background color of buttons on hover */
        .tab button:hover {
            background-color: white;
        }

        /* Create an active/current tablink class */
        .tab button.active {
            background-color: white;
            border-color: #259ED6 #E1E3E5 #E1E3E5 #E1E3E5;
        }

        /* Style the tab content */
        .tabcontent {
            display: none;
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-top: none;
            background-color: white;
        }

        #chartdiv1 {
            width: 100%;
            height: 300px;
        }

        #chartdiv2 {
            width: 100%;
            height: 300px;
        }

        #chartdiv3 {
            width: 100%;
            height: 300px;
        }

        #chartdiv4 {
            width: 100%;
            height: 300px;
        }

        #chartdiv5 {
            width: 100%;
            height: 300px;
        }


        #chartdiv6 {
            width: 100%;
            height: 300px;

        }

        .amcharts-chart-div a {
            display: none !important;
        }

    </style>
</head>


<body>
    <div class="box" style="background: #FFFFFF;">
        <?php 
$query1=("SELECT SUM(registration_count) FROM `bme_analysis`  ");
		$result1=mysqli_query($link,$query1) or die();
$arr1=  mysqli_fetch_row($result1);
$total_registrations=$arr1[0];
$total_cost=$total_registrations*(2.5);

?> <div class='card-header'>
            <div class="row">
                <div class="col-lg-7">
                    <h3 style='color:#0D94D2'> <i class="nav-icon fas fa-chart-pie"></i> &nbsp;BME Registrations Analysis </h3>
                </div>
                <div class="col-lg-5">
                    <h5> Total Registrations: <?php echo $total_registrations; ?> </h5>
                    <h6> Total Cost Saved : <b style="color:red">$<?php echo $total_cost; ?> </b> ($2.5 per registration) </h6>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="chartdiv6"></div>
            </div>
        </div>
    </div>
</body>

</html>
