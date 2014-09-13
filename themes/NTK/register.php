
<h1><?php echo get_lang('register_title');?></h1>

<?php  if($register_success==true){ ?>
	<div style="text-align:center;color:#0000FF;"><?php echo get_lang('register_success');?></div>
<?	
}else{
?>
<form id="frm_register" name="frm_register" method="POST" action="<?php echo $fullsite?>/0/0/dang-ky.html">
	<div style="text-align:center;color:#FF0000;"><? echo $msg ;?></div>
	<table class="table_info">
		<tr>
			<th><?php echo get_lang('register_email');?></td>
			<td><input type="text" name="email" value=""/></td>
		</tr>
		<tr>
			<th><?php echo get_lang('register_password');?></td>
			<td><input type="password" name="password" value=""/></td>
		</tr>
		<tr>
			<th><?php echo get_lang('register_password_re');?></td>
			<td><input type="password" name="re_password" value=""/></td>
		</tr>
		<tr>
			<th><?php echo get_lang('register_fullname');?></td>
			<td><input type="full_name" name="full_name" value=""/></td>
		</tr>
		<tr>
			<th><?php echo get_lang('register_province');?></td>
			<td>
				<select name="province_id" id="province_id">
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
				<select name="hospital_id" id="hospital_id">
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
			<th><?php echo get_lang('register_department');?></td>
			<td>
				<select name="department_id" id="department_id">
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
			<td align="center" colspan="2">
			<br />
				<input style="text-align:center;" type="submit" name="btnregister" value="<?php echo get_lang('register_btnregister');?>"/>
			</td>
		</tr>
										
	</table>
</form>
<?
}

?>
