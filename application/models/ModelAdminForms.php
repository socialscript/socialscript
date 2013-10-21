<?php

namespace models;

use lib\Core\Model as Model;

class ModelAdminForms extends Model {
	function __construct() {
		parent::__construct();
	}
	function getRegisterFields() {
		$result = $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->table_prefix . '_forms WHERE type="register_form" AND id>4 ORDER BY id ASC');
		
		foreach($result as $k => &$v) {
			$options = array();
			$v->name = ucwords($v->name);
			if($v->field_type == 'checkbox' || $v->field_type == 'radio' || $v->field_type == 'dropdown') {
				$options = explode('|', $v->options);
				unset($options[count($options) - 1]);
				
				$i = 0;
				foreach($options as $k2 => $v2) {
					
					list($v->elements[$i]['name'], $v->elements[$i]['checked']) = explode(':', $v2);
					// $v->elements[$i]['field_name'] =
					// strtolower(preg_replace('/[^A-Za-z0-9]/', '',
					// $v->elements[$i]['name']));
					$v->elements[$i]['field_name'] = strtolower(str_replace(' ', '', $v->elements[$i]['name']));
					$i ++;
				}
			}
			// $v->field_name = strtolower(preg_replace('/[^A-Za-z0-9]/', '',
			// $v->name));
			$v->field_name = strtolower(str_replace(' ', '', $v->name));
			$v->value = '';
		}
		
		return $result;
	}
	function getProfileFields() {
		$result = $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->table_prefix . '_forms WHERE type="user_profile" ORDER BY id ASC');
		foreach($result as $k => &$v) {
			$options = array();
			$v->name = ucwords($v->name);
			if($v->field_type == 'checkbox' || $v->field_type == 'radio' || $v->field_type == 'dropdown') {
				$options = explode('|', $v->options);
				unset($options[count($options) - 1]);
				
				$i = 0;
				foreach($options as $k2 => $v2) {
					
					list($v->elements[$i]['name'], $v->elements[$i]['checked']) = explode(':', $v2);
					// $v->elements[$i]['field_name'] =
					// strtolower(preg_replace('/[^A-Za-z0-9]/', '',
					// $v->elements[$i]['name']));
					$v->elements[$i]['field_name'] = strtolower(str_replace(' ', '', $v->elements[$i]['name']));
					$i ++;
				}
			}
			// $v->field_name = strtolower(preg_replace('/[^A-Za-z0-9]/', '',
			// $v->name));
			$v->field_name = strtolower(str_replace(' ', '', $v->name));
			$v->value = '';
		}
		return $result;
	}
	function DeleteRegister() {
		$this->DB->loadQuery('DELETE')->executeQuery('DELETE FROM ' . $this->table_prefix . '_forms WHERE type ="register_form" AND id > 4 ');
	}
	function Delete($Type) {
		$this->DB->loadQuery('DELETE')->executeQuery('DELETE FROM ' . $this->table_prefix . '_forms WHERE type ="' . $Type . '" ');
	}
}

?>