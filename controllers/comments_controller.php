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
			// if(isset($_POST['add_comments'])) {
			// 	$commentData = $_POST['comment'];
			// 	// $path = $this->convertPath($commentData['post_id'], $cm->getID_Auto());
			// 	//$commentData["path"] = $path;
				
			// 	$commentData["path"] = '';
			// 	$commentData["type"] = 0;
			// 	var_dump($commentData);
			// 	if($cm->addRecord($commentData)) {
			// 		$pm->addComments($commentData['post_id']);
			// 		$cm->updatePath();
			// 		header("Location: ".vendor_app_util::url(["ctl"=>"posts", "act"=>"view/".$commentData['post_id']]));
			// 	}else {
			// 			$this->errors = ['database'=>'An error occurred when inserting data!'];
			// 			$this->record = $_POST;
			// 	}
			// }
			
			if(isset($_POST['user_id'], $_POST['post_id'], $_POST['content'])) {
				$commentData["user_id"] = $_POST['user_id'];
				$commentData["post_id"] = $_POST['post_id'];
				$commentData["content"] = $_POST['content'];
				$commentData["path"] = '';
				$commentData["type"] = 0;
				if($cm->addRecord($commentData)) {
					$pm->addComments($commentData['post_id']);
					$cm->updatePath();
					header("Location: ".vendor_app_util::url(["ctl"=>"posts", "act"=>"view/".$commentData['post_id']]));
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
				$commentData["user_id"] = $_SESSION['user']['id'];
				$commentData["post_id"] = $_POST['post_id'];
				$commentData["content"] = $_POST['content'];
				$commentData["path"] = '';
				$commentData["type"] = 1;
				var_dump($commentData);
				exit();
				// if($cm->addRecord($commentData)) {
				// 	$pm->addComments($commentData['post_id']);
				// 	$cm->updatePath();
				// 	header("Location: ".vendor_app_util::url(["ctl"=>"posts", "act"=>"view/".$commentData['post_id']]));
				// }else {
				// 		$this->errors = ['database'=>'An error occurred when inserting data!'];
				// 		$this->record = $_POST;
				// }
			}
		}
	}
?>