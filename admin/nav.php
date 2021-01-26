<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="navbar-menu-wrapper d-flex align-items-stretch justify-content-between">
        <ul class="navbar-nav mr-lg-2 d-none d-lg-flex">
          <li class="nav-item nav-toggler-item">
            <button class="navbar-toggler align-self-center" type="button" data-toggle="minimize">
              <span class="mdi mdi-menu"></span>
            </button>
          </li>
          
        </ul>
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
          <a class="navbar-brand brand-logo" href="<?php echo constant('FETCH_ADMIN_PATH') ?>index"><img src="assets/images/logo.png" alt="logo"/></a>
          <a class="navbar-brand brand-logo-mini" href="<?php echo constant('FETCH_ADMIN_PATH') ?>index"><img src="assets/images/logo.png" alt="logo"/></a>
        </div>
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                <span class="nav-profile-name"><?php echo$_SESSION['name'] ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?php echo constant('FETCH_ADMIN_PATH') ?>logout">
                        <i class="mdi mdi-logout text-primary"></i>
                        Logout
                    </a>
                </div>
            </li>
          
            <li class="nav-item nav-toggler-item-right d-lg-none">
                <button class="navbar-toggler align-self-center" type="button" data-toggle="offcanvas">
                <span class="mdi mdi-menu"></span>
                </button>
            </li>
        </ul>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo constant('FETCH_ADMIN_PATH')?>">
                <svg class="icon icon-user"><use xlink:href="assets/images/sprite.svg#icon-clipboard"></use></svg>
                <span class="menu-title">Orders</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo constant('FETCH_ADMIN_PATH') ?>category">
                <svg class="icon icon-user"><use xlink:href="assets/images/sprite.svg#icon-books"></use></svg>
                <span class="menu-title">Category</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo constant('FETCH_ADMIN_PATH') ?>admins">
                <svg class="icon icon-user"><use xlink:href="assets/images/sprite.svg#icon-user-check"></use></svg>
                <span class="menu-title">Admin</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo constant('FETCH_ADMIN_PATH') ?>user">
                <svg class="icon icon-user"><use xlink:href="assets/images/sprite.svg#icon-user"></use></svg>
                <span class="menu-title">User</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo constant('FETCH_ADMIN_PATH') ?>delivery_boy">
                <svg class="icon icon-user"><use xlink:href="assets/images/sprite.svg#icon-truck"></use></svg>
                <span class="menu-title">Delivery Boy</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo constant('FETCH_ADMIN_PATH') ?>coupon_code">
                <svg class="icon icon-user"><use xlink:href="assets/images/sprite.svg#icon-price-tags"></use></svg>
                <span class="menu-title">Coupon Code</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo constant('FETCH_ADMIN_PATH') ?>dish">
                <svg class="icon icon-user"><use xlink:href="assets/images/sprite.svg#icon-spoon-knife"></use></svg>
                <span class="menu-title">Dish </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo constant('FETCH_ADMIN_PATH') ?>banner">
                <svg class="icon icon-user"><use xlink:href="assets/images/sprite.svg#icon-tv"></use></svg>
                <span class="menu-title">Banner </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo constant('FETCH_ADMIN_PATH') ?>contact_us">
                <svg class="icon icon-user"><use xlink:href="assets/images/sprite.svg#icon-envelop"></use></svg>
                <span class="menu-title">Contact Us </span>
                </a>
            </li>
          
        </ul>
      </nav>