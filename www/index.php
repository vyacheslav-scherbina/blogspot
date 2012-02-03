<?PHP
header ('Content-type: text/html; charset=utf-8');

define ('site_path', dirname(__FILE__) . '/');

include (site_path . 'includes/config.php');
include (site_path . 'includes/framework/FrontController.php');
include (site_path . 'includes/framework/Request.php');
include (site_path . 'includes/framework/Role.php');
include (site_path . 'includes/framework/TableFactory.php');
include (site_path . 'includes/framework/Table.php');
include (site_path . 'includes/framework/View.php');
include (site_path . 'includes/framework/Controller.php');
include (site_path . 'includes/framework/utils_loader.php');
include (site_path . 'includes/access_array.php');

$db = new PDO(DBMS . ':host=' . host . ';dbname=' . DB, login, password);
$db->exec('SET NAMES utf8');

$request = new Request($_REQUEST);
$sess_id = @$request->get('PHPSESSID');

if(!empty($sess_id)){
	@session_start();
}

$models_path = site_path . 'models/';
$model = new TableFactory($db, $models_path);

$controllers_path = site_path . 'controllers/';
$fc = new FrontController($model, $access_array, $controllers_path);

try{
	$views_path = site_path . 'views/';
	$fc->run($request, $views_path);
}
catch(Exception $e){
	echo $e->getMessage();
	//header('location:' . absolute_path);
}


?>
