<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>LAMP_Blog</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Test ">
    <meta name="author" content="pacificsoftdev@gmail.com">

    <!-- Bootstrap core CSS -->
    <link href="<?php echo LibsURI; ?>bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo LibsURI; ?>fontawesome/css/all.min.css">
    <link href="<?php echo RootREL; ?>media/css/main.css" rel="stylesheet">
    <?php echo vendor_html_helper::_cssHeader(); ?>
    <script>
    let isLogin = false;
    <?php if (isset($_SESSION['user'])) { ?>
    isLogin = true;
    <?php } ?>
    </script>
</head>

<body class="pb-0">
    <!-- Preloader -->
    <div class="preloader-wrapper d-none">
        <div class="preloader">
            <img src="<?php echo MediaURI; ?>img/1476.gif" alt="LAMP">
        </div>
    </div>
    <header>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="container-fluid">
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <a class="navbar-brand p-0" href="<?php echo vendor_app_util::url(['ctl'=>'home']); ?>">
                        <img class="logo" src="<?php echo MediaURI; ?>img/logo.png" alt="Logo" style="max-height:50px">
                    </a>
                    <ul class="navbar-nav mb-2 mb-md-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page"
                                href="<?php echo vendor_app_util::url(['ctl'=>'home']); ?>">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo vendor_app_util::url(['ctl'=>'posts']); ?>">Posts</a>
                        </li>
                    </ul>
                    <div class="d-flex">
                        <?php  if (!isset($_SESSION['user']['email'])) { ?>
                        <p class="d-flex align-items-center me-2 mb-0" style="color:yellow">Hi!
                            there</p>
                        <a href="<?php echo vendor_app_util::url(['ctl'=>'login']); ?>"
                            class="btn btn-outline-success ms-2">Login</a>
                        <?php }
                        else { ?>
                        <div class="dropdown d-flex position-relative">
                            <div class="image">
                                <img src="<?php echo user_model::getAvatarUrl();?>"
                                    class="img-circle elevation-2 rounded-circle ms-2 me-2"
                                    style="width:50px; height:50px" alt="User Image">
                            </div>
                            <p class="d-flex align-items-center me-2 mb-0" style="color:yellow">Hi!
                                <?php echo user_model::getFullnameLogined();?></p>
                            <ul class="dropdown-menu pull-right dropdown-menu-end end-0 p-3 bg-dark text-warning"
                                aria-labelledby="dropdownMenuButton" style="top:50px">
                                <li><a class="dropdown-item text-warning"
                                        href="<?=vendor_app_util::url(array('ctl'=>'posts', 'act'=>'profile/'.$_SESSION['user']['id'])); ?>">My
                                        Blog</a></li>
                                <li><a class="dropdown-item text-warning"
                                        href="<?=vendor_app_util::url(array('ctl'=>'login', 'act'=>'logout')); ?>">Logout</a>
                                </li>
                            </ul>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <div class="container">