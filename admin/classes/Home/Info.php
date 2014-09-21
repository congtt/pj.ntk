<?
class Home_Ext  extends Home
{
	function execute(){		
		$list_form = new XTemplate('Home/List.html');	
		$left_menu= $this->rmenu();
		$uId = get_userid();
		$infoArr = $this->fnc_get_user_info($type_id=1,$value=$uId,$html=true);		
		$gridview = $infoArr['html'];
		$list_form->assign('slide_bar',$this->slide_bar($left_menu));
		$list_form->assign('tabs'	,  	$this->set_tabs());
		$list_form->assign('gridview',$gridview);
		$list_form->assign('dialog_title','thành viên');
		$list_form->parse('main');
		$html = $list_form->out_return('main');	
		echo $html;		
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