<?php
class Request{

	private $request;
	public $controller;
	public $method;
	public $arg;

	function __construct($request){
		$this->request = $request;
		if(!empty($request)){
			@list($this->controller, $this->method, $this->arg) = explode('/', $request['action']);
		}
	}
		
        function getRequestMethod(){
            return $_SERVER['REQUEST_METHOD'];
        }
        
	function get($name){
		return $this->request[$name];
	}

}
