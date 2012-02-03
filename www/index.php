<?PHP
header ('Content-type: text/html; charset=utf-8');

define ('site_path', dirname(__FILE__) . '/');

include (site_path . 'private/includes/config.php');
include (site_path . 'private/includes/framework/FrontController.php');
include (site_path . 'private/includes/framework/Request.php');
include (site_path . 'private/includes/framework/Role.php');
include (site_path . 'private/includes/framework/TableFactory.php');
include (site_path . 'private/includes/framework/Table.php');
include (site_path . 'private/includes/framework/View.php');
include (site_path . 'private/includes/framework/Controller.php');
include (site_path . 'private/includes/framework/utils_loader.php');
include (site_path . 'private/includes/access_array.php');

$db = new PDO(DBMS . ':host=' . host . ';dbname=' . DB, login, password);
$db->exec('SET NAMES utf8');

$request = new Request($_REQUEST);
$sess_id = @$request->get('PHPSESSID');

if(!empty($sess_id)){
	@session_start();
}

$models_path = site_path . 'private/models/';
$model = new TableFactory($db, $models_path);

$controllers_path = site_path . 'private/controllers/';
$fc = new FrontController($model, $access_array, $controllers_path);

try{
	$fc->run($request);
}
catch(Exception $e){
	echo $e->getMessage();
	//header('location:' . absolute_path);
}


?>
