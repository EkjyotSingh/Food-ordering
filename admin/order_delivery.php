<?php 
include('top.php');
include('nav.php');
$order_id=$_GET['order_id'];

if(isset($_GET['delivery_boy_id'])){
    $delivery_boy_id=$_GET['delivery_boy_id'];
    $smtm=$con->prepare("update full_order set delivery_boy_id='$delivery_boy_id' where id='$order_id'");
    $smtm->execute();
    redirect(constant('FETCH_ADMIN_PATH')."order_detail?id=".$order_id);

}
if(isset($_GET['order_status'])){
    $order_status=$_GET['order_status'];
    $smtm=$con->prepare("update full_order set order_status='$order_status' where id='$order_id'");
    $smtm->execute();
    redirect(constant('FETCH_ADMIN_PATH')."order_detail?id=".$order_id);

}
?>