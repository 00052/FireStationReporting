<?php
final class OfficerController extends ControllerBase {
	protected function onBefore($action = '') {
		parent::checkIfAdmin();
	}
	
	private function checkOfficer($department,$duty) {
		if($department > count(Profile::getDepartments())-1 || $duty > count(Profile::getDuties())-1) {
			System::displayError(System::getLanguage()->_('InvalidRequest'), '400 Bad Request');
			exit;
		}
	}

	private function officerArrayTranslated($officers) {
		
		for($i=0; $i<count($officers); $i++) {
			$officers[$i]->duty = System::getLanguage()->_(Profile::getDuty($officers[$i]->duty));
			$officers[$i]->department= System::getLanguage()->_(Profile::getDepartment($officers[$i]->department));
		}
		return $officers;
	}
	public function index() {
		$officers = Officer::find();
		$smarty = new Template;
		$smarty->assign('title',System::getLanguage()->_('OfficerPanel'));
		$smarty->assign('heading',System::getLanguage()->_('OfficerPanel'));
		$smarty->assign('officers', $this->officerArrayTranslated($officers));

		$smarty->display('officer/index.tpl');
	}

	public function add() {
		$officer = new Officer;
		$form = new Form('form-add-officer', Router::getInstance()->build('OfficerController', 'add'));
		$form->binding = $officer;

		$fieldset = new Fieldset(System::getLanguage()->_('General'));

		$name = new Text('officer-name', System::getLanguage()->_('OfficerName'), true);
		$name->binding = new Databinding('name');
		$name->maxlength = 18;
		$name->minlength = 6;


		$departmentArray = array();
		foreach(Profile::getDepartments() as $i => $str)
			$departmentArray[$i] = System::getLanguage()->_($str);

		$department = new Select(
			'officer-department', System::getLanguage()->_('Department'),
			$departmentArray
		);
		$department->binding = new Databinding('department');


		$dutiesArray = array();
		foreach(Profile::getDuties() as $i => $str)
			$dutiesArray[$i] = System::getLanguage()->_($str);


		$duty = new Select(
			'officer-duty', System::getLanguage()->_('Duty'),
			$dutiesArray
		);
		$duty->binding = new Databinding('duty');

		$fieldset->addElements($name, $department, $duty);

		$form->addElements($fieldset);

		$form->setSubmit(
			new Button(
				System::getLanguage()->_('Submit'), 
				'floppy-disk'
				//Router::getInstance()->build('OfficerController', 'index')
			)
		);

		$form->addButton(
			new Button(
				System::getLanguage()->_('Cancel'),
				'remove',
				Router::getInstance()->build('OfficerController', 'index')
			)
		);

				


		if(Utils::getPOST('submit', false) !== false) {

			if($form->validate()) {
				$form->save();
				$this->checkOfficer($officer->department, $officer->duty);
				$officer->save();
				System::getSession()->setData('successMsg', System::getLanguage()->_('OfficerAdded'));
				System::forwardToRoute(Router::getInstance()->build('OfficerController', 'index'));
				exit;
			}
		} else {
			$form->fill();  
		}

		$smarty = new Template;
		$smarty->assign('title', System::getLanguage()->_('AddOfficer'));
		$smarty->assign('heading', System::getLanguage()->_('AddOfficer'));

		$smarty->assign('form', $form);
		$smarty->display('form.tpl');



	}


	public function edit() {

		$officer = Officer::find('_id', $this->getParam('id'));
		if(count($officer) == 0) {
			System::displayError(System::getLanguage()->_('OfficerNotFound'), '404 Not Found');
			exit;
		}
		$officer = $officer[0];

		$form = new Form('form-edit-officer', Router::getInstance()->build('OfficerController', 'edit'));
		$form->binding = $officer;
		$name = new Text('officer-name', System::getLanguage()->_('Name'), true);
		$name->binding = new Databinding('name');

		$name->maxlength = 18;
		$name->minlength = 6;


		$departmentArray = array();
		foreach(Profile::getDepartments() as $i => $str)
			$departmentArray[$i] = System::getLanguage()->_($str);

		$department = new Select(
			'officer-department', System::getLanguage()->_('Department'),
			$departmentArray
		);
		$department->binding = new Databinding('department');


		$dutiesArray = array();
		foreach(Profile::getDuties() as $i => $str)
			$dutiesArray[$i] = System::getLanguage()->_($str);


		$duty = new Select(
			'officer-duty', System::getLanguage()->_('Duty'),
			$dutiesArray
		);
		$duty->binding = new Databinding('duty');

		$form->addElements($name, $department, $duty);


		$form->setSubmit(
			new Button(
				System::getLanguage()->_('Submit'), 
				'floppy-disk'
			)
		);

		$form->addButton(
			new Button(
				System::getLanguage()->_('Cancel'),
				'remove',
				Router::getInstance()->build('OfficerController', 'index')
			)
		);

				


		if(Utils::getPOST('submit', false) !== false) {

			if($form->validate()) {
				$form->save();
				$this->checkOfficer($officer->department, $officer->duty);
				$officer->save();
				System::forwardToRoute(Router::getInstance()->build('OfficerController', 'index'));
				exit;
			}
		} else {
			$form->fill();  
		}

		$smarty = new Template;
		$smarty->assign('title', System::getLanguage()->_('EditOfficer'));
		$smarty->assign('heading', System::getLanguage()->_('EditOfficer'));

		$smarty->assign('form', $form);
		$smarty->display('form.tpl');

	}

	public function delete() {
		$officers = Officer::find('_id', $this->getParam('id', 0));
		

		if($officers == NULL) {
			System::displayError(System::getLanguage()->_('ErrorOfficerNotFound'), '404 Not Found');   
		}
		$officer = $officers[0];


		$officer->delete();

		System::forwardToRoute(Router::getInstance()->build('OfficerController', 'index'));
	}

	public function onFinished($action = '') {

	}
	

}
?>
