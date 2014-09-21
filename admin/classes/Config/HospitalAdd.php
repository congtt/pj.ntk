<?
if(!defined('TSEntry') || !TSEntry) die('Not A Valid Entry Point');
include('include/form.inc.php');
include('classes/TSDefault/RefModule.class.php');
class HHConfig_Ext  extends HHConfig
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

		$list_form = new XTemplate('HHConfig/AbsentListAdd.html');			

		$Attr_pstabsent_list_code = array('rel1'=>'{Require:\'R\',Alert:\'Vui lòng nhập absent_list_code  \'}','style'=>'');
		$txt_pstabsent_list_code = addInput('text','absent_list_code',$absent_list_code,$Attr_pstabsent_list_code,$list_form);	
		
		$RefModule = new RefModule($this->db,$this->AuthSum);
				
		$arr_info_company_id = $RefModule->ref_company();
		$Attr_company_id = array('rel1'=>'{Require:\'R\',Alert:\'Vui lòng nhập role_name  \'}','style'=>'');
		$txt_company_id = addSelectList4('company_id',$arr_info_company_id,NULL,$Attr_company_id,$list_form,$company_id);

			
		$Attr_pstabsent_list_name = array('rel1'=>'{Require:\'R\',Alert:\'Vui lòng nhập absent_list_name  \'}','style'=>'width:250px;');
		$txt_pstabsent_list_name = addInput('text','absent_list_name',$absent_list_name,$Attr_pstabsent_list_name,$list_form);			
		
		
		$arr_info_status = $RefModule->ref_status();
		$Attr_status = array('rel1'=>'{Require:\'R\',Alert:\'Vui lòng nhập role_name  \'}','style'=>'');
		$txt_status = addSelectList2('status',$arr_info_status,NULL,$Attr_status,$list_form,$status);


			
		$Attr_pstmax_day = array('rel1'=>'{Require:\'R\',Alert:\'Vui lòng nhập max_day  \'}','style'=>'');
		$txt_pstmax_day = addInput('text','max_day',$max_day,$Attr_pstmax_day,$list_form);	
		
		$Attr_pstnote = array('rel1'=>'{Require:\'R\',Alert:\'Vui lòng nhập note  \'}','style'=>'');
		$txt_pstnote = addInput('text','note',$note,$Attr_pstnote,$list_form);	
		
		$list_form->assign('Id',$Id);
		$list_form->assign('token',$token);
		if ($Id>0)
			$list_form->assign('formmode','AbsentListEdit');
		else
			$list_form->assign('formmode','AbsentListAdd');

		$list_form->parse('main');
		$html = $list_form->out_return('main');	
		die($html);		
	}

	function rmenu(){
		return '';
	
	}


	function getListDetail($id){
		$_Table = 'ws_rf_absent_list';
		$_KeyField = 'absent_list_id';	
		$sSQL="exec web_table_detail_list '$_Table','$_KeyField',$id,'int'";
		$result = $this->db->query($sSQL, true, "Query failed");	
		$aR = $this->db->fetchByAssoc($result);
		return $aR;
	}
}
$seed = new HHConfig_Ext();
$seed->execute();
