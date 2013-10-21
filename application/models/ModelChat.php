<?php

namespace models;

use lib\Core\Model;

class ModelChat extends Model {
	function __construct() {
		parent::__construct();
	}
	function getChatrooms() {
		return $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->table_prefix . '_chat_rooms ORDER BY room_name ASC');
	}
	function getGeneralMessages() {
		return $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->table_prefix . '_chat WHERE room_id="general" ORDER BY id DESC LIMIT 20');
	}
	function getRoomsMessages($roomId) {
		return $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->setPrepareOn(TRUE)->setPreparedValues($roomId)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_chat WHERE room_id= ?  ORDER BY id DESC LIMIT 20');
	}
	function getFriendsMessages($Fields) {
		return $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_chat WHERE user_from = ? AND user_to = ? OR user_from = ? AND user_to = ? ORDER BY id DESC LIMIT 20');
	}
	function sendGeneralMessage($Message) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->username,
				'',
				'general',
				$Message,
				time()
		))->executeQuery('INSERT INTO ' . $this->table_prefix . '_chat(user_from,user_to,room_id,message,timestamp)
								VALUES(?,?,?,?,?)');
	}
	function sendFriendMessage($Fields) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_chat(user_from,user_to,room_id,message,timestamp)
								VALUES(?,?,?,?,?)');
	}
	function sendRoomMessage($Fields) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_chat(user_from,user_to,room_id,message,timestamp)
				VALUES(?,?,?,?,?)');
	}
}

?>