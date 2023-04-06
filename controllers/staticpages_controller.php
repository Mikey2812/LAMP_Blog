<?php
class staticpages_controller extends vendor_main_controller {
	public $layout = "errors/";
	public function index() {
		$this->display();
	} 
	
	public function error() {
		$this->display();
	} 
}
?>