<table border=1>
	<tr>
		<td>
			Пользователь
		</td>
		<td>
			Блог
		</td>
	</tr>
	<?foreach($data as $key=>$value):?>
		<tr>
			<td>
				<a href='<?=absolute_path . 'action/user/' . $data[$key]['owner_id']?>'><?=$data[$key]['first_name']?></a>
			</td>
			<td>
				<a href='<?=absolute_path . 'action/blog/' . $data[$key]['id']?>'><?=$data[$key]['name']?></a>
			</td>
		</tr>
	<?endforeach?>
</table>