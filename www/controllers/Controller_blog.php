<?php
class Controller_blog extends Controller{
	
	function all($user_id){
		$data['blogs'] = $this->getModel()
			->blog
			->select('blog.id', 'blog.name')
			->innerJoin('user', 'blog.owner_id=user.id')
			->where('', "blog.owner_id=$user_id")
			->query();

		$this->render('blogs_list.tpl', $data);
	}
	
	function messages($blog_id){
		$data['messages'] = $this->getModel()
			->message
			->select('message.id', 'message.topic',	'message.text')
			->innerJoin('blog', 'blog.id=message.blog_id')
			->where('', "message.blog_id=$blog_id")
			->query();
		
		$this->render('messages.tpl', $data);
	}
	
	function create(){
		$submit_button = @$this->request->get('new_blog');
		if($submit_button == 'Готово'){
			$data['errors'] = $this->checkValidBlog();
			if(empty($data['errors'])){
				$values = array(
					'name' => $this->request->get('blog_name'),
					'owner_id' => $_SESSION['id']
				);
				$this->getModel()->blog->insert($values)->execute();
				$url = absolute_path . 'index/results/new_blog';
				$this->redirect($url);
			}
			else{
				$data['blog_name'] = $this->request->get('blog_name');
			}		
		}
		$this->render('new_blog_form.tpl', @$data);
		
	}
	
	private function checkValidBlog(){
		$errors = array();
		$blog_name = $this->request->get('blog_name');
		if(empty($blog_name)){	
			$errors[] = 'Не заполнено поле Название';	
		}
		else{
			$blog_name = $this->request->get('blog_name');
			$owner_id = $_SESSION['id'];
			$rec = $this->getModel()
				->blog
				->select('id')
				->where('AND', "name=$blog_name", "owner_id=$owner_id")
				->query();
				
			if(!empty($rec)){
				$errors[] = 'У Вас уже есть блог с таким названием';	
			}
		}
		return $errors;
	}
	
}
?>
