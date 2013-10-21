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

class formInputRadio extends Form {
	private $toCleanTypeRadioArray = array(
			'alt',
			'src',
			'accept',
			'maxlength',
			'src'
	);
	private $formTypeRadio = '';
	private $formTypeRadioOutput = '';
	function generateInputRadio(array $formTypeRadioAttributes) {
		$this->formTypeRadio = $formTypeRadioAttributes;
		$this->formInputToValidate = $this->formTypeRadio['name'];
		
		parent::validateInput($this->formTypeRadio, 'radio', 'name');
		if($this->validateInput == TRUE) {
			$this->formInputToValidate = $this->formTypeRadio['value'];
			parent::validateInput($this->formTypeRadio, 'radio', 'value');
			if($this->validateInput == TRUE) {
				$this->formTypeRadio = parent::cleanInputArray($this->formTypeRadio, $this->toCleanTypeRadioArray, 'radio');
				
				$this->formTypeRadioOutput = '<input type="radio" ';
				$this->formTypeRadioOutput .= parent::arraysOutput($this->formTypeRadio);
				
				$this->formTypeRadioOutput .= parent::makeXHTML();
				$this->formTypeRadioOutput .= '>';
			}
		}
		
		return $this->formTypeRadioOutput;
	}
}

?>