<?if(!defined('TSEntry') || !TSEntry) die('Not A Valid Entry Point');

function dump_vars() {
	global $_POST, $_GET;
	echo "<br><h2>POST_VARS:</h2><br>\n";
	while (list($var, $value) = each($_POST)) {
		echo "<b>$var</b> = [$value]<br>\n";
	}
	echo "<br><h2>GET_VARS:</h2><br>\n";
		while (list($var, $value) = each($_GET)) {
			echo "<b>$var</b> = [$value]<br>\n";
	}
	echo "<br><br>";
}

function dump_array(&$mit,$indent="") {
	while (list($key, $value) = each($mit)) {
		if (gettype($value)=="array") {
				echo "<br>".$indent."<font face='verdana,helvetica' size=1><b>[$key]</b> =";
				echo " ARRAY<br>\n".$indent."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[</font><br>\n";
        dump_array($value,$indent."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
				echo $indent."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;]<br>\n";
			} else {
			echo $indent."<font face='verdana,helvetica' size=1><b>[$key]</b> =";
			echo " [".htmlspecialchars($value)."]</font><br>\n";
		}		 
	}
}

function timer($stime,$etime)
{
	$stime=explode(" ",$stime);
	$etime=explode(" ",$etime);
	return $etime[0]+$etime[1]-$stime[0]-$stime[1];
}

function debuglog($mit)
{
 global $release;
 if ($release=="dev")
 	error_log(date("[G:i:s] ").$mit,3,"/tmp/php3-ibusz.log");
}

?>