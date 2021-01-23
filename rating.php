<?php
session_start();
include('connect.php');
include('function.php');
if(isset($_POST['value'])){
$value=$_POST['value'];
$dish_detail_id=$_POST['dish_detail_id'];
$full_order_id=$_POST['full_order_id'];
//$arr=array('Bad','Below Average','Average','Good','Very Good');
$id=$_SESSION['USER_ID'];
$a=$value;
$smtm=$con->prepare("insert into rating(user_id,order_id,dish_detail_id,review) values('$id','$full_order_id','$dish_detail_id','$a')");
$smtm->execute();
}
?>