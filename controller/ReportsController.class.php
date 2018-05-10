<?php
use ICanBoogie\DateTime;
final class ReportsController extends ControllerBase {
	protected function onBefore($action = '') {
		parent::checkIfAdmin();
	}

		
	/**
	 * @param tr_id string 	Translating stiring ID
	 * @param report_name string Report name	
	 */
	private static function makeMenuItem($tr_id, $action) {
		return array(
			System::getLanguage()->_($tr_id), 
			Router::getInstance()->build('ReportsController',$action)
		);
	}

	private static function makeMenu() {
		return array(
			self::makeMenuItem('StationStrengthReport', 'stationStrength'),
			self::makeMenuItem('SmallStationStrengthReport', 'smallStationStrength'),
			self::makeMenuItem('Rota', 'rota')
		);
	}

	public function index() {

		$smarty = new Template;
		$smarty->assign('title', System::getLanguage()->_('Reports'));
		$smarty->assign('menu', self::makeMenu());
		$smarty->assign('form', 'empty form');
		$smarty->display('reports/index.tpl');
	}

	public function stationStrength() {
		$table = StationStrength::find();
		$smarty = new Template;
		$smarty->caching = 0;
		$smarty->assign('title',System::getLanguage()->_('StrengthReport'));
		$smarty->assign('menu', self::makeMenu());
		$smarty->assign('table', $table);
		$smarty->requireResource('datepicker');
		$smarty->requireResource('datepicker_zh');
		$smarty->display('reports/station_strength.tpl');
	}

	public function smallStationStrength() {
		$smarty = new Template;
		$smarty->assign('title',System::getLanguage()->_('SmallStrengthReport'));
		$smarty->assign('menu', self::makeMenu());
		$smarty->assign('form', 'empty form');
		$smarty->display('reports/small_station_strength.tpl');

	}
	public function onFinished($action = '') {

	}
	

}
?>
