<?php
abstract class Table{
	
	public $db;
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
	
	function getLastInsertId(){
		return $this->db->lastInsertId();
	}
	
}

?>
