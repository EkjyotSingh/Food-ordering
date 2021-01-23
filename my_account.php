<?php
include('header.php');
 if(!isset($_SESSION['USER_LOGIN'])){
     redirect(constant('FETCH_PATH').'shop');
    }

?>

<div class="myaccount-area pb-80 pt-100">
            <div class="container">
                <div class="row">
                    <div class="ml-auto mr-auto col-lg-9">
                        <div class="checkout-wrapper">
                            <div id="faq" class="panel-group">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h5 class="panel-title"><span>1</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-1">Edit your account information </a></h5>
                                    </div>
                                    <div id="my-account-1" class="panel-collapse collapse show">
                                        <div class="panel-body">
                                            <div class="billing-information-wrapper">
                                                <div class="account-info-wrapper">
                                                    <h4>My Account Information</h4>
                                                    <h5>Your Personal Details</h5>
                                                </div>
                                                <form method="post" class="account_form">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6">
                                                            <?php
                                                            $id=$_SESSION['USER_ID'];
                                                            $smtm=$con->prepare("select * from user where id='$id'");
                                                            $smtm->execute();
                                                            $row=$smtm->fetch(PDO::FETCH_ASSOC);
                                                            ?>
                                                            <div class="billing-info">
                                                                <label>Name</label>
                                                                <input type="text" class="account_name" required value="<?php echo $row['name']?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6">
                                                            <div class="billing-info">
                                                                <label>Mobile</label>
                                                                <input type="text" class="account_mobile" required value="<?php echo $row['mobile']?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12">
                                                            <div class="billing-info">
                                                                <label>Email Address</label>
                                                                <input type="email" class="text-secondary" readonly value="<?php echo $row['email']?>">
                                                            </div>
                                                            <span class=" mt-4 account_message text-danger"></span>
                                                        </div>
                                                    </div>
                                                    <div class="billing-back-btn">
                                                        <div class="billing-back">
                                                            <a href="javascript:void(0)"><i class="ion-arrow-up-c"></i> back</a>
                                                        </div>
                                                        <div class="billing-btn">
                                                            <button type="submit"class=" account_button">Continue</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                if($row['password'] !=''){
                                ?>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h5 class="panel-title"><span>2</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-2">Change your password </a></h5>
                                    </div>
                                    <div id="my-account-2" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <div class="billing-information-wrapper">
                                                <div class="account-info-wrapper">
                                                    <h4 class="">Change Password</h4>
                                                </div>
                                                <form method="post" class="password_form">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12">
                                                            <div class="billing-info">
                                                                <label>Old Password</label>
                                                                <input type="text" class="old_password" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12">
                                                            <div class="billing-info">
                                                                <label>New Password</label>
                                                                <input type="text" class="new_password" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12">
                                                            <div class="billing-info">
                                                                <label>Password Confirm</label>
                                                                <input type="text" class="password_confirm" required>
                                                            </div>
                                                            <span class=" mt-4 password_message text-danger"></span>
                                                        </div>
                                                    </div>
                                                    <div class="billing-back-btn">
                                                        <div class="billing-back">
                                                            <a href="javascript:void(0)"><i class="ion-arrow-up-c"></i> back</a>
                                                        </div>
                                                        <div class="billing-btn">
                                                            <button type="submit" class="password_button">Continue</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php }else{echo "<span class='text-danger'>You are logged in through google so no password change is available</span>";}?>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php
include('footer.php');
?>