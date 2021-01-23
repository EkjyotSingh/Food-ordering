
<?php 
session_start();
include('../connect.php');
include('../function.php');
include('../constant.php');
$error='';
if(isset($_SESSION['delivery_boy_login']) && $_SESSION['delivery_boy_login']=='yes'){
redirect(constant('FETCH_DELIVERY_PATH').'orders');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Delivery Boy Login</title>
  <link rel="stylesheet" href="<?php echo constant('FETCH_DELIVERY_PATH')?>assets/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="<?php echo constant('FETCH_DELIVERY_PATH')?>assets/css/style.css">
  <link rel="stylesheet" href="<?php echo constant('FETCH_DELIVERY_PATH')?>assets/css/custom.css">
</head>
<body class="sidebar-light">
    <!--<div class="preloader">
        <div class="black"></div>
    </div>-->
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    

<?php
if(isset($_POST['submit'])){
    $mobile=$_POST['mobile'];
    $password=$_POST['password'];
    $smtm=$con->prepare("select * from delivery_boy where mobile='$mobile' and password='$password'");
    $smtm->execute();
    $rows=$smtm->fetch(PDO::FETCH_ASSOC);
    if(isset($rows['id']) && $rows['id'] != ''){
        $_SESSION['delivery_boy_login']='yes';
        $_SESSION['delivery_boy_id']=$rows['id'];
        $_SESSION['delivery_boy_name']=$rows['name'];

        redirect(constant('FETCH_DELIVERY_PATH').'orders');
    }else{
        $error='Please enter right credentials';
    }
    
}

?>

<!--<div class="container-scroller">-->
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center justify-content-center auth">
        <div class="row w-100">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left p-5">
              <div class="brand-logo text-center">
                <img src="assets/images/logo.png" alt="logo">
              </div>
              <h6 class="font-weight-light">Login to continue.</h6>
              <form class="pt-3" method="post">
                <div class="form-group">
                  <input type="text" name="mobile" class="form-control form-control-lg" id="mobile" placeholder="Mobile">
                </div>
                <div class="form-group">
                  <input type="password" name="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password">
                </div>
                <div class="mt-3">
                  <button class="btn btn-block btn-primary btn-md font-weight-medium" name="submit" type="submit">SIGN IN</button>
                </div>
                
              </form>
              <div class="text-danger my-3" style="font-size:.8rem;"><?php echo $error?></div>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>







    


    <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2018 <a href="https://www.urbanui.com/" target="_blank">Urbanui</a>. All rights reserved.</span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="<?php echo constant('FETCH_DELIVERY_PATH')?>assets/js/vendor.bundle.base.js"></script>
  <script src="<?php echo constant('FETCH_DELIVERY_PATH')?>assets/js/jquery-3.5.1.min.js"></script>

</body>
</html>