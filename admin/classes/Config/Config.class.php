<?
if(!defined('TSEntry') || !TSEntry) die('Not A Valid Entry Point');
class Config extends TSDefault
{
	function define(){
		$this->dont_check_user = false;
	}
	
	function getListProvince(){
		$sSQL="select * from ntk_province order by `order` asc ";		
		$result = $this->db->query($sSQL, true, "Query failed");
		$data = array();		
		while($aR = $this->db->fetchByAssoc($result)){
			$data[$aR['id']] = $aR['name'];
		}
		return $data;
	}
	function getListPostCategories(){
		$sSQL="select * from ntk_forum_categories order by `order` asc ";		
		$result = $this->db->query($sSQL, true, "Query failed");
		$data = array();		
		while($aR = $this->db->fetchByAssoc($result)){
			$data[$aR['category_id']] = $aR['category_name_en']==''?$aR['category_name_vi']:$aR['category_name_vi']."(".$aR['category_name_en'].")";
		}
		return $data;
	}
	
	
}
