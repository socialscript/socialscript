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
namespace helpers;

use lib\Core\Registry;

class CountryByIp {
	private $countryFormat = 'iso_code_2';
	function __construct() {
		$Registry = Registry::getInstance();
		$this->DB = $Registry->DB;
		$this->table_prefix = $Registry->table_prefix;
	}
	function setCountryFormat($countryFormat) {
		$this->countryFormat = $countryFormat;
	}
	function getUserCountry() {
		$this->userCountry = $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT c.' . $this->countryFormat . ' FROM ' . $this->table_prefix . '_ip2nationcountries c, ' . $this->table_prefix . '_ip2nation i WHERE
		i.ip < INET_ATON("' . $_SERVER['REMOTE_ADDR'] . '")
		AND
		c.code = i.country
		ORDER BY
		i.ip DESC
		LIMIT 0,1')[0]->iso_code_2;
		return $this;
	}
	function checkCountryAvailability() {
		return $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT available FROM ' . $this->table_prefix . '_ip2nationcountries WHERE iso_code_2="' . $this->userCountry . '" LIMIT 1')[0]->available;
	}
}

?>