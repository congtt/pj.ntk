
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
</script>
<div class="lft-title" style="background-color:#71baf1;"><?php echo get_lang('register_title');?></div>
<div class="group_content" style="margin-left:50px;margin-top:20px;">
<?php  if($register_success==true){ ?>
	<div style="text-align:center;color:#0000FF;font-size:15px;"><?php echo get_lang('register_success');?></div>
<?	
}else{
?>
<form id="frm_register" name="frm_register" method="POST" action="<?php echo $fullsite?>/0/0/dang-ky.html">
	<div style="text-align:center;color:#FF0000;"><? echo $msg ;?></div>
	<table class="table_info">
		<tr>
			<th width="200px" ><?php echo get_lang('register_email');?></td>
			<td><input style="width:250px;" type="text" name="email" value=""/></td>
		</tr>
		<tr>
			<th><?php echo get_lang('register_password');?></td>
			<td><input style="width:250px;"type="password" name="password" value=""/></td>
		</tr>
		<tr>
			<th><?php echo get_lang('register_password_re');?></td>
			<td><input style="width:250px;"type="password" name="re_password" value=""/></td>
		</tr>
		<tr>
			<th><?php echo get_lang('register_fullname');?></td>
			<td><input style="width:250px;"type="full_name" name="full_name" value=""/></td>
		</tr>
		<tr>
			<th><?php echo get_lang('register_province');?></td>
			<td>
				<select onchange="getHospital();" style="width:270px;" name="province_id" id="province_id">
					<option value="">-- <?php echo get_lang('register_province_select');?> --</option>
					<?php
						foreach($province_list as $k=>$va){
							?>							
							<option value="<? echo $va['id']?>"><? echo $va['name'] ?></option>
							<?
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<th><?php echo get_lang('register_hospital');?></td>
			<td>
				<select name="hospital_id" style="width:270px;" id="hospital_id">
					<option value="">-- <?php echo get_lang('register_hospital_select');?> --</option>
					<?php
						foreach($hospital_list as $k=>$va){
							?>							
							<option value="<? echo $va['id']?>"><? echo $va['name'] ?></option>
							<?
						}
					?>
				</select>				
			</td>
		</tr>
		<tr>
			<th><?php echo get_lang('register_hospital_orther');?></td>
			<td>
				<input style="width:250px;"type="text" name="hospital_name" value=""/>
			</td>
		</tr>
		<tr>
			<th><?php echo get_lang('register_department');?></td>
			<td>
				<select name="department_id" style="width:270px;" id="department_id">
					<option value="">-- <?php echo get_lang('register_department_select');?> --</option>
					<?php
						foreach($department_list as $k=>$va){
							?>							
							<option value="<? echo $va['id']?>"><? echo $va['name'] ?></option>
							<?
						}
					?>
				</select>
			</td>
		</tr>
		
		<tr>
			<td align="center" ></td>
			<td align="center" style="padding-left:50px;" >
			<br />
				<input style="text-align:center;" type="submit" name="btnregister" value="<?php echo get_lang('register_btnregister');?>"/>
			</td>
		</tr>
										
	</table>
</form>

<?
}

?>
</div>
