<?
if(!defined('TSEntry') || !TSEntry) die('Not A Valid Entry Point');
class Config extends TSDefault
{
	function define(){
		$this->dont_check_user = false;
	}
}
