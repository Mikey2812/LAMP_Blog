<?php
	class comments_controller extends vendor_main_controller {
		protected $topics;
		protected $errors;
		protected $comments;

		public function add() {
			if (!isset($_SESSION['user']['email'])) {
				header("Location: ".vendor_app_util::url(array('ctl'=>'login')));
				exit;
			}
			$cm = comment_model::getInstance();
			$pm = post_model::getInstance();
			
			if(isset($_POST['user_id'], $_POST['post_id'], $_POST['content'])) {
				$commentData["user_id"] = $_POST['user_id'];
				$commentData["post_id"] = $_POST['post_id'];
				$commentData["content"] = $_POST['content'];
				$commentData["path"] = '';
				$commentData["type"] = 0;
				if(isset($commentData["content"])) {
					$cmt_id = json_encode($cm->addRecord($commentData));
					echo $cmt_id;
					$pm->addComments($commentData['post_id']);
					$cm->updatePath($commentData['post_id'], $cmt_id);
				}else {
						$this->errors = ['database'=>'An error occurred when inserting data!'];
						$this->record = $_POST;
				}
			}
		}

		public function addreply() {
			if (!isset($_SESSION['user']['email'])) {
				header("Location: ".vendor_app_util::url(array('ctl'=>'login')));
				exit;
			}
			$cm = comment_model::getInstance();
			$pm = post_model::getInstance();
			if(isset($_POST['post_id'], $_POST['content'])) {
				$pathParent = $_POST['path_Parent'];
				$commentData["user_id"] = $_SESSION['user']['id'];
				$commentData["post_id"] = $_POST['post_id'];
				$commentData["content"] = $_POST['content'];
				$commentData["path"] = '';
				$commentData["type"] = 1;
				if(isset($commentData["content"])) {
					$cmt_id = json_encode($cm->addRecord($commentData));
					echo $cmt_id;
					$pm->addComments($commentData['post_id']);
					$cm->updatePath($commentData['post_id'], $cmt_id, $pathParent);
				}else {
						$this->errors = ['database'=>'An error occurred when inserting data!'];
						$this->record = $_POST;
				}
			}
		}
	}
?>