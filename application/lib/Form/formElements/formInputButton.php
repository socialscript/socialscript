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

class formInputButton extends Form {
	public $toCleanTypeButtonArray = array(
			'accept',
			'checked',
			'maxlength',
			'alt',
			'readonly'
	);
	public $formTypeButton = '';
	public $formTypeButtonOutput = '';
	function generateInputButton(array $formTypeButtonAttributes) {
		$this->formTypeButton = $formTypeButtonAttributes;
		$this->formInputToValidate = $this->formTypeButton['name'];
		
		parent::validateInput($this->formTypeButton, 'button', 'name');
		if($this->validateInput == TRUE) {
			$this->formTypeButton = parent::cleanInputArray($this->formTypeButton, $this->toCleanTypeButtonArray, 'text');
			
			$this->formTypeButtonOuput = '<input type="button" ';
			$this->formTypeButtonOuput .= parent::arraysOutput($this->formTypeButton);
			
			$this->formTypeButtonOuput .= parent::makeXHTML();
			$this->formTypeButtonOuput .= ' >';
		}
		
		return $this->formTypeButtonOuput;
	}
}

?>