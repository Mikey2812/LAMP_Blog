<?php
    class login_controller extends vendor_main_controller {
        protected 	$errors = false;
        public function __construct() {
            global $app;
            $rolesFlip = array_flip($app['roles']);
            if (isset($_SESSION['user']['role']) && $_SESSION['user']['role']==$rolesFlip["user"]) {
                header( "Location: ".vendor_app_util::url(['ctl'=>'dashboard']));	die();
            }
            parent::__construct();
        }
        
        public function index() {
            if(isset($_POST['btn_submit'])) {
                $user = $_POST['user'];
                $auth = vendor_auth_model::getInstance();
                if($auth->login($user)) {
                    header("Location: ".vendor_app_util::url(['ctl'=>'dashboard']));
                } else {
                    echo 2;exit();
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

        // public function forgotPassWord() {
        //     global $app;
        //     if(isset($_POST['btn_submit']))
        //     {
        //         $email = $_POST['email'];
        //         $user = user_model::getInstance();
        //         if( $user->getCountWhere(['email'=>$email])) {	
        //             $tocken = time().rand(10000,99999);
        //             $user->updateWhere(['tocken'=>$tocken], ['email'=>$email]);

        //             $to = $email;
        //             $subject = "HTML email";
        //             $message = "
        //                 <html>
        //                 <head>
        //                 <title>HTML email</title>
        //                 </head>
        //                 <body>
        //                 <h3>What's Next?</h3>
        //                 <p>Please <a target='_blank' href='".RootABS.
        //                     vendor_app_util::url([
        //                             'ctl'=>'login',
        //                             'act'=> 'resetPassWord', 
        //                             'params'=> ['tocken' => $tocken]
        //                     ]).
        //                     "''>click here </a> to create your new password.</p>
        //                 </body>
        //                 </html>
        //             ";
        //             // Always set content-type when sending HTML email
        //             $headers = "MIME-Version: 1.0" . "\r\n";
        //             $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        //             // More headers
        //             $headers .= 'From: <softdevelop.dev@gmai.com>' . "\r\n";
        //             $headers .= 'Cc: softdevelop.test@gmail.com' . "\r\n";

        //             mail($to,$subject,$message,$headers);
        //             // $this->errors = ['message'=>'<a href="#">thank! </a>'];
        //         } else {
        //             $this->errors = ['message'=>'Error! Please enter a valid email address.'];
        //         }
        //     }
        //     $this->display();
        // }

        // public function resetPassWord() {
        //     global $app;
        //     $this->tocken = $app['prs']['tocken'];
        //     $user = user_model::getInstance();
        //     if( $user->getCountWhere(['tocken'=>$this->tocken])) {
        //         if(isset($_POST['btn_submit'])) {
        //             $tocken = $this->tocken;
        //             $password = vendor_app_util::generatePassword($_POST['password']);
        //             if ($user->updateWhere(['tocken'=>$tocken], ['password'=>$password])){
        //                 header( "Location: ".vendor_app_util::url(array('ctl'=>'login')));
        //             }
        //         }
        //         $this->display();
        //     } else {
        //         //header( "Location: ".vendor_app_util::url(array('ctl'=>'login', 'act'=> 'erorsResetPass')));
        //         $this->errors = ['message'=>'Error! tocken does not exist, Please check the tocken '];
        //         $this->display(['act'=>'erorsResetPass']);
        //     }
        // }
    }
?>