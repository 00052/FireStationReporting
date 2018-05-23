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
		$menu = array();

		if(System::getUser()->type == User::USER_STATION) {
			$menu[] = ReportController::makeMenuItem('StationStrengthReport','addStationStrength');
		} else if(System::getUser()->type == User::USER_SMALL_STATION) {
			$menu[] = ReportController::makeMenuItem('SmallStationStrengthReport','addSmallStationStrength');
		} else if(System::getUser()->type == User::USER_ADMIN) {
			;
		}
		return $menu;
	}

	public function index() {
		if(System::getUser()->type == User::USER_STATION) {
			System::forwardToRoute(Router::getInstance()->build('ReportController', 'addStationStrength'));
		} else if(System::getUser()->type == User::USER_SMALL_STATION) {
			System::forwardToRoute(Router::getInstance()->build('ReportController', 'addSmallStationStrength'));
		} else if(System::getUser()->type == User::USER_ADMIN) {
			$form = new Template;
			$form->assign('title', System::getLanguage()->_('SubmitReport'));
			$form->assign('menu', array());
			$form->assign('menutitle', 'None');
			$form->display('report/index.tpl');

		}
			

	}

	public function addStationStrength() {
		if(System::getUser()->type != User::USER_STATION) {
			System::displayError(System::getLanguage()->_('PageNotFound', '404 Not Found'));
			exit;
		}

		$reportMenu = self::makeMenu();

		$smarty = new Template;
		$smarty->assign('title',System::getLanguage()->_('SubmitReport'));
		$smarty->assign('menu', $reportMenu);
		$smarty->assign('menutitle', System::getLanguage()->_($reportMenu[0][0]));
		if(SmallStationStrength::needReport() == FALSE) {
			$smarty->display('report/neednotsubmit.tpl');
			exit;
		}


		$obj = new StationStrength;
		$form = new Form('form-officer', Router::getInstance()->build('ReportController', 'addStationStrength'));
		$form->binding = $obj;

		//$fieldset = new Fieldset(System::getLanguage()->_('General'));

		$officer = new Text('officer', System::getLanguage()->_('TheNumberOfOfficer'), true,"numeric", 2, 1);
		$officer->binding = new Databinding('nofficer');
		$officer->maxlength = 2; 

		$soldier = new Text('soldier', System::getLanguage()->_('TheNumberOfSoldier'), true, 'numeric', 2, 1);
		$soldier->binding = new Databinding('nsoldier');
		$soldier->maxlength = 2; 

		$employee = new Text('employee', System::getLanguage()->_('TheNumberOfEmployee'), true, 'numeric', 2, 1);
		$employee->binding = new Databinding('nemployee');
		$employee->maxlength = 2; 

		$fireengine = new Text('fireengine', System::getLanguage()->_('TheNumberOfFireengine'), 'numeric', 2, 1);
		$fireengine->binding = new Databinding('nfireengine');
		$fireengine->maxlength = 2; 

		$driver = new Text('driver', System::getLanguage()->_('TheNumberOfDriver'), true, 'numeric', 2, 1);
		$driver->binding = new Databinding('ndriver');
		$driver->maxlength = 2; 

		$form->addElements($officer, $soldier, $employee, $fireengine, $driver);

		//$form->addElements($fieldset);

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
				System::getSession()->setData('successMsg', System::getLanguage()->_('SucceedToSubmit'));
				System::forwardToRoute(Router::getInstance()->build('ReportController', 'index'));
				exit;
			}
		} else {
			$form->fill();
		}
		

		//$smarty->assign('usertype',$usertype);
		$smarty->assign('nickname',System::getUser()->nickname);
		$smarty->assign('form', $form);

		$smarty->display('report/station_strength.tpl');
	}

	public function addSmallStationStrength() {
		if(System::getUser()->type != User::USER_SMALL_STATION) {
			System::displayError(System::getLanguage()->_('PageNotFound', '404 Not Found'));
			exit;
		}


		$reportMenu = self::makeMenu();

		$smarty = new Template;
		$smarty->assign('title',System::getLanguage()->_('SubmitReport'));
		$smarty->assign('menutitle', $reportMenu[0][0]);
		$smarty->assign('menu', $reportMenu);

		if(SmallStationStrength::needReport() == FALSE) {
			$smarty->display('report/neednotsubmit.tpl');
			exit;
		}


		$obj = new SmallStationStrength;
		$form = new Form('form-add-smallstrength', Router::getInstance()->build('ReportController', 'addSmallStationStrength'));
		$form->binding = $obj;

		$fieldset = new Fieldset(System::getLanguage()->_('General'));

		$onduty = new Text('onduty', System::getLanguage()->_('OnDuty'), true, "numeric",2 ,1);
		$onduty->binding = new Databinding('onduty');

		$driver = new Text('driver', System::getLanguage()->_('TheNumberOfDrivers'), true, "numeric",2 ,1);
		$driver->binding = new Databinding('driver');

		$vehicle = new Text('vehicle', System::getLanguage()->_('TheNumberOfVehicles'), true, "numeric",2 ,1);
		$vehicle->binding = new Databinding('vehicle');

		$vehicle_inuse = new Text('vehicle_inuse', System::getLanguage()->_('TheNumberOfVehicleInUse'), true, "numeric",2 ,1);
		$vehicle_inuse->binding = new Databinding('vehicle_inuse');

		$vehicle_condition = new Text('vehicle_condition', System::getLanguage()->_('VehicleCondition'), false);
		$vehicle_condition->binding = new Databinding('vehicle_condition');
		$vehicle_condition->maxlength = 40; 

		$equipment_condition = new Text('equipment_condition', System::getLanguage()->_('EquipmentCondition'), false);
		$equipment_condition->binding = new Databinding('equipment_condition');
		$equipment_condition->maxlength = 40; 

		$fieldset->addElements($onduty, $driver, $vehicle, $vehicle_inuse, $vehicle_condition, $equipment_condition);

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
				System::getSession()->setData('successMsg', System::getLanguage()->_('SucceedToSubmit'));
				System::forwardToRoute(Router::getInstance()->build('ReportController', 'index'));
				exit;
			}
		} else {
			$form->fill();
		}

		$smarty->assign('nickname',System::getUser()->nickname);
		$smarty->assign('form', $form);

		$smarty->display('report/small_station_strength.tpl');

	}

	public function onFinished($action = '') {

	}
	

}
?>
