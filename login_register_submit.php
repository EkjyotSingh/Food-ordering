<?php
session_start();
include('connect.php');
include('function.php');
include('constant.php');
$type=$_POST['type'];
$arr=array();
if($type=='register'){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $mobile=$_POST['mobile'];
    $password=$_POST['password'];
    $dbpassword=password_hash($password,PASSWORD_BCRYPT);
    $rows=$con->query("select Count(*) from user where email='$email'")->fetchColumn();
    if($rows>0){
        $arr=array('status'=>'error','message'=>'Email already registered','error_field'=>'email');
    }else{
        $str=str_shuffle('abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz');
        $str=substr($str,15,15);
        register($name,$email,$mobile,$dbpassword,'1','0',$str);
        $html=constant('FETCH_PATH').'email_verified.php?id='.$str;
        $subject="Email Verification";
        if($email!='' && $html!='' && $subject!=''){
            //emailer($email,$html,$subject);
        }
        $arr=array('status'=>'success','message'=>'Thanks for registering.Email has been sent to your email address,please verify your email','error_field'=>'form_message');
    }
    echo json_encode($arr);   
}
if($type=='login'){
    $checkout=$_POST['checkout'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $arr=array();
    $smtm=$con->prepare("select * from user where email='$email'");
    $smtm->execute();
    $rows=$smtm->fetch(PDO::FETCH_ASSOC);
    if(!isset($rows['id'])){
        $arr=array('status'=>'error','message'=>'Email is not registered','error_field'=>'email');
    }
    elseif($rows['verified']!='1'){
        $arr=array('status'=>'error','message'=>'Your email address is not verified','error_field'=>'form');

    }
    elseif($rows['status']!='1'){
        $arr=array('status'=>'error','message'=>'Your account is deactivated','error_field'=>'form');

    }elseif($rows['password']=='google'){
        $arr=array('status'=>'error','message'=>'This email is logged in with google','error_field'=>'form');
    }
    else{
        $dbpassword=$rows['password'];
        if(password_verify($password,$dbpassword)){
            $_SESSION['USER_LOGIN']='yes';
            $_SESSION['USER_NAME']=$rows['name'];
            $_SESSION['USER_ID']=$rows['id'];
            if($checkout=='yes'){
                $arr=array('status'=>'checkout');
            }else{
                $arr=array('status'=>'success');
            }
            if(isset($_SESSION['cart']) && count($_SESSION['cart'])>0){
                foreach($_SESSION['cart'] as $key=>$value){
                    $attribute=$key;
                    $quantity=$value['quantity'];
                    add_cart($attribute,$quantity);
                }
            }
    }else{
        $arr=array('status'=>'error','message'=>'Your password is incorrect','error_field'=>'password');
    }
    }
    echo json_encode($arr);
}
if($type=='forgot'){
    $email=$_POST['email'];
    $smtm=$con->query("select count(*) from user where email='$email' and password !='google'")->fetchColumn();
    if($smtm>0){
    $password=rand(111111111111,999999999999);
    $dbpassword=password_hash($password,PASSWORD_BCRYPT);
    $smtm=$con->prepare("update user set password='$dbpassword' where email='$email'");
    $smtm->execute();
    $html="<h4>".$password."</h4>";
    $subject='New Password';
    emailer($email,$html,$subject);
    $arr=array('status'=>'success','message'=>'Password has been sent to email account given by you');
    }else{
        $arr=array('status'=>'error','message'=>'Email not registered');

    }
    echo json_encode($arr);
}
?>

