<?if(!defined('TSEntry') || !TSEntry) die('Not A Valid Entry Point');

	function debug($txt,$end = 0 ){		
		print("<pre>");
		echo('-- debug --<br>');	
		echo $txt.'<br>';
		print_r($txt);
		echo('--end debug --<br>');	
		if ($end==1)
			die('-- --- --');	
	}
	

	function page_menu($parent_id=-1,$step=0,$name,$parent_name=''){		
		global $db,$fullsite;
		$lang = "_".get_language();		
		if ($parent_id==-1)
			$sql="select * from ntk_menus where parent_id = -1";
		else 
			$sql="select * from ntk_menus where parent_id = ".$parent_id;
		//echo $sql.'<br>';
		if ($name!='')
			$id='  class="'.$name.'" ';
		$step++;

		$result = $db->query($sql, true, "Query failed");
		$org=str_repeat(' ',$step*10).'<ul '.$id.'>'.chr(13);
		while ($aR = $db->fetchByAssoc($result)) {  
			$special = '';
			if ($aR['status_id']==0)
				$special = ' ';

			$href="";
			if ($aR['link']!=''){
				if (substr($aR['link'],0,7)=='http://')
					$href=' href="'.$aR['link'].'" ';
				else
					$href=' href="'.$fullsite.'/'.$aR['group'].'/0/'.$aR['link'].'" ';
				
			}
			else{
				if ($parent_name!='')
					$href=' href="'.$fullsite.'/'.$aR['menu_id'].'/0/'.tag_link($aR['menu_name'.$lang]).'.html" ';
				
			}


			$org.=str_repeat(' ',$step*10).'<li><a  data-actor="'.$aR['id'].'"  title="'.$aR['note'].'" id="'.$aR['id'].'" token="'.$md5sum.'" name="'.$aR['name'].'" note="'.$aR['note'].'" status="'.$aR['status_id'].'" uid="'.$aR['detail_id'].'" uidtoken="'.$uidtoken.'" 
			 order="'.$aR['order'].'" '.$special.' style="cursor:pointer" '.$href.'><span>'.$aR['menu_name'.$lang].'</span></a>'.chr(13);
			$parent_name_vl = tag_link($aR['menu_name'.$lang]);
			$org.=page_menu($aR['menu_id'],$step,'',$parent_name_vl);
			$org.=str_repeat(' ',$step*10).'</li>'.chr(13);
		}
		$org.=str_repeat(' ',$step*10).'</ul>'.chr(13);
		return $org;
	}		
	function forum_menu($parent_id=-1,$step=0,$name,$parent_name=''){		
		global $db,$fullsite;
		$lang = "_".get_language();
		if ($parent_id==-1)
			$sql="select * from ntk_forum_categories where parent_id = -1";
		else 
			$sql="select * from ntk_forum_categories where parent_id = ".$parent_id;		
		if ($name!='')
			$id='  class="'.$name.'" ';
		$step++;

		$result = $db->query($sql, true, "Query failed");
		$org=str_repeat(' ',$step*10).'<ul '.$id.'>'.chr(13);
		while ($aR = $db->fetchByAssoc($result)) {  
			$special = '';
			if ($aR['status_id']==0)
				$special = ' ';

			$href="";
			if ($aR['link']!=''){
				if (substr($aR['link'],0,7)=='http://')
					$href=' href="'.$aR['link'].'" ';
				else
					$href=' href="'.forum_path.'/'.$aR['group'].'/0/'.$aR['link'].'" ';
				
			}
			else{
				if ($parent_name!='')
					$href=' href="'.forum_path.'/'.$aR['category_id'].'/0/'.tag_link($aR['category_name'.$lang]).'.html" ';
				
			}


			$org.=str_repeat(' ',$step*10).'<li><a  data-actor="'.$aR['id'].'"  title="'.$aR['note'].'" id="'.$aR['id'].'" token="'.$md5sum.'" name="'.$aR['category_name'].'" note="'.$aR['note'].'" status="'.$aR['status_id'].'" uid="'.$aR['detail_id'].'" uidtoken="'.$uidtoken.'" 
			 order="'.$aR['order'].'" '.$special.' style="cursor:pointer" '.$href.'><span>'.$aR['category_name'.$lang].'</span></a>'.chr(13);
			$parent_name_vl = tag_link($aR['category_name'.$lang]);
			$org.=forum_menu($aR['category_id'],$step,'',$parent_name_vl);
			$org.=str_repeat(' ',$step*10).'</li>'.chr(13);
		}
		$org.=str_repeat(' ',$step*10).'</ul>'.chr(13);
		return $org;
	}
	
	function get_lang($key){
		global $__lang;
		return $__lang[$key];
	}
	function get_language(){
		$arr_lang = array('en','vi');
		if(isset($_SESSION[_PLATFORM_]['lang'])){
			$lang = $_SESSION[_PLATFORM_]['lang'];
		}else{
			$lang = $_COOKIE[_PLATFORM_.'lang'];
		}
		if(!in_array($lang,$arr_lang)){
			$lang = 'vi';
		}
		$_SESSION[_PLATFORM_]['lang'] = $lang;
		//setcookie(_PLATFORM_.'lang',$lang);
		return $lang;
		
	}
	function is_login(){
		if($_SESSION[_PLATFORM_]['is_login'] && is_array($_SESSION[_PLATFORM_]['USER_INFO'])){
			return true;
		}
		return false;
		/*global $ts_info;
		
		if (count($ts_info)>0 && trim($ts_info['User_Name'])!='' && $_GET['module']!='Error'){
			return true;
		}else
		{return false;}*/
		
		
	}

	function is_admin(){
		return true;
		if ($_SESSION[_PLATFORM_]["CLA"]["isAdmin"]==1 || $_SESSION[_PLATFORM_]["CLA"]["User_Name"]=='admin')
			return 1;
		else
			return -1;
	}


	function ts_debug($txt,$end = 0 ){
		if (trim($_SESSION[_PLATFORM_]["CLA"]["User_Name"])=='hoang'){
			echo('-- debug --<br>');	
			echo $txt.'<br>';	
			var_dump($txt);
			echo('--end debug --<br>');	
			if ($end==1)
				die('-- --- --');		
		}	
	}

	function is_freetds() {
	
		$ret=false;
		if (isset($GLOBALS['mssql_library_version'])) {
			if ($GLOBALS['mssql_library_version']=='freetds') {
				$ret=true;
			} else {
				$ret=false;
			}
		} else {
			ob_start();
			phpinfo();
			$info=ob_get_contents();
			ob_end_clean();
	
			if (strpos($info,'FreeTDS') !== false) {
				$GLOBALS['mssql_library_version']='freetds';
				$ret=true;
			} else {
				$GLOBALS['mssql_library_version']='regular';
				$ret=false;
			}
		}
		return $ret;
	}


	function ts_die($msg){
		die($msg);
		exit();
	}

	function ts_permission(){
		die('<div style="color:red;font-size:15px">You do not have permission to view this page.</div>');
		exit();
	}

$toHTML = array(
	'"' => '&quot;',
	'<' => '&lt;',
	'>' => '&gt;',
	"'" => '&#039;',
);
$GLOBALS['toHTML_keys'] = array_keys($toHTML);
$GLOBALS['toHTML_values'] = array_values($toHTML);

function to_html($string, $encode=true){
	if (empty($string)) {
		return $string;
	}
	static $cache = array();
	global $toHTML;
	if (isset($cache['c'.$string])) {
	    return $cache['c'.$string];
	}
	
	$cache_key = 'c'.$string;
	
	if($encode && is_string($string)){//$string = htmlentities($string, ENT_QUOTES);
		/*
		 * cn: bug 13376 - handle ampersands separately 
		 * credit: ashimamura via bug portal
		 */ 
		//$string = str_replace("&", "&amp;", $string);

		if(is_array($toHTML)) { // cn: causing errors in i18n test suite ($toHTML is non-array)
			$string = str_replace(
				$GLOBALS['toHTML_keys'],
				$GLOBALS['toHTML_values'],
				$string
			);
		}
	}
	$cache[$cache_key] = $string;
	return $cache[$cache_key];
}

	function fnStrConvert($text){
	
	   # Convert values from Lower to Upper
	   $arrayLower=array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','à','á','ả','ã','ạ','ă','ằ','ắ','ẳ','ẵ','ặ','â','ầ','ấ','ẩ','ẫ','ậ','đ','è','é','ẻ','ẽ','ẹ','ê','ề','ế','ể','ễ','ệ','ì','í','ỉ','ĩ','ị','ò','ó','ỏ','õ','ọ','ô','ồ','ố','ổ','ỗ','ộ','ơ','ờ','ớ','ở','ỡ','ợ','ù','ú','ủ','ũ','ụ','ư','ừ','ứ','ử','ữ','ự','ỳ','ý','ỷ','ỹ','ỵ','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','À','Á','Ả','Ã','Ạ','Ă','Ằ','Ắ','Ẳ','Ẵ','Ặ','Â','Ầ','Ấ','Ẩ','Ẫ','Ậ','Đ','È','É','Ẻ','Ẽ','Ẹ','Ê','Ề','Ế','Ể','Ễ','Ệ','Ì','Í','Ỉ','Ĩ','Ị','Ò','Ó','Ỏ','Õ','Ọ','Ô','Ồ','Ố','Ổ','Ỗ','Ộ','Ơ','Ờ','Ớ','Ở','Ỡ','Ợ','Ù','Ú','Ủ','Ũ','Ụ','Ư','Ừ','Ứ','Ử','Ữ','Ự','Ỳ','Ý','Ỷ','Ỹ','Ỵ');
	   $arrayUpper=array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','d','e','e','e','e','Ẹ','e','e','e','e','e','e','i','i','i','i','i','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','u','u','u','u','u','u','u','u','u','u','u','y','y','y','y','y','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','A','A','A','A','A','A','A','A','A','A','A','A','A','A','A','A','A','D','E','E','E','E','Ẹ','E','E','E','E','E','E','I','I','I','I','I','O','O','O','O','O','O','O','O','O','O','O','O','O','O','O','O','O','U','U','U','U','U','U','U','U','U','U','U','Y','Y','Y','Y','Y');
	
	if($text == ''){
	   return $text;
	}
	
	   $text=str_replace($arrayLower, $arrayUpper, $text);
	   return($text);
	} #end of function	
	
	function vndate2date($date,$sp='/',$time=false){
		if ($date==''){
			return '';
		}
		else
		{	
			$arr_time = explode(' ',$date);
			$tmp = explode($sp,$arr_time[0]);
			$strdate = $tmp[2].'/'.$tmp[1].'/'.$tmp[0];			
			if ($time){
				return $strdate.' '.$arr_time[1];
			}else{
				return $strdate;
			}
		}
	}
	
	function date2vndate($date,$time=false){
		if ($date=='' || $date=='0000-00-00 00:00:00' || $date=='0000/00/00 00:00:00'){
			return '';
		}
		else
		{
			$tmp = strtotime($date);
			$strdate = date('d/m/Y',$tmp);
			$strtime = ' '.date('H:i:s',$tmp);
			if ($time){
				return $strdate.$strtime;
			}else
			{
				return $strdate;	
			}
		}
		
	}	
	
	function dateadd($v,$d=null , $f="m/d/Y"){ 
	  $d=($d?$d:date("Y-m-d")); 
	  return date($f,strtotime($v." days",strtotime($d))); 
	}


	function date_diff_v1($start, $end)
	{
	   	$dateDiff = strtotime($end) - strtotime($start);
		$fullDays = ($dateDiff/(60*60*24));  		
		return $fullDays;   
	}



	function nb_format($digits,$number=0){
		return number_format($digits, $number, '.', ',');
	}
	function nb_format2($digits,$number=0){
		return number_format($digits, $number, '.', '.');
	}

	function nb_format3($digits,$number=0){
		return number_format($digits, $number, '.', '');
	}
	function iif($expression, $returntrue, $returnfalse = ''){
		return ($expression ? $returntrue : $returnfalse);
	}

	function isNull($vl,$def){
		if (empty($vl) || $vl==null){return $def;}
		else 
			return $vl;
	}
	
	function randomString($length = 8)
    {
        $str = '';
        $allowed_chars = '2346789ABCDEFGHJKLMNPRTWXYZ';
        $chars_length = strlen($allowed_chars) - 1;

        for ($i = 0; $i < $length; $i++) {
            $str .= $allowed_chars{rand(0, $chars_length)};
        }

        return $str;
    }

	function getform()
	{
		 $array=($_POST);   	 
		 $key_arrays=array_keys($array);    
		 $tmp='';
		 $tmp1='';
		 for ($i=0;$i<count($key_arrays);$i++)
		 {	 	
			print "$".$key_arrays[$i]."=$"."_POST[".chr(34).$key_arrays[$i].chr(34)."];<br>";
			$tmp.="$".$key_arrays[$i]."= _get(".chr(34).$key_arrays[$i].chr(34).");<br>";
			$tmp1.="$".$key_arrays[$i]."= __post(".chr(34).$key_arrays[$i].chr(34).");<br>";
		 }

		 $array=($_GET);   	 
		 $key_arrays=array_keys($array);    
	 
		 for ($i=0;$i<count($key_arrays);$i++)
		 {	 	
			print "$".$key_arrays[$i]."=$"."_GET[".chr(34).$key_arrays[$i].chr(34)."];<br>";
			$tmp.="$".$key_arrays[$i]."= _get(".chr(34).$key_arrays[$i].chr(34).");<br>";
			$tmp1.="$".$key_arrays[$i]."= __post(".chr(34).$key_arrays[$i].chr(34).");<br>";
		 }
		 print '<hr>'.$tmp;
		 print '<hr>'.$tmp1;

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
	
	function PageHeader(){	
		$PageArr = array('2','5','10','20','50','100');
		$_PageHeader='
				<table width="100%">
				    <tr>
				         <td align=left>Tổng số dòng : <b style="color:red">'.$this->TotalRecord.'</b> / '.$this->TotalPage.' trang</td>
				         <td align="right">Số dòng / trang 
						 	<select name="ddlPageSize" id="ddlPageSize"  onchange="document.form1.submit()" >';
		for ($i=0;$i<count($PageArr);$i++){
		$slted='';
		if 	($PageArr[$i]==$_POST['ddlPageSize'])
		{
			$slted=' selected ';
		}
		
		$_PageHeader.='<option value="'.$PageArr[$i].'" '.$slted.'>'.$PageArr[$i].'</option>';
		}
		
		$_PageHeader.='	</select>
				         </td>
				    </tr>
				</table>';				
		$_PageHeader.=$this->_fnSortOrderBy();				
		return 	$_PageHeader;	
	}	
	
	function Paging($totalPages=0,$currentPage=0,$formName='')
	{
		global $vportal;
		$form = ($formName!=""&&$formName!=null) ? $formName : "forms[0]";
		$strPaging = '<div id="paging" align=center><table border=0 cellpadding=0 cellspacing=0><tr>';
/*			
			/<td><div class="page">ddd</div></td>
			<td><div class="page">ddd</div></td>*/
			
			
			
			

		
		$pSegment = 5;
		if (is_numeric($totalPages))
		{
			$totalSegment = ceil($totalPages/$pSegment);
			$currentSegment = ceil($currentPage/$pSegment);
			$startPage = (($currentSegment-1)*$pSegment) + 1;
			$endPage = $currentSegment * $pSegment;
			$maxPage = ($endPage>$totalPages) ? $totalPages : $endPage;
			if ($currentPage>1)
				$strPaging .= "<td><div class='page'><a href=\"#Trang đầu\" onclick=\"document.$form.page.value='1';document.$form.submit();\"><img src=\"/images/first.png\" border=0 title='First'></a></div></td>";
			//else
			//	$strPaging .= "<img src=\"".$vportal->vars["site_url"]."/images/first_gr.png\"> ";
			if ($currentSegment>1)
				$strPaging .= "<td><div class='page'><a href=\"#Trang trước\" onclick=\"document.$form.page.value='".($currentSegment-1)*$pSegment."';document.$form.submit();\"><img src=\"/images/prevjump.png\" border=0  title='Prev'></a></div></td>";
			//else
			//	$strPaging .= "<img src=\"".$vportal->vars["site_url"]."/images/prevjump_gr.png\"> ";
			if ($currentPage>1)
				$strPaging .= "<td><div class='page'><a href=\"#Trang trước\" onclick=\"document.$form.page.value='".($currentPage-1)."';document.$form.submit();\"><img src=\"/images/prev.png\" border=0  title='Prev'></a></div></td>";
			//else
			//	$strPaging .= "<img src=\"".$vportal->vars["site_url"]."/images/prev_gr.png\"> ";
			
			for ($i=$startPage;$i<=$maxPage;$i++)
			{
				if ($currentPage==$i)
					$strPaging .= '<td><div ><input type="text" class="pgCurrent" value="'.$i.'" alt="integer" id="iCurrentPage" name="iCurrentPage"></div></td>';
				else
					$strPaging .= '<td><div class="page"><a href="#Trang '.$i.'"  onclick="document.'.$form.'.page.value=\''.$i.'\';document.'.$form.'.submit();" 	>'.$i.'</a></div></td>';
			}
			
			if ($currentPage<$totalPages)
				$strPaging .= "<td><div class='page'><a href=\"#Trang trước\" style=\"text-decoration:none\" onclick=\"document.$form.page.value='".($currentPage+1)."';document.$form.submit();\"><img src=\"/images/next.png\" border=0 title='Next'></a></div></td>";
			//else
			//	$strPaging .= "<img src=\"".$vportal->vars["site_url"]."/images/next_gr.png\"> ";
			if ($currentSegment<$totalSegment)
				$strPaging .= "<td><div class='page'><a href=\"#Trang sau\"  style=\"text-decoration:none\"  onclick=\"document.$form.page.value='".($currentSegment*$pSegment+1)."';document.$form.submit();\"><img src=\"/images/nextjump.png\" border=0  title='Next'></a></div></td>";
			//else
			//	$strPaging .= "<li class='pgNext pgEmpty'>kế</li> ";
			if ($currentPage<$totalPages)
				$strPaging .= "<td><div class='page'><a href=\"#Trang cuối\" style=\"text-decoration:none\" onclick=\"document.$form.page.value='".$totalPages."';document.$form.submit();\"><img src=\"/images/last.png\" border=0  title='Last'></a></div></td>";
			//else
			//	$strPaging .= "<img src=\"".$vportal->vars["site_url"]."/images/last_gr.png\"> ";
		}
		
		
		
		$strPaging .= "<td><div class='page'><a href=\"#Trang cuối\" style=\"text-decoration:none\" onclick=\" if (document.$form.iCurrentPage.value==''){document.$form.iCurrentPage.value=1;};document.$form.page.value=document.$form.iCurrentPage.value;  document.$form.submit();\"><b>go to page</b></a></div></td></tr></table></div>";		
		
		
		return $strPaging;
	}






	
	


	function md5sum($str){
		$code='PR@SH0P'.session_id();
		return md5($code.$str.$code.$_SESSION[_PLATFORM_]["CLA"]["User_Name"]);
	}
	
	function md5check($id){
		
		if (($_GET['chksum']!='' && md5sum($id)==$_GET['chksum']) || ($_GET['token']!='' && md5sum($id)==$_GET['token'])){
			$flag=true;
		}else
			{
				$flag=flase;	
				header('location:do?module=Error&err=2');					
				die('<div style="color:red">You do not have access to this area. Contact your site administrator to obtain access.</div>');
			}
		return $flag;
	}

	function tokencheck($id){		
		if (($_GET['chksum']!='' && md5sum($id)==$_GET['chksum']) || ($_GET['token']!='' && md5sum($id)==$_GET['token'])){
			$flag=true;
		}else
			{
				$flag=flase;	
				header('location:do?module=Error&err=2');					
				die('<div style="color:red">You do not have access to this area. Contact your site administrator to obtain access.</div>');
			}
		return $flag;
	}

	function StrUpper($str) {
		return trim(str_replace(' ','',strtoupper($str)));
	}


	function update_file($file,$path){
		
		$_file = $file['tmp_name'];
		if ($_file!=''){
			$_file_name = $file['name'];
			$fsize = @filesize($_file);
			if (!is_uploaded_file($_file)){
				echo 'error';
				die();
			}else{
				$time=date("Ymd");
				$new_file = ''.session_id().'_'.$time.$_file_name;
				@copy($_file,$path.'//'.$new_file) or die("<font size=\"2\">Couldn't Copy File To Server</font>");
				@chmod($path.'//'.$new_file,0777);
			}
			return $new_file;
		}else{
			return '';
		}
	}	



	function img_name($text){
		$text = strtolower(fnStrConvert(preg_replace("/ /i",'_',$text)));
		return $text.'.jpg';


	}
	function anti2($sWords){
		$num = (int) $sWords;
		if ($num==''){$num=0;}
		return $num;
	}

	function anti($sWords, $bHtmlSpecialchars=false, $bQuote=false) {//return $sWords;
			$quote = array('/\s*(S|s)(E|e)(L|l)(E|e)(C|c)(T|t)\s*/',
					'/\s*(D|d)(R|r)(O|o)(P|p)\s*/',
					'/\s*(I|i)(N|n)(S|s)(E|e)(R|r)(T|t)\s*/',
					'/\s*(U|u)(P|p)(D|d)(A|a)(T|t)(E|e)\s*/',
					'/\s*(D|d)(E|e)(L|l)(E|e)(T|t)(E|e)\s*/',
					'/\s*(V|v)(A|a)(L|l)(U|u)(E|e)(S|s)\s*/',
					'/\s*(N|n)(U|u)(L|l)(L|l)\s*/',
					'/\s*(O|o)(R|r)\s*/',
					'/\s*(A|a)(n|N)(D|d)\s*/',
					'/\s*(T|t)(A|a)(B|b)(L|l)(E|e)\s*/',
					'/\s*(X|x)(P|p)_\s*/',
					'/\s*(U|u)(N|n)(I|i)(O|o)(N|n)\s*/',
					'/\s*(AND|ANd|AnD|aND|And|aNd|anD|and)\s*(1=1|0=0|1=0|0=1|true=true|false=false)\s*(--)*/',
					'/\s*(OR|or|Or|oR)\s*(1=1|0=0|1=0|0=1|true=true|false=false|1)\s*(--)*/');
			
				$sWords = preg_replace($quote, '', $sWords);
			
				if (!$bQuote) {
					$ArrBadChars = array("'", ";", "--", "%", "=");
					$sWords = str_ireplace($ArrBadChars, '', $sWords);
				}
			
				if(!$bHtmlSpecialchars){
					$arrSearch = array('<', '>', '"');
					$arrReplace = array('&lt;', '&gt;', '&quot;');
					$sWords = str_replace($arrSearch, $arrReplace, $sWords);
				}
			
				return $sWords;
	}

	function jsaler($txt='',$n=-1){
		if ($txt ==''){
			return 'javascript:sys_per('.$n.')';
		}
	}

	function pcParse($code){
		//Define Barcode cua shop:
		//	x x xx xx xxxx > x: SHOP, x: Gender, xx: Vendor, xx: so lan nhap: xxxx: So Thu tu		
		$shopId =  (int)substr($code,0,1);
		$gender =  (int)substr($code,1,1)==1?'MALE':'FEMALE';
		$vendorId =  (int)substr($code,2,2);
		$time =  substr($code,4,2);
		$number =  substr($code,6,12);
		$arr['shopId'] = $shopId;
		$arr['gender'] = $gender;
		$arr['vendorId'] = $vendorId;
		$arr['time'] = $time;
		$arr['number'] = $number;
		return $arr;
	}

	function setRMenu($arr){
		$_rmenu='';
		$RoleData = $_SESSION[_PLATFORM_]["CLA"]['RoleData'];
		foreach ($arr as $key=>$val){
			$link=explode('|',$val);
			$_rmenu.='<li><a title="" href="do?module='.$key.$link[1].'" id="black_rose" class="set_theme">'.$link[0].'</a></li>';
			if ($_SESSION[_PLATFORM_]["CLA"]["isAdmin"]==-1){
				if (!array_key_exists($key,$RoleData)){
					$_rmenu='';
				}
			}
		}


		
		
		return $_rmenu;
	}

	function GenerateZero($str,$num)
	{
		$tmp="";
		for ($i=strlen($str);$i<$num;$i++)
		{
			$tmp.="0";
		}
		return $tmp.$str;
	}


	function mysql_date_add($field ='CURRENT_TIMESTAMP()',$hour =14,$as_name=''){
		if ($as_name==''){$as_name = $field;}
		return  ' , DATE_ADD('.$field.',INTERVAL '.$hour.' HOUR) as da_'.$as_name.' ';
	}

 
	function tag_link($text){
		$text = fnStrConvert($text);
		$regexp="/( )/i";
		$text = preg_replace($regexp, "-", $text);
		return $text;
	}

	function anti_post($text){
		$regexp="/(select)|(drop)|(truncate)|(table)|(from)|(update)|(insert)|(;)|(')/i";
		$quoteexp ="/(')/";
		if (preg_match($quoteexp, $text)){
			$text = preg_replace($regexp, "", $text);
			$ret = preg_replace($quoteexp, "''", $text);
			return $ret;
		}
		else if (preg_match($regexp, $text)){
			//echo 'invalid';
			$ret = preg_replace($regexp, "", $text);
			return $ret;                                        
		}
		return $text;                      
	}

	function anti_sql($text){
		$regexp="/(select)|(drop)|(truncate)|(table)|(from)|(update)|(insert)|(;)/i";
		if (preg_match($quoteexp, $text)){
			$text = preg_replace($regexp, "", $text);
			return $text;
		}
		else if (preg_match($regexp, $text)){
			//echo 'invalid';
			$ret = preg_replace($regexp, "", $text);
			return $ret;                                        
		}
		return $text;                      
	}

	function __get($id,$def=''){
			$vl = $_GET[$id]!=''?$_GET[$id]:'';
			if (!isset($id) || $id=='' )
				$vl = $def;
			return anti_post($vl);	
		}


	function __post($id,$def='') {
			$vl = $_POST[$id]!=''?$_POST[$id]:'';
			if (!isset($id) || $id=='' )
				$vl = $def;
			return anti_post($vl);	
	}

	function __post2($id,$def='') {
			$vl = $_POST[$id]!=''?$_POST[$id]:$_GET[$id];
			if (!isset($id) || $id=='' )
				$vl = $def;
			return anti_post($vl);	
	}

	function _go_error($num){		
		header('location:do?module=Error&err='.$num);
		die('');
	}


	function jumNumber($from,$quantity){
		$maxLen = strlen($from);
		$f = (int)$from;
		$t = $f+$quantity;

		if ($maxLen<strlen($t))
			$maxLen = strlen($t);
		$rep= $maxLen- strlen($f);
		$prefix = str_repeat('0',$rep);

		$rep2= $maxLen- strlen($t);
		$prefix2 = str_repeat('0',$rep2);


		$arr['from']=$prefix.$f;
		$arr['to']=$prefix2.$t;
		return $arr;
	}

	function genContractNumber($id){
		$maxLen = 5;
		$Number = '';
		if (strlen($id)<$maxLen){
			$Number = str_repeat('0',$maxLen-strlen($id)).$id;
		}else{
			$Number = $id;
		}
		
		$gen = substr($Number,0,strlen($Number)-1).date('y').substr($Number,strlen($Number)-1,strlen($Number));

		$contractNumber = $gen.'-'.date("m").'/NXT-HĐ';
		return $contractNumber;
	}

	function genProductionNumber($id){
		$maxLen = 5;
		$Number = '';
		if (strlen($id)<$maxLen){
			$Number = str_repeat('0',$maxLen-strlen($id)).$id;
		}else{
			$Number = $id;
		}
		
		$gen = $Number;

		$contractNumber = $gen.'-'.date("m").'/'.date("y").'-ĐNSX';
		return $contractNumber;
	}
	//echo genNumber(1,$text='XK-NVL');
	function genNumber($id,$text='',$maxLen = 5){
		$Number = '';
		if (strlen($id)<$maxLen){
			$Number = str_repeat('0',$maxLen-strlen($id)).$id;
		}else{
			$Number = $id;
		}
		
		$gen = $Number;

		$genNumber = date("y").date("m").date('d').$gen.'/'.$text;
		return $genNumber;
	}

	function genReqDelivery($id,$text='-ĐNXH'){
		$maxLen = 10;
		$Number = '';
		if (strlen($id)<$maxLen){
			$Number = str_repeat('0',$maxLen-strlen($id)).$id;
		}else{
			$Number = $id;
		}
		
		$gen = $Number;

		$gNumber = $gen.$text;
		return $gNumber;
	}
	
	function genRateId($txt){
		return genReqDelivery($txt,'-ĐNBG');
	
	}


	/* example
	$quantitative[]=56;
	$quantitative[]=50;
	$quantitative[]=56;
	print "<pre>";
	print_r(calSize('210 x 279 mm',$quantitative,10000));
	die();
	*/
	function calSize($size='',$quantitative=array(),$quantity=0){ // tinh dinh luong
			$wh_arr = explode('x',$size);
			$w = (int)$size;
			$h = (int)$wh_arr[1];

			$w1000 = $w/1000;
			$h1000 = $h/1000;
			$data = array();
			$total = 0; 
			foreach($quantitative as $k=>$v){
				$_vl1000 = $v/1000;
				$_cal = $w1000 * $h1000 * $_vl1000 * $quantity;
				$data[$k][0] = $_cal;
				$data[$k][1] = $_vl1000;
				$data[$k][2] = 'Liên '.($k+1);
				$total+=$_cal;
				
			}
			$k++;
			$data[$k][0] = $total;
			$data[$k][1] = $w1000;
			$data[$k][2] = $h1000;
			$data[$k][3] = $quantity;
			$data[$k][4] = 'Tổng cộng';

			return $data;

	
	}
	function calSize2($size='',$quantitative,$quantity=0){ // tinh dinh luong
			$wh_arr = explode('x',$size);
			$w = (int)$size;
			$h = (int)$wh_arr[1];
			$w1000 = $w/1000;
			$h1000 = $h/1000;
			$total = 0; 
			$_vl1000 = $quantitative/1000;
			
			$_cal = $w1000 * $h1000 * $_vl1000 * $quantity;
			return round($_cal,2);	
	}
	function calSize3($size='',$quantitative,$quantity=0){ // tinh dinh luong
			$wh_arr = explode('x',$size);
			$w = (int)$size;
			$h = (int)$wh_arr[1];
			$w1000 = $w/1000;
			$h1000 = $h/1000;
			$total = 0; 
			$_vl1000 = $quantitative/1000;
			
			$_cal = $w1000 * $h1000 * $_vl1000 * $quantity;
			$data[0]=round($_cal,2);
			$data[1]=$w; //width
			return $data;	
	}


	function sText($text,$num,$more ='...'){
		$arr = explode(' ',$text);
		$txt = '';
		for($i=0;$i<$num;$i++){
			$txt.=$arr[$i].' ';
		}
		if ($num<count($arr))
			$txt.=$more;		
		return $txt;
	}

	function get_username(){
		return $_SESSION[_PLATFORM_]["CLA"]["User_Name"];
	}
	
	function get_userid(){
		return $_SESSION[_PLATFORM_]["CLA"]["User_ID"];
	}

	function get_deptId(){
		return $_SESSION[_PLATFORM_]["CLA"]["Dept_ID"];
	}
	
	function setMessage($list_form,$data){
		$_msg = array();
		if(is_array($data)){
			if($data['result']>0){
				$_msg['class'] = _CLASS_MSG_SUCC;
				if($data['msg']==''){
					$_msg['msg'] = _INFO_SUCC;
				}else{
					$_msg['msg'] = $data['msg'];
				}
			}else{
				$_msg['class'] = _CLASS_MSG_ERROR;
				if($data['msg']==''){
					if($data['result']==-21){
						$_msg['msg'] = _INFO_ERROR_SECURITY;
					}else{
						$_msg['msg'] = _INFO_ERROR;
					}
				}else{
					$_msg['msg'] = $data['msg'];
				}
			}
			if(isset($list_form)){
				$list_form->assign('msg',$_msg);
			}
		}
		return $_msg;
	}
	
?>