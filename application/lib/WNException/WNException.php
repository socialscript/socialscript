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

namespace lib\WNException;
use \Exception as Exception;

class WNException extends Exception {

	// Redefine the exception so message isn't optional
	public function __construct($message, $code = 0, Exception $previous = null) {
		// some code

		// make sure everything is assigned properly
		parent::__construct($message, $code, $previous);
	}

	// custom string representation of object
	public function __toString() {
		return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	}

	public function manageException() {
		print $this->getMessage();
		print $this->getCode();
		print $this->getFile();
		print $this->getLine();
		print_r($this->getTrace());
		print $this->getPrevious();
		print $this->getTraceAsString();
		exit();
		// /print $message;
	}
}

?>