<?if(!defined('TSEntry') || !TSEntry) die('Not A Valid Entry Point');
include('include/form.inc.php');
include('captcha2/captcha.php');
class Config_Ext  extends Config
{	
	function execute(){				$type =__post('tp');				switch($type){			case 'del_file':				$id = __post('id');				if($id>0){					$sSQL = "delete from ntk_new_files where id = ".(int)$id;					$result = $this->db->query($sSQL, true, "Query failed");					die("1");				}				die("-1");				break;						case '':				break;						}	}
}
$seed = new Config_Ext();
$seed->execute();
