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

namespace lib\RBAC;
use lib\RBAC\Interfaces\InterfaceRBACSystem;
use lib\Core\Registry;
use helpers\Utils;
class RBACSystem implements InterfaceRBACSystem {

	function __construct(){
		$Registry = Registry::getInstance();
		$this->DB = $Registry->DB;
		$this->table_prefix = $Registry->table_prefix;
		unset($Registry);
		$this->encryptionAlgorithm = Utils::getEncryptionAlgorithm();
	}
	public function CreateSession($User) {
		$_SESSION['user_' . $_SERVER['SERVER_NAME']] = $User;
		$_SESSION['key_' . $_SERVER['SERVER_NAME']] = hash($this->encryptionAlgorithm,$_SERVER['SERVER_SOFTWARE'] . $_SERVER['HTTP_USER_AGENT']);
		$_SESSION['type_' . $_SERVER['SERVER_NAME']] = 'user';
		$_SESSION['logged_in_' . $_SERVER['SERVER_NAME']] = TRUE;
	}
	public function DeleteSession() {
		session_unset();
		session_destroy();
	}
	public function AddActiveRole() {

	}
	public function DropActiveRole() {

	}
	public function CheckAccess() {

		if(isset($_SESSION['logged_in_' . $_SERVER['SERVER_NAME']])) {
			if(isset($_SESSION['key_' . $_SERVER['SERVER_NAME']])) {
				if($_SESSION['key_' . $_SERVER['SERVER_NAME']] === hash($this->encryptionAlgorithm,$_SERVER['SERVER_SOFTWARE'] . $_SERVER['HTTP_USER_AGENT'])) {
					$_SESSION['user_' . $_SERVER['SERVER_NAME']] = $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues(array(
							$_SESSION['user_' . $_SERVER['SERVER_NAME']]->username
					))->executeQuery('SELECT * FROM ' . $this->table_prefix . '_users
 				WHERE username= ? LIMIT 1')[0];
					return TRUE;
				} else {
					return FALSE;
				}
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}

	}

}

?>