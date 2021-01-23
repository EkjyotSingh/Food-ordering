<?php
include('header.php');
//prx($_SERVER);
$show='';
$payment='';
$not_login_show='';
$not_login_payment='';
$wallet_status='';
$wallet_class='';
if($totalprice<=0){
    redirect(constant('FETCH_PATH').'shop');
}
if(isset($_SESSION['USER_ID'])){
    if($totalprice>$wallet_amount){
        $wallet_status='disabled';
        $wallet_class='notactive';
    }
}
if(isset($_SESSION['USER_ID'])){
    $not_login_show='show';
    $not_login_payment='payment';
}else{
    $show='show';
    $payment='payment';
}
checkout_sessions();
    //prx($_SESSION);
?>
<script src="https://js.stripe.com/v3/"></script>
<div class="checkout-area pb-80 pt-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="checkout-wrapper">
                            <div id="faq" class="panel-group">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h5 class="panel-title"><span>1.</span> <a data-toggle="collapse" data-parent="#faq" href="#payment-1">Checkout method</a></h5>
                                    </div>
                                    <div id="<?php echo $payment?>-1" class="panel-collapse collapse <?php echo $show?>">
                                        <div class="panel-body">
                                            <div class="row">
                                                <!--<div class="col-lg-5">
                                                    <div class="checkout-register">
                                                        <div class="title-wrap">
                                                            <h4 class="cart-bottom-title section-bg-white">CHECKOUT AS A GUEST OR REGISTER</h4>
                                                        </div>
                                                        <div class="register-us">
                                                            <ul>
                                                                <li><input type="checkbox"> Checkout as Guest</li>
                                                                <li><input type="checkbox"> Register</li>
                                                            </ul>
                                                        </div>
                                                        <h6>REGISTER AND SAVE TIME!</h6>
                                                        <div class="register-us-2">
                                                            <p>Register with us for future convenience.</p>
                                                            <ul>
                                                                <li>Fast and easy checkout</li>
                                                                <li>Easy access to your order history and status</li>
                                                            </ul>
                                                        </div>
                                                        <a href="#">Apply Coupon</a>
                                                    </div>-->
                                                </div>
                                                <div class="col-lg-9 text-center">
                                                    <div class="checkout-login">
                                                        <div class="title-wrap">
                                                            <h4 class=" section-bg-white">LOGIN</h4>
                                                        </div>
                                                        <p class="text-left text-danger">Already have an account? </p>
                                                        <span class="text-left">Please log in below:</span>
                                                        <form class="login_form" method="post">
                                                            <div class="text-left login-form login_form">
                                                                <label >Email Address<span class="text-danger"> *</span> </label>
                                                                <input type="email" class="login_email" required>
                                                                <span class="email_message text-danger"></span>
                                                            </div>
                                                            <div class="text-left login-form">
                                                                <label >Password <span class="text-danger"> *</span></label>
                                                                <input type="password" class="login_password" required>
                                                                <span class="password_message text-danger"></span>
                                                            </div>
                                                            <div class="login-forget">
                                                                <a href="<?php echo constant('FETCH_PATH')?>forgot">Forgot your password?</a>
                                                                <p>* Required Fields</p>
                                                            </div>
                                                            <div class="checkout-login-btn">
                                                                <button type="submit" class="login_button">Login</button>
                                                                <span><a href="<?php echo constant('FETCH_PATH')?>login_register" class="checkout-register-btn">Register</a></span>
                                                            </div>
                                                            <input type="hidden" class="login_type" value="login">
                                                            <input type="hidden" class="login_checkout" value="yes">
                                                        </form>
                                                    </div>
                                                    <span class="text-left mt-4 login_message text-danger"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h5 class="panel-title"><span>2.</span> <a data-toggle="collapse" data-parent="#faq" href="#payment-2">billing information</a></h5>
                                        </div>
                                        <div id="<?php echo $not_login_payment?>-2" class="panel-collapse collapse <?php echo $not_login_show?>">
                                            <div class="panel-body">
                                                <div class="billing-information-wrapper">
                                                <form class="detail_form" method="post">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6">
                                                            <div class="billing-info">
                                                                <label>Full Name</label>
                                                                <input type="text" class="checkout_name" required onchange="detail_update()">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6">
                                                            <div class="billing-info">
                                                                <label>Mobile Number</label>
                                                                <input type="text" class="checkout_mobile" required onchange="detail_update()">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6">
                                                            <div class="billing-info">
                                                                <label>Email Address</label>
                                                                <input type="email" class="checkout_email" required onchange="detail_update()">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6">
                                                            <div class="billing-info">
                                                                <label>Zip/Postal Code</label>
                                                                <input type="text" class="checkout_zipcode" required onchange="detail_update()">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12">
                                                            <div class="billing-info">
                                                                <label>Address</label>
                                                                <input type="text" class="checkout_address" required onchange="detail_update()">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6">
                                                            <div class="billing-info">
                                                                <label>city</label>
                                                                <input type="text" class="checkout_city" required onchange="detail_update()">
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="billing-back-btn">
                                                        <div class="billing-back">
                                                            <a href="#"><i class="ion-arrow-up-c"></i> back</a>
                                                        </div>
                                                        <div class="billing-btn">
                                                            <button type="submit" class="detail_button">Next</button>
                                                        </div>
                                                    </div>
                                                </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h5 class="panel-title"><span>3.</span> <a data-toggle="collapse" data-parent="#faq" href="#payment-5">payment information</a></h5>
                                        </div>
                                        <div id="<?php echo $not_login_payment?>-5" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <form method="post" class="payment_form">
                                                    <div class="payment-info-wrapper">
                                                        <div class="ship-wrapper">
                                                            <div class="single-ship">
                                                                <input id="cod" type="radio" checked="checked" value="cod" name="checkout_payment" onchange="payment_update()">
                                                                <label for="cod">Cash on delivery</label>
                                                            </div>
                                                            <div class="single-ship">
                                                                <input id="stripe" type="radio" value="stripe" name="checkout_payment" onchange="payment_update()">
                                                                <label for="stripe">Stripe</label>
                                                            </div>
                                                            <div class="single-ship">
                                                                <input id="paytm" type="radio" value="paytm" name="checkout_payment" onchange="payment_update()">
                                                                <label for="paytm">Paytm</label>
                                                            </div>
                                                            <div class="single-ship">
                                                                <input id="wallet" <?php echo $wallet_status?> type="radio" value="wallet" name="checkout_payment" onchange="payment_update()">
                                                                <label for="wallet"><span class="<?php echo $wallet_class?>">Wallet</span></label>
                                                                <?php
                                                                if(isset($_SESSION['USER_ID'])){
                                                                if($totalprice>$wallet_amount){?>
                                                                <a href="<?php echo constant('FETCH_PATH').'wallet'?>" class="low-wallet-link">(Low amount refill your wallet)</a>
                                                               <?php }}?>
                                                            </div>
                                                        </div>
                                                        <div class="billing-back-btn">
                                                            <div class="billing-back">
                                                                <a href="#"><i class="ion-arrow-up-c"></i> back</a>
                                                            </div>
                                                            <div class="billing-btn">
                                                                <button type="submit" class="payment_button">Next</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h5 class="panel-title"><span>4.</span> <a data-toggle="collapse" data-parent="#faq" href="#payment-6">Order Review</a></h5>
                                        </div>
                                        <div id="<?php echo $not_login_payment?>-6" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="order-review-wrapper">
                                                    <div class="order-review">
                                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="width-1">Product Name/Type</th>
                                                                        <th class="width-2">Price</th>
                                                                        <th class="width-3">Quantity</th>
                                                                        <th class="width-4">Total</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach($cartarray as $list){?>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="o-pro-dec">
                                                                                <p><?php echo $list['dish'].' ('.$list['attribute'].')'?></p>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="o-pro-price">
                                                                                <p><?php echo 'Rs '.$list['price']?></p>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="o-pro-qty">
                                                                                <p><?php echo $list['quantity']?></p>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="o-pro-subtotal">
                                                                                <p><?php echo 'Rs '.$list['price']*$list['quantity']?></p>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <?php }?>
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <td colspan="3"><span class="text-bold">Subtotal</span></td>
                                                                        <td><b>Rs</b>&nbsp;<span class="text-bold total-price"><?php echo $totalprice?></span></td>
                                                                    </tr>
                                                                    <!--<tr class="tr-f">
                                                                        <td colspan="3">Shipping & Handling (Flat Rate - Fixed</td>
                                                                        <td colspan="1">Rs 45.00</td>
                                                                    </tr>-->
                                                                    <tr class="coupon-minus">
                                                                        <td colspan="1" class="text-left">
                                                                            <form method="post" class="coupon_form">
                                                                                <input type="text" class="coupon-input" placeholder="Coupon Code">
                                                                                <button type="submit" class="ml-10 apply_coupon">
                                                                                    Apply &nbsp;Coupon
                                                                                </button>
                                                                            </form>
                                                                        </td>
                                                                        
                                                                    </tr>
                                                                    <tr class="coupon-final">
                                                                        <td colspan="2" class="text-left coupon_message text-danger" style=" font-size: 13px;"></td>
                                                                        <td ><span class="text-bold">Grand Total</span></td>
                                                                        <td class="without-coupon"><span class="text-bold amount" data-amount="<?php echo $totalprice?>">Rs&nbsp;<?php echo $totalprice?></span></td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                        <div class="billing-back-btn">
                                                            <span>
                                                                Forgot an Item?
                                                                <a href="<?php echo constant('FETCH_PATH')?>cart_page"> Edit Your Cart</a>
                                                            </span>
                                                            <div class="billing-btn">
                                                                <button type="button" onclick="place_order()" class="place_button">Place Order</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<script>
        alert('This website is for demo purpose.\nPaytm wallet test details are\n\nMobile Number: 7777777777\nPassword: Paytm1234\nOTP: 489871\n\nStripe test details are\nCard Number: 4242424242424242\nExpiry Date & CVC: Any number');
</script>
<?php
include('footer.php');?>