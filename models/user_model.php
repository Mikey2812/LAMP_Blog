<?php
	class user_model extends vendor_frap_model
	{
		public $nopp = 10;
		public static $avatUrl = UploadREL."users/";
		public static $status = [
							0 => 'Disable',
							1 => 'Enable'
						];

		protected $relationships = [
			'hasMany'	=>	[
				['post', 'key'=>'user_id'],
				['comment', 'key'=>'user_id'],		
				['like', 'key'=>'user_id'],		
			]
		];

		public function rules() {
			global $app;
			return [
				'firstname' => ['string', ['max', 'value'=>50]],
				'lastname' 	=> ['string', ['max', 'value'=>50]],
				'email' 	=> [['required', 'errmsg'=>'email can not bank!'], 'unique', 'string', ['max', 'value'=>60]],
				'email' 	=> ['required', 'unique', ['email','errmsg'=>'Value is invalid email format!']],
				'phone' 	=> ['number', ['min', 'value'=> 9], ['max', 'value'=>14]],
				'password' 	=> ($app['act']=='edit')? []: [['min', 'value'=> 4], ['max', 'value'=>60]],
								// Problem when edit user -> can't validate password
				'address' 	=> ['string'],
				'role'		=> [['inlist', 'value'=>array_keys($app['roles'])]],
				'status'	=> [['inlist', 'value'=>array_keys(self::$status)]]
			];
		}

		public static function getAvatarUrl() {
			return RootURL.self::$avatUrl.$_SESSION['user']['avatar'];
		}

		public static function getFullnameLogined() {
			return ucfirst($_SESSION['user']['firstname'])." ".ucfirst($_SESSION['user']['lastname']);
		}

		public static function getFullname($id) {
			$user = (new self)->getRecord($id);
			return ucfirst($user['firstname'])." ".ucfirst($user['lastname']);
		}

		// public function getTopUser()
		// {
		// 	$rsAll = $this->getAllData();
		// 	$topUser = array();
		// 	for($id = 0; $id < NUM_TOP_USERS; $id++){
		// 		if(isset($rsAll[$id]))
		// 			$topUser[$id] = $rsAll[$id];
		// 		else break;
		// 	}
		// 	return $topUser;
		// }

		public function getAllChangepass()
		{
			$email = ucfirst($_SESSION['user']['email']);
			$sql = "SELECT `password` FROM `users` WHERE `email` = '".$email."'";
			$result = $this->con->query($sql);
			
			return $result;
		}

		public function checkOldPassword($password)
		{
			$email = ucfirst($_SESSION['user']['email']);
			$sql = "SELECT COUNT(id) as total  FROM `users` WHERE `email` = '".$email."' AND `password` = '".$password."'";
			$result = $this->con->query($sql);
			return $result->fetch_assoc()['total'];
		}

		public function updatePassword($newpassword)
		{
			$email = ucfirst($_SESSION['user']['email']);
			$sql = "UPDATE users SET password='$newpassword' WHERE `email` = '".$email."'";
			$result = $this->con->query($sql);
			
			return $result;
		}
		
		public function profile(){
			$email = ucfirst($_SESSION['user']['email']);
			$sql = "SELECT * FROM `users` WHERE `email` = '".$email."'";
			$result = $this->con->query($sql);
			if($result) {
				$record = $result->fetch_assoc();
			} else $record=false;
			return $record;
		}
	}
?>