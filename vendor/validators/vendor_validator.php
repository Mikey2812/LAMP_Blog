<?php
trait vendor_validator {
	public static function convertErrorMessage($errmsgs) {
		$rs = [];
		foreach ($errmsgs as $key => $value) {
			$rs[$key] = implode("<br>",$value);
		}
		return $rs;
	}

	public function requiredField($value) {
		if(!strlen(trim($value)))
			return ['status'=>false, 'message'=>"This field can not blank!"];
		else return ['status'=>true];
	}

	public function minField($value, $length) {
		if(strlen($value)<$length) 
			return ['status'=>false, 'message'=>"The length of this field can not less than $length character!"];
		else return ['status'=>true];
	}

	public function maxField($value, $length) {
		if(strlen($value)>$length) 
			return ['status'=>false, 'message'=>"The length of this field can not more than $length character!"];
		else return ['status'=>true];
	}

	public function booleanField($value) {
		if(is_bool($value))
			return ['status'=>true];
		else return ['status'=>false, 'message'=>"The type of this field should be boolean!"];
	}

	public function integerField($value) {
		if(is_int($value))
			return ['status'=>true];
		else return ['status'=>false, 'message'=>"The type of this field should be interger!"];
	}

	public function floatField($value) {
		if(is_float($value))
			return ['status'=>true];
		else return ['status'=>false, 'message'=>"Vui lòng nhập số thực!"];
	}

	public function doubleField($value) {
		if(is_double($value))
			return ['status'=>true];
		else return ['status'=>false, 'message'=>"The type of this field should be float!"];
	}
 
	public function numberField($value) {
		if(is_numeric($value))
			return ['status'=>true];
		else return ['status'=>false, 'message'=>"The type of this field should be number!"];
	}

	public function stringField($value) {
		if(is_string($value))
			return ['status'=>true];
		else return ['status'=>false, 'message'=>"The type of this field should be string!"];
	}

	public function emailField($value) {
		if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
		  	return ['status'=>true];
		} else return ['status'=>false, 'message'=>"Invalid email format!"];
	}

	public function urlField($value) {
		if (preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$value)) {
			return ['status'=>true];
		} else return ['status'=>false, 'message'=>"Invalid url format!"];
	}

	public function fileField() {
		return ['status'=>true];
	}

	public function imageField() {
		return ['status'=>true];
	}

	public function uniqueField($value, $field, $editId=false) {
		if($editId===false)
			$checkExist = $this->getCountRecords(['conditions'=>$field.'="'.$value.'"']);
		else 	$checkExist = $this->getCountRecords(['conditions'=>$field.'="'.$value.'" AND id<>'.$editId]);
		if($checkExist)
			return ['status'=>false, 'message'=>"This value already exist!"];
		else
			return ['status'=>true];
	}

	public function matchPasswordField($value, $value2) {
		if(($value == $value2) == 1)
			return ['status'=>true];
		else
			return ['status'=>false, 'message'=>"Password not match!"];
	}

	public function inlistField($value, $list) {
		if (in_array($value, $list)) {
			return ['status'=>true];
		} return ['status'=>false, 'message'=>"Value of this field should in  ".implode(", ",$list)];
	}

	public static function datetimeField($datetime, $format = 'Y-m-d H:i:s')
	{
		if(substr_count($datetime, ':') < 2)	$datetime .= ":00";
	    $d = DateTime::createFromFormat($format, $datetime);
	    if($d && $d->format($format) == $datetime)
			return ['status'=>true];
		else
	    	return ['status'=>false, 'message'=>"This value invalid datetime!"];
	}
}
?>
