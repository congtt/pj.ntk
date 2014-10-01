<?php
if(!defined('TSEntry') || !TSEntry) die('Not A Valid Entry Point');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-gb" lang="en-gb">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><? echo get_lang('site_title');?></title>
	<link href="<?=$fullsite?>/css/style.css" rel="stylesheet" media="all" />

	<link type="text/css" href="<?=$fullsite?>/css/template.css" rel="stylesheet">
	<link href="<?=$fullsite?>/themes/admintasia/css/styles/light_blue/ui.css" rel="stylesheet" title="style" media="all" />
	<link rel="stylesheet" href="<?=$fullsite?>/css/ui/css/redmond/jquery-ui.custom.css" type="text/css">
	<link rel="stylesheet" href="<?=$fullsite?>/css/login.css" type="text/css">	
	<style>
.myClass {
  background-color: #88FF88;
} 
</style>
	
	<script type="text/javascript" src="<?=$fullsite?>/css/jquery-1.4.2.min.js"></script>	
	<!--<script type="text/javascript" src="<?=$fullsite?>/css/site.js"></script>-->
<script>
$(document).ready(
  /* This is the function that will get executed after the DOM is fully loaded */
  function () {	
    /* Next part of code handles hovering effect and submenu appearing */
    $('.nav li').hover(
      function () { //appearing on hover
        $('ul', this).fadeIn();
      },
      function () { //disappearing on hover
        $('ul', this).fadeOut();
      }
    );
  }
);
</script>


<script type="text/javascript">
$(function(){  
    $('#button_login').click(function(){
        var $leftLogin=$('#den_mo').width();//lấy chiều rộng thẻ #den_mo
        var $topLogin=$('#den_mo').height();//lấy chiều cao thẻ #den_mo
        var $heightLogin=$('#login').height();//lấy chiều cao thẻ #login
        $('#login').css({'left':($leftLogin-300)/2,'top':($topLogin-$heightLogin-20)/2});//canh ra giữa trang     web+thêm 10px len trên
        $('#den_mo,#login').fadeIn();//cho hiện đèn và khung LOGIN		
    });
    $('#login_close').click(function(){
        $('#den_mo,#login').hide();//ĐÓNG đèn mờ và khung LOGIN
    });
});
</script>
</head>

<body id="bd" class=" wide fs3" >
<div id="den_mo">

</div>

<div id="login">
    <div id="content_login">
        <div class="lft-title" style="background-color:#71baf1;">&nbsp;<? echo get_lang('login_title'); ?>
		</div>
		<br />
        <div id="login_main">
            <form name="frm_login" id="frm_login" action="<?=$fullsite?>/0/0/dang-nhap.html" method="POST" >
				<div align="center">
					<table>
						<tr>
							<td><? echo get_lang('login_text_email'); ?></td>						
							<td><input type="text" style="width:130px;" id="email" name="email" value=""></td>
						</tr>
						<tr>
							<td><? echo get_lang('login_text_password'); ?></td>
						
							<td><input type="password" style="width:130px;"  id="password" name="password" value=""></td>
						</tr>
						<tr>
							<td colspan="2">
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
        <div style="text-align:center;"><input id="login_close" type="submit" value="<? echo get_lang('login_text_close');  ?>"/></div>
    </div><!--end#content_login-->
</div><!--end#login-->

<div id="ja-wrapper">

<!-- BEGIN: CPANEL -->
<div id="ja-cpanel">
		<div id="ja-search">
		<div id="jflanguageselection">
			<div class="rawimages">
				<?if($_SESSION[_PLATFORM_]['is_login'] && is_array($_SESSION[_PLATFORM_]['USER_INFO'])){?>
					
					<span>						
						<span style="color:#FFF;"><? echo get_lang('hello'); ?></span> <b><a title="Thông tin thành viên" href="<?=$fullsite?>/0/0/thong-tin-thanh-vien.html"><?php echo $_SESSION[_PLATFORM_]['USER_INFO']['full_name']?></a></b>
						&nbsp;&nbsp; <a title="<? echo get_lang('logout_link'); ?>" href="<?=$fullsite?>/0/0/dang-xuat.html">[<? echo get_lang('logout_link'); ?>]</a>
					</span>	
				<?
				}else{?>
						<span>
					<a id="button_login"> 
						<?echo get_lang('login_title')?>
					</a>
					&nbsp;&nbsp;&nbsp;
					<span style="color:#FFF;"><? echo get_lang('login_text_register_here'); ?> <a href="<?=$fullsite?>/0/0/dang-ky-thanh-vien.html"><? echo get_lang('login_text_register_here_here'); ?></a></span>
					</span>	
				
				<?
				}
				?>
				&nbsp;&nbsp;&nbsp;			
				<span>
					<a href="?language=vi"> 
						<img src="<?=$fullsite?>/images/vi.gif" alt="Viet Nam" title="Viet Nam"/>
					</a>
				</span>
				<span id="active_language">
					<a href="?language=en">
						<img src="<?=$fullsite?>/images/en.gif" alt="English (United Kingdom)" title="English (United Kingdom)" />
					</a>
				</span>
			</div>
		</div>
		
<!-- &copy; 2003-2009 Think Network, released under the GPL. -->
<!-- More information: at http://www.joomfish.net -->

	</div>	
		
	<div id="ja-pathway">
	<strong></strong>
	</div>
	
</div>
<!-- END: CPANEL -->

<!-- BEGIN: HEADER -->
<div id="ja-header" class="clearfix">

		<h1 class="logo">
		<a href="<?=$fullsite?>" title="Hội Phẫu Thuật Thần Kinh Việt Nam"><span>Hội Phẫu Thuật Thần Kinh Việt Nam</span></a>
	</h1>
	
		
<!-- BEGIN: MAIN NAVIGATION -->

    <div id="flash">
	<img src="<?=$fullsite?>/images/banneren.jpg" alt="" /><br />		
    </div>


<div id="ja-mainnavwrap">
 
<div class="navigation" id="ja-mainnav">

<div id="ja-mainnav" class="navigation">
          <ul class="nav">
          <li><a style="cursor:pointer" href="<? echo forum_path ;?>" id="" title="" data-actor=""><span><? echo get_lang('text_home_forum') ;?></span></a>
            </li>         
          </ul>
</div>

<?
$page_menu = forum_menu(-1,0,'nav');
echo $page_menu;
?>
</div>

</div>
<!-- END: MAIN NAVIGATION -->
  
</div>
<!-- END: HEADER -->