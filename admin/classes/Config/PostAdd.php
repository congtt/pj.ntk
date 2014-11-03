<?
if(!defined('TSEntry') || !TSEntry) die('Not A Valid Entry Point');
include('include/form.inc.php');
include('classes/TSDefault/RefModule.class.php');
include('captcha2/captcha.php');
class Config_Ext  extends Config
{
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
		
		$Id= __post("Id");
		if($Id>0){
			if($token != $this->md5sum('edit'.$Id)){
				die('Do not have permission to access page!');
			}
		}
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
			$show_index=(int)__post("show_index");
			
			$result_id  = $this->form_add($id,$menu_id,$title_vi,$title_en,$short_vi,$short_en,$content_vi,$content_en,$keyword_vi,$keyword_en,$status,$show_index);
			if((int)$id<=0){
				$id = $result_id;
			}			
			if ($result_id>0)
			{
				$_msg['result'] = 1;
			}else{
				$_msg['result'] = -20;
			}	
		}
		$list_form = new XTemplate('Config/PostAdd.html');
		$left_menu= $this->rmenu();
		$list_form->assign('slide_bar',$this->slide_bar($left_menu));
		$list_form->assign('tabs'	,  	$this->set_tabs());
		$list_form->assign('dialog_title','thành viên');
		$CaptchaText = $captcha->CreateText();
		if ((int)$Id>0)
		{
			$token= __post("token");
			$data = $this->getDetail($Id);
			foreach($data as $key=>$value){
				$$key=$value;
			}
			/*
			$sSQL = "select * from ntk_forum_posts where id = ".(int)$Id;
			$result = $this->db->query($sSQL, true, "Query failed");	
			while ($aR = $this->db->fetchByAssoc($result)){
				$list_form->assign('file',$aR);
				$list_form->parse('main.file');
			}*/
			
		}				
		$class_input = 'ckeditor';
		$arr_info_menu_id = $this->getListPostCategories();
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
		
		$arr_info_show_index = array(1=>'Hiển thị trang chủ',0=>'Không hiển thị trang chủ');
		$Attr_show_index = array('rel1'=>'{Require:\'R\',Alert:\'Vui lòng chọn trạng thái \'}','style'=>'');
		$txt_show_index = addSelectList2('show_index',$arr_info_show_index,NULL,$Attr_show_index,$list_form,$show_index);
		
		if ($this->acl_per(2)){
			$arr_attr_btnadd = array('style'=>'color:blue;','onclick'=>'add()');
			$inp_btnadd = addInput2('button','btnadd',$btnadd,$arr_attr_btnadd,$list_form,'LƯU');
		}
		
		setMessage($list_form,$_msg);
		$list_form->assign('title'	,  	$_Title);
		$list_form->assign('_error_'	,  	$error);
		$list_form->assign('gridview'	,  	$gridview);		
		$list_form->assign('Id',$Id);
		$list_form->assign('token',$token);
		$list_form->parse('main');
		$html = $list_form->out_return('main');	
		echo $html;		
	}

	function rmenu(){
		return '';	
	}
	
	function getDetail($id){		
		$sSQL="select * from ntk_forum_posts where id = ".(int)$id;	
		$result = $this->db->query($sSQL, true, "Query failed");	
		$aR = $this->db->fetchByAssoc($result);
		return $aR;
	}
	function form_add($id,$menu_id,$title_vi,$title_en,$short_vi,$short_en,$content_vi,$content_en,$keyword_vi,$keyword_en,$status,$show_index){
		if($menu_id>0){
			$sSQL=" update ntk_forum_posts 
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
			where id = ".$menu_id;
			//echo "<hr>".$sSQL."<hr>";
			$result = $this->db->query($sSQL, true, "Query failed");
			return 1;
		}else{
			$sSQL = "insert into ntk_forum_posts (cid,title_vi,title_en,short_vi,short_en,content_vi,content_en,keyword_vi,keyword_en,`status`,`show_index`,create_date,create_date) 
			values(".(int)$menu_id.",N'".$title_vi."',N'".$title_en."',N'".$short_vi."',N'".$short_en."',N'".$content_vi."',N'".$content_en."',N'".$keyword_vi."',N'".$keyword_en."',".$status.",".$show_index.",'admin',NOW())
			";			
			$sSQLID = "select id from ntk_forum_posts where cid = ".(int)$menu_id." and title_vi = N'".$title_vi."' order by id desc limit 0,1
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
