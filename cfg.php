<?php
session_start();
if (isset($_SESSION['LANGUAGE'])){
	if ($_GET["action"]=='language-en'){
		$_SESSION['LANGUAGE']='en';
	}
	else{
		$_SESSION['LANGUAGE']='vi';	
	}

}
else{
		$_SESSION['LANGUAGE']='vi';

}
header('location:/pj.thankinh/ntk/');
die();
