<?if(!defined('TSEntry') || !TSEntry) die('Not A Valid Entry Point');
class TreeModule {

	public $db;
	public function TreeModule($db){
		$this->db = $db;
	}
	//RebuildTree(-1,0,'ws_user_directly_reporting','detail_id');
	public function RebuildTree($parent, $left,$table,$fieldkey) {   
	   // the right value of this node is the left value + 1   
	   $right = $left+1;   

	   // get all children of this node   
  	   $sql = "exec sys_level_rebuild_tree 0,".$parent.",NULL,NULL ,'".$table."','".$fieldkey."'";
	   $result = $this->db->query($sql, true, "Query failed");	
	   while ($aR = $this->db->fetchByAssoc($result)) {   
	       // recursive execution of this function for each   
	       // child of this node   
	       // $right is the current right value, which is   
	       // incremented by the rebuild_tree function   
	       $right = $this->RebuildTree($aR[$fieldkey], $right,$table,$fieldkey);   
	   }   
	  
	   // we've got the left value, and now that we've processed   
	   // the children of this node we also know the right value   
	  // $sql = 'exec usp_vng_location_rebuild_tree 1,'.$parent.','.$left.','.$right.' ';
	   $sql = "exec sys_level_rebuild_tree 1,".$parent.",".$left.",".$right.",'".$table."','".$fieldkey."' ";
	   $this->db->query($sql, true, "Query failed");	 
	  
	   // return the right value of this node + 1   
	   return $right+1;   
	} 	

}