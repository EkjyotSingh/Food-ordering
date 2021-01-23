<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="navbar-menu-wrapper d-flex align-items-stretch justify-content-between">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center pl-4">
            <a class="navbar-brand brand-logo" href="<?php echo constant('FETCH_ADMIN_PATH') ?>index"><img src="assets/images/logo.png" alt="logo"/></a>
            <a class="navbar-brand brand-logo-mini" href="<?php echo constant('FETCH_ADMIN_PATH') ?>index"><img src="assets/images/logo.png" alt="logo"/></a>
        </div>
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown" id="profileDropdown">
                    <span class="nav_profile_name"><?php echo $_SESSION['delivery_boy_name'] ?></span>
                    <svg class="icon icon-play3"><use xlink:href="<?php echo constant('FETCH_DELIVERY_PATH') ?>assets/images/sprite.svg#icon-play3"></use></svg>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?php echo constant('FETCH_DELIVERY_PATH') ?>logout">
                    <svg class="icon icon-exit"><use xlink:href="<?php echo constant('FETCH_DELIVERY_PATH') ?>assets/images/sprite.svg#icon-exit"></use></svg>
                        Logout
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>
<div class="container-fluid page-body-wrapper pt-5">
