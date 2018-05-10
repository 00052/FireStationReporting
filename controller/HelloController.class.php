<?php
final class HelloController extends ControllerBase {
	protected function onBefore($action = '') {
		parent::checkIfAuthentication();
	}

		
	public function hello() {
		$smarty = new Template;
		$smarty->assign('title','Title');
		$smarty->assign('isAdmin',System::getUser() != NULL && System::getUser()->type == User::USER_ADMIN);
		$smarty->display('hello/main.tpl');
	}

	public function onFinished($action = '') {

	}
	

}
?>
