<?
if(!defined('TSEntry') || !TSEntry) die('Not A Valid Entry Point');
class TSDefault
{

	public $db;
	public $dbi;
	public $html;
	public $action;
	public $ajmodw;
	public $pagemode;
	public $formmode;
	public $module;
	public $dont_check_user = false;
	public $AuthSum = 'TSL2012';
	public $RMenu = '';
	public $userName;
	public $userId;
	public $tabName;
	public $prefix = array();
	
	function TSDefault(){
		global $cla_action,$cla_module;
		$this->db = DBManagerFactory::getInstance();
		$this->db->resetQueryCount();
		

		$this->action = $cla_action;
		$this->module = $cla_module;
		$this->formaction = $_POST['formaction']!=''?$_POST['formaction']:$_GET['formaction'];
		$this->ajmode = $_POST['ajmode']!=''?$_POST['ajmode']:$_GET['ajmode'];
		$this->pagemode =  $_POST['mode_inpvl']!=''?$_POST['mode_inpvl']:$_GET['mode_inpvl'];
		$this->formmode =  $_POST['formmode']!=''?$_POST['formmode']:$_GET['formmode'];
		$this->userName = $_SESSION[_PLATFORM_]["CLA"]["User_Name"];
		$this->userId = $_SESSION[_PLATFORM_]["CLA"]["User_ID"];

		$this->prefix = array(
			'edit'=>'edit'.$this->module.$this->action
			,'delete'=>'delete'.$this->module.$this->action
			,'approve'=>'approve'.$this->module.$this->action
			,'active'=>'active'.$this->module.$this->action
		);

	}
	
	function siteHeader(){
		return '';
	}

	function siteFooter(){
		return '';
	}


	function scriptHeader(){
		return '';
	}
	function execute(){
		global $cla_module;
		ob_start();
		if ($cla_module=='TSDefault'){

		$list_form = new XTemplate('Home.html');

		$list_form->assign('table'	,  	$table);

		$list_form->parse('main');
		$this->html = $list_form->out_return('main');	
			
		
	
		}
		
		ob_end_flush();	
	}
	
	function template(){

		$html='
			<div class="page-title ui-widget-content ui-corner-all">
					<h1>Welcome to </h1>
					<div class="other">

						';

		


		$html.='				
						';
		$html.=$this->html;						
		$html.='<div class="clearfix"></div></div>
					

				</div>			
		
		';
		
		
		echo $html;
		
	}
	
	function role(){		
		global $cla_module;
		/*---------------------------------------------*/
		if ($this->dont_check_user!=true && $_SESSION[_PLATFORM_]["CLA"]["isAdmin"]!=1){			
			$RoleData = $_SESSION[_PLATFORM_]["CLA"]['RoleData'];
			//print_r($RoleData);
			if (array_key_exists($cla_module,$RoleData)){
					if ($_SERVER['QUERY_STRING']!='');
					{
						$_SESSION[_PLATFORM_]["AUTO"]['REDIRECT'] = 'do?'.$_SERVER['QUERY_STRING'];
					}				
			}else{
					header('location:do?module=Error&err=530');
					ts_die('You do not  have permission to view this page');						
			}
		}
		/*---------------------------------------------*/
	}	
	

	function acl_access($action='',$module=''){	
		
		global $cla_module,$cla_action,$action_allow;
		if ($module=='')
			$module = $cla_module; 

		if ($action=='')
			$action = $cla_action;
		/*---------------------------------------------*/
		if (is_admin()>0 || $this->dont_check_user==true || $action=='Ajax' || $action=='index' || $action_allow[$module][$action]==1){
			return true;
		}else{
			$RoleData = $_SESSION[_PLATFORM_]["CLA"]['RoleData'];
			if (is_array($RoleData[$module][$module.'_'.$action])){
				return true;
			}
		}
		return false;
		/*---------------------------------------------*/
	}

	function acl_per($per=-1,$action='',$module=''){
		global $cla_module,$cla_action;
		if ($module=='')
			$module = $cla_module; 

		if ($action=='')
			$action = $cla_action;
		/*---------------------------------------------*/
		$RoleData = $_SESSION[_PLATFORM_]["CLA"]['RoleData'];
		if (is_admin()>0){
			return true;
		}else{
			$RoleData = $_SESSION[_PLATFORM_]["CLA"]['RoleData'];
			$binary = $RoleData[$module][$module.'_'.$action][0];
			if ($binary=='')
				$binary=0;
			$flag = $binary&$per;
			if ($flag>0){return true;}
			else {return false;}
		}
		return false;		
	}



	function per_role($txt=1,$per=-1,$action,$module=''){
		global $cla_module,$cla_action;
		if ($module=='')
			$module = $cla_module; 

		if ($action=='')
			$action = $cla_action;
		/*---------------------------------------------*/
		$RoleData = $_SESSION[_PLATFORM_]["CLA"]['RoleData'];
		if (is_admin()>0){
			return $txt;
		}else{			
			$binary = $RoleData[$module][$module.'_'.$action][0];
			if ($binary=='')
				$binary=0;
			$flag = $binary&$per;
			if ($flag>0){return $txt;}
			else {return '';}
		}
		return '';		
	}
	
	function rmenu(){
		return '';
	}
	
	function slide_bar($left_menu=''){
		$SLIDE_BAR = '<div id="sidebar"><div class="side-col ui-sortable"><!--SildeBarMenu-->';
		if ($left_menu!=''){
			$SLIDE_BAR.='<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all">
				<div class="portlet-header ui-widget-header">Danh mục</div>
				<div class="portlet-content">
					<ul class="side-menu" id="style-switcher" style="line-height:18px">'.$left_menu.'									
					</ul>
				</div>
				</div>';
			}
		$SLIDE_BAR.='<!--SildeBarMenu-->
		<div id="favorite_bar" style="display:none" class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all">
				<div class="portlet-header ui-widget-header"><span>Link thường dùng</span>&nbsp;<a href="#" title="Đánh dấu trang"><span class="ui-icon ui-icon-plus">+</span></a></div>
				<div class="portlet-content">
					<ul style="line-height:13px" id="favorite-area" class="side-menu">&nbsp;									
					</ul>
				</div>
		</div>
		<div id="datepicker" ></div>
		<!--Calendar--></div><div class="clearfix"></div></div>';
		return $SLIDE_BAR;
	}




	function error(){}
	function define(){
		$this->dont_check_user = true;	
	}
	
	
	function _fnSortOrderBy(){
		$tmp='
					<input type="hidden" name="_SortOrderBy" id="_SortOrderBy"  value="'.$_POST['_SortOrderBy'].'">
					<input type="hidden" name="_OrderDirection" id="_OrderDirection"  value="'.$_POST['_OrderDirection'].'">
					<script>
					function fnOrder(_col){
						var frm = document.form1;	
						var _ord = $("#_SortOrderBy");
						var _orddir = $("#_OrderDirection");
						if (_ord.val()==""){_ord.val(_col);	_orddir.val("asc")}
						if (_ord.val()==_col){
							if (_orddir.val()=="asc")
								{_orddir.val("desc")}
							else
							 	{ _orddir.val("asc")}
						}
						if (_ord.val()!=_col){
							_ord.val(_col)
							_orddir.val("asc")
						}
						frm.submit();						
					}
					
					
					</script>'	;		
		
		return $tmp;
	}
	
	function setPaging(){
		if ($this->TotalPage>0)
		{	
			$_Paging='<table width=100% cellpadding=0 cellspacing=0><tr><td colspan=100 align=left>'.$this->Paging($this->TotalPage,$this->PageIndex,'form1').'</td></tr></table>';
		}
		return $_Paging;
	}

	function setFooter(){$_Footer='</table></div></div>';return $_Footer;}		
	
	function PageHeader($first_row,$last_row){	
		$PageArr = array('10','20','50','100','200','500','1000','2000','5000','100000');
		$_PageHeader='
				
				
				<table width="100%" style="width:100%">
					<tr><td colspan=100>'.$first_row.'</td></tr>
				    <tr>
				         <td align=left style="text-align:left;;vertical-align:;vertical-align:middle" colspan=100>
						 <div class="fg-toolbar ui-widget-header_table ui-corner-tl ui-corner-tr ui-helper-clearfix" style=";vertical-align:;vertical-align:middle;height:30px">
							<div id="example_length" class="dataTables_length" style="color:#FFFFFF;float:left">
								&nbsp;Số dòng  
									<select name="ddlPageSize" id="ddlPageSize"  onchange="document.form1.submit()" >';
									for ($i=0;$i<count($PageArr);$i++){
									$slted='';
									if 	($PageArr[$i]==$_POST['ddlPageSize'])
									{
										$slted=' selected ';
									}
									
									$_PageHeader.='<option value="'.$PageArr[$i].'" '.$slted.'>'.$PageArr[$i].'</option>';
									}
									
									$_PageHeader.='	</select>/ trang							
											
							</div>
							<div style="float:right;display:none">
							<ul style="padding:0px 0px 0px 0px;height: 30px;">
								 <li class="dropdown"  style="padding:0px 5px 0px 10px;height:30px;">
											<a href="#" class="btn1 btn1-sm default1 js-activated">Dropdown <b class="caret"></b></a>
											<div class="dropdown-menu hold-on-click dropdown-checkboxes pull-right">
											  <label><input type="checkbox" /> Finance</label>											  
										   </div>
								</li></ul>
							</div>

						</div>						 
						 

				         </td>
				    </tr>
					<tr><td colspan=100>'.$last_row.'</td></tr>
				</table>';				
		$_PageHeader.=$this->_fnSortOrderBy();				
		return 	$_PageHeader;	
	}	
	
	function Paging($totalPages=0,$currentPage=0,$formName='')
	{
		global $vportal;
		$form = ($formName!=""&&$formName!=null) ? $formName : "forms[0]";
		$strPaging = '
    <style type="text/css">

        
        .dropdown dd, .dropdown dt, .dropdown ul { margin:0px; padding:0px; }
        .dropdown dd { position:relative; }
        .dropdown a, .dropdown a:visited {  text-decoration:none; outline:none;}
        .dropdown a:hover { color:#5d4617;}
        .dropdown dt a:hover { color:#5d4617; border: 1px solid #CCCCCC; }
        .dropdown dt a {
					    display:block;
                        border:1px solid #CCCCCC; width:150px;}
        .dropdown dt a span {cursor:pointer; display:block;}
        .dropdown dd ul { background:#e4dfcb none repeat scroll 0 0; 
						  border:1px solid #d4ca9a; color:#000000; display:none;
                          left:0px;  
						  position:absolute;  width:auto; 
						   list-style:none; }
        .dropdown span.value { display:none;}
        .dropdown dd ul li a {  display:block;}
        .dropdown dd ul li a:hover { background-color:#d0c9af;}        
        .dropdown img.flag { border:none; vertical-align:middle;  } 
        
    </style>		
		
    <script type="text/javascript">
        $(document).ready(function() {

            $(".dropdown dt a").click(function() {
                $(".dropdown dd ul").toggle();
            });          

            $(document).bind(\'click\', function(e) {
                var $clicked = $(e.target);
                if (! $clicked.parents().hasClass("dropdown"))
                    $(".dropdown dd ul").hide();
            });
			
            $("#flagSwitcher").click(function() {
                $(".dropdown img.flag").toggleClass("flagvisibility");
            });
        });
    </script>	
		
		<div class="fg-toolbar ui-widget-header_table ui-corner-bl ui-corner-br ui-helper-clearfix">
		<table border=10 cellpadding=10 cellspacing=10 width=100%><tr><td align=right  style=\"color:#FFFFFF\">
		
		<table border=0 cellpadding=0 cellspacing=0 align=left><tr><td>&nbsp;</td>
		
		
	
		';

			
			
			
			

		
		$pSegment = 5;
		if (is_numeric($totalPages))
		{
			$totalSegment = ceil($totalPages/$pSegment);
			$currentSegment = ceil($currentPage/$pSegment);
			$startPage = (($currentSegment-1)*$pSegment) + 1;
			$endPage = $currentSegment * $pSegment;
			$maxPage = ($endPage>$totalPages) ? $totalPages : $endPage;
			if ($currentPage>1)
				$strPaging .= "<td><a href=\"#Trang đầu\" onclick=\"document.$form.page.value='1';document.$form.submit();\"><img src=\"../images/first.png\" border=0 title='First'></a></td>";
			//else
			//	$strPaging .= "<img src=\"".$vportal->vars["site_url"]."/../images/first_gr.png\"> ";
			if ($currentSegment>1)
				$strPaging .= "<td><a href=\"#Trang trước\" onclick=\"document.$form.page.value='".($currentSegment-1)*$pSegment."';document.$form.submit();\"><img src=\"../images/prevjump.png\" border=0  title='Prev'></a></td>";
			//else
			//	$strPaging .= "<img src=\"".$vportal->vars["site_url"]."/../images/prevjump_gr.png\"> ";
			if ($currentPage>1)
				$strPaging .= "<td><a href=\"#Trang trước\" onclick=\"document.$form.page.value='".($currentPage-1)."';document.$form.submit();\"><img src=\"../images/prev.png\" border=0  title='Prev'></a></td>";
			//else
			//	$strPaging .= "<img src=\"".$vportal->vars["site_url"]."/../images/prev_gr.png\"> ";
			
			for ($i=$startPage;$i<=$maxPage;$i++)
			{
				if ($currentPage==$i)
					$strPaging .= '<td><div ><input type="text" class="pgCurrent" value="'.$i.'" alt="integer" readonly style="width:40px;text-align:center"></div></td>';
				else
					$strPaging .= '<td><a href="#Trang '.$i.'"  onclick="document.'.$form.'.page.value=\''.$i.'\';document.'.$form.'.submit();" 	>&nbsp;&nbsp;'.$i.'&nbsp;&nbsp;</a></td>';
			}
			
			if ($currentPage<$totalPages)
				$strPaging .= "<td><a href=\"#Trang trước\" style=\"text-decoration:none\" onclick=\"document.$form.page.value='".($currentPage+1)."';document.$form.submit();\"><img src=\"../images/next.png\" border=0 title='Next'></a></td>";
			//else
			//	$strPaging .= "<img src=\"".$vportal->vars["site_url"]."/../images/next_gr.png\"> ";
			if ($currentSegment<$totalSegment)
				$strPaging .= "<td><a href=\"#Trang sau\"  style=\"text-decoration:none\"  onclick=\"document.$form.page.value='".($currentSegment*$pSegment+1)."';document.$form.submit();\"><img src=\"../images/nextjump.png\" border=0  title='Next'></a></td>";
			//else
			//	$strPaging .= "<li class='pgNext pgEmpty'>kế</li> ";
			if ($currentPage<$totalPages)
				$strPaging .= "<td><a href=\"#Trang cuối\" style=\"text-decoration:none\" onclick=\"document.$form.page.value='".$totalPages."';document.$form.submit();\"><img src=\"../images/last.png\" border=0  title='Last'></a></td>";
			//else
			//	$strPaging .= "<img src=\"".$vportal->vars["site_url"]."/../images/last_gr.png\"> ";
		}
		
		
		
		$strPaging .= "<td align=left>
			
		
		<dl id=\"sample\" class=\"dropdown\">
        <dt ><a  style=\"width:80px\" href=javascript:><span ><b>&nbsp;CHUYỂN&nbsp;ĐẾN</b></span></a></dt>
        <dd>
            <ul>
                <li>
				<table width=120 cellpadding=0 cellspacing=0 border=0><tr><td>
				Trang ...<br>
				<input type=\"text\"  value=\"".$currentPage."\" alt=\"integer\" id=\"iCurrentPage\" name=\"iCurrentPage\"  style=\"width:30px; height:20px;\">
				<input type=button value=\"GO\" style=\"text-align:top\"  onclick=\" if (document.$form.iCurrentPage.value==''){document.$form.iCurrentPage.value=1;};document.$form.page.value=document.$form.iCurrentPage.value;  document.$form.submit();\">
				</td></tr></table>
								
				</li>
            </ul>
        </dd>
    	</dl>		
		</td></tr></table></td><td style=\"text-align:right;color:#FFFFFF;vertical-align:middle\">
					<div  class=\"dataTables_info\" id=\"example_info\">Tổng số trang ".number_format($this->TotalPage, 0, '.', ',')."(".number_format($this->TotalRecord, 0, '.', ',')." dòng)&nbsp;
					
					
					
					</div>
		</td></tr></table></div>";		
		
		
		return $strPaging;
	}

	function ExportToExcel($filename='',$exportStr='') {
		


		$Date		= time();
		$exportContent =  	"<html>
							<head>
							<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" /> 							
							</head>
							<body>
								$exportStr
							</body>
							</html>";
		header('HTTP/1.1 200 OK');
		header('Cache-Control: public, must-revalidate');
		header('Expires: '.gmdate('D, d M Y H:i:s', $Date).' GMT');
		header('Date: ' . date("D M j G:i:s T Y", $Date));
		header('Last-Modified: ' . date("D M j G:i:s T Y", $Date));
		header('Content-type: applicationnd.ms-excel;charset=utf-8');
		header("Content-Transfer-Encoding: binary");
		header('Content-type:charset=utf-8');
		header('Content-Disposition: attachment; filename="'.$filename.'.xls"'); 
		print $exportContent;
		exit;
	}	
	
	function md5sum($txt,$session_id = true){
		$key=0;
		if ($session_id)
			$key=session_id().$_SESSION[_PLATFORM_]["CLA"]["User_Name"];
		return md5($key.$this->AuthSum.$txt.$this->AuthSum);
	}
	
	function md5sum_check2($txt,$sumVar,$session_id = true){		


		$sum = $_POST[$sumVar]!=''?$_POST[$sumVar]:$_GET[$sumVar];
		if (($sum!='' && $this->md5sum($txt,$session_id)==$sum)){
			$flag=true;
		}else
			{
				$flag=false;	
			}
		return $flag;		
	}

	function md5sum_check($txt,$session_id = true){		
		$chksum = $_POST['chksum']!=''?$_POST['chksum']:$_GET['chksum'];
		$token = $_POST['token']!=''?$_POST['token']:$_GET['token'];



		if (($chksum!='' && $this->md5sum($txt,$session_id)==$chksum) || ($token!='' && $this->md5sum($txt,$session_id)==$token)){
			$flag=true;
		}else
			{
				$flag=false;	
			}
		return $flag;		
	}

	function md5sum_check_die($txt,$session_id = true){		
		$chksum = $_POST['chksum']!=''?$_POST['chksum']:$_GET['chksum'];
		$token = $_POST['token']!=''?$_POST['token']:$_GET['token'];
		if (($chksum!='' && $this->md5sum($txt,$session_id)==$chksum) || ($token!='' && $this->md5sum($txt,$session_id)==$token)){
			$flag=true;
		}else
			{
				$flag=flase;	
				header('location:do?module=Error&err=2');			
				die('<div style="color:red">You do not have access to this area. Contact your site administrator to obtain access.</div>');
			}
		return $flag;		
	}	
	

	/*--HoangHD--*/
	function get_template($template){			
			if (is_file('classes/templates/'.$template.'.html')){				
				$template =  new XTemplate('../templates/'.$template.'.html');
				$template->assign('frm_input'	,  	$_SESSION['FRM_INPUT']);
				$template->parse('main');
				return $template->out_return('main');	
			
			}else{
				return '';
			}
	}

	function set_leftmenu($module='',$tab_file='menus.php',$url_ext = array(),$unset_tab = array()){
		global $fsystem,$cla_module,$cla_action;
		 if ($module=='')
			 $module = $cla_module;
		 /*------Tabs-----------------*/		 
		 $tabs_file = 'classes/'.$cla_module.'/menus.php';
		 $tabs_flag= false;
		 if (is_file($tabs_file)){
		 	require_once($tabs_file);	
			$tabs_array = is_array($leftmenu_array_action[$cla_action])?$leftmenu_array_action[$cla_action]:$leftmenu_array;				
			if (is_array($tabs_array))
			{	
				foreach($unset_tab as $k=>$l){
					unset($tabs_array[$l]);	
				}
				
				$active_page = $_REQUEST['action']==''?$tabs_array['index']:$_REQUEST['action'];		
				
				//$tindex[$index]=' ui-tabs-selected ui-state-active';
				
				$tmp='';
				foreach ($tabs_array as $key=>$val)
				{		
					if ($key!='index'){	
							if (is_admin()<0){
								$RoleData = $_SESSION[_PLATFORM_]["CLA"]['RoleData'];								
								if (!is_array($RoleData[$module][$module.'_'.$key])){									
									unset($tabs_array[$key]);
								}						
							}
					}
				}
				foreach ($tabs_array as $key=>$val)
				{
						if ($key!='index'){
							if (isset($tabs_array[$cla_action]))
							{
								$acted = '';
								if ($cla_action==$key || $tabs_array_maps[$cla_action]==$key ){
									$acted = ' active';
								}

								$tmp.='<li class="'.$acted.'" rel="'.$key.'" ><a href="?module='.$module.'&action='.$key.''.$url_ext[$module].'" style="cursor:pointer"><span>'.$val.'</span></a></li>';							

								$tabs_flag= true;	
							}
											
						}
						
						
						
				}		
				$tmp.='';
			}	 
		 }
		 /*------Tabs-----------------*/	
		 $arr[0]=$tabs_flag;
		 $arr[1]=$tmp;
		 return $tmp;		
	
	}

	function set_tabs($module='',$tab_file='tabs.php',$url_ext = array(),$unset_tab = array()){
		 global $fsystem,$cla_module,$cla_action;
		 if ($module=='')
			 $module = $cla_module;
		 /*------Tabs-----------------*/		 
		 $tabs_file = admin_dir.'classes/'.$cla_module.'/tabs.php';		 
		 $tabs_flag= false;
		 if (is_file($tabs_file)){
		 	require_once($tabs_file);				
			$tabs_array = is_array($tabs_array_action[$module][$cla_action])?$tabs_array_action[$module][$cla_action]:$tabs_array[$module];
			$tabs_array_maps = $tabs_array_maps[$module];
			//print_r($tabs_array);die("end".$cla_action);
			if (is_array($tabs_array))
			{		
		
				foreach($unset_tab as $k=>$l){
					unset($tabs_array[$l]);	
				}
				
				$active_page = $_REQUEST['action']==''?$tabs_array['index']:$_REQUEST['action'];		
				
				//$tindex[$index]=' ui-tabs-selected ui-state-active';
				$tmp='<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" id="systab" style="height:25px">';
				foreach ($tabs_array as $key=>$val)
				{		
					if ($key!='index' && $val!=''){	
							if (is_admin()<0){
								$RoleData = $_SESSION[_PLATFORM_]["CLA"]['RoleData'];								
								if (!is_array($RoleData[$module][$module.'_'.$key])){									
									unset($tabs_array[$key]);
								}						
							}
					}
				}
				
				foreach ($tabs_array as $key=>$val)
				{
						if ($key!='index' && $val!=''){
							if (isset($tabs_array[$cla_action]))
							{
								$acted = '';
								if ($cla_action==$key || $tabs_array_maps[$cla_action]==$key ){
									$acted = ' ui-tabs-selected ui-state-active';
								}

								$tmp.='<li class="ui-state-default ui-corner-top'.$acted.'" rel="'.$key.'" ><a href="?module='.$module.'&action='.$key.''.$url_ext[$module].'" style="cursor:pointer"><span>'.$val.'</span></a></li>';							

								$tabs_flag= true;	
							}
											
						}
						
						
						
				}		
				$tmp.='</ul>';
			}	 
		 }
		
		if ($tabs_flag==false)
		{
				$tabs_flag= true;
				$tmp='<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" id="systab" style="height:25px">';	
				$tmp.='<li class="ui-state-default ui-corner-top  ui-tabs-selected ui-state-active" rel="list" ><a href="#" style="cursor:pointer"><span>Thông tin nhân viên</span></a></li>';	
				$tmp.='</ul>';
		 
		 }
		 /*------Tabs-----------------*/	
		 $arr[0]=$tabs_flag;
		 $arr[1]=$tmp;
		 return $tmp;		
	}


//=========button permission===============================================================//
	/*
		$Attr_Account = array();
		$uaccount = cInput('button','btn2',$u_account,$Attr_Account,$list_form);	
	
	*/
    function cInput($type, $name, $value, $attr_ar = array(),$OBJ,$module = '') { 
		global $cla_module;
		if (trim($value)=='')
		{
			$value = $_POST[$name];
		}	
	
        $str = "<input type=\"$type\" name=\"$name\" id=\"$name\" value=\"$value\""; 
        if ($attr_ar) { 
            $str .= addAttributes( $attr_ar ); 
        } 
        $str .= ' />'; 
		
		
		if ($module==''){
			$module = $cla_module;
		}	
		
		if ($_SESSION["CLA"]["User_Name"]!='admin'  && $this->dont_check_user!=true ){			
			
			$p_per = $_SESSION["CLA"]['Role_Data'][$module];				
			if ($p_per!=1){		
				$str='';		
			}
		}		
		
		$OBJ->assign('_'.$name,$str);
        return $str; 
    } 


	/*
		$btn='<input type=button value="New Promotion"><br><br>';		
		$btn = cInputText($btn);	
	
	*/

    function cPanelText($InputTxt,$module = '',$dont_check_user) { 
		global $cla_module;
		if ($module==''){
			$module = $cla_module;
		}
		if ($_SESSION[_PLATFORM_]["CLA"]["User_Name"]!='admin'  && $dont_check_user!=true){
			
			$p_per = $_SESSION[_PLATFORM_]["CLA"]['Role_Data'][$module];				
			if ($p_per!=1){		
				$InputTxt='';		
			}				
		}
        return $InputTxt; 
    }


	/*
		$btn='<input type=button value="New Promotion"><br><br>';		
		$btn = cInputText($btn);	
	
	*/

    function cInputText($InputTxt,$module = '') { 
		global $cla_module;
		if ($module==''){
			$module = $cla_module;
		}
		if ($_SESSION[_PLATFORM_]["CLA"]["User_Name"]!='admin'  && $this->dont_check_user!=true ){
			
			$p_per = $_SESSION[_PLATFORM_]["CLA"]['Role_Data'][$module];				
			if ($p_per!=1){		
				$InputTxt='';		
			}				
		}
        return $InputTxt; 
    }
	
	
	/*
	$Title="Link";
	$Href="http://www.yahoo.com";		
	echo cHref($Title,$Href);
	*/
	
	function cHref($Title,$InputHref,$module = '',$style='') { 
		global $cla_module;
		if ($module==''){
			$module = $cla_module;
		}
		
		$OutHref = '<a href="'.$InputHref.'" '.$style.'>'.$Title.'</a>';
		if ($_SESSION[_PLATFORM_]["CLA"]["User_Name"]!='admin'  && $this->dont_check_user!=true){		
			
			$p_per = $_SESSION[_PLATFORM_]["CLA"]['Role_Data'][$module];				
			if ($p_per!=1){		
				$OutHref=$Title;		
			}				
	
		}
        return $OutHref; 
    } 
//=========================================================================//	
	
	
	/*
		$Attr_Account = array();
		$uaccount = cInput2('button','btn2',$u_account,$Attr_Account,$list_form,8);	
	
	*/
    function cInput2($type, $name, $value, $attr_ar = array(),$OBJ,$permission) { 
		global $cla_module;
		if (trim($value)=='')		{
			$value = $_POST[$name];
		}	
	
        $str = "<input type=\"$type\" name=\"$name\" id=\"$name\" value=\"$value\""; 
        if ($attr_ar) { 
            $str .= addAttributes( $attr_ar ); 
        } 
        $str .= ' />'; 

		$module = $cla_module;
		
		if ($_SESSION[_PLATFORM_]["CLA"]["User_Name"]!='admin'  && $this->dont_check_user!=true ){			
			
			$p_per = $_SESSION[_PLATFORM_]["CLA"]['RoleData'][$module];	
			
			$tmp=$p_per&$permission;
			if ($tmp==0){		
				$str='';		
			}
		}		
		
		$OBJ->assign('_'.$name,$str);
        return $str; 
    } 


	/*
		$btn='<input type=button value="New Promotion"><br><br>';		
		$btn = cInputText2($btn,8);	
	
	*/

    function cInputText2($InputTxt,$permission=0) { 
		global $cla_module;
		$module = $cla_module;
		//print "<pre>";
		//print_r($_SESSION["CLA"]['RoleData']);
		if ($_SESSION[_PLATFORM_]["CLA"]["User_Name"]!='admin'  && $this->dont_check_user!=true ){
			
			$p_per = $_SESSION[_PLATFORM_]["CLA"]['RoleData'][$module];		
			
			$tmp=$p_per&$permission;		
			if ($tmp==0){		
				$InputTxt='';		
			}				
		}
        return $InputTxt; 
    }
	
	
	/*
	$Title="Link";
	$Href="http://www.yahoo.com";		
	echo cHref2($Title,$Href,8);
	*/
	
	function cHref2($Title,$InputHref,$permission = 0,$style='') { 
		global $cla_module;
		$module = $cla_module;
		
		$OutHref = '<a href="'.$InputHref.'" '.$style.'>'.$Title.'</a>';
		if ($_SESSION[_PLATFORM_]["CLA"]["User_Name"]!='admin'  && $this->dont_check_user!=true){		
			
			$p_per = $_SESSION[_PLATFORM_]["CLA"]['RoleData'][$module];	
			$tmp=$p_per&$permission;		
			if ($tmp==0){								
				$OutHref=$Title;		
			}				
	
		}
        return $OutHref; 
    } 
//=========================================================================//		
	

	function _Menu(){
		global $menu_site,$module_install;
		if (!isset($_SESSION[_PLATFORM_]["CLA"]['Menu']))//if menu
		{
			$RoleData = $_SESSION[_PLATFORM_]["CLA"]['RoleData'];
			$tmp='';
			//while ($aRow = $this->db->fetchByAssoc($result))
			foreach($module_install as $module_folder=>$module_desc)
				{			
					$tmpsub='';
					foreach($menu_site[$module_folder] as $action=>$action_name)
						{							
								//$_SESSION["CLA"]['Menu'][$module_folder]['Menu'][$action]=$action_name;
								$_txtmenu='<li  ><a href="do?module='.$module_folder.'&action='.$action.'">'.$action_name.'</a></li>'.chr(13);
								if ($_SESSION[_PLATFORM_]["CLA"]["isAdmin"]==-1){
									if (!is_array($RoleData[$module_folder][$module_folder.'_'.$action])){
										$_txtmenu='';	
										//unset($_SESSION["CLA"]['Menu'][$module_folder]['Menu'][$action]);
									}
								}
									
								$tmpsub.=$_txtmenu;						
											
						}
					if ($tmpsub!='')
					{
						//$_SESSION["CLA"]['Menu'][$module_folder]['Name'] = $module_desc;
						$tmp.='<li ><a href="#">'.$module_desc.'</a>'.chr(13);
						$tmp.='<ul style="display:none">'.chr(13);	
						$tmp.=$tmpsub;
						$tmp.='</ul>';
						$tmp.='</li>'.chr(13);										
					}
				}	
				
				if ($tmp!=''){
					$_SESSION[_PLATFORM_]["CLA"]['Menu']=$tmp;			
				}
			}//end if menu
			else{
			$tmp=$_SESSION[_PLATFORM_]["CLA"]['Menu'];
			}
			

		return $tmp;
		
		
	}
	

	//_Menu2(-1,0,'');
	function _Menu2($parent_id=-1,$step=0,$name){		
		/*
		$RoleData = $_SESSION[_PLATFORM_]["CLA"]['RoleData'];
		if (!isset($_SESSION[_PLATFORM_]["CLA"]['TopLeftLinkType']) || (int)$_SESSION[_PLATFORM_]["CLA"]['TopLeftLinkType']==0){
			$_SESSION[_PLATFORM_]["CLA"]['TopLeftLinkType'] = 1;
		}
		//print "<pre>";
		//print_r($RoleData);
		$sql="exec sys_level_rebuild_list 'ws_rf_menu','parent_id',".$parent_id.",-1,' and status=1 and mode_id&".$_SESSION[_PLATFORM_]["CLA"]['TopLeftLinkType'].">0 '";
		//echo $sql.'<br>';
		if ($name!='')
			$id='  '.$name.' ';
		$step++;
		$result = $this->db->query_debug($sql, true, "Query failed");
		
		if ($result){
			$menu1=str_repeat(' ',$step*10).'<ul '.$id.'>'.chr(13);
			$menu='';
			while ($aR = $this->db->fetchByAssoc($result)) {  
				$module = $aR['memu_module'];				
				$action = $aR['menu_action'];				
				$href = 'javascript:';
				$url = $aR['url'];
				$url_http =  substr($url,0,4);
				if (is_admin()==1 || is_array($RoleData[$module][$module.'_'.$action]) || (is_array($RoleData[$module])&&($action==''||$action=='index')) || $url_http=='http'){
					if ($menu=='')
						$menu.=$menu1;
					if ($url_http=='http' || $url_http=='java'){
						$href = $url;
					}
					else{					
						if ($module=='' || $action=='' || ($action=='index' && is_admin()==1) ){
						$href = 'javascript:';
						}
						else
						{$href = 'do?module='.$module.'&action='.$action.$url;}
					}
					
					$menu.=str_repeat(' ',$step*10).'<li><a href="'.$href.'"><em><b>'.$aR['menu_name'].'</b></em></a>'.chr(13);	
					
					$menu.=$this->_Menu2($aR['menu_id'],$step,'');
					$menu.=str_repeat(' ',$step*10).'</li>'.chr(13);
				}

			}
			$menu1=str_repeat(' ',$step*10).'</ul>'.chr(13);
			if ($menu!='')
					$menu.=$menu1;
		}*/
		return $menu;
	}	
	

	function arr_status_name(){
	
		$arr = array();
		$arr[0]='Inactive';	
		$arr[1]='Active';	
		return $arr;
	}	
	//========================================//
	
	function generateCode($characters) {
		/* list all possible characters, similar looking characters and vowels have been removed */
		$possible = '23456789bcdfghjkmnpqrstvwxyz';
		$code = '';
					      $i = 0;
					      while ($i < $characters) {
					         $code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
					         $i++;
					      }
					      return $code;
	}
	
	function encrypt_decrypt($Str_Message) {
    $Len_Str_Message=STRLEN($Str_Message);
    $Str_Encrypted_Message="";
    for ($Position = 0;$Position<$Len_Str_Message;$Position++){
        $Key_To_Use = (($Len_Str_Message+$Position)+1); // (+5 or *3 or ^2)
        $Key_To_Use = (255+$Key_To_Use) % 255; 		
        $Byte_To_Be_Encrypted = SUBSTR($Str_Message, $Position, 1);
        $Ascii_Num_Byte_To_Encrypt = ORD($Byte_To_Be_Encrypted);
        $Xored_Byte = $Ascii_Num_Byte_To_Encrypt ^ $Key_To_Use;  //xor operation
        $Encrypted_Byte = CHR($Xored_Byte);
        $Str_Encrypted_Message .= $Encrypted_Byte;

    }
    return $Str_Encrypted_Message;
	} //end function	
	




		


	function ajax_chk($arr,$list_form){		
		foreach ($arr as $k=>$v){
			$rand = rand(10,99);
			$chk = md5($this->AuthSum.$rand);
			$rtn[$k]['rand'] = $this->per_role($rand,1);	
			$rtn[$k]['token'] = $chk;	
		}		
		$list_form->assign('AjaxToken'	,  	$rtn);
	}



	function anti($text,$type=3,$regexp="/[^A-Za-z]/"){

		switch ($type) {
		case 1:			
			break;
		case 2:
			$regexp="/[^0-9]/";
			break;
		case 3:
			$regexp="/[^A-Za-z0-9_]/";
			break;
		case 4: //date
			$text = str_replace('/','-',$text);
			$regexp="/[^0-9-: ]/";
			break;
		default: 
			if ($regexp==""){$regexp="/[^0-9]/";}
			break;
		}
			
		if (!preg_match($regexp, $text)){
			//echo 'hop le';
			return $text;
		}else{
			$rep = preg_replace( $regexp, "", $text);
			return $rep;
		}
		return "";
	
	}
	
	function arr_data_box($table,$key,$value,$filter='none',$where,$token='',$ajax=false){
		$sSQL="exec sys_box_list '$table','$key','$value','$filter','$where' ";				
		$result = $this->db->query($sSQL, true, "Query failed");		
		$arr = array();
		$j=0;
		while ($aRow = $this->db->fetchByAssoc($result))
			{
				if ($filter=='none'){
					if($ajax){
						$arr[$j]['record_id']= $aRow['record_id'];
						$arr[$j]['item'] = $aRow['item'];
					}else{
						$arr[$aRow['record_id']]=$aRow['item'];	
					}
				}else{
					if($ajax){
						foreach($aRow as $key1=>$value1){
							$arr[$j][$key1]=$value1;	
						}
						if ($token==''){						
							$arr[$j]['token'] = $this->md5sum('token'.$aRow[$token]);
						}
					}else{
						$arr[$aRow[$key]][0]=$aRow[$value];
						$i=0;
						foreach($aRow as $key1=>$value1){
							
							$arr[$aRow[$key]][1][$i]=$value1;
							$i++;
						}
						if ($token!=''){
							$arr[$aRow[$key]][1][$i]=$this->md5sum('token'.$aRow[$token]);
							$i++;
						}
					}					
				}
				$j++;
			}	

		return $arr;	
	}
	function no_body(){
		return false;
	}
	
	function fnc_get_user_info($type_id,$value,$html=false,$html_type=0){
		$detail_id = 0;
		$user_name = '';
		$user_code = '';
		switch($type_id){
			case 1:
				$detail_id = $value;
				break;
			case 2:
				$user_name = $value;
				break;
			case 3:
				$user_code = $value;
				break;
			default:
				break;
		}
		
		$arr_result['result'] = -1;
		if($detail_id>0 || $user_name !='' || $user_code!=''){
			$sSQL = "exec usp_user_info 0,'".$user_name."',".(int)$detail_id.",'".$user_code."'";			
			$result = $this->db->query($sSQL, true, "Query failed");
			if($aRow = $this->db->fetchByAssoc($result)){
				$token_user = $this->md5sum($aRow['detail_id'].$aRow['user_name'].$aRow['position_id'].$aRow['level_id']);
				$aRow['token_user'] = $token_user;
				$org_chart = $this->getOrgChart($aRow['dep_id']);
				$aRow['org_chart'] = $org_chart;
				$arr_result['result'] = 1;
				$arr_result['data'] = $aRow;
				if($html){		
					if($html_type==0){
						$list_form = new XTemplate('templates/user_info_1.html');
					}else{
						$list_form = new XTemplate('templates/user_info.html');
					}
					$list_form->assign('user_info',$aRow);				
					$list_form->assign('check_status_'.(int)$aRow['status'],'checked="checked"');
					$list_form->parse('main');
					$html = $list_form->out_return('main');
					$arr_result['html'] = $html;
				}
			}
		}
		return $arr_result;
	}
	
	
	
	function getDepListChild($detail_id){
		$sSQL="exec usp_dep_list_child ".(int)$detail_id;		
		$result = $this->db->query($sSQL, true, "Query failed");	
		$arr_id = array();		
		while($aR = $this->db->fetchByAssoc($result)){			
			$arr_id[$aR['id']] = $aR['name'];
		}
		return $arr_id;
	}	
	function getUserListChild($detail_id,$get_leader =1){
		$sSQL="exec usp_user_list_child ".(int)$detail_id.",".(int)$get_leader;		
		$result = $this->db->query($sSQL, true, "Query failed");	
		$arr_id = array();
		$arr_username = array();
		while($aR = $this->db->fetchByAssoc($result)){			
			$arr_id[$aR['detail_id']] = $aR['full_name'];
			$arr_username[$aR['user_name']] = $aR['full_name'];		
		}	
		$arr[0] = $arr_id;
		$arr[1] = $arr_username;
		return $arr;
	}
	function getOrgChart($dep_id,$return_str = true){
		$sSQL="exec sys_level_rebuild_list 'ws_user_departments','id',".(int)$dep_id.",1,''";		
		$result = $this->db->query($sSQL, true, "Query failed");	
		$arr = array();
		$str_org_chart = '';
		while($aR = $this->db->fetchByAssoc($result)){
			if($return_str){
				if($str_org_chart!=''){
					$str_org_chart .=" -> ";
				}
				$str_org_chart .= $aR['name'];
			}else{
				$arr[] = $aR;
			}			
		}		
		if($return_str){
			return $str_org_chart;
		}
		return $arr;
	}
	
	function getUserLeaderInfo($detail_id){
		$sSQL="exec usp_user_get_info_user_leader ".(int)$detail_id;		
		$result = $this->db->query($sSQL, true, "Query failed");
		if($aR = $this->db->fetchByAssoc($result)){			
			return $aR;
		}
		return array();
	}	
	
	function setStatusColor($mode_id,$list_form,$arr_color=null){
		$str_status_color_css = '';
		$str_status_color_description = '';
		if(is_array($arr_color)){			
			foreach($arr_color as $aR){				
				$arr_status[] = $aR;
				$status_id = $aR[1][0];
				$status_name = $aR[1][1];
				$status_color = $aR[1][2];
				if($status_color!=''){
					$str_status_color_css.=".status_color_bg_".$status_id."{background:".$status_color.";}";			
					$str_status_color_css.=".status_color_text_".$status_id."{color:".$status_color.";}";
					$str_status_color_description .= '<div style="float:left;"><div class="status_color_checkbox_description status_color_bg_'.$status_id.'"></div>&nbsp;<b>'.$status_name.'</b> &nbsp;&nbsp;&nbsp;&nbsp;</div>';	
				}
			}
		}else{
			$sSQL = "exec web_table_list 1,100,' and mode_id=".(int)$mode_id." ','[order]','asc','*' ,'ws_rf_status','status_id'";
			$result = $this->db->query($sSQL, true, "Query failed");
			
			$arr_status = array();
			while($aR = $this->db->fetchByAssoc($result)){
				$arr_status[] = $aR;
				if($aR['color']!=''){
					$str_status_color_css.=".status_color_bg_".$aR['status_id']."{background:".$aR['color'].";}";			
					$str_status_color_css.=".status_color_text_".$aR['status_id']."{color:".$aR['color'].";}";
					$str_status_color_description .= '<div style="float:left;"><div class="status_color_checkbox_description status_color_bg_'.$aR['status_id'].'"></div>&nbsp;<b>'.$aR['status_name'].'</b> &nbsp;&nbsp;&nbsp;&nbsp;</div>';	
				}
			}
		}
		if($str_status_color_css!=''){
			$str_status_color_css ="<style>".$str_status_color_css."</style>";
		}
		if($str_status_color_description!=''){
			$status_color_description_with_title ='<table class="info" width="100%"><tr><td><div width="100%" class="group_info_title_bg">Giải thích màu trạng thái</div></td></tr><tr><td>'.$str_status_color_description.'</td></tr></table>';
			$str_status_color_description ='<div style="margin:5px 0px 30px 20px;">'.$str_status_color_description.'</div>';
		}
		
		if(isset($list_form)){
			$list_form->assign('css_status',$str_status_color_css);
			$list_form->assign('status_color_description',$str_status_color_description);
			$list_form->assign('status_color_description_with_title',$status_color_description_with_title);
		}
		$arr_result[0] = $arr_status;
		$arr_result[1] = $str_status_color_css;
		$arr_result[2] = $str_status_color_description;
		return $arr_result;
	}
	
	function getListNewsCategories(){
		$sSQL = " select t1.*
			,t2.menu_name_vi as parent_menu_name_vi 
			,t2.menu_name_en as parent_menu_name_en
			from ntk_menus  t1 
			left join ntk_menus t2 on t1.parent_id = t2.menu_id			
			where t1.parent_id > 0
		";
		$result = $this->db->query($sSQL, true, "Query failed");
		$arr_result = array();
		while($aR = $this->db->fetchByAssoc($result)){
			$arr_result[$aR['menu_id']] = $aR['parent_menu_name_vi'].'->'.$aR['menu_name_vi'].'('.$aR['parent_menu_name_en'].'->'.$aR['menu_name_en'].')';
		}
		return $arr_result;
			
	}
	
}

