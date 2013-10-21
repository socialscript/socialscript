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

class formInputImage extends Form {
	public $toCleanTypeImageArray = array(
			'accept',
			'checked',
			'maxlength',
			'src'
	);
	public $formTypeImage = '';
	public $formTypeImageOutput = '';
	function generateInputImage(array $formTypeImage) {
		$this->formTypeImage = $formTypeImage;
		$this->formInputToValidate = $this->formTypeImage['name'];
		
		parent::validateInput($this->formTypeImage, 'image', 'name');
		if($this->validateInput == TRUE) {
			
			$this->formTypeImage = parent::cleanInputArray($this->formTypeImage, $this->toCleanTypeImageArray, 'image');
			
			$this->formTypeImageOuput = '<input type="image" ';
			$this->formTypeImageOuput .= parent::arraysOutput($this->formTypeImage);
			
			$this->formTypeImageOuput .= parent::makeXHTML();
			$this->formTypeImageOuput .= ' >';
		}
		
		return $this->formTypeImageOutput;
	}
}

?>