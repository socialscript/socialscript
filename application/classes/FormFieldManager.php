<?php
/**
 * This file is part of socialscript (c) 2013 Paul Trombitas.
 *
 * socialscript is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * socialscript is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with socialscript.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace classes;

use lib\Core\Registry;

class FormFieldManager {
	function __construct() {
		$this->Registry = Registry::getInstance();
		$this->DB = $this->Registry->DB;
	}
	function insertTextField($Data) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Data)->executeQuery('INSERT INTO ' . $this->Registry->table_prefix . '_forms( `field_type` ,`name` ,`required` ,`validation` ,`validation_ajax`,`options`,`min`,`max`,`type`)
				VALUES(?,?,?,?,?,?,?,?,?)');
	}
	function insertTextareaField($Data) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Data)->executeQuery('INSERT INTO ' . $this->Registry->table_prefix . '_forms( `field_type` ,`name` ,`required` ,`validation` ,`validation_ajax`,`options`,`min`,`max` ,`type`)
				VALUES(?,?,?,?,?,?,?,?,?)');
	}
	function insertCheckboxField($Data) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Data)->executeQuery('INSERT INTO ' . $this->Registry->table_prefix . '_forms( `field_type` ,`name` ,`required` ,`validation` ,`validation_ajax`,`options`,`min`,`max` ,`type`)
				VALUES(?,?,?,?,?,?,?,?,?)');
	}
	function insertRadioField($Data) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Data)->executeQuery('INSERT INTO ' . $this->Registry->table_prefix . '_forms( `field_type` ,`name` ,`required` ,`validation` ,`validation_ajax`,`options` ,`min`,`max`,`type`)
				VALUES(?,?,?,?,?,?,?,?,?)');
	}
	function insertDropdownField($Data) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Data)->executeQuery('INSERT INTO ' . $this->Registry->table_prefix . '_forms( `field_type` ,`name` ,`required` ,`validation` ,`validation_ajax`,`options` ,`min`,`max`,`type`)
				VALUES(?,?,?,?,?,?,?,?,?)');
	}
	function insertDobField($Data) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Data)->executeQuery('INSERT INTO ' . $this->Registry->table_prefix . '_forms( `field_type` ,`name` ,`required` ,`validation` ,`validation_ajax`,`options` ,`min`,`max`,`type`)
				VALUES(?,?,?,?,?,?,?,?,?)');
	}
	function insertPasswordField($Data) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Data)->executeQuery('INSERT INTO ' . $this->Registry->table_prefix . '_forms( `field_type` ,`name` ,`required` ,`validation` ,`validation_ajax`,options` ,`min`,`max`,`type`)
				VALUES(?,?,?,?,?,?,?,?,?)');
	}
	function insertRepeatPasswordField($Data) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Data)->executeQuery('INSERT INTO ' . $this->Registry->table_prefix . '_forms( `field_type` ,`name` ,`required` ,`validation` ,`validation_ajax`,`options` ,`min`,`max`,`type`)
				VALUES(?,?,?,?,?,?,?,?,?)');
	}
	static function generateFormFields(&$Fields, $Type) {
		foreach($Fields as $k => &$v) {

			switch ($v->field_type) {
				case 'checkbox' :
					$options = explode('|', $v->options);
					unset($options[count($options) - 1]);
					$value = explode('|', $v->value);
					$checked_default = array();
					$i = 0;
					foreach($options as $k2 => $v2) {
						$option = explode(':', $v2);
						unset($option[count($option) - 1]);
						if(in_array($option[0], $value)) {
							$checked_default[$i]['field_name'] = $option[0];
							$checked_default[$i]['name'] = str_replace(' ', '', $option[0]);
							$checked_default[$i]['checked'] = 1;
						} else {
							$checked_default[$i]['field_name'] = $option[0];
							$checked_default[$i]['name'] = str_replace(' ', '', $option[0]);
							$checked_default[$i]['checked'] = 0;
						}
						$i ++;
					}
					$v->checkbox_name = $Type . '_checkbox_' . $v->id;
					$v->elements = $checked_default;
					break;
				case 'radio' :
					$options = explode('|', $v->options);
					unset($options[count($options) - 1]);
					$checked_default = array();
					$i = 0;
					foreach($options as $k2 => $v2) {
						$option = explode(':', $v2);
						if($option[0] == $v->value) {
							$checked_default[$i]['field_name'] = $option[0];
							//$checked_default[$i]['name'] = str_replace(' ', '', $option[0]);
							$checked_default[$i]['name'] =  $option[0];
							$checked_default[$i]['checked'] = 1;
						} else {
							$checked_default[$i]['field_name'] = $option[0];
						//	$checked_default[$i]['name'] = str_replace(' ', '', $option[0]);
							$checked_default[$i]['name'] =  $option[0];
							$checked_default[$i]['checked'] = 0;
						}
						$i ++;
					}
					$v->elements = $checked_default;
					break;
				case 'dropdown' :
					$options = explode('|', $v->options);
					unset($options[count($options) - 1]);
					$checked_default = array();
					$i = 0;
					foreach($options as $k2 => $v2) {
						$option = explode(':', $v2);
						if($option[0] == $v->value) {
							$checked_default[$i]['field_name'] = $option[0];
							$checked_default[$i]['name'] = str_replace(' ', '', $option[0]);
							$checked_default[$i]['checked'] = 1;
						} else {
							$checked_default[$i]['field_name'] = $option[0];
							$checked_default[$i]['name'] = str_replace(' ', '', $option[0]);
							$checked_default[$i]['checked'] = 0;
						}
						$i ++;
					}
					$v->elements = $checked_default;
					break;
				default :

					break;
			}
			$v->field_name = str_replace(' ', '', $v->name);
		}
		// return $Fields;
	}
	static function prepareFieldsForUpdate($Fields) {
		$user_model = new \models\ModelUsers();
		$checkbox_values = '';
		$option_ar = array();
		// pr($Fields);
		foreach($Fields as $k => $v) {
			// p($k);
			if(strpos($k, 'radio') !== FALSE) {
				$Fields_2[$user_model->getUserExtraField($k)] = $v;
			} elseif(strpos($k, 'dropdown') !== FALSE) {
				// p($k);
				$Fields_2[$user_model->getUserExtraField($k)] = next($Fields);
			} elseif(strpos($k, 'checkbox') !== FALSE) {
				$field = $user_model->getUserExtraFieldById(str_replace('checkbox_', '', $v));
				$options_ar = explode('|', $field->options);
				foreach($options_ar as $k2 => $v2) {
					$option_ar = explode(':', $v2);
					if(isset($Fields[$option_ar[0]])) {
						$checkbox_values .= $option_ar[0] . '|';
					}
				}
				$Fields_2[str_replace('checkbox_', '', $v)] = $checkbox_values;
			} elseif(! in_array($v, $option_ar)) {
				$Fields_2[$user_model->getUserExtraField($k)] = $v;
			}
		}
		return $Fields_2;
	}
}

?>