<?
if(!defined('TSEntry') || !TSEntry) die('Not A Valid Entry Point');
include('include/form.inc.php');
include('captcha2/captcha.php');
class Config_Ext  extends Config
{
	public $arrHeader=array();
	public $arrSortHeader=array();	
	
	function execute(){
		global $ts_config;
		$_Title = 'Forum - Quản lý Bài đăng';
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
		$post_id = __post2('post_id');
		/*===================================*/
		if ($formmode!=''){			
			$menu_id=__post("menu_id");
			$title_vi=__post("title_vi");
			$title_en=__post("title_en");
			$short_vi=__post("short_vi");
			$short_en=__post("short_en");
			$content_vi=__post("content_vi");
			$content_en=__post("content_en");
			$keyword_vi = __post("keyword_vi");
			$keyword_en = __post("keyword_en");			
			$status=(int)__post("status");
			$show_index=(int)__post("show_index");
			
			$result_id  = $this->form_add($id,$menu_id,$title_vi,$title_en,$short_vi,$short_en,$content_vi,$content_en,$keyword_vi,$keyword_en,$status,$show_index);
			if((int)$id<=0){
				$id = $result_id;
			}
			/*
			$result = UpLoadMultiFile($ts_config['upload_dir'],'filenew',$gen_name = false,$title='',$max_size=9048576);
			$file_type_id = 7;
			foreach($result as $k=>$va){
				$sSQL = "insert into ntk_new_files(new_id,file_name,file_path,file_type_id,require_login)
						values(".$id.",'".$va['name']."','".$va['file_name']."',".$file_type_id.",1)
				";
				$re = $this->db->query($sSQL, true, "Query failed");
			}*/
			if ($result_id>0)
			{
				$_msg['result'] = 1;
			}else{
				$_msg['result'] = -20;
			}	
		}
		
		$list_form = new XTemplate('Config/PostComment.html');	
		$left_menu= $this->rmenu();
		$list_form->assign('slide_bar',$this->slide_bar($left_menu));
		$list_form->assign('tabs'	,  	$this->set_tabs());
		$list_form->assign('dialog_title','thành viên');
		$CaptchaText = $captcha->CreateText();
		/****** Delete (8) - Export (16) ***********************************/		
		$arr_attr_btnmdelete = array('style'=>'','onclick'=>'sbm_form(8,\''.$CaptchaText.'\')');
		$inp_btnmdelete = addInput2('button','btndelete',$btnmdelete,$arr_attr_btnmdelete,$list_form,'Xóa');

		$arr_attr_btnmdelete = array('style'=>'','onclick'=>'sbm_form(9,\''.$CaptchaText.'\')');
		$inp_btnmdelete = addInput2('button','btnactive',$btnmdelete,$arr_attr_btnmdelete,$list_form,'ACTIVE');

		$arr_attr_btnmdelete = array('style'=>'','onclick'=>'sbm_form(10,\''.$CaptchaText.'\')');
		$inp_btnmdelete = addInput2('button','btninactive',$btnmdelete,$arr_attr_btnmdelete,$list_form,'INACTIVE');		
		if ($mode_inpvl=='DELETE' || $mode_inpvl=='ACTIVE'|| $mode_inpvl=='INACTIVE'){
			$idList = '0';
			foreach($idchk as $ind=>$delvl){
				$idArr = explode('|',$delvl);
				if ($idArr[1]==$this->md5sum($this->prefix['delete'].$idArr[0])){
					$idList.=','.$idArr[0];
				}
			
			}
			$status_change = -13;
			switch($mode_inpvl){
				case 'DELETE':
					$status_change = -13;
					break;
				case 'ACTIVE':
					$status_change = 1;
					break;
				case 'INACTIVE':
					$status_change = 0;
					break;
				default:
					break;
			}
			if ($idList!='0')
			{
				$_msg = $this->form_delete($idList,$status_change);					
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
		
		$infosk[0]=array('t1.content'=>'Nội dung bình luận');		
		$infosk[1]=array('t2.title_vi'=>'Tên bài đăng(vi)');
		$infosk[2]=array('t2.title_en'=>'Tên bài đăng(en)');
		$vlkey = array_keys($infosk[$selectkeyword]);
		
		//list($vlkey, $vlval) = each();
		$Attr_selectkeyword = array('style'=>'');
		$txt_selectkeyword = addSelectList5('selectkeyword',$infosk,NULL,$Attr_selectkeyword,$list_form,$selectkeyword);
		
		if ($keyword!='' && $vlkey[0]!='')
			$filter .= ' and '.$vlkey[0]." like N'%$keyword%'";		
		$category_id = (int)__post('category_id');
		$status = __post('status');	
		//echo $filter;
		if($category_id>0){
			$filter .= ' and t2.cid = '.$category_id;		
		}	
		if($status!=""){
			$filter .= ' and t1.status = '.(int)$status;
		}	
		if($post_id>0){
			$filter .= " and t1.post_id = ".(int)$post_id;
		}
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
					
		$arr_info_show_index = array(1=>'Hiển thị trang chủ',0=>'Không hiển thị trang chủ');
		$Attr_show_index = array('rel1'=>'{Require:\'R\',Alert:\'Vui lòng chọn trạng thái \'}','style'=>'');
		$txt_show_index = addSelectList2('show_index',$arr_info_show_index,'-- Trang chủ --',$Attr_show_index,$list_form,$show_index);
		
		$arr_info_category_id = $this->getListPostCategories();
		$Attr_category_id = array('rel1'=>'{Require:\'R\',Alert:\'Vui lòng chọn danh mục \'}','style'=>'width:400px;');
		$txt_category_id = addSelectList2('category_id',$arr_info_category_id,'-- Danh mục --',$Attr_category_id,$list_form,$category_id);
		
		$arr_info_status = array(1=>'Active',0=>'InActive');
		$Attr_status = array('rel1'=>'{Require:\'R\',Alert:\'Vui lòng chọn trạng thái \'}','style'=>'');
		$txt_status = addSelectList2('status',$arr_info_status,'-- Trạng thái --',$Attr_status,$list_form,$status);
			
		
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
	function define(){
		$this->dont_check_user = false;	
	}

	function rmenu(){
		//1: view - 2:add - 4:edit - 8:delete - 16:export				
		$rmenu = '<li><a href="?module=Config&action=AbsentList">Danh sách </a></li>' ;
		$rmenu_add= '<li><a href="javascript:dg_add(\'Config\',\'PostCommentAdd\',0,\'\',\'Thêm mới\',400,300)">Tạo mới</a></li>' ;
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
			$this->arrHeader = array('STT'=>'STT','comment_id'=>'ID','title_vi'=>'Bài viết(vi)','title_en'=>'Bài viết(en)','content'=>'Nội dung','status'=>'Trạng thái','email'=>'Email người đăng','full_name'=>'Họ tên người đăng');
		}else{
			$this->arrHeader = array('STT'=>'<input type=checkbox id=check_all name=check_all>','comment_id'=>'ID','title_vi'=>'Bài viết(vi)','title_en'=>'Bài viết(en)','content'=>'Nội dung','status'=>'Trạng thái','email'=>'Email người đăng','full_name'=>'Họ tên người đăng');
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
				$_OrderBy = 'comment_id';
				$_OrderDirection = 'desc';	
			}
			else
			{
				$_OrderBy = $this->arrSortHeader[$_SortOrderBy];			
			}		
			// ===== order =============/				
			
			$_Where=" and 1=1  and t1.status <> -13 ".$filter;
			
			try
			{	
				$_dblist='';			
				$i=0;
				$start = ($this->PageIndex-1)*$PageSize;
				if ($mode_inpvl=='EXPORT')
					$sSQL = "select t1.*,t2.title_vi , t2.title_en,t3.email,t3.full_name
					from ntk_forum_comments  t1 
					left join ntk_forum_posts t2  on t1.post_id = t2.id
					left join ntk_users t3  on t1.user_id = t3.id
					where 1=1 ".$_Where." order by ".$_OrderBy." ".$_OrderDirection;					
				else{
					$sSQLTotal = "select count(t1.comment_id) as TotalRecord 
					from ntk_forum_comments t1
					left join ntk_forum_posts t2 on   t1.post_id = t2.id
					left join ntk_users t3  on t1.user_id = t3.id
					where 1=1 ".$_Where;
					$sSQL = "select t1.*,t2.title_vi , t2.title_en ,t3.email,t3.full_name
					from ntk_forum_comments  t1 
					left join ntk_forum_posts t2  on  t1.post_id = t2.id
					left join ntk_users t3  on t1.user_id = t3.id
					where 1=1 ".$_Where." order by ".$_OrderBy." ".$_OrderDirection. " limit ".$start.",".$PageSize;					
					//echo $sSQLTotal;
					$resultTotal = $this->db->query($sSQLTotal, true, "Query failed");	
					$aRTotal = $this->db->fetchByAssoc($resultTotal);
					$this->TotalRecord = $aRTotal['TotalRecord'];
					$this->TotalPage = intval($this->TotalRecord/$PageSize + ($this->TotalRecord%$PageSize > 0?1:0));						
					
				}
				$result = $this->db->query($sSQL, true, "Query failed");										
				$tooltip = '';
				$arr_wrap = array('content');
				while ($aR = $this->db->fetchByAssoc($result))
				{
					$_RowNum = $aR['RowNum'];
					$_TotalRecord = $aR['TotalRecord'];
					$STT = ($i+($this->PageIndex-1)*$PageSize)+1;	
					$id = $aR['comment_id'];
					$_dblist.='<tr>';										
					if ($mode_inpvl=='EXPORT'){					
						$_dblist.='<td  style="text-align:center" width=50>'.$STT.'</td>';	
					}else{
						$inp_del = '<div  title="" class="status_box '.$status_class_name.'">';					
						$tokenDelete = $this->md5sum($this->prefix['delete'].$id);
						$inp_del.= '	<input  type=checkbox value="'.$id.'|'.$tokenDelete.'" name="chk[]" id="chk_'.$STT.'">';
						//$tokenEdit = $this->md5sum($this->prefix['edit'].$id);
						//$inp_del.= '	<img src="../images/edit2.png" width=16 height=16 style="cursor:pointer;margin-right:5px" onclick="dg_add(\'Config\',\'PostCommentAdd\','.$id.',\''.$tokenEdit.'\',\'Cập nhật thông tin\',800,600)">';
						$inp_del.= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../images/delete.png" width=16 height=16  style="cursor:pointer;" onclick="dg_del('.$id.',\''.$tokenDelete.'\','.$STT.',\''.$CaptchaText.'\')">';
						$inp_del.= '</div>';
						$_dblist.='<td  nowrap style="text-align:left;width:60px">'.$inp_del.'</td>';	
				   }				
					if($mode_inpvl!='EXPORT'){
						$arr_status = array(1=>'<div class="icon_status_success"></div>',0=>'<div class="icon_status_fail"></div>');
					}else{
						$arr_status = array(1=>'Active',0=>'InActive');
					}					
					foreach ($this->arrHeader as $field=>$name){					
						if($field=='status' || $field=='show_index'){
							$aR[$field] = $arr_status[(int)$aR[$field]];
						}
						if ($field!='STT'){
							if(in_array($field,$arr_wrap)){								
								$len = strlen($aR[$field]);
								if( $len > 50 ){
									$data = substr($aR[$field],0,50).' ....';
								}else{
									$data = $aR[$field];
								}
								$_dblist.='<td title = "'.$aR[$field].'" style="text-align:left"><pre>'.$data.'</pre></td>';
							}else{
								$_dblist.='<td  style="text-align:left">'.$aR[$field].'</td>';
							}
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
	function form_delete($id,$status=-13){
		$sSQL="update ntk_forum_comments set status = ".(int)$status." where comment_id in(".anti_post($id).") ";	
		$result = $this->db->query($sSQL, true, "Query failed");	
		$aR = $this->db->fetchByAssoc($result);
		return 1;
	}	
	function form_add($id,$menu_id,$title_vi,$title_en,$short_vi,$short_en,$content_vi,$content_en,$keyword_vi,$keyword_en,$status,$show_index){
		if($id>0){
			$sSQL=" update ntk_forum_comments 
			set cid=".$menu_id."			
			,title_vi = N'".$title_vi."'
			,title_en = N'".$title_en."'
			,short_vi = N'".$short_vi."'
			,short_en = N'".$short_en."'
			,content_vi = N'".$content_vi."'
			,content_en = N'".$content_en."'
			,keyword_vi = N'".$keyword_vi."'
			,keyword_en = N'".$keyword_en."'
			, `status` = ".(int)$status."
			, `show_index` = ".(int)$show_index."
			,modify_by = 'admin'
			,modify_date = NOW()
			where id = ".$id;
			//echo "<hr>".$sSQL."<hr>";
			$result = $this->db->query($sSQL, true, "Query failed");
			return 1;
		}else{
			$sSQL = "insert into ntk_forum_comments (cid,title_vi,title_en,short_vi,short_en,content_vi,content_en,keyword_vi,keyword_en,`status`,`show_index`,create_date,create_date) 
			values(".(int)$menu_id.",N'".$title_vi."',N'".$title_en."',N'".$short_vi."',N'".$short_en."',N'".$content_vi."',N'".$content_en."',N'".$keyword_vi."',N'".$keyword_en."',".$status.",".$show_index.",'admin',NOW())
			";
			$sSQLID = "select id from ntk_forum_comments where cid = ".(int)$menu_id." and title_vi = N'".$title_vi."' order by id desc limit 0,1
			";			
			$result = $this->db->query($sSQL, true, "Query failed");
			$resultID = $this->db->query($sSQLID, true, "Query failed");
			
			$aR = $this->db->fetchByAssoc($resultID);	
			return (int)$aR['id'];
		}
		return -1;
	}
}	

$seed = new Config_Ext();
$seed->execute();
