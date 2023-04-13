<?php
	class likes_controller extends vendor_main_controller {
		protected $topics;
		protected $errors;
		protected $comments;

		public function add() {
			if (!isset($_SESSION['user']['email'])) {
				header("Location: ".vendor_app_util::url(array('ctl'=>'login')));
				exit;
			}
			$lm = like_model::getInstance();
			
			if(isset($_POST['location_id'], $_POST['type'])) {
                $likeData["location_id"] = $_POST['location_id'];
			 	$likeData["user_id"] = $_SESSION['user']['id'];
			 	$likeData["type"] = $_POST['type'];
				if($_POST['action'] == '1') {
					$lm->addRecord($likeData);
				}
				else {
					$conditions = 'location_id = '.$likeData["location_id"].' AND user_id = '.$likeData["user_id"];
					$lm->delRecord(null, $conditions);
				}
				if ($likeData["type"] == 0) {
					$pm = post_model::getInstance();
					$pm->updateLikes((int)$_POST['action'], $likeData["location_id"]);
				} else {
					$cm = comment_model::getInstance();
					$cm->updateLikes((int)$_POST['action'], $likeData["location_id"]);
				}
			 	
			}
            else {
                $this->errors = ['database'=>'An error occurred when inserting data!'];
                $this->record = $_POST;
            }
		}
	}
?>