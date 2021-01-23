<?php session_start();
include('../function.php');
include('../constant.php');
unset($_SESSION['delivery_boy_login']);
unset($_SESSION['delivery_boy_id']);
unset($_SESSION['delivery_boy_name']);

redirect(constant('FETCH_DELIVERY_PATH').'login');
?>