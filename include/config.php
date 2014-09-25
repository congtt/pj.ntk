<?
if(!defined('TSEntry') || !TSEntry) die('Not A Valid Entry Point');
define('ENV','DEV');
if(ENV=='PRODUCTION'){
	$ts_config = array (  
	  'site_title' => '#'
	  ,'dbconfig'=>
			  array (
				'db_host_name' => '127.0.0.1',
				//'db_host_name' => 'CPU10208\SQLEXPRESS',
				'db_host_instance' => '',
				'db_user_name' => 'thankinh',
				'db_password' => 'thankinh@123',
				'db_name' => 'thankinh_ssdesk_com',
				'db_type' => 'mysqli',
			  )
	  ,'site_url' => 'http://thankinh.ssdesk.com/'	 
	  ,'filenews_dir' => 'http://thankinh.ssdesk.com/images/newfiles'//
	  ,'site_url_download_file'=>'http://thankinh.ssdesk.com/download_file.php?fn='
	  ,'photo_url' => 'http://thankinh.ssdesk.com/photo'
	  ,'upload_dir' => 'E://xampp//htdocs//pj.ntk//images//newfiles'//
	  
	  
	  ,'upload_maxsize' => 52*1024*1024 // 52.428.800 bytes 
	  ,'permission'=>array(
			'1'=>'Access',
			'2'=>'Add',
			'4'=>'Edit',
			'8'=>'Delete',
			'16'=>'Import',
			'32'=>'Export',
	   )
	  ,'mail'=>'gmail.com'
	  ,'smtp'=>''
	);
}else{
		$ts_config = array (  
	  'site_title' => '#'
	  ,'dbconfig'=>
			  array (
				'db_host_name' => 'localhost',
				//'db_host_name' => 'CPU10208\SQLEXPRESS',
				'db_host_instance' => '',
				'db_user_name' => 'root',
				'db_password' => '',
				'db_name' => 'thankinh',
				'db_type' => 'mysqli',
			  )
	  ,'site_url' => 'http://127.0.0.1/pj.ntk'	 
	  ,'filenews_dir' => 'http://127.0.0.1/pj.ntk/images/newfiles'//
	  ,'site_url_download_file'=>'http://127.0.0.1/pj.ntk/download_file.php?fn='
	  ,'photo_url' => 'http://127.0.0.1/pj.ntk/photo'
	  ,'upload_dir' => 'E://xampp//htdocs//pj.ntk//images//newfiles'//
	  
	  
	  ,'upload_maxsize' => 52*1024*1024 // 52.428.800 bytes 
	  ,'permission'=>array(
			'1'=>'Access',
			'2'=>'Add',
			'4'=>'Edit',
			'8'=>'Delete',
			'16'=>'Import',
			'32'=>'Export',
	   )
	  ,'mail'=>'gmail.com'
	  ,'smtp'=>''
	);

}

$fullsite = $ts_config['site_url'];

?>