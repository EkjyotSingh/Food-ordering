<?php
include('header.php');
//if(!isset($_SESSION['failed']))
//{
//   redirect(constant('FETCH_PATH').'shop'); 
//}
?>
<div class="breadcrumb-area gray-bg">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="<?php echo constant('FETCH_PATH')?>shop">Shop</a></li>
                <li class="active">Failed </li>
            </ul>
        </div>
    </div>
</div>
<div class="contact-area pt-100 pb-60">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-9 d-flex align-items-center ek mb-100">
                <div class="overview-content-2">
                    <h2>Your transaction is<span> failed </span>!</h2>
                </div>
            </div>
            <div class="cart-shiping-update ml-20">
                <a href="<?php echo constant('FETCH_PATH')?>shop">Continue Shopping</a>
            </div>
            <div class="cart-clear ml-20">
                <a href="<?php echo constant('FETCH_PATH')?>checkout">Checkout</a>
            </div>
            <div class="cart-clear ml-20">
                <a href="<?php echo constant('FETCH_PATH')?>wallet">Wallet</a>
            </div>
        </div>
    </div>
</div>
        
<?php
unset($_SESSION['failed']);
include('footer.php');?>