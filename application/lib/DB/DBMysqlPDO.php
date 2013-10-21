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

namespace lib\DB;
use lib\DB\Exceptions\customPDOException;

class DBMysqlPDO {

	private $DBConnectionAr;
	private $DBConnectionArDefaults = array(
			'main' => array(
					'DB_HOST' => '',
					'DB_USERNAME' => '',
					'DB_PASSWORD' => '',
					'DB_NAME' => ''
			),
			'select' => array(
					'DB_HOST' => '',
					'DB_USERNAME' => '',
					'DB_PASSWORD' => '',
					'DB_NAME' => ''
			),
			'insert' => array(
					'DB_HOST' => '',
					'DB_USERNAME' => '',
					'DB_PASSWORD' => '',
					'DB_NAME' => ''
			),
			'update' => array(
					'DB_HOST' => '',
					'DB_USERNAME' => '',
					'DB_PASSWORD' => '',
					'DB_NAME' => ''
			),
			'delete' => array(
					'DB_HOST' => '',
					'DB_USERNAME' => '',
					'DB_PASSWORD' => '',
					'DB_NAME' => ''
			)
	);
	private $DBConnectionString;
	private $DBQueryTypesDefault = array(
			'SELECT',
			'INSERT',
			'UPDATE',
			'DELETE'
	);
	private $DBQuery;
	private $DBQueryAr;
	private $DBQueryType;
	private $DBConnection = FALSE;
	private $DBSelected;
	private $Connection;
	private $changeConnection = FALSE;

	public function setDBConnectionAr($DBConnectionAr) {
		$this->DBConnectionAr = $DBConnectionAr;
		// pr($this->DBConnectionAr);
		return $this;
	}

	public function Connect() {
		self::prepareConnectionParametersFromArray();

		if($this->changeConnection === TRUE && is_object($this->DBConnection)) {

			self::Disconnect();
		}

		if(! is_object($this->DBConnection)) {
			try {

				$this->DBConnection = new \PDO('mysql:host=' . $this->DBConnectionCredentials['DB_HOST'] . ';dbname=' . $this->DBConnectionCredentials['DB_NAME'], $this->DBConnectionCredentials['DB_USERNAME'], $this->DBConnectionCredentials['DB_PASSWORD']);

			} catch ( \PDOException $e ) {
				/*
				 * TODO show template page with error,for some reason the
				 * customPDOException cannot be used
				 */
				p($e->getMessage());

			}
		}

	}

	public function loadQuery($queryType) {

		$this->DBQueryType = strtoupper(trim($queryType));
		self::Connect();

		if($this->DBConnection !== FALSE) {
			try {

				if(in_array($this->DBQueryType, $this->DBQueryTypesDefault)) {

					switch ($this->DBQueryType) {
						case 'SELECT' :
							$this->queryClass = new \lib\DB\PDOQueries\querySelectPDO($this->DBConnection);
							break;
						case 'INSERT' :
							$this->queryClass = new \lib\DB\PDOQueries\queryInsertPDO($this->DBConnection);
							break;
						case 'UPDATE' :
							$this->queryClass = new \lib\DB\PDOQueries\queryUpdatePDO($this->DBConnection);
							break;
						case 'DELETE' :
							$this->queryClass = new \lib\DB\PDOQueries\queryDeletePDO($this->DBConnection);
							break;
					}

					return $this->queryClass;

				} else {

					throw new customPDOException(customPDOException::getCustomMessage('The query has an invalid format', FALSE, 'The query must be of type: SELECT,INSERT,UPDATE,DELETE', 'Your query is:', $this->DBQuery));

				}
			} catch ( customPDOException $e ) {
				$e->customErrorMessage();
			}
		}

	}

	public function Disconnect() {

		return $this->DBConnection = NULL;
	}

	private function isValidDbConnectionAr() {

		try {
			if(is_array($this->DBConnectionAr)) {
				foreach($this->DBConnectionAr as $Key => $Value) {

					if(! in_array($Key, array_keys($this->DBConnectionArDefaults))) {
						throw new customPDOException(customPDOException::getCustomMessage('Connection array has an invalid format', FALSE, 'Accepted format is:'));

					}
				}
			}
		} catch ( customPDOException $e ) {
			$e->customErrorMessage();
		}
	}

	private function prepareConnectionParametersFromArray() {

		$this->DBConnectionCredentials = $this->DBConnectionAr['MAIN'];

		if(isset($this->DBConnectionAr[$this->DBQueryType]['DB_HOST']) && isset($this->DBConnectionAr[$this->DBQueryType]['DB_USERNAME']) && isset($this->DBConnectionAr[$this->DBQueryType]['DB_NAME'])) {
			if(trim($this->DBConnectionAr[$this->DBQueryType]['DB_HOST']) != '' && trim($this->DBConnectionAr[$this->DBQueryType]['DB_USERNAME']) != '' && trim($this->DBConnectionAr[$this->DBQueryType]['DB_NAME']) != '') {
				$this->DBConnectionCredentials = $this->DBConnectionAr[$this->DBQueryType];
				$this->changeConnection = TRUE;
			}

		}

	}

	function __destruct() {
		$this->DBConnection = NULL;
	}

}

?>