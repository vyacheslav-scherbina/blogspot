<?php
abstract class Controller{

	protected $model;
	protected $request;
	
	function __construct($model, $request){
		$this->model = $model;
		$this->request = $request;	
	}
	
	protected function getModel(){
		return $this->model;
	}
		
	protected function render($template_name, $center_data = NULL){
		if(FrontController::getCurrentUserRole() == Role::regular){
			$left_object = new View('left_regular.tpl');
			$tmp = $this->getModel()
				->user
				->select('user.avatar_id', 'user.id')
				->innerJoin('image', 'image.id=user.avatar_id')
				->where('', "user.id={$_SESSION['id']}")
				->query();
			$left_data['user_avatar_id'] = @$tmp[0]['avatar_id'];
			$left_data['user_id'] = @$tmp[0]['id'];
			$left_data['user_first_name'] = $left_object->filter($_SESSION['first_name']);
			$left_data['user_last_name'] = $left_object->filter($_SESSION['last_name']);
		}
		else $left_object = new View('left_unknown.tpl');
		$left_html = $left_object->render(@$left_data);
		
		$right_object = new View('right.tpl');
		$right_data['tags'] = $this->getModel()->tag->select('*')->query();
		if(!empty($right_data['tags'])) $right_data['tags'] = $right_object->filter($right_data['tags']);
		$right_html = $right_object->render($right_data);
		
		$center_object = new View($template_name);
		if(!empty($center_data)) $center_data = $center_object->filter($center_data);
		$center_html = $center_object->render($center_data);
		
		$output_object = new View('output.tpl');         
		$output_data = array('left' => $left_html, 'right'=>$right_html, 'center' => $center_html);
		
		echo $output_object->render($output_data);
    }

	protected function redirect($url){
		header('location:' . $url);
	}
	
}
?>
