<?php
use ICanBoogie\DateTime;
final class ReportsController extends ControllerBase {
	protected function onBefore($action = '') {
		parent::checkIfAdmin();
	}

    /** 
     * Returns an input value from
     * the JSON request object
     * @param string Name of the property
     * @param mixed Default value if the property is not available
     */
    private function getGETParam($property, $default = NULL) {
        if($_GET != NULL && array_key_exists($property, $_GET)) {
            return $_GET[$property];
        }
    
        return $default;
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
		$date = $this->getGETParam('date',NULL);
		if($date == NULL) {
			$time = new DateTime('now', 'Asia/Shanghai');
			$date = $time->format_as_date();
		} else {
			if(!DateFormat::isValidDate($date)) {
				System::displayError(System::getLanguage()->_('InvalidDateFormat'));
				exit;
			}
		}

		$strengthArray = StationStrength::find('date', $date, array('orderby'=>'user_ID', 'sort'=>'desc'));

		$userArray = User::find('type',User::USER_STATION,array('orderby'=>'_id', 'sort'=>'desc'));
		if(!is_array($userArray))
			$userArray = array($userArray);

		$table = array();
		$totalItem = array(
			'nofficer'	=> 0,
			'nsoldier'	=> 0,
			'nemployee'	=> 0,
			'nfireengine'=>0,
			'ndriver'	=> 0
		);

		$i=0;

		foreach($userArray as $user) {
			$tableItem 				= array();
			$tableItem['uid'] 		= $user->uid;
			$tableItem['nickname'] 	= $user->nickname;

			if($i > count($strengthArray) - 1 || $user->uid != $strengthArray[$i]->userid) {
				$tableItem['reported'] = 0; //No reporting
			} else {
				$tableItem['reported'] = 1;

				$totalItem['nofficer'] += $tableItem['nofficer'] = $strengthArray[$i]->nofficer;
				$totalItem['nsoldier'] += $tableItem['nsoldier'] = $strengthArray[$i]->nsoldier;
				$totalItem['nemployee']+= $tableItem['nemployee'] = $strengthArray[$i]->nemployee;
				$totalItem['nfireengine'] += $tableItem['nfireengine'] = $strengthArray[$i]->nfireengine;
				$totalItem['ndriver'] += $tableItem['ndriver'] = $strengthArray[$i]->ndriver;

				$i++;
			}
			$table[] = $tableItem;
		}

		$smarty = new Template;
		$smarty->caching = 0;
		$smarty->assign('title',System::getLanguage()->_('StrengthReport'));
		$smarty->assign('menu', self::makeMenu());
		$smarty->assign('date', $date);
		$smarty->assign('table', $table);
		$smarty->assign('total', $totalItem);
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
