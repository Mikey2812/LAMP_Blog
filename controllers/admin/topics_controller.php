<?php
class topics_controller extends vendor_backend_controller
    {
        public function index()
        {
            global $app;
            $conditions = "";
            // if (isset($app['prs']['status'])) {
            //     $conditions .= "status=".$app['prs']['status'];
            // }
            // if (isset($app['prs']['role'])) {
            //     $conditions .= (($conditions) ? " AND " : "")."role=".$app['prs']['role'];
            // }
            // if (isset($app['prs']['kw'])) {
            //     $conditions .= (($conditions) ? " AND (" : "")."firstname LIKE '%".$app['prs']['kw']."%' OR lastname LIKE '%".$app['prs']['kw']."%' OR email LIKE '%".$app['prs']['kw']."%'".(($conditions) ? ")" : "");
            // }

            $tm = topic_model::getInstance();
            $this->records = $tm->allp('*', ['conditions'=>$conditions, 'joins'=>false]);
            $this->display();
        }

        public function view($id) {
            $tm = topic_model::getInstance();
                $this->record = $tm->getRecord($id);
                $this->display();
        }

        public function add() {
            $tm = topic_model::getInstance();
            if(isset($_POST['btn_submit'])) {
                $topicData = $_POST['topic'];   
                    if($tm->addRecord($topicData))
                        header("Location: ".vendor_app_util::url(["ctl"=>"topics"]));
                    else {
                        $this->errors = ['database'=>'An error occurred when inserting data!'];
                        $this->record = $topicData;
                    }
            }
            $this->display();
        }

        public function edit($id) {
        $tm = topic_model::getInstance();
            $this->record = $tm->one($id);
            if(isset($_POST['btn_submit'])) {
                $topicData = $_POST['topic'];
                if($_FILES['image']['tmp_name']) {
                    if($this->record['avatar'] && file_exists(RootURI."/media/upload/" .$this->controller.'/'.$this->record['avatar']))
                        unlink(RootURI."/media/upload/" .$this->controller.'/'.$this->record['avatar']);
                    $topicData['avatar'] = $this->uploadImg($_FILES);
                }
                
                $valid = $tm->validator($topicData, $id);
                if($valid['status']){
                    if($topicData['password'])
                        $topicData['password'] = vendor_app_util::generatePassword($topicData['password']);
                    else
                        unset($topicData['password']);


                    if($tm->editRecord($id, $topicData)) {
                        header("Location: ".vendor_app_util::url(["ctl"=>"topics"]));
                    } else {
                        $this->errors = ['database'=>'An error occurred when editing data!'];
                        $this->record = $topicData;
                    }
                } else {
                    $this->errors = $tm::convertErrorMessage($valid['message']);
                    $this->record = $topicData;
                    $this->record['id'] = $id;
                }
            }
            $this->display();
        }

        // public function del($id) {
        //     $tm = topic_model::getInstance();
        //     if($tm->delRelativeRecord($id, "role != 1")) echo "Delete Successful";
        //     else echo "error";
        // }

        public function filter() { 
            $tm = topic_model::getInstance();
            $conditions = '';
            global $app;
            if(isset($app['prs']['kw'])) {
                $conditions .= (($conditions)? " AND (":"")."id LIKE '%".$app['prs']['kw']."%'
                OR name LIKE '%".$app['prs']['kw']."%'".(($conditions)? ")":"");
            }
            $this->records = $tm->allp('*',['conditions'=>$conditions, 'joins'=>false]);
            $this->display();
        }
    }
?>