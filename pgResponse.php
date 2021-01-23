<?php
session_start();
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");
include('function.php');
include('constant.php');

// following files need to be included
require_once("./lib/config_paytm.php");
require_once("./lib/encdec_paytm.php");

$paytmChecksum = "";
$paramList = array();
$isValidChecksum = "FALSE";

$paramList = $_POST;
$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg

//Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application�s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
$isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.


if($isValidChecksum == "TRUE") {
    //prx($_POST);
	if ($_POST["STATUS"] == "TXN_SUCCESS") {
        if(!isset($_SESSION['add_money'])){
            $payment_status='paid';
            $amount=$_POST['TXNAMOUNT'];
            $payment_id='PAYTM'.rand(10000,99999999);
            place_final_order($payment_status,$_POST['TXNID'],$_POST["TXNAMOUNT"]);
            redirect(constant('FETCH_PATH').'success');
        }else{
            wallet_money_manage($_SESSION['USER_ID'],$_POST['TXNAMOUNT'],'Added by user from paytm','added',$_POST['TXNID']);
            unset($_SESSION['add_money']);
            redirect(constant('FETCH_PATH').'wallet');
        }
	}
	else {
        checkout_sessions();
        $_SESSION['failed']='yes';
        redirect(constant('FETCH_PATH').'transaction_failed');
	}

	//if (isset($_POST) && count($_POST)>0 )
	//{
	//	foreach($_POST as $paramName => $paramValue) {
	//			echo "<br/>" . $paramName . " = " . $paramValue;
	//	}
	//}
	

}
else {
	echo "<b>Checksum mismatched.</b>";
	//Process transaction as suspicious.
}

?>