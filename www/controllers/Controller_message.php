<?php
class Controller_message extends Controller{
	
	function view($message_id){
		$submit_button = @$this->request->get('submit_comment');
		if($submit_button == 'Готово' && FrontController::getCurrentUserRole() == Role::regular){
			$comment_text = $this->request->get('comment_text');
			$tmp = $this->getModel()->message->select('id')->where('', "id=$message_id")->query();
			if(!empty($tmp[0]['id']) && !empty($comment_text)){
				$values = array(
					'text' => $comment_text,
					'message_id' => $message_id,
					'owner_id' => $_SESSION['id']
				);
				$this->getModel()->comment->insert($values)->execute();
				$url = absolute_path . 'message/view/' . $message_id;
				$this->redirect($url);
			}
		}
		$data['message'] = $this->getModel()
			->message
			->select('message.id', 'message.topic', 'message.text', 'message.image_id')
			->leftJoin('comment', 'comment.message_id=message.id')
			->where('', "message.id=$message_id")
			->query();
			
		$data['comments'] = $this->getModel()
			->comment
			->select('comment.text, user.first_name, user.last_name')
			->innerJoin('user', 'user.id=comment.owner_id')
			->where('', "comment.message_id=$message_id")
			->query();
		
		if(FrontController::getCurrentUserRole() == Role::regular) $data['comments_enable'] = true;
		$this->render('message.tpl', $data);
	}

	function create(){
		$submit_button = @$this->request->get('new_message');
		if($submit_button == 'Готово'){
			$data['errors'] = $this->checkValidMessage();							
			if(empty($data['errors'])){
				$image_path = $_FILES['image']['tmp_name'];
				if(file_exists($image_path)){
					$img = new Image();
					$image = $img->image_resize($image_path, 250);
					$this->getModel()->image->insert(array('content' => $image))->execute();
					$image_id = $this->getModel()->image->getLastInsertId();
				}
				else $image_id = '';			
				$values = array(
					'topic' => $this->request->get('message_topic'),
					'text' => $this->request->get('text'),
					'blog_id' => $this->request->get('blog_id'),
					'image_id' => $image_id
				);
				$this->getModel()->message->insert($values)->execute();
				$this->tags();
				$url = absolute_path . 'index/results/new_message';
				$this->redirect($url);
			}
			else{
				$data['message_topic'] = $this->request->get('message_topic');
				$data['text'] = $this->request->get('text');
				$data['tags'] = $this->request->get('tags');
			}
		}
		$owner_id = $_SESSION['id'];
		$data['blogs'] = $this->getModel()
			->blog
			->select('blog.id', 'blog.name')
			->innerJoin('user', 'user.id=blog.owner_id')
			->where('', "blog.owner_id=$owner_id")
			->query();
		
		$this->render('new_message_form.tpl', @$data);
	}
	
	private function checkValidMessage(){
		$errors = array();
		$blog_id = $this->request->get('blog_id');
		if($blog_id == 'unselected'){
			$errors[] = 'Выберите блог, на котором будет создано сообщение';
		}
		else{
			$blog_id = $this->request->get('blog_id');
			$owner_id = $_SESSION['id'];
			$tmp = $this->getModel()
				->blog
				->select('id')
				->where('AND', "id=$blog_id", "owner_id=$owner_id")
				->query();
			if(empty($tmp)){
				$errors[] = 'Вы не можете создавать сообщения на этом блоге'; 
			}
		}
		$message_topic = $this->request->get('message_topic');
		if(empty($message_topic)){	
			$errors[] = 'Не заполнено поле Тема';	
		}
		$text = $this->request->get('text');
		if(empty($text)){	
			$errors[] = 'Не заполнено поле Содержание';	
		}
		return $errors;
	}
		
	private function tags(){
		$message_id = $this->getModel()->message->getLastInsertId();
		$tags = str_replace(' ', '', $this->request->get('tags'));
		$tags = explode(',', $tags);
		foreach($tags as $value){
			if(!empty($value)){
				$r = $this->getModel()->tag->select('id')->where('', "name=$value")->query();
				if(empty($r)){
					$this->getModel()->tag->insert(array('name' => $value))->execute();
					$tag_id = $this->getModel()->tag->getLastInsertId();
				}
				else $tag_id = $r[0]['id'];
				$values = array(
					'message_id' => $message_id,
					'tag_id' => $tag_id
				);
				$this->getModel()->message_tag->insert($values)->execute();
			}
		}
	}
	
}
?>
