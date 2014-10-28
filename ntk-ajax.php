
<?php
if(!defined('TSEntry') || !TSEntry) die('Not A Valid Entry Point');
    
	$tp =  $_POST['tp']; 
	switch($tp){
		case 'get_hospital':
			$arr_data = get_hospital();
			die(json_encode($arr_data));			
			break;
		case 'add_comment':
			add_comment();			
			break;
		default:
			break;
	}	
		function add_comment(){
			global $db,$fullsite,$cla_cid,$cla_nid,$cla_site,$ts_config;
			$result=array('result'=>-1,'data'=>'');
			if(!is_login()){
				die(json_encode($result));
			}
			$user_info = get_user_info_login();
			$user_id = get_userid();
			$comment = __post('comment');
			$post_id = (int)__post('post_id');
			$token = __post('token');
			$tokenCheck = md5(md5($post_id));
			if($token!=$tokenCheck){
				$result['result'] = -2;
				die(json_encode($result));
			}
			$sSQL = " insert into ntk_forum_comments(user_id,post_id,content,`status`,create_date)
				values($user_id,$post_id,'$comment',0,NOW() )
			";
			$resultSQL = $db->query($sSQL, true, "Query failed");
			$result['result'] = 1;	
			$html_comment = '<div class="forum_comment '.$class.'">';
			
				$html_comment .= '<div class="forum_comment_header">';			
					$html_comment .= '<span class="forum_comment_full_name">'.$user_info['full_name'].'</span>&nbsp;&nbsp;&nbsp;&nbsp;';
					$html_comment .= '<span class="forum_comment_date">'.date("d/m/Y H:i:s").'</span><br>';
				$html_comment .= '</div>';
				$html_comment .= '<div class="forum_comment_content">';
					$html_comment .= '&nbsp;&nbsp;&nbsp;&nbsp;<pre>'.$comment.'<pre>';
				$html_comment .= '</div>';			
				
			$html_comment .= '</div>';			
			$result['data'] = $html_comment;
			die(json_encode($result));
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
				$name = $aR['name'];//.$lang];
				$arr[$i]['id'] = $id;
				$arr[$i]['name'] = $name;
				$i++;
			}			
			return $arr;
		}
	}