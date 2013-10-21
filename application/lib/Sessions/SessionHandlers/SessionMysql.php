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

namespace lib\sessions\SessionHandlers;
use lib\Core\Registry;
use lib\DB\DBMysqlPDO;
class SessionMysql implements \SessionHandlerInterface {

	function __construct() {
		$this->oldId = session_id();
		session_regenerate_id();
	}
	function open($savePath, $sessName) {

		// get session-lifetime;
		$this->lifeTime = get_cfg_var("session.gc_maxlifetime");

		$Registry = Registry::getInstance();
		$this->DB = $Registry->DB;
		$this->table_prefix = $Registry->table_prefix;

	}
	function close() {
		$this->gc(ini_get('session.gc_maxlifetime'));
		// close database-connection
		$this->DB = NULL;
	}
	function read($sessID) {
		// fetch session-data
		$result = $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->setFetchType('OneRecord')->setPrepareOn(TRUE)->setPreparedValues(array(
				$sessID
		))->executeQuery('SELECT session_data
				 		FROM ' . $this->table_prefix . '_sessions WHERE session_id = ?
				AND session_expire > ' . time());
		if(is_object($result)) {
			return unserialize($result->session_data);
		}
	}
	function write($sessID, $sessData) {
		// new session-expire-time
		$newExp = time() + $this->lifeTime;
		// is a session with this id in the database?
		$time = time();

		$nr_rows = $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->setFetchType('OneRecord')->setPrepareOn(TRUE)->setPreparedValues(array(
				$sessID
		))->executeQueryNrRows('SELECT *
						FROM ' . $this->table_prefix . '_sessions WHERE session_id = ?
						AND session_expire > ' . time());
		// ...update session-data
		if($nr_rows > 0) {
			$this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues(array(
					$newExp,
					serialize($sessData),
					$sessID
			))->executeQuery('UPDATE ' . $this->table_prefix . '_sessions SET session_expire = ?,session_data = ? WHERE session_id=?');
			return TRUE;
		} 		// if no session-data was found,
		else {
			// create a new row
			$Query = $this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues(array(
					$sessID,
					$newExp,
					serialize($sessData)
			))->executeQuery('INSERT INTO ' . $this->table_prefix . '_sessions(session_id,session_expire,session_data)	VALUES(?,?,?)');
			return TRUE;
		}
		// an unknown error occured
		return false;
	}
	function destroy($sessID) {

		// delete session-data
		$Query = $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues(array(
				$sessID
		))->executeQuery('DELETE FROM ' . $this->table_prefix . '_sessions  WHERE session_id=?');

		return true;

	}
	function gc($sessMaxLifeTime) {

		// delete old ' . $this->table_prefix . '_sessions
		$this->DB->loadQuery('DELETE')->executeQuery('DELETE FROM ' . $this->table_prefix . '_sessions  WHERE session_expire < ' . time());

		// return affected rows
		return TRUE;
	}

}

?>