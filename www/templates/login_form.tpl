<html>
	<head>
		<link rel='stylesheet' type='text/css' href='<?=absolute_path . 'style_login.css'?>' />
	</head>
	<body>
		<div id='message'>�� ������ �����, ��������� ������������ ��������� ������ � ������</div>
		<div id='login'>
			<form method='post' enctype='multipart/form-data' action='<?=absolute_path . 'auth/login'?>'>
				<div>�����</div>
				<div><input type='text' name='a_login' value='<?=@$data['a_login']?>'/></div>
				<div>������</div>
				<div><input type='password' name='password'/></div>
				<div><input type='submit' value='�����' name='submit'/></div>
			</form>
		</div>
	</body>
</html>