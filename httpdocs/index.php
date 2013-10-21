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

define('ROOT_DIR', realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR);
include '../application/bootStrap.php';
use classes\Languages;

$Registry->language = (! isset($Registry->GET['lang'])) ? 'en' : $Registry->GET['lang'];
$Registry->languages = (new Languages() )->getTexts();
$Registry->nr_items_to_display = $Settings->getNrItemsToDisplay();
$Registry->user_pictures_settings = $Settings->getUserPicturesSettings();
$Registry->user_videos_settings = $Settings->getUserVideosSettings();
$Registry->user_music_settings = $Settings->getUserMusicSettings();
$Registry->banners = $Settings->getBanners();
if($Registry->Settings->enable_apc_cache == 'yes') {
	(new SplAutoloader('lib\SystemCache', array(
			'lib/SystemCache'
	)) )->register();
	$Registry->SystemCache = \lib\SystemCache\SystemCache::cacheFactory('apc');
} elseif($Registry->Settings->enable_memcache == 'yes') {
	(new SplAutoloader('lib\SystemCache', array(
			'lib/SystemCache'
	)) )->register();
	$Registry->SystemCache = new \lib\SystemCache\SystemCache('memcache');
} else {
	$Registry->SystemCache = FALSE;
}
isset($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key) ? (new classes\UsersLogged())->updateLoginTime() : NULL;
(new classes\UsersLogged())->updateLoggedInUsers();
(new SplAutoloader('lib\Router', array(
		'lib/Router'
)) )->register();

$Router = new lib\Router\Router();
// print
// $Router->setRouteType('GET')->routerFactory()->setValidRoutes($validRoutes)->findRoute()->getPage();
$Router->findRoute()->Dispatch();
?>