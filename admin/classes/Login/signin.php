<?

class Login_Ext  extends Login
{
	function execute(){
		global $ts_config;
				
						
				$username=__post("username");
				$password=__post("password");
				if ($username!=''){
					$this->signin($username,$password);
					die();
				}

					ob_start();
					$display='';
					if ($_SESSION[_PLATFORM_]['KeyCode']=='')
					{
						$KeyCode=$this->encrypt_decrypt($this->generateCode(5));
						$_SESSION[_PLATFORM_]['KeyCode'] = $KeyCode;	
						$_SESSION[_PLATFORM_]['Login_Cnt'] = 0;		
									
					}
					if ($_SESSION[_PLATFORM_]['Login_Cnt']>=3){
						$display='1';
					}
					/*------LOGIN----------*/
					$error_arr['error']='Thông tin Username hoặc mật khẩu chưa hợp lệ !';
					$error_arr['scerror']='Mã bảo mật chưa hợp lệ !';
					$list_form = new XTemplate('Login/LoginForm.html');
					$keycode = $_SESSION[_PLATFORM_]['KeyCode'];
					$list_form->assign('display'	,$display);
					$list_form->assign('tourl'	,__post2('tourl'));
					$list_form->assign('error'	,$error_arr[$_GET['mode']]);
					$list_form->assign('keycode'	,$keycode);
					$list_form->assign('site_title'	,$ts_config['site_title']);
					$list_form->parse('main');
					$login_html = $list_form->out_return('main');	
					echo $login_html;		
											
					/*------LOGIN----------*/
					ob_end_flush();
	}

}
$seed = new Login_Ext();
$seed->execute();
?>