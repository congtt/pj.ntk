<?
class Login_Ext  extends Login
{
	function execute(){
		global $ts_config;
		$this->signout();		
				
	}

}
$seed = new Login_Ext();
$seed->execute();
?>