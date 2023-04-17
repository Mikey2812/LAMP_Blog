<?php
	class home_controller extends vendor_main_controller {
		public function index() {
			$pm = post_model::getInstance();
			$conditions = '';
			$this->records = $pm->allp('*',['conditions'=>$conditions, 'joins'=>['user'], 'order' => 'view DESC',
			 'pagination' => ['nopp' => '3']]);
			$this->display();
		}
		// public function view($id) {
		// 	$pm = post_model::getInstance();
		// 	$this->record = $pm->getRecord($id);
		// 	$pm->addViews($id[1]);
		// 	$this->display();
		// } 
	}
?>