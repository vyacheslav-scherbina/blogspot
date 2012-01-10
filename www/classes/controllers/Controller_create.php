<?php
class Controller_create extends Controller{

	function blog(){
		$submit_button = @$this->registry->get('request')->get('new_blog');
		if($submit_button == 'Готово'){
			$data['message_2'] = $this->checkValidBlog();
			if(empty($data['message_2'][1])){
				$values = array(
					'name' => $this->registry->get('request')->get('blog_name'),
					'owner_id' => $this->registry->get('session')->get('id')
				);
				$this->getModel()->blog->insert($values);
				header('location:' . absolute_path . 'action/results/new_blog');
			}
			else{
				$keys = array(
					'blog_name'
				);
				foreach($keys as $value){
					$data[$value] = $this->filter($this->registry->get('request')->get($value));
				}				
			}
			
			$data['content'] = $this->view->render('new_blog_form.tpl', $data);
			
			echo $this->view->render('output_index.tpl', $data);				
			
		}
		else{
			header('location:' . absolute_path);
		}
	}
	
	private function checkValidBlog(){
		$errors[] = 'Возникли следующие ошибки:';
		$blog_name = $this->registry->get('request')->get('blog_name');
		if(empty($blog_name)){	
			$errors[] = 'Не заполнено поле Название';	
		}
		elseif(!preg_match('/^[a-z0-9а-я\!\@\#\$\%\^\&\*\(\)\_\=\+\\\|\s]{2,12}$/i', $blog_name)){
			$errors[] = 'Не корректная информация в поле Название';				
		}
		else{
			$condition = array(
				'name' => $this->registry->get('request')->get('blog_name'),
				'owner_id' => $this->registry->get('session')->get('id')
			);
			$rec = $this->getModel()->blog->selectWithWhereCondition('id', $condition, 'AND');
			if(!empty($rec)){
				$errors[] = 'У Вас уже есть блог с таким названием';	
			}
		}
		return $errors;
	}

	function message(){
		$submit_button = @$this->registry->get('request')->get('new_message');
		if($submit_button == 'Готово'){
			$data['message_2'] = $this->checkValidMessage();
			if(empty($data['message_2'][1])){
				$values = array(
					'topic' => $this->registry->get('request')->get('message_topic'),
					'content' => $this->registry->get('request')->get('content'),
					'blog_id' => $this->registry->get('request')->get('blog_id')
				);
				$image_path = $_FILES['image']['tmp_name'];
				if(file_exists($image_path)){
					$img = new Image();
					$values['image'] = $img->image_resize($image_path, 200);
				}
				
				$this->getModel()->message->insert($values);
				$message_id = $this->getModel()->message->getLastInsertId();
				
				$tags = $this->registry->get('request')->get('tags');
				$tags = str_replace(' ', '', $tags);
				$tags = explode(',', $tags);
				foreach($tags as $value){
					if(!empty($value)){
						$values = array(
							'name' => $value,
							'blog_id' => $this->registry->get('request')->get('blog_id')
						);
						$r = $this->getModel()->tag->selectWithWhereCondition('id', $values, 'AND');
						if(empty($r)){
							$this->getModel()->tag->insert($values);
							$tag_id = $this->getModel()->tag->getLastInsertId();
						}
						else{
							$tag_id = $r[0]['id'];
						}
						$values = array(
							'message_id' => $message_id,
							'tag_id' => $tag_id
						);
						$this->getModel()->message_tag->insert($values);
					}
				}
				
				header('location:' . absolute_path . 'action/results/new_message');
			}
			else{
				$fields = array(
					'blog.id',
					'blog.name',
				);
				$join_condition = array(
					'user.id' => 'blog.owner_id',
				);
				$where_condition = array(
					'blog.owner_id' => $this->registry->get('session')->get('id')
				);
				
				$tmp = $this->getModel()->blog->selectWithJoinAndWhereCondition($fields, 'user', $join_condition, $where_condition);
				
				$data['blogs'] = $this->filter($tmp);
			
				$keys = array(
					'message_topic',
					'content',
					'tags'
				);
				foreach($keys as $value){
					$data[$value] = $this->filter($this->registry->get('request')->get($value));
				}	
			}
			$data['content'] = $this->view->render('new_message_form.tpl', $data);
			
			echo $this->view->render('output_index.tpl', $data);				
			
		}
		else{
			header('location:' . absolute_path);
		}
	}
	
	private function checkValidMessage(){
		
		$errors[] = 'Возникли следующие ошибки:';
		
		$blog_id = $this->registry->get('request')->get('blog_id');
		if($blog_id == 'unselected'){
			$errors[] = 'Выберите блог, на котором будет создано сообщение';
		}
		else{
			$fields = array(
				'id',
			);
			$where_condition = array(
				'id' => $this->registry->get('request')->get('blog_id'),
				'owner_id' => $this->registry->get('session')->get('id')
			);
			$tmp = $this->getModel()->blog->selectWithWhereCondition($fields, $where_condition, 'AND');
			if(empty($tmp)){
				$errors[] = 'Вы не можете создавать сообщения на этом блоге'; 
			}
		}
		$message_topic = $this->registry->get('request')->get('message_topic');
		if(empty($message_topic)){	
			$errors[] = 'Не заполнено поле Тема';	
		}
		
		$content = $this->registry->get('request')->get('content');
		if(empty($content)){	
			$errors[] = 'Не заполнено поле Содержание';	
		}
		
		return $errors;
	}
	
	function comment($message_id){
		$submit_button = @$this->registry->get('request')->get('submit_comment');
		if($submit_button == 'Готово'){
			$message_id = (int)$message_id;
			$tmp = $this->getModel()->message->selectWithWhereCondition('id', array('id' => $message_id));
			if(empty($tmp[0]['id'])){
				$data['message_1'] = 'Сообщения не существует';
				echo $this->view->render('output_index.tpl', $data);
			}
			else{
				$owner_id = $this->registry->get('session')->get('id');
				$values = array(
					'content' => $this->registry->get('request')->get('comment_content'),
					'message_id' => $message_id,
					'owner_id' => $owner_id
				);
				$this->getModel()->comment->insert($values);
				header('location:' . absolute_path . 'action/results/new_comment');
			}
		}
		else{
			header('location:' . absolute_path);
		}
	}
	
}
?>