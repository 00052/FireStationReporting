<?php
use ICanBoogie\DateTime;
final class ReportController extends ControllerBase {
	protected function onBefore($action = '') {
		parent::checkAuthentification();
	}

		
	/**
	 * @param tr_id string 	Translating stiring ID
	 * @param report_name string Report name	
	 */
	private static function makeMenuItem($tr_id, $action) {
		return array(
			System::getLanguage()->_($tr_id), 
			Router::getInstance()->build('ReportController',$action)
		);
	}

	private static function makeMenu() {
		if(System::getUser()->type == User::USER_STATION)
			return array(
				ReportController::makeMenuItem('StationStrengthReport','add_station_strength')
			);
		else if(System::getUser()->type == User::USER_SMALL_STATION)
			return array(
				ReportController::makeMenuItem('SmallStationStrengthReport','add_small_station_strength')
			);
		else if(System::getUser()->type == User::USER_ADMIN)
			return array();

		return NULL;
	}

	public function index() {
		$form = new Template;
		$form->assign('title', System::getLanguage()->_('SubmitReport'));
		$form->assign('menu', ReportController::makeMenu());
		$form->display('report/index.tpl');
	}

	public function add_station_strength() {
		if(System::getUser()->type != User::USER_STATION) {
			System::displayError(System::getLanguage()->_('PageNotFound', '404 Not Found'));
			exit;
		}

		$obj = new StationStrength;
		$form = new Form('form-officer', Router::getInstance()->build('ReportController', 'add_station_strength'));
		$form->binding = $obj;

		$fieldset = new Fieldset(System::getLanguage()->_('General'));

		$officer = new Text('officer', System::getLanguage()->_('TheNumberOfOfficer'), true);
		$officer->binding = new Databinding('nofficer');
		$officer->maxlength = 2; 

		$soldier = new Text('soldier', System::getLanguage()->_('TheNumberOfSoldier'), true);
		$soldier->binding = new Databinding('nsoldier');
		$soldier->maxlength = 2; 

		$employee = new Text('employee', System::getLanguage()->_('TheNumberOfEmployee'), true);
		$employee->binding = new Databinding('nemployee');
		$employee->maxlength = 2; 

		$fireengine = new Text('fireengine', System::getLanguage()->_('TheNumberOfFireengine'), true);
		$fireengine->binding = new Databinding('nfireengine');
		$fireengine->maxlength = 2; 

		$driver = new Text('fireengine', System::getLanguage()->_('TheNumberOfFireengine'), true);
		$driver->binding = new Databinding('ndriver');
		$driver->maxlength = 2; 

		$fieldset->addElements($officer, $soldier, $employee, $fireengine, $driver);

		$form->addElements($fieldset);

        $form->setSubmit(
            new Button(
                System::getLanguage()->_('Submit'),
                'floppy-disk'
            )
        );

		

		if(Utils::getPOST('submit', false) !== false) {

			if($form->validate()) {
				$form->save();
				$obj->userid = System::getUser()->uid;
				$obj->save();
				System::forwardToRoute(Router::getInstance()->build('ReportController', 'index'));
				exit;
			}
		} else {
			$form->fill();
		}
		
		$reportMenu = ReportController::makeMenu();

		$smarty = new Template;
		$smarty->assign('title',System::getLanguage()->_('StrengthReport'));
		//$smarty->assign('usertype',$usertype);
		$smarty->assign('nickname',System::getUser()->nickname);
		$smarty->assign('menu', $reportMenu);
		$smarty->assign('form', $form);

		$smarty->display('report/station_strength.tpl');
	}

	public function add_small_station_strength() {

	}
	public function onFinished($action = '') {

	}
	

}
?>
