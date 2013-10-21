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

namespace lib\Form\FormValidator;

use lib\WNException\WNException;
use lib\Core\Registry;

class FormValidator {
	private $_varToFilter;
	private $_varFilter;
	private $_arrayToFilter;
	private $_arrayFilters;
	function __construct() {
	}
	function setVarToFilter($_varToFilter) {
		$this->_varToFilter = $_varToFilter;
		return $this;
	}
	function getVarToFilter() {
		return $this->_varToFilter;
	}
	function setVarFilter($_varFilter) {
		$this->_varFilter = $_varFilter;
		return $this;
	}
	function getVarFilter() {
		return $this->_varFilter;
	}
	function setArrayToFilter(array $_arrayToFilter) {
		try {

			if(! is_array($_arrayToFilter)) {
				throw new WNException('The array to filter must be an array');
			}

			$this->_arrayToFilter = $_arrayToFilter;
		} catch ( WNException $e ) {
			$e->manageException();
		}
		return $this;
	}
	function getArrayToFilter() {
		return $this->_arrayToFilter;
	}
	function setArrayFilters(array $_arrayFilters) {
		try {

			if(! is_array($_arrayFilters)) {
				throw new WNException('The array filters must be an array');
			}
			$this->_arrayFilters = $_arrayFilters;
		} catch ( WNException $e ) {
			$e->manageException();
		}
		return $this;
	}
	function getArrayFilters() {
		return $this->_arrayFilters;
	}
	function validateVar() {
		return filter_var($this->_varToFilter, $this->_varFilter);
	}
	function validateArray() {
		// var_dump($this->_arrayFilters);
		// var_dump($this->_arrayToFilter);
		return filter_var_array($this->_arrayToFilter, $this->_arrayFilters);
	}
	function createValidationArray($formFields) {
		$this->Registry = Registry::getInstance();

		foreach($formFields as $k => $v) {

			$v->validation = ucfirst($v->validation);
			if($v->field_type == 'dob') {

				$array_filters['year'] = array(
						'filter' => FILTER_VALIDATE_INT,
						'options' => array(
								'min_range' => 4
						)
				);

			} else {
				switch ($v->validation) {
					case '0' :
						break;
					case 'Email' :
						$array_filters[$v->field_name] = array(
								'filter' => FILTER_VALIDATE_EMAIL
						);
						break;
					case 'Numeric' :
						$options_ar = array();
						if($v->min != 0 || $v->max != 0) {
							$v->min != 0 ? $options_ar['min_range'] = $v->min : NULL;
							$v->max != 0 ? $options_ar['max_range'] = $v->max : NULL;
						}
						$array_filters[$v->field_name] = array(
								'filter' => FILTER_VALIDATE_INT,
								'options' => $options_ar
						);
						break;
					case 'Ipv4' :
						$array_filters[$v->field_name] = array(
								'filter' => FILTER_VALIDATE_IP,
								'flags' => FILTER_FLAG_IPV4
						);
						break;
					case 'Ipv6' :
						$array_filters[$v->field_name] = array(
								'filter' => FILTER_VALIDATE_IP,
								'flags' => FILTER_FLAG_IPV6
						);
						break;
					case 'Url' :
						$array_filters[$v->field_name] = array(
								'filter' => FILTER_VALIDATE_URL
						);
						break;
					case 'LettersAndNumbers' :
					case 'OnlyLetters' :
					case 'Lowercase' :
					case 'Uppercase' :
					case 'OnlyNumbersAndSpace' :
					case 'OnlyLettersAndSpace' :
					case 'OnlyLettersAndUnderscore' :
					case 'LetterNumberUnderscore' :
					case 'AtLeastOneNumberOneLowercaseOneUppercase' :
						$chars = '';
						if($v->min > 0 || $v->max > 0) {
							$chars = '.{' . $v->min . ',' . $v->max . '}';
						}
						$array_filters[$v->field_name] = array(
								'filter' => FILTER_VALIDATE_REGEXP,
								'options' => array(
										"regexp" => str_replace('.{min,max}', $chars, $this->Registry->form_validators_regexp[$v->validation])
								)
						);
						break;
					default :
						$options_ar = array();
						if($v->min != 0 || $v->max != 0) {
							$v->min != 0 ? $options_ar['min_range'] = $v->min : NULL;
							$v->max != 0 ? $options_ar['max_range'] = $v->max : NULL;
						}
						$array_filters[$v->field_name] = array(
								'filter' => FILTER_CALLBACK,
								'options' => array(
										$this->Registry->form_validators[$v->validation],
										'min_range' => 6,
										'max_range' => 10
								)
						);
						break;
				}
			}
		}
		return $array_filters;
	}
	function getAvailableFilters() {
		foreach(filter_list() as $key => $value) {
			echo "<br>" . $key . "=" . $value . '=' . filter_id($value);
		}
	}
	function __destruct() {
	}
}

?>