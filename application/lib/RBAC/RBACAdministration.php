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

use lib\RBAC\Interfaces\InterfaceRBACAdministration;
use lib\Core\Registry;

class RBACAdministration implements InterfaceRBACAdministration {
	function __construct() {
		$this->Registry = Registry::getInstance();
		$this->DB = $this->Registry->DB;
		$this->table_prefix = $this->Registry->table_prefix;
	}
	public function AddRole() {
	}
	public function RevokePermission() {
	}
	public function AddUser($MainFields, $ExtraFields) {
		$this->userId = $this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues(array_values($MainFields))->executeQuery('INSERT INTO ' . $this->table_prefix . '_users(' . implode(array_keys($MainFields), ',') . ')
				VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, array_values($MainFields)), ',') . ')');

		foreach($ExtraFields as $k => $v) {
			$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues(array_values(array(
					'user_id' => $MainFields['user_key'],
					'field' => $k,
					'value' => $v
			)))->executeQuery('INSERT INTO ' . $this->table_prefix . '_users_extra(user_id,field,value)
					VALUES(' . implode(array_map(function ($value) {
				return '?';
			}, array(
					'user_id' => $this->userId,
					'field' => $k,
					'value' => $v
			)), ',') . ')');
		}

		return $this;
	}
	public function editUser($userId, $MainFields,$Birthday, $ExtraFields) {
		if(count($MainFields) > 0) {

			$this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues(array_merge(array_values($MainFields), array(
					$userId
			)))->executeQuery('UPDATE ' . $this->table_prefix . '_users SET
				password=?,salt = ? WHERE user_key = ?');
		}
		$this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues(array($Birthday,$userId
		))->executeQuery('UPDATE ' . $this->table_prefix . '_users SET
				birthday=?  WHERE user_key = ?');

		foreach($ExtraFields as $k => $v) {

			$this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues(array(
					$v,
					$userId,
					$k
			))->executeQuery('UPDATE ' . $this->table_prefix . '_users_extra SET `value`=?
					WHERE `user_id`=? AND `field`=? ');
		}

		return $this;
	}
	public function GrantPermission() {
	}
	public function DeassignUser($userKey) {
		$this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues(array(
				$userKey
		))->executeQuery('DELETE FROM ' . $this->table_prefix . '_users_roles
				WHERE user_key= ? ');
	}
	public function DeleteUser($userKey) {
		$this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues(array(
				$userKey
		))->executeQuery('DELETE FROM ' . $this->table_prefix . '_users
				WHERE user_key= ? ');
	}
	public function AssignUser($userKey) {
		$this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues(array(
				$userKey
		))->executeQuery('DELETE FROM ' . $this->table_prefix . '_users
				WHERE user_key= ? ');
	}
	public function DeleteRole() {
	}
	function __destruct() {
	}
}

?>