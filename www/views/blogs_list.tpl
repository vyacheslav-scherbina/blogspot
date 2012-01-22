<?if(empty($blogs)):?>
	Блоги отсутствуют
<?else:?>
	<div>Список блогов</div>
	<ul>
		<?foreach($blogs as $key=>$value):?>
			<li><a href='<?=absolute_path . 'blog/messages/' . $blogs[$key]['id']?>'><?=$blogs[$key]['name']?></a></li>
		<?endforeach;?>
	</ul>
<?endif?>
