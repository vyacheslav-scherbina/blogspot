<?php
abstract class Table{
	
	protected $registry;
	protected $table_name;

	function __construct($table_name){
		$this->registry = Registry::getInstance();
		$this->table_name = $table_name;
	}		
	
	function insert($fields){
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
		$statement = $this->registry->get('db')->prepare($sql);
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
		$statement = $this->registry->get('db')->prepare($sql);
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
	
	
	function getLastInsertId(){
		return $this->registry->get('db')->lastInsertId();
	}
	
}

?>