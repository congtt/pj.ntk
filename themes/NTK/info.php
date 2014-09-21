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
<h1><?php echo get_lang('info_title');?></h1>

<?php if($update_success==true){ ?>
	<div style="text-align:center;color:#0000FF;margin-button:10px;font-size:15px;"><?php echo get_lang('update_success');?></div>
<?}?>

<form id="frm_register" name="frm_register" method="POST" action="<?php echo $fullsite?>/0/0/thong-tin-thanh-vien.html">
	<div style="text-align:center;color:#FF0000;"><? echo $msg ;?></div>
	<table class="table_info">
		<tr>
			<th><?php echo get_lang('register_email');?></th>
			<td><?php echo $user_info['email'];?></td>
		</tr>
		<tr>
			<th><?php echo get_lang('register_fullname');?></th>
			<td><input type="full_name" name="full_name" value="<?php echo $user_info['full_name'] ;?>"/></td>
		</tr>
		<tr>
			<th><?php echo get_lang('register_province');?></th>
			<td>
				<select onchange="getHospital();" name="province_id" id="province_id">
					<option value="">-- <?php echo get_lang('register_province_select');?> --</option>
					<?php
						foreach($province_list as $k=>$va){
							if($user_info['province_id']==$va['id']){
							?>							
								<option selected="selected" value="<? echo $va['id'];?>"><? echo $va['name']; ?></option>
							<?
							}else{ ?>
								<option value="<? echo $va['id'];?>"><? echo $va['name']; ?></option>
							<?
						}
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<th><?php echo get_lang('register_hospital');?></th>
			<td>
				<select name="hospital_id" id="hospital_id">
					<option value="">-- <?php echo get_lang('register_hospital_select');?> --</option>
					<?php
						foreach($hospital_list as $k=>$va){							
							if($user_info['hospital_id']==$va['id']){
							?>
								<option selected="selected" value="<? echo $va['id'];?>"><? echo $va['name']; ?></option>
							<?
							}else{ ?>
								<option value="<? echo $va['id'];?>"><? echo $va['name']; ?></option>
							<?							
						}
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<th><?php echo get_lang('register_department');?></th>
			<td>
				<select name="department_id" id="department_id">
					<option value="">-- <?php echo get_lang('register_department_select');?> --</option>
					<?php
						foreach($department_list as $k=>$va){							
							if($user_info['department_id']==$va['id']){
							?>
								<option selected="selected" value="<? echo $va['id'];?>"><? echo $va['name'.] ;?></option>
							<?
							}else{ ?>
								<option value="<? echo $va['id'];?>"><? echo $va['name']; ?></option>
							<?
						}
					}
					?>
				</select>
			</td>
		</tr>
		
		<tr> 
			<td align="center" colspan="2">
			<br />
				<input style="text-align:center;" type="submit" name="btnregister" value="<?php echo get_lang('info_btnupdate');?>"/>
			</td>
		</tr>
										
	</table>
</form>
