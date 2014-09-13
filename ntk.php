<?
if(!defined('TSEntry'))define('TSEntry', true);
include('include/init.inc.php');

if(isset($_GET['language']) && $_GET['language'] !=''){
	$_SESSION[_PLATFORM_]['lang'] = $_GET['language'];
	$_COOKIE[_PLATFORM_]['lang'] = $_SESSION[_PLATFORM_]['lang'];
	setcookie(_PLATFORM_.'lang',$_SESSION[_PLATFORM_]['lang']);
}
$lang = get_language();
include('language/'.$lang.'.php');
?>	 
<?include('ntk-header.php');?>	
<div id="ja-containerwrap">
<div id="ja-container">
<div id="ja-container-inner" class="clearfix">

	<!--BEGIN: CONTENT-->
	<div id="ja-mainbodywrap">	
	<div id="ja-mainbody" class="clearfix">
		<div id="ja-contentwrapper">    
    <!--BEGIN: CONTENT-->
		<div id="ja-contentwrap"><div id="ja-content">
			<div id="ja-current-content" class="clearfix">

			<!--CONTENT-->
			<?
				include('ntk-info.php');
			?>
			<!--CONTENT-->


			</div>

		</div></div>
		<!--END: CONTENT-->
		
    </div>

	<?include('ntk-left.php');?>  	   		
	</div></div>
	<!--END: CONTENT-->
		
	<?include('ntk-right.php');?>	
</div></div>
</div>
<?include('ntk-footer.php');?>
