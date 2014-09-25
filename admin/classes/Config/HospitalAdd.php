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
			$data = $this->getListDetail($Id);
			foreach($data as $key=>$value){
				$$key=$value;
			}
		}
		$list_form = new XTemplate('Config/HospitalAdd.html');		
		
		$arr_info_province_id = $this->getListProvince();
		$Attr_province_id = array('rel'=>'{Require:\'R\',Alert:\'Vui lòng chọn tỉnh thành \'}','style'=>'');
		$txt_province_id = addSelectList2('province_id',$arr_info_province_id,NULL,$Attr_province_id,$list_form,$province_id);
				
		$arr_info_status = array(1=>'Active',0=>'InActive');
		$Attr_status = array('rel'=>'{Require:\'R\',Alert:\'Vui lòng chọn trạng thái \'}','style'=>'');
		$txt_status = addSelectList2('status',$arr_info_status,NULL,$Attr_status,$list_form,$status);
							
		$Attr_pstname = array('rel'=>'{Require:\'R\',Alert:\'Vui lòng nhập tên bệnh viện \'}','style'=>'width:200px;');
		$txt_pstname = addInput('text','name',$name,$Attr_pstname,$list_form);	
		$Attr_pstorder = array('style'=>'');
		$txt_pstorder = addInput('text','order',$order,$Attr_pstorder,$list_form);	
		
		$list_form->assign('Id',$Id);
		$list_form->assign('token',$token);
		$list_form->parse('main');
		$html = $list_form->out_return('main');	
		die($html);		
	}

	function rmenu(){
		return '';
	
	}

	
	function getListDetail($id){		
		$sSQL="select * from ntk_hospital where id = ".(int)$id;		
		//echo $sSQL;
		$result = $this->db->query($sSQL, true, "Query failed");	
		$aR = $this->db->fetchByAssoc($result);
		return $aR;
	}
}
$seed = new Config_Ext();
$seed->execute();
