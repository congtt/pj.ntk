<?php
if(!defined('TSEntry') || !TSEntry) die('Not A Valid Entry Point');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-gb" lang="en-gb">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>#</title>
	<link href="<?=$fullsite?>/css/style.css" rel="stylesheet" media="all" />

	<link type="text/css" href="<?=$fullsite?>/css/template.css" rel="stylesheet">
	<link href="<?=$fullsite?>/themes/admintasia/css/styles/light_blue/ui.css" rel="stylesheet" title="style" media="all" />
	<link rel="stylesheet" href="<?=$fullsite?>/css/ui/css/redmond/jquery-ui.custom.css" type="text/css">
	<style>
.myClass {
  background-color: #88FF88;
} 
</style>
	<script type="text/javascript" src="<?=$fullsite?>/css/jquery-1.4.2.min.js"></script>
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







</head>

<body id="bd" class=" wide fs3" >
<div id="ja-wrapper">

<!-- BEGIN: CPANEL -->
<div id="ja-cpanel">
		<div id="ja-search">
		<div id="jflanguageselection"><div class="rawimages"><span><a href="<?=$fullsite?>/cfg/language-vi.html"><img src="<?=$fullsite?>/images/vi.gif" alt="Viet Nam" title="Viet Nam" /></a></span><span id="active_language"><a href="<?=$fullsite?>/cfg/language-en.html"><img src="<?=$fullsite?>/images/en.gif" alt="English (United Kingdom)" title="English (United Kingdom)" /></a></span></div></div><!--Joom!fish V2.0.2 ()-->
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
		<a href="/index.php" title="Hội Phẫu Thuật Thần Kinh Việt Nam"><span>Hội Phẫu Thuật Thần Kinh Việt Nam</span></a>
	</h1>
	
		
<!-- BEGIN: MAIN NAVIGATION -->

    <div id="flash">
	<img src="<?=$fullsite?>/images/banneren.jpg" alt="" /><br />
    </div>


<div id="ja-mainnavwrap">
 
<div class="navigation" id="ja-mainnav">
<?
$page_menu = page_menu(-1,0,'nav');
echo $page_menu;
?>
    
</div>

</div>
<!-- END: MAIN NAVIGATION -->
  
</div>
<!-- END: HEADER -->