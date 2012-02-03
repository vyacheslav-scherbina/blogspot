<?if(empty($message)):?>
	Сообщение не найдено
<?else:?>
	<div class='message'>
		<div class='message_topic'>
			<h3><?=$message[0]['topic']?></h3>
		</div>
		<div class='message_content'>
			<?=$message[0]['text']?>
		</div>
		<?if(!empty($message[0]['image_id'])):?>
			<img src='<?=absolute_path . 'file/image/' . $message[0]['image_id']?>'/>
		<?endif?>
	</div>
	<?if(!empty($comments)):?>
		<h3>
			Комментарии:
		</h3>
		<?foreach($comments as $key=>$value):?>
			<div class='comment'>
				<h4>
					<?=$comments[$key]['first_name'] . ' ' . $comments[$key]['last_name'] . ':'?>
				</h4>
				<div class='comment_text'>
					<?=$comments[$key]['text']?>
				</div>
			</div>
		<?endforeach?>
	<?else:?>
		<h4>
			Комментарии отсутствуют
		</h4>
	<?endif?>
	<?if($current_user_role == Role::regular):?>
		<form method='post' action='<?=absolute_path . 'comment/create/' . $message[0]['id']?>'>
			<div>Отправить комментарий</div>
			<div>
				<textarea name='comment_text'></textarea>
			</div>
			<input type='submit' name='submit_comment' value='Готово'/>
		</form>
	<?endif?>
<?endif?>
