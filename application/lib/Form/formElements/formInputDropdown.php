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

class formInputDropdown {
	function formTypeDropdown(array $formTypeDropdown) {
		$this->formTypeDropdown = $formTypeDropdown;
		$this->formInputToValidate = $this->formTypeDropdown['name'];
		
		parent::validateInput($this->formTypeDropdown, 'dropdown', 'name');
		if($this->validateInput == TRUE) {
			
			$this->formInputToValidate = $this->formTypeDropdown['option'];
			parent::validateInput($this->formTypeDropdown, 'dropdown', 'option');
			if($this->validateInput == TRUE) {
				$this->formTypeDropdown = Form::cleanInputArray($this->formTypeDropdown, $this->toCleanTypeDropdownArray, 'dropdown');
				
				$this->formTypeDropdownOuput = '<select ';
				$this->formTypeDropdownOuput .= Form::arraysOutput($this->formTypeDropdown);
				
				$this->formTypeDropdownOuput .= ' >';
				
				$this->formTypeDropdownOuput .= Form::dropdownOptionsOutput($this->formTypeDropdown['option'], $this->formTypeDropdown['option_selected']);
				
				$this->formTypeDropdownOuput .= '</select>';
			}
		}
		
		return $this->formTypeDropdownOuput;
	}
}

?>