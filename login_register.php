<?php
include('header.php');
//prx ($_SESSION);
$google_error='';
require_once 'vendor/autoload.php';
$client = new Google_Client();
$client->setClientId(constant('GOOGLE_CLIENT_ID'));
$client->setClientSecret(constant('GOOGLE_CLIENT_SECRET'));
$client->setRedirectUri(constant('FETCH_PATH').'login_register');
$client->addScope("email");
$client->addScope("profile");
// authenticate code from Google OAuth Flow
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    if(isset($token['error'])?$token['error'] !='invalid_grant':true){
        $client->setAccessToken($token['access_token']);
    
        // get profile info
        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
        $email =  $google_account_info->email;
        $name =  $google_account_info->name;
        $smtm=$con->prepare("select * from user where email='$email'");
        $smtm->execute();
        $rows=$smtm->fetch(PDO::FETCH_ASSOC);
        if(isset($rows['id'])){
            if($rows['password'] =='google'){
                login_google_oauth($rows['name'],$rows['id']);
            }else{
                $google_error="This email is not logged in with google";
            }
        }else{
            $id=register($name,$email,'','google','1','1','');
            login_google_oauth($name,$id);
        }
    }
}
     
if(isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN']=='yes'){
    redirect(constant('FETCH_PATH').'shop');
}?>
    

<div class="login-register-area pt-95 pb-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                        <div class="login-register-wrapper">
                            <div class="login-register-tab-list nav">
                                <a class="active" data-toggle="tab" href="#lg1">
                                    <h4> login </h4>
                                </a>
                                <a data-toggle="tab" href="#lg2">
                                    <h4> register </h4>
                                </a>
                            </div>
                            <div class="tab-content">
                                <div id="lg1" class="tab-pane active">
                                    <div class="login-form-container">
                                        <?php
                                        if($google_error !=''){?>
                                            <span class=" mt-4 login_message text-danger mb-3 text-center"><?php echo $google_error ?></span>
                                        
                                    <?php
                                            } 
                                        $client = new Google_Client();
                                        $client->setClientId(constant('GOOGLE_CLIENT_ID'));
                                        $client->setClientSecret(constant('GOOGLE_CLIENT_SECRET'));
                                        $client->setRedirectUri(constant('FETCH_PATH').'login_register');
                                        $client->addScope("email");
                                        $client->addScope("profile");
                                        echo "<a href='".$client->createAuthUrl()."' class='oauth_google'>";?>
                                            <svg class='icon icon-google-plus'>
                                                <use xlink:href='<?php echo constant('FETCH_PATH')?>assets/img/sprite.svg#icon-google-plus'></use>
                                            </svg>
                                            <span>Login with Google</span>
                                        </a>
                                        <span class="or">OR</span>
                                        <div class="login-register-form">
                                            <form  class="login_form" method="post">
                                                <div class="login-group">
                                                    <input type="email" class="login-input login_email" placeholder="Email" required>
                                                    <span class="email_message text-danger"></span>
                                                </div>
                                                <div class="login-group">
                                                    <input type="password" class="login-input login_password" placeholder="Password" required>
                                                    <span class="password_message text-danger"></span>
                                                </div>
                                                <div class="button-box">
                                                    <div class="login-toggle-btn">
                                                        <a href="<?php echo constant('FETCH_PATH')?>forgot" class="mt-2">Forgot Password?</a>
                                                    </div>
                                                    <button type="submit" class="login_button">Login</button>
                                                </div>
                                                <input type="hidden"  class="login_type" value="login">
                                                <input type="hidden" class="login_checkout" value="">
                                            </form>
                                        </div>
                                        <span class=" mt-4 login_message text-danger"></span>
                                    </div>
                                </div>
                                <div id="lg2" class="tab-pane">
                                    <div class="login-form-container"><?php
                                        if($google_error !=''){?>
                                            <span class=" mt-4 login_message text-danger mb-3 text-center"><?php echo $google_error ?></span>
                                        
                                        <?php
                                            } 
                                        $client = new Google_Client();
                                        $client->setClientId(constant('GOOGLE_CLIENT_ID'));
                                        $client->setClientSecret(constant('GOOGLE_CLIENT_SECRET'));
                                        $client->setRedirectUri(constant('FETCH_PATH').'login_register');
                                        $client->addScope("email");
                                        $client->addScope("profile");
                                        echo "<a href='".$client->createAuthUrl()."' class='oauth_google'>";?><svg class='icon icon-google-plus'><use xlink:href='<?php echo constant('FETCH_PATH')?>assets/img/sprite.svg#icon-google-plus'></use></svg>
                                        <span>Sign Up with Google</span>
                                        </a>
                                        <span class="or">OR</span>
                                        <div class="login-register-form">
                                            <form method="post" class="register_form">
                                                <input type="text" class="user_name" placeholder="Username" required>
                                                <input class="user_email" placeholder="Email" type="email" required>
                                                <div class="register_email email text-danger"></div>
                                                <input type="text" class="user_mobile" placeholder="Mobile" required>
                                                <input type="password" class="user_password" placeholder="Password" required>
                                                <div class="button-box">
                                                    <button type="submit" class="register_button">Register</button>
                                                </div>
                                                <input type="hidden"  class="user_type" value="register">
                                            </form>
                                        </div>
                                        <p class=" mt-4 form_message text-danger"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            alert('Wanted to see all features of website? But doesnot want to register with email on untrusted website.\n\nThen Login with these credentials\n\nEmail: 1@gmail.com\nPassword: 1');
        </script>
<?php
include('footer.php');?>