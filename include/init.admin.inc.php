<?session_start();


if (is_admin() && $cla_module=='' && $cla_action==''){
	$cla_module='Config';
	$cla_action='Hospital';
}

if ($cla_module==''){
	$cla_module = 'TSDefault';
}
if ($cla_action==''){
	$cla_action = 'index';
}

$no_body = __post('no_body')==''?__get('no_body'):__post('no_body');
$cla_module==''?'TSDefault':$cla_module;
define('_MODULE_',$cla_module);
define('_ACTION_',$cla_action);
require_once('XTemplate/xtpl.php');
require_once(admin_dir."classes/TSDefault/TSDefault.class.php");

try {
	if (is_file(admin_dir."classes/".$cla_module."/".$cla_module.".class.php")){				
		require_once(admin_dir."classes/".$cla_module."/".$cla_module.".class.php");
	}
	if (class_exists($cla_module)){
		$cla = new $cla_module();
		$cla->define();
		if ($cla_module != 'TSDefault' && $cla_module != 'Ajax' && $cla_module != 'Error' && !$cla->acl_access()){
			ts_permission(1,$ts_config['site_url']);
		}
	}else{
		header('location:do?module=Error&action=ViewError');
		die();
	}
}catch (Exception $e){


}/*
echo admin_dir."classes/".$cla_module."/".$cla_action.".php";
if (is_file(admin_dir."classes/".$cla_module."/".$cla_action.".php")){
	
	require_once(admin_dir."classes/".$cla_module."/".$cla_action.".php");
	if(class_exists($cla_action)){
		$cla = new $cla_action();
		$cla->define();
		$cla->execute();
	}

}
*/

	
