<?
if(!defined('TSEntry') || !TSEntry) die('Not A Valid Entry Point');

class Login extends TSDefault
{
	public $act;
	
	function signin($username,$password){
		global $ts_config;
		//$sSQL="update ws_user_detail set full_name=N'Quản trị hệ thống'";
		//$this->db->query($sSQL, true, "Query failed");	
		/*$tourl = __post('tourl');
		if (isset($tourl) && $tourl!=''){
			$_SESSION[_PLATFORM_]["AUTO"]['REDIRECT'] = base64_decode($tourl);
		}*/
		$ip = $_SERVER['REMOTE_ADDR'];
		$session_id = session_id();
		//$sSQL="exec web_login '".$username."','".$password."','$session_id','$ip'";	
		$sSQL = "select * from ntk_users where email = '".$username."' and password='".$password."' ";
		$result = $this->db->query($sSQL, true, "Query failed");		
		$type='error';		
		if ($_REQUEST['scode']!=$this->encrypt_decrypt($_SESSION[_PLATFORM_]['KeyCode']) && $_SESSION[_PLATFORM_]['Login_Cnt']>=3 ){
			$KeyCode=$this->encrypt_decrypt($this->generateCode(5));			
			$_SESSION[_PLATFORM_]['KeyCode'] = $KeyCode;	
			
			header('location:/admin?module=Login&action=signin&mode=sc'.$type.'&tourl='.$tourl);		
			die();
		}		
		while ($aRow = $this->db->fetchByAssoc($result))
		{			
			unset($_SESSION[_PLATFORM_]["CLA"]);
			$username = $aRow['email'];
			$pwd = $aRow['password'];
			$_SESSION[_PLATFORM_]["CLA"]["User_ID"]		= $aRow['id'];
			$_SESSION[_PLATFORM_]["CLA"]["Dept_ID"]	= $aRow['deptId'];
			$_SESSION[_PLATFORM_]["CLA"]["Full_Name"]		= $aRow['full_name'];
			$_SESSION[_PLATFORM_]["CLA"]["Login_Time"]		= time();

			$_SESSION[_PLATFORM_]["CLA"]["User_Name"]	= $username;
			$_SESSION[_PLATFORM_]["CLA"]["email"]	= $aRow['email'];
			$_SESSION[_PLATFORM_]["CLA"]["Role_ID"]	= $aRow['groupId'];
			$_SESSION[_PLATFORM_]['is_login'] = true;
			$info = $aRow;
			unset($info['password']);
			$_SESSION[_PLATFORM_]['USER_INFO'] = $info;
			// begin get user info
			/*$user_info = $this->fnc_get_user_info(1,$aRow['id'],false,0);
			if($user_info['result']==1){
				$_SESSION[_PLATFORM_]["CLA"]['user_info'] = $user_info['data'];
			}*/
			// end get user info
			/*if (!isset($_SESSION[_PLATFORM_]["CLA"]["RoleData"]))//if datarole
			{
				$rolers = $this->get_roleuserlist($aRow['userId']);
				$rolelist = array();
				$flagchk = false;
				//print "<pre>";
				while ($roledata = $this->db->fetchByAssoc($rolers))
				{
					$datalist = unserialize(base64_decode($roledata['role_data']));

					if ($flagchk==false){
						$rolelist = $datalist;
						$flagchk=true;
					}else{
						//print_r($datalist);
						foreach($datalist as $module=>$modulearr){
							foreach($modulearr as $kma=>$vlarr){
								if (!is_array($rolelist[$module][$kma])){
									$rolelist[$module][$kma]=$vlarr;
								}else{
									$bin = 1;
									while($bin<=$vlarr[0]){
										//process
										$oldbin = $rolelist[$module][$kma][0];
										$flag1 = $bin&$vlarr[0];
										$flag2 = $oldbin&$bin;
										if ($flag1>0 && $flag2<=0){
											$rolelist[$module][$kma][0]+=$bin;
										}//end if									
										$bin=$bin*2;								
									}//end while							
								}//end else if											
							}//end foreach
						}//end foreach				
					}//end else if
				}//end while
				$_SESSION[_PLATFORM_]["CLA"]["RoleData"] =  $rolelist;

			}//end if datarole
			*/
			$_SESSION[_PLATFORM_]["CLA"]["isAdmin"] = -1;
			$_SESSION[_PLATFORM_]["CLA"]["SecurityCode"] =$_SESSION[_PLATFORM_]["CLA"]["User_ID"].'|'.$_SESSION[_PLATFORM_]["CLA"]["Shop_ID"].'|'.$_SESSION[_PLATFORM_]["CLA"]["Role_ID"];
			if ($username=='admin' || $aRow['isAdmin']==1){
				$_SESSION[_PLATFORM_]["CLA"]["isAdmin"]=1;
			}			
			//$this->s_role($_SESSION[_PLATFORM_]["CLA"]["RoleData"]);
		}	

		if ($pwd!='' && $pwd==$password){


			if ($_SESSION[_PLATFORM_]["AUTO"]['REDIRECT']!='')
			{
				$_SESSION[_PLATFORM_]['KeyCode']="";
				$_SESSION[_PLATFORM_]['Login_Cnt'] = 0;
				$redirect=$_SESSION[_PLATFORM_]["AUTO"]['REDIRECT'];
				unset($_SESSION[_PLATFORM_]["AUTO"]);
				header('location:'.$redirect);	
			}
			else{			
				$_SESSION[_PLATFORM_]['KeyCode']="";
				$_SESSION[_PLATFORM_]['Login_Cnt'] = 0;			
				header('location:'.$ts_config['site_url_admin'].'?module=Config&action=News');				
			}
			
			die();
		}
		$_SESSION[_PLATFORM_]['Login_Cnt'] = $_SESSION[_PLATFORM_]['Login_Cnt']+1;
		header('location:'.$ts_config['site_url_admin'].'?module=Login&action=signin&cnt='.$_SESSION[_PLATFORM_]['Login_Cnt'].'&mode='.$type.'&tourl='.$tourl);
	}
	
	function define(){
		$this->dont_check_user = true;
	
	}	
	
	function signout(){
		global $ts_config;
		$username = get_username();
		$ip = $_SERVER['REMOTE_ADDR'];
		$session_id = session_id();
		//$sSQL="exec web_logout '".$username."','$session_id','$ip','".$_SESSION[_PLATFORM_]["CLA"]["Login_Time"]."'";		
		//$result = $this->db->query($sSQL, true, "Query failed");
		session_destroy();		
		unset($_SESSION[_PLATFORM_]["CLA"]);
		unset($_SESSION[_PLATFORM_]['KeyCode']);
		unset($_SESSION[_PLATFORM_]['LOGIN_CNT']);	
		session_regenerate_id(true);
		header('location:'.$ts_config['site_url_admin']);die();
	}
	
	
	function s_role($role_id){		
			if (trim($_SESSION[_PLATFORM_]["CLA"]["Role_ID"])!='')
			{	
	//print_r($_SESSION["CLA"]);
			}			
	}
	
	
	function execute(){
		$_act = $_GET['action'];
		$username=$_POST["username"];
		$password=$_POST["password"];
		$this->act = $_act;
		if ($_act=='signin'){			
			$this-> signin($username,$password);	
		}
		else if ($_act=='signout'){
			$this-> signout();
		
		}		
	}
	
	function error(){
		if ($this->act=='welcome'){echo 'Welcome to Administrator';}
		if ($this->act=='error'){echo '<div><font color=red>Login attempt failed please check the username and password</font><br><br></div>';}
	
	}

	function get_roleuserlist($id){
		$sSQL="exec web_role_user_list -1,$id";
		//echo $sSQL;
		$result = $this->db->query($sSQL, true, "Query failed");					
		return $result;
		
	}
}

?>