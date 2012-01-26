<?php
Class FrontController{
	
	private static $current_user_role = Role::unknown;
	private $model;
	private $access_array = array();
	private $controllers_path;
	
	static function setCurrentUserRole($value){
		self::$current_user_role = $value;
	}
	
	static function getCurrentUserRole(){
		return self::$current_user_role;
	}
	
	private function determineCurrentUserRole(){
		if(!empty($_SESSION['id'])){
			$this->setCurrentUserRole(Role::regular);
		}
	}
	
	function __construct($model, $access_array, $controllers_path){
		
		$this->model = $model;
		$this->access_array = $access_array;
		$this->controllers_path = $controllers_path;
		
		$this->determineCurrentUserRole();
	}
	
	function run($request){
			
		$controller = $request->get('controller');
		$method = $request->get('method');
		$arg = $request->get('arg');
		
		if(empty($controller)){
			$controller = 'index';
		}
		if(empty($method)){
			$method = 'index';
		}
		
		$class_name = 'Controller_' . $controller;
		$class_path = $this->controllers_path . $class_name . '.php';
						
		$this->before($class_name, $method);
		
		include $class_path;
		
		$controller =  new $class_name($this->model, $request);
		$controller->$method($arg);
		
	}
	
	private function before($controller, $method){		
		$flag = false;
		foreach($this->access_array as $key=>$value){
			if($this->access_array[$key]['controller'] == $controller && $this->access_array[$key]['method'] == $method){	
				$flag = true;
				break;
			}
			
		}
		if(!$flag){
			throw new Exception('Not Found');
		}
		if(self::getCurrentUserRole() != $this->access_array[$key]['role'] && $this->access_array[$key]['role'] != '*'){
			throw new Exception('Forbidden');
		}
	}

}

?>
