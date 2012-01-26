<?if(empty($messages)):?>
	<div>Сообщения отсутствуют</div>
<?else:?>	
	<?foreach($messages as $key=>$value):?>
		<div class='message'>
			<div class='message_topic'>
				<a href='<?=absolute_path . 'message/view/' . $messages[$key]['id']?>'><?=$messages[$key]['topic']?></a>
			</div>
			<div class='message_content'>
				<?=$messages[$key]['text']?>
			</div>
		</div>
	<?endforeach?>
<?endif?>
