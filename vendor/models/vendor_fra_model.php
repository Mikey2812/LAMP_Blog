<?php
class vendor_fra_model extends vendor_crud_model {
	public function all($fields='*', $options=null) {
		$resultMObject = parent::getRecords($fields, $options);
		if($resultMObject) {
			$result = [];
			while($row = $resultMObject->fetch_assoc()) {
	    		$result[] = $row;
	    	}
			return $result;
		} else return false;
	}

	public function one($id=null, $fields='*', $options=null) {
		if($id)	$options = $this->addIDCondition($id, $options);

		//return parent::getRecordRelation($id, $fields, $options);
		return parent::getDetailRecord($fields, $options);
	}
}
?>