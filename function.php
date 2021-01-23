<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 function redirect($link){?>
    <script>
    window.location.href='<?php echo $link?>';
    </script>
    <?php }
    
    function prx($arr){
        echo "<pre>";
        print_r($arr);
        die();
    }
    
    function add_cart($attribute,$quantity){
        include('connect.php');
        $id=$_SESSION['USER_ID'];
        $smtm=$con->prepare("select * from cart where user_id='$id' and attribute_id='$attribute'");
        $smtm->execute();
        $cart_rows=$smtm->fetchAll(PDO::FETCH_ASSOC);
        if(count($cart_rows)>0){
            $cart_id=$cart_rows[0]['id'];
            $smtm=$con->prepare("update cart set quantity='$quantity' where id='$cart_id'");
            $smtm->execute();
        }else{
            $added_on=date('Y-m-d h:i:s');
            $smtm=$con->prepare("insert into cart(user_id,attribute_id,quantity,added_on) values('$id','$attribute','$quantity','$added_on')");
            $smtm->execute();
        }
    }
    function fetch_cart(){
        include('connect.php');
        $cartarray=array();
        if(isset($_SESSION['USER_ID'])){
            $id=$_SESSION['USER_ID'];
            $smtm=$con->prepare("select * from cart where user_id='$id'");
            $smtm->execute();
            $cart_rows=$smtm->fetchAll(PDO::FETCH_ASSOC);
            foreach( $cart_rows as $list){
                if(status_check($list['attribute_id'])){
                    $cartarray[$list['attribute_id']]['quantity']=$list['quantity'];
                    $cartarray[$list['attribute_id']]['price']=dish_detail($list['attribute_id'])['price'];
                    $cartarray[$list['attribute_id']]['image']=dish_detail($list['attribute_id'])['image'];
                    $cartarray[$list['attribute_id']]['dish']=dish_detail($list['attribute_id'])['dish'];
                    $cartarray[$list['attribute_id']]['attribute']=dish_detail($list['attribute_id'])['attribute'];
                }
            }
        }else{
            if(isset($_SESSION['cart']) && count($_SESSION['cart'])>0){
                foreach( $_SESSION['cart'] as $key=>$list){
                    if(status_check($key)){
                        $cartarray[$key]['quantity']=$list['quantity'];
                        $cartarray[$key]['price']=dish_detail($key)['price'];
                        $cartarray[$key]['image']=dish_detail($key)['image'];
                        $cartarray[$key]['dish']=dish_detail($key)['dish'];
                        $cartarray[$key]['attribute']=dish_detail($key)['attribute'];
                    }
                }
            }
        }
        
        return $cartarray;
    }
    function status_check($key){
        include('connect.php');
            $smtm=$con->prepare("select dish.status as dish_status,dish_detail.dish_id,dish_detail.status as dish_detail_status
            from dish,dish_detail where dish_detail.id='$key' and dish.id=dish_detail.dish_id");
            $smtm->execute();
            $status=$smtm->fetch(PDO::FETCH_ASSOC);
            if(isset($_SESSION['USER_ID'])){
                $id=$_SESSION['USER_ID'];
                if($status['dish_status']=='0' || $status['dish_detail_status']=='0'){
                    $smtm=$con->prepare("delete from cart where user_id='$id' and attribute_id='$key'");
                    $smtm->execute();
                    return false;
                }
                return true;
            }else{
                if($status['dish_status']=='0' || $status['dish_detail_status']=='0'){
                    unset($_SESSION['cart'][$key]);
                    return false;
                }
                return true;
            }
    }
        

    function dish_detail($attribute){
        include('connect.php');
            $smtm=$con->prepare("select dish.dish,dish.image,dish_detail.price,dish_detail.attribute from dish,dish_detail where dish_detail.id='$attribute' and dish.id=dish_detail.dish_id");
            $smtm->execute();
            $dish_detail=$smtm->fetch(PDO::FETCH_ASSOC);
            return $dish_detail;
    }
    function total_price($cartarray){
        $totalprice=0;
        foreach($cartarray as $key=>$value){
        $totalprice=$totalprice + ($value['price']*$value['quantity']);
        }
        return $totalprice;
    }
    
    function delete_cart_item($attribute){
        include('connect.php');
        if(isset($_SESSION['USER_ID'])){
            $id=$_SESSION['USER_ID'];
            $smtm=$con->prepare("delete from cart where user_id='$id' and attribute_id='$attribute'");
            $smtm->execute();
        }else{
            unset($_SESSION['cart'][$attribute]);
        }
    }
    function delete_full_cart(){
        include('connect.php');
        if(isset($_SESSION['USER_ID'])){
        $id=$_SESSION['USER_ID'];
        $smtm=$con->prepare("delete from cart where user_id='$id'");
        $smtm->execute();
    }else{
        unset($_SESSION['cart']);
    }
    }
    function emailer($email,$html,$subject){
        require 'vendor/autoload.php';
        //PHPMailer Object
        $mail = new PHPMailer(true); //Argument true in constructor enables exceptions
        //$mail->SMTPDebug = 2;
        $mail->isSMTP();
        $mail->Host="smtp.gmail.com";
        $mail->Port=587;
        $mail->SMTPsecure="tls";
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        //From email address and name
        $mail->setFrom(constant('OWNER_EMAIL'),constant('WEBSITE_NAME'));
        $mail->Password=constant('EMAIL_PASS');
        $mail->Username = constant('OWNER_EMAIL');

        //To address and name
        //$mail->addAddress("recepient1@example.com", "Recepient Name");
        $mail->addAddress($email); //Recipient name is optional

        //Address to which recipient will reply
        //$mail->addReplyTo("reply@yourdomain.com", "Reply");

        //CC and BCC
        //$mail->addCC("cc@example.com");
        //$mail->addBCC("bcc@example.com");

        //Send HTML or Plain Text email
        $mail->isHTML(true);

        $mail->Subject =$subject;
        $mail->Body=$html;
        $mail->SMTPOptions=array('ssl'=>array(
            'verify_peer'=>false,
            'verify_peer_name'=>false,
            'allow_self_signed'=>false
        ));
        //$mail->AltBody = "This is the plain text version of the email content";

        try {
            $mail->send();
            //echo "Email has been sent successfully";
        } catch (Exception $e) {
            echo "Error occurred:" . $mail->ErrorInfo;
        }
   }

   function order_detail($oid,$user){
       include('connect.php');
       $sql="select full_order.*,full_order.order_status,order_detail.*,dish_detail.attribute,dish.dish from full_order,order_detail,dish_detail,dish where full_order.id='$oid' and order_detail.full_order_id='$oid' and dish_detail.id=order_detail.dish_detail_id and dish.id=dish_detail.dish_id";
       if($user=='user'){
        $uid=$_SESSION['USER_ID'];
        $sql.=" and full_order.user_id=$uid";
       }
       $sql.=" order by price asc";
       $smtm=$con->prepare($sql);
       $smtm->execute();
       $details=$smtm->fetchAll(PDO::FETCH_ASSOC);
        return $details;
   }

   function wallet_money_manage($id,$amount,$description,$type,$transaction_id=''){
    include('connect.php');
    $added_on=date('Y-m-d h:i:s');
    $smtm=$con->prepare("insert into wallet(user_id,amount,description,type,added_on,transaction_id) values('$id','$amount','$description','$type','$added_on','$transaction_id')");
    $smtm->execute();
   }

   function final_price_for_gateway(){
    $cartarray=fetch_cart();
    $total_price=total_price($cartarray);

    if(isset($_SESSION['coupon'])){
        $coupon_discount=explode('_',$_SESSION['coupon'])[1];
        $total_price=$total_price-(int)$coupon_discount;
    }
    return $total_price;
   }
   function place_final_order($payment_status,$transaction_id,$final_price=''){
    $added_on=date('Y-m-d,h:i:s');
    $discount='NA';
    $coupon='NA';
    if(isset($_SESSION['checkout_payment'])||isset($_SESSION['checkout_name'])||isset($_SESSION['checkout_email']) ||isset($_SESSION['checkout_address'])||isset($_SESSION['checkout_city'])||isset($_SESSION['checkout_zipcode'])||isset($_SESSION['checkout_mobile'])){
    $user_id=$_SESSION['USER_ID'];
    $full_name=$_SESSION['checkout_name'];
    $email=$_SESSION['checkout_email'];
    $address=$_SESSION['checkout_address'];
    $city=$_SESSION['checkout_city'];
    $mobile=$_SESSION['checkout_mobile'];
    $zipcode=$_SESSION['checkout_zipcode'];
    $payment_type=$_SESSION['checkout_payment'];
    }
    $cartarray=fetch_cart();
    if($final_price==''){
        $total_price=total_price($cartarray);
    }else{
        $total_price=$final_price;
    }
    if($final_price?$final_price>0:$total_price>0){

        if(isset($_SESSION['coupon'])){
            $discount=explode('_',$_SESSION['coupon'])[1];
            $coupon=explode('_',$_SESSION['coupon'])[0];
            if($final_price==''){
                $final_price=$total_price-$discount;
            }else{
                $total_price=$final_price+$discount;
            }
        }else{
            $final_price=$total_price;
        }
        include('connect.php');
        $smtm=$con->prepare("insert into full_order(delivery_boy_id,final_price,discount,coupon,user_id,added_on,full_name,email,address,city,mobile,zipcode,payment_type,payment_status,total_price,transaction_id,order_status) values('0','$final_price','$discount','$coupon','$user_id','$added_on','$full_name','$email','$address','$city','$mobile','$zipcode','$payment_type','$payment_status','$total_price','$transaction_id','pending')");
        $smtm->execute();
        checkout_sessions();
        $full_order_id=$con->lastInsertId();
        $_SESSION['full_order_id']=$full_order_id;
        foreach($cartarray as $key=>$value){
            $price=$value['price'];
            $quantity=$value['quantity'];
            $smtm=$con->prepare("insert into order_detail(full_order_id,dish_detail_id,quantity,price,added_on) values('$full_order_id','$key','$quantity','$price','$added_on')");
            $smtm->execute();
        }
        unset($_SESSION['cart']);
        delete_full_cart();

        $ar=array('success',$final_price);
    }else{
        $ar=array('error',$final_price);
    }
    return $ar;

   }
   function checkout_sessions(){
    unset($_SESSION['coupon']);
    unset($_SESSION['add_money']);
    unset($_SESSION['checkout_payment']);
    unset($_SESSION['checkout_name']);
    unset($_SESSION['checkout_email']);
    unset($_SESSION['checkout_address']);
    unset($_SESSION['checkout_city']);
    unset($_SESSION['checkout_mobile']);
    unset($_SESSION['checkout_zipcode']);
   }

function ratings( $id){
    include('connect.php');
    $smtm=$con->prepare("select count(rating.dish_detail_id) as count,sum(rating.review) as rating from dish_detail,rating where dish_detail.id=rating.dish_detail_id and dish_id='$id'");
    $smtm->execute();
    $rate=$smtm->fetch(PDO::FETCH_ASSOC);
    if($rate['count']>0){
        $color="rating-shop-low";
        if($rate['count']==1){
            $user=' user';
        }else{
            $user=' users';
        }
        if(round($rate['rating']/$rate['count'],2)>2.5){
            $color="rating-shop-high";
        }
    $rating_text="<div class='".$color."'>Rated <b>".round($rate['rating']/$rate['count'],2)."</b> by <b>".$rate['count']."</b>".$user."</div>";
    }else{
        $rating_text='<div class="no-rating">No rating</div>';
        }
        return $rating_text; 
}
function delivery_boy_detail($delivery_boy_id)
{
    include('connect.php');
       $smtm=$con->prepare("select name,mobile from delivery_boy where id='$delivery_boy_id'");
       $smtm->execute();
       $details=$smtm->fetch(PDO::FETCH_ASSOC);
    return $details;
}
///////////////oauth start////////////
function register($name,$email,$mobile='',$dbpassword='',$status='',$verified='',$str=''){
    include('connect.php');
    $added_on=date('Y-m-d h:i:s');
    $smtm=$con->prepare("insert into user(name,email,mobile,password,added_on,status,verified,email_verify_string) values('$name','$email','$mobile','$dbpassword','$added_on','$status','$verified','$str')");
    $smtm->execute();
    $id=$con->lastInsertId();
    wallet_money_manage($id,40,'Registering','added');
    return $id;
}

function login_google_oauth($name,$id){
    $_SESSION['USER_LOGIN']='yes';
    $_SESSION['USER_NAME']=$name;
    $_SESSION['USER_ID']=$id;
    if(isset($_SESSION['cart']) && count($_SESSION['cart'])>0){
        foreach($_SESSION['cart'] as $key=>$value){
            $attribute=$key;
            $quantity=$value['quantity'];
            add_cart($attribute,$quantity);
        }
    }
    redirect(constant('FETCH_PATH').'shop');
}

///////////////oauth end////////////

function order_invoice($oid,$user){
    include('constant.php');
    include('connect.php');
    $order_details = order_detail($oid,$user);
    //prx(order_detail($oid,$user));
    $html="<!DOCTYPE html><html lang='en'><head><meta charset='utf-8'><title>Foody Order Invoice</title>
        <style>
            @font-face {font-family: SourceSansPro;src: url(SourceSansPro-Regular.ttf);}
            .clearfix:after {content: '';display: table;clear: both;}
            a{color: #0087C3;text-decoration: none;}
            body{position: relative;width: 21cm;height: 29.7cm; margin: 0 auto; color: #555555;background: #FFFFFF; font-family: Arial, sans-serif; font-size: 14px; font-family: SourceSansPro;}
            header {padding: 10px 0;margin-bottom: 20px;border-bottom: 1px solid #AAAAAA;}
            #logo {float: left;margin-top: 8px;}
            #logo img {height: 70px;}
            #company {float: right;text-align: right;}
            #details {margin-bottom: 50px;}
            #client {padding-left: 6px;border-left: 6px solid #0087C3;float: left;}
            #client .to {color: #777777;}
            h2.name {font-size: 1.4em;font-weight: normal;margin: 0;}
            #invoice {float: right;text-align: right;}
            #invoice h1 {color: #0087C3;font-size: 2.4em;line-height: 1em;font-weight: normal;margin: 0  0 10px 0;}
            #invoice .date {font-size: 1.1em;color: #777777;}
            table { width: 100%; border-collapse: collapse; border-spacing: 0; margin-bottom: 20px; }
            table th,table td {padding: 20px;background: #EEEEEE;text-align: center;border-bottom: 1px solid #FFFFFF;}
            table th {white-space: nowrap;font-weight: normal;}
            table td {text-align: center;}
            table td h3{color: #e02c2b;font-size: 1.2em;font-weight: normal;margin: 0 0 0.2em 0;}
            table .no {color: #FFFFFF;font-size: 1.6em;background: #e02c2b;}
            table .desc {text-align: left;}
            table .unit {background: #DDDDDD;}
            table .qty {}
            table .total {background: #e02c2b;color: #FFFFFF;}
            table td.unit,table td.qty,table td.total {font-size: 1.2em;}
            table tbody tr:last-child td {border: none;}
            table tfoot td {padding: 10px 20px;background: #FFFFFF;border-bottom: none;font-size: 1.2em;white-space: nowrap; border-top: 1px solid #AAAAAA; }
            table tfoot tr:first-child td {border-top: none; }
            table tfoot tr:last-child td {color: #e02c2b;font-size: 1.4em;border-top: 1px solid #e02c2b; }
            table tfoot tr td:first-child {border: none;}
            #thanks{font-size: 2em;margin-bottom: 50px;}
            #notices{padding-left: 6px;border-left: 6px solid #0087C3;  }
            #notices .notice {font-size: 1.2em;}
            footer {color: #777777;width: 100%;height: 30px;position: absolute;bottom: 0;border-top: 1px solid #AAAAAA;padding: 8px 0;text-align: center;}
            .contact_us_link{color:#e02c2b;}
        </style>
      </head>
      <body>
        <header class='clearfix'>
        <div id='logo'>
            <a href='".constant('FETCH_PATH')."'><img src='".constant('LOGO_FETCH')."logo2.png'></a>
        </div>
        <div id='company'>
            <h2 class='name'><a href='".constant('FETCH_PATH')."'>".constant('WEBSITE_NAME')."</a></h2>
            <div>455 Foggy Heights, AZ 85004, India</div>
            <div>9253221717</div>
            <div><a href='mailto:".constant('OWNER_EMAIL')."'>".constant('OWNER_EMAIL')."</a></div>
        </div>
          </div>
        </header>
        <main>
            <div id='details' class='clearfix'>
                <div id='client'>
                    <div class='to'>INVOICE TO:</div>
                    <h2 class='name'>".ucfirst($order_details[0]['full_name'])."</h2>
                    <div class='address'>".$order_details[0]['address'].", ".$order_details[0]['city'].", ".$order_details[0]['zipcode'].", India</div>
                    <div class='email'><a href='mailto:".$order_details[0]['email']."'>".$order_details[0]['email']."</a></div>
                </div>
                <div id='invoice'>
                    <h1>FOOD ORDER INVOICE</h1>
                    <div class='date'>Date and timming of order: ".$order_details[0]['added_on']."</div>
                </div>
            </div>
            <table border='0' cellspacing='0' cellpadding='0'>
                <thead>
                    <tr>
                        <th class='no'>#</th>
                        <th class='desc'>Dish</th>
                        <th class='unit'>UNIT PRICE</th>
                        <th class='qty'>QUANTITY</th>
                        <th class='total'>TOTAL</th>
                    </tr>
                </thead>
                <tbody>";
                $i=1;
                foreach($order_details as $order_detail){
                    $html.="<tr>
                        <td class='no'>".$i."</td>
                        <td class='desc'><h3>".$order_detail['dish']."</h3>".$order_detail['attribute']."</td>
                        <td class='unit'>Rs ".$order_detail['price']."</td>
                        <td class='qty'>".$order_detail['quantity']."</td>
                        <td class='total'>Rs ".$order_detail['price']*$order_detail['quantity']."</td>
                   </tr>";
                   $i++;
                }
                $html.="</tbody>
                <tfoot>
                    <tr>
                        <td colspan='2'></td>
                        <td colspan='2'>SUBTOTAL</td>
                        <td>Rs ".$order_detail['total_price']."</td>
                    </tr>";
                    if($order_detail['coupon'] != 'NA'){
                        $html.="<tr>
                            <td colspan='2'></td>
                            <td colspan='2'>Coupon Code(".$order_detail['coupon'].")</td>
                            <td>- Rs ".$order_detail['discount']."</td>
                        </tr>";
                    }
                    $html.="<tr>
                        <td colspan='2'></td>
                        <td colspan='2'>GRAND TOTAL</td>
                        <td>Rs ".$order_detail['final_price']."</td>
                    </tr>
                </tfoot>
            </table>
            <div id='thanks'>Thank you for choosing us,Happy eating!</div>
            <div id='notices'>
                <div>NOTICE:</div>
                <div class='notice'>For any query <a class='contact_us_link' href='".constant('FETCH_PATH')."contact_us'>contact us</a></div>
            </div>
        </main>
        <footer>
            Invoice was created on a computer and is valid without the signature and seal.
        </footer>
    </body>
</html>";
    return $html;
}