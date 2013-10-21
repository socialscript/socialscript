<?php

namespace models;

use lib\Core\Model;

class ModelAdminChatrooms extends Model {
	function __construct() {
		parent::__construct();
	}
	function getChatrooms() {
		return $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->table_prefix . '_chat_rooms ORDER BY room_name ASC');
	}
	function Update($Fields, $Id) {
		return $this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues(array_pad(array_values($Fields), count($Fields) + 1, $Id))->executeQuery('UPDATE ' . $this->table_prefix . '_chat_rooms SET ' . implode(array_keys($Fields), '=?,') . ' =? WHERE id = ? ');
	}
	function Add($Fields) {
		return $this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues(array_values($Fields))->executeQuery('INSERT INTO ' . $this->table_prefix . '_chat_rooms(room_name) VALUES(?) ');
	}
	function Delete($Fields) {
		return $this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues(array_values($Fields))->executeQuery('DELETE FROM ' . $this->table_prefix . '_chat_rooms WHERE id = ? ');
	}
}

?>