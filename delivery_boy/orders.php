<?php 
session_start();
include('../connect.php');
include('../function.php');
include('../constant.php');
if(isset($_SESSION['delivery_boy_login']) && $_SESSION['delivery_boy_login']=='yes'){

}else{
    redirect(constant('FETCH_DELIVERY_PATH').'login');
}

$id=$_SESSION['delivery_boy_id'];
$smtm=$con->prepare("select * from full_order where delivery_boy_id='$id' order by id desc");
$smtm->execute();
$rows=$smtm->fetchAll(PDO::FETCH_ASSOC);

if(isset($_GET['delivered']) && $_GET['delivered']>0){
    $oid=$_GET['delivered'];
    $delivered_at=date('Y-m-d,h:i:s');
    $smtm=$con->prepare("update full_order set order_status='delivered',delivered_at='$delivered_at',payment_status='paid' where delivery_boy_id='$id' and id='$oid'");
    $smtm->execute();
    //redirect(constant('FETCH_DELIVERY_PATH').'orders');

}
//prx($rows);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Delivery Boy Orders</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="<?php echo constant('FETCH_DELIVERY_PATH')?>assets/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="<?php echo constant('FETCH_DELIVERY_PATH')?>assets/css/style.css">
  <link rel="stylesheet" href="<?php echo constant('FETCH_DELIVERY_PATH')?>assets/css/custom.css">
</head>
<body class="sidebar-light">
    <!--<div class="preloader">
        <div class="black"></div>
    </div>-->
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
            <?php include('nav.php');?>
            <div class="main-panel">
                <div class="content-wrapper" style="width:100vw;">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="mb-4">Orders</h2>
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table  class="table">
                                            <thead>
                                                <tr>
                                                    <th>S.no #</th>
                                                    <th>Name/Mobile</th>
                                                    <th>Address/City/Zipcode</th>
                                                    <th>Added On</th>
                                                    <th>Final Price</th>
                                                    <th>Payment Status</th>
                                                    <th>Delivered</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if(count($rows)>0){
                                                    foreach($rows as $row){?>
                                                    <tr class="">
                                                        <td class="pl-4"><?php echo $row['id']?></td>
                                                        <td class="pl-4"><span class="table_row"><?php echo $row['full_name']?></br><?php echo $row['mobile']?></span></td>
                                                        <td class="pl-4"><span class="table_row"><?php echo $row['address']?></br><?php echo $row['city']?></br><?php echo $row['zipcode']?></span></td>
                                                        <td class="pl-4"><?php echo $row['added_on']?></td>
                                                        <td class="pl-4"><?php echo $row['final_price']?></td>
                                                        <td class="pl-4"><?php echo $row['payment_status']?></td>
                                                        <?php
                                                        if($row['order_status'] !='delivered'){?>
                                                        <td class="pl-4"><a href="<?php echo constant('FETCH_DELIVERY_PATH')?>orders?delivered=<?php echo $row['id']?>"> Deliver Order</a></td>
                                                        <?php }else{?>
                                                            <td class="pl-4">Delivered</td>
                                                        <?php }?>
                                                    </tr>
                                                    <?php }?>
                                            </tbody>
                                            <?php
                                            }else{
                                                echo"<tr><td class='text-left text-sm-center text-danger' colspan='7'> No orders recieved yet</td></tr>";
                                            }?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="d-flex justify-content-center">
                <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © <?php echo date('Y')?> <a href="https://www.urbanui.com/" target="_blank">Urbanui</a>. All rights reserved.</span>
            </div>
        </footer>
    </div>
        <!-- partial -->
</div>
    <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
    <!-- container-scroller -->

  <!--plugins:js-->
  <script src="<?php echo constant('FETCH_DELIVERY_PATH')?>assets/js/jquery-3.5.1.min.js"></script>
  <script src="<?php echo constant('FETCH_DELIVERY_PATH')?>assets/js/vendor.bundle.base.js"></script>
  <!-- End custom js for this page-->
</body>
</html>