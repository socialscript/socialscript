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
class queryDeletePDO {
	
	private $dQuery;
	private $mandatoryQueryKeywords = array(
			'DELETE'
	);
	private $nrRows;
	private $Connection;
	private $queryResult;
	private $queryToPrint;
	private $transactionOn = FALSE;
	private $prepareOn = FALSE;
	private $preparedValues;
	private $Prepared;
	
	/**
	 * Sets the pdo connection object
	 *
	 * @param object $DB        	
	 */
	public function __construct($DB = FALSE) {
		
		$this->Connection = $DB;
	}
	
	/**
	 * Set if you want to use transactions
	 * Values accepted: FALSE,TRUE
	 * Default: TRUE
	 * Used in method: executeQuery()
	 *
	 * @param var $Status        	
	 */
	public function setTransactionOn($transactionOn) {
		
		$this->transactionOn = $transactionOn;
		return $this;
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
	
	/**
	 * Executes the query
	 * If the data is not in db,the query is not run
	 *
	 * @param var $dQuery        	
	 * @return number of affected rows
	 */
	public function executeQuery($dQuery = FALSE) {
		
		/* if query is not set yet, it sets it */
		if(! isset($this->dQuery)) {
			
			$this->dQuery = $dQuery;
		}
		
		try {
			
			/* if both 'TRANSACTION' AND 'PREPARE' are true throw error */
			if($this->prepareOn == TRUE && $this->transactionOn == TRUE) {
				
				throw new customPDOException('You can"t set "TRANSACTION" AND "PREPARE" BOTH TO TRUE"');
			}
			
			/* if PREPARED on */
			if($this->prepareOn == TRUE) {
				
				try {
					/* prepare the query.if unsuccesfull,throw error */
					$this->Prepared = $this->Connection->prepare($this->dQuery);
					if($this->Prepared === FALSE) {
						throw new customPDOException($this->Connection->errorInfo(), 'Unable to prepare query<br /> query: ' . $this->dQuery);
					} else {
						try {
							
							/* run query.if unsuccesfull,throw error */
							$this->queryResult = $this->Prepared->execute($this->preparedValues);
							
							if($this->queryResult == FALSE) {
								throw new customPDOException($this->Prepared->errorInfo(), 'Unable to execute prepared query<br /> query: ' . $this->dQuery);
							}
						} catch ( customPDOException $e ) {
							$e->manageException();
						
						}
					}
				} catch ( customPDOException $e ) {
					$e->manageException();
				
				}
			
			}			

			/*
			 * if wanted to use transactions(usefull if query fails and rollback
			 * is needed)
			 */
			elseif($this->transactionOn == TRUE) {
				
				try {
					
					/* Begin a transaction, turning off autocommit */
					$this->Connection->beginTransaction();
					
					/* Run query */
					
					$this->queryResult = $this->Connection->exec($this->dQuery);
					
					/* Recognize mistake and roll back changes */
					$this->Connection->rollBack();
					
					/*
					 * $this->queryResult is the query result.it returns the
					 * number of affected rows is succesfull
					 */
					if($this->queryResult === FALSE) {
						throw new customPDOException($this->Connection->errorInfo(), 'Unable to execute prepared query<br /> query: ' . $this->dQuery);
					}
				} catch ( customPDOException $e ) {
					$e->manageException();
				}
			
			} else {
				
				try {
					/* run query in normal mode */

					/* $this->queryResult is the number of affected rows */
					$this->queryResult = $this->Connection->exec($this->dQuery);
					
					if($this->queryResult === FALSE) {
						throw new customPDOException($this->Connection->errorInfo(), 'Unable to execute prepared query<br /> query: ' . $this->dQuery);
					}
				
				} catch ( customPDOException $e ) {
					$e->manageException();
				}
			
			}
		} catch ( customPDOException $e ) {
			$e->customErrorMessage();
		}
		
		return $this->queryResult;
	
	}
	
	/**
	 * Shorthand for executeQuery() method.
	 * Just sets the query and invoke executeQuery() method
	 *
	 * @param var $dQuery        	
	 * @return the result of executeQuery(), which is the result set fetched
	 */
	
	public function q($dQuery) {
		
		$this->dQuery = $dQuery;
		return self::executeQuery();
	}
	
	/**
	 * Invokes executeQuery() method, and in addition prints the query
	 * It invokes showQuery() method which prints the query
	 *
	 * @param var $dQuery        	
	 * @return the result of executeQuery(), which is the result set fetched
	 */
	
	public function pexecuteQuery($dQuery) {
		
		$this->dQuery = $dQuery;
		self::showQuery();
		return self::executeQuery();
	}
	
	/**
	 * Shorthand for pexecuteQuery
	 * Invokes executeQuery() method, and in addition prints the query
	 * It invokes showQuery() method which prints the query
	 *
	 * @param var $dQuery        	
	 * @return the result of executeQuery(), which is the result set fetche
	 */
	public function pq($dQuery) {
		
		$this->dQuery = $dQuery;
		self::showQuery();
		return self::executeQuery();
	}
	
	/**
	 * Prints the query
	 *
	 * @return query printed
	 */
	
	private function showQuery() {
		
		$this->queryToPrint = '-------------------------------------------- YOUR QUERY-----------------------------------' . '<br>' . '<span style="color: red">' . $this->dQuery . '</span>' . '<br>' . '-------------------------------------------- YOUR QUERY-----------------------------------';
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
		
		if(strtoupper(substr($trimmed, 0, 6)) != 'DELETE') {
			// print 'not ok';
		}
	}

}

?>