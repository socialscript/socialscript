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

namespace lib\Router;
use lib\Router\Interfaces\InterfaceRouter;
use lib\WNException\WNException;
use lib\Core\Registry;

final class Router implements InterfaceRouter {

	protected $queryString;
	/**
	 * The variable will hold the query string elements if there are more than
	 * one.
	 *
	 * @var array
	 */
	protected $queryStringElementsLevelI = FALSE;

	/**
	 * The variable will hold the query string elements exploded by '='
	 *
	 * @var array
	 */
	protected $queryStringElementsLevelII = FALSE;
	/**
	 * page element,the php file name to be loaded(eg page=home)
	 */
	const PAGE_ELEMENT = 'route';

	/**
	 * Will hold the status,if route is found or not
	 *
	 * @var bool
	 */
	protected $isValidRoute = FALSE;
	/**
	 * Will hold the page name(the php file to be loaded)
	 *
	 * @var unknown_type
	 */
	protected $pageName = FALSE;

	protected $isPageElement = FALSE;

	protected $message = FALSE;
	protected $serverScriptFilename = FALSE;
	protected $scriptFilenameAr = FALSE;
	public $scriptFilename;
	private $controllersDir;

	function __construct() {
		$this->Registry = Registry::getInstance();

		$this->validRoutes = $this->Registry->validRoutes;
		$this->controllersDir = $this->Registry->CONTROLLERS_DIR;
		$this->GET = $this->Registry->GET;

	}
	/**
	 * Retrieve the query string from $_SERVER variable
	 */
	function retrieveQueryString() {
		$this->queryString = $_SERVER['QUERY_STRING'];

	}

	function setControllersDir($controllersDir) {
		$this->controllersDir = $controllersDir;
		return $this;

	}

	function setValidRoutes($validRoutes) {
		$this->validRoutes = $validRoutes;
		return $this;
	}

	/**
	 * First level elements.All elements exploded by &,if it has more than 1
	 * element,if no & then returns the query string
	 */
	function queryStringElementsLevelI() {
		/* check if query string has more than one elements */
		if($this->queryString == '')
		{
			$this->queryString = 'route=index&action=index';
		}
		if(strpos($this->queryString, '&')) {
			(array) $this->queryStringElementsLevelI;
			$this->queryStringElementsLevelI = explode('&', $this->queryString);
		} else {
			$this->queryStringElementsLevelI = $this->queryString;

		}

	}

	/**
	 * Second level elements.Returns an array with elements exploded by =,
	 * eg Array ( [0] => Array ( [0] => page [1] => home ) [1] => Array ( [0] =>
	 * action [1] => add ) )
	 */
	function queryStringElementsLevelII() {
		if(is_array($this->queryStringElementsLevelI)) {
			(array) $this->queryStringElementsLevelII;

			foreach($this->queryStringElementsLevelI as $k => $v) {
				try {

					if(strpos($v, '=')) {

						$this->queryStringElementsLevelII[] = explode('=', $v);
					} else {
						throw new WNException('Url has not a valid format');
					}
				} catch ( WNException $e ) {
					$e->manageException();
				}

			}
		} else {
			(array) $this->queryStringElementsLevelII;
			$this->queryStringElementsLevelII[] = explode('=', $this->queryStringElementsLevelI);
		}

	}

	/**
	 * Find the route based on query string.
	 */

	public function findRoute() {
		self::retrieveQueryString();
		self::queryStringElementsLevelI();
		self::queryStringElementsLevelII();


		if(count($this->queryStringElementsLevelII) > 0) {
			foreach($this->queryStringElementsLevelII as $k => $v) {
				// For Array ( [0] => page [1] => home ) first arg is
				// page,second is valid routes keys
				if(array_key_exists($v[0], $this->validRoutes['parameter_name'])) {

					if($v[0] == self::PAGE_ELEMENT) {
						$this->isPageElement = TRUE;
					}
					// For Array ( [0] => page [1] => home ) first arg is
					// home,second is valid routes values for 'page'
					if(in_array($v[1], $this->validRoutes['parameter_name'][$v[0]])) {

						$this->isValidRoute = TRUE;

						// if it is the page element,the php file name to be
						// loaded
						if($v[0] == self::PAGE_ELEMENT) {
							$this->controllerName = $v[1];
						}
					} else {
						// unset the element
						unset($this->GET[$v[0]]);

						$this->message[] = 'Element ' . $v[0] . '=<span style="color:red">' . $v[1] . '</span> does not have a value that match';
					}
				}

				// If not found,try to find in regexp elements
				// For Array ( [0] => id [1] => 10 ) first arg is id,second is
				// valid routes regexp keys
				elseif(array_key_exists($v[0], $this->validRoutes['parameter_name']['regexp'])) {
					if(preg_match('/' . current($this->validRoutes['parameter_name']['regexp'][$v[0]]) . '/', $v[1])) {
						$this->isValidRoute = TRUE;
					}
				} else {
					// unset the element
					unset($this->GET[$v[0]]);

					$this->message[] = 'Element <span style="color:red">' . $v[0] . '</span> does not have a value that match';

				}
			}
		}
		$this->Registry->GET = $this->GET;
		return $this;
	}

	public function getPage() {
		if($this->isValidRoute == TRUE) {
			return $this->controllerName;
		}

	}

	public function getQueryStringElements() {
		return $this->queryStringElementsLevelII;
	}

	public function getRoute() {
		self::findRoute();
	}

	public function getFileName() {
		$this->serverScriptFilename = $_SERVER['SCRIPT_FILENAME'];
		$this->scriptFilenameAr = explode('/', $this->serverScriptFilename);
		$this->scriptFilename = $this->scriptFilenameAr[count($this->scriptFilenameAr) - 1];
		return $this->scriptFilename;
	}

	public function Dispatch() {
		if($this->controllerName !== FALSE) {
			try {
				if(strpos($this->controllerName, '_') !== FALSE) {
					$this->controllerNameAr = explode('_', $this->controllerName);

				$this->controllerNameAr =	array_map(function ($value) {
						return ucfirst($value);
					}, $this->controllerNameAr);
					$this->controllerName = implode('', $this->controllerNameAr);
				}
				$this->controllerName = ucfirst($this->controllerName);

				($this->Registry->isAdmin === TRUE) ? $this->controllerName = 'Admin' . $this->controllerName : NULL;

				if(file_exists($this->controllersDir . $this->controllerName . '.php')) {

					// use $this->controllersDir . '\\' .
					// $this->controllerName();

					$this->Registry->controllerName = $this->controllerName;

					(new \SplAutoloader('controllers', array(
							'controllers'
					)) )->register();

					if(isset($this->queryStringElementsLevelII[1]) && $this->queryStringElementsLevelII[1][0] == 'action') {
						$method = ucfirst($this->queryStringElementsLevelII[1][1]);
						$method = str_replace('_', '', $method);
						// $this->Controller->$method();
					}

					$controller = 'controllers\\' . $this->controllerName;
					try {
						if(class_exists($controller)) {

							if(! isset($method)) {
								if($this->Registry->isAdmin === TRUE) {
									$this->Controller = new $controller();
								} else {
									$this->Controller = (new $controller() )->Index();
								}
							} else {
								$this->Controller = (new $controller() )->$method();
							}
						} else {
							throw new WNException('Class "' . $this->controllerName . ' does not exists');
						}

					} catch ( WNException $e ) {
						$e->manageException();
					}

				} else {
					throw new WNException('File "' . $this->controllerName . '.php" does not exists');
				}
			} catch ( WNException $e ) {
				$e->manageException();
			}

		}

	}

	function Status() {
		if(is_array($this->message)) {
			array_unshift($this->message, '<span style="color:red">Failed</span>');
		}

		if($this->isPageElement !== FALSE) {
			if($this->controllerName !== FALSE) {
				$this->message[] = 'Page was found';
			}
		} else {
			$this->message[] = 'The query string does not have the ' . self::PAGE_ELEMENT . ' element';
		}

		if($this->isValidRoute === FALSE) {
			$this->message[] = 'The route is not valid';
		}

		echo implode('<br>', $this->message);
	}
}
?>