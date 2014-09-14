<?php

define('ALLOWED_REFERRER', '');
define('BASE_DIR','E:/xampp/htdocs/pj.ntk/images/newfiles/');
define('LOG_DOWNLOADS',true);
define('LOG_FILE','downloads.log');
	
		$allowed_ext = array (
			// archives
			//aloow: zip, rar, jpg, jpeg, bmp, doc(x), xls(x
			
			  'zip' => 'application/zip',
			  'rar' => 'application/rar',
			  // documents
			  //'pdf' => 'application/pdf',
			  'doc' => 'application/msword',
			  'docx' => 'application/msword',
			  'xls' => 'application/vnd.ms-excel',
			  'xlsx' => 'application/vnd.ms-excel',
			  //'ppt' => 'application/vnd.ms-powerpoint',
			  //'csv' => 'application/csv',
			  // executables
			 // 'exe' => 'application/octet-stream',

			  // images
			  'gif' => 'image/gif',
			  'png' => 'image/png',
			  'jpg' => 'image/jpeg',
			  'jpeg' => 'image/jpeg',

			  // audio
			//  'mp3' => 'audio/mpeg',
			 // 'wav' => 'audio/x-wav',

			  // video
			  /*'mpeg' => 'video/mpeg',
			  'mpg' => 'video/mpeg',
			  'mpe' => 'video/mpeg',
			  'mov' => 'video/quicktime',
			  'avi' => 'video/x-msvideo',*/
			// others
			  //'css' => 'application/force-download'
		  
		);



		####################################################################
		###  DO NOT CHANGE BELOW
		####################################################################

		// If hotlinking not allowed then make hackers think there are some server problems
		if (ALLOWED_REFERRER !== ''
		&& (!isset($_SERVER['HTTP_REFERER']) || strpos(strtoupper($_SERVER['HTTP_REFERER']),strtoupper(ALLOWED_REFERRER)) === false)
		) {
		  die("Internal server error. Please contact system administrator.");
		}

		// Make sure program execution doesn't time out
		// Set maximum script execution time in seconds (0 means no limit)
		set_time_limit(0);

		if (!isset($_GET['fn']) || empty($_GET['fn'])) {
		  die("Please specify file name for download.");
		}
		
		// Get real file name.
		// Remove any path info to avoid hacking by adding relative path, etc.
		$fname = basename($_GET['fn']);

		// get full file path (including subfolders)
		$file_path =BASE_DIR.$fname;	
		//find_file(BASE_DIR, $fname, $file_path);
		if (!is_file($file_path)) {
		  die("File does not exist. Make sure you specified correct file name."); 
		}
		
		// file size in bytes
		$fsize = filesize($file_path); 

		// file extension
		$fext = strtolower(substr(strrchr($fname,"."),1));

		// check if allowed extension
		if (!array_key_exists($fext, $allowed_ext)) {
		  die("Not allowed file type."); 
		}

		// get mime type
		if ($allowed_ext[$fext] == '') {
		  $mtype = '';
		  // mime type is not set, get from server settings
		  if (function_exists('mime_content_type')) {
			$mtype = mime_content_type($file_path);
		  }
		  else if (function_exists('finfo_file')) {
			$finfo = finfo_open(FILEINFO_MIME); // return mime type
			$mtype = finfo_file($finfo, $file_path);
			finfo_close($finfo);  
		  }
		  if ($mtype == '') {
			$mtype = "application/force-download";
		  }
		}
		else {
		  // get mime type defined by admin
		  $mtype = $allowed_ext[$fext];
		}

		// Browser will try to save file with this filename, regardless original filename.
		// You can override it if needed.

		if (!isset($_GET['rn']) || empty($_GET['rn'])) {
		  $asfname = $fname;
		}
		else {
		  // remove some bad chars
		  $asfname = str_replace(array('"',"'",'\\','/'), '', $_GET['rn']);
		  if ($asfname === '') $asfname = 'NoName';
		}

		// set headers
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Type: $mtype");
		header("Content-Disposition: attachment; filename=\"$asfname\"");
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: " . $fsize);

		// download
		// @readfile($file_path);



		$file = @fopen($file_path,"rb");
		if ($file) {
		  while(!feof($file)) {
			print(fread($file, 1024*8));
			flush();
			if (connection_status()!=0) {
			  @fclose($file);
			  die();
			}
		  }
		  @fclose($file);
		}

		// log downloads
		if (!LOG_DOWNLOADS) die();


		if (filesize(LOG_FILE)>7000)
		{$f = @fopen(LOG_FILE, "w+"); }
		else
		{$f = @fopen(LOG_FILE, "a+"); }

		//$f = @fopen(LOG_FILE, 'a+');
		if ($f) {
		  @fputs($f, date("m.d.Y g:ia")."  ".$_SERVER['REMOTE_ADDR']."  ".$fname."\n");
		  @fclose($f);
		}

?>

