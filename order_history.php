<?php
include('header.php');
if(!isset($_SESSION['USER_ID'])){
    redirect(constant('FETCH_PATH').'shop');
}
//prx($_SESSION);
if(isset($_POST['cancel_order'])){
    if(isset($_POST['oid']) && $_POST['oid']>0){
        $oid=$_POST['oid'];
        $uid=$_SESSION['USER_ID'];
        $smtm=$con->prepare("Update full_order set order_status='cancelled',cancelled_by='Cancelled by you' where id='$oid' and user_id='$uid' and order_status='pending'");
        $smtm->execute();
    }
    redirect(constant('FETCH_PATH').'order_history');
}
?>
<div class="cart-main-area pt-80 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <h4 class="wallet_heading">Your Orders</h4>
                    <div class=" table-content table-responsive empty-cart-append">
                    <?php
                        $id=$_SESSION['USER_ID'];
                        $smtm=$con->prepare("select * from full_order where user_id='$id' order by id desc");
                        $smtm->execute();
                        $orders=$smtm->fetchAll(PDO::FETCH_ASSOC);
                        if(count($orders)>0){?>
                        <table class="table-hover">
                            <thead>
                                <tr>
                                    <th class="white-space">S.No</th>
                                    <th class="white-space">Order Status</th>
                                    <th class="white-space">Final Price</th>
                                    <th class="white-space">Payment Status</th>
                                    <th class="white-space">Coupon Code/Discount</th>
                                    <th class="white-space">Name/ Email/ Mobile</th>
                                    <th class="white-space">Address/ City/ Zipcode</th>
                                    <th class="white-space">Added On</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i=1;
                                foreach( $orders as $order){?>
                                <tr class="clickable-row" data-href="<?php echo constant('FETCH_PATH').'order_detail?id='.$order['id']?>">
                                    <td class="padding"><?php echo $i++ ?></br>
                                    <?php if($order['order_status']=='delivered'){?>
                                        <form action="<?php echo constant('FETCH_PATH').'invoice'?>" method="post" >
                                            <input type="hidden" value="<?php echo $order['id']?>" name="oid">
                                            <button type="submit" title="Download invoice" style="border:none;background:transparent;"><svg class="icon icon-file-pdf"><use xlink:href="<?php echo constant('FETCH_PATH')?>assets/img/sprite.svg#icon-file-pdf"></use></svg></button>
                                        </form>
                                        <?php }?>
                                    </td>
                                    <?php
                                        if($order['order_status']=='cancelled'){?>
                                            <td class="padding"><?php echo $order['cancelled_by']?></td>
                                        <?php }else{?>
                                            <td class="padding"><?php echo $order['order_status']?></br>
                                        <?php }?>

                                        <?php
                                        if($order['order_status']=='pending'){
                                             ?>
                                            <form method="post" action="<?php echo constant('FETCH_PATH').'order_history'?>">
                                                <input type="hidden" name="oid" value="<?php echo $order['id']?>">
                                                <button type="submit" class="cancel_button" name="cancel_order">Cancel</button>
                                            </form>
                                        <?php }?>
                                    </td>
                                    <td class="padding"><?php echo 'Rs '.$order['final_price']?></td>
                                    <td class="padding"><?php echo ucfirst($order['payment_status'])?></td>
                                    <td class="padding"><span><?php 
                                    if($order['coupon']!='NA'){echo $order['coupon'];}?></br>
                                    <?php 
                                    if($order['coupon']!='NA'){echo 'Rs '.$order['discount'];}?></span></td>

                                    <td class="padding"><span><?php echo $order['full_name']?></br>
                                    <?php echo $order['email']?></br><?php echo $order['mobile']?></span></td>

                                    <td class="padding"><span><?php echo $order['address']?></br>
                                    <?php echo $order['city']?></br><?php echo $order['zipcode']?></span></td>

                                    <td class="padding"><?php echo $order['added_on']?></td>
                                    
                                </tr>
                            <?php }?>
                            </tbody>
                        </table>
                        <?php }else{
                        echo '<h6 class="text-danger mb-30 no-content">No orders!</h6>';
                        }?>
                    </div>
            </div>
        </div>
    </div>
</div>
<?php
include('footer.php');?>