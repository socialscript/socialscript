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

namespace lib\Form\formElements;

use lib\Form\Form;

class formDropdown extends Form {
	public $toCleanTypeDropdownArray = array(
			'alt',
			'src',
			'accept',
			'maxlength',
			'src',
			'checked'
	);
	public $formTypeDropdown = '';
	public $formTypeDropdownOutput = '';
	function generateDropdown($formTypeDropdown) {
		$this->formTypeDropdown = $formTypeDropdown;
		$this->formInputToValidate = $this->formTypeDropdown['name'];
		
		parent::validateInput($this->formTypeDropdown, 'dropdown', 'name');
		if($this->validateInput == TRUE) {
			
			$this->formInputToValidate = $this->formTypeDropdown['option'];
			parent::validateInput($this->formTypeDropdown, 'dropdown', 'option');
			if($this->validateInput == TRUE) {
				$this->formTypeDropdown = parent::cleanInputArray($this->formTypeDropdown, $this->toCleanTypeDropdownArray, 'dropdown');
				
				$this->formTypeDropdownOuput = '<select ';
				$this->formTypeDropdownOuput .= parent::arraysOutput($this->formTypeDropdown);
				
				$this->formTypeDropdownOuput .= ' >';
				
				$this->formTypeDropdownOuput .= self::dropdownOptionsOutput($this->formTypeDropdown['option'], $this->formTypeDropdown['option_selected']);
				
				$this->formTypeDropdownOuput .= '</select>';
			}
		}
		
		return $this->formTypeDropdownOuput;
	}
	function dropdownOptionsOutput($optionArray, $selectedOption) {
		foreach($optionArray as $Key => $Value) {
			$this->dropdownOptionsOutput .= '<option value="' . $Key . '"';
			if($selectedOption == $Key) {
				$this->dropdownOptionsOutput .= ' selected="selected" ';
			}
			$this->dropdownOptionsOutput .= '>' . $Value . '</option>';
		}
		return $this->dropdownOptionsOutput;
	}
}

?>