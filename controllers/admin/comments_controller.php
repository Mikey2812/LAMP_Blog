<?php
    class comments_controller extends vendor_backend_controller {
        public function index() {
            $conditions = "";
            $cm = comment_model::getInstance();
            $this->records = $cm->allp('*',['conditions'=>$conditions, 'joins'=>false]);
            $this->display();
        }

        public function view($id) {
            $cm = comment_model::getInstance();
                $this->record = $cm->getRecord($id);
                $this->display();
        }

        public function changetype() {
            $cm = comment_model::getInstance();
            if (isset($_POST['comment_id'], $_POST['value'])) {
                $commentData['status'] = $_POST['value'];
                $cm->editRecord($_POST['comment_id'], $commentData);
            }
        }

    }
?>