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

namespace lib\Core;

class Registry {
	private $data = array();
	static $Instance;
	static function getInstance() {
		if(! is_object(self::$Instance)) {
			self::$Instance = new Registry();
		}
		return self::$Instance;
	}
	public function __set($name, $value) {
		$this->data[$name] = $value;
		// print_r($this->data);
	}
	public function __get($name) {
		if(array_key_exists($name, $this->data)) {
			return $this->data[$name];
		}
	}
	public function __isset($name) {
		return isset($this->data[$name]);
	}
	public function __unset($name) {
		unset($this->data[$name]);
	}
}

?>