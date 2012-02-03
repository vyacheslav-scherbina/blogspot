<?php
class Controller_blog extends Controller_parent{
	
	function all($user_id){
		$data['blogs'] = $this->getModel()
			->blog
			->select('blog.id', 'blog.name')
			->join('INNER', 'user', 'blog.owner_id=user.id')
			->where('blog.owner_id=?', $user_id)
			->query();

		$this->render('blogs_list.tpl', $data);
	}
	
	function messages($blog_id){
		$data['messages'] = $this->getModel()
			->message
			->select('message.id', 'message.topic',	'message.text')
			->join('INNER', 'blog', 'blog.id=message.blog_id')
			->where('message.blog_id=?', $blog_id)
			->query();
		
		$this->render('messages.tpl', $data);
	}
	
	function create(){
		if($this->request->getRequestMethod() == 'POST'){
			$data['errors'] = $this->checkValidBlog();
			if(empty($data['errors'])){
                                $blog_name = $this->request->get('blog_name');
				$this->getModel()->blog->insert()->set('name=?, owner_id=?', $blog_name, $_SESSION['id'])->execute();
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
			$rec = $this->getModel()
				->blog
				->select('id')
				->where('name=? and owner_id=?', $this->request->get('blog_name'), $_SESSION['id'])
				->query();
				
			if(!empty($rec)){
				$errors[] = 'У Вас уже есть блог с таким названием';	
			}
		}
		return $errors;
	}
	
}
?>
