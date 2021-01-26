
<?php 
session_start();
include('../connect.php');
include('../function.php');
include('../constant.php');
if(isset($_SESSION['is_login']) && $_SESSION['is_login']=='yes'){

}else{
    redirect(constant('FETCH_ADMIN_PATH').'login');
}

switch($_SERVER['PHP_SELF']){
    case constant('PHP_SELF_ADMIN_URL').'index.php':
    $title='Orders';
    break;
    case constant('PHP_SELF_ADMIN_URL').'order_detail.php':
    $title='Admin Order Detail';
    break;
    case constant('PHP_SELF_ADMIN_URL').'category.php':
    $title='Category';
    break;
    case constant('PHP_SELF_ADMIN_URL').'category_manage.php':
    $title='Category Manage';
    break;
    case constant('PHP_SELF_ADMIN_URL').'admins.php':
    $title='Admin';
    break;
    case constant('PHP_SELF_ADMIN_URL').'admins_manage.php':
    $title='Admin Manage';
    break;
    case constant('PHP_SELF_ADMIN_URL').'user.php':
    $title='Users';
    break;
    case constant('PHP_SELF_ADMIN_URL').'delivery_boy.php':
    $title='Delivery Boys';
    break;
    case constant('PHP_SELF_ADMIN_URL').'delivery_boy_manage.php':
    $title='Delivery Boy Manage';
    break;
    case constant('PHP_SELF_ADMIN_URL').'coupon_code.php':
    $title='Coupon Code';
    break;
    case constant('PHP_SELF_ADMIN_URL').'coupon_code_manage.php':
    $title='Coupon Code Manage';
    break;
    case constant('PHP_SELF_ADMIN_URL').'dish.php':
    $title='Dish';
    break;
    case constant('PHP_SELF_ADMIN_URL').'dish_manage.php':
    $title='Dish Manage';
    break;
    case constant('PHP_SELF_ADMIN_URL').'banner.php':
    $title='Banner';
    break;
    case constant('PHP_SELF_ADMIN_URL').'banner_manage.php':
    $title='Banner manage';
    break;
    case constant('PHP_SELF_ADMIN_URL').'contact_us.php':
    $title='Admin Contact Us';
    break;
    default:
    $title='Food Ordering Admin Panel';
    break;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?php echo $title?></title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="<?php echo constant('FETCH_ADMIN_PATH')?>assets/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="<?php echo constant('FETCH_ADMIN_PATH')?>assets/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="<?php echo constant('FETCH_ADMIN_PATH')?>assets/css/dataTables.bootstrap4.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="<?php echo constant('FETCH_ADMIN_PATH')?>assets/css/bootstrap-datepicker.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="<?php echo constant('FETCH_ADMIN_PATH')?>assets/css/style.css">
  <link rel="stylesheet" href="<?php echo constant('FETCH_ADMIN_PATH')?>assets/css/custom.css">
  <script src="<?php echo constant('FETCH_ADMIN_PATH')?>assets/js/jquery-3.5.1.min.js"></script>

</head>
<body class="sidebar-light">
    <!--<div class="preloader">
        <div class="black"></div>
    </div>-->
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    