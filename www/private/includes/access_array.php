<?php
$access_array = array(
	array(
		'controller' => 'Controller_index',
		'method' => 'index',
		'role' => '*',
	),
	array(
		'controller' => 'Controller_index',
		'method' => 'results',
		'role' => '*',
	),
	
	array(
		'controller' => 'Controller_auth',
		'method' => 'login',
		'role' => Role::unknown,
	),
	array(
		'controller' => 'Controller_auth',
		'method' => 'login_form',
		'role' => Role::unknown,
	),
	array(
		'controller' => 'Controller_auth',
		'method' => 'sign_up',
		'role' => Role::unknown,
	),
	array(
		'controller' => 'Controller_auth',
		'method' => 'logout',
		'role' => Role::regular,
	),
	
	array(
		'controller' => 'Controller_blog',
		'method' => 'all',
		'role' => '*',
	),
	array(
		'controller' => 'Controller_blog',
		'method' => 'message',
		'role' => '*',
	),
	array(
		'controller' => 'Controller_blog',
		'method' => 'messages',
		'role' => '*',
	),
	array(
		'controller' => 'Controller_blog',
		'method' => 'create',
		'role' => Role::regular,
	),
	
	array(
		'controller' => 'Controller_file',
		'method' => 'image',
		'role' => '*',
	),
	
	array(
		'controller' => 'Controller_message',
		'method' => 'view',
		'role' => '*',
	),
	array(
		'controller' => 'Controller_message',
		'method' => 'create',
		'role' => Role::regular,
	),
	
	array(
		'controller' => 'Controller_tag',
		'method' => 'search',
		'role' => '*',
	),
	
	array(
		'controller' => 'Controller_chat',
		'method' => 'view',
		'role' => Role::regular,
	),
	array(
		'controller' => 'Controller_chat',
		'method' => 'new_message',
		'role' => Role::regular,
	),
	array(
		'controller' => 'Controller_chat',
		'method' => 'get_json',
		'role' => Role::regular,
	),
	
        array(
		'controller' => 'Controller_comment',
		'method' => 'create',
		'role' => Role::regular,
	),
);
?>
