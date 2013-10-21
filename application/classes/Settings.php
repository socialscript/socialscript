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

use lib\Core\Registry;

class Settings {
	function __construct() {
		$this->Registry = Registry::getInstance();
		$this->DB = $this->Registry->DB;
	}
	function getSettings() {
		$result = $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT id,name,value FROM ' . $this->Registry->table_prefix . '_settings');
		$settings = new \stdClass();
		foreach($result as $k => $v) {
			$id = strtolower(str_replace(' ', '_', $v->name));
			$settings->$id = $v->value;
		}
		
		$settings->resources_url = (filter_var($settings->cdn_url, FILTER_VALIDATE_URL)) ? $settings->cdn_url : $settings->site_url;
		$settings->analytics_code = $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->Registry->table_prefix . '_analytics_code WHERE id="1"')[0]->code;
		
		return $settings;
	}
	function getNrItemsToDisplay() {
		$result = $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT id,name,value FROM ' . $this->Registry->table_prefix . '_nr_items_to_display');
		$nr_items_to_display = new \stdClass();
		foreach($result as $k => $v) {
			$id = strtolower(str_replace(' ', '_', $v->name));
			$nr_items_to_display->$id = $v->value;
		}
		
		return $nr_items_to_display;
	}
	function getUserPicturesSettings() {
		$result = $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT id,name,value FROM ' . $this->Registry->table_prefix . '_user_pictures_settings');
		$user_pictures_settings = new \stdClass();
		foreach($result as $k => $v) {
			$id = strtolower(str_replace(' ', '_', $v->name));
			$user_pictures_settings->$id = $v->value;
		}
		
		return $user_pictures_settings;
	}
	function getUserVideosSettings() {
		$result = $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT id,name,value FROM ' . $this->Registry->table_prefix . '_user_videos_settings');
		$user_videos_settings = new \stdClass();
		foreach($result as $k => $v) {
			$id = strtolower(str_replace(' ', '_', $v->name));
			$user_videos_settings->$id = $v->value;
		}
		
		return $user_videos_settings;
	}
	function getUserMusicSettings() {
		$result = $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT id,name,value FROM ' . $this->Registry->table_prefix . '_user_music_settings');
		$user_music_settings = new \stdClass();
		foreach($result as $k => $v) {
			$id = strtolower(str_replace(' ', '_', $v->name));
			$user_music_settings->$id = $v->value;
		}
		
		return $user_music_settings;
	}
	function getBanners() {
		return $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->Registry->table_prefix . '_banners ORDER BY section DESC');
	}
}

?>