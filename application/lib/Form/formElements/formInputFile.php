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

class formInputFile extends Form {
	public $toCleanTypeFileArray = array(
			'value',
			'alt',
			'checked',
			'maxlength',
			'src'
	);
	public $formTypeFile = '';
	public $formTypeFileOuput = '';
	function generateInputFile(array $formTypeFileAttributes) {
		$this->formTypeFile = $formTypeFileAttributes;
		$this->formInputToValidate = $this->formTypeFile['name'];
		
		parent::validateInput($this->formTypeFile, 'file', 'name');
		if($this->validateInput == TRUE) {
			
			$this->formTypeFile = parent::cleanInputArray($this->formTypeFile, $this->toCleanTypeFileArray, 'file');
			
			$this->formTypeFileOuput = '<input type="file" ';
			$this->formTypeFileOuput .= parent::arraysOutput($this->formTypeFile);
			
			$this->formTypeFileOuput .= parent::makeXHTML();
			$this->formTypeFileOuput .= '>';
		}
		
		return $this->formTypeFileOuput;
	}
}

?>