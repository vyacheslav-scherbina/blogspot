<?php
class View{

	function render($template_path, $data = NULL){
		$template_path = Registry::getInstance()->get('templates_path') . $template_path;
		ob_start();
		
		include $template_path;
		return ob_get_clean();
		
	}

}
?>