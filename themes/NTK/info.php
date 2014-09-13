<script>
	function getHospital(){
		var province_id = $( "#province_id option:selected" ).val();
		if(province_id>0){
			$.ajax({
					  type: "POST",
					  url: "index.php?module=SSToolReport&action=Ajax&sugar_body_only=true",
					  data: "tp=get_total_record_export&from_date="+from_date+"&to_date="+to_date+"&type_id="+type_id+"&group_id="+group_id+"&token="+token,
					  success: function(msg){
							 //alert(msg);
							 var js_obj = eval('(' + msg + ')');                      
							 if(js_obj.length>0)              
							 {    
								  var total = js_obj[0].total;
								  var input = js_obj[0].input;
								  //alert(total);
								  //alert(input);
								  $('#form1 #total_record').val(total);                             
								  $('#export_area #html_page_export').html(input);
								  //var val = js_obj[i].record_id;
								  //var text = js_obj[i].item;
								  //var tmp=' ';
								  //loccity.append($('<option  '+tmp+'></option>').val(val).html(text))
							 }         
								 
					  }
			});
		}
	}
</script>
<h1>Thông tin thành viên</h1>

<?php if($update_success==true){ ?>
	<div style="text-align:center;color:#0000FF;margin-button:10px;">Cập nhật thông tin thành công.</div>
<?}?>

<form id="frm_register" name="frm_register" method="POST" action="<?php echo $fullsite?>/0/0/thong-tin-thanh-vien.html">
	<div style="text-align:center;color:#FF0000;"><? echo $msg ;?></div>
	<table class="table_info">
		<tr>
			<th>Email</th>
			<td><?php echo $user_info['email'];?></td>
		</tr>
		<tr>
			<th>Họ tên</th>
			<td><input type="full_name" name="full_name" value="<?php echo $user_info['full_name'] ;?>"/></td>
		</tr>
		<tr>
			<th>Tỉnh thành</th>
			<td>
				<select onchange="getHospital();" name="province_id" id="province_id">
					<option value="">-- Chọn tỉnh thành --</option>
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
			<th>Bệnh viện đang công tác</th>
			<td>
				<select name="hospital_id" id="hospital_id">
					<option value="">-- Chọn Bệnh Viện --</option>
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
			<th>Chuyên khoa</th>
			<td>
				<select name="department_id" id="department_id">
					<option value="">-- Chọn Chuyên khoa --</option>
					<?php
						foreach($department_list as $k=>$va){							
							if($user_info['department_id']==$va['id']){
							?>
								<option selected="selected" value="<? echo $va['id'];?>"><? echo $va['name'] ;?></option>
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
				<input style="text-align:center;" type="submit" name="btnregister" value="CẬP NHẬT THÔNG TIN"/>
			</td>
		</tr>
										
	</table>
</form>
