<?php
class Controller_file extends Controller{

	function image($image_id){
		$image = $this->getModel()->image->select('content')->where('', "id=$image_id")->query();

		header('Content-type: image');
		echo @$image[0]['content'];
	}
	
	
	
}
?>
