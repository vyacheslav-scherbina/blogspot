<?php
abstract class Controller{

	protected $model;
	protected $request;
        public $current_user_role;
	
	function __construct($model, $request, $current_user_role){
		$this->model = $model;
		$this->request = $request;	
                $this->current_user_role = $current_user_role;	
	}
	
	protected function getModel(){
		return $this->model;
	}
		
	protected function redirect($url){
		header('location:' . $url);
	}
	
}
?>
