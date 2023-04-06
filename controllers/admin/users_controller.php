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
            if(isset($_POST['btn_submit'])) {
            $um = user_model::getInstance();
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

        public function trash() {
            global $app;
            $id = $app['prs'][1];
            $um = user_model::getInstance();
            $userData['status'] = 0;
            $status=explode("/",$_GET["pr"])[4]==0?1:0;

            if($um->editRecords($id, ["status" => $status] , "role != 1")) echo "Successful handle!";
            else echo "error";
        }

        public function del($id) {
            $um = user_model::getInstance();
            if($um->delRelativeRecord($id, "role != 1")) echo "Delete Successful";
            else echo "error";
        }

        public function trashmany() {
            global $app;
            $ids = $app['prs']['ids'];
            $um = user_model::getInstance();
            $userData['status'] = 0;
            if($um->editRecords($ids, $userData, "role != 1")) echo "Move many to trash successful";
            else echo "error";
        }

        public function delmany() {
            global $app;
            $ids = $app['prs']['ids'];
            $um = user_model::getInstance();
            if($um->delRelativeRecords($ids)) echo "Delete many successful";
            else echo "error";
        }

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

        public function search_users(){
            $um = user_model::getInstance();
            $conditions  = "";
            $search_term = isset($_GET['q']) ? $_GET['q'] : '';
            $conditions .= " role in (1,2,3,4,5)";
            $conditions .= " and (CONCAT(TRIM(users.firstname),\" \",TRIM(users.lastname)) like '%".$search_term."%'";
            $conditions .= " or CONCAT(TRIM(users.lastname),\" \",TRIM(users.firstname)) like '%".$search_term."%'";
            $conditions .= " or TRIM(users.firstname) like '%".$search_term."%'";
            $conditions .= " or users.email like '%".$search_term."%') ";

            $options['conditions'] = $conditions;
            $options = [
                'conditions' => $conditions,
                'order' => 'firstname ASC',
            ];
            $result = $um->allp('*',$options);
            $data['incomplete_results'] = false ;
            $data['items'] = $result['data'];
            $data['page'] = $result['curp'];
            $data['total_count'] = $result['norecords'];
            echo json_encode($data);
        }
    }
?>