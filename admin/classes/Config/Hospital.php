<?
if(!defined('TSEntry') || !TSEntry) die('Not A Valid Entry Point');
include('include/form.inc.php');
include('captcha2/captcha.php');
class Config_Ext  extends Config
{
	public $arrHeader=array();
	public $arrSortHeader=array();	

	function execute(){
		$_Title = 'Quản lý Bệnh viện';
		$_msg = null;
		$captcha = new SimpleCaptcha();
		$formmode=$_POST["formmode"];
		$mode_inpvl = __post('mode_inpvl');
		$captchatxt = __post('captcha');
		$captchaForm = __post('captchaForm');
		$idchk=$_POST["chk"];
		$flagCaptcha =  $captcha->CaptchaValidate($captchatxt);
		$flagCaptchaForm =  $captcha->CaptchaValidate($captchaForm);
		$id = __post('Id');
		/*===================================*/

		if ($formmode!=''){			
			/*Post data*/
			$absent_list_code=__post("absent_list_code");
			$company_id=__post("company_id");
			$absent_list_name=__post("absent_list_name");
			$status=__post("status");
			$max_day=__post("max_day");
			$note=__post("note");

			/*Post data*/
			/****** Add (2) ***********************************/
			if ($formmode=='AbsentListAdd'  && $this->acl_per(2)  && $flagCaptchaForm==true){				
				$_msg  = $this->form_add(0,$absent_list_code,$company_id,$absent_list_name,$status,$max_day,$note);
			}
			/****** Edit (4) ***********************************/
			else if ($formmode=='AbsentListEdit'  && $this->acl_per(4) && $flagCaptchaForm==true){
				$_msg  = $this->form_add($id,$absent_list_code,$company_id,$absent_list_name,$status,$max_day,$note);
			} 
			if (!isset($_msg ))
			{
				$_msg['result'] = -20;
			}			
		}		

		$list_form = new XTemplate('Config/Hospital.html');	
		$left_menu= $this->rmenu();
		$list_form->assign('slide_bar',$this->slide_bar($left_menu));
		$list_form->assign('tabs'	,  	$this->set_tabs());
		$list_form->assign('dialog_title','thành viên');
		$CaptchaText = $captcha->CreateText();
		/****** Delete (8) - Export (16) ***********************************/
		if ($this->acl_per(8)){
			$arr_attr_btnmdelete = array('style'=>'','onclick'=>'sbm_form(8,\''.$CaptchaText.'\')');
			$inp_btnmdelete = addInput2('button','btndelete',$btnmdelete,$arr_attr_btnmdelete,$list_form,'Xóa');	
			if ($mode_inpvl=='DELETE' && $flagCaptcha==true){
				$idList = '0';
				foreach($idchk as $ind=>$delvl){
					$idArr = explode('|',$delvl);
					if ($idArr[1]==$this->md5sum($this->prefix['delete'].$idArr[0])){
						$idList.=','.$idArr[0];
					}
				
				}
				if ($idList!='0')
				{
					$_msg = $this->form_delete($idList);					
				}
			}

		}
		/****** Delete (8) - Export (16) ***********************************/

		if ($this->acl_per(16)){		
			$arr_attr_btnexport = array('style'=>'','onclick'=>'sbm_form(16,\''.$CaptchaText.'\')');
			$inp_btnexport = addInput2('button','btnexport',$btnexport,$arr_attr_btnexport,$list_form,'Xuất Excel');
		}

		/*************************************
		*****************/
		$keyword=__post("keyword");
		$selectkeyword=__post("selectkeyword");


		$Attr_keyword = array('rel1'=>'{Require:\'R\',Alert:\'Vui lòng nhập Keyword  \'}','style'=>'');
		$txt_keyword = addInput('text','keyword',$keyword,$Attr_keyword,$list_form);
		
		//$infosk[0]=array('absent_list_name'=>'Loại phép');
		//$vlkey = array_keys($infosk[$selectkeyword]);
		
		//list($vlkey, $vlval) = each();
		$Attr_selectkeyword = array('rel1'=>'{Require:\'R\',Alert:\'Vui lòng nhập Status  \'}','style'=>'');
		$txt_selectkeyword = addSelectList5('selectkeyword',$infosk,'-- Chọn -- ',$Attr_selectkeyword,$list_form,$selectkeyword);
		
		if ($keyword!='' && $vlkey[0]!='')
		$filter = ' and t1.'.$vlkey[0]." like ''%$keyword%''";
		
		//$ref = new RefModule($this->db);
		//$conpany_list = $ref->ref_company();		
		//-----------------------------------------//
		$gridview='';
		$gridview.= $this->PageHeader();
		$gridview.= $this->_AddPageHeader();
		$exportGrid = $this->setHeader();
		$DBList = $this->setList($CaptchaText,$filter,$conpany_list);	
		$exportGrid.= $DBList[0];
		$gridview.= $exportGrid;		
		$gridview.=$this->setFooter();
		$gridview.=$this->setPaging();	
		



		if($mode_inpvl ==='EXPORT'  && $this->acl_per(16))
			{			
				$this->ExportToExcel(fnStrConvert($_Title),strip_tags($exportGrid,'<table><tr><td><th>'));		
				die();
			}
		//-----------------------------------------//
		setMessage($list_form,$_msg);
		$list_form->assign('title'	,  	$_Title);
		$list_form->assign('_error_'	,  	$error);
		$list_form->assign('gridview'	,  	$gridview);
		$list_form->parse('main');
		$this->html = $list_form->out_return('main');	
		
		echo $this->html;		
	}


	function template(){
		echo $this->html;
	}		
	/*
		function setFooter(){$_Footer='<tr><td colspan=100><img src="images/arrow_ltr.png"> <input	type=checkbox name="check_all" id="check_all"></td></tr></table></div></div>';return $_Footer;}	
	*/
	function define(){
		$this->dont_check_user = false;	
	}

	function rmenu(){
		//1: view - 2:add - 4:edit - 8:delete - 16:export				
		$rmenu = '<li><a href="?module=Config&action=AbsentList">Danh sách </a></li>' ;
		$rmenu_add= '<li><a href="javascript:dg_add(\'Config\',\'AbsentListAdd\',0,\'\',\'Thêm mới\',600,400)">Tạo mới</a></li>' ;
		if ($this->acl_per(2))
			$rmenu.=$rmenu_add;	
		$rmenu.= $this->set_leftmenu();
		$rmenu.='';			
		return $rmenu;
	}

	//======================//
	function _AddPageHeader(){	
		return 	$_PageHeader;	
	}

	function setHeader(){		
		if ($this->pagemode=='EXPORT' || !$this->acl_per(16)){
			$this->arrHeader = array('STT'=>'STT','id'=>'ID','name'=>'Tên','status'=>'Trạng thái','order'=>'Thứ tự');
		}
		else{
			$this->arrHeader = array('STT'=>'<input type=checkbox id=check_all name=check_all>','id'=>'ID','name'=>'Tên','status'=>'Trạng thái','order'=>'Thứ tự');
		}
		$this->arrSortHeader = array('0');
		$SortImage[$_POST['_SortOrderBy']]='&nbsp;<img src="images/order_'.$_POST['_OrderDirection'].'.gif" alt="'.$_POST['_OrderDirection'].'" align="absmiddle" height=7 width=7>';
		$_Header='<div class="hastable"><div id="aj_result">';
		$_Header.='<table   width="90%"  cellspacing="0"  cellpadding="0" border=0 id="tblHeader">';
		$_Header.='<tr style="display:none"><td colspan=10></td></tr><thead><tr>';
		foreach($this->arrHeader as $k=>$name)
		{
			$sortOrder=array_search($k,$this->arrSortHeader);
			if ($sortOrder>=0 && $sortOrder!='')
				{					
					$_Header.='<th  class="ui-state-default t_cap"><a href=javascript:fnOrder('.$sortOrder.') >'.$name.'</a>'.$SortImage[$sortOrder].'</th>';
					$sortOrder=-1;
				}
			else
				$_Header.='<th  class="ui-state-default t_cap">'.$name.'</th>';
			}
			$_Header.='</tr></thead>';
			
			return $_Header;
		}
		function setList($CaptchaText,$filter,$conpany_list){
			$result = NULL;	
			$PageSize=10;		
			$this->PageIndex = isset($_POST["page"]) ? $_POST["page"] : 1;		
			if ($_POST['ddlPageSize']!=''){$PageSize=$_POST['ddlPageSize'];}
			$this->PageSize = $PageSize;
			$_FlgExport=false;
			$mode_inpvl = __post('mode_inpvl');
			if($mode_inpvl=='EXPORT'){$PageSize=0;$_FlgExport=true;}
			
			$_Table = 'ws_rf_absent_list';
			$_KeyField = 'absent_list_id';

			// ===== order =============/
			$_SortOrderBy=$_POST["_SortOrderBy"];
			$_OrderDirection=$_POST["_OrderDirection"];
			
			if (trim($_SortOrderBy)=='' || $_FlgExport)
			{
				$_OrderBy = 'name';
				$_OrderDirection = 'asc';	
			}
			else
			{
				$_OrderBy = $this->arrSortHeader[$_SortOrderBy];			
			}
			//echo $_OrderBy ." - ".$_OrderDirection."<hr>";
			// ===== order =============/				
			
			$_Where=" and 1=1  and status in (0,1) ".$filter;
			
			try
			{	
				$_dblist='';			
				$i=0;
				$start = ($this->PageIndex-1)*$PageSize;
				if ($mode_inpvl=='EXPORT')	
					$sSQL = "select * from ntk_hospital where 1=1 ".$_Where." order by ".$_OrderBy." ".$_OrderDirection;					
				else
					$sSQL = "select * from ntk_hospital where 1=1 ".$_Where." order by ".$_OrderBy." ".$_OrderDirection. " limit ".$start.",".$PageSize;					
				//echo($sSQL);
				//$this->ws_debug($sSQL,false);
				$result = $this->db->query($sSQL, true, "Query failed");					
				$tooltip = '';
				while ($aR = $this->db->fetchByAssoc($result))
				{ 
					if ($i==0){
						$this->TotalRecord = 100;//$aR['TotalRecord'];
						$this->TotalPage = intval($this->TotalRecord/$PageSize + ($this->TotalRecord%$PageSize > 0?1:0));						
					}
					$_RowNum = $aR['RowNum'];
					$_TotalRecord = $aR['TotalRecord'];
					$STT = ($i+($this->PageIndex-1)*$PageSize)+1;	
					$id = $aR['id'];
					$_dblist.='<tr>';										
					if ($mode_inpvl=='EXPORT'){						
						$_dblist.='<td  style="text-align:center" width=50>'.$STT.'</td>';	
					}else{
						$inp_del = '<div title="" class="status_box '.$status_class_name.'">';					
						$tokenDelete = $this->md5sum($this->prefix['delete'].$id);
						$inp_del.= '	<input  type=checkbox value="'.$id.'|'.$tokenDelete.'" name="chk[]" id="chk_'.$STT.'">';
						
						$tokenEdit = $this->md5sum($this->prefix['edit'].$id);
						$inp_del.= '	<img src="../images/edit2.png" width=16 height=16 style="cursor:pointer;margin-right:5px" onclick="dg_add(\'Config\',\'AbsentListAdd\','.$id.',\''.$tokenEdit.'\',\'Cập nhật thông tin\',600,400)">';
					
						$inp_del.= '<img src="../images/delete.png" width=16 height=16  style="cursor:pointer;" onclick="dg_del('.$id.',\''.$tokenDelete.'\','.$STT.',\''.$CaptchaText.'\')">';
						
						$inp_del.= '</div>';
				   }
					$_dblist.='<td  style="text-align:left;width:60px">'.$inp_del.'</td>';	
					$arr_status = array(1=>'<div class="icon_status_success"></div>',0=>'<div class="icon_status_fail"></div>');
					foreach ($this->arrHeader as $field=>$name){					
						if($field=='status'){
							$aR[$field] = $arr_status[(int)$aR[$field]];
						}
						if ($field!='STT'){
							$_dblist.='<td  style="text-align:left">'.$aR[$field].'</td>';
						}
					}
				  $_dblist.='</tr>';
				  $i++;				
				
				}				
				if ($i==0){
					if ($this->TotalRecord==0)
						{
							$_dblist.='<tr><td colspan=100>Không tìm thấy thông tin</td></tr>';	
						}	
				}else{	}
								
			}
			catch (PDOException $ex)
			{}			
					
			$list[0] = $_dblist;
			return $list;							
		}
	function form_delete($id){
		$sSQL="exec sys_table_inactive 'ws_rf_absent_list','absent_list_id',' in(".anti_post($id).") ','status','-13' ";
		//$sSQL="exec web_..._del '".anti_post($id)."'";
		$result = $this->db->query($sSQL, true, "Query failed");	
		$aR = $this->db->fetchByAssoc($result);
		return $aR;
	}
	function form_add($id,$absent_list_code,$company_id,$absent_list_name,$status,$max_day,$note){
		$sSQL="exec web_rf_absent_list_add $id , '$absent_list_code', $company_id, N'$absent_list_name', $status, $max_day, N'$note','".get_username()."' ";
		//echo $sSQL;
		$result = $this->db->query($sSQL, true, "Query failed");	
		$aR = $this->db->fetchByAssoc($result);
		return $aR;
	}
}	

$seed = new Config_Ext();
$seed->execute();
