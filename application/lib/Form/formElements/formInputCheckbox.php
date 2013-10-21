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

class formInputCheckbox extends Form {
	private $toCleanTypeCheckboxArray = array(
			'alt',
			'src',
			'accept',
			'maxlength',
			'src'
	);
	private $formTypeCheckbox = '';
	private $formTypeCheckboxOutput = '';
	function generateInputCheckbox(array $formTypeCheckboxAttributes) {
		$this->formTypeCheckbox = $formTypeCheckboxAttributes;
		$this->formInputToValidate = $this->formTypeCheckbox['name'];
		
		parent::validateInput($this->formTypeCheckbox, 'checkbox', 'name');
		if($this->validateInput == TRUE) {
			$this->formInputToValidate = $this->formTypeCheckbox['value'];
			Form::validateInput($this->formTypeCheckbox, 'checkbox', 'value');
			if($this->validateInput == TRUE) {
				$this->formTypeCheckbox = parent::cleanInputArray($this->formTypeCheckbox, $this->toCleanTypeCheckboxArray, 'checkbox');
				
				$this->formTypeCheckboxOuput = '<input type="checkbox" ';
				$this->formTypeCheckboxOuput .= parent::arraysOutput($this->formTypeCheckbox);
				
				$this->formTypeCheckboxOuput .= parent::makeXHTML();
				$this->formTypeCheckboxOuput .= ' >';
			}
		}
		
		return $this->formTypeCheckboxOuput;
	}
}

?>