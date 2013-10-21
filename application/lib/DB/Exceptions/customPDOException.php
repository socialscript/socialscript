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

namespace lib\DB\Exceptions;

class customPDOException extends \PDOException {
	
	public function __construct($errorInfo, $optionalMessage = FALSE, $errorSolutionText = FALSE) {
		
		if($optionalMessage != FALSE) {
			$this->getCustomMessage[] = '<span style="color: red">' . $optionalMessage . '</span>';
		}
		if($errorSolutionText != FALSE) {
			$this->getCustomMessage[] = '<span style="color: red">' . $errorSolutionText . '</span>';
		}
		
		$this->getCustomMessage[] = '<span style="color: red">SQLSTATE error code: ' . $errorInfo[0] . '</span>';
		
		if(isset($errorInfo[1])) {
			$this->getCustomMessage[] = '<span style="color: red">Driver-specific error code: ' . $errorInfo[1] . '</span>';
		
		}
		if(isset($errorInfo[2])) {
			$this->getCustomMessage[] = '<span style="color: red">Error: ' . $errorInfo[2] . '</span>';
		}
	
	}
	
	function manageException() {
		
		$this->errorMessage = '-------------------------------------------------------PDO---------------------------------------------------------<br>' . implode('<br />', $this->getCustomMessage) . '<br />' . 'Message: ' . $this->getMessage() . '<br />' . 'Code: ' . $this->getCode() . '<br />' . 'File: ' . $this->getFile() . '<br />' . 'Line: ' . $this->getLine() . '<br />' . 
		// 'Trace: <pre>' . print_r($this->getTrace(),TRUE) . '</pre><br />' .
		'Previous: ' . $this->getPrevious() . '<br />' . 'Trace: ' . $this->getTraceAsString() . '<br />';
		
		'<br>-------------------------------------------------------PDO---------------------------------------------------------<br>';
		p($this->errorMessage);
		return $this->errorMessage;
	}

}