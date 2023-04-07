<?php
class dashboard_controller extends vendor_backend_controller {
	public function index() {
		$this->noUsers 		= (user_model::getInstance())->getCountRecords();
		$this->noTopics		= (topic_model::getInstance())->getCountRecords();
		$this->noPosts 		= (post_model::getInstance())->getCountRecords();
		$this->display();
	}
}
?>