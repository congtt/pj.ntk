<?
include('include/form.inc.php');
include('captcha2/captcha.php');
class Config_Ext  extends Config
{	
	function execute(){		
}
$seed = new Config_Ext();
$seed->execute();