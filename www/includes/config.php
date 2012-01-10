<?php
include 'includes/autoload.php';

error_reporting (E_ALL);

if (version_compare(phpversion(), '5.1.0', '<') == true) { die ('PHP5.1 Only'); }

// Константы:


define ('site_path', realpath(dirname(__FILE__) . '/../') . '/');

$absolute_path = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
$absolute_path = pathinfo($absolute_path);
define ('absolute_path',$absolute_path['dirname'] . '/');

define ('DBMS', 'mysql');

define ('host', 'localhost');

define ('login', 'root');

define ('password', '');

define ('DB', 'my_db');


$access_array = array(
	array(
		'controller' => 'Controller_action',
		'method' => 'index',
		'role' => '*',
	),
	array(
		'controller' => 'Controller_action',
		'method' => 'register',
		'role' => Role::unknown,
	),
	array(
		'controller' => 'Controller_action',
		'method' => 'avatar',
		'role' => Role::regular,
	),
	array(
		'controller' => 'Controller_action',
		'method' => 'blog',
		'role' => '*',
	),
	array(
		'controller' => 'Controller_action',
		'method' => 'blogs',
		'role' => Role::regular,
	),
	array(
		'controller' => 'Controller_action',
		'method' => 'image',
		'role' => '*',
	),
	array(
		'controller' => 'Controller_action',
		'method' => 'new_blog',
		'role' => Role::regular,
	),
	array(
		'controller' => 'Controller_action',
		'method' => 'new_message',
		'role' => Role::regular,
	),
	array(
		'controller' => 'Controller_action',
		'method' => 'login',
		'role' => Role::unknown,
	),
	array(
		'controller' => 'Controller_action',
		'method' => 'results',
		'role' => '*',
	),
	array(
		'controller' => 'Controller_action',
		'method' => 'search',
		'role' => '*',
	),
	array(
		'controller' => 'Controller_action',
		'method' => 'message',
		'role' => '*',
	),
	array(
		'controller' => 'Controller_action',
		'method' => 'user',
		'role' => '*',
	),
	array(
		'controller' => 'Controller_auth',
		'method' => 'login',
		'role' => Role::unknown,
	),
	array(
		'controller' => 'Controller_auth',
		'method' => 'logout',
		'role' => Role::regular,
	),
	array(
		'controller' => 'Controller_auth',
		'method' => 'sign_up',
		'role' => Role::unknown,
	),
	array(
		'controller' => 'Controller_create',
		'method' => 'blog',
		'role' => Role::regular,
	),
	array(
		'controller' => 'Controller_create',
		'method' => 'message',
		'role' => Role::regular,
	),
	array(
		'controller' => 'Controller_create',
		'method' => 'comment',
		'role' => Role::regular,
	),
	array(
		'controller' => 'Controller_show',
		'method' => 'file',
		'role' => '*',
	)
	
	
);