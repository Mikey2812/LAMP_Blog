<?php
class vendor_fontend_controller extends vendor_crud_controller {
	protected $records;
	protected $record;
	protected $errors;

	public function __construct() {
		$this->checkRole();
		parent::__construct();
	}

	public function checkRole() {
		global $app;
		$this->checkAuth();
		$rolesFlip = array_flip($app['roles']);
		if (!isset($_SESSION['user']['role']) || $_SESSION['user']['role']!=$rolesFlip["admin"]) {
			$_SESSION['flasherror'] = "This page not exist!";
			header( "Location: ".vendor_app_util::url(array('ctl'=>'home')));
			exit;
		}
	}
}
?>