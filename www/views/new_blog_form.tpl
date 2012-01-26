<?if(!empty($errors)):?>
	<div class='errors'>
		<?foreach($errors as $value):?>
			<div><?=$value?></div>
		<?endforeach?>
	</div>
<?endif?>
<form method='post' action='<?=absolute_path . 'blog/create'?>'>
	<div>Название</div>
	<div><input type='text' name='blog_name' value='<?=@$blog_name?>'/></div>
	<div><input type='submit' value='Готово' name='new_blog'/></div>
</form>
