<?php
class Request{

	private $request;
	private $controller;
	private $method;
	private $arg;

	function __construct($request){
		$this->request = $request;
		if(!empty($request)){
			@list($this->controller, $this->method, $this->arg) = explode('/', $request['action']);
		}
	}
	
	function __get($name){
		return $this->request[$name];
	}
	
	function get($name){
		return $this->$name;
	}

}