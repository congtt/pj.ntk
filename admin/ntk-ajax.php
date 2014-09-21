
<?php
if(!defined('TSEntry') || !TSEntry) die('Not A Valid Entry Point');
    
	$tp =  $_POST['tp']; 
	switch($tp){
		case 'get_hospital':
			$arr_data = get_hospital();
			die(json_encode($arr_data));			
			break;
		default:
			break;
	}		
	function get_hospital(){	
		global $db,$fullsite,$cla_cid,$cla_nid,$cla_site,$ts_config;		
		$lang = '_'.get_language();
		$province_id = (int)$_POST['province_id'];	
		if($province_id>0){
			$sql="SELECT * FROM ntk_hospital WHERE  status =1 and province_id = ".$province_id." order by `order` asc ";
			$result = $db->query($sql, true, "Query failed");
			$arr = array();
			$i = 0;
			while ($aR = $db->fetchByAssoc($result)) {
				$id = $aR['id'];
				$name = $aR['name'.$lang];
				$arr[$i]['id'] = $id;
				$arr[$i]['name'] = $name;
				$i++;
			}
			return $arr;
		}
	}