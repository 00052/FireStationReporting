<?php
final class HelloController extends ControllerBase {
	protected function onBefore($action = '') {
		//parent::checkIfAdmin();
	}

		
	public function hello() {
		$smarty = new Template;
		$smarty->assign('title','Title');
		$smarty->display('hello/main.tpl');
	}

	public function onFinished($action = '') {

	}
	

}
?>
