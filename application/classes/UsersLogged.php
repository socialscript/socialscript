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

namespace classes;

use lib\Core\Registry;

class UsersLogged {
	function __construct() {
		$this->Registry = Registry::getInstance();
		$this->DB = $this->Registry->DB;

	}

	function updateLoginTime() {
		$this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		))->executeQuery('UPDATE ' . $this->Registry->table_prefix . '_users
				SET last_login="'.time().'" WHERE user_key= ? ');
	}
	function updateLoggedInUsers() {
		$this->DB->loadQuery('UPDATE')->executeQuery('UPDATE ' . $this->Registry->table_prefix . '_users
				SET online="0" WHERE (last_login + 600) < "'.time().'" ');
	}

}

?>