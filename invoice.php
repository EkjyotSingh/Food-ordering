<?php

session_start();
require('function.php');
require('constant.php');
require_once __DIR__ . '/vendor/autoload.php';
if(isset($_POST['oid']) && $_POST['oid']!=''){
    $html=order_invoice($_POST['oid'],'user');
    $mpdf=new \Mpdf\Mpdf;
    $mpdf->WriteHTML($html);
    $file=time().'.pdf';
    $mpdf->output($file,'D');
}else{
    redirect(constant('FETCH_PATH').'order_history');
}

?>