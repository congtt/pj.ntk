<?
if(!defined('TSEntry'))define('TSEntry', true);
include('include/init.inc.php');
die("<h1>Welcome to forum</h1>");
if(isset($_GET['language']) && $_GET['language'] !=''){
	$_SESSION[_PLATFORM_]['lang'] = $_GET['language'];
	$_COOKIE[_PLATFORM_]['lang'] = $_SESSION[_PLATFORM_]['lang'];
	setcookie(_PLATFORM_.'lang',$_SESSION[_PLATFORM_]['lang']);
}
$_SESSION[_PLATFORM_]['pre_url'] = $_SESSION[_PLATFORM_]['cur_url'];
$cur_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$_SESSION[_PLATFORM_]['cur_url'] = $cur_url;

$lang = get_language();

if($cla_cid==-100){	
	include('ntk-ajax.php');
	die();
}
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
