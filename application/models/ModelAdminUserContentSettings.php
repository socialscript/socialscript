<?php

namespace models;

use lib\Core\Model;

class ModelAdminUserContentSettings extends Model {
	function __construct() {
		parent::__construct();
	}
	function getUserPicturesSettings() {
		return $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->table_prefix . '_user_pictures_settings ORDER BY name ASC');
	}
	function updatePicturesSettings($Fields, $Id) {
		return $this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues(array_pad(array_values($Fields), count($Fields) + 1, $Id))->executeQuery('UPDATE ' . $this->table_prefix . '_user_pictures_settings SET ' . implode(array_keys($Fields), '=?,') . ' =? WHERE id = ? ');
	}
	function getUserVideosSettings() {
		return $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->table_prefix . '_user_videos_settings ORDER BY name ASC');
	}
	function updateVideosSettings($Fields, $Id) {
		return $this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues(array_pad(array_values($Fields), count($Fields) + 1, $Id))->executeQuery('UPDATE ' . $this->table_prefix . '_user_videos_settings SET ' . implode(array_keys($Fields), '=?,') . ' =? WHERE id = ? ');
	}
}

?>