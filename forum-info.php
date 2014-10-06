<script>
	function AddComent(post_id,token){		
		var is_login = <? if(!is_login){ echo '0';}else{echo '1';}?>;
		if(is_login!=1){
			alert('<? echo get_lang('forum_text_error_login')?>');
		}
		var comment = $( "#comment" ).val();
		
		if(comment!='' && post_id>0){
			$.ajax({
					  type: "POST",
					  url: "<? echo forum_path ;?>/-100/0/thong-tin.html",
					  data: "tp=add_comment&post_id="+post_id+"&comment="+comment+"&token="+token,
					  success: function(msg){
						var js_obj = eval('(' + msg + ')'); 						
						
						var result = js_obj.result; 
						var data = js_obj.data; 
						if(result==1){
							$('#area_add_comment').append(data);
							$('#comment').val('');
						}else{
							if(result==-1){
								alert('<? echo get_lang('forum_text_error_login')?>');
							}else{
								alert('<? echo get_lang('forum_text_error_comment')?>');
							}
						}
						
					  }
			});
		}	
	}
</script>
<?php
if(!defined('TSEntry') || !TSEntry) die('Not A Valid Entry Point');


if($pageUrl=='' || $pageUrl =='?language=en' || $pageUrl == '?language=vi'){
	$pageUrl = 'trang-chu.html';
}
if(isset($_GET['language']) || strpos("?language",$pageUrl)>0){
	$pageUrl = str_replace('?language=en','',$pageUrl);
	$pageUrl = str_replace('?language=vi','',$pageUrl);
}
if((int)$cla_cid==0 && (int)$cla_nid==0){
	$pageUrl = 'trang-chu.html';
}
/*
echo "pageUrl: ".$pageUrl."<br>";
echo "cla_cid: ".$cla_cid."<br>";
echo "cla_nid: ".$cla_nid."<br>";
debug($_GET,1);
*/

//debug($_GET,1);
/*if ($cla_cid == "news"){
	echo 'news detail';
}
else */

if($pageUrl=='dang-bai.html'){
	page_post();
}else if($cla_nid>0){
	page_detail();
}else if($cla_cid>0){
	page_news();
}else{
	if ($cla_nid==0){
		switch($pageUrl){			
			case 'trang-chu.html':
				$result = page_news(true);
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

	function page_post(){
		global $db,$fullsite,$cla_cid,$cla_nid,$cla_site,$ts_config;
		$_msg = null;
		if(isset($_POST['title']) && __post('title')!=''){
			$result=array('result'=>-1,'data'=>'');
			if(!is_login()){
				$_msg['msg'] = get_lang('forum_post_error_1');
				$_msg['result'] =-1;
			}
			$user_info = get_user_info_login();
			$user_email = $user_info['email'];
			$title = __post('title');
			$category_id = __post('category_id');
			$content = __post('content');
			$status = 1;
			if($title!='' && $category_id >0 && $content!=''){
				$sSQL = " insert into ntk_forum_posts (cid,title_vi,content_vi,status,create_date,create_by)
						values(".(int)$category_id.",N'".$title."',N'".$content."',".$status.",NOW(),'".$user_email."')
						";
				$result = $db->query($sSQL, true, "Query failed");
				if($result!=NULL){	
					$sSQL ="	select * from ntk_forum_posts where `status` = 1 order by id desc limit 0,1 ";
					$result = $db->query($sSQL, true, "Query failed");
					if($aR = $db->fetchByAssoc($result)){
						$_msg['result'] = 1;
						$_msg['msg'] = get_lang('forum_post_success');
						$_msg['post_id'] = $aR['id'];
						$post_id = $aR['id'];
						$title_link = fnStrConvert($title);
						$title_link = str_replace(" ",'-',$title_link);
						$link_detail = forum_path."/".$category_id."/".$post_id."/".$title_link.".html";
					}
				}else{
					$_msg['result'] = -3;
					$_msg['msg'] = get_lang('forum_post_error_3');
				}
				
			}else{
				$_msg['result'] = -2;
				$_msg['msg'] = get_lang('forum_post_error_2');
			}
		}	
		if($_msg!=null){
			if($_msg['result']==1){
				$post_success = true;
				$_msg['msg']== '<span style="color:#0000FF; font-size:14px;">'.$_msg['msg'].'</span>';
			}else{
				$_msg['msg']== '<span style="color:#FF0000; font-size:14px;">'.$_msg['msg'].'</span>';
			}
		}
		$category_list = get_list_categories();
		include('themes/NTK/forum_post.php');
		
	}
	function get_list_categories(){
		global $db;
		$sql = "select * from ntk_forum_categories where `status` = 1 and parent_id > 0 order by 'order' asc ";
		$result = $db->query($sql, true, "Query failed");
		$list = array();
		$lang = '_'.get_language();		
		while($aR = $db->fetchByAssoc($result)) {
			$aR['id'] = $aR['category_id'];
			$aR['name'] = $aR['category_name'.$lang] != ''?$aR['category_name'.$lang]:$aR['category_name_vi'];
			$list[] = $aR;
		}
		return $list;
	}
	function home(){
		global $db,$fullsite,$cla_cid,$cla_nid,$cla_site,$ts_config;		
		$sql="SELECT * FROM ntk_news WHERE show_index = 1 ";		
		$sql.="ORDER BY news_order ASC,id ASC 	LIMIT 0,10 ";
		$result = $db->query($sql, true, "Query failed");
		while ($aR = $db->fetchByAssoc($result)) {	
			echo '<div class="news_title">'.$aR['title'].'</div>';
			echo '<div><div class="news_date">'.date2vndate($aR['create_date']).'</div><div class="news_download">';				
			$sql = " select t1.*,t2.file_type_name,t2.file_type_icon 
					from ntk_new_files t1
					left join ntk_file_type t2 on t1.file_type_id = t2.file_type_id
					where t1.new_id = ".(int)$aR['id']."
			";		
			$result_file = $db->query($sql, true, "Query failed");
			$i=0;				
			while ($aR_file = $db->fetchByAssoc($result_file)) {					
				if($aR_file['require_login']==1 && !is_login()){
					$href ='javascript:notLogin();';
				}else{
					$href =$ts_config['site_url_download_file'].$aR_file['file_path'];
				}
				if($i>0){echo ' | ';}					
				echo '<a href="'.$href.'"><img src="'.$fullsite.'/images/'.$aR_file['file_type_icon'].'"></a>';
				$i++;
			}		
			echo '</div></div>'; 				
			echo '<div class="news_short">'.$aR['short'].'</div>';
			echo '<hr size=2 style="color:#EFEFEF">';
		}
		
	}
	/**/
	
	function getListComment($post_id){
		global $db,$fullsite,$cla_cid,$cla_nid,$cla_site,$ts_config;
		$sSQL = " select t1.*,t2.full_name,t2.email
			from ntk_forum_comments t1
			left join ntk_users t2 on t1.user_id = t2.id
			where post_id = ".(int)$post_id ."
			order by create_date desc
		";
		$result = $db->query($sSQL, true, "Query failed");
		$html = '<div class="forum_comment_area">';
		
		$html .= '<div class="forum_comment_title">Danh sách bình luận</div>';
		$html .= '<div id="area_add_comment">';
		$i = 0;
		while ($aR = $db->fetchByAssoc($result)) {
			$class = "event";
			if($i%2==0){
				$class = "old";
			}
			$html_comment = '<div class="forum_comment '.$class.'">';
			
				$html_comment .= '<div class="forum_comment_header">';			
					$html_comment .= '<span class="forum_comment_full_name">'.$aR['full_name'].'</span>&nbsp;&nbsp;&nbsp;&nbsp;';
					$html_comment .= '<span class="forum_comment_date">'.date2vndate($aR['create_date'],true).'</span><br>';
				$html_comment .= '</div>';
				$html_comment .= '<div class="forum_comment_content">';
					$html_comment .= '&nbsp;&nbsp;&nbsp;&nbsp;'.$aR['content'];
				$html_comment .= '</div>';			
				
			$html_comment .= '</div>';
			$html.=$html_comment;
			$i++;
		}
		$html .= '</div>';
		// area comment
		
		$html .='
			<div id="comment_area">
				<div class="comment_title">'.get_lang('forum_comment_text').'</div>
				<textarea class="comment_inp" col="30" rows="5" id="comment" name="comment" ></textarea>
				<input onclick="javascript:AddComent('.$cla_nid.',\''.md5(md5($cla_nid)).'\');" type ="button" name="btncomment" id="btncomment" value="'.get_lang('forum_btncomment_text').'"/>
			</div>';
		
		//
		$html .='</div><br><br>';
		return $html;		
	}
	function page_detail(){		
		global $db,$fullsite,$cla_cid,$cla_nid,$cla_site,$ts_config;
		$lang = '_'.get_language();
		if ((int)$cla_cid>0 && (int)$cla_nid>0){
			$sql="SELECT *,1 as stt FROM ntk_forum_posts WHERE id =".(int)$cla_nid." and status = 1 ";
			$sql .=" union all ";
			$sql.="SELECT *,2 as stt FROM ntk_forum_posts WHERE id<> ".(int)$cla_nid." and cid=".(int)$cla_cid." and status = 1  ";			
			$sql.="ORDER BY stt,create_date DESC LIMIT 0,10 ";
			$result = $db->query($sql, true, "Query failed");
			$hasrelated = false;
			while ($aR = $db->fetchByAssoc($result)) {
				$new_id = $aR['id'];				
				$content = $aR['content'.$lang];
				$short = $aR['short'.$lang];
				if($aR['title'.$lang]!='' && $content!=''){
					if($new_id==$cla_nid){ // detail
						
						$title_url = '';
						$title_url = fnStrConvert($aR['title'.$lang]);
						$title_url = str_replace(" ",'-',$title_url);
						
						echo '<div class="news_title_detail">'.$aR['title'.$lang].'</div>';				
						
						echo '<div><div class="news_date">'.date2vndate($aR['create_date']).'</div><div class="news_download">';				
						/*
						$sql = " select t1.*,t2.file_type_name,t2.file_type_icon 
								from ntk_new_files t1
								left join ntk_file_type t2 on t1.file_type_id = t2.file_type_id
								where t1.new_id = ".(int)$aR['id']."
						";		
						$result_file = $db->query($sql, true, "Query failed");
						$i=0;
						while ($aR_file = $db->fetchByAssoc($result_file)) {					
							if($aR_file['require_login']==1 && !is_login()){
								$href ='javascript:notLogin();';
							}else{
								$href =$ts_config['site_url_download_file'].$aR_file['file_path'];
							}
							if($i>0){echo ' | ';}
							echo '<a href="'.$href.'"><img src="'.$fullsite.'/images/'.$aR_file['file_type_icon'].'"></a>';
							$i++;
						}*/
						echo '</div></div><br>';					
						//echo '<div class="news_short"><div style="width:25px; float:left;">&nbsp;</div><b>'.$short.'</b></div><br>';
						echo '<div class="news_short"><div style="width:25px; float:left;">&nbsp;</div>'.$content.'</div>';
						
						//echo '<hr size=2 style="color:#cccccc">';						
						if($new_id==$cla_nid){ // detail
							//echo '<div class="related_title">'.get_lang('text_related').'</div>';
						}
						
						$html_comment = getListComment($cla_nid);
						echo $html_comment;
						
					}else{// related
						if(!$hasrelated){
							echo '<hr size=2 style="color:#cccccc">';
							echo '<div style="clear:both;" class="related_title">'.get_lang('forum_text_related').'</div>';
						}
						echo '<div class="" style="margin-left:15px;font-size:11px;"><img src="'.$fullsite.'/images/next.png"/><a href="'.forum_path.'/'.(int)$aR['cid'].'/'.(int)$aR['id'].'/'.$title_url.'.html">'.$aR['title'.$lang].'</a> &nbsp;<span class="news_date1">('.date2vndate($aR['create_date']).') <span class="posted_by">'.get_lang('forum_posted_by').' '.$aR['create_by'].'</span></span></div>';
						//echo '<hr size=2 style="color:#cccccc">';
						$hasrelated = true;
					}
				}
			}
		}		
	}
	function page_news($home=false){	
		global $db,$fullsite,$cla_cid,$cla_nid,$cla_site,$ts_config;
		$lang = '_'.get_language();
		if ((int)$cla_cid>0 || $home){
			$sql="SELECT * FROM ntk_forum_posts WHERE  status = 1 ";
			if ((int)$cla_cid>0){
				$sql .=" and cid=".$cla_cid." ";
			}
			if ((int)$cla_nid>0)
				$sql.=" AND id = ".$cla_nid;
			if($home){
				//$sql.=" AND show_index = 1 ";
			}
			$sql.=" ORDER BY create_date DESC,modify_date DESC 	LIMIT 0,10 ";
			//echo $sql;die();
			$result = $db->query($sql, true, "Query failed");
			$i = 0;
			while ($aR = $db->fetchByAssoc($result)) {		
				if($aR['title'.$lang]!='' && $aR['content'.$lang]!=''){
					$title_url = '';
					$title_url = fnStrConvert($aR['title'.$lang]);
					$title_url = str_replace(" ",'-',$title_url);
										
					echo '<div class="news_title"><a href="'.forum_path.'/'.(int)$aR['cid'].'/'.(int)$aR['id'].'/'.$title_url.'.html">'.$aR['title'.$lang].'</a>';
					if($i<=5 && $home){
						echo '&nbsp;&nbsp;&nbsp;<img src="images/icon/new.gif">';
					}
					echo '</div>';
					echo '<div><div class="news_date">'.date2vndate($aR['create_date']).' <span class="posted_by">'.get_lang('forum_posted_by').' '.$aR['create_by'].'</span> </div><div class="news_download">';				
					/*
					$sql = " select t1.*,t2.file_type_name,t2.file_type_icon 
							from ntk_new_files t1
							left join ntk_file_type t2 on t1.file_type_id = t2.file_type_id
							where t1.new_id = ".(int)$aR['id']."
					";		
					$result_file = $db->query($sql, true, "Query failed");
					$i=0;				
					while ($aR_file = $db->fetchByAssoc($result_file)) {					
						if($aR_file['require_login']==1 && !is_login()){
							$href ='javascript:notLogin();';
						}else{
							$href =$ts_config['site_url_download_file'].$aR_file['file_path'];
						}
						if($i>0){echo ' | ';}		
						//$urlre = $sugar_config['site_url_download_file']."/download_file_case.php?fn=".$filePath;
						//header('location:'.$urlre.'');
						//die();					
						echo '<a href="'.$href.'"><img src="'.$fullsite.'/images/'.$aR_file['file_type_icon'].'"></a>';
						$i++;
					}*/		
					echo '</div></div><br>'; 				
					$short_description = substr($aR['content'.$lang],0,50);
					echo '<div class="news_short"><div style="width:25px; float:left;">&nbsp;</div>'.$short_description.'&nbsp;<a href="'.forum_path.'/'.(int)$aR['cid'].'/'.(int)$aR['id'].'/'.$title_url.'.html">'.get_lang('text_detail').'</a></div>';
					echo '<hr size=2 style="color:#cccccc">';
					$i++;
				}
			}
		
		}
	}