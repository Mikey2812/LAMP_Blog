<?php
    class login_controller extends vendor_main_controller {
        protected 	$errors = false;
        public function __construct() {
            global $app;
            $rolesFlip = array_flip($app['roles']);
            if (isset($_SESSION['user']['role']) && $_SESSION['user']['role']==$rolesFlip["user"]) {
                header( "Location: ".vendor_app_util::url(['ctl'=>'home']));	die();
            }
            parent::__construct();
        }
        
        public function index() {
            if(isset($_POST['btn_submit'])) {
                $user = $_POST['user'];
                $auth = vendor_auth_model::getInstance();
                if($auth->login($user)) {
                    header("Location: ".vendor_app_util::url(['ctl'=>'home']));
                } else {
                    $this->errors = ['message'=>'Can not login with your account!'];
                }
            }
            $this->display();
        }
        
        public function logout() {
            session_unset(); 
            session_destroy(); 
            header( "Location: ".vendor_app_util::url(array('ctl'=>'login')));
        }
    }
?>