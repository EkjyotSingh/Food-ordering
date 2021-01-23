<?php
include('header.php');
if(!isset($_SESSION['full_order_id'])){
   redirect(constant('FETCH_PATH').'shop'); 
}
?>
<div class="breadcrumb-area gray-bg">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="<?php echo constant('FETCH_PATH')?>shop">Shop</a></li>
                <li class="active">Success </li>
            </ul>
        </div>
    </div>
</div>
<div class="contact-area pt-100 pb-100">
            <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-7 d-flex align-items-center">
                <div class="overview-content-2">
                    <h2>Order has been placed <span>succesfully</span> !</h2>
                    <?php echo $_SESSION['full_order_id']?>
                </div>
            </div> 
        </div>
    </div>
</div>
        
<?php
unset($_SESSION['full_order_id']);
include('footer.php');?>