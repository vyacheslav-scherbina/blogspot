<div class='user_f_s_name'>
	<?=$user_first_name . ' ' . $user_last_name?>
</div>
<center><img src='<?=absolute_path . 'file/image/' . $user_avatar_id?>'/></center>
<ul>
	<li><a href='<?=absolute_path?>'>Главная</a></li>
	<li><a href='<?=absolute_path . 'chat/view'?>'>Чат</a></li>
	<li><a href='<?=absolute_path . 'blog/all/' . $user_id?>'>Мои Блоги</a></li>
	<li><a href='<?=absolute_path . 'message/create'?>'>Написать Сообщение</a></li>
	<li><a href='<?=absolute_path . 'blog/create'?>'>Создать Блог</a></li>
	<li><a href='<?=absolute_path . 'auth/logout'?>'>Выйти</a></li>
</ul>
