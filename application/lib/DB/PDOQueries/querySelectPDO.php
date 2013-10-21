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

namespace lib\DB\PDOQueries;

use lib\DB\Exceptions\customPDOException as customPDOException;
use \PDO as PDO;

class querySelectPDO {

	private $sQuery;
	private $mandatoryQueryKeywords = array(
			'FROM'
	);
	private $resultQuery;
	private $fetchType = 'ALL';
	private $fetchMode = 'FETCH_BOTH';
	private $nrRows;
	private $getNrRecords = FALSE;
	private $Connection;
	private $queryResult;
	private $queryResultFetched;
	private $queryToPrint;
	private $prepareOn = FALSE;
	private $preparedValues;
	private $Prepared;
	private $Operator = '';

	/**
	 * Sets the pdo connection object...
	 *
	 * @param object $DB
	 */
	public function __construct($DB = FALSE) {

		$this->Connection = $DB;
		//var_dump($this->Connection);
	}

	/**
	 * Set the fetch type
	 * Values accepted: 'ALL','OneRecord'
	 * Default: 'ALL'
	 * Used in method: executeQuery()
	 *
	 * @param var $fetchType
	 */
	public function setFetchType($fetchType) {

		$this->fetchType = $fetchType;
		return $this;
	}

	/**
	 * Set the fetch mode
	 * Values accepted:
	 * FETCH_BOTH,FETCH_NUM,FETCH_ASSOC,FETCH_OBJ,FETCH_LAZY.Default: FETCH_BOTH
	 * Not implemented yet: FETCH_BOUND,FETCH_CLASS,FETCH_INTO
	 * Used in method: executeQuery()
	 *
	 * @param var $fetchMode
	 */
	public function setFetchMode($fetchMode) {

		$this->fetchMode = $fetchMode;
		return $this;
	}

	/**
	 * Set if you want the query to return number of records.
	 * Values accepted: FALSE,TRUE
	 * Default: FALSE
	 * Used in method: executeQuery()
	 *
	 * @param var $Status
	 */
	public function getNrRecords($Status) {

		$this->getNrRecords = $Status;
	}

	/**
	 * Set if you want to use prepare
	 * Values accepted: FALSE,TRUE
	 * Default: FALSE
	 * Used in method: executeQuery()
	 *
	 * @param var $Status
	 */
	public function setPrepareOn($prepareOn) {

		$this->prepareOn = $prepareOn;
		return $this;
	}

	/**
	 * Set prepared values
	 * Used in method: executeQuery()
	 *
	 * @param var $preparedValues
	 */
	public function setPreparedValues($preparedValues) {

		$this->preparedValues = $preparedValues;
		return $this;
	}

	function setOperator($Operator) {
		$this->Operator = $Operator;
		return $this;
	}
	public function Select($qSelect = FALSE) {
		$this->qSelect = $qSelect;

		self::addSelect();
		return $this;
	}

	public function fromTbl($qFromTbl) {
		$this->qFromTbl = $qFromTbl;

		self::addFromTbl();
		return $this;
	}

	public function Join($qJoin) {
		$this->qJoin = $qJoin;

		self::addJoin();
		return $this;
	}

	public function On($qJoinOn) {
		$this->qJoinOn = $qJoinOn;

		self::addJoinOn();
		return $this;
	}

	public function Where($qWhere, $qWhereMode = FALSE) {
		$this->qWhere = $qWhere;
		if($qWhereMode != FALSE) {
			$this->qWhereMode = $qWhereMode;
		}
		self::addWhere();
		return $this;
	}

	public function orderBy($qOrderBy, $qOrderByMode = FALSE) {
		$this->qOrderBy = $qOrderBy;
		if($qOrderByMode != FALSE) {
			$this->qOrderByMode = $qOrderByMode;
		}
		self::addOrderBy();
		return $this;
	}

	public function Limit($lStart, $lEnd = FALSE) {
		$this->lStart = $lStart;
		if($lEnd != FALSE) {
			$this->lEnd = $lEnd;
		}
		self::addLimit();
		return $this;
	}

	public function groupBy($qGroupBy) {
		$this->qGroupBy = $qGroupBy;

		self::addGroupBy();
		return $this;
	}

	function buildQuery() {

		if(isset($this->addSelect)) {
			$this->sQuery = $this->addSelect;
		}

		if(isset($this->addFromTbl)) {
			$this->sQuery .= $this->addFromTbl;
		}
		if(isset($this->addJoin)) {
			$this->sQuery .= $this->addJoin;
		}
		if(isset($this->addJoinOn)) {
			$this->sQuery .= $this->addJoinOn;
		}
		if(isset($this->addWhere)) {
			$this->sQuery .= $this->addWhere;
		}

		if(isset($this->addGroupBy)) {
			$this->sQuery .= $this->addGroupBy;
		}

		if(isset($this->addOrderBy)) {
			$this->sQuery .= $this->addOrderBy;
		}

		if(isset($this->addLimit)) {
			$this->sQuery .= $this->addLimit;
		}
		return $this;
	}

	/**
	 * Executes the query
	 *
	 * @param var $sQuery
	 * @return query result fetched
	 */
	public function executeQuery($sQuery = FALSE) {
		/* if query is not set yet, it sets it */
		if($this->sQuery == '') {
			if($sQuery == FALSE) {
				self::buildQuery();

			} else {
				$this->sQuery = $sQuery;
			}
		}

		self::prepareQuery();
		$Registry = \lib\Core\Registry::getInstance();
		if($Registry->SystemCache !== FALSE && $Registry->SystemCache !== NULL)
		{
					if( $Registry->SystemCache->Exists($this->sQuery))
					{
						return $Registry->SystemCache->Fetch($this->sQuery . print_r($this->preparedValues,TRUE));

					}

		}
		/* if wanted to retrieve the number of records */
		if($this->getNrRecords == TRUE) {
			self::executeQueryNrRows();
		}

		/* if wanted to retrieve the query results */
		else {

			/* if PREPARED on */
			if($this->prepareOn == TRUE) {

				try {

					/* prepare the query.if unsuccesfull,throw error */

					$this->queryResult = $this->Connection->prepare($this->sQuery);
					if($this->queryResult === FALSE) {
						throw new customPDOException($this->Connection->errorInfo(),'Unable to prepare query<br /> query: ' . $this->sQuery);
					} else {
						try {

							/*
							 * run query.if unsuccesfull,throw error .returns
							 * true on success,need to see how returns the
							 * result for fetch
							 */

							if($this->Operator == ':') {
								// alternate,bind it
								foreach($this->preparedValues as $k => $v) {

									$this->queryResult->bindParam("$k", $v);
								}
								$this->queryResult->execute();
								// no rows
								if($this->queryResult == FALSE) {
									return '0';
								} else {
									return $this->queryResult;
								}
							} else {

								$this->queryResult->execute($this->preparedValues);

								// return $this->Prepared;

							}
						} catch ( customPDOException $e ) {
							$e->manageException();

						}
					}
				} catch ( customPDOException $e ) {
					$e->manageException();

				}

			} else {

				/* PDO query() function (returns the result set) */
				/* IMPORTANT if you want to add methods,make sure you don't override the query() method,as it is a PDO method */
				try {
					$this->queryResult = $this->Connection->query($this->sQuery);
					if(! is_object($this->queryResult)) {
						throw new customPDOException($this->Connection->errorInfo(),'Unable to prepare query<br /> query: ' . $this->uQuery);
					}
				} catch ( customPDOException $e ) {
					$e->manageException();

				}

				// if you do not fetch the results the call may fail.in this
			// case,before making another call,use PDOStatement:closeCursor
				/*
				 * $pdoStatement = new PDOStatement;
				 * $pdoStatement->closeCursor();
				 */

			}
			try {
				/* fetch the results based on fetch mode and fetch type */
				switch ($this->fetchType) {
					case 'ALL' :
						switch ($this->fetchMode) {

							case 'FETCH_BOTH' :
								$this->queryResultFetched = $this->queryResult->fetchAll(PDO::FETCH_BOTH);
								break;
							case 'FETCH_NUM' :
								$this->queryResultFetched = $this->queryResult->fetchAll(PDO::FETCH_NUM);
								break;
							case 'FETCH_ASSOC' :
								$this->queryResultFetched = $this->queryResult->fetchAll(PDO::FETCH_ASSOC);
								break;
							case 'FETCH_OBJ' :
								$this->queryResultFetched = $this->queryResult->fetchAll(PDO::FETCH_OBJ);
								break;
							case 'FETCH_LAZY' :
								$this->queryResultFetched = $this->queryResult->fetchAll(PDO::FETCH_LAZY);
								break;
							default :
								$this->queryResultFetched = $this->queryResult->fetchAll(PDO::FETCH_BOTH);
								break;

						}
						break;
					case 'OneRecord' :
						switch ($this->fetchMode) {

							case 'FETCH_BOTH' :
								$this->queryResultFetched = $this->queryResult->fetch(PDO::FETCH_BOTH);
								break;
							case 'FETCH_NUM' :
								$this->queryResultFetched = $this->queryResult->fetch(PDO::FETCH_NUM);
								break;
							case 'FETCH_ASSOC' :
								$this->queryResultFetched = $this->queryResult->fetch(PDO::FETCH_ASSOC);
								break;
							case 'FETCH_OBJ' :
								$this->queryResultFetched = $this->queryResult->fetch(PDO::FETCH_OBJ);
								break;
							case 'FETCH_LAZY' :
								$this->queryResultFetched = $this->queryResult->fetch(PDO::FETCH_LAZY);
								break;
							default :
								$this->queryResultFetched = $this->queryResult->fetch(PDO::FETCH_BOTH);
								break;

						}
						break;
					default :
						switch ($this->fetchMode) {

							case 'FETCH_BOTH' :
								$this->queryResultFetched = $this->queryResult->fetchAll(PDO::FETCH_BOTH);
								break;
							case 'FETCH_NUM' :
								$this->queryResultFetched = $this->queryResult->fetchAll(PDO::FETCH_NUM);
								break;
							case 'FETCH_ASSOC' :
								$this->queryResultFetched = $this->queryResult->fetchAll(PDO::FETCH_ASSOC);
								break;
							case 'FETCH_OBJ' :
								$this->queryResultFetched = $this->queryResult->fetchAll(PDO::FETCH_OBJ);
								break;
							case 'FETCH_LAZY' :
								$this->queryResultFetched = $this->queryResult->fetchAll(PDO::FETCH_LAZY);
								break;
							default :
								$this->queryResultFetched = $this->queryResult->fetchAll(PDO::FETCH_BOTH);
								break;

						}
						break;
				}

				/*
				 * $this->queryResultFetched is the fetched result.Type:
				 * array(can be multidimensional)
				 */
				// print_r($this->queryResultFetched);
				/*
				 * if($this->queryResultFetched === FALSE) { throw new
				 * customPDOException(); }
				 */
			} catch ( customPDOException $e ) {
				$e->manageException();

			}

			if($Registry->SystemCache !== FALSE  && $Registry->SystemCache !== NULL)
			{
					$Registry->SystemCache->Store($this->sQuery  . print_r($this->preparedValues,TRUE),$this->queryResultFetched);

			}

			return $this->queryResultFetched;

			/* result usage example */
			/*
			foreach($result as $key=>$val) {

			echo $key.' - '.$val.'<br />';
			}
			*/

		}

	}

	/**
	 * executes the query to retrieve the number of rows
	 *
	 * @param var $sQuery
	 * @return number of rows
	 */

	public function executeQueryNrRows($sQuery = FALSE) {

		/* if query is not set yet, it sets it */
		if(! isset($this->sQuery)) {
			$this->sQuery = $sQuery;
		}



			/* PDO query() function (returns the result set) */
			/* IMPORTANT if you want to add methods,make sure you don't override the query() method,as it is a PDO method */
			//p($this->sQuery);

			if($this->prepareOn == TRUE) {

				try {

					/* prepare the query.if unsuccesfull,throw error */


					$this->queryResult = $this->Connection->prepare($this->sQuery);

					if($this->Operator == ':') {
						// alternate,bind it
						foreach($this->preparedValues as $k => $v) {

							$this->queryResult->bindParam("$k", $v);
						}
						$this->queryResult->execute();
						// no rows
						if($this->queryResult == FALSE) {
							return '0';
						} else {
							return $this->queryResult;
						}
					} else {

						$this->queryResult->execute($this->preparedValues);

						// return $this->Prepared;

					}


					if($this->queryResult === FALSE) {
						throw new customPDOException($this->Connection->errorInfo(),'Unable to prepare query<br /> query: ' . $this->sQuery);
					} else {


					//	$this->queryResult = $this->Connection->query($this->sQuery);

						/* PDO rowCount() function(returns the number of rows) */
						/* IMPORTANT if you want to add methods,make sure you don't override the rowCount() method,as it is a PDO method */
						$this->nrRows = $this->queryResult->rowCount();

						return $this->nrRows;
					}


		} catch ( customPDOException $e ) {
			$e->manageException();

		}

	}
	else
	{
	try {

			/* PDO query() function (returns the result set) */
			/* IMPORTANT if you want to add methods,make sure you don't override the query() method,as it is a PDO method */
			$this->queryResult = $this->Connection->query($this->sQuery);

			/* PDO rowCount() function(returns the number of rows) */
			/* IMPORTANT if you want to add methods,make sure you don't override the rowCount() method,as it is a PDO method */
			$this->nrRows = $this->queryResult->rowCount();

			return $this->nrRows;

		}
		catch (customPDOException $e) {
			 $e->manageException();

		}
	}
	}

	private function addSelect() {

		$this->addSelect = ' SELECT ';
		if(! is_array($this->qSelect)) {
			$this->addSelect .= ' * ';
		} else {
			$this->addSelect .= '`' . implode('` , `', $this->qSelect) . '`';
		}
		return $this;
	}

	private function addFromTbl() {
		$this->addFromTbl = ' FROM ';
		$this->addFromTbl .= $this->qFromTbl;
	}

	private function addJoin() {

		if(count($this->qJoin) == 2) {
			list($this->qJoinTblName, $this->qJoinType) = $this->qJoin;
			$this->addJoin = ' ' . $this->qJoinType . ' JOIN ';
			$this->addJoin .= '`' . $this->qJoinTblName . '`';

		} else {
			list($this->qJoinTblName) = $this->qJoin;
			$this->addJoin = ' ' . ' LEFT ' . ' JOIN ';
			$this->addJoin .= '`' . $this->qJoinTblName . '`';
		}
		return $this;

	}

	private function addJoinOn() {

		$this->arKeys = array_keys($this->qJoinOn);

		end($this->arKeys);
		$this->lastKey = key($this->arKeys);
		$this->lastValue = $this->arKeys[$this->lastKey];

		$this->addJoinOn = ' ON ';

		for($i = 0; $i <= $this->lastKey; $i ++) {

			$this->jTblName = $this->qJoinOn[$i][0];
			$this->jFieldName = $this->qJoinOn[$i][1];
			$this->addJoinOn .= $this->qJoinOn[$i][0] . '.' . $this->qJoinOn[$i][1];
			$this->addJoinOn .= '=';
		}

		$this->addJoinOn = substr($this->addJoinOn, 0, - 1);
		return $this;
	}

	private function addWhere() {

		$this->addWhereFieldName = key($this->qWhere);
		$this->addWhereFieldValue = $this->qWhere[$this->addWhereFieldName];

		if(! isset($this->addWhere)) {
			$this->addWhere = ' WHERE ';
			$this->addWhere .= $this->addWhereFieldName . '=' . $this->addWhereFieldValue;
		} else {
			if(isset($this->qWhereMode)) {
				$this->addWhere .= " $this->qWhereMode ";
			} else {
				$this->addWhere .= " AND ";
			}

			$this->addWhere .= $this->addWhereFieldName . '=' . $this->addWhereFieldValue;
		}
		return $this;
	}

	private function addOrderBy() {

		if(! isset($this->addOrderBy)) {

			if(count($this->qOrderBy) == 2) {
				list($this->orderByField, $this->orderByMode) = $this->qOrderBy;
				$this->addOrderBy = ' ORDER BY ';
				$this->addOrderBy .= $this->orderByField . ' ' . $this->orderByMode;
			} else {
				list($this->orderByField) = $this->qOrderBy;
				$this->addOrderBy = ' ORDER BY ';
				$this->addOrderBy .= $this->orderByField . ' ' . 'ASC';
			}
		} else {
			if(count($this->qOrderBy) == 2) {
				list($this->orderByField, $this->orderByMode) = $this->qOrderBy;

				$this->addOrderBy .= ', ' . $this->orderByField . ' ' . $this->orderByMode;
			} else {
				list($this->orderByField) = $this->qOrderBy;

				$this->addOrderBy .= ', ' . $this->orderByField . ' ' . 'ASC';
			}

		}
		return $this;
	}

	private function addLimit() {

		$this->addLimit = ' LIMIT ';
		$this->addLimit .= $this->lStart;
		if(isset($this->lEnd)) {
			$this->addLimit .= ', ' . $this->lEnd;
		}
		return $this;
	}

	private function addGroupBy() {

		$this->addGroupBy = ' GROUP BY ';
		$this->addGroupBy .= $this->qGroupBy;
		return $this;

	}
	public function fetchRow() {
		switch ($this->fetchMode) {
			case 'MYSQL_BOTH' :
				$this->fetchedResults = mysql_fetch_array($this->queryResult, MYSQL_BOTH);
				break;
			case 'MYSQL_ASSOC' :
				$this->fetchedResults = mysql_fetch_array($this->queryResult, MYSQL_ASSOC);
				break;
			case 'MYSQL_NUM' :
				$this->fetchedResults = mysql_fetch_array($this->queryResult, MYSQL_NUM);
				break;
			default :
				$this->fetchedResults = mysql_fetch_array($this->queryResult, MYSQL_ASSOC);
				break;
		}
		return $this->fetchedResults;
	}
	/**
	 * Shorthand for executeQuery() method.
	 * Just sets the query and invoke executeQuery() method
	 *
	 * @param var $sQuery
	 * @return the result of executeQuery(), which is the result set fetched
	 */

	public function q($sQuery) {

		$this->sQuery = $sQuery;
		return self::executeQuery();
	}

	/**
	 * Shorthand for executeQueryNrRows() method.
	 * Just sets the query and invoke executeQueryNrRows() method
	 *
	 * @param var $sQuery
	 * @return the result of executeQueryNrRows(), which is the number of rows
	 */
	public function qNr($sQuery) {

		$this->sQuery = $sQuery;
		return self::executeQueryNrRows();
	}

	/**
	 * Invokes executeQuery() method, and in addition prints the query
	 * It invokes showQuery() method which prints the query
	 *
	 * @param var $sQuery
	 * @return the result of executeQuery(), which is the result set fetched
	 */

	public function pexecuteQuery($sQuery) {

		if($sQuery == FALSE) {
			self::buildQuery();
		} else {
			$this->sQuery = $sQuery;
		}
		self::showQuery();
		return self::executeQuery();
	}

	/**
	 * Shorthand for pexecuteQuery
	 * Invokes executeQuery() method, and in addition prints the query
	 * It invokes showQuery() method which prints the query
	 *
	 * @param var $sQuery
	 * @return the result of executeQuery(), which is the result set fetche
	 */
	public function pq($sQuery) {

		$this->sQuery = $sQuery;
		self::showQuery();
		return self::executeQuery();
	}

	/**
	 * Invokes executeQueryNrRows() method, and in addition prints the query
	 * It invokes showQuery() method which prints the query
	 *
	 * @param var $sQuery
	 * @return the result of executeQueryNrRows(), which is the number of rows
	 */
	public function pexecuteQueryNrRows($sQuery) {

		$this->sQuery = $sQuery;
		self::showQuery();
		return self::executeQueryNrRows();
	}

	/**
	 * Shorthand for pexecuteQueryNrRows
	 * Invokes executeQueryNrRows() method, and in addition prints the query
	 * It invokes showQuery() method which prints the query
	 *
	 * @param var $sQuery
	 * @return the result of executeQueryNrRows(), which is the number of rows
	 */
	public function pqNr($sQuery) {

		$this->sQuery = $sQuery;
		self::showQuery();
		return self::executeQueryNrRows();
	}

	/**
	 * Prints the query
	 *
	 * @return query printed
	 */

	private function showQuery() {

		$this->queryToPrint = '-------------------------------------------- YOUR QUERY-----------------------------------' . '<br>' . '<span style="color: red">' . $this->sQuery . '</span>' . '<br>' . '-------------------------------------------- YOUR QUERY-----------------------------------';
		return print $this->queryToPrint;

	}

	/**
	 * applies the desired methods to validate the query *
	 */
	private function prepareQuery() {
		self::checkValidQuery();
	}

	/**
	 * not finished yet
	 */
	private function checkValidQuery() {

		$trimmed = trim($this->sQuery);

		if(strtoupper(substr($trimmed, 0, 6)) != 'SELECT') {
			// print 'not ok';
		}
	}

}

?>