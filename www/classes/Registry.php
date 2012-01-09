<?php
Class Registry{

	private $vars = array();
		
	private static $instance;
	
	private function __construct(){
	
	}
	
	static function getInstance(){
		if(!isset(self::$instance)){
			self::$instance = new Registry();
		}
		return self::$instance;
	}
	
	function set($key, $var){
		if (isset($this->vars[$key])) {
			die('already set');
		}
        $this->vars[$key] = $var;
        return true;
	}
	
	function get($key){
        if (!isset($this->vars[$key])){
                return null;
        }
        return $this->vars[$key];
	}
	
}
?>