<?php
    class users_controller extends vendor_backend_controller {
        public function index() {
            global $app;
            $conditions = "";
            if(isset($app['prs']['status'])) {
                $conditions .= "status=".$app['prs']['status'];
            }
            if(isset($app['prs']['role'])) {
                $conditions .= (($conditions)? " AND ":"")."role=".$app['prs']['role'];
            }
            if(isset($app['prs']['kw'])) {
                $conditions .= (($conditions)? " AND (":"")."firstname LIKE '%".$app['prs']['kw']."%' OR lastname LIKE '%".$app['prs']['kw']."%' OR email LIKE '%".$app['prs']['kw']."%'".(($conditions)? ")":"");
            }
            
            $um = user_model::getInstance();
            $this->records = $um->allp('*',['conditions'=>$conditions, 'joins'=>false]);
            $this->display();
        }

        public function view($id) {
        $um = user_model::getInstance();
            $this->record = $um->getRecord($id);
            $this->display();
        }

        public function add() {
            $um = user_model::getInstance();
            if(isset($_POST['btn_submit'])) {
                $userData = $_POST['user'];
                if($_FILES['image']['tmp_name'])
                    $userData['avatar'] = $this->uploadImg($_FILES);
                $valid = $um->validator($userData);
                if($valid['status']) {
                    $userData['password'] = vendor_app_util::generatePassword($userData['password']);
                    if($um->addRecord($userData))
                        header("Location: ".vendor_app_util::url(["ctl"=>"users"]));
                    else {
                        $this->errors = ['database'=>'An error occurred when inserting data!'];
                        $this->record = $userData;
                    }
                } else {
                    $this->errors = $um::convertErrorMessage($valid['message']);
                    $this->record = $userData;
                }
            }
            $this->display();
        }

        public function edit($id) {
        $um = user_model::getInstance();
            $this->record = $um->one($id);
            if(isset($_POST['btn_submit'])) {
                $userData = $_POST['user'];
                if($_FILES['image']['tmp_name']) {
                    if($this->record['avatar'] && file_exists(RootURI."/media/upload/" .$this->controller.'/'.$this->record['avatar']))
                        unlink(RootURI."/media/upload/" .$this->controller.'/'.$this->record['avatar']);
                    $userData['avatar'] = $this->uploadImg($_FILES);
                }
                
                $valid = $um->validator($userData, $id);
                if($valid['status']){
                    if($userData['password'])
                        $userData['password'] = vendor_app_util::generatePassword($userData['password']);
                    else
                        unset($userData['password']);


                    if($um->editRecord($id, $userData)) {
                        header("Location: ".vendor_app_util::url(["ctl"=>"users"]));
                    } else {
                        $this->errors = ['database'=>'An error occurred when editing data!'];
                        $this->record = $userData;
                    }
                } else {
                    $this->errors = $um::convertErrorMessage($valid['message']);
                    $this->record = $userData;
                    $this->record['id'] = $id;
                }
            }
            $this->display();
        }

        // public function del($id) {
        //     $um = user_model::getInstance();
        //     if($um->delRelativeRecord($id, "role != 1")) echo "Delete Successful";
        //     else echo "error";
        // }

        public function profile() {
            $um = new user_model();
            $this->record = $um->getRecord($_SESSION['user']['id']);
            $this->display();
        }

        public function changepassword() {
            global $app;
            $curpassword = vendor_app_util::generatePassword($_POST['curpassword']);
            $um = user_model::getInstance();
            if( $um->checkOldPassword($curpassword)) {
                $newpassword 	= $_POST['newpassword'];
                $userData['password'] = vendor_app_util::generatePassword($newpassword);

                $id 		= $_SESSION['user']['id'];
                $password 	= $um->getRecords($id);
                if($um->editRecord($id, $userData)) 
                    echo json_encode(['status'=>1, 'message'=>'Update successful!']);
                else echo json_encode(['status'=>0, 'message'=>'Have error when update password!']);
            } else {
                echo json_encode(['status'=>0, 'message'=>'Current password not match!']);
            }
            exit;
        }

        public function filter() { 
            $um = user_model::getInstance();
            $conditions = '';
            global $app;
            if(isset($app['prs']['kw'])) {
                $conditions .= (($conditions)? " AND (":"")."id LIKE '%".$app['prs']['kw']."%'
                OR CONCAT(users.firstname, ' ', users.lastname) LIKE '%".$app['prs']['kw']."%'
                OR email LIKE '%".$app['prs']['kw']."%'
                OR phone LIKE '%".$app['prs']['kw']."%'".(($conditions)? ")":"");
            }
            $this->records = $um->allp('*',['conditions'=>$conditions, 'joins'=>false]);
            $this->display();
        }
    }
?>