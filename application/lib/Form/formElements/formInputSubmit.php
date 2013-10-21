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

class formInputSubmit extends Form {
	private $toCleanTypeSubmitArray = array(
			'accept',
			'checked',
			'maxlength',
			'src',
			'alt'
	);
	private $formTypeSubmit = '';
	private $formTypeSubmitOutput = '';
	function generateInputSubmit(array $formTypeSubmitAttributes) {
		$this->formTypeSubmit = $formTypeSubmitAttributes;
		$this->formInputToValidate = $this->formTypeSubmit['name'];
		
		parent::validateInput($this->formTypeSubmit, 'submit', 'name');
		if($this->validateInput == TRUE) {
			$this->formTypeSubmit = parent::cleanInputArray($this->formTypeSubmit, $this->toCleanTypeSubmitArray, 'submit');
			
			$this->formTypeSubmitOutput = '<input type="submit" ';
			$this->formTypeSubmitOutput .= parent::arraysOutput($this->formTypeSubmit);
			
			$this->formTypeSubmitOutput .= parent::makeXHTML();
			$this->formTypeSubmitOutput .= '>';
		}
		
		return $this->formTypeSubmitOutput;
	}
}

?>