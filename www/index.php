<?PHP
include 'includes/config.php';

$registry = Registry::getInstance();

$registry->set('access_array', $access_array);

$request = new Request($_REQUEST);
$registry->set('request', $request);

$db = new PDO(DBMS . ':host=' . host . ';dbname=' . DB, login, password);
$registry->set('db', $db);

$controller_path = site_path . 'classes/controllers/';
$model_path = site_path . 'classes/model/';
$view_path = site_path . 'classes/View/';
$templates_path = site_path . 'templates/';

$registry->set('controller_path', $controller_path);
$registry->set('model_path', $model_path);
$registry->set('view_path', $view_path);
$registry->set('templates_path', $templates_path);

$sess_id = @$registry->get('request')->get('PHPSESSID');

if(!empty($sess_id)){
	session_start();
}

$session = new Session(@$_SESSION);
$registry->set('session', $session);

$fc = new FrontController();

try{
	$fc->run();
}
catch(Exception $e){
	//echo $e->getMessage();//Not Found
	header('location:' . absolute_path);
}

?>