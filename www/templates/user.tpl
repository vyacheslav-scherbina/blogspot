<div>
	Имя
</div>
<div>
	<?=$data['user'][0]['first_name']?>
</div>
<div>
	Фамилия
</div>
<div>
	<?=$data['user'][0]['last_name']?>
</div>
<div>
	Пол
</div>
<div>
	<?=$data['user'][0]['male']?>
</div>
<div>
	О себе
</div>
<div>
	<?=$data['user'][0]['description']?>
</div>
<?if(@$data['blogs_enable']):?>
	<div>
		Блоги пользователя:
	</div>
	<ul>
		<?foreach($data['blogs'] as $key=>$value):?>
			<li>
				<a href='<?=absolute_path . '/action/blog/' . $data['blogs'][$key]['id']?>'><?=$data['blogs'][$key]['name']?></a>
			</li>
		<?endforeach?>
	</ul>
<?else:?>
<?endif?>