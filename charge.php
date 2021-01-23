<?php 
session_start();
require('function.php');
require('constant.php');
require('connect.php');
require('stripe-php-master/init.php');

//prx($_POST);
if(isset($_POST['stripeToken']) && isset($_POST['amount']) && isset($_POST['for'])){
    $stripe = new \Stripe\StripeClient(constant('STRIPE_SECRET_KEY'));
    if($_POST['for'] == 'wallet'){
        $description='Added by user from stripe';
        $charge=$stripe->charges->create([
            'amount' =>  $_POST['amount']*100,
            'currency' => 'inr',
            'source' => $_POST['stripeToken'],
            'description' => $description,
            ]);
            if($charge->status=='succeeded'){
                wallet_money_manage($_SESSION['USER_ID'],$_POST['amount'],$description,'added',$charge->id);
                redirect(constant('FETCH_PATH').'wallet');
            }else{
                $_SESSION['failed']='yes';
                redirect(constant('FETCH_PATH').'transaction_failed');
            }
    }else{
        $total_price=final_price_for_gateway();
        $charge=$stripe->charges->create([
            'amount' =>  $total_price*100,
            'currency' => 'inr',
            'source' => $_POST['stripeToken'],
            'description' => 'Deducted for order',
            ]);
            if($charge->status=='succeeded'){
                $payment_status='paid';
                $amount=($charge->amount)/100;
                place_final_order($payment_status,$charge->id,$amount);
                redirect(constant('FETCH_PATH').'success');
            }else{
                checkout_sessions();
                $_SESSION['failed']='yes';
                redirect(constant('FETCH_PATH').'transaction_failed');
            }
    }
}else{
    redirect(constant('FETCH_PATH').'wallet');
}

?>