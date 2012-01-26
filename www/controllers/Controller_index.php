<?php
class Controller_index extends Controller{

	function index(){	
		$data['blogs'] = $this->getModel()
			->blog
			->select('blog.id', 'blog.name','blog.owner_id', 'user.first_name', 'user.last_name')
			->InnerJoin('user', 'blog.owner_id=user.id')
			->query();
		
		$this->render('users_blogs_table.tpl', $data);
	}
	
	function results($input){
		$register = 'Регистрация прошла успешно !';
		$new_blog = 'Блог создан успешно !';
		$new_message = 'Сообщение создано успешно !';
		
		$data['message'] = @$$input;
				
		echo $this->render('notice.tpl', $data);
	}

	
	
}
?>
