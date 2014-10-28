

	
	<?if(!defined('TSEntry') || !TSEntry) die('Not A Valid Entry Point');
$datetime = date('d/m/Y H:i:s');
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>ADMIN NEUROSURGICAL SOCIETY OF VIETNAM</title>
	<link href="../css/style.css" rel="stylesheet" media="all" />	
	<link href="../themes/admintasia/css/styles/light_blue/ui.css" rel="stylesheet" title="style" media="all" />
	<link rel="stylesheet" href="../css/ui/css/redmond/jquery-ui.custom.css" type="text/css">
	<style>
.myClass {
  background-color: #88FF88;
} 

/* Make Header Sticky */
#top-menu {background:#2c8cd7;border:1px solid #666; height:60px; left:0; position:fixed; width:100%; top:0;z-index:10000 }

 


</style>
	<script type="text/javascript" src="../css/jquery17.js"></script>
	
	<!--<script src="../css/rloader1.5.4_min.js"></script>-->
	<script type="text/javascript" src="../css/dialog.js"></script>
	<script type="text/javascript" >	
	var fmenu = true;				
				
				$(document).ready(function() { 
				
					var rMenu = $.cookie('rMenu');
					if(rMenu==null || rMenu=='Show'){	
						
							$('#sidebar').attr('style','margin-left:0px');
							$('#main-content').attr('style','margin-left:235px');
							fmenu=true;
					}else{
							$('#sidebar').attr('style','margin-left:-215px');
							$('#main-content').attr('style','margin-left:20px');		
							fmenu=false;
					}


					$('#sidebar').dblclick(function() {
						if (fmenu==true)
						{
							$(this).attr('style','margin-left:-215px');
							$('#main-content').attr('style','margin-left:20px');
							fmenu=false;
							$.cookie('rMenu', 'Hide' );
						}else{
							$(this).attr('style','margin-left:0px');
							$('#main-content').attr('style','margin-left:235px');	
							fmenu=true;
							$.cookie('rMenu', 'Show' );
						}						
					});

				<?if (!is_login()){?>	
					//$('#FLogin').fadeIn();
					$('#sidebar').attr('style','display:none');
					$('#main-content').attr('style','margin-left:0px');
					$('#username').focus();
					$('input').keypress(function(event){			
						if (event.keyCode==13){				
							$("#login_button").click();
						}
					})
				<?}?>
				
		
				
					
					// Navigation menu
				
					$('#page_menu').superfish({ 
						delay:       1,
						animation:   {opacity:'show',height:'show'},
						speed:       'fast',
						autoArrows:  true,
						dropShadows: true
					}).show();
					
				
				

				
					

	
				
				var myDate = new Date('2010/01/01');

					// Datepicker
					$('#datepicker').datepicker({
						inline: true
						,onSelect: function(dateText, inst) {}
						,altField: '#actualDate'
					});
					
					/*var special_dates = new Array(1,10,13);
					var dates = $("#datepicker table tr td");
					$(dates).each(function(i, d) {
						var a = $(this); 
						//alert(i)
						//alert(a.html())
						
						for (var i1 in special_dates)
					{
							
							
							if (special_dates[i1]==(i+1)){
								//a.attr('style','color:red');
								//a.html('<span title="AAAAA">'+(i+1)+'</span>')
							}
					}						
					 //alert($(dates).addClass('myClass'))
					});   					 */
					
					<?echo $cla->scriptHeader();?>	
					
				});
	</script>

</head>

<body>
	<div id="header">

		<div id="top-menu">
		<?if (is_login()){?>
		<div style="float:left;color:#FFF;width:300px;line-height:28px;text-align:left">
		&nbsp;&nbsp;&nbsp;<?
			$default_top_left_link='do?module=Login&action=signin';
			if (is_login()){
				$default_top_left_link='do?module=Home&action=List';
			}
			$top_left_link_tmp='';
			foreach($top_left_link as $k=>$vl){
				$cl_color='color:#CCC';
				if ($k==$top_left_link_type)
					$cl_color='color:#FFF;font-weight:bold';
				if ($top_left_link_tmp!='')
					$top_left_link_tmp.=' | ';
				$top_left_link_tmp.='<a href="'.($vl['link']!=''?$vl['link']:$default_top_left_link.'&type='.$k.'&no_body=true'.$vl['url_prefix']).'" style="'.$cl_color.'">'.$vl['name'].'</a>';
			}
			echo $top_left_link_tmp;
			$urlref=base64_encode($_SERVER["REQUEST_URI"]);
		?>
		</div>					
				<span>Tài khoản : <a href="do?module=Login&action=signout&no_body=true" title="Đăng nhập với tài khoản <?=$ts_info['User_Name']?>"><?=$ts_info['Full_Name']?></a> | 
				<!--<a href="javascript:dg_add_2('HHFeedback','FeedbackAdd',0,'','Góp ý ban quản trị',500,400,'<?=$urlref?>')" title="Góp ý cho ban quản trị">Góp ý</a> |-->
				<a href="do?module=Login&action=signout&no_body=true" title="Thoát">Thoát</a></span>
			<?}else{?>
				<a href="do?module=Login&action=signin"   title="Đăng nhập vào hệ thống">Đăng nhập</a>
			<?}?> &nbsp;&nbsp;&nbsp;
		</div>
		<div id="sitename" style="">
			<div  style="float:left;border-width:0px;border-style:solid"><a href="do?module=Home&action=List&mnl=1&no_body=true&type=1" class="logo float-left" title="<?=$ts_config['site_title']?>"  ><?=$ts_config['site_title']?></a>			
			</div>
			
			<div  style="float:right;text-align:right;padding:5px;border-width:0px;border-style:solid;height: 34px;display:none" id="notif_area">	
			  
				<?if (is_login()){?>
				<ul class="nav-list">
				<!--<li><a href="index.html" class="nav-link">Profile <span class="nav-counter nav-counter-green">4</span></a></li>-->
				<li><a href="#" class="nav-link" id="eform_href">Duyệt Eform <span class="nav-counter nav-scounter-blue" id="eform_count">0</span></a></li>
				<li><a href="#" class="nav-link" id="holiday_href">Duyệt Nghỉ phép <span class="nav-counter nav-scounter-blue" id="holiday_count">0</span></a></li>
				</ul>

				<?}?>
			  </div>

			</div>		
		<?echo $cla->siteHeader();?>	
		<div style="border:0px solid red;height:40px">
			<div style="width:600px;float:left">
			<?if (is_login()){		
				if (!isset($_SESSION[_PLATFORM_]["CLA"]['MENU'])|| __post2('menureload')==1|| __post2('mnl')==1){
					$_SESSION[_PLATFORM_]["CLA"]['MENU'] = $cla->_Menu2(-1,0,' class="sf-menu" id="page_menu" style="display:none" ');
					
				}
				$page_menu = $_SESSION[_PLATFORM_]["CLA"]['MENU'];
				echo $page_menu;
			?>
			</div>
			<div id="alert_area" style="width:600px;float:right"></div>	
			<?}?>
		</div>		
	</div>
	