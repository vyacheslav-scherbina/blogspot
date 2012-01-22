<html>
	<head>
		<link rel='stylesheet' type='text/css' href='<?=absolute_path . 'style_login.css'?>' />
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	</head>
	<body>
		<div id='message'>Не удаётся войти, проверьте правильность написания логина и пароля</div>
		<div id='login'>
			<form method='post' enctype='multipart/form-data' action='<?=absolute_path . 'auth/login'?>'>
				<div>Логин</div>
				<div><input type='text' name='a_login' value='<?=@$a_login?>'/></div>
				<div>Пароль</div>
				<div><input type='password' name='password'/></div>
				<div><input type='submit' value='Войти' name='submit'/></div>
			</form>
		</div>
	</body>
</html>
