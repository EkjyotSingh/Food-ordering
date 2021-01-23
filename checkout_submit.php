<?php
session_start();
include('connect.php');
include('function.php');
include('constant.php');

$type=$_POST['type'];
if($type=='checkout_detail'){
    $_SESSION['checkout_name']=$_POST['checkout_name'];
    $_SESSION['checkout_email']=$_POST['checkout_email'];
    $_SESSION['checkout_address']=$_POST['checkout_address'];
    $_SESSION['checkout_city']=$_POST['checkout_city'];
    $_SESSION['checkout_mobile']=$_POST['checkout_mobile'];
    $_SESSION['checkout_zipcode']=$_POST['checkout_zipcode'];
}
if($type=='checkout_payment'){
    $_SESSION['checkout_payment']=$_POST['checkout_payment'];
    
}

if($type=='coupon'){
    $coupon_code=$_POST['coupon_code'];
    $smtm=$con->prepare("select * from coupon_code where coupon_code='$coupon_code' and status='1'");
    $smtm->execute();
    $row=$smtm->fetchAll(PDO::FETCH_ASSOC);
    if(count($row)>0){
        if(strtotime($row[0]['expired_on'])>strtotime(date('Y-m-d'))){
            $cartarray=fetch_cart();
            $total_price=total_price($cartarray);
            if($total_price>=$row[0]['cart_min_value']){
                if($row[0]['coupon_type']=='F'){
                    $discount=ceil($row[0]['coupon_value']);
                    $arr=array('status'=>'success','coupon_code'=>$row[0]['coupon_code'],'discount'=>$discount);
                }else{
                    $discount=ceil(($total_price*$row[0]['coupon_value'])/100);
                    $arr=array('status'=>'success','coupon_code'=>$row[0]['coupon_code'],'discount'=>$discount);
                }
                $_SESSION['coupon']=$row[0]['coupon_code'].'_'.$discount;
            }else{
                unset($_SESSION['coupon']);
                $arr=array('status'=>'minimum_cart','min'=>$row[0]['cart_min_value']);
            }
        }else{
            unset($_SESSION['coupon']);
            $arr=array('status'=>'expired');
        }
        
    }else{
        unset($_SESSION['coupon']);
        $arr=array('status'=>'invalid');
    }
    echo json_encode($arr);
    
}

if($type=='remove_coupon_code'){
    unset($_SESSION['coupon']);
}

if($type=='order_placed'){
    $payment_type=$_SESSION['checkout_payment'];
        if($payment_type=='wallet'){
            $payment_status='paid';
        }
        if($payment_type=='cod'){
            $payment_status='pending';
        }
        $transaction_id='ORDS'.rand(10000,99999999);
        $response=place_final_order($payment_status,$transaction_id);
        if($payment_type=='wallet'){
            $total_price=$response[1];
            wallet_money_manage($_SESSION['USER_ID'],$total_price,'Shopped','withdraw');
        }
        echo $response[0];
    
}

?>