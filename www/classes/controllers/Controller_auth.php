<?php
class Controller_auth extends Controller{

	function login(){
		$submit_button = @$this->registry->get('request')->get('submit');
		if($submit_button == '�����'){
			$login = $this->registry->get('request')->get('a_login');
			$password = $this->registry->get('request')->get('password');
			$hashed_password = md5($password);
			
			$fields = array(
				'id',
				'first_name',
				'last_name'
			);
			
			$condition = array(
				'login' => $login,
				'password' => $hashed_password
			);
			
			$r = $this->getModel()->user->selectWithWhereCondition($fields, $condition, 'AND');
			
			if(!empty($r)){
				@session_start();
				$_SESSION = $r[0];
				$url = @$this->registry->get('request')->get('url');
				if(empty($url)){
					$url = absolute_path;
				}
				header('location:' . $url);
			}
			else{
				$path = absolute_path . 'action/login/' . $login;
				header('location:' . $path);
			}
		}
		else{
			header('location:' . absolute_path);
		}
	}
	
	function logout(){
		@session_start();
		session_unset();
		session_destroy();
		setcookie('PHPSESSID', '', time()+3600, '/', $_SERVER['HTTP_HOST']);
		header('location:' . absolute_path);
	}
	
	function sign_up(){
		$submit_button = @$this->registry->get('request')->get('reg');
		if($submit_button == '������'){
			$data['message_2'] = $this->checkValid();
			if(empty($data['message_2'][1])){
				$values = array(
					'login' => $this->r_login,
					'password' => md5($this->password),
					'male' => $this->male,
					'first_name' => $this->first_name,
					'last_name' => $this->last_name,
					'description' => $this->description
				);
				$image_path = $_FILES['image']['tmp_name'];
				if(file_exists($image_path)){
					$img = new Image();
					$values['image'] = $img->image_resize($image_path, 250);
				}
				$this->getModel()->user->insert($values);
				
				header('location:' . absolute_path . 'action/results/register');				
			}
			else{
				$keys = array(
					'r_login',
					'first_name',
					'last_name',
					'description'
				);
				foreach($keys as $value){
					$data[$value] = $this->filter($this->$value);
				}
			}
			
			$data['content'] = $this->view->render('register_form.tpl', $data);
			
			echo $this->view->render('output_index.tpl', $data);				
			
		}
		else{
			header('location:' . absolute_path);
		}
	}
	
	function __isset($name){
		$tmp = $this->registry->get('request')->get($name);
		return $tmp;
	}
	
	function __get($name){
		$tmp = $this->registry->get('request')->get($name);
		return $tmp;
	}
	
	private function checkValid(){
		$errors[] = '�������� ��������� ������:';
		if(empty($this->r_login)){	
			$errors[] = '�� ��������� ���� �����';	
		}
		else{
			if(!preg_match('/^[a-z0-9]{4,12}$/i', $this->r_login)){
				$errors[] = '�� ���������� ���������� � ���� �����';	
			}
			else{
				$condition = array(
					'login' => $this->r_login
				);
				$rec = $this->getModel()->user->selectWithWhereCondition('id', $condition);
				if(!empty($rec)){
					$errors[] = '������������ � ����� ������� ��� ����������';	
				}
			}
		}
		if(empty($this->password)){
			$errors[] = '�� ��������� ���� ������';	
		}
		else{
			if(!preg_match('/^[a-z0-9]{6,20}$/i',$this->password)){
				$errors[] = '�� ���������� ���������� � ���� ������';	
			}
			else{
				if(empty($this->password_confirm)){
					$errors[] = '�� ��������� ���� ������������� ������';	
				}
				else{
					if($this->password != $this->password_confirm){
						$errors[] = '������ �� ���������';	
					}
				}
			}
		}
		if($this->male == 'unselected'){
			$errors[] = '�� �� ������� ���';	
		}
		else{
			if($this->male != '�������' && $this->male != '�������'){
				$errors[] = '�� ���������� ���������� � ���� ���';	
			}	
		}
		if(empty($this->first_name)){
			$errors[] = '�� ��������� ���� ���';	
		}
		else{
			if(!preg_match('/^[�-�a-z]{4,12}$/i',$this->first_name)){
				$errors[] = '�� ���������� ���������� � ���� ���';	
			}
		}
		if(empty($this->last_name)){
			$errors[] = '�� ��������� ���� �������';	
		}
		else{
			if(!preg_match('/^[�-�a-z]{4,12}$/i',$this->last_name)){
				$errors[] = '�� ���������� ���������� � ���� �������';	
			}
		}
		if(!empty($_FILES['image']['name'])){
			if($_FILES['image']['error'] != 0 || substr($_FILES['image']['type'],0,5) !== 'image'){
				$errors[] = '���-�� �� ��� � ������������';	
			}
		}
		return $errors;
	}

}
?>