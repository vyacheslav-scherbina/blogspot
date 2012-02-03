<div id='left_unknown'>
	<form method='POST' action='<?=absolute_path . 'auth/login'?>'>
		<input name='url' type='hidden' value='<?='http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']?>'/>
		<div>Логин</div>
		<div><input type='text' name='a_login'/></div>
		<div>Пароль</div>
		<div><input type='password' name='password'/></div>
		<input type='submit' name='submit' value='Войти'/>
	</form>
</div>
<ul>
	<li><a href='<?=absolute_path?>'>Главная</a></li>
	<li><a href='<?=absolute_path . 'auth/sign_up'?>'>Регистрация</a></li>
</ul>
