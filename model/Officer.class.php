<?php
final class Officer extends ModelBase {
	/**
	 * 警官ID
	 * @var int
	 */
	private $id;

	/**
	 * 警官姓名
	 * @var string
	 */
	private $name;

	/**
	 * 部门
	 * @var int
	 */
	private $department;
	
	/**
	 * 值班岗位
	 * @var int
	 */
	private $duty;

	/**
	 * Constructor
	 * @param mixed An Officer Identiefier either the numeeric 
	 */
	public function __construct() { }
	
	protected function assign(array $row) {
		$this->isNewRecord	= false;
		$this->id			= $row['_id'];
		$this->name			= $row['name'];
		$this->department	= $row['department'];
		$this->duty			= $row['duty'];
	}

	/**
	 * Saves changes to DB
	 */
	public function save() {
		$data = array(
			':name' => $this->name,
			':department' => $this->department,
			':duty' => $this->duty,
		);
		
		if($this->isNewRecord) {
			$sql = System::getDatabase()->prepare('INSERT INTO officers (department, name, duty) VALUES(:department, :name, :duty)');
			$sql->execute($data);
			
			$this->id = System::getDatabase()->lastInsertId();
		} else {
			$data[':id']	= $this->id;
			
			$sql = System::getDatabase()->prepare('UPDATE officers SET department = :department, name = :name, duty = :duty WHERE _id = :id');
			
			$sql->execute($data);
		}
	}
	
	public function delete() {
		
		// Delete user
		$sql = System::getDatabase()->prepare('DELETE FROM officers WHERE _id = :id');
		$sql->execute(array(':id' => $this->id));
        
        Log::sysLog("Officer", "Officer ".$this->getName()." was deleted");
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
		return $this->getName();	
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
		$query = 'SELECT * FROM officers';
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
	
		$list = array();
		
		while($row = $sql->fetch()) {

			$officer = new Officer();
			$officer->assign($row);
			
			$list[] = $officer;	
		}
		return $list;
	}
	
}
?>
