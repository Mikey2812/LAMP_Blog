<?php
	date_default_timezone_set('Asia/Ho_Chi_Minh');

	$domain = $_SERVER["SERVER_NAME"];
	if($_SERVER["SERVER_PORT"] != 80)
		$domain .= ":".$_SERVER["SERVER_PORT"];

	$relRoot = dirname($_SERVER['SCRIPT_NAME']);
	if(substr($relRoot, -1) != "/") $relRoot .= "/"; 
	define('RootURL', 'http://'.$domain.$relRoot);
	define('RootABS', 'http://'.$domain.$relRoot);
	define('RootREL', $relRoot);
	define('MediaREL', 'media/');
	define('MediaURI', $relRoot.'media/');
	define('LibsREL', 'media/libs/');
	define('LibsURI', $relRoot.'media/libs/');
	define('UploadREL', 'media/upload/');
	define('UploadURI', $relRoot.UploadREL);
	define('RootURI', dirname($_SERVER['SCRIPT_FILENAME'])."/");

	define('ControllerREL', 'controllers/');
	define('AdminPath', 'admin');
	define('ControllerAdminREL', ControllerREL."/".AdminPath);

	define('DefaultImgW', 600);
	
	// Global variables
	$app = [];
	$app['area'] = 'users';
	$app['areaPath'] = '';

	$app['roles'] = [
		'1'=>'admin',
		'2'=>'leader',
		'3'=>'user'
	];

	$app['role_accounts'] = [
		'1'=>'Admin',
		'2'=>'User'
	];

	$app['status'] = [
		'0'=> 'Block',
		'1'=>'Active',
	];

	$app['recordTime'] = [
		'created'	=>	'created',
		'updated'	=>	'updated'
	];

	$app['months'] = [
		'Jan',
		'Feb',
		'Mar',
		'Apr',
		'May',
		'Jun',
		'Jul',
		'Aug',
		'Sep',
		'Oct',
		'Nov',
		'Dece',
	];

	$app['weekdays'] = [
		'Monday',
		'Tuesday',
		'Wednesday',
		'Thursday',
		'Friday',
		'Saturday',
		'Sunday'
	];

	$mediaFiles = [
		'css'	=>	[],
		'js'	=>	[]
	];
	$obMediaFiles = $mediaFiles;
	include_once(__DIR__.'/database.php');

	$enableOB = true;
?>