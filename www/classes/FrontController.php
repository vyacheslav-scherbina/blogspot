<?php
Class FrontController{
	
	private $registry;
	private static $current_user_role = Role::unknown;
	
	static function setCurrentUserRole($value){
		self::$current_user_role = $value;
	}
	
	static function getCurrentUserRole(){
		return self::$current_user_role;
	}
	
	private function determineCurrentUserRole(){
		$id = $this->registry->get('session')->get('id');
		if(!empty($id)){
			$this->setCurrentUserRole(Role::regular);
		}
	}
	
	function __construct(){
		$this->registry = Registry::getInstance();
		$this->determineCurrentUserRole();
	}
	
	function run(){
		$controller = $this->registry->get('request')->get('controller');
		$method = $this->registry->get('request')->get('method');
		$arg = $this->registry->get('request')->get('arg');
		
		if(empty($controller)){
			$controller = 'action';
		}
		if(empty($method)){
			$method = 'index';
		}
		
		$main_class_path = $this->registry->get('controller_path') . 'Controller.php';
		include $main_class_path;
		
		$class_name = 'Controller_' . $controller;
        $class_path = $this->registry->get('controller_path') . $class_name . '.php';
		
		if(file_exists($class_path)){
			include $class_path;
		}
		else{
			throw new Exception('Not Found');
		}
		$controller =  new $class_name();
						
		try{
			$controller->before($method);
			$controller->$method($arg);
			
		}
		catch(Exception $e){
			//echo $e->getMessage();//Not Found | Forbidden
			header('location:' . absolute_path);
		}
	}

}

?>