<?php
use ICanBoogie\DateTime;
final class SmallStationStrength extends ModelBase {
	private $id;
	private $userid;
	private $user;
	private $date;
	private $onduty;
	private $driver;
	private $vehicle;
	private $vehicle_inuse;
	private $vehicle_condition;
	private $equipment_condition;

	public function __construct() { }
	
	protected function assign(array $row) {
		$this->isNewRecord	= false;
		$this->userid			= $row['user_ID'];
		$this->onduty			= $row['onduty'];
		$this->driver			= $row['driver'];
		$this->vehicle			= $row['vehicle'];
		$this->vehicle_inuse	= $row['vehicle_inuse'];
		$this->vehicle_condition = $row['vehicle_condition'];
		$this->equipment_condition = $row['equipment_condition'];
	}

	/**
	 * Saves changes to DB
	 */
	public function save() {
		if($this->isNewRecord) {
			$date = new DateTime('now', 'Asia/Shanghai');
			$this->date	= $date->format_as_date();
		}

		$data = array(
			':user_ID' => $this->userid,
			':date' => $this->date,
			':onduty' => $this->onduty,
			':driver' => $this->driver,
			':vehicle' => $this->vehicle,
			':vehicle_inuse' => $this->vehicle_inuse,
			':vehicle_condition' => $this->vehicle_condition,
			':equipment_condition' => $this->equipment_condition
		);
		
		if($this->isNewRecord) {
			$sql = System::getDatabase()->prepare('INSERT INTO small_station_stg(user_ID, date, onduty, driver, vehicle, vehicle_inuse, vehicle_condition, equipment_condition) VALUES(:user_ID, :date, :onduty, :driver, :vehicle, :vehicle_inuse, :vehicle_condition, :equipment_condition)');
			$sql->execute($data);
			
			$this->id = System::getDatabase()->lastInsertId();
		} else {
			$data[':id']	= $this->id;
			
			$sql = System::getDatabase()->prepare('INSERT INTO small_station_stg (_id, user_ID, onduty, driver, vehicle, vehicle_inuse, vehicle_condition, equipment_condition) VALUES(:_id :user_ID, :onduty, :driver, :vehicle, :vehicle_inuse, :vehicle_condition, :equipment_condition');
			#$sql = System::getDatabase()->prepare('INSERT INTO station_stg(_id, user_ID, officer, soldier, employee, fireengine, dirver) VALUES(:id, :user_ID, :officer, :soldier, :employee, :fireengine, :driver)');
			
			$sql->execute($data);
		}
	}
	
	public function delete() {
		
		// Delete user
		$sql = System::getDatabase()->prepare('DELETE FROM small_station_stg WHERE _id = :id');
		$sql->execute(array(':id' => $this->id));
	}
	
	/**
	 * Global setter
	 * @param string Property name
	 * @param mixed Property value
	 */
	public function __set($property, $value) {
		if($property == 'id') {
			throw new InvalidArgumentException('ID is read-only and cannot be set');	
		}
		
		if(property_exists($this, $property)) {
			$this->$property = $value;	
		} else {
			throw new InvalidArgumentException('Property '.$property.' does not exist (class: '.get_class($this).')');
		}
	}
	
	/**
	 * Global getter
	 * @param string Property name
	 */
	public function __get($property) {
		if(property_exists($this, $property)) {
			return $this->$property;	
		}
		
		throw new InvalidArgumentException('Property '.$property.' does not exist (class: '.get_class($this).')');
	}
	
	/**
	 * Returns full name
	 * @return string Fullname
	 */
	//public function getName() {
	//	if(empty($this->name)) {
	//		return '';
	//	} else {
	//		return trim($this->name);
	//	}
	//	return trim($this->name);	
	//}
	
	public function __toString() {
		return $this->id();	
	}
	
	public static function find($column = '*', $value = NULL, array $options = array()) {
		$query = 'SELECT * FROM small_station_stg';
		$params = array();
		
		if($column != '*' && strlen($column) > 0 && $value != NULL) {
			$query .= ' WHERE '.Database::makeTableOrColumnName($column).' = :value';
			$params[':value'] = $value;
		}
		
		if(isset($options['orderby']) && isset($options['sort'])) {
			$query .= ' ORDER BY '.Database::makeTableOrColumnName($options['orderby']).' ' . strtoupper($options['sort']);
		}
		
		if(isset($options['limit'])) {
			$query .= ' LIMIT ' . $options['limit'];
		}
			
		$sql = System::getDatabase()->prepare($query);
		$sql->execute($params);
		//var_dump($sql->rowCount());
		
		$list = array();
		
		while($row = $sql->fetch()) {

			$obj = new SmallStationStrength();
			$obj->assign($row);
			$user = User::find('_id', $obj->userid);
			if($user != NULL)
				$obj->user = $user;
			
			$list[] = $obj;	
		}
		return $list;
	}

    public static function needReport() {
            $datetime = new DateTime('now', 'Asia/Shanghai');
            $date   = $datetime->format_as_date();

            $query = 'select count(_id) from small_station_stg where date = :date';
            $params = array(
                'date'  => $date
            );

            $sql = System::getDatabase()->prepare($query);
            $sql->execute($params);
			$record = $sql->fetch();
            if($record['count(_id)'] == 0)
                return TRUE;
            return FALSE;
    }   
	
	
}
?>
