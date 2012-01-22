<?php
class Controller_auth extends Controller{

	function login(){
		$url = absolute_path;
		$submit_button = @$this->request->get('submit');
		if($submit_button == 'Войти'){
			$login = $this->request->get('a_login');
			$password = $this->request->get('password');
			$hashed_password = md5($password);
			
			$r = $this->getModel()
				->user
				->select('id', 'first_name', 'last_name')
				->where('AND', "login=$login", "password=$hashed_password")
				->query();
			
			if(!empty($r)){
				@session_start();
				$_SESSION = $r[0];
				$url = @$this->request->get('url');
				if(empty($url)){
					$url = absolute_path;
				}
			}	
			else{
				$url = absolute_path . 'auth/login_form/' . $login;
			}
		}
		$this->redirect($url);
	}
	
	function login_form($a_login){
		$view = new View('login_form.tpl');
		$data['a_login'] = $view->filter($a_login);
		echo $view->render($data);
	}
	
	function logout(){
		@session_start();
		session_unset();
		session_destroy();
		setcookie('PHPSESSID', '', time()+3600, '/', $_SERVER['HTTP_HOST']);
		$this->redirect(absolute_path);
	}
	
	function sign_up(){
		$submit_button = @$this->request->get('reg');
		if($submit_button == 'Готово'){
			$data['errors'] = $this->checkValid();
			if(empty($data['errors'])){
				$image_path = $_FILES['image']['tmp_name'];
				if(file_exists($image_path)){
					$img = new Image();
					$image = $img->image_resize($image_path, 250);
					$this->getModel()->image->insert(array('content' => $image))->execute();
					$image_id = $this->getModel()->image->getLastInsertId();
				}
				else $image_id = 1;
			
				$values = array(
					'login' => $this->request->get('r_login'),
					'password' => md5($this->request->get('password')),
					'first_name' => $this->request->get('first_name'),
					'last_name' => $this->request->get('last_name'),
					'avatar_id' => $image_id
				);
				
				$this->getModel()->user->insert($values)->execute();
				$this->redirect(absolute_path . 'index/results/register');				
			}
			else{
				$keys = array('r_login', 'first_name', 'last_name');
				foreach($keys as $value){
					$data[$value] = $this->request->get($value);
				}
			}
		}
		$this->render('register_form.tpl', @$data);				
	}
	
	private function checkValid(){
		$errors = array();
		$r_login = $this->request->get('r_login');
		if(empty($r_login)){	
			$errors[] = 'Не заполнено поле Логин';	
		}
		else{
			if(!preg_match('/^[a-z0-9]{4,12}$/i', $r_login)){
				$errors[] = 'Не корректная информация в поле Логин';	
			}
			else{
				$rec = $this->getModel()->user->select('id')->where('',"login=$r_login")->query();
				if(!empty($rec)){
					$errors[] = 'Пользователь с таким Логином уже существует';	
				}
			}
		}
		$password = $this->request->get('password');
		$password_confirm = $this->request->get('password_confirm');
		if(empty($password)){
			$errors[] = 'Не заполнено поле Пароль';	
		}
		else{
			if(!preg_match('/^[a-z0-9]{6,20}$/i',$password)){
				$errors[] = 'Не корректная информация в поле Пароль';	
			}
			else{
				if(empty($password_confirm)){
					$errors[] = 'Не заполнено поле Подтверждение пароля';	
				}
				else{
					if($password != $password_confirm){
						$errors[] = 'Пароли не совпадают';	
					}
				}
			}
		}
		$first_name = $this->request->get('first_name');
		if(empty($first_name)){
			$errors[] = 'Не заполнено поле Имя';	
		}
		$last_name = $this->request->get('last_name');
		if(empty($last_name)){
			$errors[] = 'Не заполнено поле Фамилия';	
		}
		if(!empty($_FILES['image']['name'])){
			if($_FILES['image']['error'] != 0 || substr($_FILES['image']['type'],0,5) !== 'image'){
				$errors[] = 'Что-то не так с изображением';	
			}
		}
		return $errors;
	}

}
?>
