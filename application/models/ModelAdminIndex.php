<?php

namespace models;

use lib\Core\Model;

class ModelAdminIndex extends Model {
	function __construct() {
		parent::__construct();
	}
	function getTotalNrUsers() {
		return $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQueryNrRows('SELECT id FROM ' . $this->table_prefix . '_users');
	}
	function getTotalNrUsersFemales() {
		return $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQueryNrRows('SELECT id FROM ' . $this->table_prefix . '_users WHERE gender="female"');
	}
	function getTotalNrUsersMales() {
		return $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQueryNrRows('SELECT id FROM ' . $this->table_prefix . '_users WHERE gender="male"');
	}
	function getTotalNrVideos() {
		return $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQueryNrRows('SELECT id FROM ' . $this->table_prefix . '_videos');
	}
	function getTotalNrMusic() {
		return $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQueryNrRows('SELECT id FROM ' . $this->table_prefix . '_music_files');
	}
	function getTotalNrPictures() {
		return $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQueryNrRows('SELECT id FROM ' . $this->table_prefix . '_pictures');
	}
	function getTotalNrBlogs() {
		return $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQueryNrRows('SELECT id FROM ' . $this->table_prefix . '_blogs');
	}
	function getTotalNrEvents() {
		return $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQueryNrRows('SELECT id FROM ' . $this->table_prefix . '_blogs');
	}
	function getTotalNrGroups() {
		return $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQueryNrRows('SELECT id FROM ' . $this->table_prefix . '_groups');
	}
	function Login($Username, $Password) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues(array(
				$Username,
				$Password
		))->executeQueryNrRows('SELECT id FROM ' . $this->table_prefix . '_users
				WHERE username= ? AND password = ? AND role="admin"');
	}
	function getUserByUsername($Username) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues(array(
				$Username
		))->executeQuery('SELECT * FROM ' . $this->table_prefix . '_users
				WHERE username= ? LIMIT 1');
	}
	function getTextPages() {
		return $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->table_prefix . '_text_pages ORDER BY id ASC');
	}
	function editTextPages($Fields, $Id) {
		return $this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues(array_pad(array_values($Fields), count($Fields) + 1, $Id))->executeQuery('UPDATE ' . $this->table_prefix . '_text_pages SET ' . implode(array_keys($Fields), '=?,') . ' =? WHERE id = ? ');
	}
	function addTextPages($Fields) {
		return $this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues(array_values($Fields))->executeQuery('INSERT INTO ' . $this->table_prefix . '_text_pages( `section`, `name`, `url`, `text`) VALUES(?,?,?,?) ');
	}
	function deleteTextPages($Fields) {
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues(array_values($Fields))->executeQuery('DELETE FROM ' . $this->table_prefix . '_text_pages WHERE id = ? ');
	}
	function getBanners() {
		return $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->table_prefix . '_banners ORDER BY id ASC');
	}
	function editBanners($Fields, $Id) {
		return $this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues(array_pad(array_values($Fields), count($Fields) + 1, $Id))->executeQuery('UPDATE ' . $this->table_prefix . '_banners SET ' . implode(array_keys($Fields), '=?,') . ' =? WHERE id = ? ');
	}
	function getAdmins() {
		$result =  $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->table_prefix . '_users WHERE role = "admin" ORDER BY id ASC');
		foreach($result as $k => &$v)
		{
			$v->password = '******';
		}
		return $result;
	}
	function editAdmin($Fields, $Id) {
		return $this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues(array_pad(array_values($Fields), count($Fields) + 1, $Id))->executeQuery('UPDATE ' . $this->table_prefix . '_users SET ' . implode(array_keys($Fields), '=?,') . ' =? WHERE id = ? ');
	}

	function deleteAdmin($Fields) {
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues(array_values($Fields))->executeQuery('DELETE FROM ' . $this->table_prefix . '_users WHERE id = ? ');
	}
}

?>