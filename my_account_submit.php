<?php
session_start();
include('function.php');
include('constant.php');
include('connect.php');
if(!isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN']!='yes'){
    redirect(constant('FETCH_PATH').'shop');
   }
//   prx($_POST[]);
$id=$_SESSION['USER_ID'];
$type=$_POST['type'];
if($type=='name_details'){
    $name=$_POST['name'];
    $mobile=$_POST['mobile'];
    $smtm=$con->prepare("update user set name='$name',mobile='$mobile' where id='$id'");
    $smtm->execute();
    $_SESSION['USER_NAME']=$name;
}
if($type=='password_details'){
    $old_password=$_POST['old_password'];
    $smtm=$con->prepare("select * from user where id='$id'");
    $smtm->execute();
    $row=$smtm->fetch(PDO::FETCH_ASSOC);
    if(password_verify($old_password,$row['password'])){
        $new_password=$_POST['new_password'];
        $db_password=password_hash($new_password,PASSWORD_BCRYPT);
        $smtm=$con->prepare("update user set password='$db_password' where id='$id'");
        $smtm->execute();
        echo 'success';
    }else{
        echo 'error';
    }
}
?>