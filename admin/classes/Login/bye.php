<?
class Login_Ext  extends Login
{
	function execute(){
		global $ts_config;
		$this->signout();
		header('location:'.$ts_config['site_url_admin']);die();	
	}
}
$seed = new Login_Ext();
$seed->execute();
		