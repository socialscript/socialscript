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

namespace lib\Form;

use lib\Form\formElements\formStart;
use lib\Form\formElements\formEnd;
use lib\Form\formElements\formDropdown;
use lib\Form\formElements\formInputButton;
use lib\Form\formElements\formInputCheckbox;
use lib\Form\formElements\formInputDropdown;
use lib\Form\formElements\formInputFile;
use lib\Form\formElements\formInputHidden;
use lib\Form\formElements\formInputImage;
use lib\Form\formElements\formInputPassword;
use lib\Form\formElements\formInputRadio;
use lib\Form\formElements\formInputReset;
use lib\Form\formElements\formInputSubmit;
use lib\Form\formElements\formInputText;
use lib\Form\formElements\formTextarea;

class Form {
	private $debuggingMessage = array();
	private $debuggingMessageToDisplay = '';
	public $formInputToValidate = '';
	public $makeXHTML = ' /';
	function formStart(array $formStartAttributes) {
		return (new formStart() )->formStartForm($formStartAttributes);
	}
	function formEnd() {
		return (new formEnd() )->formEndForm();
	}
	function inputText(array $formTypeTextAttributes) {
		return (new formInputText() )->generateInputText($formTypeTextAttributes);
	}
	function inputFile(array $formTypeFileAttributes) {
		return (new formInputFile() )->generateInputFile($formTypeFileAttributes);
	}
	function inputHidden(array $formTypeHiddenAttributes) {
		return (new formInputHidden() )->generateInputHidden($formTypeHiddenAttributes);
	}
	function Dropdown(array $formTypeDropdownAttributes) {
		return (new formDropdown() )->generateDropdown($formTypeDropdownAttributes);
	}
	function inputButton(array $formTypeHiddenAttributes) {
		return (new formInputButton() )->generateInputButton($formTypeHiddenAttributes);
	}
	function inputCheckbox(array $formTypeCheckboxAttributes) {
		return (new formInputCheckbox() )->generateInputCheckbox($formTypeCheckboxAttributes);
	}
	function inputImage(array $formTypeImageAttributes) {
		return (new formInputImage() )->generateInputImage($formTypeImageAttributes);
	}
	function inputPassword(array $formTypePssswordAttributes) {
		return (new formInputPassword() )->generateInputPassword($formTypePssswordAttributes);
	}
	function inputRadio(array $formTypeRadioAttributes) {
		return (new formInputRadio() )->generateInputRadio($formTypeRadioAttributes);
	}
	function inputReset(array $formTypeResetAttributes) {
		return (new formInputReset() )->generateInputReset($formTypeResetAttributes);
	}
	function inputSubmit(array $formTypSubmitAttributes) {
		return (new formInputSubmit() )->generateInputSubmit($formTypSubmitAttributes);
	}
	function Textarea(array $formTypeTextareaAttributes) {
		return (new formTextarea() )->generateTextarea($formTypeTextareaAttributes);
	}
	function subArraysOutput(array $subArray) {
		$this->subArrayOutput = '';
		
		foreach($subArray as $subArrayAttribute => $subArrayAttributeValue) {
			if(trim($subArrayAttributeValue) != '') {
				$this->subArrayOutput .= ' ' . $subArrayAttribute . '="' . $subArrayAttributeValue . '"';
			}
		}
		
		return $this->subArrayOutput;
	}
	function arraysOutput(array $Array) {
		$this->arrayOutput = '';
		foreach($Array as $Attribute => $Value) {
			// change for value,to do:if user callback not set
			// if((!is_array($Value) && trim($Value) != '') &&
			// strtolower($Attribute) != 'value' && strtolower($Attribute) !=
			// 'standard_attributes' && strtolower($Attribute) !=
			// 'event_attributes' && strtolower($Attribute) !=
			// 'other_attributes')
			if((! is_array($Value) && trim($Value) != '') && strtolower($Attribute) != 'standard_attributes' && strtolower($Attribute) != 'event_attributes' && strtolower($Attribute) != 'other_attributes') {
				$this->arrayOutput .= ' ' . $Attribute . '="' . $Value . '"';
			} elseif(strtolower($Attribute) == 'user_callback_function') {
				self::userCallbackFunction($Array);
				if($this->userCallbackFunction != FALSE) {
					$this->arrayOutput .= ' ' . $Attribute . '="' . '<?=' . eval($this->userCallbackFunction) . '(' . $Value . ')' . '?>' . '"';
				} else {
					$this->arrayOutput .= ' ' . $Attribute . '="' . $Value . '"';
				}
			} 

			elseif(strtolower($Attribute) == 'standard_attributes') {
				$this->arrayOutput .= self::subArraysOutput($Array[$Attribute]);
			} elseif(strtolower($Attribute) == 'event_attributes') {
				$this->arrayOutput .= self::subArraysOutput($Array[$Attribute]);
			} elseif(strtolower($Attribute) == 'other_attributes') {
				$this->arrayOutput .= self::subArraysOutput($Array[$Attribute]);
			}
		}
		
		return $this->arrayOutput;
	}
	function cleanInputArray(array $inputArray, array $toCleanArray, $inputType) {
		foreach($toCleanArray as $Key => $Value) {
			if(array_key_exists($Value, $inputArray)) {
				unset($inputArray[$Value]);
				$this->debuggingMessage[] = $Value . ' is not a valid attribute for ' . $inputType . ' type.It has been unset';
			}
		}
		
		return $inputArray;
	}
	function setXHTML(bool $xhtml) {
		if($xhtml == TRUE) {
			$this->makeXHTML = ' /';
		} else {
			$this->makeXHTML = '';
		}
		
		return $this->makeXHTML;
	}
	function makeXHTML() {
		return $this->makeXHTML;
	}
	function debuggingMessage() {
		if(is_array($this->debuggingMessage)) {
			if(count($this->debuggingMessage) > 0) {
				$this->debuggingMessageToDisplay = implode(' <br/> ', $this->debuggingMessage);
			} else {
				$this->debuggingMessageToDisplay = 'No errors';
			}
		}
		return $this->debuggingMessageToDisplay;
	}
}

?>