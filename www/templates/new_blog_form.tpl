<form method='post' action='<?=absolute_path . 'create/blog'?>'>
	<div>Название</div>
	<div><input type='text' name='blog_name' value='<?=@$data['blog_name']?>'/></div>
	<div><input type='submit' value='Готово' name='new_blog'/></div>
</form>