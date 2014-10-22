<?
if(!defined('TSEntry') || !TSEntry) die('Not A Valid Entry Point');
include('include/form.inc.php');
include('classes/TSDefault/RefModule.class.php');
class Config_Ext  extends Config
{
	function execute(){


		$Id= __post("Id");
		if ((int)$Id>0)
		{
			$token= __post("token");
			$data = $this->getDetail($Id);
			foreach($data as $key=>$value){
				$$key=$value;
			}
		}
		$list_form = new XTemplate('Config/NewsAdd.html');		
		
		$arr_info_menu_id = $this->getListNewsCategories();
		$Attr_menu_id = array('rel'=>'{Require:\'R\',Alert:\'Vui lòng chọn danh mục \'}','style'=>'width:400px;');
		$txt_menu_id = addSelectList2('menu_id',$arr_info_menu_id,NULL,$Attr_menu_id,$list_form,$menu_id);
		
		$arr_info_status = array(1=>'Active',0=>'InActive');
		$Attr_status = array('rel'=>'{Require:\'R\',Alert:\'Vui lòng chọn trạng thái \'}','style'=>'');
		$txt_status = addSelectList2('status',$arr_info_status,NULL,$Attr_status,$list_form,$status);
							
		$Attr_psttitle_vi = array('rel'=>'{Require:\'R\',Alert:\'Vui lòng nhập tên bệnh viện \'}','style'=>'width:400px;');
		$txt_psttitle_vi = addInput('text','title_vi',$title_vi,$Attr_psttitle_vi,$list_form);	
		
		$Attr_psttitle_en = array('rel'=>'{Require:\'R\',Alert:\'Vui lòng nhập tên bệnh viện \'}','style'=>'width:400px;');
		$txt_psttitle_en = addInput('text','title_en',$title_en,$Attr_psttitle_en,$list_form);	
		
		$Attr_short_vi = array('class'=>$class_input,'rel1'=>'{Require:\'R\',Alert:\'Vui lòng nhập role_name  \'}','style'=>'width:400px;');
		$txt_short_vi = addTextarea('short_vi',3,30,$short_vi,$Attr_short_vi,$list_form);
		$Attr_short_en = array('class'=>$class_input,'rel1'=>'{Require:\'R\',Alert:\'Vui lòng nhập role_name  \'}','style'=>'width:400px;');
		$txt_short_en = addTextarea('short_en',3,30,$short_en,$Attr_short_en,$list_form);
		$Attr_content_vi = array('class'=>$class_input,'rel1'=>'{Require:\'R\',Alert:\'Vui lòng nhập role_name  \'}','style'=>'width:400px;');
		$txt_content_vi = addTextarea('content_vi',3,30,$content_vi,$Attr_content_vi,$list_form);
		$Attr_content_en = array('class'=>$class_input,'rel1'=>'{Require:\'R\',Alert:\'Vui lòng nhập role_name  \'}','style'=>'width:400px;');
		$txt_content_en = addTextarea('content_en',3,30,$content_en,$Attr_content_en,$list_form);
		
		$Attr_pstkeyword_vi = array('rel'=>'{Require:\'R\',Alert:\'Vui lòng nhập tên bệnh viện \'}','style'=>'width:400px;');
		$txt_pstkeyword_vi = addInput('text','keyword_vi',$keyword_vi,$Attr_pstkeyword_vi,$list_form);	
		
		$Attr_pstkeyword_en = array('rel'=>'{Require:\'R\',Alert:\'Vui lòng nhập tên bệnh viện \'}','style'=>'width:400px;');
		$txt_pstkeyword_en = addInput('text','keyword_en',$keyword_en,$Attr_pstkeyword_en,$list_form);	
		
		
		$list_form->assign('Id',$Id);
		$list_form->assign('token',$token);
		$list_form->parse('main');
		$html = $list_form->out_return('main');	
		die($html);		
	}

	function rmenu(){
		return '';	
	}
	
	function getDetail($id){		
		$sSQL="select * from ntk_news where id = ".(int)$id;		
		//echo $sSQL;
		$result = $this->db->query($sSQL, true, "Query failed");	
		$aR = $this->db->fetchByAssoc($result);
		return $aR;
	}
}
$seed = new Config_Ext();
$seed->execute();
