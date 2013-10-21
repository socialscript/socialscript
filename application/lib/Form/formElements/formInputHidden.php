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

class formInputHidden extends Form {
	public $toCleanTypeHiddenArray = array(
			'size',
			'accept',
			'alt',
			'checked',
			'disabled',
			'maxlength',
			'src'
	);
	public $formTypeHidden = '';
	public $formTypeHiddenOutput = '';
	function generateInputHidden(array $formTypeHiddenAttributes) {
		$this->formTypeHidden = $formTypeHiddenAttributes;
		$this->formInputToValidate = $this->formTypeHidden['name'];
		
		parent::validateInput($this->formTypeHidden, 'hidden', 'name');
		if($this->validateInput == TRUE) {
			
			$this->formTypeHidden = parent::cleanInputArray($this->formTypeHidden, $this->toCleanTypeHiddenArray, 'hidden');
			
			$this->formTypeHiddenOutput = '<input type="hidden" ';
			$this->formTypeHiddenOutput .= parent::arraysOutput($this->formTypeHidden);
			
			$this->formTypeHiddenOutput .= parent::makeXHTML();
			$this->formTypeHiddenOutput .= '>';
		}
		
		return $this->formTypeHiddenOutput;
	}
}

?>