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

class formTextarea extends Form {
	private $toCleanTypeTextareaArray = array(
			'alt',
			'src',
			'accept',
			'maxlength',
			'src'
	);
	private $formTypeTextarea = '';
	private $formTypeTextareaOutput = '';
	private $valueStrippedTextareaOutput;
	function generateTextarea(array $formTypeTextarea) {
		$this->formTypeTextarea = $formTypeTextarea;
		$this->formInputToValidate = $this->formTypeTextarea['name'];
		
		parent::validateInput($this->formTypeTextarea, 'textarea', 'name');
		if($this->validateInput == TRUE) {
			$this->formTypeTextarea = parent::cleanInputArray($this->formTypeTextarea, $this->toCleanTypeTextareaArray, 'textarea');
			
			$this->formTypeTextareaOutput = '<textarea ';
			$this->formTypeTextareaOutput .= parent::arraysOutput($this->formTypeTextarea);
			$this->formTypeTextareaOutput .= ' >';
			
			$this->formTypeTextareaOuput = self::valueStrippedTextareaOutput($this->formTypeTextareaOutput);
			
			if(isset($this->formTypeTextarea['value']) && trim($this->formTypeTextarea['value']) != '') {
				parent::userCallbackFunction($this->formTypeTextarea);
				if($this->userCallbackFunction != FALSE) {
					$this->formTypeTextareaOutput .= '<?=' . eval($this->userCallbackFunction) . '(' . $this->formTypeTextarea['value'] . ')' . '?>' . '"';
				} else {
					$this->formTypeTextareaOutput .= trim($this->formTypeTextarea['value']);
				}
			}
			$this->formTypeTextareaOutput .= '</textarea>';
		}
		
		return $this->formTypeTextareaOutput;
	}
	function valueStrippedTextareaOutput($textareaOutput) {
		if(preg_match('/value="/', $textareaOutput)) {
			$this->valueStrippedTextareaOutput = preg_replace('/value="(.*)"/', '', $textareaOutput);
		}
		
		return $this->valueStrippedTextareaOutput;
	}
}

?>