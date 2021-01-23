<?php
session_start();
include('function.php');
if(isset($_GET['paytm']) && $_GET['paytm']=='pp')
{
    $total_price=final_price_for_gateway();

    if($total_price>0){
        $html='<form method="post" action="pgRedirect" name="place_order" style="display:none;">
            <label>ORDER_ID::*</label>
            <input id="ORDER_ID" tabindex="1" maxlength="20" size="20"
                            name="ORDER_ID" autocomplete="off"
                            value="ORDS'.rand(10000,99999999).'">
            <label>CUSTID ::*</label><input id="CUST_ID" tabindex="2" maxlength="12" size="12" name="CUST_ID" autocomplete="off" value="'.$_SESSION['USER_ID'].'">
            <label>INDUSTRY_TYPE_ID ::*</label><input id="INDUSTRY_TYPE_ID" tabindex="4" maxlength="12" size="12" name="INDUSTRY_TYPE_ID" autocomplete="off" value="Retail">
            <label>Channel ::*</label><input id="CHANNEL_ID" tabindex="4" maxlength="12"
                            size="12" name="CHANNEL_ID" autocomplete="off" value="WEB">
                        <label>txnAmount*</label>
                        <input title="TXN_AMOUNT" tabindex="10"
                            type="text" name="TXN_AMOUNT"
                            value="'.$total_price.'">
                        <input value="CheckOut" type="submit"	onclick="">
            * - Mandatory Fields
            </form>
            <script type="text/javascript">
                document.place_order.submit();
            </script>';
        echo $html;

    }
}
?>