<?php
class Controller_action extends Controller{

	function index(){
		$fields = array(
			'blog.id',
			'blog.name',
			'blog.owner_id',
			'user.first_name',
			'user.last_name'
		);
		$condition = array(
			'blog.owner_id' => 'user.id',		
		);
		
		$tmp = $this->getModel()->blog->selectWithJoinCondition($fields, 'user', $condition);
		if(empty($tmp)){
			$data['message_1'] = 'Блоги отсутствуют'; 
		}
		else{
			$data = $this->filter($tmp);
		}
		
		$data['content'] = $this->view->render('center_table_all_blogs.tpl', $data);
		
		echo $this->view->render('output_index.tpl', $data);
	}
	
	function register(){
		$data['content'] = $this->view->render('register_form.tpl');
		echo $this->view->render('output_index.tpl', $data);				
	}
	
	function login($login){
		$data['a_login'] = $this->filter($login);
		echo $this->view->render('login_form.tpl', $data);
	}
	
	function avatar(){
		$id = $this->registry->get('session')->get('id');
		$avatar = $this->getModel()->user->selectWithWhereCondition('image', array('id' => $id));
		if(empty($avatar[0]['image'])){
			$avatar = $this->getModel()->no_avatar->selectWithWhereCondition('image', array('id' => '1'));
		}
		header('Content-type: image ');
		echo $avatar[0]['image'];
	}
	
	function image($message_id){
		$image = $this->getModel()->message->selectWithWhereCondition('image', array('id' => $message_id));
		header('Content-type: image ');
		echo @$image[0]['image'];
	}
	
	function blogs(){
		$fields = array(
			'blog.id',
			'blog.name'
		);
		$join_condition = array(
			'blog.owner_id' => 'user.id',
		);
		$where_condition = array(
			'blog.owner_id' => $this->registry->get('session')->get('id')
		);
		
		$tmp = $this->getModel()->blog->selectWithJoinAndWhereCondition($fields, 'user', $join_condition, $where_condition);
		
		if(empty($tmp)){
			$data['message_1'] = 'У Вас нет блогов';
		}
		else{
			$data = $this->filter($tmp);
		}
		
		$data['content'] = $this->view->render('center_table_user_blogs.tpl', $data);
		
		echo $this->view->render('output_index.tpl', $data);
	}
	
	function blog($blog_id){
		$fields = array(
			'message.id',
			'message.topic',
			'message.content',
			'message.image',
			'blog.name'
		);
		$join_condition = array(
			'blog.id' => 'message.blog_id',
		);
		$where_condition = array(
			'message.blog_id' => $blog_id
		);
		$tmp = $this->getModel()->message->selectWithJoinAndWhereCondition($fields, 'blog', $join_condition, $where_condition);
		
		if(empty($tmp)){
			$data['message_1'] =  'Блога не существует или на нём нет сообщений ';
		}
		else{
			$data = $this->filter($tmp);
			foreach($data as $key=>$value){
				if(!empty($data[$key]['image'])){
					$data[$key]['image_enable'] = true;
				}
				else{
					$data[$key]['image_enable'] = false;
				}
			}
			$data['right_enable'] = true;
		}
		
		$data['content'] = $this->view->render('messages_on_blog.tpl', $data);
		
		$data['right'] = $this->tags($blog_id);
		
		echo $this->view->render('output_index.tpl', $data);
	}
	
	function search($tag_id){
		$tag_id = (int)$tag_id;
		$fields = array(
			'message.id',
			'message.topic',
			'message.content',
			'message.image',
			'message.blog_id'
		);
		$join_condition = array(
			'message.id' => 'message_tag.message_id',
		);
		$where_condition = array(
			'message_tag.tag_id' => $tag_id
		);
		
		$tmp = $this->getModel()->message->selectWithJoinAndWhereCondition($fields, 'message_tag', $join_condition, $where_condition);
		
		if(empty($tmp)){
			$data['message_1'] = 'Ничего не найдено'; 
			$tmp = $this->getModel()->tag->selectWithWhereCondition('blog_id', array('id' => $tag_id));
			$data[0]['blog_id'] = @$this->filter($tmp[0]['blog_id']);
		}
		else{
			$data = $this->filter($tmp);
			foreach($data as $key=>$value){
				if(!empty($data[$key]['image'])){
					$data[$key]['image_enable'] = true;
				}
				else{
					$data[$key]['image_enable'] = false;
				}
			}
			//для того что бы узнать название блога =>
			$tmp = $this->getModel()->blog->selectWithWhereCondition('name', array('id' => $data[0]['blog_id']));
			$data[0]['name'] = $this->filter($tmp[0]['name']);
		}
		
		$data['content'] = $this->view->render('messages_on_blog.tpl', $data);
		
		$data['right_enable'] = true;
		$data['right'] = $this->tags($data[0]['blog_id']);
		
		echo $this->view->render('output_index.tpl', $data);
	}
	
	function message($message_id){
		$message_id = (int)$message_id;
		
		$fields = array(
			'id',
			'topic',
			'content',
			'image',
			'blog_id'
		);
		$tmp = $this->getModel()->message->selectWithWhereCondition($fields, array('id' => $message_id));
		
		if(empty($tmp)){
			$data['message_1'] = 'Сообщение не найдено'; 
		}
		else{
			$data['message'] = $this->filter($tmp);
			if(!empty($data['message'][0]['image'])){
				
				$data['message'][0]['image_enable'] = true;
			}
			else{
				$data['message'][0]['image_enable'] = false;
			}
		}
		$fields = array(
			'comment.id',
			'comment.content',
			'user.first_name',
			'user.last_name'
		);
		$join_condition = array(
			'user.id' => 'comment.owner_id',
		);
		$where_condition = array(
			'comment.message_id' => $message_id
		);
		$tmp = $this->getModel()->comment->selectWithJoinAndWhereCondition($fields, 'user', $join_condition, $where_condition);
		
		if(empty($tmp)){
			$data['comments_enable'] = false;
		}
		else{
			$data['comments_enable'] = true;
			$data['comments'] = $this->filter($tmp);
		}
		
		$data['content'] = $this->view->render('message.tpl', $data);
		
		$data['right_enable'] = true;
		$data['right'] = $this->tags($data['message'][0]['blog_id']);
		
		echo $this->view->render('output_index.tpl', $data);
		
	}
	
	private function tags($blog_id){
		$fields = array(
			'tag.id',
			'tag.name',
		);
		$join_condition = array(
			'blog.id' => 'tag.blog_id',
		);
		$where_condition = array(
			'tag.blog_id' => $blog_id
		);
		
		$tmp = $this->getModel()->tag->selectWithJoinAndWhereCondition($fields, 'blog', $join_condition, $where_condition);
		if(empty($tmp)){
			$data['message'] = 'Тэги отсутствуют'; 
		}
		else{
			$data = $this->filter($tmp);
		}
		return $data;
	}
	
	function new_message(){
	
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
		
		if(empty($tmp)){
			$data['message_1'] = 'У Вас нет блогов'; 
		}
		else{
			$data['blogs'] = $this->filter($tmp);
		}
		
		$data['content'] = $this->view->render('new_message_form.tpl', $data);
		
		echo $this->view->render('output_index.tpl', $data);
	}
	
	function new_blog(){
		$data['content'] = $this->view->render('new_blog_form.tpl');
		echo $this->view->render('output_index.tpl', $data);
	}

	function user($user_id){
		$user_id = (int)$user_id;
		$fields = array(
			'id',
			'male',
			'first_name',
			'last_name',
			'description',
			'image'
		);
		
		$tmp = $this->getModel()->user->selectWithWhereCondition($fields, array('id' => $user_id));
		if(empty($tmp)){
			$data['message_1'] = 'Запрошенный пользователь не найден';
		}
		else{
			$data['user'] = $this->filter($tmp);
			$fields = array(
				'id',
				'name'
			);
			$tmp = $this->getModel()->blog->selectWithWhereCondition($fields, array('owner_id' => $user_id));
			if(empty($tmp)){
				$data['blogs_enable'] = false;
			}
			else{
				$data['blogs_enable'] = true;
				$data['blogs'] = $this->filter($tmp);
			}
		}
		
		$data['content'] = $this->view->render('user.tpl', $data);
		
		echo $this->view->render('output_index.tpl', $data);
	}
		
	function results($input){
		$register = 'Регистрация прошла успешно !';
		$new_blog = 'Блог создан успешно !';
		$new_message = 'Сообщение создано успешно !';
		$new_comment = 'Комментарий создан успешно !';
		
		$data['message_1'][] = @$$input;
		//$data['message_1'][] = 'Вы будете переадресованы через несколько секунд';
		
		//header('refresh:3;url=' . absolute_path );
		
		echo $this->view->render('output_index.tpl', $data);
	}

	
	
}
?>