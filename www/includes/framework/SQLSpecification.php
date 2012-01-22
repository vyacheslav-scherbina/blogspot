<?php
class SQLSpecification{
	
	function __construct($table_name){
		$this->table_name = $table_name;
	}
	
	function select($fields){
		return 'SELECT ' . implode(', ', $fields) . ' FROM ' . $this->table_name;
	}
	
	function where($params, $logical_function){
		$isFirst = true;
		$qry = ' WHERE ';
		foreach($params as $key=>$value){
			if(!$isFirst){
				$qry .= ' ' . $logical_function . ' ';
			}
			$qry .= $key . '=?';
			$isFirst = false;
		}
		return $qry;
	}
	
	function innerJoin($table_name, $condition = NULL){
		$qry = ' INNER JOIN ' . $table_name;
		if(!empty($condition)){
			$qry .= ' ON(' . $condition . ')';
		}
		return $qry;
	}
	
	function leftJoin($table_name, $condition = NULL){
		$qry = ' LEFT JOIN ' . $table_name;
		if(!empty($condition)){
			$qry .= ' ON(' . $condition . ')';
		}
		return $qry;
	}
	
	function insert($params){	
		$sqlFields = '';
		$sqlValues = '';
		$isFirst = true;
		foreach($params as $key=>$value){
			if(!$isFirst){
				$sqlFields .= ', ';
				$sqlValues .= ', ';
			}
			$sqlFields .= $key;
			$sqlValues .= '?';
			$isFirst = false;
		}
		return 'INSERT INTO ' . $this->table_name . ' (' . $sqlFields . ') VALUES(' . $sqlValues . ')';	
	}
	
}
?>
