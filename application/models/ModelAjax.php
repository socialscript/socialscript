<?php
namespace models;
use lib\Core\Model;
class ModelAjax extends Model {

	function __construct() {
		parent::__construct();

	}

	function usernameExists($Username) {
		return $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQueryNrRows('SELECT username FROM ' . $this->table_prefix . '_users WHERE username="' . $Username . '" LIMIT 1');
	}

	function emailExists($Email) {
		return $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQueryNrRows('SELECT username FROM ' . $this->table_prefix . '_users WHERE email="' . $Email . '" LIMIT 1');
	}
}

?>