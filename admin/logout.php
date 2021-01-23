<?php session_start();
include('../function.php');
include('../constant.php');
unset($_SESSION['is_login']);
unset($_SESSION['name']);
redirect(constant('FETCH_ADMIN_PATH').'login');
?>