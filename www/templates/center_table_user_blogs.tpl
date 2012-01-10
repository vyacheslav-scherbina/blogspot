<div>Ваши Блоги</div>
<ul>
	<?foreach($data as $key=>$value):?>
		<li><a href='<?=absolute_path . 'action/blog/' . $data[$key]['id']?>'><?=$data[$key]['name']?></a></li>
	<?endforeach;?>
</ul>