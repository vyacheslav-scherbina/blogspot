<?if(empty($tags)):?>
	<div class='align_center'>Тэги отсутствуют</div>
<?else:?>
	<div class='align_center'>Облако Тэгов</div>
	<ul class='tags'>
		<?foreach($tags as $key=>$value):?>
			<li>
				<a href='<?=absolute_path . 'tag/search/' . $tags[$key]['id']?>'><?=$tags[$key]['name']?></a>
			</li>
		<?endforeach?>
	</ul>
<?endif?>
