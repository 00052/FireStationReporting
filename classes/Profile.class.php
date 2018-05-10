<?php
class Profile{
	private static $deps = array(
		'SiLingBu',
		'ZhengZhiChu',
		'HouQinChu',
		'FangHuoChu'
	);
	public static function getDepartments() {
		return Profile::$deps;
	}

	public static function getDepartment($i) {
		if($i > count(Profile::$deps))
			return NULL;
		return Profile::$deps[$i];
	}

	private static $duties = array(
		'NoDuty',
		'DaiBanShouZhang',
		'ZhiBanLingDao',
		'ZhiHuiZhang',
		'ZhiHuiZhuLi',
		'XingZhengZhiBan',
		'ZhiHuiChe'
	);
	public static function getDuties() {
		return Profile::$duties;
	}
	public static function getDuty($i) {
		if($i > count(Profile::$duties))
			return NULL;
		return Profile::$duties[$i];
	}

}
?>
