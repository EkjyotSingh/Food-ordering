<?php
include('connect.php');
include('function.php');
include('constant.php');
if(isset($_GET['id']) && $_GET['id']!=''){
    $string=$_GET['id'];
    $smtm=$con->prepare("update user set verified='1' where email_verify_string='$string'");
    $row=$smtm->execute();
    redirect(constant('FETCH_PATH').'login_register');
}
?>