<?php
class View{

	private $template_path;

	function __construct($template_name){
		$this->template_path = site_path . 'views/' . $template_name;
	}

	function render($data = NULL){
		if(!empty($data) && is_array($data)){
			foreach($data as $key=>$value){
				$$key = $value;
			}
		}
		ob_start();
		include $this->template_path;
		return ob_get_clean();
		
	}
	
	function filter($input){	
		if(!is_array($input)){
			return htmlspecialchars($input, ENT_QUOTES);
		}
		else{
			foreach($input as $key=>$value){
				$output[$key] = $this->filter($input[$key]);
			}
			return @$output;
		}
	}
	
	function json($par){
		return json_encode($par);
	}

}
?>
