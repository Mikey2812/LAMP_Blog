<?php
class vendor_frap_model extends vendor_fra_model {
	/*
	$options 					:	multidimensional array
	$options['joins']	:	array with items are all of model would to join 
	*/
	public function allp($fields='*', $options=null) {
		$pagination = [];
		$resultMObject = parent::getRecords($fields, $options);
		$pagination['data'] = [];
		if($resultMObject) {
			while($row = $resultMObject->fetch_assoc()) {
	    		$pagination['data'][] = $row;
	    	}
		}
		$pagination['norecords']= parent::getCountRecords($options);
		$pagination['nocurp'] 	= count($pagination['data']);
		$pagination['curp'] 	= $this->curp;
		$pagination['nopp'] 	= $this->nopp;
		return $pagination;
	}
}
?>