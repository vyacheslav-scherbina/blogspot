<?if(!empty($errors)):?>
	<div class='errors'>
		<?foreach($errors as $value):?>
			<div><?=$value?></div>
		<?endforeach?>
	</div>
<?endif?>
<form method='post' enctype='multipart/form-data' action='<?=absolute_path . 'auth/sign_up'?>'>
	<div>Логин</div>
	<div><input type='text' name='r_login' value='<?=@$r_login?>'/></div>
	<div>Пароль</div>
	<div><input type='password' name='password'/></div>
	<div>Подтверждение</div>
	<div><input type='password' name='password_confirm'/></div>
	<div>Имя</div>
	<div><input type='text' name='first_name' value='<?=@$first_name?>'/></div>
	<div>Фамилия</div>
	<div><input type='text' name='last_name' value='<?=@$last_name?>'/></div>
	<div>Аватар</div>
	<div><input type='file' name='image' accept='image/*'/></div>
	<div><input type='submit' value='Готово' name='reg'/></div>
</form>
