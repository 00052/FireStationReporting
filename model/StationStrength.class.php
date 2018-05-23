<?php
use ICanBoogie\DateTime;
final class StationStrength extends ModelBase {
	private $id;
	private $userid;
	private $user;
	private $date;
	private $nofficer;
	private $nsoldier;
	private $nemployee;
	private $nfireengine;
	private $ndriver;

	/**
	 * Constructor
	 * @param mixed An Officer Identiefier either the numeeric 
	 */
	public function __construct() { }
	
	protected function assign(array $row) {
		$this->isNewRecord	= false;
		$this->userid			= $row['user_ID'];
		$this->date          	= $row['date'];
		$this->nofficer      	= $row['officer'];
		$this->nsoldier      	= $row['soldier'];
		$this->nemployee     	= $row['employee'];
		$this->nfireengine   	= $row['fireengine'];
		$this->ndriver       	= $row['driver'];
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
			':officer' => $this->nofficer,
			':soldier' => $this->nsoldier,
			':employee' => $this->nemployee,
			':fireengine' => $this->nfireengine,
			':driver' => $this->ndriver
		);
		
		if($this->isNewRecord) {
			$sql = System::getDatabase()->prepare('INSERT INTO station_stg(user_ID, date, officer, soldier, employee, fireengine, driver) VALUES(:user_ID, :date, :officer, :soldier, :employee, :fireengine, :driver)');
			$sql->execute($data);
			
			$this->id = System::getDatabase()->lastInsertId();
		} else {
			$data[':id']	= $this->id;
			
			$sql = System::getDatabase()->prepare('INSERT INTO station_stg(_id, user_ID, officer, soldier, employee, fireengine, dirver) VALUES(:id, :user_ID, :officer, :soldier, :employee, :fireengine, :driver)');
			
			$sql->execute($data);
		}
	}
	
	public function delete() {
		
		// Delete user
		$sql = System::getDatabase()->prepare('DELETE FROM station_stg WHERE _id = :id');
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
	public function getName() {
		if(empty($this->name)) {
			return '';
		} else {
			return trim($this->name);
		}
		return trim($this->name);	
	}
	
	public function __toString() {
		return $this->id();	
	}
	
	//public function getFolders() {
	//	$list = array();
	//	
	//	$folders = Folder::find('user_ID', $this->uid);
	//	
	//	if(is_array($folders)) {
	//		$list = $folders;	
	//	} else if($folders != NULL) {
	//		$list[] = $folders;	
	//	}
	//	
	//	return $list;	
	//}
	
	public static function find($column = '*', $value = NULL, array $options = array()) {
		$query = 'SELECT * FROM station_stg';
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
		
		if($sql->rowCount() == 0) {
			return NULL;	
		} /*else if($sql->rowCount() == 1) {
			$officer = new Officer();
			$officer->assign($sql->fetch());
			
			return $officer;
		} */else {
			$list = array();
			
			while($row = $sql->fetch()) {

				$obj = new StationStrength();
				$obj->assign($row);
				$user = User::find('_id', $obj->userid);
				if($user != NULL)
					$obj->user = $user;
				
				$list[] = $obj;	
			}
			return $list;
		}
	}

	public static function needReport() {
			$datetime = new DateTime('now', 'Asia/Shanghai');
			$date	= $datetime->format_as_date();

			$query = 'select count(_id) from station_stg where date = :date';
			$params = array(
				'date'	=> $date
			);

			$sql = System::getDatabase()->prepare($query);
			$sql->execute($params);

			if($sql->rowCount() == 0)
				return TRUE;
			return FALSE;
	}
}
?>
