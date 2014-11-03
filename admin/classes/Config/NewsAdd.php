<?
if(!defined('TSEntry') || !TSEntry) die('Not A Valid Entry Point');
include('include/form.inc.php');
include('classes/TSDefault/RefModule.class.php');
include('captcha2/captcha.php');
class Config_Ext  extends Config
{
	function execute(){
		global $ts_config;
		$_Title = 'Quản lý Bài viết';
		$_msg = null;
		$captcha = new SimpleCaptcha();
		$formmode=$_POST["formmode"];
		$mode_inpvl = __post('mode_inpvl');		
		$captchatxt = __post('captcha');
		$captchaForm = __post('captchaForm');
		$idchk=$_POST["chk"];
		$flagCaptcha =  $captcha->CaptchaValidate($captchatxt);
		$flagCaptchaForm =  $captcha->CaptchaValidate($captchaForm);
		
		$Id= __post2("Id");
		$token= __post2("token");
		if($Id>0){
			if($token != $this->md5sum('edit'.$Id)){
				die('Do not have permission to access page!');
			}
		}
		$list_form = new XTemplate('Config/NewsAdd.html');	
		
		if ($mode_inpvl=='ADD'){
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
			
			$result_id  = $this->form_add($Id,$menu_id,$title_vi,$title_en,$short_vi,$short_en,$content_vi,$content_en,$keyword_vi,$keyword_en,$status);
			if((int)$Id<=0){
				$Id = $result_id;
			}			
			$result = UpLoadMultiFile($ts_config['upload_dir'],'filenew', false,'',$max_size=9048576);
			$file_type_id = 7;
			foreach($result as $k=>$va){
				if($va['result']==1){
					$sSQL = "insert into ntk_new_files(new_id,file_name,file_path,file_type_id,require_login)
						values(".$Id.",'".$va['name']."','".$va['file_name']."',".$file_type_id.",1)
					";
					$re = $this->db->query($sSQL, true, "Query failed");
				}
			}
			if ($result_id>0)
			{
				$_msg['result'] = 1;
			}else{
				$_msg['result'] = -20;
			}	
		}		
		if ((int)$Id>0)
		{			
			$data = $this->getDetail($Id);			
			foreach($data as $key=>$value){
				$$key=$value;
			}
			
			$sSQL = "select * from ntk_new_files where new_id = ".(int)$Id;
			$result = $this->db->query($sSQL, true, "Query failed");	
			while ($aR = $this->db->fetchByAssoc($result)){
				$list_form->assign('file',$aR);
				$list_form->parse('main.file');
			}			
		}
		$left_menu= $this->rmenu();
		$list_form->assign('slide_bar',$this->slide_bar($left_menu));
		$list_form->assign('tabs'	,  	$this->set_tabs());
		$list_form->assign('dialog_title','thành viên');
		$CaptchaText = $captcha->CreateText();		
		
		$arr_info_menu_id = $this->getListNewsCategories();
		$Attr_menu_id = array('rel'=>'{Require:\'R\',Alert:\'Vui lòng chọn danh mục \'}','style'=>'width:400px;');
		$txt_menu_id = addSelectList2('menu_id',$arr_info_menu_id,NULL,$Attr_menu_id,$list_form,$cid);
			
		$arr_info_status = array(1=>'Active',0=>'InActive');
		$Attr_status = array('rel'=>'{Require:\'R\',Alert:\'Vui lòng chọn trạng thái \'}','style'=>'');
		$txt_status = addSelectList2('status',$arr_info_status,NULL,$Attr_status,$list_form,$status);
							
		$Attr_psttitle_vi = array('rel'=>'{Require:\'R\',Alert:\'Vui lòng nhập tiêu đề tiếng việt \'}','style'=>'width:400px;');
		$txt_psttitle_vi = addInput('text','title_vi',$title_vi,$Attr_psttitle_vi,$list_form);	
		
		$Attr_psttitle_en = array('rel1'=>'{Require:\'R\',Alert:\'Vui lòng nhập tiêu đề tiếng anh \'}','style'=>'width:400px;');
		$txt_psttitle_en = addInput('text','title_en',$title_en,$Attr_psttitle_en,$list_form);	
		$class_input = 'ckeditor';
		$Attr_short_vi = array('class'=>$class_input,'rel'=>'{Require:\'R\',Alert:\'Vui lòng nhập mô tả ngắn tiếng việt  \'}','style'=>'width:400px;');
		$txt_short_vi = addTextarea('short_vi',3,30,$short_vi,$Attr_short_vi,$list_form);
		$Attr_short_en = array('class'=>$class_input,'rel1'=>'{Require:\'R\',Alert:\'Vui lòng nhập role_name  \'}','style'=>'width:400px;');
		$txt_short_en = addTextarea('short_en',3,30,$short_en,$Attr_short_en,$list_form);
		$Attr_content_vi = array('class'=>$class_input,'rel'=>'{Require:\'R\',Alert:\'Vui lòng nhập Nội dung tiếng việt  \'}','style'=>'width:400px;');
		$txt_content_vi = addTextarea('content_vi',3,30,$content_vi,$Attr_content_vi,$list_form);
		$Attr_content_en = array('class'=>$class_input,'rel1'=>'{Require:\'R\',Alert:\'Vui lòng nhập Nội dung tiếng anh  \'}','style'=>'width:400px;');
		$txt_content_en = addTextarea('content_en',3,30,$content_en,$Attr_content_en,$list_form);
		
		$Attr_pstkeyword_vi = array('rel'=>'{Require:\'R\',Alert:\'Vui lòng nhập từ khóa tiếng việt \'}','style'=>'width:400px;');
		$txt_pstkeyword_vi = addInput('text','keyword_vi',$keyword_vi,$Attr_pstkeyword_vi,$list_form);	
		
		$Attr_pstkeyword_en = array('rel1'=>'{Require:\'R\',Alert:\'Vui lòng nhập từ khóa tiếng anh\'}','style'=>'width:400px;');
		$txt_pstkeyword_en = addInput('text','keyword_en',$keyword_en,$Attr_pstkeyword_en,$list_form);	
		
		if ($this->acl_per(2)){
			//$arr_attr_btnadd = array('style'=>'color:blue;','onclick'=>'sbm_form(2,\''.$CaptchaText.'\')');
			$arr_attr_btnadd = array('style'=>'color:blue;','onclick'=>'add()');
			$inp_btnadd = addInput2('button','btnadd',$btnadd,$arr_attr_btnadd,$list_form,'LƯU');
		}
		
		
		$list_form->assign('Id',$Id);
		$list_form->assign('token',$token);
		//$list_form->parse('main');
	//	$html = $list_form->out_return('main');	
		$list_form->assign('title'	,  	$_Title);
		$list_form->assign('_error_'	,  	$error);
		$list_form->assign('gridview'	,  	$gridview);
		$list_form->parse('main');
		$this->html = $list_form->out_return('main');	
		
		echo $this->html;
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
	
	function form_add($id,$menu_id,$title_vi,$title_en,$short_vi,$short_en,$content_vi,$content_en,$keyword_vi,$keyword_en,$status){
		if($id>0){
			$sSQL=" update ntk_news 
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
			where id = ".$id;			
			$result = $this->db->query($sSQL, true, "Query failed");
			return 1;
		}else{
			$sSQL = "insert into ntk_news (cid,title_vi,title_en,short_vi,short_en,content_vi,content_en,keyword_vi,keyword_en,`status`) 
			values(".(int)$menu_id.",N'".$title_vi."',N'".$title_en."',N'".$short_vi."',N'".$short_en."',N'".$content_vi."',N'".$content_en."',N'".$keyword_vi."',N'".$keyword_en."',".$status.")
			";
			$sSQLID = "select id from ntk_news where cid = ".(int)$menu_id." and title_vi = N'".$title_vi."' order by id desc limit 0,1
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
