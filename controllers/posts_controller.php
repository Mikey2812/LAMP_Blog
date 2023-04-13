<?php
	class posts_controller extends vendor_main_controller {
		protected $topics;
		protected $errors;
		protected $comments;
		protected $likes;
		public function index() {
			$pm = post_model::getInstance();
			$conditions = '';
			$this->records = $pm->allp('*',['conditions'=>$conditions, 'joins'=>['user']]);
			$um = user_model::getInstance();
			$conditionsUser = 'id = '.$_SESSION['user']['id'];
			$this->likes = $um->allp('*',['conditions'=> $conditionsUser, 
										'joins'=>['like'],
										'get-child'=>true,]);
			//$this->records = $pm->getAllRecords();

			// $this->display();
			// $um = user_model::getInstance();
			// $conditions = '';
			// $this->records = $um->allp('*',
			// 							['conditions'=> $conditions, 
			// 							'joins'=>['post','like'],
			// 							'search-left-join'=>true,
			// 							'order' => 'id ASC']);
			$this->display();
		}

		public function view($id) {
			$pm = post_model::getInstance();
			$this->record = $pm->getRecord($id);
		
			$cm = comment_model::getInstance();
			$conditions = "post_id = '$id[1]'";
			$this->comments = $cm->allp('*',
										['conditions'=> $conditions, 
										'joins'=>['user'],
										'get-child'=>true,
										'order' => 'path ASC']);

			$pm->addViews($id[1]);
			$this->display();
		}

		public function profile($id) {
			$pm = post_model::getInstance();
			$conditions = "user_id = '$id[1]'";
			$this->records = $pm->allp('*',['conditions'=>$conditions, 'joins'=>['user','comment']]);
			$this->display();
		}
		
		public function add() {
			if (!isset($_SESSION['user']['email'])) {
				header( "Location: ".vendor_app_util::url(array('ctl'=>'login')));
				exit;
			}
			$pm = post_model::getInstance();
			$this->topics = $pm->getTopics();
			if(isset($_POST['btn_submit'])) {
				$postData = $_POST['post'];
				if($_FILES['image']['tmp_name'])
                    $postData['image'] = $this->uploadImg($_FILES);
				if($pm->addRecord($postData))
                        header("Location: ".vendor_app_util::url(["ctl"=>"posts"]));
                    else {
                        $this->errors = ['database'=>'An error occurred when inserting data!'];
                        $this->record = $_POST;
                	}
			}
			$this->display();
		}
	}
?>