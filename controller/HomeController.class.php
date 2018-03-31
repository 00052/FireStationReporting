<?php
final class HomeController extends ControllerBase {
	protected function onBefore($action = '') {
		parent::checkAuthentification();	
	}
	
	public function index() {
		System::forwardToRoute(Router::getInstance()->build('UsersController', 'index'));
		echo "Home Controller";
		exit;	
	}
}
?>
