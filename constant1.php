<?php define('UPLOAD_PATH',$_SERVER['DOCUMENT_ROOT']);
define('DISH_UPLOAD',constant('UPLOAD_PATH').'/food-ordering/media/dish/');
define('BANNER_UPLOAD',constant('UPLOAD_PATH').'/food-ordering/media/banner/');

define('FETCH_PATH','http://localhost/food-ordering/');
define('FETCH_ADMIN_PATH','http://localhost/food-ordering/admin/');
define('FETCH_DELIVERY_PATH','http://localhost/food-ordering/delivery_boy/');
define('DISH_FETCH',constant('FETCH_PATH').'media/dish/');
define('BANNER_FETCH',constant('FETCH_PATH').'media/banner/');
define('LOGO_FETCH',constant('FETCH_PATH').'media/logo/');

define('PHP_SELF_FRONT_URL','/food-ordering/');
define('PHP_SELF_ADMIN_URL','/food-ordering/admin/');

define('FAILED',constant('PHP_SELF_FRONT_URL').'transaction_failed.php');
define('SUCCESS',constant('PHP_SELF_FRONT_URL').'success.php');
define('CHECKOUT',constant('PHP_SELF_FRONT_URL').'checkout.php');
define('SHOP',constant('PHP_SELF_FRONT_URL').'shop.php');
define('ABOUT',constant('PHP_SELF_FRONT_URL').'about.php');
define('CONTACT_US',constant('PHP_SELF_FRONT_URL').'contact_us.php');


define('STRIPE_SECRET_KEY','');
define('STRIPE_PUBLISHABLE_KEY','');


define('GOOGLE_CLIENT_ID','');
define('GOOGLE_CLIENT_SECRET','');

define('PAYTM_MERCHANT_KEY','');
define('PAYTM_MERCHANT_ID','');


define('WEBSITE_NAME','');
define('EMAIL_PASS','');
define('OWNER_EMAIL','');

?>