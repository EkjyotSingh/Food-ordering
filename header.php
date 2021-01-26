<?php
session_start();
include('connect.php');
include('constant.php');
include('function.php');
//prx($_SESSION);
$search_input='';
switch($_SERVER['PHP_SELF']){
    case constant('PHP_SELF_FRONT_URL').'shop.php':
    $title='Shop';
    break;
    case constant('PHP_SELF_FRONT_URL').'login_register.php':
    $title='Food Ordering SignIn';
    break;
    case constant('PHP_SELF_FRONT_URL').'contact_us.php':
    $title='Contact Us';
    break;
    case constant('PHP_SELF_FRONT_URL').'about.php':
    $title='About';
    break;
    case constant('PHP_SELF_FRONT_URL').'order_history.php':
    $title='Order History';
    break;
    case constant('PHP_SELF_FRONT_URL').'checkout.php':
    $title='Checkout';
    break;
    case constant('PHP_SELF_FRONT_URL').'wallet.php':
    $title='Wallet';
    break;
    case constant('PHP_SELF_FRONT_URL').'my_account.php':
    $title=$_SESSION['USER_NAME'];
    break;
    case constant('PHP_SELF_FRONT_URL').'cart_page.php':
    $title='Cart Page';
    break;
    case constant('PHP_SELF_FRONT_URL').'cart_page.php':
    $title='Cart Page';
    break;
    case constant('PHP_SELF_FRONT_URL').'order_detail.php':
    $title='Order Detail';
    break;
    default:
    $title='Food Ordering';
    break;
}



if(isset($_GET['search']) && $_GET['search']!=''){
    $search_input=$_GET['search'];
}
$shopping_cart_setting='shopping-cart-content';
if($_SERVER['PHP_SELF']==constant('FAILED')){
    unset($_SESSION['add_money']);
    }
$cartarray=fetch_cart();
$totalprice= total_price($cartarray);
//prx($_SESSION);
?>

<!doctype html>
<html class="no-js" lang="zxx">
<head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title><?php echo $title?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?php echo constant('FETCH_PATH')?>assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo constant('FETCH_PATH')?>assets/css/animate.css">
        <link rel="stylesheet" href="<?php echo constant('FETCH_PATH')?>assets/css/owl.carousel.min.css">
        <link rel="stylesheet" href="<?php echo constant('FETCH_PATH')?>assets/css/slick.css">
        <link rel="stylesheet" href="<?php echo constant('FETCH_PATH')?>assets/css/chosen.min.css">
        <link rel="stylesheet" href="<?php echo constant('FETCH_PATH')?>assets/css/ionicons.min.css">
        <link rel="stylesheet" href="<?php echo constant('FETCH_PATH')?>assets/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo constant('FETCH_PATH')?>assets/css/simple-line-icons.css">
        <link rel="stylesheet" href="<?php echo constant('FETCH_PATH')?>assets/css/jquery-ui.css">
        <link rel="stylesheet" href="<?php echo constant('FETCH_PATH')?>assets/css/meanmenu.min.css">
        <link rel="stylesheet" href="<?php echo constant('FETCH_PATH')?>assets/css/style.css">
        <link rel="stylesheet" href="<?php echo constant('FETCH_PATH')?>assets/css/responsive.css">
        <link rel="stylesheet" href="<?php echo constant('FETCH_PATH')?>assets/css/custom.css">
        <script src="<?php echo constant('FETCH_PATH')?>assets/js/vendor/modernizr-2.8.3.min.js"></script>
        <script src="<?php echo constant('FETCH_PATH')?>assets/js/jquery-3.5.1.min.js"></script>
        <script>let stripe_key="<?php echo constant('STRIPE_PUBLISHABLE_KEY')?>";</script>
    </head>
    <body>
        <!--<div class="preloader">
            <div class="black"></div>
        </div>-->
        <!-- header start -->
        <header class="header-area">
            <div class="header-top black-bg">
                <div class="container">
                <?php
                //prx($_SESSION);
                if(isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN']=='yes'){
                    $shopping_cart_setting='shopping-cart-setting';
                    $id=$_SESSION['USER_ID'];
                    $smtm=$con->prepare("select * from wallet where user_id='$id' order by id desc");
                    $smtm->execute();
                    $wallets=$smtm->fetchAll(PDO::FETCH_ASSOC);
                    $withdraw=0;
                    $added=0;
                    foreach($wallets as $wallet){
                        if($wallet['type']=='withdraw'){
                            $withdraw=$withdraw+$wallet['amount'];
                        }
                        if($wallet['type']=='added'){
                            $added=$added+$wallet['amount'];
                        }
                    }
                    $wallet_amount=$added-$withdraw;
                    ?>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-12 col-sm-4">
                            <!--<div class="welcome-area">
                                <p>Default welcome msg! </p>
                            </div>-->
                        </div>
                        <div class="col-lg-8 col-md-8 col-12 col-sm-8">
                            <div class="account-curr-lang-wrap f-right">
                                <ul>
                                <li class="top-hover"><a href="<?php echo constant('FETCH_PATH')?>wallet" class="user_name user_name_first">
                                    Wallet- <?php echo 'Rs '.$wallet_amount?></a>
                                    <li class="top-hover"><a href="javascript:void(0)" class="user_name1 ml-3 ml-md-2"><?php echo ucfirst($_SESSION['USER_NAME'])?>  <i class="ion-chevron-down"></i></a>
                                        <ul>
                                            <li><a href="<?php echo constant('FETCH_PATH')?>my_account">my account</a></li>
                                            <li><a href="<?php echo constant('FETCH_PATH')?>order_history">Order History</a></li>
                                            <li><a href="<?php echo constant('FETCH_PATH')?>logout">Logout</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                </div>
            </div>
            <div class="header-middle">
                <div class="container">
                    <div class="row" style="align-items:center">
                        <div class="col-lg-3 col-md-4 col-12 col-sm-4">
                        <a href="<?php echo constant('FETCH_PATH')?>index">
                            <div class="logo">
                                <img alt="" src="<?php echo constant('FETCH_PATH')?>media/logo/logo2.png" style="width:134px; height:60px;">
                            </div>
                        </a>
                        </div>
                        <div class="col-lg-9 col-md-8 col-12 col-sm-8">
                            <div class="header-middle-right f-right">
                                <div class="header-login">
                                <?php
                                    if(!isset($_SESSION['USER_LOGIN']) || $_SESSION['USER_LOGIN']!='yes'){?>
                                        <a href="<?php echo constant('FETCH_PATH')?>login_register" class="header-login-inner">
                                            <div class="header-icon-style">
                                                <i class="icon-user icons"></i>
                                            </div>
                                            <div class="login-text-content">
                                                <p>Register <br> or <span>Sign in</span></p>
                                            </div>
                                        </a>
                                        <?php }?>
                                </div>
                                <div class="header-wishlist">
                                   &nbsp;
                                </div>
                                <?php
                                if($_SERVER['PHP_SELF']!=constant('CHECKOUT')){?>
                                <div class="header-cart">
                                    <a href="javascript:void(0)">
                                        <div class="header-icon-style">
                                            <i class="icon-handbag icons"></i>
                                            <span class="count-style"><?php echo count($cartarray)?></span>
                                        </div>
                                        <div class="cart-text">
                                            <span class="digit">My Cart</span>
                                            <span class="cart-digit-bold">
                                            <?php
                                            if($totalprice>0){

                                                echo 'Rs '.$totalprice;
                                            }?>
                                            </span>
                                        </div>
                                    </a>
                                    <?php 
                                    if($totalprice>0){?>
                                    <div class=" <?php echo $shopping_cart_setting?>">
                                        <ul class="cart-list">
                                            <?php foreach( $cartarray as $key=>$cart){?>
                                                <li class="single-shopping-cart single-shopping-cart-<?php echo $key?>">
                                                <div class="shopping-cart-img">
                                                    <img alt="<?php echo $cart['dish']?>" class="dish-image" src="<?php echo constant('DISH_FETCH').$cart['image']?>">
                                                </div>
                                                <div class="shopping-cart-title">
                                                    <h4><a href="javascript:void(0)"><?php echo $cart['dish']?></a></h4>
                                                    <h6>Qty:<?php echo $cart['quantity']?></h6>
                                                    <span><?php echo 'Rs '.$cart['quantity']*$cart['price']?></span>
                                                </div>
                                                <div class="shopping-cart-delete">
                                                    <a href="javascript:void(0)" onclick="delete_from_cart(<?php echo $key?>,'delete')"><i class="ion ion-close"></i></a>
                                                </div>
                                            </li>
                                            <?php }?>
                                        </ul>
                                        <div class="shopping-cart-total">
                                            <h4>Total : <span class="shop-total"><?php echo 'Rs '.$totalprice?></span></h4>
                                        </div>
                                        <div class="shopping-cart-btn">
                                        <a href="<?php echo constant('FETCH_PATH')?>cart_page">view cart</a>
                                        <a href="<?php echo constant('FETCH_PATH')?>checkout">Checkout</a>
                                        </div>
                                    </div>
                                    <?php }?>
                                </div> 
                                 <?php }?>                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-bottom transparent-bar black-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="main-menu">
                                <nav class="main_nav">
                                    <ul>
                                        <li><a href="<?php echo constant('FETCH_PATH')?>index">Home</a></li>
                                        <?php $s='';
                                        if( $_SERVER['PHP_SELF']==constant('SHOP')){
                                            $s='noti_active';
                                        }?>
                                        <li><a href="<?php echo constant('FETCH_PATH')?>shop"  class="<?php echo $s?>">Shop</a></li>
                                        <?php $a='';
                                        if( $_SERVER['PHP_SELF']==constant('ABOUT')){
                                            $a='noti_active';
                                        }?>
                                        <li><a href="<?php echo constant('FETCH_PATH')?>about"  class="<?php echo $a?>">About</a></li>
                                        <?php $c='';
                                        if( $_SERVER['PHP_SELF']==constant('CONTACT_US')){
                                            $c='noti_active';
                                        }?>
                                        <li><a href="<?php echo constant('FETCH_PATH')?>contact_us"  class="<?php echo $c?>">Contact Us</a></li>
                                    </ul>
                                    <?php
                                    if($_SERVER['PHP_SELF']==constant('SHOP')){?>
                                        <ul class="search_list p-0">
                                            <div style=" position:relative;">
                                                <form method="get" action="<?php echo constant('FETCH_PATH').'shop'?>">
                                                    <input type="text" name="search" class="search_input" placeholder="Search Item" value="<?php echo $search_input?>">
                                                    <button type="submit" class="search_button ">
                                                        <svg class="icon icon-search">
                                                            <use xlink:href="<?php echo constant('FETCH_PATH')?>assets/img/sprite.svg#icon-search"></use>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </ul>
                                    <?php }?>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- mobile-menu-area-start -->
			<div class="mobile-menu-area">
				<div class="container">
					<div class="row">
						<div class="col-lg-12">
							<div class="mobile-menu">
								<nav id="mobile-menu-active">
									<ul class="menu-overflow" id="nav">
                                        <?php
                                        if($_SERVER['PHP_SELF']==constant('SHOP')){?>
                                            <li class="search_list">
                                                <div style=" position:relative;">
                                                <form method="get" action="<?php echo constant('FETCH_PATH').'shop'?>">
                                                    <input type="text" name="search" class="search_input2" placeholder="Search Item" value="<?php echo $search_input?>">
                                                    <button type="submit" class="search_button">
                                                        <svg class="icon icon-search icon-search2">
                                                            <use xlink:href="<?php echo constant('FETCH_PATH')?>assets/img/sprite.svg#icon-search"></use>
                                                        </svg>
                                                    </button>
                                                </form>
                                                </div>
                                            </li>
                                        <?php }?>
                                        <li><a href="<?php echo constant('FETCH_PATH')?>index">Home</a></li>
                                        <?php $s='';
                                        if( $_SERVER['PHP_SELF']==constant('SHOP')){
                                            $s='noti_active';
                                        }?>
                                        <li><a href="<?php echo constant('FETCH_PATH')?>shop" class="<?php echo $s?>">Shop</a></li>
                                        <?php $a='';
                                        if( $_SERVER['PHP_SELF']==constant('ABOUT')){
                                            $a='noti_active';
                                        }?>
                                        <li><a href="<?php echo constant('FETCH_PATH')?>about" class="<?php echo $a?>">About</a></li>
                                        <?php $c='';
                                        if( $_SERVER['PHP_SELF']==constant('CONTACT_US')){
                                            $c='noti_active';
                                        }?>
                                        <li><a href="<?php echo constant('FETCH_PATH')?>contact_us" class="<?php echo $c?>">Contact Us</a></li>
									</ul>
								</nav>
							</div>
						</div>
					</div>
				</div>
			</div>
            <!-- mobile-menu-area-end -->
            <script>
                function add_to_cart(id,type){
                    let quantity=$(`.input-number-${id}`).val();
                    let attribute=$(`input[name='radio_${id}']:checked`).val();
                    $('body').css('overflow-y','hidden');
                    $('body').css('overflow-x','hidden');
                    if(quantity=='Qty' || attribute==undefined){
                        $html=`<div class="cart_black"><div class="cart_error text-center"><h2 class="text-danger">OPPS!</h2><svg class="icon icon-cancel-circle"><use xlink:href="<?php echo constant('FETCH_PATH')?>assets/img/sprite.svg#icon-cancel-circle"></use></svg><h4>ERROR OCCURRED</h4><div><button onclick="remove_message()">OK</button></div></div></div>`;
                        $('body').append($html);
                    }else{
                        $html=`<div class="cart_black"><div class="cart_success text-center"><h2 class="text-success">YIPEE!</h2><svg class="icon icon-checkbox-checked"><use xlink:href="<?php echo constant('FETCH_PATH')?>assets/img/sprite.svg#icon-checkbox-checked"></use></svg><h4>ITEM ADDED SUCCESFULLY</h4><div><button onclick="remove_message()">OK</button></div></div></div>`;
                        $('body').append($html);
                        $.ajax({
                        url:FETCH_PATH+'add_cart',
                        method:'post',
                        data:`quantity=${quantity}&attribute=${attribute}&type=${type}`,
                        success:function(response){
                            let data=$.parseJSON(response);
                            if(data.dish=='refresh'){
                                window.location.href=window.location.href;
                            }
                                $(`#added-item-${attribute}`).html(`(Added-${quantity})`);
                                $('.count-style').html(data.count);
                                $('.cart-digit-bold').html('Rs '+data.totalprice);
                                $('.shop-total').html('Rs '+data.totalprice);

                                let html=`<div class="<?php echo $shopping_cart_setting?>"><ul class="cart-list"><li class="single-shopping-cart single-shopping-cart-${attribute}">`+
                                        `<div class="shopping-cart-img"><img alt="" class="dish-image" src="<?php echo constant('DISH_FETCH')?>${data.image}">`+
                                        `</div><div class="shopping-cart-title"><h4><a href="javascript:void(0)">${data.dish}</a></h4><h6>Qty:${quantity}</h6>`+
                                        `<span >Rs ${quantity*data.price}</span></div><div class="shopping-cart-delete"><a href="javascript:void(0)" onclick="delete_from_cart(${attribute},'delete')"><i class="ion ion-close">`+
                                        `</i></a></div></li></ul><div class="shopping-cart-total">`+
                                        `<h4>Total : <span class="shop-total">Rs ${data.totalprice}</span></h4></div><div class="shopping-cart-btn">`+
                                        `<a href="<?php echo constant('FETCH_PATH')?>cart_page">view cart</a><a href="<?php echo constant('FETCH_PATH')?>checkout">checkout</a></div></div>`;

                                if(data.count==1){
                                $('.header-cart').append(html);
                                }else{
                                    $(`.single-shopping-cart-${attribute}`).remove();
                                    let html=`<li class="single-shopping-cart single-shopping-cart-${attribute}">`+
                                        `<div class="shopping-cart-img"><img alt="" class="dish-image" src="<?php echo constant('DISH_FETCH')?>${data.image}">`+
                                        `</div><div class="shopping-cart-title"><h4><a href="javascript:void(0)">${data.dish}</a></h4><h6>Qty:${quantity}</h6>`+
                                        `<span>Rs ${quantity*data.price}</span></div><div class="shopping-cart-delete"><a href="javascript:void(0)" onclick="delete_from_cart(${attribute},'delete')"><i class="ion ion-close">`+
                                        `</i></a></div></li>`;
                                    $('.cart-list').append(html);
                                    
                                }
                        }
                    });
                    }
                }

                function ajax_loader(){
                    $html=`<div class="cart_black"><div class="ajax-loader"><div class="loader">
                        <span style="--i:0"></span><span style="--i:1"></span><span style="--i:2"></span>
                        <span style="--i:3"></span><span style="--i:4"></span><span style="--i:5"></span>
                        </div></div></div>`;
                    $('body').append($html);
                }
                function remove_message(){
                    $('.cart_black').remove();
                    $('body').css('overflow-y','auto');
                    $('body').css('overflow-x','auto');
                }

                function delete_from_cart(attribute,type){
                    ajax_loader();
                    $.ajax({
                        url:FETCH_PATH+'add_cart',
                        method:'post',
                        data:`attribute=${attribute}&type=${type}`,
                        success:function(response){
                            let data=$.parseJSON(response);
                            $(`#added-item-${attribute}`).html('');
                                $('.count-style').html(data.count);
                                $('.cart-digit-bold').html('Rs '+data.totalprice);
                                $('.shop-total').html('Rs '+data.totalprice);
                                $(`.single-shopping-cart-${attribute}`).remove();
                                $(`.cart_page_dish_${attribute}`).remove();
                                if(data.totalprice==0){
                                    $('.<?php echo $shopping_cart_setting?>').remove();
                                    $('.cart-digit-bold').html('');
                                    $('.empty-cart-append').html(`<h6 class="text-danger">Cart Empty!</h6></div>`);
                                    $('.cart-shiping-update-wrapper').html(`<div class="cart-shiping-update"><a href="<?php echo constant('FETCH_PATH')?>shop">Continue Shopping</a></div>`);
                                }
                                remove_message();
                        }
                    });
                }

            </script>
        </header>
        