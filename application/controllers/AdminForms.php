<?php

namespace controllers;

use lib\Form\FormValidator;
use lib\Core\Controller as Controller;
use lib\Core\Registry;
use lib\JQGrid\JQGrid;
use models\ModelAdminForms;
use classes\FormFieldManager;

class AdminForms extends Controller {
	function __construct() {
		parent::__construct();
		$this->Registry = Registry::getInstance();
		(new \SplAutoloader('models', array(
				'models'
		)) )->register();
		
		$model = 'models\Model' . $this->Registry->controllerName;
		$this->model = new $model();
		
		(new \SplAutoloader('classes', array(
				'classes'
		)) )->register();
		$this->FormFieldManager = new FormFieldManager();
		$this->DB = $this->Registry->DB;
		
		for($i = 1950; $i < 2010; $i ++) {
			$this->year_dropdown[$i] = $i;
		}
		for($i = 1; $i <= 31; $i ++) {
			$this->days_dropdown[$i] = $i;
		}
		for($i = 1; $i <= 12; $i ++) {
			$this->months_dropdown[$i] = $i;
		}
	}
	function Register() {
		$this->view->assign('form_validators_js_ajax', $this->Registry->form_validators_js_ajax);
		$this->view->assign('days_dropdown', $this->days_dropdown);
		$this->view->assign('months_dropdown', $this->months_dropdown);
		$this->view->assign('years_dropdown', $this->year_dropdown);
		$this->view->assign('validators', $this->Registry->form_validators);
		$this->view->assign('register_form_text', $this->Registry->language['register_form_left_text']);
		$this->view->assign('form_fields_nr', count($this->model->getRegisterFields()));
		$this->view->assign('form_fields', $this->model->getRegisterFields());
		$this->view->display('register_form.tpl');
	}
	function SaveRegister() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		
		// pr($this->POST);
		
		$this->model->DeleteRegister();
		for($i = 0; $i <= 100; $i ++) {
			
			if(isset($this->POST['type_' . $i])) {
				switch ($this->POST['type_' . $i]) {
					case 'text' :
						
						$this->FormFieldManager->insertTextField(array(
								'text',
								$this->POST['label_' . $i],
								(! isset($this->POST['required_' . $i])) ? 0 : $this->POST['required_' . $i],
								$this->POST['validation_' . $i],
								0,
								'',
								(isset($this->POST['min_' . $i])) ? (int) $this->POST['min_' . $i] : 0,
								(isset($this->POST['max_' . $i])) ? (int) $this->POST['max_' . $i] : 0,
								'register_form'
						));
						break;
					case 'textarea' :
						
						$this->FormFieldManager->insertTextareaField(array(
								'textarea',
								$this->POST['label_' . $i],
								(! isset($this->POST['required_' . $i])) ? 0 : $this->POST['required_' . $i],
								$this->POST['validation_' . $i],
								'',
								'',
								(isset($this->POST['min_' . $i])) ? (int) $this->POST['min_' . $i] : 0,
								(isset($this->POST['max_' . $i])) ? (int) $this->POST['max_' . $i] : 0,
								'register_form'
						));
						break;
					case 'checkbox' :
						$options = '';
						foreach($this->POST['label_default_' . $i] as $k => $v) {
							
							$checked = isset($this->POST['checked_default_' . $i][$k]) ? 1 : 0;
							$options .= $v . ':' . $checked . '|';
						}
						
						$this->FormFieldManager->insertCheckboxField(array(
								'checkbox',
								$this->POST['label_' . $i],
								(! isset($this->POST['required_' . $i])) ? 0 : $this->POST['required_' . $i],
								$this->POST['validation_' . $i],
								'',
								$options,
								(isset($this->POST['min_' . $i])) ? (int) $this->POST['min_' . $i] : 0,
								(isset($this->POST['max_' . $i])) ? (int) $this->POST['max_' . $i] : 0,
								'register_form'
						));
						break;
					
					case 'dropdown' :
						$options = '';
						foreach($this->POST['label_default_dropdown_' . $i] as $k => $v) {
							
							if($v != '') {
								$checked = ($this->POST['checked_default_dropdown_' . $i] == $k) ? 1 : 0;
								$options .= $v . ':' . $checked . '|';
							}
						}
						// $options .= ':' .
						// $this->POST['checked_default_dropdown_' . $i];
						
						$this->FormFieldManager->insertDropdownField(array(
								'dropdown',
								$this->POST['label_' . $i],
								(! isset($this->POST['required_' . $i])) ? 0 : $this->POST['required_' . $i],
								$this->POST['validation_' . $i],
								'',
								$options,
								(isset($this->POST['min_' . $i])) ? (int) $this->POST['min_' . $i] : 0,
								(isset($this->POST['max_' . $i])) ? (int) $this->POST['max_' . $i] : 0,
								'register_form'
						));
						break;
					case 'radio' :
						$options = '';
						foreach($this->POST['label_default_radio_' . $i] as $k => $v) {
							
							if($v != '') {
								$checked = ($this->POST['checked_default_radio_' . $i] == $k) ? 1 : 0;
								$options .= $v . ':' . $checked . '|';
							}
						}
						// $options .= ':' .
						// $this->POST['checked_default_radio_' . $i];
						
						$this->FormFieldManager->insertRadioField(array(
								'radio',
								$this->POST['label_' . $i],
								(! isset($this->POST['required_' . $i])) ? 0 : $this->POST['required_' . $i],
								$this->POST['validation_' . $i],
								'',
								$options,
								(isset($this->POST['min_' . $i])) ? (int) $this->POST['min_' . $i] : 0,
								(isset($this->POST['max_' . $i])) ? (int) $this->POST['max_' . $i] : 0,
								'register_form'
						));
						
						break;
					case 'dob' :
						$this->FormFieldManager->insertDobField(array(
								'dob',
								$this->POST['dob-' . $i],
								(! isset($this->POST['required-' . $i])) ? 0 : $this->POST['required-' . $i],
								(isset($this->POST['validation_type-' . $i])) ? $this->POST['validation_type-' . $i] : 0,
								'',
								'',
								(isset($this->POST['min_' . $i])) ? (int) $this->POST['min_' . $i] : 0,
								(isset($this->POST['max_' . $i])) ? (int) $this->POST['max_' . $i] : 0,
								'register_form'
						));
						break;
					case 'password' :
						
						$this->FormFieldManager->insertPasswordField(array(
								'password',
								$this->POST['password-' . $i],
								(! isset($this->POST['required-' . $i])) ? 0 : $this->POST['required-' . $i],
								(isset($this->POST['validation_type-' . $i])) ? $this->POST['validation_type-' . $i] : 0,
								'',
								'',
								(isset($this->POST['min_' . $i])) ? (int) $this->POST['min_' . $i] : 0,
								(isset($this->POST['max_' . $i])) ? (int) $this->POST['max_' . $i] : 0,
								'register_form'
						));
						break;
					case 'password_retype' :
						
						$this->FormFieldManager->insertRepeatPasswordField(array(
								'repeat_password',
								$this->POST['password_retype-' . $i],
								(! isset($this->POST['required-' . $i])) ? 0 : $this->POST['required-' . $i],
								(isset($this->POST['validation_type-' . $i])) ? $this->POST['validation_type-' . $i] : 0,
								'',
								'',
								(isset($this->POST['min_' . $i])) ? (int) $this->POST['min_' . $i] : 0,
								(isset($this->POST['max_' . $i])) ? (int) $this->POST['max_' . $i] : 0,
								'register_form'
						));
						break;
				}
			}
		}
		echo json_encode(array(
				'status' => true
		));
	}
	function userProfile() {
		$this->view->assign('form_validators_js_ajax', $this->Registry->form_validators_js_ajax);
		$this->view->assign('days_dropdown', $this->days_dropdown);
		$this->view->assign('months_dropdown', $this->months_dropdown);
		$this->view->assign('years_dropdown', $this->year_dropdown);
		$this->view->assign('validators', $this->Registry->form_validators);
		$this->view->assign('user_profile_form_text', $this->Registry->language['user_profile_form_left_text']);
		$this->view->assign('form_fields_nr', count($this->model->getProfileFields()));
		$this->view->assign('form_fields', $this->model->getProfileFields());
		$this->view->display('user_profile_form.tpl');
	}
	function saveUserProfile() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		
		// pr($this->POST);
		
		$this->model->Delete('user_profile');
		for($i = 0; $i <= 100; $i ++) {
			
			if(isset($this->POST['type_' . $i])) {
				switch ($this->POST['type_' . $i]) {
					case 'text' :
						
						$this->FormFieldManager->insertTextField(array(
								'text',
								$this->POST['label_' . $i],
								(! isset($this->POST['required_' . $i])) ? 0 : $this->POST['required_' . $i],
								$this->POST['validation_' . $i],
								0,
								'',
								(isset($this->POST['min_' . $i])) ? (int) $this->POST['min_' . $i] : 0,
								(isset($this->POST['max_' . $i])) ? (int) $this->POST['max_' . $i] : 0,
								'user_profile'
						));
						break;
					case 'textarea' :
						
						$this->FormFieldManager->insertTextareaField(array(
								'textarea',
								$this->POST['label_' . $i],
								(! isset($this->POST['required_' . $i])) ? 0 : $this->POST['required_' . $i],
								$this->POST['validation_' . $i],
								'',
								'',
								(isset($this->POST['min_' . $i])) ? (int) $this->POST['min_' . $i] : 0,
								(isset($this->POST['max_' . $i])) ? (int) $this->POST['max_' . $i] : 0,
								'user_profile'
						));
						break;
					case 'checkbox' :
						$options = '';
						foreach($this->POST['label_default_' . $i] as $k => $v) {
							
							$checked = isset($this->POST['checked_default_' . $i][$k]) ? 1 : 0;
							$options .= $v . ':' . $checked . '|';
						}
						
						$this->FormFieldManager->insertCheckboxField(array(
								'checkbox',
								$this->POST['label_' . $i],
								(! isset($this->POST['required_' . $i])) ? 0 : $this->POST['required_' . $i],
								$this->POST['validation_' . $i],
								'',
								$options,
								(isset($this->POST['min_' . $i])) ? (int) $this->POST['min_' . $i] : 0,
								(isset($this->POST['max_' . $i])) ? (int) $this->POST['max_' . $i] : 0,
								'user_profile'
						));
						break;
					
					case 'dropdown' :
						$options = '';
						foreach($this->POST['label_default_dropdown_' . $i] as $k => $v) {
							
							if($v != '') {
								$checked = ($this->POST['checked_default_dropdown_' . $i] == $k) ? 1 : 0;
								$options .= $v . ':' . $checked . '|';
							}
						}
						// $options .= ':' .
						// $this->POST['checked_default_dropdown_' . $i];
						
						$this->FormFieldManager->insertDropdownField(array(
								'dropdown',
								$this->POST['label_' . $i],
								(! isset($this->POST['required_' . $i])) ? 0 : $this->POST['required_' . $i],
								$this->POST['validation_' . $i],
								'',
								$options,
								(isset($this->POST['min_' . $i])) ? (int) $this->POST['min_' . $i] : 0,
								(isset($this->POST['max_' . $i])) ? (int) $this->POST['max_' . $i] : 0,
								'user_profile'
						));
						break;
					case 'radio' :
						$options = '';
						foreach($this->POST['label_default_radio_' . $i] as $k => $v) {
							
							if($v != '') {
								$checked = ($this->POST['checked_default_radio_' . $i] == $k) ? 1 : 0;
								$options .= $v . ':' . $checked . '|';
							}
						}
						// $options .= ':' .
						// $this->POST['checked_default_radio_' . $i];
						
						$this->FormFieldManager->insertRadioField(array(
								'radio',
								$this->POST['label_' . $i],
								(! isset($this->POST['required_' . $i])) ? 0 : $this->POST['required_' . $i],
								$this->POST['validation_' . $i],
								'',
								$options,
								(isset($this->POST['min_' . $i])) ? (int) $this->POST['min_' . $i] : 0,
								(isset($this->POST['max_' . $i])) ? (int) $this->POST['max_' . $i] : 0,
								'user_profile'
						));
						
						break;
					case 'dob' :
						$this->FormFieldManager->insertDobField(array(
								'dob',
								$this->POST['dob-' . $i],
								(! isset($this->POST['required-' . $i])) ? 0 : $this->POST['required-' . $i],
								(isset($this->POST['validation_type-' . $i])) ? $this->POST['validation_type-' . $i] : 0,
								'',
								'',
								(isset($this->POST['min_' . $i])) ? (int) $this->POST['min_' . $i] : 0,
								(isset($this->POST['max_' . $i])) ? (int) $this->POST['max_' . $i] : 0,
								'user_profile'
						));
						break;
					case 'password' :
						
						$this->FormFieldManager->insertPasswordField(array(
								'password',
								$this->POST['password-' . $i],
								(! isset($this->POST['required-' . $i])) ? 0 : $this->POST['required-' . $i],
								(isset($this->POST['validation_type-' . $i])) ? $this->POST['validation_type-' . $i] : 0,
								'',
								'',
								(isset($this->POST['min_' . $i])) ? (int) $this->POST['min_' . $i] : 0,
								(isset($this->POST['max_' . $i])) ? (int) $this->POST['max_' . $i] : 0,
								'user_profile'
						));
						break;
					case 'password_retype' :
						
						$this->FormFieldManager->insertRepeatPasswordField(array(
								'repeat_password',
								$this->POST['password_retype-' . $i],
								(! isset($this->POST['required-' . $i])) ? 0 : $this->POST['required-' . $i],
								(isset($this->POST['validation_type-' . $i])) ? $this->POST['validation_type-' . $i] : 0,
								'',
								'',
								(isset($this->POST['min_' . $i])) ? (int) $this->POST['min_' . $i] : 0,
								(isset($this->POST['max_' . $i])) ? (int) $this->POST['max_' . $i] : 0,
								'user_profile'
						));
						break;
				}
			}
		}
		echo json_encode(array(
				'status' => true
		));
	}
}

?>