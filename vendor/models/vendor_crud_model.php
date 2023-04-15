<?php
class vendor_crud_model extends vendor_main_model {
	protected $relationships;
	protected $error;
	use vendor_validator;

	public function delRecord($id=null, $conditions=null) {
		if(is_array($id)) {
			$id = array_key_exists('id', $id)? $id['id']: $id[1];
		}
		if($conditions && $id != null)	$conditions = ' and '.$conditions;
		$id = vendor_html_helper::processSQLString($id);
		if ($id == null) {
			$sql = "DELETE FROM $this->table WHERE ".$conditions;
		} else {
			$sql = "DELETE FROM $this->table WHERE id=$id".$conditions;
		}
		return $this->con->query($sql);
	}
	
	public function delRelativeRecord($id=null, $conditions=null) {
		if($conditions)	$conditions = ' and '.$conditions;
		$tables = $this->table;
		$innerJoin = "";

		if(isset($this->relationships) && isset($this->relationships['hasMany'])) {
			$hasManyArr = (vendor_app_util::is_multi_array($this->relationships['hasMany']))?
							$this->relationships['hasMany'] : [$this->relationships['hasMany']];
			foreach($hasManyArr as $v) {
				if($v['on_del']) {
					$joinTable = $this->getTableNameFromModelName($v[0]);
					$tables .= ",".$joinTable;
					$innerJoin .= " LEFT JOIN ".$joinTable." ON ".$this->table.".id=".$joinTable.".".$v['key'];
				}
			}
		}
		$id = vendor_html_helper::processSQLString($id);
		$sql = "DELETE ".$tables." FROM ".$this->table.$innerJoin." WHERE $this->table.id=$id".$conditions;
		echo $sql;
		exit();
		return $this->con->query($sql);
	}
	
	public function delRelativeRecordWhere($id=null, $conditions=null) {
		if($conditions)	$conditions = ' and '.$conditions;
		$tables = $this->table;
		$wheres = "";

		if(isset($this->relationships) && isset($this->relationships['hasMany'])) {
			$hasManyArr = (vendor_app_util::is_multi_array($this->relationships['hasMany']))?
							$this->relationships['hasMany'] : [$this->relationships['hasMany']];
			foreach($hasManyArr as $v) {
				if($v['on_del']) {
					$joinTable = $this->getTableNameFromModelName($v[0]);
					$tables .= ",".$joinTable;
					$wheres .= " AND ".$this->table.".id=".$joinTable.".".$v['key'];
				}
			}
		}
		$id = vendor_html_helper::processSQLString($id);
		$sql = "DELETE ".$tables." FROM ".$tables." WHERE id=$id".$wheres.$conditions;
		return $this->con->query($sql);
	}

	// Function delete record and relationship with all deep 
	//public function delRecordsRelationshipAllDeep($ids=null, $conditions=null) {}
	public function delRRAD($id=null, $conditions=null) {
		if($conditions)	$conditions = ' and '.$conditions;
		$id = vendor_html_helper::processSQLString($id);
		$sql = "DELETE FROM $this->table WHERE id=$id".$conditions;
		if($this->con->query($sql)) {
			if(isset($this->relationships) && isset($this->relationships['hasMany'])) {
				$hasManyArr = (vendor_app_util::is_multi_array($this->relationships['hasMany']))?
								$this->relationships['hasMany'] : [$this->relationships['hasMany']];
				foreach($hasManyArr as $v) {
					if($v['on_del']) {
						$joinTable = $this->getTableNameFromModelName($v[0]);
						$joinModel = new $v[0]();
						$joinRecords = $joinModel->getRecords('id',['conditions'=>$joinTable.'.'.$this->table.'_id = '.$id]);
						while($record = mysqli_fetch_array($joinRecords)) {
							$joinModel->delRRAD($record['id']);
						}
					}
				}
			}
			return true;
		} else
			return false;
	}
	
	public function delRecords($ids=null, $conditions=null) {
		if($conditions)	$conditions = ' and '.$conditions;
		$ids = vendor_html_helper::processSQLString($ids);
		$sql = "DELETE FROM $this->table WHERE id in ($ids) $conditions";
		return $this->con->query($sql);
	}
	
	public function delRelativeRecords($ids=null, $conditions=null) {
		if($conditions)	$conditions = ' and '.$conditions;
		$tables = $this->table;
		$innerJoin = "";

		if(isset($this->relationships) && isset($this->relationships['hasMany'])) {
			$hasManyArr = (vendor_app_util::is_multi_array($this->relationships['hasMany']))?
							$this->relationships['hasMany'] : [$this->relationships['hasMany']];
			foreach($hasManyArr as $v) {
				if($v['on_del']) {
					$joinTable = $this->getTableNameFromModelName($v[0]);
					$tables .= ",".$joinTable;
					$innerJoin .= " LEFT JOIN ".$v[0]." ON ".$this->table.".id=".$joinTable.".".$v['key'];
				}
			}
		}
		$sql = "DELETE ".$tables." FROM ".$this->table.$innerJoin." WHERE $this->table.id in ($ids) $conditions";
		return $this->con->query($sql);
	}
	
	public function delRelativeRecordsWhere($ids=null, $conditions=null) {
		if($conditions)	$conditions = ' and '.$conditions;
		$tables = $this->table;
		$wheres = "";

		if(isset($this->relationships) && isset($this->relationships['hasMany'])) {
			$hasManyArr = (vendor_app_util::is_multi_array($this->relationships['hasMany']))?
							$this->relationships['hasMany'] : [$this->relationships['hasMany']];
			foreach($hasManyArr as $v) {
				if($v['on_del']) {
					$joinTable = $this->getTableNameFromModelName($v[0]);
					$tables .= ",".$joinTable;
					$wheres .= " AND ".$this->table.".id=".$joinTable.".".$v['key'];
				}
			}
		}
		$ids = vendor_html_helper::processSQLString($ids);
		$sql = "DELETE ".$tables." FROM ".$tables." WHERE id in ($ids) $wheres $conditions";
		return $this->con->query($sql);
	}

	// Function delete records and relationship with all deep 
	//public function delRecordsRelationshipAllDeep($ids=null, $conditions=null) {}
	// public function delRsRAD($id=null, $conditions=null) {
	// 	if($conditions)	$conditions = ' and '.$conditions;
	// 	$ids = vendor_html_helper::processSQLString($ids);
	// 	$sql = "DELETE FROM $this->table WHERE id in ($ids) $conditions";
	// 	if($this->con->query($sql)) {
	// 		if(isset($this->relationships) && isset($this->relationships['hasMany'])) {
	// 			$hasManyArr = (vendor_app_util::is_multi_array($this->relationships['hasMany']))?
	// 							$this->relationships['hasMany'] : [$this->relationships['hasMany']];
	// 			foreach($hasManyArr as $v) {
	// 				if($v['on_del']) {
	// 					$joinTable = $this->getTableNameFromModelName($v[0]);
	// 					$joinModel = new $v[0]();
	// 					$joinRecords = $joinModel->getRecords('id',['conditions'=>$joinTable.'.'.$this->table.'_id = in ('.$ids.')']);
	// 					while($record = mysqli_fetch_array($joinRecords)) {
	// 						$joinModel->delRRAD($record['id']);
	// 					}
	// 				}
	// 			}
	// 		}
	// 		return true;
	// 	} else
	// 		return false;
	// }
	
	public function addRecord($datas) {
		global $app;
		$fields = $values = '';
		$i=0;
		foreach($datas as $k=>$v) {
			if (is_string($v)) {
				$v = mysqli_real_escape_string($this->con, $v);
			}

			if($i) {
				$fields .=',';
				$values .=',';
			}
			$fields .= $k;
			$values .= "'".$v."'";
			$i++;
		}
		if($createdTime = $this->recordTime($app['recordTime']['created'])) {
			$fields .= ','.$app['recordTime']['created'];
			$values .=','.$createdTime;
		}
		if($updatedTime = $this->recordTime($app['recordTime']['updated'])) {
			$fields .= ','.$app['recordTime']['updated'];
			$values .=','.$updatedTime;
		}
		$query = "INSERT INTO $this->table($fields) VALUES ($values)";
		if(mysqli_query($this->con,$query)){
			return $this->con->insert_id;
		}
		else {
			$this->errors['type']		=	'database';
			$this->errors['message'] 	= mysqli_error($this->con);
			return false;
		}
	}
	
	public function editRecord($id,$datas,$conditions=null){
		global $app;
		if(is_array($id)) {
			$id = array_key_exists('id', $id)? $id['id']: $id[1];
		}
		$setDatas = '';
		$i=0;
		foreach($datas as $k=>$v) {
			if (is_string($v)) {
				$v = mysqli_real_escape_string($this->con, $v);
			}
			if($i) {
				$setDatas .=',';
			}
			$setDatas .= $k."='".$v."'";
			$i++;
		}
		if($updatedTime = $this->recordTime($app['recordTime']['updated'])) {
			$setDatas .= ','.$app['recordTime']['updated'].'='.$updatedTime;
		}
		if($conditions)	$conditions = ' and '.$conditions;
		$query = "UPDATE $this->table SET $setDatas WHERE id='$id'".$conditions;
		echo $query;
		exit();
		if(mysqli_query($this->con,$query))
			return true;
		else {
			$this->errors['type']		=	'database';
			$this->errors['message'] 	= mysqli_error($this->con);
			return false;
		}
    }

	public function editRecords($ids,$datas,$conditions=null){
		global $app;
		$setDatas = '';
		$i=0;
		foreach($datas as $k=>$v) {
			if($i) {
				$setDatas .=',';
			}
			$v = vendor_html_helper::processSQLString($v);
			$setDatas .= $k."='".$v."'";
			$i++;
		}
		if($updatedTime = $this->recordTime($app['recordTime']['updated'])) {
			$setDatas .= ','.$app['recordTime']['updated'].'='.$updatedTime;
		}
		if($conditions)	$conditions = ' and '.$conditions;
		$ids = vendor_html_helper::processSQLString($ids);
		$query = "UPDATE $this->table SET $setDatas WHERE id IN($ids)".$conditions;
		if(mysqli_query($this->con,$query))
			return true;
		else {
			$this->error = mysqli_error($this->con);
			return false;
		}
	}

	public function editRecordsWhere($data, $conditions=""){
		$i=0;
		$setDatas='';
		foreach($data as $k=>$v) {
			if($i) {
				$setDatas .=',';
			}
			$setDatas .= $k."='".$v."'";
			$i++;
		}
		$query = "UPDATE $this->table SET $setDatas ".($conditions!=""?"WHERE ".$conditions:'');
		if(mysqli_query($this->con,$query))
			return true;
		else {
			$this->error = mysqli_error($this->con);
			return false;
		}
	}

	public function deleteRecordsWhere($conditions=""){
		$query = "DELETE FROM ".$this->table.($conditions!=""?" WHERE ".$conditions:'');
		if(mysqli_query($this->con,$query))
			return true;
		else {
			$this->error = mysqli_error($this->con);
			return false;
		}
	}

    private function recordTime($field) {
    	$fields = $this->getColumnsName();
    	$recordTime = "";
    	$datetime = date('Y-m-d h:i:s', time());
    	if(in_array($field, $fields)) {
    		$recordTime .= '"'.$datetime.'"';
    	}
    	return $recordTime;
    }

    private function getColumnsName() {
    	$sql = 'DESCRIBE '.$this->table;
		$result = mysqli_query($this->con,$sql);

		$rows = array();
		if($result){
			while($row = mysqli_fetch_assoc($result)) {
				$rows[] = $row['Field'];
			}
		}

		return $rows;
    }

    // Validate data from post form
    public function validator($data, $editId=false) {
    	$rs = ['status'=>true, 'message'=>[]];
    	if(method_exists($this, 'rules')) {
    		$rules = $this->rules();
			foreach ($data as $field => $dv) {
				$errMessages = [$field=>[]];
				if(isset($rules[$field])) {
					foreach ($rules[$field] as $rv) {
						if(is_array($rv)) {
							$validName = $rv[0];
							$rvv = (isset($rv['value']))?	$rv['value']:false;
						} else {
							$validName = $rv;
						}
						$validFuncName = $validName.'Field';
						if($validName == 'unique') {
							if($editId===false)
								$vlf = $this->{$validFuncName}($dv, $field);
							else $vlf = $this->{$validFuncName}($dv, $field, $editId);
						} 
						else if($validName == 'matchPassword') {
							$vlf = $this->{$validFuncName}($dv,$data['password']);
						}else if(isset($rvv) && $rvv) {
						    $vlf = $this->{$validFuncName}($dv, $rvv);
						} else {
							$vlf = $this->{$validFuncName}($dv);
						}
						if(!$vlf['status']) {
							$rs['status']=false;
							$errMessages[$field][$validName] = $vlf['message'];
							$rs['message'][$field] = $errMessages[$field];
						}
					}
				}
			}
		}
    	return $rs;
    }

	/*
    public function validator($data, $editId=false) {
    	$rs = ['status'=>true, 'message'=>[]];
    	$rules = $this->rules();
    	foreach ($data as $field => $dv) {
    		$errMessages = [$field=>[]];
    		if(isset($rules[$field])) {
	    		foreach ($rules[$field] as $rv) {
	    			$errmsg = null;	$rvv = false;
	    			if(is_array($rv)) {
	    				$validName = $rv[0];
	    				if(isset($rv['value']))	$rvv = $rv['value'];
	    				if(isset($rv['errmsg'])) $errmsg = $rv['errmsg'];
	    			} else {
	    				$validName = $rv;
	    			}
	    			$validFuncName = $validName.'Field';
	    			if($validName=='unique') {
	    				$vlf = $this->{$validFuncName}($field, $dv, $editId, $errmsg);
	    			} else if(isset($rvv) && $rvv) {
	    			    $vlf = $this->{$validFuncName}($field, $dv, $rvv, $errmsg);
	    			} else {
	    				$vlf = $this->{$validFuncName}($field, $dv, $errmsg);
	    			}
	    			if(!$vlf['status']) {
	    				$rs['status']=false;
						$errMessages[$field][$validName] = $vlf['message'];
	    				$rs['message'][$field] = $errMessages[$field];
	    			}
	    		}
	    	}
    	}
    	return $rs;
    }
	*/
}
?>