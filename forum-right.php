<?php
if(!defined('TSEntry') || !TSEntry) die('Not A Valid Entry Point');

// get adv
$sql="SELECT * FROM ntk_adv WHERE status = 1 ";		
$sql.=" ORDER BY `order` ASC	LIMIT 0,6 ";
$result = $db->query($sql, true, "Query failed");
$adv_list = array();
while ($aR = $db->fetchByAssoc($result)) {
	$adv_list[] = $aR;
}
// end get adv


?>
<!-- BEGIN: RIGHT COLUMN -->
	<div id="ja-col2">
		<div class="ja-innerpad">
			<div class="module">
				<div>
					<?if($_SESSION[_PLATFORM_]['is_login'] && is_array($_SESSION[_PLATFORM_]['USER_INFO'])){?>
					<!--<div>
						<div>
							<? echo get_lang('hello'); ?> <b><a title="Thông tin thành viên" href="<?=$fullsite?>/0/0/thong-tin-thanh-vien.html"><?php echo $_SESSION[_PLATFORM_]['USER_INFO']['full_name']?></a></b>
							<br>
							<a title="<? echo get_lang('logout_link'); ?>" href="<?=$fullsite?>/0/0/dang-xuat.html"><? echo get_lang('logout_link'); ?></a>
						</div>	
					</div>-->				
					<?
					}else{?>					
					<!--begin-login-->
					<!--<div>
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
					</div>-->
					<?
					}					
					?>
					<div>
						<div>
							<div class="lft-title" style="background-color:#71baf1;">&nbsp;Quảng cáo
							</div>
							<br>
							<div align="center">							
								<? 
								foreach($adv_list as $k=>$adv){
								?>
									<div style="margin:5px 0px 5px 0px; border-bottom:#ccc solid 1px;">
										<a target="_blank" href="<?echo $adv['adv_link'];?>"><img width="187px" height="187px" src="<?=$fullsite?>/images/adv/<? echo $adv['adv_image'];?>" alt="<? echo $adv['adv_name'];?>" /></a>
									</div>
								<?
								}
								?>
							</div>					
						</div>
					</div>
				</div>
			</div>	
		</div>
	</div>
	<br />
	<!-- END: RIGHT COLUMN -->	