<?
if(!defined('TSEntry'))define('TSEntry', true);
ini_set('display_errors',1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

//print("<pre>");print_r($_GET);die();
define(admin_dir,'admin/');

$cla_module = $_GET['module'];
$cla_action = $_GET['action'];
//echo "m: ".$module." - ac: ".$action."<br>";
//include($admin_dir.'ntk-header.php');

require_once('include/init.admin.inc.php');

if ($no_body!='true' && $cla->no_body()!=true){require_once(admin_dir.'header.php');}
			if (is_admin()){				
				if (is_file(admin_dir."classes/".$cla_module."/{$cla_action}.php")){				
					require_once(admin_dir."classes/".$cla_module."/{$cla_action}.php");
				}else{		
					header("location:do?module=Error&action=ViewError&err=1&md=".$cla_module."&mdact=".$cla_action);
					ts_die("Error: Action <a href=do?module=".$cla_module."&action=".$cla_action.">".$cla_action."</a> does not exist.");
				}
			} else {				
				$cla->error();
				if ($cla_module=='Error'){					
					require_once(admin_dir."classes/".$cla_module."/{$cla_action}.php");
				}
				else
				{
					require_once(admin_dir."classes/Login/Login.class.php");
					require_once(admin_dir."classes/Login/signin.php");
					
				}
			}				
		
if ($no_body!='true'){require_once(admin_dir.'footer.php');}


