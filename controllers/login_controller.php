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

        public function register() {
            if(isset($_POST['btn_submit'])) {
                $user = $_POST['user'];
                //Change js later
                if ($user['password'] != $user['repassword']) {
                    $this->errors = ['message'=>'Password and Repassword not correct'];
                }
                if($user){
                    $email = $user['email'];
                    $um = new user_model();
                    $result = $um->getRecordWhere([
                        'email' => $email,
                    ]);
                    if(is_null($result)) {
                        unset($user['repassword']);
                        $user['password'] = vendor_app_util::generatePassword($user['password']);
                        $user['role'] = 2;
                        $user['status'] = 1;
                        $um->addRecord($user);
                        header("Location: ".vendor_app_util::url(["ctl"=>"login"]));
                    }
                    else {
                        $this->errors = ['message'=>'Email already have !!'];
                    }
                }
            }
            $this->display();
        }

    }
?>