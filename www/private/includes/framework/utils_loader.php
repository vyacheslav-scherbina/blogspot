<?php
function __autoload($class_name){
    $filename = $class_name . '.php';
    $file = site_path . 'utils/' . $filename;
	if(file_exists($file)){
		include $file;
	}
    
}
