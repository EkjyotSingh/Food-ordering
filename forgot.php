<?php
include('header.php');
?>

<div class="login-register-area pt-95 pb-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                        <div class="login-register-wrapper">
                            <div class="login-register-tab-list nav">
                                    <h5>New Password will be send to given email</h5>
                            </div>
                            <div class="tab-content">
                                <div id="lg1" class="tab-pane active">
                                    <div class="login-form-container">
                                        <div class="login-register-form">
                                            <form  class="forgot_form" method="post">
                                                <div class="login-group">
                                                    <input type="email" class="login-input forgot_email mb-10" placeholder="Email" required>
                                                    <span class="forgot_message text-danger mt-10" style="display:inline-block;"></span>
                                                </div>
                                                <div class="button-box">
                                                <div class="login-toggle-btn">
                                                        <a href="<?php echo constant('FETCH_PATH')?>login_register" class="mt-2">Login</a>
                                                    </div>
                                                    <button class="forgot_button" type="submit">Send</button>
                                                </div>
                                                <input type="hidden"  class="forgot_type" value="forgot">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php
include('footer.php');
?>