<div>
	���
</div>
<div>
	<?=$data['user'][0]['first_name']?>
</div>
<div>
	�������
</div>
<div>
	<?=$data['user'][0]['last_name']?>
</div>
<div>
	���
</div>
<div>
	<?=$data['user'][0]['male']?>
</div>
<div>
	� ����
</div>
<div>
	<?=$data['user'][0]['description']?>
</div>
<?if(@$data['blogs_enable']):?>
	<div>
		����� ������������:
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