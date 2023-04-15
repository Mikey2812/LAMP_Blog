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
			if (isset($_SESSION['user']['email'])) {
			$um = user_model::getInstance();
			$conditionsUser = 'id = '.$_SESSION['user']['id'];
			$this->likes = $um->allp('*',['conditions'=> $conditionsUser, 
										'joins'=>['like'],
										'get-child'=>true,]);
			}
		
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
			if(isset($_SESSION['user']['id'])){
				$um = user_model::getInstance();
				$conditionsUser = 'id = '.$_SESSION['user']['id'];
				$this->likes = $um->allp('*',['conditions'=> $conditionsUser, 
											'joins'=>['like'],
											'get-child'=>true,]);
			}
			$pm->addViews($id[1]);
			$this->display();
		}

		public function profile($id) {
			if (isset($_SESSION['user']['email'])) {
				$pm = post_model::getInstance();
				$conditions = "user_id = '$id[1]'";
				$this->records = $pm->allp('*',['conditions'=>$conditions, 'joins'=>['user']]);	
				$um = user_model::getInstance();
				$conditionsUser = 'id = '.$_SESSION['user']['id'];
				$this->likes = $um->allp('*',['conditions'=> $conditionsUser, 
											'joins'=>['like'],
											'get-child'=>true,]);
			}
			else {
				header( "Location: ".vendor_app_util::url(array('ctl'=>'login')));
				exit;
			}
			$this->display();
		}
		
		public function add() {
			if (!isset($_SESSION['user']['email'])) {
				header( "Location: ".vendor_app_util::url(array('ctl'=>'login')));
				exit;
			}
			$pm = post_model::getInstance();
			$tm = topic_model::getInstance();
			$this->topics = $tm->getTopics();
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

		public function edit($id) {
			if (!isset($_SESSION['user']['email'])) {
				header( "Location: ".vendor_app_util::url(array('ctl'=>'login')));
				exit;
			}
			$pm = post_model::getInstance();
            $this->record = $pm->one($id[1]);
			$tm = topic_model::getInstance();
			$this->topics = $tm->getTopics();
			if(isset($_POST['btn_submit'])) {
				$postData = $_POST['post'];
				if($_FILES['image']['tmp_name']) {
					if($this->record['image'] && file_exists(RootURI."media/upload/" .$this->controller.'/'.$this->record['image'])) {
						unlink(RootURI."media/upload/" .$this->controller.'/'.$this->record['image']);
					}
					$postData['image'] = $this->uploadImg($_FILES);
				}
				if($pm->editRecord($id, $postData)) {
					header("Location: ".vendor_app_util::url(["ctl"=>"posts"]));
					exit;
				} else {
					$this->errors = ['database'=>'An error occurred when editing data!'];
					$this->record = $postData;
				}
			}
			$this->display();
		}

		public function del($id) {
			if (!isset($_SESSION['user']['email'])) {
				header( "Location: ".vendor_app_util::url(array('ctl'=>'login')));
				exit;
			}
			$pm = post_model::getInstance();
            if($pm->delCommentAndLike($id[1])) {
				$pm->delPostAndLike($id[1]);
				echo "Delete Successful";
			} 
            else echo "error";
		}
	}
?>