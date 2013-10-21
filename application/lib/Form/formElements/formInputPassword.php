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

class formInputPassword extends Form {
	private $formTypePassword = '';
	private $formTypePasswordOutput = '';
	private $toCleanTypePasswordArray = array(
			'alt',
			'checked',
			'src',
			'accept'
	);
	function generateInputPassword(array $formTypePasswordAttributes) {
		$this->formTypePassword = $formTypePasswordAttributes;
		$this->formInputToValidate = $this->formTypePassword['name'];
		
		parent::validateInput($this->formTypePassword, 'password', 'name');
		if($this->validateInput == TRUE) {
			$this->formTypePassword = parent::cleanInputArray($this->formTypePassword, $this->toCleanTypePasswordArray, 'password');
			
			$this->formTypePasswordOutput = '<input type="password" ';
			$this->formTypePasswordOutput .= parent::arraysOutput($this->formTypePassword);
			
			$this->formTypePasswordOutput .= parent::makeXHTML();
			$this->formTypePasswordOutput .= ' >';
		}
		
		return $this->formTypePasswordOutput;
	}
}

?>