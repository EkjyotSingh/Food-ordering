<?php 
session_start();
include('../connect.php');
include('../function.php');
include('../constant.php');
$error='';
if(isset($_POST['submit'])){
    $email=$_POST['email'];
    $password=$_POST['password'];
    $smtm=$con->prepare("select * from admin where email='$email' and password='$password'");
    $smtm->execute();
    $rows=$smtm->fetch(PDO::FETCH_ASSOC);
    if($rows){
        $_SESSION['is_login']='yes';
        $_SESSION['name']=$rows['name'];
        redirect(constant('FETCH_ADMIN_PATH'));
    }else{
        $error='Please enter right credentials';
    }
    
}

if(isset($_SESSION['is_login']) && $_SESSION['is_login']=='yes'){
    redirect(constant('FETCH_ADMIN_PATH'));
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Admin Login</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="assets/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="assets/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="assets/css/bootstrap-datepicker.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="sidebar-light">
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    
<div class="container-scroller">
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
                  <input type="email" name="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Email">
                </div>
                <div class="form-group">
                  <input type="password" name="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password">
                </div>
                <div class="mt-3">
                  <button class="btn btn-block btn-primary btn-md font-weight-medium"name="submit" type="submit">SIGN IN</button>
                </div>
                
              </form>
              <div class="text-danger my-2"  style="font-size:.8rem;"><?php echo $error?></div>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
<?php include('bottom.php');?>