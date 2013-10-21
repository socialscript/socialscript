<?php

namespace models;

use lib\Core\Model;

class ModelAdminSettings extends Model {
	function __construct() {
		parent::__construct();
	}
	function getSettings() {
		return $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->table_prefix . '_settings ORDER BY name ASC');
	}
	function Update($Fields, $Id) {
		return $this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues(array_pad(array_values($Fields), count($Fields) + 1, $Id))->executeQuery('UPDATE ' . $this->table_prefix . '_settings SET ' . implode(array_keys($Fields), '=?,') . ' =? WHERE id = ? ');
	}
	function getAvailableCountries() {
		return $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT code,country,available FROM ' . $this->table_prefix . '_ip2nationcountries ORDER BY country ASC');
	}
	function updateAvailability($Fields, $Id) {
		return $this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues(array_pad(array_values($Fields), count($Fields) + 1, $Id))->pexecuteQuery('UPDATE ' . $this->table_prefix . '_ip2nationcountries SET ' . implode(array_keys($Fields), '=?,') . ' =? WHERE code = ? ');
	}
	function getAnalyticsCode() {
		return $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->table_prefix . '_analytics_code WHERE id="1"');
	}
	function editAnalytics($Fields, $Id) {
		return $this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues(array_pad(array_values($Fields), count($Fields) + 1, $Id))->executeQuery('UPDATE ' . $this->table_prefix . '_analytics_code SET ' . implode(array_keys($Fields), '=?,') . ' =? WHERE id = ? ');
	}
}

?>