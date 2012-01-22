<?if(empty($blogs)):?>
	<div>Блоги отсутствуют</div>
<?else:?>
	<table border=1 cellpadding=0 cellspacing=0>
		<tr>
			<td>
				Пользователь
			</td>
			<td>
				Блог
			</td>
		</tr>
		<?foreach($blogs as $key=>$value):?>
			<tr>
				<td>
					<?=$blogs[$key]['first_name']?>
				</td>
				<td>
					<a href='<?=absolute_path . 'blog/messages/' . $blogs[$key]['id']?>'><?=$blogs[$key]['name']?></a>
				</td>
			</tr>
		<?endforeach?>
	</table>
<?endif?>
