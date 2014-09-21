<?
class Home_Ext  extends Home
{
	function execute(){
		
		if ((int)__post2('type')>0){
			$_SESSION[_PLATFORM_]["CLA"]['TopLeftLinkType'] = (int)__post2('type');
		}
		
		elseif (!isset($_SESSION[_PLATFORM_]["CLA"]['TopLeftLinkType']) || $_SESSION[_PLATFORM_]["CLA"]['TopLeftLinkType']=='' || (int)$_SESSION[_PLATFORM_]["CLA"]['TopLeftLinkType']==0){
			$_SESSION[_PLATFORM_]["CLA"]['TopLeftLinkType'] = 1;
		}
		$member_access= $this->acl_access('Member','HHMember');
		if ($_SESSION[_PLATFORM_]["CLA"]['TopLeftLinkType']==1){
			if ($member_access)
				header('location:do?module=HHMember&action=Member&mnl=1');
			else
				header('location:do?module=Home&action=Info&mnl=1');
			die('');
		}else if((int)__post2('type')>0){
			header('location:do?module=Home&action=Info&mnl=1');
			die('');
		}		
		die();	
	}

	function rmenu(){
		return '&nbsp;';
	
	}

	function no_body(){	
		return true;
	}
}
$seed = new Home_Ext();
$seed->execute();
?>