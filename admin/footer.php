<?if(!defined('TSEntry') || !TSEntry) die('Not A Valid Entry Point');?>
	<div class="clearfix"></div>
	<?echo $cla->siteFooter();?>	
	<!--<div id="footer">
		Copyright &copy; 2014 by NEUROSURGICAL SOCIETY OF VIETNAM
	</div>-->
	<script type="text/javascript" src="../css/jquery.validate.js"></script>	
	
	<script type="text/javascript" src="../css/site.js"></script>
	<script type="text/javascript" src="../themes/admintasia/js/superfish.js"></script>
	<script type="text/javascript" src="../themes/admintasia/js/jquery-ui-1.7.2.js"></script>
	<script type="text/javascript" src="../themes/admintasia/js/tablesorter.js"></script>
	<script type="text/javascript" src="../themes/admintasia/js/cookie.js"></script>
	<script type="text/javascript" src="../css/pnotify/jquery.pnotify.js"></script>
	<link href="../css/pnotify/jquery.pnotify.default.css" media="all" rel="stylesheet" type="text/css" />
	<link href="../css/pnotify/jquery.pnotify.default.css" media="all" rel="stylesheet" type="text/css" />
	<link href="../css/superfish/css/superfish.css" media="all" rel="stylesheet" type="text/css" />
	
	<script src="../css/ckeditor/ckeditor.js"></script>
	<!--<msdropdown>-->
	<link rel="stylesheet" type="text/css" href="../css/masterdropdown/css/msdropdown/dd.css" />
	<!--<script src="../css/masterdropdown/js/msdropdown/jquery.dd.min.js"></script>-->
	<!--</msdropdown>-->
	
	<!--alertify-->
	<link rel="stylesheet" href="../css/alertify/themes/alertify.core.css" />
	<link rel="stylesheet" href="../css/alertify/themes/alertify.default.css" id="toggleCSS" />
	<script src="../css/alertify/lib/alertify.min.js"></script>
	<!--alertify-->	
	<script>
	
	/*$(function(){
		$.pnotify.defaults.history = false;
		$('input[name=captchaForm]').attr('autocomplete','off');
	});
	$.rloader([{src:'../css/notification_icon.css'},{src:'../css/profile.js'},{src:'../css/timer/jquery.timer.js'},{src:'../css/dropdown/bootstrap.js'},{src:'../css/dropdown/bootstrap-hover-dropdown.js'},{src:'../css/scroller/li-scroller.css'},{src:'../css/scroller/jquery.li-scroller.1.0.js'},{src:'../css/format/jquery.format-1.3.min.js'}, {event:'onready', func:'get_notification', arg:"'<?echo get_userid();?>,<?echo get_username();?>,<?=$cla->md5sum(get_userid())?>'"}]);
	*/</script>

</body>
</html>