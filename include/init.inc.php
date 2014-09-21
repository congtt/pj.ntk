<?session_start();




if(!defined('TSEntry') || !TSEntry) die('Not A Valid Entry Point');
// config|_override.php
if(is_file('include/config.php')) {
    require_once('include/config.php'); // provides $ts_config
}
// load up the config_override.php file.  This is used to provide default user settings
if(is_file('include/config_override.php')) {
	require_once('include/config_override.php');
}

require_once('include/defined.inc.php');
$ts_info = $_SESSION[_PLATFORM_]["CLA"];
require_once('include/db/DBManagerFactory.php');
$db = DBManagerFactory::getInstance();
$db->resetQueryCount();
require_once('include/system.function.inc.php');
require_once('include/function.inc.php');



$cla_nid = __post2("nid");
$cla_site = __post2("site");
$cla_cid = __post2("cid");

require_once('XTemplate/xtpl.php');
$arParam = explode('/',$_SERVER["REQUEST_URI"]);
$pageUrl = $arParam[count($arParam)-1];


