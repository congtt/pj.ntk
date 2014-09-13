
<h1>Đăng ký thành viên</h1>

<?php  if($register_success==true){ ?>
	<div style="text-align:center;color:#0000FF;">Chúc mừng bạn đã đăng ký thông tin thành công.</div>
<?	
}else{
?>
<form id="frm_register" name="frm_register" method="POST" action="<?php echo $fullsite?>/0/0/dang-ky.html">
	<div style="text-align:center;color:#FF0000;"><? echo $msg ;?></div>
	<table class="table_info">
		<tr>
			<th>Email</td>
			<td><input type="text" name="email" value=""/></td>
		</tr>
		<tr>
			<th>Mật khẩu</td>
			<td><input type="password" name="password" value=""/></td>
		</tr>
		<tr>
			<th>Nhập lại mật khẩu</td>
			<td><input type="password" name="re_password" value=""/></td>
		</tr>
		<tr>
			<th>Họ tên</td>
			<td><input type="full_name" name="full_name" value=""/></td>
		</tr>
		<tr>
			<th>Tỉnh thành</td>
			<td>
				<select name="province_id" id="province_id">
					<option value="">-- Chọn tỉnh thành --</option>
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
			<th>Bệnh viện đang công tác</td>
			<td>
				<select name="hospital_id" id="hospital_id">
					<option value="">-- Chọn Bệnh Viện --</option>
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
			<th>Chuyên khoa</td>
			<td>
				<select name="department_id" id="department_id">
					<option value="">-- Chọn Chuyên khoa --</option>
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
				<input style="text-align:center;" type="submit" name="btnregister" value="ĐĂNG KÝ THÀNH VIÊN"/>
			</td>
		</tr>
										
	</table>
</form>
<?
}

?>
