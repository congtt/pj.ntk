<?
if(!defined('TSEntry') || !TSEntry) die('Not A Valid Entry Point');
class RefModule {

	public $db;
	public $AuthSum;
	public function RefModule($db,$AuthSum){
		$this->db = $db;
		$this->AuthSum = $AuthSum;
	}

	function ref_married(){
		return array(0=>'Độc thân',1=>'Đã kết hôn',2=>'Ly hôn');
	}
	function ref_study_level(){
		return $this->arr_data_box('ws_rf_study_level','study_level_id','study_level_name',$filter='none',' and status = 1  order by [order]  ',$token='');	
	}	
	
	function ref_relationship(){
		return $this->arr_data_box('ws_rf_relationship','relationship_id','relationship_name',$filter='none',' and status = 1  order by [order]  ',$token='');	
	}	
	
	function ref_eform_status(){
		return $this->arr_data_box('ws_rf_status','status_id','status_name',$filter='none',' and active =1 and mode_id = 5 order by [order]  ',$token='');	
	}
	
	function ref_kpi_plan(){
		return $this->arr_data_box('ws_kpi_plan','kpi_plan_id','plan_name',$filter='none',' and status not in (-13) order by [status] desc ',$token='');	
	}
	function ref_contract_type(){
		return array(1=>'Đang có hiệu lực',0=>'Hết hiệu lực');
	}
	function ref_year($year=0,$num=0){
		if ($num==0)
			$num = 5;
		if ($year==0)
			$year = date('Y')-$num;

		for ($i=$year;$i<=$year+$num;$i++){
			$arr[$i] = $i;
		}
		arsort($arr);
		return $arr;
	}
	function ref_year2($from=0,$to=0){
		if ($from==0)
			$from = date("Y");
		if ($to==0)
			$to = date('Y');

		for ($i=$from;$i<=$to;$i++){
			$arr[$i] = $i;
		}
		arsort($arr);
		return $arr;
	}
	
	function ref_month(){
		for ($i=1;$i<=12;$i++){
			if ($i<10)
				$arr['0'.$i] = '0'.$i;
			else
				$arr[$i] = $i;
		}
		return $arr;
	}


	function ref_week(){
		$arr=array('Chủ Nhật','Thứ hai','Thứ ba','Thứ tư','Thứ năm','Thứ sáu','Thứ bảy');
		return $arr;
	
	}

	function ref_department(){
		return $this->arr_data_box('ws_user_departments','id','name');
	}

	function ref_level(){
		return $this->arr_data_box($table,$key,$value,$filter='none',$where,$token='');	
	}

	function ref_company(){
		return $this->arr_data_box('ws_rf_company','company_id','company_name',$filter='company_id,company_name',' and status=1 ',$token='company_id');	
	}

	function ref_company_binary(){
		return $this->arr_data_box('ws_rf_company','binary_company_id','company_name',$filter='none',' and status=1 ','');	
	}
	
	function ref_status(){
		$arr = array('Inactive','Active');
		return $arr;	
	}

	function ref_report_template(){
		return $this->arr_data_box('ws_rf_report_template','template_id','template_name',$filter='template_id,template_name,template_type,from_time','  ',$token='template_id');	
	}

	function arr_data_box($table,$key,$value,$filter='none',$where,$token=''){
		$sSQL="exec sys_box_list '$table','$key','$value','$filter','$where' ";
		//echo $sSQL;	
		$result = $this->db->query($sSQL, true, "Query failed");		
		$arr = array();
		
		while ($aRow = $this->db->fetchByAssoc($result))
			{	
	
				if ($filter=='none'){
					$arr[$aRow['record_id']]=$aRow['item'];	
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

		return $arr;	
	}
	function md5sum($txt,$session_id = true){
		$key=0;
		if ($session_id)
			$key=session_id();
		return md5($key.$this->AuthSum.$txt.$this->AuthSum.$_SESSION[_PLATFORM_]["CLA"]["User_Name"]);
	}
}