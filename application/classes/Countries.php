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

namespace classes;

use \lib\Core\Registry;

class Countries {
	function __construct() {
		$this->Registry = Registry::getInstance();
		$this->table_prefix = $this->Registry->table_prefix;
		$this->DB = $this->Registry->DB;
	}
	function getAllCountries() {
		return $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->table_prefix . '_ip2nationcountries
				 					ORDER BY country ASC');
	}
	function getCountry() {
		$country = $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT
	            c.iso_code_2
	        FROM
	            ' . $this->table_prefix . '_ip2nationcountries c,
	            ' . $this->table_prefix . '_ip2nation i
	        WHERE
	            i.ip < INET_ATON("' . $_SERVER['REMOTE_ADDR'] . '")
	            AND
	            c.code = i.country
	        ORDER BY
	            i.ip DESC
	        LIMIT 0,1');
		
		if(is_object($country[0])) {
			return $country[0]->iso_code_2;
		} else {
			return FALSE;
		}
	}
	function getCountryNameByCode($Code) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues(array(
				$Code
		))->executeQuery('SELECT * FROM ' . $this->table_prefix . '_ip2nationcountries
				 					WHERE iso_code_2 = ? ORDER BY country ASC LIMIT 1')[0];
	}
	function getCountryByName($Code) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues(array(
				$Code
		))->executeQuery('SELECT * FROM ' . $this->table_prefix . '_ip2nationcountries
				 					WHERE iso_country = ? ORDER BY country ASC LIMIT 1')[0];
	}
}

?>