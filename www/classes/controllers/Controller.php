<?php
abstract class Controller{

	protected $model;
	protected $registry;
	protected $view;
		
	function __construct(){
		$this->registry = Registry::getInstance();
		
		$this->setModel(new TableFactory());
		
		$view_class_path = $this->registry->get('view_path') . 'View.php';
		include $view_class_path;
		
		$this->view = new View();
				
	}
	
	function setModel($model){
		$this->model = $model;
	}
	
	function getModel(){
		return $this->model;
	}
	
	function before($method){
		$flag = false;
		$access_array = $this->registry->get('access_array');
		$controller = get_called_class();
		foreach($access_array as $key=>$value){
			if($access_array[$key]['controller'] == $controller && $access_array[$key]['method'] == $method){
				
				$flag = true; // если не будет тру значит контроллера с таким методом не существует
				break;
			}
			
		}
		if(!$flag){
			throw new Exception('Not Found');
		}
		if(FrontController::getCurrentUserRole() != $access_array[$key]['role'] && $access_array[$key]['role'] !== '*'){
			throw new Exception('Forbidden');
		}
	}
	
	protected function filter($input){	
		if(!is_array($input)){
			return htmlspecialchars($input, ENT_QUOTES);
		}
		else{
			foreach($input as $key=>$value){
				$output[$key] = $this->filter(&$value);
			}
			return $output;
		}
	}
	
}
?>