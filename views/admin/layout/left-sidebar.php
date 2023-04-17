<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo vendor_app_util::url(['ctl'=>'dashboard']); ?>" class="brand-link">
        <img src="<?php echo LibsURI; ?>Admin_LTE/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?php echo user_model::getAvatarUrl();?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?php echo user_model::getFullnameLogined();?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="<?php echo vendor_app_util::url(['ctl'=>'dashboard']); ?>" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa fa-user"></i>
                        <p>
                            User
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?=vendor_app_util::url(array('ctl'=>'users')); ?>" class="nav-link">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="far fa fa-users nav-icon ms-1"></i>
                                <p>List User</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=vendor_app_util::url(array('ctl'=>'users', 'act'=>'add')); ?>" class="nav-link">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="far fa fa-user-plus nav-icon"></i>
                                <p>Add User</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tree"></i>
                        <p>
                            Topic
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?=vendor_app_util::url(array('ctl'=>'topics')); ?>" class="nav-link">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="far fa-circle nav-icon"></i>
                                <p>List Topic</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=vendor_app_util::url(array('ctl'=>'topics', 'act'=>'add')); ?>"
                                class="nav-link">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="far fa-circle nav-icon"></i>
                                <p>Add Topic</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-regular fa-newspaper"></i>
                        <p>
                            Posts
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?=vendor_app_util::url(array('ctl'=>'posts'.'/index/p=1')); ?>" class="nav-link">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="far fa-circle nav-icon"></i>
                                <p>List post</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-regular fa-comment"></i>
                        <p>
                            Comments
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?=vendor_app_util::url(array('ctl'=>'comments')); ?>" class="nav-link">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="far fa-circle nav-icon"></i>
                                <p>General Elements</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="<?=vendor_app_util::url(array('ctl'=>'login', 'act'=>'logout')); ?>" class="nav-link">
                        <i class="fas fa-sign-out-alt"></i>
                        <p>
                            Logout
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>