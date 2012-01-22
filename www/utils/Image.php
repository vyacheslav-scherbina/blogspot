<?php
class Image{

	function image_resize($image_path, $width){
		switch($_FILES['image']['type']){
			case 'image/gif': {
				$funct1 = 'imagecreatefromgif';
				$funct2 = 'imagegif';
				break;
			}
			case 'image/jpeg':
			case 'image/pjpeg': {
				$funct1 = 'imagecreatefromjpeg';
				$funct2 = 'imagejpeg';
				break;
			}
			case 'image/png': {
				$funct1 = 'imagecreatefrompng';
				$funct2 = 'imagepng';
				break;
			}
		}
		$image = $funct1($image_path);
		list($image_width, $image_height) = getimagesize($image_path);
		$height = $width/$image_width * $image_height;
		$resized_img = imagecreatetruecolor($width, $height);
		imagecopyresampled($resized_img, $image, 0, 0, 0, 0, $width, $height, $image_width, $image_height);
		ob_start();
		$funct2($resized_img);
		imagedestroy($resized_img);
		return ob_get_clean();		
	}
	

}
?>
