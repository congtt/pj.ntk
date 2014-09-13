<?php
if(!defined('TSEntry') || !TSEntry) die('Not A Valid Entry Point');
?>
<!-- BEGIN: RIGHT COLUMN -->
	<div id="ja-col2">
		<div class="ja-innerpad">
			<div class="module">
				<div>
					<?if($_SESSION[_PLATFORM_]['is_login'] && is_array($_SESSION[_PLATFORM_]['USER_INFO'])){?>
					<div>
						<div>
							<? echo get_lang('hello'); ?> <b><a title="Thông tin thành viên" href="<?=$fullsite?>/0/0/thong-tin-thanh-vien.html"><?php echo $_SESSION[_PLATFORM_]['USER_INFO']['full_name']?></a></b>
							<br>
							<a title="<? echo get_lang('logout_link'); ?>" href="<?=$fullsite?>/0/0/dang-xuat.html"><? echo get_lang('logout_link'); ?></a>
						</div>	
					</div>					
					<?
					}else{?>					
					<!--begin-login-->
					<div>
						<div>
							<div class="lft-title" style="background-color:#71baf1;">&nbsp;<? echo get_lang('login_title'); ?>
							</div>
							<br />
							<form name="frm_login" id="frm_login" action="<?=$fullsite?>/0/0/dang-nhap.html" method="POST" >
								<div align="center">
									<table>
										<tr>
											<td><? echo get_lang('login_text_email'); ?></td>
										</tr>
										<tr>
											<td><input type="text" style="width:130px;" id="email" name="email" value=""></td>
										</tr>
										<tr>
											<td><? echo get_lang('login_text_password'); ?></td>
										</tr>
										<tr>
											<td><input type="password" style="width:130px;"  id="password" name="password" value=""></td>
										</tr>
										<tr>
											<td>
												<input style="text-align:center" type="submit" name="btnlogin" value="<? echo get_lang('login_text_btn_login'); ?>"/>
											</td>
										</tr>
										<tr>
											<td>
												<span style=""><? echo get_lang('login_text_register_here'); ?> <a href="<?=$fullsite?>/0/0/dang-ky-thanh-vien.html"><? echo get_lang('login_text_register_here_here'); ?></a></span>
											</td>
										</tr>
										
									</table>
								</div>
							</form>
						</div>
					</div>
					<!--end-login-->
					<?
					}					
					?>
					<div>
						<div>
							<div class="lft-title" style="background-color:#71baf1;">&nbsp;Quảng cáo
							</div>
							<br>
							<div align="center"><img src="<?=$fullsite?>/images/adv/1.jpg" alt="" /><br />
								<br /><img src="<?=$fullsite?>/images/adv/2.jpg" alt="" /><br />
								<br /><img src="<?=$fullsite?>/images/adv/3.jpg" alt="" /><br />
								<br /><img src="<?=$fullsite?>/images/adv/4.jpg" alt="" /><br />
								<br /><img src="<?=$fullsite?>/images/adv/5.jpg" alt="" /><br />
								<br />
							</div>					
						</div>
					</div>
				</div>
			</div>	
		</div>
	</div>
	<br />
	<!-- END: RIGHT COLUMN -->	