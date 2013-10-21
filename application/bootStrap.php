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

ob_start();
ini_set ( 'log_errors', 1 );
ini_set ( 'error_log', ROOT_DIR . 'data/logs/log.txt' );
set_time_limit(0);
ini_set('display_errors', 0);
error_reporting(0);
date_default_timezone_set('America/Los_Angeles');
define('APPLICATION_DIR', realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR);
define('CONFIGS_DIR', APPLICATION_DIR . 'config' . DIRECTORY_SEPARATOR);
define('LANGUAGES_DIR', CONFIGS_DIR . DIRECTORY_SEPARATOR . 'languages' . DIRECTORY_SEPARATOR);
define('LIBS_DIR', APPLICATION_DIR . 'lib' . DIRECTORY_SEPARATOR);
define('HELPERS_DIR', APPLICATION_DIR . 'helpers' . DIRECTORY_SEPARATOR);
define('CONTROLLERS_DIR', APPLICATION_DIR . 'controllers' . DIRECTORY_SEPARATOR);
if(! defined('DATA_DIR')) {
	define('DATA_DIR', ROOT_DIR . 'data' . DIRECTORY_SEPARATOR);
}
define('UPLOADS_DIR', DATA_DIR . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR);
define('USER_DATA_DIR', DATA_DIR . 'uploads' . DIRECTORY_SEPARATOR);
define('WN', 'WN');
(count(explode('/', $_SERVER['SCRIPT_NAME'])) > 1) ? define('INSTALLATION_DIR', substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/') + 1)) : define('INSTALLATION_DIR', '');
ini_set('include_path', APPLICATION_DIR);
use lib\WNException\WNException;
use lib\DB\DBMysqlPDO;
use classes\Settings;

include LIBS_DIR . 'WNException/WNException.php';

try {
	if(is_file(CONFIGS_DIR . 'config.php')) {
		include CONFIGS_DIR . 'config.php';
	} else {
		throw new WNException('config file doesn"t exist');
	}
} catch ( WNException $e ) {
	print $e->getMessage();
}

try {
	if(is_file(LIBS_DIR . 'Autoloader/SplAutoloader.php')) {
		include LIBS_DIR . 'Autoloader/SplAutoloader.php';
	} else {
		throw new WNException('loader file doesn"t exist');
	}
} catch ( WNException $e ) {
	print $e->getMessage();
}

include HELPERS_DIR . 'functions.php';
set_error_handler('WNErrorHandler');

(new SplAutoloader('lib\Core', array(
		'lib/Core'
)) )->register();

(new \SplAutoloader('lib\DB', array(
		'lib/DB'
)) )->register();
(new SplAutoloader('classes', array(
		'classes'
)) )->register();
(new SplAutoloader('lib\Sessions', array(
		'lib/Sessions'
)) )->register();

(new \SplAutoloader('lib\RBAC', array(
		'lib/RBAC'
)) )->register();
(new \SplAutoloader('helpers', array(
		'helpers'
)) )->register();
$Registry = lib\Core\Registry::getInstance();
$Registry->dbConnectionAr = $dbConnectionAr;
$Registry->table_prefix = $table_prefix;
$Registry->DB = (new DBMysqlPDO() )->setDBConnectionAr($dbConnectionAr);
$Settings = new Settings();
$Registry->Settings = $Settings->getSettings();
define('SITE_URL', $Registry->Settings->site_url);
if(! defined('IS_ADMIN')) {
	define('NO_AJAX', $Registry->Settings->front_load_ajax);
} else {
	define('NO_AJAX', 'no');
}
try {
	if((new \helpers\CountryByIp() )->getUserCountry()->checkCountryAvailability() == 'no') {
		throw new WNException('The website is not available for your country');
	}
} catch ( WNException $e ) {
	$e->manageException();
}

ini_set('session.use_only_cookies', 1);
ini_set('session.referer_check', $_SERVER['SERVER_NAME']);
if(extension_loaded('hash')) {
	ini_set('session.hash_function', helpers\Utils::getEncryptionAlgorithm());
}
ini_set('gc_maxlifetime', (int) $Registry->Settings->session_lifetime);

switch ($Registry->Settings->session_type) {
	case 'file' :
		$Registry->sessionsSavePath = DATA_DIR . 'sessions';
		session_set_save_handler(new \lib\Sessions\SessionHandlers\SessionFile(), true);
		break;
	case 'mysql' :
		session_set_save_handler(new \lib\Sessions\SessionHandlers\SessionMysql(), true);
		break;
	case 'memcached' :
		session_set_save_handler(new \lib\Sessions\SessionHandlers\SessionMemcached(), true);
		break;
	default :
		break;
}


session_start();

$Registry->validRoutes = $validRoutes;
$Registry->smartyConfig = $smarty_config;
$Registry->APPLICATION_DIR = APPLICATION_DIR;
$Registry->CONTROLLERS_DIR = CONTROLLERS_DIR;
$Registry->form_validators = $form_validators;
$Registry->form_validators_js = $form_validators_js;
$Registry->form_validators_regexp = $form_validators_regexp;
$Registry->POST = $_POST;
$Registry->GET = $_GET;

$Registry->FILES = $_FILES;
$Registry->COOKIE = $_COOKIE;

unset($_GET);
unset($_POST);
unset($_FILES);
unset($GLOBALS);
unset($_ENV);
?>