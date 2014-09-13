<?php
if(!defined('TSEntry') || !TSEntry) die('Not A Valid Entry Point');

/*
print("<pre>");
print_r($_GET);
die();
*/
/*if ($cla_cid == "news"){
	echo 'news detail';
}
else */
if ($cla_cid>0){
	page_news();
}
else{
	if ($cla_nid==0){		
		switch($pageUrl){
			case 'lien-he.html':
				echo 'lien he';
				break;
			case 'dang-nhap.html':
				$result = login();
				break;
			case 'dang-xuat.html':
				$result = logout();
				break;
			case 'dang-ky-thanh-vien.html':
				$result = register_form();
				break;
			case 'dang-ky.html':
				$result = register();
				break;
			case 'thong-tin-thanh-vien.html':							
				$result = member_info();
				break;
			default:
				echo 'Không tìm thấy trang này';
				break;
		}
	}else if ($cla_nid>0){
		echo 'aaa';
	}else{
		echo 'test';
	}
}



	/**/
	function member_info($update_success=false){		
		global $db,$fullsite,$cla_cid,$cla_nid,$cla_site;		
		if(isset($_POST['full_name'])){
			$update_success = false;		
			$email = $_SESSION[_PLATFORM_]['USER_INFO']['email'];
			$full_name = __post('full_name');
			$province_id = __post('province_id');
			$hospital_id = __post('hospital_id');
			$department_id = __post('department_id');
			if($full_name!=''){
				$sql = "
					update ntk_users
					set full_name = N'".$full_name."'
					,province_id = ".(int)$province_id."
					,department_id = ".(int)$department_id."
					,hospital_id = ".(int)$hospital_id."
					where email = '".$email."'
				";
				$result = $db->query($sql, true, "Query failed");	
				$update_success = true;				
				get_user_info($email,1);
			}else{
				$msg = "Cập nhật thông tin không thành công. Vui lòng kiểm tra lại thông tin.";			
			}
		}
		$user_info = $_SESSION[_PLATFORM_]['USER_INFO'];
		$province_list = get_list_province();
		$province_id = (int)$user_info['province_id'];
		$hospital_list = get_list_hospital($province_id);
		$department_list = get_list_department();
		include('themes/NTK/info.php');	
	}
	
	function register(){
		global $db,$fullsite,$cla_cid,$cla_nid,$cla_site;		
		$register_success = false;
		$email = __post('email');
		$password = __post('password');
		$re_password = __post('re_password');
		$full_name = __post('full_name');
		$province_id = __post('province_id');
		$hospital_id = __post('hospital_id');
		$department_id = __post('department_id');
		if($password==$re_password && $email!='' && $full_name!=''){
			$user_info = get_user_info($email);			
			if(is_array($user_info)){
				$msg = "Email đã tồn tại. Vui lòng kiểm tra lại thông tin.";
			}else{
				$password = md5($password);
				$sql = " insert into ntk_users(email,password,full_name,province_id,department_id,hospital_id)
					values('".$email."','".$password."',N'".$full_name."',".(int)$province_id.",".(int)$department_id.",".(int)$hospital_id.")
				";
				$result = $db->query($sql, true, "Query failed");			
				$user_info = get_user_info($email);
				if(is_array($user_info)){
					$msg = "Đăng ký thành công.";
					$_SESSION[_PLATFORM_]['is_login'] = true;
					$_SESSION[_PLATFORM_]['USER_INFO'] = $user_info;
					$register_success = true;
				}
			}			
		}else{
			$msg = "Đăng ký không thành công. Vui lòng kiểm tra lại thông tin.";			
		}
		register_form($msg,$register_success);
	}	
	
	function register_form($msg='',$register_success=false){	
		global $db,$fullsite,$cla_cid,$cla_nid,$cla_site;		
		$province_list = get_list_province();
		$hospital_list = get_list_hospital();
		$department_list = get_list_department();
		include('themes/NTK/register.php');
	}
		
	function get_list_province(){
		global $db;
		$sql = "select * from ntk_province order by 'order' asc ";
		$result = $db->query($sql, true, "Query failed");
		$list = array();
		while($aR = $db->fetchByAssoc($result)) {
			$list[] = $aR;
		}
		return $list;
	}
	function get_list_hospital($province_id=0){
		global $db;
		if($province_id>0){
			$sql = "select * from ntk_hospital where status = 1 and province_id =".(int)$province_id." order by 'order' asc";
		}else{
			$sql = "select * from ntk_hospital where status = 1 order by 'order' asc";
		}
		$result = $db->query($sql, true, "Query failed");
		$list = array();
		while($aR = $db->fetchByAssoc($result)) {
			$list[] = $aR;
		}
		return $list;
	}
	function get_list_department(){
		global $db;
		$sql = "select * from ntk_department order by 'order' asc";
		$result = $db->query($sql, true, "Query failed");
		$list = array();
		while($aR = $db->fetchByAssoc($result)) {
			$list[] = $aR;
		}
		return $list;
	}
	
	function get_user_info($email,$reset=0){
		global $db;
		if($reset==0 && is_array($_SESSION[_PLATFORM_]['USER_INFO'])){
			return $_SESSION[_PLATFORM_]['USER_INFO'];
		}
		$sql = "select * from ntk_users where email='".$email."' limit 0,1 ";
		$result = $db->query($sql, true, "Query failed");		
		if($aR = $db->fetchByAssoc($result)) { 
			$_SESSION[_PLATFORM_]['USER_INFO'] = $aR;
			return $aR;
		}		
	}
	function login(){		
		global $db,$fullsite,$cla_cid,$cla_nid,$cla_site;
		$email = __post('email');
		$password = md5(__post('password'));
		$sql = "select * from ntk_users where email='".$email."' and password='".$password."'";
		$result = $db->query($sql, true, "Query failed");
		$user_info = array();
		$is_login = false;
		if($aR = $db->fetchByAssoc($result)) { 
			if($aR['email'] ==$email && $password==$aR['password']){
				$is_login = true;
				$user_info = $aR;
			}
		}
		if($is_login){			
			$_SESSION[_PLATFORM_]['is_login'] = true;
			$_SESSION[_PLATFORM_]['USER_INFO'] = $user_info;
		}
	}
	function logout(){
		global $db,$fullsite,$cla_cid,$cla_nid,$cla_site;
		unset($_SESSION[_PLATFORM_]);
	}
	
	/**/

	function page_news(){
		global $db,$fullsite,$cla_cid,$cla_nid,$cla_site;
		if ((int)$cla_cid>0){
			$sql="SELECT * FROM ntk_news WHERE cid=".$cla_cid." ";
			if ((int)$cla_nid>0)
				$sql.=" AND id<=".$cla_nid;
			$sql.="ORDER BY news_order ASC,id DESC 	LIMIT 0,10 ";
			//echo $sql;
			$result = $db->query($sql, true, "Query failed");
			while ($aR = $db->fetchByAssoc($result)) {  
				echo '<div class="news_title">'.$aR['title'].'</div>';
				echo '<div><div class="news_date">20/07/2014</div><div class="news_download">
				<img src="'.$fullsite.'/images/word.png"> | <img src="'.$fullsite.'/images/pdf.png"> | <img src="'.$fullsite.'/images/printer.png">
				| <img src="'.$fullsite.'/images/letter.png"></div></div>'; 
				echo '<div class="news_short">'.$aR['short'].'</div>';
				echo '<hr size=1 style="color:#EFEFEF">';
			}
		
		}
	}