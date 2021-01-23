<?php
include('connect.php');
include('function.php');
include('constant.php');

$smtm=$con->prepare("select * from banner where status='1' order by orderby");
$smtm->execute();
$result=$smtm->fetchAll(PDO::FETCH_ASSOC);
?><!doctype html>
<html class="no-js" lang="zxx">
<head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>FoodOrdering</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?php echo constant('FETCH_PATH')?>assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo constant('FETCH_PATH')?>assets/css/animate.css">
        <link rel="stylesheet" href="<?php echo constant('FETCH_PATH')?>assets/css/owl.carousel.min.css">
        <link rel="stylesheet" href="<?php echo constant('FETCH_PATH')?>assets/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo constant('FETCH_PATH')?>assets/css/style.css">
        <link rel="stylesheet" href="<?php echo constant('FETCH_PATH')?>assets/css/responsive.css">
        <script src="<?php echo constant('FETCH_PATH')?>assets/js/vendor/modernizr-2.8.3.min.js"></script>
        <script src="<?php echo constant('FETCH_PATH')?>assets/js/popper.js"></script>

    </head>
    <body>
        <div class="slider-area">
            <div class="slider-active owl-dot-style owl-carousel">
                <?php foreach($result as $res){?>
                    <div class="single-slider pt-210 pb-220 bg-img" style="background-image:url(<?php echo constant('BANNER_FETCH').$res['image']?>);">
                        <div class="container">
                            <div class="slider-content slider-animated-1">
                                <h1 class="animated"><?php echo $res['heading']?></h1>
                                <h3 class="animated"><?php echo $res['sub_heading']?></h3>
                                <div class="slider-btn mt-90">
                                    <a class="animated" href="<?php echo constant('FETCH_PATH').$res['link']?>"><?php echo $res['link_text']?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }?>
            </div>
        </div>
        <script src="<?php echo constant('FETCH_PATH')?>assets/js/vendor/jquery-1.12.0.min.js"></script>
        <script src="<?php echo constant('FETCH_PATH')?>assets/js/bootstrap.min.js"></script>
        <script src="<?php echo constant('FETCH_PATH')?>assets/js/imagesloaded.pkgd.min.js"></script>
        <script src="<?php echo constant('FETCH_PATH')?>assets/js/isotope.pkgd.min.js"></script>
        <script src="<?php echo constant('FETCH_PATH')?>assets/js/owl.carousel.min.js"></script>
        <script src="<?php echo constant('FETCH_PATH')?>assets/js/plugins.js"></script>
        <script src="<?php echo constant('FETCH_PATH')?>assets/js/main.js"></script>
    </body>
</html>
