<?php
require('constant.php');
?>
<html>
    <head>
        <title>404 Page Not Found</title>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <style>
            *,a,*:after,*:before{
                margin:0;
                padding:0;
                box-sizing:border-box;
            }
        </style>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800;900&display=swap" rel="stylesheet">   
        <link rel="stylesheet" href="<?php echo constant('FETCH_PATH')?>assets/css/responsive.css">
        <link rel="stylesheet" href="<?php echo constant('FETCH_PATH')?>assets/css/custom.css">
    </head>
    <body class="body_404">
        <div class="body_404_inner">
            <span class="oo">4</span>
            <span class="o"></span>
            <span  class="oo">4</span>
        </div>
        <span class="text">Oops! Looks Like You Lost</span>
        <a class="link_404" href="<?php echo constant('FETCH_PATH')?>shop">Go Home</a>
    </body>
</html>