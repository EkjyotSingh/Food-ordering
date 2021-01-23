<?php
include('header.php');
if(isset($_POST['delete'])){
    delete_full_cart();
    redirect(constant('FETCH_PATH').'cart_page');
}
if(isset($_POST['update'])){
    $quantity=$_POST['quantity'];
    if(isset($_SESSION['USER_ID'])){
        $id=$_SESSION['USER_ID'];
        foreach( $quantity as $key=>$value){
            if($value[0]==0){
                $smtm=$con->prepare("delete from cart where user_id='$id' and attribute_id='$key'");
                $smtm->execute();
            }else{
                $smtm=$con->prepare("update cart set quantity='$value[0]' where user_id='$id' and attribute_id='$key'");
                $smtm->execute();
            }
        }
    }else{
        foreach( $quantity as $key=>$value){
            if($value[0]==0){
                unset($_SESSION['cart'][$key]);
            }else{
                $_SESSION['cart'][$key]['quantity']=$value[0];
            }
        }
    }
    redirect(constant('FETCH_PATH').'cart_page');
}
?>
<div class="cart-main-area pt-95 pb-100">
            <div class="container">
                <h3 class="page-title">Your cart items</h3>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <form method="post">
                            <div class="table-content table-responsive empty-cart-append">
                                <?php
                                if($totalprice>0){?>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Product Name</th>
                                            <th>Unit Price</th>
                                            <th>Qty</th>
                                            <th>Subtotal</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach( $cartarray as $key=>$cart){?>
                                        <tr class="cart_page_dish_<?php echo $key?>">
                                            <td class="product-thumbnail">
                                                <a href="#"><img src="<?php echo constant('DISH_FETCH').$cart['image']?>" class="dish-image" alt="<?php echo $cart['dish']?>"></a>
                                            </td>
                                            <td class="product-name"><a href="#"><?php echo $cart['dish']?></a></td>
                                            <td class="product-price-cart"><span class="amount"><?php echo 'Rs '.$cart['price']?></span></td>
                                            <td class="product-quantity">
                                                <div class="cart-plus-minus">
                                                    <input class="cart-plus-minus-box" type="text" name="quantity[<?php echo $key?>][]" value="<?php echo $cart['quantity']?>">
                                                </div>
                                            </td>
                                            <td class="product-subtotal"><?php echo 'Rs '.$cart['price']*$cart['quantity']?></td>
                                            <td class="product-remove">
                                                <a href="javascript:void(0)" onclick="delete_from_cart(<?php echo $key?>,'delete')"><i class="fa fa-times"></i></a>
                                           </td>
                                        </tr>
                                    <?php }?>
                                    </tbody>
                                </table>
                                <?php }else{
                                    echo '<h6 class="text-danger">Cart Empty!</h6>';
                                }?>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="cart-shiping-update-wrapper">
                                        <div class="cart-shiping-update">
                                            <a href="<?php echo constant('FETCH_PATH')?>shop">Continue Shopping</a>
                                        </div>
                                        <?php
                                        if($totalprice>0){?>
                                        <div class="cart-clear">
                                            <button name="update" type="submit">Update Shopping Cart</button>
                                            <form method="post">
                                                <button type="submit" name="delete">Clear Shopping Cart</button>
                                            </form>
                                            <a href="<?php echo constant('FETCH_PATH')?>checkout" class="ek-checkout-button">Checkout</a>
                                        </div>
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        include('footer.php');?>