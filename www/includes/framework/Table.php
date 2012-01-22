<?php
abstract class Table{
	
	protected $db;
	protected $table_name;
	protected $specification;
	protected $qry;
	protected $params;

	function __construct($db, $table_name){
		$this->db = $db;
		$this->table_name = $table_name;
		$this->specification = new SQLSpecification($table_name);
	}	
	
	function query(){
		return $this->execute()->fetchAll(PDO::FETCH_ASSOC);
	}	
	
	function execute(){
		//echo $this->qry;
		$statement = $this->db->prepare($this->qry);
		$i = 1;
		
		if(!empty($this->params)){
			foreach($this->params as &$value){
				//echo $value;
				$statement->bindValue($i, $value);
				$i ++;
			}
		}
		
		$statement->execute();
		return $statement;
	}
	
	function insert($params){
		$this->params = $params;
		$this->qry = $this->specification->insert($params);
		return $this;
	}
	
	function select(){
		$fields = func_get_args();
		$this->qry = $this->specification->select($fields);
		return $this;
	}
	
	function innerJoin($table_name, $condition = NULL){
		$this->qry .= $this->specification->innerJoin($table_name, $condition);
		return $this;
	}
	
	function leftJoin($table_name, $condition = NULL){
		$this->qry .= $this->specification->leftJoin($table_name, $condition);
		return $this;
	}	
	
	function where($logical_function){
		$args = func_get_args();
		foreach($args as $key=>$value){
			if($key != 0){
				$tmp = explode('=', $value);
				$arr[$tmp[0]] = $tmp[1];
			}
		}
		$this->params = $arr;
		$this->qry .= $this->specification->where($this->params, $logical_function);
		return $this;
	}
	
	/*function insert($fields){
		$sqlFields = '';
		$sqlValues = '';
		$isFirst = true;
		foreach($fields as $key=>$value){
			if(!$isFirst){
				$sqlFields .= ', ';
				$sqlValues .= ', ';
			}
			$sqlFields .= $key;
			$sqlValues .= '?';
			$isFirst = false;
		}
		$sql = 'INSERT INTO ' . $this->table_name . ' (' . $sqlFields . ') VALUES(' . $sqlValues . ')';
		$statement = $this->db->prepare($sql);
		$i = 1;
		foreach($fields as $key=>$value){
			$statement->bindValue($i, $fields[$key]);
			$i++;
		}

		$statement->execute();
	}
	
	function update($fields, $id){
		$assignment = '';
		$isFirst = true;
		foreach($fields as $key=>$value){
			if(!$isFirst){
				$assignment .= ', ';
			}
			$assignment .=  $key . '=?';
			$isFirst = false;
		}
		$sql = 'UPDATE ' . $this->table_name . ' SET ' . $assignment . ' WHERE id=' . $id;
		$statement = $this->registry->get('db')->prepare($sql);
		$i = 1;
		foreach($fields as $key=>$value){
			$statement->bindValue($i, $fields[$key]);
			$i++;
		}

		$statement->execute();
	}
	
	function delete($id){
		$sql = 'DELETE FROM ' . $this->table_name . ' WHERE id=?';
		$statement = $this->registry->get('db')->prepare($sql);
		$statement->bindValue(1, $id);
		$statement->execute();
	}
	
	function selectAll($fields){
		if($fields != '*'){
			$fields = implode(',', $fields);
		}
		$sql = 'SELECT ' . $fields . ' FROM ' . $this->table_name;
		$statement = $this->registry->get('db')->prepare($sql);
		$statement->execute();
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}
	
	function selectWithWhereCondition($fields, $where = array(), $logical_function = NULL){
		$condition = '';
		if($fields !== '*' && is_array($fields)){
			$fields = implode(',', $fields);
		}
		$isFirst = true;
		foreach($where as $key=>$value){
			if(!$isFirst){
				$condition .= ' ' . $logical_function . ' ';
			}
			$condition .= $key . '=?';
			$isFirst = false;
		}
		$sql = 'SELECT ' . $fields . ' FROM ' . $this->table_name . ' WHERE ' . $condition;
		$statement = $this->registry->get('db')->prepare($sql);
		$i = 1;
		foreach($where as $key=>$value){
			$statement->bindValue($i, $where[$key]);
			$i++;
		}
		$statement->execute();
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}
	
	function selectWithJoinCondition($fields, $joined_table_name, $join = array()){
		$join_condition = '';
		if($fields != '*'){
			$fields = implode(',', $fields);
		}
		foreach($join as $a=>$b){
			$join_condition = $a . '=' . $b;
		}
		$sql = 'SELECT ' . $fields . ' FROM ' . $this->table_name . ' JOIN ' . $joined_table_name .' ON (' . $join_condition . ')';
		$statement = $this->db->prepare($sql);
		$statement->execute();
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}

	
	function selectWithJoinAndWhereCondition($fields, $joined_table_name, $join = array(), $where = array(), $logical_function = NULL){
		$join_condition = '';
		$where_condition = '';
		if($fields != '*'){
			$fields = implode(',', $fields);
		}
		$isFirst = true;
		foreach($where as $key=>$value){
			if(!$isFirst){
				$where_condition .= ' ' . $logical_function . ' ';
			}
			$where_condition .= $key . '=?';
			$isFirst = false;
		}
		foreach($join as $a=>$b){
			$join_condition = $a . '=' . $b;
		}
		$sql = 'SELECT ' . $fields . ' FROM ' . $this->table_name . ' JOIN ' . $joined_table_name .' ON (' . $join_condition . ') WHERE ' . $where_condition;
		$statement = $this->registry->get('db')->prepare($sql);
		$i = 1;
		foreach($where as $key=>$value){
			$statement->bindValue($i, $where[$key]);
			$i++;
		}
		$statement->execute();
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}
	
	*/
	function getLastInsertId(){
		return $this->db->lastInsertId();
	}
	
}

?>
