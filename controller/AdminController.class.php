<?php
final class AdminController extends ControllerBase {
	const UPDATE_CHECK = 'https://github.com/poilynx/SimplePHP/raw/master/VERSION';
	
	protected function onBefore($action = '') {
		parent::checkAuthentification();	
		parent::checkIfAdmin();
	}
	
	public function index() {
		
		// Get files
		
		$sql = System::getDatabase()->query('SELECT u._id, u.username, u.nickname FROM users u GROUP BY u._id');
		
		$num_users = 0;
		
		while($user = $sql->fetch(PDO::FETCH_OBJ)) {
			
			
			
			$obj = new Object();
			$obj->username = $user->username;
			$obj->nickname = $user->nickname;
			
			$users[] = $obj;
			$num_users++;
		}
		
		
		// Newest User
		$newUsers = User::find('*', NULL, array('orderby' => '_id', 'sort' => 'DESC'));

		
		if(!is_array($newUsers)) {
			$newUsers = array($newUsers);
		}
		
		
		
		// Version
		$version = file_get_contents(SYSTEM_ROOT . '/VERSION');
		$phpversion = phpversion();
		
		$res = System::getDatabase()->query('SELECT VERSION() AS mysql_version');
		$row = $res->fetch(PDO::FETCH_ASSOC);
		
		if(!isset($row['mysql_version'])) {
			$mysqlversion = System::getLanguage()->_('Unknown');
		} else {
			$mysqlversion = $row['mysql_version'];		
		}
		
		// Extensions
		$imagick = extension_loaded('imagick') && class_exists('Imagick');
		$rar = extension_loaded('rar') && class_exists('RarArchive');
		
		$maxpost = Utils::parseInteger(ini_get('post_max_size'));	
		$maxupload = Utils::parseInteger(ini_get('upload_max_filesize'));
		
		$smarty = new Template();
        $smarty->assign('title', System::getLanguage()->_('Admin'));
		$smarty->assign('heading', System::getLanguage()->_('Admin'));
		
		$smarty->assign('num_users', $num_users);
		
		$smarty->assign('newUsers', $newUsers);		
		$smarty->assign('userByQutoa', $users);
		
		$smarty->assign('version', $version);
		$smarty->assign('phpversion', $phpversion);
		$smarty->assign('mysqlversion', $mysqlversion);
		$smarty->assign('maxpost', $maxpost);
		$smarty->assign('maxupload', $maxupload);
		
		$smarty->assign('imagick', $imagick);
		$smarty->assign('rar', $rar);
		
		$smarty->requireResource('admin');
		
		$smarty->display('admin/index.tpl');		
	}
	
	public function updateCheck() {
		$response = new AjaxResponse();
		
		try {
			$remoteVersion = Utils::getRequest(self::UPDATE_CHECK);	
			$currentVersion = file_get_contents(SYSTEM_ROOT . '/VERSION');
			
			$result = new Object();
			$result->isUpdateAvailable = version_compare($remoteVersion, $currentVersion, '>');
					
			$response->success = true;
			$response->data = $result;
		} catch(RequestException $e) {
			$response->success = false;	
		}
		
		$response->send();
	}
}
?>
