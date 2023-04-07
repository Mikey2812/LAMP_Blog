<?php
class vendor_main_model {
	protected $con;
	protected $table;
	public $nopp = 20;
	public $curp = 1;
	public $errors = false;
  private static $instance = [];  

	public function __construct(){
		global $app;
		if(isset($app['prs']['p'])) $this->curp = $app['prs']['p'];

		$instanceDB = vendor_connectdb_model::getInstance();
		$this->con = $instanceDB->getConnection();
		if(!$this->table)	$this->setTableName();
	}

	public static function getInstance() {
		$called_class = get_called_class();
        if (!array_key_exists($called_class,self::$instance)) {
			self::$instance[$called_class] = new $called_class();
		}
        return self::$instance[$called_class];
    }
	
	protected function setTableName($table=null){
		if($table) {
			$this->table=$table;
		} else {
			$cln = get_class($this);
			$clnf = str_split($cln, strrpos($cln, '_'))[0];
			$this->table = vendor_noun_util::pluralize($clnf);
		}
	}
	
	/* Old code! Should you vendor_noun_util::pluralize instead of this function */
	public function getTableNameFromModelName($modelName) {
		if (strrpos($modelName,"y")) {
			if ((strrpos($modelName,"y") + 1) == strlen($modelName)) {
				return str_split($modelName, strrpos($modelName, 'y'))[0].'ies'; 
			} 
		}
		return $modelName.'s';
	}
		
	public function getAllTables() {
		$sql = "SHOW TABLES FROM ".DB_NAME;
		$query = mysqli_query($this->con,$sql);
		$result = [];
		if($query) {
			while($field = mysqli_fetch_row($query)) {
				array_push($result, $field[0]);
			}
		}
		return $result;
	}
	
	public function getAllFieldsOfTable($tableName) {
		$sql = "SHOW COLUMNS FROM ".$tableName;
		$fields = $this->con->query($sql);
		$result = [];
		while($field = mysqli_fetch_array($fields)) {
    		array_push($result, $field['Field']);
    	}
		return $result;
	}
	
	public function getTableName() {
		return $this->table;
	}

	public function getCountRecords($options=null) {
		$conditions = (isset($options['conditions']) && $options['conditions'])? $options['conditions']: '';
		$join = "";
		if(isset($this->relationships) && (isset($options['joins']) && $options['joins'])) {
			$join = $this->addJoins($options)['join'];
			$conditions = $conditions? $this->conditionsJoin($conditions):"";
		}
		$conditions = $conditions? ' where '.$conditions: "";

		if(isset($options['group'])) {
			$group = " GROUP BY ";
			if (strpos($options['group'], '.') !== false) {
				$group .= $options['group'];
			} else 	$group .= $this->table.".".$options['group'];
			$sql = "SELECT COUNT(*) as total FROM (SELECT ".$options['group']." FROM ".$this->table.$join.$conditions.$group.") AS SUBQUERY";
		}else if(isset($options['total-distinct']) && $options['total-distinct']){
			$sql = "SELECT COUNT(DISTINCT ".$this->table.".id) as total FROM ".$this->table.$join.$conditions;
			preg_match('/(.*)(GROUP BY.*)/', $sql, $matches);
			$sql = $matches[1];
		} else {
			$sql = "SELECT COUNT(*) as total FROM ".$this->table.$join.$conditions;
		}
		$result = $this->con->query($sql);
		return $result->fetch_assoc()['total'];
	}

	public function getRecords($fields='*', $options=null) {
		if($fields=='*') $fields = $this->table.".*";
		$join = "";
		$conditions = (isset($options['conditions']) && $options['conditions'])? $options['conditions']: '';

		if(isset($this->relationships) && (isset($options['joins']) && $options['joins'])) {
			$joinR = $this->addJoins($options);
			$join =	$joinR['join'];
			$fields .= $joinR['joinFields'];;

			// Add table prefix for conditions 
			$conditions = $conditions? $this->conditionsJoin($conditions):"";
		}
		$conditions = $conditions? ' WHERE '.$conditions: "";

		$group = "";
		if(isset($options['group'])) {
			$group = " GROUP BY ";
			if (strpos($options['group'], '.') !== false) {
				$group .= $options['group'];
			} else 	$group .= $this->table.".".$options['group'];
		}

		$order = " ORDER BY ";
		if(isset($options['order'])) {
			if(substr($options['order'], 0, 1) == '*' ){
				$order .= substr($options['order'], 1);
			}
			else if (strpos($options['order'], '.') !== false) {
				$order .= $options['order'];
			} else 	$order .= $this->table.".".$options['order'];
		} else
			$order .= $this->table.".created_at DESC";

		$limit = "";
		if(isset($options['pagination'])) {
			if(isset($options['pagination']['page'])) $this->curp = $options['pagination']['page'];
			if(isset($options['pagination']['nopp'])) $this->nopp = $options['pagination']['nopp'];
			$limit = " LIMIT $this->nopp OFFSET ".($this->curp-1)*$this->nopp;
		}

		
		$sql = "SELECT ".$fields." FROM ".$this->table.$join.$conditions.$group.$order.$limit;
		return $this->con->query($sql);
	}

	public function getRecordsWhere($wheres, $fields='*') {
		$conditions = ' WHERE ';
		$i=0;
		foreach ($wheres as $key => $value) {
			$conditions .= (($i)? " AND ":""). $key."='".$value."'";
			$i++;
		}
		return $this->getRecords($fields, $options);
	}

	public function getRecord($id, $fields='*', $options=null) {
		if(is_array($id)) {
			$id = array_key_exists('id', $id)? $id['id']: $id[1];
		}
		$id = vendor_html_helper::processSQLString($id);		
		if($id)	$options = $this->addIDCondition($id, $options);
		return $this->getDetailRecord($fields, $options);
	}

	public function getRecordWhere($wheres, $fields='*', $options=null) {
		if (isset($options['conditions'])) {
		  if(is_array($options['conditions'])) {
		  	$options['conditions'] = array_merge($options['conditions'], $wheres);
			} else {
				$i=0;
				foreach ($wheres as $key => $value) {
					$field = (strpos($key,'.')===false && isset($this->table))? $this->table.'.'.$key: $key;
					$options['conditions'] .= (($i)? " AND ":""). $field."='".$value."'";
					$i++;
				}
			}
		} else $options['conditions'] = $wheres;
		return $this->getDetailRecord($fields, $options);
	}

	public function getCountWhere($wheres) {
		$sql = "COUNT(*) as total FROM {$this->table} WHERE ";
		$i=0;
		foreach ($wheres as $key => $value) {
			$sql .= (($i)? " AND ":""). $key."='".$value."'";
			$i++;
		};
		$result = mysqli_query($this->con,$sql);
		if (!$result) return false;
		$rows = array();
		while($row = mysqli_fetch_assoc($result)) {
			$rows[] = $row;
		}
		return $rows;
	}

	/*
	// Function getDetailRecord for get one row without id
	// Parrams:
	//		$joinFields : string fields
	//		$options 		: [] without conditions with items can be order, group , limit
	// Return: mysqli_result object
	*/
	public function getDetailRecord($fields='*', $options=null) {
		$join = '';
		$opConditions = (isset($options['conditions']) && $options['conditions'])? $options['conditions']: '';
		if(isset($this->relationships) && (isset($options['joins']) && $options['joins'])) {
			$joinFields = "";
			foreach($this->relationships as $k=>$rv) {
				if(!vendor_app_util::is_multi_array($rv)) {
					$vtmp = $rv;
					$rv = [];
					$rv[] = $vtmp;
				}
				foreach($rv as $v) {
					if(isset($options['joins']) && !in_array($v[0],$options['joins']))
						continue;
					$joinTable = $this->getTableNameFromModelName($v[0]);
					$joinTableFields = $this->getAllFieldsOfTable($joinTable);
					if($k=="belongTo") {
						foreach ($joinTableFields as $field) {
							$joinFields .= ", ".$joinTable.".".$field." as ".$joinTable."_".$field;
						}
						$join .= " LEFT JOIN ".$joinTable." ON ".$this->table.".".$v['key']."=".$joinTable.".id ";
					} else if($k=="hasMany" && ((isset($options['get-child']) && $options['get-child']) || isset($options['group']))){
						if(!isset($options['group'])) {
							foreach ($joinTableFields as $field) {
								$joinFields .= ", ".$joinTable.".".$field." as ".$joinTable."_".$field;
							}
						}
						$join .= " RIGHT JOIN ".$joinTable." ON ".$this->table.".id=".$joinTable.".".$v['key']." ";
					}
				}
			}
			// Check if $fields has $this->table ?
			if($joinFields)	$fields = $this->table.'.'.$fields.$joinFields;
			$joinConditions = $this->conditionsJoin($opConditions);
		}
		$conditions = is_array($opConditions)? $this->conditionsJoin($opConditions)	: ($joinConditions?? $opConditions);
		$conditions = "WHERE ". $conditions;

		/* Becaful with group */
		$group = "";
		if(isset($options['group'])) {
			$group = "GROUP BY ";
			if (strpos($options['group'], '.') !== false) {
				$group .= $options['group'];
			} else 	$group .= $this->table.".".$options['group'];
		}

		$order = (isset($options['order']))? "ORDER BY ".$options['order']:'';

		$limit = (isset($options['limit']))? "LIMIT ".$options['limit']:"";

		$sql = "SELECT $fields FROM $this->table $join $conditions $group $order $limit";
		$result = $this->con->query($sql);
		if($result) {
			$record = $result->fetch_assoc();
		} else $record=false;
		return $record;
	}

	public function delRecordByCond($conditions=null) {
		if($conditions)
			$sql = "DELETE FROM $this->table WHERE ".$conditions;
		return mysqli_query($this->con,$sql);
	}

	public function updateWhere($datas,$conditions=null) {
		global $app;
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
		if($updatedTime = $this->recordTime($app['recordTime']['updated_at'])) {
			$setDatas .= ','.$app['recordTime']['updated_at'].'='.$updatedTime;
		}
		if($conditions)	$conditions = ' and '.$conditions;
		$sql = "UPDATE $this->table SET $setDatas WHERE ".$conditions;
		if(mysqli_query($this->con,$sql))
			return true;
		else {
			$this->errors['type']		=	'database';
			$this->errors['message'] 	= mysqli_error($this->con);
			return false;
		}
  }

  /*
	// function conditionsJoin build for add table prefix in join query
	// Parrams:
	//		$conditions: string or array
	//				- string type:
	//				- array type : all items 
  */
  protected function conditionsJoin($conditions, $table=null) {
		if(!$table)	$table = $this->table;
		$rs = "";
		if (is_array($conditions)) {
			$i=0;
			foreach($conditions as $k=>$v) {
				if(is_array($v)) {
					if(isset($v['logicalOp']))	$rs .= $v['logicalOp']." ";
					if(vendor_ar_util::is_multi_array($v)) {
						$rs .= "(".$this->conditionsJoin($v).")";
					} else {
						$rs .= $table.".".$v['field']." ".$v['comparisonOp']." '".$v['value']."'";
					}
				} else {
					$rs .= (($i)? " AND ":"").$table.".".$k."='".$v."'";
				}
				$i++;
			}
		} else {
			$arrOps = ['AND', 'OR', 'NOT', '('];
			$j=0;
			$arr = explode(" ",$conditions);
			foreach($arr as $v) {
				if(strpos($v, $this->table.'.')===false) {
					if(strpos($v,'(')!==false)
						$rs .= ($j? " ":"").str_replace('(', '('.$table.'.', $v);
					else {
						if($j) {
							$rs .= " ".(in_array(strtoupper($arr[$j-1]), $arrOps)? $table.'.'.$v: $v);
						} else
							$rs .= $table.'.'.$v;
					}
				} else {
					$rs .= ($j? " ":""). $v;
				}
				$j++;
			}
		}
		return $rs;
  }

  protected function addIDCondition($id, $options=null) {
		if(isset($options['conditions']) && is_array($options['conditions'])) {
			array_unshift($options['conditions'], ['id', ]);
		} else {
			$options['conditions'] = $options['conditions']?? "";
			$options['conditions'] = $this->table.".id=".$id.($options['conditions']? " AND ".$options['conditions']:"");
		}
		return $options;
	}

  protected function addJoins($options=null) {
  	$join = $joinFields = "";
		foreach($this->relationships as $k=>$rv) {
			if(!vendor_app_util::is_multi_array($rv)) {
				$vtmp = $rv;
				$rv = [];
				$rv[] = $vtmp;
			}
			foreach($rv as $v) {
				if(isset($options['joins']) && !in_array($v[0],$options['joins']))
					continue;
				$joinTable = $this->getTableNameFromModelName($v[0]);
				$joinTableFields = $this->getAllFieldsOfTable($joinTable);
				if($k=="belongTo") {
					foreach ($joinTableFields as $field) {
						$joinFields .= ", ".$joinTable.".".$field." as ".$joinTable."_".$field;
					}
					$join .= " LEFT JOIN ".$joinTable." ON ".$this->table.".".$v['key']."=".$joinTable.".id ";
				} else if($k=="hasMany" && isset($options['get-child']) && $options['get-child']) {
					foreach ($joinTableFields as $field) {
						$joinFields .= ", ".$joinTable.".".$field." as ".$joinTable."_".$field;
					}
					$join .= " RIGHT JOIN ".$joinTable." ON ".$this->table.".id=".$joinTable.".".$v['key']." ";
				}else if($k=="hasMany" && isset($options['search-left-join']) && $options['search-left-join']) {
					if(isset($options['onlycolumn']) && $options['onlycolumn']){
					}else{
						foreach ($joinTableFields as $field) {
							$joinFields .= ", ".$joinTable.".".$field." as ".$joinTable."_".$field;
						}
					}
					$join .= " LEFT JOIN ".$joinTable." ON ".$this->table.".id=".$joinTable.".".$v['key']." ";
				}
			}
		}
  	return ['join'=>$join, 'joinFields'=>$joinFields];
  }

	public function getTotal($field, $conditions=null, $table=null) {
		if(!$table)	$table = $this->table;

		$sql = "SELECT SUM($field) as total FROM $table WHERE $conditions";
		$result = $this->con->query($sql);
		if($result) {
			$record = $result->fetch_assoc();
		} else $record=false;
		return $record['total'];
	}

	public function getRecordsArray($fields='*', $options=null) {
		$records = [];
		$resultMObject = $this->getRecords($fields, $options);
		$records['data'] = [];
		if($resultMObject) {
			while($row = $resultMObject->fetch_assoc()) {
	    		$records['data'][] = $row;
	    	}
		}
		//$records['norecords']= $this->getCountRecords($options);
		$records['norecords'] 	= count($records['data']);
		return $records;
	}

  public static function convertToList($mysqliObject, $valueName) {
  	$arrReturn = [];
  	while($row = mysqli_fetch_array($mysqliObject)) {
  		$arrReturn[$row['id']] = $row[$valueName];
  	}
  	return $arrReturn;
  }
}
?>