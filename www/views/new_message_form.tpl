<?if(empty($blogs)):?>
	<div>У Вас нет Блогов</div>
<?else:?>
	<?if(!empty($errors)):?>
		<div class='errors'>
			<?foreach($errors as $value):?>
				<div><?=$value?></div>
			<?endforeach?>
		</div>
	<?endif?>
	<form method='post' enctype='multipart/form-data' action='<?=absolute_path . 'message/create'?>'>
		<div>Название Блога</div>
		<div>
			<select name='blog_id'>
				<option selected value='unselected'></option>
				<?foreach($blogs as $key=>$value):?>
					<option value='<?=$blogs[$key]['id']?>'><?=$blogs[$key]['name']?></option>
				<?endforeach?>
			</select>
		</div>
		<div>Тема</div>
		<div><input type='text' name='message_topic' value='<?=@$message_topic?>'/></div>
		<div>Содержание</div>
		<div><textarea name='text'><?=@$text?></textarea></div>
		<div>Тэги (через запятую)</div>
		<div><input type='text' name='tags' value='<?=@$tags?>'/></div>
		<div>Прикрепить фотографию</div>
		<div><input type='file' name='image' accept='image/*'/></div>
		<div><input type='submit' value='Готово' name='new_message'/></div>
	</form>
<?endif?>
