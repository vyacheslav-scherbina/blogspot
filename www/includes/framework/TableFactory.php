<?php
class TableFactory{

	private $tables = array();
	private $db;
	private $models_path;

	function __construct($db, $models_path){
		$this->db = $db;
		$this->models_path = $models_path;
	}
	
	function __get($table_name){
		return $this->getTable($table_name);
	}
	
	private function getTable($table_name){
		if(!array_key_exists($table_name, $this->tables)){
			$class_name = $table_name . 'Table';
			$class_path = $this->models_path . $class_name . '.php';
			include $class_path;
			
			$this->tables[$table_name] = new $class_name($this->db, $table_name);
		}
		return $this->tables[$table_name];
	}
	
}
?>
