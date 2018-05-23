<?php
final class HelloController extends ControllerBase {
	protected function onBefore($action = '') {
		parent::checkAuthentification();
	}

		
	public function hello() {
		$smarty = new Template;
		$smarty->assign('title',System::getLanguage()->_('Welcome')." ");
		$smarty->assign('usertype',System::getUser());
		$smarty->assign('nickname',System::getUser()->nickname);
		$smarty->display('hello/main.tpl');
	}

	public function onFinished($action = '') {

	}
	

}
?>
