<?

require "tabs.php";
$module = 'HHConfig';
foreach($tabs_array[$module] as $action=>$name){
	if($action!='index'){
		$module_action = $module."_".$action;
		if(isset($_SESSION[_PLATFORM_]['CLA']['RoleData'][$module][$module_action])){	
			header('location: do?module='.$module.'&action='.$action);die();
		}
	}
}
die();
?>