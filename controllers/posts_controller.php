<?php
	class posts_controller extends vendor_main_controller {
		public function index() {
			$pm = post_model::getInstance();
			$conditions = '';
			$this->records = $pm->allp('*',['conditions'=>$conditions, 'joins'=>['user','comment']]);
			// $this->display();
			$this->display();
		}
		public function view($id) {
			$pm = post_model::getInstance();
			$this->record = $pm->getRecord($id);
			$pm->addViews($id[1]);
			$this->display();
		} 
	}
?>