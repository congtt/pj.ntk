
<script>
	function getHospital(){
		var province_id = $( "#province_id option:selected" ).val();
		var hospital = $('#hospital_id');
		$("#hospital_id option[value!='']").remove();
		if(province_id>0){
			$.ajax({
					  type: "POST",
					  url: "<? echo $fullsite?>/-100/0/thong-tin-a.html",
					  data: "tp=get_hospital&province_id="+province_id+"&token=",
					  success: function(msg){							 
						 var js_obj = eval('(' + msg + ')');                      
						 if(js_obj.length>0)              
						 {  
							for (i=0;i<js_obj.length;i++){
								var val = js_obj[i].id;
								var text = js_obj[i].name;
								var tmp=' ';
								hospital.append($('<option  '+tmp+'></option>').val(val).html(text))
							}
						 }  
					  }
			});
		}
	}
	function postNews(is_login){
		if(is_login!=1){
			alert('<? echo get_lang('forum_post_error_1');?>');return;
		}
		if($('#title').val()==''){
			alert('<? echo get_lang('forum_post_req_title');?>');
			$('#title').focus();
			return;
		}else if($('#category_id option:selected').val()==''){
			alert('<? echo get_lang('forum_post_req_topic');?>');
			$('#category_id').focus();
			return;
		}else if($('#content').val()==''){
			alert('<? echo get_lang('forum_post_req_content');?>');
			$('#content').focus();
			return;
		}
		document.frm_post.submit();
	}
</script>
<style>
	.table_info_1 th{font-weight:bold;}
</style>
<h1><?php echo get_lang('forum_post_title');?></h1>

<?php  if($post_success==true){ ?>
	<div style="text-align:center;color:#0000FF;font-size:15px;"><?php echo get_lang('forum_post_success');?>
		<a href="<? echo $link_detail; ?>"><? echo get_lang('forum_post_success_detail');?></a>
	</div>
<?	
}else{
?>
<form id="frm_post" name="frm_post" method="POST" action="<?php echo forum_path?>/-1/0/dang-bai.html">
	<div style="text-align:center;color:#FF0000;"><? echo $msg ;?></div>
	<table class="table_info_1">
		<tr>
			<th style="width:100px;"><?php echo get_lang('forum_post_text_title');?></td>
			<td><input id="title" style="width:300px;" type="text" name="title" value=""/></td>
		</tr>
		<tr>			
			<td colspan="2"><?php echo $_msg['msg'];?></td>
		</tr>
		<!--<tr>
			<th><?php echo get_lang('forum_post_text_short');?></td>
			<td><textarea cols="30" rows="5" name="short" ></textarea></td>
		</tr>-->
		<tr>
			<th><?php echo get_lang('forum_post_text_category');?></td>
			<td>
				<select name="category_id" id="category_id">
					<option value="">-- <?php echo get_lang('forum_post_text_category');?> --</option>
					<?php
						foreach($category_list as $k=>$va){
							?>							
							<option value="<? echo $va['id']?>"><? echo $va['name'] ?></option>
							<?
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<th colspan="2"><?php echo get_lang('forum_post_text_content');?></td>	
		</tr>
		<tr>
			<th>&nbsp;</td>
			<td><textarea  id="content" style="width:500px;height:400px;" cols="30" rows="5" name="content"></textarea></td>
		</tr>
		<tr> 
			<td align="center" colspan="2">
			<br />
				<input style="text-align:center;" type="button" onclick="postNews(<?php if(is_login()) echo '1'; else echo '0'; ?>);" name="btnpost" value="<?php echo get_lang('forum_post_btnpost');?>"/>
			</td>
		</tr>
										
	</table>
</form>
<?
}

?>
