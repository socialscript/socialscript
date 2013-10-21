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

class formStart extends Form {
	public $formMethodOptions = array(
			"POST",
			"GET"
	);
	public $formTargetOptions = array(
			"_self",
			"_parent",
			"_blank",
			"_top"
	);
	public $formEnctypeOptions = array(
			"text/plain",
			"multipart/form-data"
	);
	public $formStartOutput = '';
	public $formMethod = '';
	public $formAction = '';
	public $formTarget = '';
	public $formEnctype = '';
	public $formStartAttributes = array();
	function formStartSetDefaults() {
		$this->formStartAttributes['method'] = ((in_array(strtoupper(trim($this->formStartAttributes['method'])), $this->formMethodOptions)) ? $this->formStartAttributes['method'] : 'POST');
		$this->formStartAttributes['action'] = ((trim($this->formStartAttributes['action']) != '') ? $this->formStartAttributes['action'] : '');
		$this->formStartAttributes['target'] = ((in_array(strtolower(trim($this->formStartAttributes['target'])), $this->formTargetOptions)) ? $this->formStartAttributes['target'] : '_self');
		$this->formStartAttributes['enctype'] = ((in_array(strtolower(trim($this->formStartAttributes['enctype'])), $this->formEnctypeOptions)) ? $this->formStartAttributes['enctype'] : 'text/plain');
	}
	function formStartForm(array $formStartAttributes) {
		$this->formStartAttributes = $formStartAttributes;
		
		self::formStartSetDefaults();
		
		$this->formStartOutput = '<form ';
		
		$this->formStartOutput .= parent::arraysOutput($this->formStartAttributes);
		
		$this->formStartOutput .= ' >';
		
		return $this->formStartOutput;
	}
}

?>