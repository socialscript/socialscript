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
use lib\DB\DBMysqlPDO;
class SessionMemcached implements \SessionHandlerInterface {

	function open($savePath, $sessionName) {

		$Registry = Registry::getInstance();
		(new \SplAutoloader('lib\DB', array(
				'lib/DB'
		)) )->register();
		$this->DB = new DBMysqlPDO();

		$this->DB->setDBConnectionAr($Registry->dbConnectionAr);

		$this->memcache = new \Memcache();
		$this->lifeTime = intval(ini_get("session.gc_maxlifetime"));
		$this->initSessionData = null;
		$this->memcache->connect("127.0.0.1", 11211);
		$session_id = session_id();
		if($session_id !== "") {
			$this->initSessionData = $this->read($session_id);
		}

		return true;

	}

	function close() {

		$this->lifeTime = null;
		$this->memcache = null;
		$this->initSessionData = null;
		return true;

	}

	function read($session_id) {

		$data = $this->memcache->get($session_id);
		if($data === false) {

			$session_idEscaped = mysql_real_escape_string($session_id);
			$data = $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->setFetchType('OneRecord')->setPrepareOn(TRUE)->setPreparedValues(array(
					$session_id
			))->executeQuery('SELECT session_data
				 		FROM sessions WHERE session_id = ?
				AND session_expires > ' . time());

			$this->memcache->set($session_id, $data, false, $this->lifeTime);
		}

		return $data;

	}

	function write($session_id, $data) {

		$result = $this->memcache->set($session_id, $data, false, $this->lifeTime);
		if($this->initSessionData !== $data) {

			$session_expire = ($this->lifeTime + time());

			$nr_rows = $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->setFetchType('OneRecord')->setPrepareOn(TRUE)->setPreparedValues(array(
					$sessID
			))->executeQueryNrRows('SELECT session_data
						FROM sessions WHERE session_id = ?
						AND session_expires > ' . time());

			if($nr_rows > 0) {
				// ...update session-data
				$this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues(array(
						$session_expire,
						$sessData,
						$session_id
				))->executeQuery('UPDATE sessions SET session_expire = ?,session_data = ? WHERE session_id=?');
				return TRUE;
			} 			// if no session-data was found,
			else {
				// create a new row
				$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues(array(
						$session_id,
						$session_expire,
						$sessionData
				))->executeQuery('INSERT INTO sessions(session_id,session_expire,session_data)	VALUES(?,?,?)');
				return TRUE;
			}

		}

		return $result;

	}

	function destroy($session_id) {

		// Called when a user logs out...

		$this->memcache->delete($session_id);

		$this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues(array(
				$session_id
		))->executeQuery('DELETE FROM sessions  WHERE session_id=?');

		return true;

	}

	function gc($maxlifetime) {

		$this->Result = $this->DB->loadQuery('SELECT')->executeQuery('SELECT *  FROM sessions  WHERE session_expire < ' . time());

		foreach($this->Result as $k => $v) {
			$this->destroy($v['session_id']);
		}

	}

}

?>