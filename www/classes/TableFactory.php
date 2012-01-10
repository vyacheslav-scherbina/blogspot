<?php
class TableFactory{

	private $tables = array();
	private $registry;

	function __construct(){
		$this->registry = Registry::getInstance();
		
		$main_class_path = $this->registry->get('model_path') . 'Table.php';
		include $main_class_path;
	}
	
	function __get($name){
		return $this->getTable($name);
	}
	
	private function getTable($name){
		if(!array_key_exists($name, $this->tables)){
			$class_name = $name . 'Table';
			$class_path = $this->registry->get('model_path') . $class_name . '.php';
			include $class_path;
			$this->tables[$name] = new $class_name($name);
		}
		return $this->tables[$name];
	}
	
}
?>