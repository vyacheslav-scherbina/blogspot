<form method='post' enctype='multipart/form-data' action='<?=absolute_path . 'create/message/'?>'>
	<div>�������� �����</div>
	<div>
		<select name='blog_id'>
			<option selected value='unselected'></option>
			<?foreach($data['blogs'] as $key=>$value):?>
				<option value='<?=$data['blogs'][$key]['id']?>'><?=$data['blogs'][$key]['name']?></option>
			<?endforeach?>
		</select>
	</div>
	<div>����</div>
	<div><input type='text' name='message_topic' value='<?=@$data['message_topic']?>'/></div>
	<div>����������</div>
	<div><textarea name='content'><?=@$data['content']?></textarea></div>
	<div>���� (����� �������)</div>
	<div><input type='text' name='tags' value='<?=@$data['tags']?>'/></div>
	<div>���������� ����������</div>
	<div><input type='file' name='image' accept='image/*'/></div>
	<div><input type='submit' value='������' name='new_message'/></div>
</form>