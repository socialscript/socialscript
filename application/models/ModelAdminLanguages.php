<?php

namespace models;

use lib\Core\Model;

class ModelAdminLanguages extends Model {
	function __construct() {
		parent::__construct();
	}
	function getAllLanguages() {
		return $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->table_prefix . '_languages GROUP BY language');
	}
	function getTexts($Language) {
		return $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->table_prefix . '_languages WHERE language="' . $Language . '"');
	}
	function Update($Fields, $Id) {
		return $this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues(array_pad(array_values($Fields), count($Fields) + 1, $Id))->executeQuery('UPDATE ' . $this->table_prefix . '_languages SET ' . implode(array_keys($Fields), '=?,') . ' =? WHERE id = ? ');
	}
	function Add($Language) {
		$languages_defaults = $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->table_prefix . '_languages_defaults');
		
		foreach($languages_defaults as $k => $v) {
			$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues(array(
					$v->name,
					$v->value,
					$Language
			))->executeQuery('INSERT INTO ' . $this->table_prefix . '_languages(name,value,language)
					VALUES(?,?,?)');
		}
		
		return TRUE;
	}
}

?>