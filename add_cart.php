<?php
session_start();
include('function.php');
$attribute=$_POST['attribute'];
$type=$_POST['type'];
$cartdata=array();
if($type=='add'){
    $quantity=$_POST['quantity'];
    if(isset($_SESSION['USER_ID'])){
        add_cart($attribute,$quantity);
    }
    else{
        $_SESSION['cart'][$attribute]['quantity']=$quantity;
    }
    $fetch_cart=fetch_cart();
    $count=count($fetch_cart);
    $totalprice=total_price($fetch_cart);
    if(isset($fetch_cart[$attribute])){
        $image=$fetch_cart[$attribute]['image'];
        $dish=$fetch_cart[$attribute]['dish'];
        $price=$fetch_cart[$attribute]['price'];
    }else{
        $image='';
        $dish='refresh';
        $price='';
    }
    $cartdata=array('count'=>$count,'totalprice'=>$totalprice,'image'=>$image,'dish'=>$dish,'price'=>$price);
    echo json_encode($cartdata);
    
}
if($type =='delete'){
    delete_cart_item($attribute);
    $fetch_cart=fetch_cart();
    $count=count($fetch_cart);
    $totalprice=total_price($fetch_cart);
    $cartdata=array('count'=>$count,'totalprice'=>$totalprice);
    echo json_encode($cartdata);
}
?>