<?php

namespace models;

use lib\Core\Model as Model;

class ModelIndex extends Model {
	function __construct() {
		parent::__construct();
	}
	function getAllLanguages() {
		return $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->table_prefix . '_languages GROUP BY language');
	}
	function getTextPages($Section) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setPreparedValues(array(
				$Section
		))->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->table_prefix . '_text_pages WHERE section = ? ORDER BY id ASC');
	}
	function getTextPage($Id) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setPreparedValues(array(
				$Id
		))->setFetchMode('FETCH_OBJ')->executeQuery('SELECT name,text FROM ' . $this->table_prefix . '_text_pages WHERE id = ?')[0];
	}


}

?>