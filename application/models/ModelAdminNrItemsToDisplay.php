<?php

namespace models;

use lib\Core\Model;

class ModelAdminNrItemsToDisplay extends Model {
	function __construct() {
		parent::__construct();
	}
	function getNrItemsToDisplay() {
		return $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->table_prefix . '_nr_items_to_display ORDER BY name ASC');
	}
	function Update($Fields, $Id) {
		return $this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues(array_pad(array_values($Fields), count($Fields) + 1, $Id))->executeQuery('UPDATE ' . $this->table_prefix . '_nr_items_to_display SET ' . implode(array_keys($Fields), '=?,') . ' =? WHERE id = ? ');
	}
}

?>