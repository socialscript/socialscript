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

namespace lib\Core;

use lib\DB\DBMysqlPDO as DBMysqlPDO;

class Model {
	function __construct() {
		$Registry = Registry::getInstance();
		/*
		 * (new \SplAutoloader('lib\DB', array( 'lib/DB' )) )->register();
		 * $this->DB = new DBMysqlPDO();
		 * $this->DB->setDBConnectionAr($Registry->dbConnectionAr);
		 */
		$this->DB = $Registry->DB;
		$this->table_prefix = $Registry->table_prefix;
		unset($Registry);
	}
}
?>