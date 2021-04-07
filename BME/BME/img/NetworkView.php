<?php
	include "header.php";
	include "DB.php";
$id=$_GET['id'];
if($id==1){
    $state=$_GET['state'];
$country=$_GET['country'];
$query="select * from `NetworkDetails` where state='$state' and country='$country'";
                    $result = $link->query($query) or die("Error0 : ".mysqli_error($link));
                    $arr=  mysqli_fetch_row($result);
}
else if($id==2){
    $Make=$_GET['Make'];
$country=$_GET['country'];
$building=$_GET['building'];
$query="select * from `NetworkDetails` where Make='$Make' and country='$country' and Location='$building'";
                    $result = $link->query($query) or die("Error0 : ".mysqli_error($link));
                    $arr=  mysqli_fetch_row($result);

}
else if($id==3){
$country=$_GET['country'];
$building=$_GET['building'];
$query="select * from `NetworkDetails` where Location='$building' and country='$country'";
                    $result = $link->query($query) or die("Error0 : ".mysqli_error($link));
                    $arr=  mysqli_fetch_row($result);
}
else if($id==4){
    $state=$_GET['state'];
$country=$_GET['country'];
    $building=$_GET['building'];
$query="select * from `NetworkDetails` where state='$state' and country='$country' and Location='$building'";
                    $result = $link->query($query) or die("Error0 : ".mysqli_error($link));
                    $arr=  mysqli_fetch_row($result);
}

                else{
                    $query="select * from `NetworkDetails`";
                    $result = $link->query($query) or die("Error0 : ".mysqli_error($link));
                    $arr=  mysqli_fetch_row($result);
                }


	?>
    <br/>
    <div class="col-lg-12">
        <div class="box">
            <div class="divscroll">
                <div class="box-header">
                    <h3 class="box-title"> Details</h3>
                    <p id="hid" style="float:right; margin-right:25px;">
                        <a href="#" target="_blank" title="Export as CSV File"><img src="./img/csv.png" width="25" height="25" /></a> &nbsp &nbsp
                        <a href="#" target="_blank" title="Export as Excel File"><img src="./img/xls.png" width="25" height="25" /></a> &nbsp &nbsp
                        <a href="#" target="_blank" title="Export as XML File"><img src="./img/xml.png" width="25" height="25" /></a>
                        <br /> </p>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-2">
                            <h4 style="background-color:#E54444;color:white"> <?php echo $_GET['status'];?></h4></div>
                    </div>
                    <table id="exampledu" class="table table-bordered table-hover table-condensed">
                        <thead>
                            <tr>
                                <th>Edit</th>
                                <th>DEVICE NAME</th>
                                <th>IP ADDRESS</th>
                                <th>MODEL</th>
                                <th>SERIAL NUMBER</th>
                                <th>MAC ADDRESS</th>
                                <th>MAKE</th>
                                <th>LOCATION</th>
                                <th>ASSET TYPE</th>
                                <th>PO Number</th>
                                <th>PO Date</th>
                                <th>Asset Tag</th>
                                <th>Country</th>
                                <th>Condition</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($arr[0]!='') do{?>
                                <tr>
                                    <td>
                                        <!--<a href="projEdit.php?slno=<?php //echo $arr[0]?>"><img src="img/Update.png" width="20" height="20" /></a>--></td>
                                    <td>
                                        <?php echo $arr[1];?>
                                    </td>
                                    <td>
                                        <?php echo $arr[2];?>
                                    </td>
                                    <td>
                                        <?php echo $arr[3];?>
                                    </td>
                                    <td>
                                        <?php echo $arr[4];?>
                                    </td>
                                    <td>
                                        <?php echo $arr[5];?>
                                    </td>
                                    <td>
                                        <?php echo $arr[6];?>
                                    </td>
                                    <td>
                                        <?php echo $arr[7];?>
                                    </td>
                                    <td>
                                        <?php echo $arr[8];?>
                                    </td>
                                    <td>
                                        <?php echo $arr[9];?>
                                    </td>
                                    <td>
                                        <?php echo $arr[10];?>
                                    </td>
                                    <td>
                                        <?php echo $arr[11];?>
                                    </td>
                                    <td>
                                        <?php echo $arr[12];?>
                                    </td>
                                    <td>
                                        <?php echo $arr[13];?>
                                    </td>
                                </tr>
                                <?php

}while($arr=mysqli_fetch_row($result));?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
    <?php include 'footer.php'; ?>