<html>
	<head>
	<link rel='stylesheet' type='text/css' href='<?=absolute_path . 'style_index.css'?>' />
	</head>
	<body>
		<div id='head'>
			Blog Spot
		</div>
		<div id='left'>
			<?if(FrontController::getCurrentUserRole() == Role::regular):?>
				<div>
					<?=Registry::getInstance()->get('session')->getFirstName() . ' ' . Registry::getInstance()->get('session')->getLastName()?>
				</div>
				<img src='<?=absolute_path . 'action/avatar'?>'/>
				<ul>
					<li><a href='<?=absolute_path?>'>Главная</a></li>
					<li><a href='<?=absolute_path . 'action/blogs'?>'>Мои Блоги</a></li>
					<li><a href='<?=absolute_path . 'action/new_message'?>'>Написать Сообщение</a></li>
					<li><a href='<?=absolute_path . 'action/new_blog'?>'>Создать Блог</a></li>
					<li><a href='<?=absolute_path . 'auth/logout'?>'>Выйти</a></li>
				</ul>
			<?else:?>
				<div id='left_login_form'>
					<form method='POST' action='<?=absolute_path . 'auth/login'?>'>
						<input name='url' type='hidden' value='<?='http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']?>'/>
						<div>Логин</div>
						<div><input type='text' name='a_login' value='<?=@$data['a_login']?>'/></div>
						<div>Пароль</div>
						<div><input type='password' name='password'/></div>
						<input type='submit' name='submit' value='Войти'/>
					</form>
				</div>
				<ul>
					<li><a href='<?=absolute_path?>'>Главная</a></li>
					<li><a href='<?=absolute_path . 'action/register'?>'>Регистрация</a></li>
				</ul>
			<?endif?>
		</div>
		<div id='center'>
			<?if(!empty($data['message_1'])):?>
				<?if(is_array($data['message_1'])):?>
					<?foreach($data['message_1'] as $value):?>
						<div>
							<?=$value?>
						</div>
					<?endforeach?>
				<?else:?>
					<?=$data['message_1']?>
				<?endif?>
			<?else:?>
				<?if(!empty($data['message_2'])):?>
					<?if(is_array($data['message_2'])):?>
						<?foreach($data['message_2'] as $value):?>
							<div>
								<?=$value?>
							</div>
						<?endforeach?>
					<?else:?>
						<?=$data['message_2']?>
					<?endif?>
				<?endif?>
				<?=$data['content']?>
			<?endif?>
		</div>
		<?if(@$data['right_enable']):?>
			<div id='right'>
				<?if(!empty($data['right']['message'])):?>
					<?=$data['right']['message']?>
				<?else:?>
					<div>Тэги</div>
					<ul>
						<?foreach($data['right'] as $key=>$value):?>
							<li>
								<a href='<?=absolute_path . 'action/search/' . $data['right'][$key]['id']?>'><?=$data['right'][$key]['name']?></a>
							</li>
						<?endforeach?>
					</ul>
				<?endif?>
			</div>
		<?endif?>
	</body>
</html>