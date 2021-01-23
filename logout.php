<?php
include('header.php');
unset($_SESSION['USER_LOGIN']);
unset($_SESSION['USER_NAME']);
unset($_SESSION['USER_ID']);
redirect(constant('FETCH_PATH').'login_register');
include('footer.php');?>