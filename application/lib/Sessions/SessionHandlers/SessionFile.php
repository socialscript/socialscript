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

namespace lib\Sessions\SessionHandlers;
use lib\Core\Registry;
use lib\WNException\WNException;
class SessionFile implements \SessionHandlerInterface {

	private $savePath;

	public function open($savePath, $sessionName) {
		try {
			$Registry = Registry::getInstance();
			$this->savePath = $Registry->sessionsSavePath;
			if(! is_dir($this->savePath)) {
				throw new WNException('Directory for saving sessions does not exist');
			}
		} catch ( WNException $e ) {
			$e->manageException();

		}

		return true;
	}

	public function close() {
		return true;
	}

	public function read($id) {
		return (string) @file_get_contents("$this->savePath/sess_$id");
	}

	public function write($id, $data) {
		return file_put_contents("$this->savePath/sess_$id", $data) === false ? false : true;
	}

	public function destroy($id) {
		$file = "$this->savePath/sess_$id";
		if(file_exists($file)) {
			unlink($file);
		}

		return true;
	}

	public function gc($maxlifetime) {
		foreach(glob("$this->savePath/sess_*") as $file) {
			if(filemtime($file) + $maxlifetime < time() && file_exists($file)) {
				unlink($file);
			}
		}

		return true;
	}

}

?>