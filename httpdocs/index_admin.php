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
define('IS_ADMIN', 1);
ini_set('display_errors',0);
include '../application/bootStrap.php';
ini_set('display_errors',0);

$lang_dir = (! isset($lang)) ? 'en' . DIRECTORY_SEPARATOR . 'admin.php' : $lang . DIRECTORY_SEPARATOR . 'admin.php';
include LANGUAGES_DIR . $lang_dir;
$Registry->google_analytics = $google_analytics;
$grid_dimensions = array();
$resolution = explode('x', $Registry->COOKIE['users_resolution']);
$Registry->resolution = $resolution;
if($resolution[0] > 1500) {
	$grid_dimensions['extra_sections']['width'] = 860;
	$grid_dimensions['extra_sections']['height'] = 660;
	$grid_dimensions['extra_sections']['per_page'] = 30;
	$grid_dimensions['extra_sections']['row_list'] = array(
			30,
			60,
			90
	);
	$grid_dimensions['extra_sections']['id_hidden'] = 'false';
	$grid_dimensions['extra_sections_comments']['width'] = 470;
	$grid_dimensions['extra_sections_comments']['height'] = 660;
	$grid_dimensions['extra_sections_comments']['per_page'] = 30;
	$grid_dimensions['extra_sections_comments']['row_list'] = array(
			30,
			60,
			90
	);
	$grid_dimensions['extra_sections_comments']['id_hidden'] = 'false';
	$grid_dimensions['events']['width'] = 860;
	$grid_dimensions['events']['height'] = 660;
	$grid_dimensions['events']['per_page'] = 30;
	$grid_dimensions['events']['row_list'] = array(
			30,
			60,
			90
	);
	$grid_dimensions['events']['id_hidden'] = 'false';
	$grid_dimensions['events_comments']['width'] = 470;
	$grid_dimensions['events_comments']['height'] = 660;
	$grid_dimensions['events_comments']['per_page'] = 30;
	$grid_dimensions['events_comments']['row_list'] = array(
			30,
			60,
			90
	);
	$grid_dimensions['events_comments']['id_hidden'] = 'false';
	$grid_dimensions['blogs']['width'] = 860;
	$grid_dimensions['blogs']['height'] = 660;
	$grid_dimensions['blogs']['per_page'] = 30;
	$grid_dimensions['blogs']['row_list'] = array(
			30,
			60,
			90
	);
	$grid_dimensions['blogs']['id_hidden'] = 'false';
	$grid_dimensions['blogs_comments']['width'] = 470;
	$grid_dimensions['blogs_comments']['height'] = 660;
	$grid_dimensions['blogs_comments']['per_page'] = 30;
	$grid_dimensions['blogs_comments']['row_list'] = array(
			30,
			60,
			90
	);
	$grid_dimensions['blogs_comments']['id_hidden'] = 'false';
	$grid_dimensions['users']['width'] = 860;
	$grid_dimensions['users']['height'] = 660;
	$grid_dimensions['users']['per_page'] = 30;
	$grid_dimensions['users']['row_list'] = array(
			30,
			60,
			90
	);
	$grid_dimensions['users']['id_hidden'] = 'false';
	$grid_dimensions['users_extra']['width'] = 470;
	$grid_dimensions['users_extra']['height'] = 660;
	$grid_dimensions['users_extra']['per_page'] = 30;
	$grid_dimensions['users_extra']['row_list'] = array(
			30,
			60,
			90
	);
	$grid_dimensions['users_extra']['id_hidden'] = 'false';
	$grid_dimensions['groups']['width'] = 650;
	$grid_dimensions['groups']['height'] = 350;
	$grid_dimensions['groups']['per_page'] = 30;
	$grid_dimensions['groups']['row_list'] = array(
			30,
			60,
			90
	);
	$grid_dimensions['groups']['id_hidden'] = 'false';
	$grid_dimensions['groups_blogs']['id_hidden'] = 'false';
	$grid_dimensions['groups_blogs']['width'] = 650;
	$grid_dimensions['groups_blogs']['height'] = 350;
	$grid_dimensions['groups_blogs']['per_page'] = 30;
	$grid_dimensions['groups_blogs']['row_list'] = array(
			30,
			60,
			90
	);
	$grid_dimensions['groups_blogs']['id_hidden'] = 'false';
	$grid_dimensions['groups_images']['width'] = 650;
	$grid_dimensions['groups_images']['height'] = 350;
	$grid_dimensions['groups_images']['per_page'] = 30;
	$grid_dimensions['groups_images']['row_list'] = array(
			30,
			60,
			90
	);
	$grid_dimensions['groups_images']['id_hidden'] = 'false';
	$grid_dimensions['groups_events']['width'] = 650;
	$grid_dimensions['groups_events']['height'] = 350;
	$grid_dimensions['groups_events']['per_page'] = 30;
	$grid_dimensions['groups_events']['row_list'] = array(
			30,
			60,
			90
	);
	$grid_dimensions['groups_events']['id_hidden'] = 'false';
	$grid_dimensions['trade']['width'] = 860;
	$grid_dimensions['trade']['height'] = 660;
	$grid_dimensions['trade']['per_page'] = 30;
	$grid_dimensions['trade']['row_list'] = array(
			30,
			60,
			90
	);
	$grid_dimensions['trade']['id_hidden'] = 'false';
	$grid_dimensions['trade_questions']['width'] = 470;
	$grid_dimensions['trade_questions']['height'] = 660;
	$grid_dimensions['trade_questions']['per_page'] = 30;
	$grid_dimensions['trade_questions']['row_list'] = array(
			30,
			60,
			90
	);
	$grid_dimensions['trade_questions']['id_hidden'] = 'false';
	$grid_dimensions['pictures']['width'] = 860;
	$grid_dimensions['pictures']['height'] = 660;
	$grid_dimensions['pictures']['per_page'] = 30;
	$grid_dimensions['pictures']['row_list'] = array(
			30,
			60,
			90
	);
	$grid_dimensions['pictures']['id_hidden'] = 'false';
	$grid_dimensions['pictures_comments']['width'] = 470;
	$grid_dimensions['pictures_comments']['height'] = 260;
	$grid_dimensions['pictures_comments']['per_page'] = 30;
	$grid_dimensions['pictures_comments']['row_list'] = array(
			30,
			60,
			90
	);
	$grid_dimensions['pictures_comments']['id_hidden'] = 'false';
	$grid_dimensions['music']['width'] = 860;
	$grid_dimensions['music']['height'] = 650;
	$grid_dimensions['music']['per_page'] = 30;
	$grid_dimensions['music']['row_list'] = array(
			30,
			60,
			90
	);
	$grid_dimensions['music']['id_hidden'] = 'false';
	$grid_dimensions['music_comments']['width'] = 470;
	$grid_dimensions['music_comments']['height'] = 260;
	$grid_dimensions['music_comments']['per_page'] = 30;
	$grid_dimensions['music_comments']['row_list'] = array(
			30,
			60,
			90
	);
	$grid_dimensions['music_comments']['id_hidden'] = 'false';
	$grid_dimensions['videos']['width'] = 860;
	$grid_dimensions['videos']['height'] = 660;
	$grid_dimensions['videos']['per_page'] = 30;
	$grid_dimensions['videos']['row_list'] = array(
			30,
			60,
			90
	);
	$grid_dimensions['videos']['id_hidden'] = 'false';
	$grid_dimensions['videos_comments']['width'] = 470;
	$grid_dimensions['videos_comments']['height'] = 260;
	$grid_dimensions['videos_comments']['per_page'] = 30;
	$grid_dimensions['videos_comments']['row_list'] = array(
			30,
			60,
			90
	);
	$grid_dimensions['videos_comments']['id_hidden'] = 'false';
} elseif($resolution[0] < 1500 && $resolution[0] > 1300) {
	$grid_dimensions['extra_sections']['width'] = 730;
	$grid_dimensions['extra_sections']['height'] = 540;
	$grid_dimensions['extra_sections']['per_page'] = 24;
	$grid_dimensions['extra_sections']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['extra_sections']['id_hidden'] = 'true';
	$grid_dimensions['extra_sections_comments']['width'] = 395;
	$grid_dimensions['extra_sections_comments']['height'] = 540;
	$grid_dimensions['extra_sections_comments']['per_page'] = 24;
	$grid_dimensions['extra_sections_comments']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['extra_sections_comments']['id_hidden'] = 'true';
	$grid_dimensions['events']['width'] = 730;
	$grid_dimensions['events']['height'] = 540;
	$grid_dimensions['events']['per_page'] = 24;
	$grid_dimensions['events']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['events']['id_hidden'] = 'true';
	$grid_dimensions['events_comments']['width'] = 395;
	$grid_dimensions['events_comments']['height'] = 540;
	$grid_dimensions['events_comments']['per_page'] = 24;
	$grid_dimensions['events_comments']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['events_comments']['id_hidden'] = 'true';
	$grid_dimensions['events_comments']['id_hidden'] = 'true';
	$grid_dimensions['blogs']['width'] = 730;
	$grid_dimensions['blogs']['height'] = 540;
	$grid_dimensions['blogs']['per_page'] = 24;
	$grid_dimensions['blogs']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['blogs']['id_hidden'] = 'true';
	$grid_dimensions['blogs_comments']['width'] = 395;
	$grid_dimensions['blogs_comments']['height'] = 540;
	$grid_dimensions['blogs_comments']['per_page'] = 24;
	$grid_dimensions['blogs_comments']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['blogs_comments']['id_hidden'] = 'true';
	$grid_dimensions['users']['width'] = 730;
	$grid_dimensions['users']['height'] = 540;
	$grid_dimensions['users']['per_page'] = 24;
	$grid_dimensions['users']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['users']['id_hidden'] = 'true';
	$grid_dimensions['users_extra']['width'] = 395;
	$grid_dimensions['users_extra']['height'] = 540;
	$grid_dimensions['users_extra']['per_page'] = 24;
	$grid_dimensions['users_extra']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['users_extra']['id_hidden'] = 'true';
	$grid_dimensions['groups']['width'] = 560;
	$grid_dimensions['groups']['height'] = 250;
	$grid_dimensions['groups']['per_page'] = 30;
	$grid_dimensions['groups']['row_list'] = array(
			30,
			60,
			90
	);
	$grid_dimensions['groups']['id_hidden'] = 'false';
	$grid_dimensions['groups_blogs']['id_hidden'] = 'false';
	$grid_dimensions['groups_blogs']['width'] = 560;
	$grid_dimensions['groups_blogs']['height'] = 250;
	$grid_dimensions['groups_blogs']['per_page'] = 30;
	$grid_dimensions['groups_blogs']['row_list'] = array(
			30,
			60,
			90
	);
	$grid_dimensions['groups_blogs']['id_hidden'] = 'false';
	$grid_dimensions['groups_images']['width'] = 560;
	$grid_dimensions['groups_images']['height'] = 250;
	$grid_dimensions['groups_images']['per_page'] = 30;
	$grid_dimensions['groups_images']['row_list'] = array(
			30,
			60,
			90
	);
	$grid_dimensions['groups_images']['id_hidden'] = 'false';
	$grid_dimensions['groups_events']['width'] = 560;
	$grid_dimensions['groups_events']['height'] = 250;
	$grid_dimensions['groups_events']['per_page'] = 30;
	$grid_dimensions['groups_events']['row_list'] = array(
			30,
			60,
			90
	);
	$grid_dimensions['groups_events']['id_hidden'] = 'false';
	$grid_dimensions['trade']['width'] = 730;
	$grid_dimensions['trade']['height'] = 540;
	$grid_dimensions['trade']['per_page'] = 24;
	$grid_dimensions['trade']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['trade']['id_hidden'] = 'true';
	$grid_dimensions['trade_questions']['width'] = 395;
	$grid_dimensions['trade_questions']['height'] = 540;
	$grid_dimensions['trade_questions']['per_page'] = 24;
	$grid_dimensions['trade_questions']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['trade_questions']['id_hidden'] = 'true';
	$grid_dimensions['pictures']['width'] = 730;
	$grid_dimensions['pictures']['height'] = 540;
	$grid_dimensions['pictures']['per_page'] = 8;
	$grid_dimensions['pictures']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['pictures']['id_hidden'] = 'true';
	$grid_dimensions['pictures_comments']['width'] = 395;
	$grid_dimensions['pictures_comments']['height'] = 240;
	$grid_dimensions['pictures_comments']['per_page'] = 24;
	$grid_dimensions['pictures_comments']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['pictures_comments']['id_hidden'] = 'true';
	$grid_dimensions['music']['width'] = 730;
	$grid_dimensions['music']['height'] = 540;
	$grid_dimensions['music']['per_page'] = 24;
	$grid_dimensions['music']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['music']['id_hidden'] = 'true';
	$grid_dimensions['music_comments']['width'] = 395;
	$grid_dimensions['music_comments']['height'] = 240;
	$grid_dimensions['music_comments']['per_page'] = 24;
	$grid_dimensions['music_comments']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['music_comments']['id_hidden'] = 'true';
	$grid_dimensions['videos']['width'] = 730;
	$grid_dimensions['videos']['height'] = 540;
	$grid_dimensions['videos']['per_page'] = 24;
	$grid_dimensions['videos']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['videos']['id_hidden'] = 'true';
	$grid_dimensions['videos_comments']['width'] = 395;
	$grid_dimensions['videos_comments']['height'] = 240;
	$grid_dimensions['videos_comments']['per_page'] = 24;
	$grid_dimensions['videos_comments']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['videos_comments']['id_hidden'] = 'true';
} elseif($resolution[0] < 1300 && $resolution[0] > 1100) {
	$grid_dimensions['extra_sections']['width'] = 680;
	$grid_dimensions['extra_sections']['height'] = 540;
	$grid_dimensions['extra_sections']['per_page'] = 24;
	$grid_dimensions['extra_sections']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['extra_sections']['id_hidden'] = 'true';
	$grid_dimensions['extra_sections_comments']['width'] = 370;
	$grid_dimensions['extra_sections_comments']['height'] = 540;
	$grid_dimensions['extra_sections_comments']['per_page'] = 24;
	$grid_dimensions['extra_sections_comments']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['extra_sections_comments']['id_hidden'] = 'true';
	$grid_dimensions['events']['width'] = 680;
	$grid_dimensions['events']['height'] = 540;
	$grid_dimensions['events']['per_page'] = 24;
	$grid_dimensions['events']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['events']['id_hidden'] = 'true';
	$grid_dimensions['events_comments']['width'] = 370;
	$grid_dimensions['events_comments']['height'] = 540;
	$grid_dimensions['events_comments']['per_page'] = 24;
	$grid_dimensions['events_comments']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['events_comments']['id_hidden'] = 'true';
	$grid_dimensions['blogs']['width'] = 680;
	$grid_dimensions['blogs']['height'] = 540;
	$grid_dimensions['blogs']['per_page'] = 24;
	$grid_dimensions['blogs']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['blogs']['id_hidden'] = 'true';
	$grid_dimensions['blogs_comments']['width'] = 370;
	$grid_dimensions['blogs_comments']['height'] = 540;
	$grid_dimensions['blogs_comments']['per_page'] = 24;
	$grid_dimensions['blogs_comments']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['blogs_comments']['id_hidden'] = 'true';
	$grid_dimensions['users']['width'] = 680;
	$grid_dimensions['users']['height'] = 540;
	$grid_dimensions['users']['per_page'] = 24;
	$grid_dimensions['users']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['users']['id_hidden'] = 'true';
	$grid_dimensions['users_extra']['width'] = 370;
	$grid_dimensions['users_extra']['height'] = 540;
	$grid_dimensions['users_extra']['per_page'] = 24;
	$grid_dimensions['users_extra']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['users_extra']['id_hidden'] = 'true';
	$grid_dimensions['groups']['width'] = 680;
	$grid_dimensions['groups']['height'] = 540;
	$grid_dimensions['groups']['per_page'] = 24;
	$grid_dimensions['groups']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['groups']['id_hidden'] = 'true';
	$grid_dimensions['groups_blogs']['width'] = 370;
	$grid_dimensions['groups_blogs']['height'] = 540;
	$grid_dimensions['groups_blogs']['per_page'] = 24;
	$grid_dimensions['groups_blogs']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['groups_blogs']['id_hidden'] = 'true';
	$grid_dimensions['groups_images']['width'] = 680;
	$grid_dimensions['groups_images']['height'] = 370;
	$grid_dimensions['groups_images']['per_page'] = 24;
	$grid_dimensions['groups_images']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['groups_images']['id_hidden'] = 'true';
	$grid_dimensions['groups_events']['width'] = 370;
	$grid_dimensions['groups_events']['height'] = 540;
	$grid_dimensions['groups_events']['per_page'] = 24;
	$grid_dimensions['groups_events']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['groups_events']['id_hidden'] = 'true';
	$grid_dimensions['trade']['width'] = 680;
	$grid_dimensions['trade']['height'] = 370;
	$grid_dimensions['trade']['per_page'] = 24;
	$grid_dimensions['trade']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['trade']['id_hidden'] = 'true';
	$grid_dimensions['trade_questions']['width'] = 680;
	$grid_dimensions['trade_questions']['height'] = 540;
	$grid_dimensions['trade_questions']['per_page'] = 24;
	$grid_dimensions['trade_questions']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['trade_questions']['id_hidden'] = 'true';
	$grid_dimensions['pictures']['width'] = 370;
	$grid_dimensions['pictures']['height'] = 540;
	$grid_dimensions['pictures']['per_page'] = 24;
	$grid_dimensions['pictures']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['pictures']['id_hidden'] = 'true';
	$grid_dimensions['pictures_comments']['width'] = 550;
	$grid_dimensions['pictures_comments']['height'] = 240;
	$grid_dimensions['pictures_comments']['per_page'] = 24;
	$grid_dimensions['pictures_comments']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['pictures_comments']['id_hidden'] = 'true';
	$grid_dimensions['music']['width'] = 680;
	$grid_dimensions['music']['height'] = 540;
	$grid_dimensions['music']['per_page'] = 24;
	$grid_dimensions['music']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['music']['id_hidden'] = 'true';
	$grid_dimensions['music_comments']['width'] = 370;
	$grid_dimensions['music_comments']['height'] = 240;
	$grid_dimensions['music_comments']['per_page'] = 24;
	$grid_dimensions['music_comments']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['music_comments']['id_hidden'] = 'true';
	$grid_dimensions['videos']['width'] = 680;
	$grid_dimensions['videos']['height'] = 540;
	$grid_dimensions['videos']['per_page'] = 24;
	$grid_dimensions['videos']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['videos']['id_hidden'] = 'true';
	$grid_dimensions['videos_comments']['width'] = 370;
	$grid_dimensions['videos_comments']['height'] = 240;
	$grid_dimensions['videos_comments']['per_page'] = 24;
	$grid_dimensions['videos_comments']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['videos_comments']['id_hidden'] = 'true';
} elseif($resolution[0] == 1024 && $resolution[1] == 600) {
	$grid_dimensions['extra_sections']['width'] = 530;
	$grid_dimensions['extra_sections']['height'] = 370;
	$grid_dimensions['extra_sections']['per_page'] = 24;
	$grid_dimensions['extra_sections']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['extra_sections']['id_hidden'] = 'true';
	$grid_dimensions['extra_sections_comments']['width'] = 280;
	$grid_dimensions['extra_sections_comments']['height'] = 370;
	$grid_dimensions['extra_sections_comments']['per_page'] = 24;
	$grid_dimensions['extra_sections_comments']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['extra_sections_comments']['id_hidden'] = 'true';
	$grid_dimensions['events']['width'] = 530;
	$grid_dimensions['events']['height'] = 370;
	$grid_dimensions['events']['per_page'] = 24;
	$grid_dimensions['events']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['events']['id_hidden'] = 'true';
	$grid_dimensions['events_comments']['width'] = 280;
	$grid_dimensions['events_comments']['height'] = 370;
	$grid_dimensions['events_comments']['per_page'] = 24;
	$grid_dimensions['events_comments']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['events_comments']['id_hidden'] = 'true';
	$grid_dimensions['blogs']['width'] = 530;
	$grid_dimensions['blogs']['height'] = 370;
	$grid_dimensions['blogs']['per_page'] = 24;
	$grid_dimensions['blogs']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['blogs']['id_hidden'] = 'true';
	$grid_dimensions['blogs_comments']['width'] = 280;
	$grid_dimensions['blogs_comments']['height'] = 370;
	$grid_dimensions['blogs_comments']['per_page'] = 24;
	$grid_dimensions['blogs_comments']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['blogs_comments']['id_hidden'] = 'true';
	$grid_dimensions['users']['width'] = 530;
	$grid_dimensions['users']['height'] = 370;
	$grid_dimensions['users']['per_page'] = 24;
	$grid_dimensions['users']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['users']['id_hidden'] = 'true';
	$grid_dimensions['users_extra']['width'] = 280;
	$grid_dimensions['users_extra']['height'] = 370;
	$grid_dimensions['users_extra']['per_page'] = 24;
	$grid_dimensions['users_extra']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['users_extra']['id_hidden'] = 'true';
	$grid_dimensions['groups']['width'] = 530;
	$grid_dimensions['groups']['height'] = 370;
	$grid_dimensions['groups']['per_page'] = 24;
	$grid_dimensions['groups']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['groups']['id_hidden'] = 'true';
	$grid_dimensions['groups_blogs']['width'] = 280;
	$grid_dimensions['groups_blogs']['height'] = 370;
	$grid_dimensions['groups_blogs']['per_page'] = 24;
	$grid_dimensions['groups_blogs']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['groups_blogs']['id_hidden'] = 'true';
	$grid_dimensions['groups_images']['width'] = 530;
	$grid_dimensions['groups_images']['height'] = 370;
	$grid_dimensions['groups_images']['per_page'] = 24;
	$grid_dimensions['groups_images']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['groups_images']['id_hidden'] = 'true';
	$grid_dimensions['groups_events']['width'] = 280;
	$grid_dimensions['groups_events']['height'] = 370;
	$grid_dimensions['groups_events']['per_page'] = 24;
	$grid_dimensions['groups_events']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['groups_events']['id_hidden'] = 'true';
	$grid_dimensions['trade']['width'] = 530;
	$grid_dimensions['trade']['height'] = 370;
	$grid_dimensions['trade']['per_page'] = 24;
	$grid_dimensions['trade']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['trade']['id_hidden'] = 'true';
	$grid_dimensions['trade_questions']['width'] = 280;
	$grid_dimensions['trade_questions']['height'] = 370;
	$grid_dimensions['trade_questions']['per_page'] = 24;
	$grid_dimensions['trade_questions']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['trade_questions']['id_hidden'] = 'true';
	$grid_dimensions['pictures']['width'] = 530;
	$grid_dimensions['pictures']['height'] = 370;
	$grid_dimensions['pictures']['per_page'] = 24;
	$grid_dimensions['pictures']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['pictures']['id_hidden'] = 'true';
	$grid_dimensions['pictures_comments']['width'] = 280;
	$grid_dimensions['pictures_comments']['height'] = 370;
	$grid_dimensions['pictures_comments']['per_page'] = 24;
	$grid_dimensions['pictures_comments']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['pictures_comments']['id_hidden'] = 'true';
	$grid_dimensions['music']['width'] = 530;
	$grid_dimensions['music']['height'] = 370;
	$grid_dimensions['music']['per_page'] = 24;
	$grid_dimensions['music']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['music']['id_hidden'] = 'true';
	$grid_dimensions['music_comments']['width'] = 280;
	$grid_dimensions['music_comments']['height'] = 370;
	$grid_dimensions['music_comments']['per_page'] = 24;
	$grid_dimensions['music_comments']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['music_comments']['id_hidden'] = 'true';
	$grid_dimensions['videos']['width'] = 530;
	$grid_dimensions['videos']['height'] = 370;
	$grid_dimensions['videos']['per_page'] = 24;
	$grid_dimensions['videos']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['videos']['id_hidden'] = 'true';
	$grid_dimensions['videos_comments']['width'] = 280;
	$grid_dimensions['videos_comments']['height'] = 370;
	$grid_dimensions['videos_comments']['per_page'] = 24;
	$grid_dimensions['videos_comments']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['videos_comments']['id_hidden'] = 'true';
} elseif($resolution[0] == 946 && $resolution[1] == 768) {
	$grid_dimensions['extra_sections']['width'] = 550;
	$grid_dimensions['extra_sections']['height'] = 500;
	$grid_dimensions['extra_sections']['per_page'] = 24;
	$grid_dimensions['extra_sections']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['extra_sections']['id_hidden'] = 'true';
	$grid_dimensions['extra_sections_comments']['width'] = 300;
	$grid_dimensions['extra_sections_comments']['height'] = 500;
	$grid_dimensions['extra_sections_comments']['per_page'] = 24;
	$grid_dimensions['extra_sections_comments']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['extra_sections_comments']['id_hidden'] = 'true';
	$grid_dimensions['events']['width'] = 550;
	$grid_dimensions['events']['height'] = 500;
	$grid_dimensions['events']['per_page'] = 24;
	$grid_dimensions['events']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['events']['id_hidden'] = 'true';
	$grid_dimensions['events_comments']['width'] = 300;
	$grid_dimensions['events_comments']['height'] = 500;
	$grid_dimensions['events_comments']['per_page'] = 24;
	$grid_dimensions['events_comments']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['events_comments']['id_hidden'] = 'true';
	$grid_dimensions['blogs']['width'] = 550;
	$grid_dimensions['blogs']['height'] = 500;
	$grid_dimensions['blogs']['per_page'] = 24;
	$grid_dimensions['blogs']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['blogs']['id_hidden'] = 'true';
	$grid_dimensions['blogs_comments']['width'] = 300;
	$grid_dimensions['blogs_comments']['height'] = 500;
	$grid_dimensions['blogs_comments']['per_page'] = 24;
	$grid_dimensions['blogs_comments']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['blogs_comments']['id_hidden'] = 'true';
	$grid_dimensions['users']['width'] = 550;
	$grid_dimensions['users']['height'] = 500;
	$grid_dimensions['users']['per_page'] = 24;
	$grid_dimensions['users']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['users']['id_hidden'] = 'true';
	$grid_dimensions['users_extra']['width'] = 300;
	$grid_dimensions['users_extra']['height'] = 500;
	$grid_dimensions['users_extra']['per_page'] = 24;
	$grid_dimensions['users_extra']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['users_extra']['id_hidden'] = 'true';
	$grid_dimensions['groups']['width'] = 550;
	$grid_dimensions['groups']['height'] = 500;
	$grid_dimensions['groups']['per_page'] = 24;
	$grid_dimensions['groups']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['groups']['id_hidden'] = 'true';
	$grid_dimensions['groups_blogs']['width'] = 300;
	$grid_dimensions['groups_blogs']['height'] = 500;
	$grid_dimensions['groups_blogs']['per_page'] = 24;
	$grid_dimensions['groups_blogs']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['groups_blogs']['id_hidden'] = 'true';
	$grid_dimensions['groups_images']['width'] = 550;
	$grid_dimensions['groups_images']['height'] = 500;
	$grid_dimensions['groups_images']['per_page'] = 24;
	$grid_dimensions['groups_images']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['groups_images']['id_hidden'] = 'true';
	$grid_dimensions['groups_events']['width'] = 300;
	$grid_dimensions['groups_events']['height'] = 500;
	$grid_dimensions['groups_events']['per_page'] = 24;
	$grid_dimensions['groups_events']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['groups_events']['id_hidden'] = 'true';
	$grid_dimensions['trade']['width'] = 550;
	$grid_dimensions['trade']['height'] = 500;
	$grid_dimensions['trade']['per_page'] = 24;
	$grid_dimensions['trade']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['trade']['id_hidden'] = 'true';
	$grid_dimensions['trade_questions']['width'] = 300;
	$grid_dimensions['trade_questions']['height'] = 500;
	$grid_dimensions['trade_questions']['per_page'] = 24;
	$grid_dimensions['trade_questions']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['trade_questions']['id_hidden'] = 'true';
	$grid_dimensions['pictures']['width'] = 550;
	$grid_dimensions['pictures']['height'] = 500;
	$grid_dimensions['pictures']['per_page'] = 24;
	$grid_dimensions['pictures']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['pictures']['id_hidden'] = 'true';
	$grid_dimensions['pictures_comments']['width'] = 300;
	$grid_dimensions['pictures_comments']['height'] = 500;
	$grid_dimensions['pictures_comments']['per_page'] = 24;
	$grid_dimensions['pictures_comments']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['pictures_comments']['id_hidden'] = 'true';
	$grid_dimensions['music']['width'] = 550;
	$grid_dimensions['music']['height'] = 500;
	$grid_dimensions['music']['per_page'] = 24;
	$grid_dimensions['music']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['music']['id_hidden'] = 'true';
	$grid_dimensions['music_comments']['width'] = 300;
	$grid_dimensions['music_comments']['height'] = 500;
	$grid_dimensions['music_comments']['per_page'] = 24;
	$grid_dimensions['music_comments']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['music_comments']['id_hidden'] = 'true';
	$grid_dimensions['videos']['width'] = 550;
	$grid_dimensions['videos']['height'] = 500;
	$grid_dimensions['videos']['per_page'] = 24;
	$grid_dimensions['videos']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['videos']['id_hidden'] = 'true';
	$grid_dimensions['videos_comments']['width'] = 300;
	$grid_dimensions['videos_comments']['height'] = 500;
	$grid_dimensions['videos_comments']['per_page'] = 24;
	$grid_dimensions['videos_comments']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['videos_comments']['id_hidden'] = 'true';
} elseif($resolution[0] < 1100) {
	$grid_dimensions['extra_sections']['width'] = 560;
	$grid_dimensions['extra_sections']['height'] = 540;
	$grid_dimensions['extra_sections']['per_page'] = 24;
	$grid_dimensions['extra_sections']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['extra_sections']['id_hidden'] = 'true';
	$grid_dimensions['extra_sections_comments']['width'] = 300;
	$grid_dimensions['extra_sections_comments']['height'] = 540;
	$grid_dimensions['extra_sections_comments']['per_page'] = 24;
	$grid_dimensions['extra_sections_comments']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['extra_sections_comments']['id_hidden'] = 'true';
	$grid_dimensions['events']['width'] = 560;
	$grid_dimensions['events']['height'] = 540;
	$grid_dimensions['events']['per_page'] = 24;
	$grid_dimensions['events']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['events']['id_hidden'] = 'true';
	$grid_dimensions['events_comments']['width'] = 300;
	$grid_dimensions['events_comments']['height'] = 540;
	$grid_dimensions['events_comments']['per_page'] = 24;
	$grid_dimensions['events_comments']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['events_comments']['id_hidden'] = 'true';
	$grid_dimensions['blogs']['width'] = 560;
	$grid_dimensions['blogs']['height'] = 540;
	$grid_dimensions['blogs']['per_page'] = 24;
	$grid_dimensions['blogs']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['blogs']['id_hidden'] = 'true';
	$grid_dimensions['blogs_comments']['width'] = 300;
	$grid_dimensions['blogs_comments']['height'] = 540;
	$grid_dimensions['blogs_comments']['per_page'] = 24;
	$grid_dimensions['blogs_comments']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['blogs_comments']['id_hidden'] = 'true';
	$grid_dimensions['users']['width'] = 560;
	$grid_dimensions['users']['height'] = 540;
	$grid_dimensions['users']['per_page'] = 24;
	$grid_dimensions['users']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['users']['id_hidden'] = 'true';
	$grid_dimensions['users_extra']['width'] = 300;
	$grid_dimensions['users_extra']['height'] = 540;
	$grid_dimensions['users_extra']['per_page'] = 24;
	$grid_dimensions['users_extra']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['users_extra']['id_hidden'] = 'true';
	$grid_dimensions['groups']['width'] = 500;
	$grid_dimensions['groups']['height'] = 540;
	$grid_dimensions['groups']['per_page'] = 24;
	$grid_dimensions['groups']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['groups']['id_hidden'] = 'true';
	$grid_dimensions['groups_blogs']['width'] = 300;
	$grid_dimensions['groups_blogs']['height'] = 540;
	$grid_dimensions['groups_blogs']['per_page'] = 24;
	$grid_dimensions['groups_blogs']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['groups_blogs']['id_hidden'] = 'true';
	$grid_dimensions['groups_images']['width'] = 500;
	$grid_dimensions['groups_images']['height'] = 370;
	$grid_dimensions['groups_images']['per_page'] = 24;
	$grid_dimensions['groups_images']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['groups_images']['id_hidden'] = 'true';
	$grid_dimensions['groups_events']['width'] = 300;
	$grid_dimensions['groups_events']['height'] = 540;
	$grid_dimensions['groups_events']['per_page'] = 24;
	$grid_dimensions['groups_events']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['groups_events']['id_hidden'] = 'true';
	$grid_dimensions['trade']['width'] = 560;
	$grid_dimensions['trade']['height'] = 370;
	$grid_dimensions['trade']['per_page'] = 24;
	$grid_dimensions['trade']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['trade']['id_hidden'] = 'true';
	$grid_dimensions['trade_questions']['width'] = 300;
	$grid_dimensions['trade_questions']['height'] = 540;
	$grid_dimensions['trade_questions']['per_page'] = 24;
	$grid_dimensions['trade_questions']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['trade_questions']['id_hidden'] = 'true';
	$grid_dimensions['pictures']['width'] = 560;
	$grid_dimensions['pictures']['height'] = 540;
	$grid_dimensions['pictures']['per_page'] = 24;
	$grid_dimensions['pictures']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['pictures']['id_hidden'] = 'true';
	$grid_dimensions['pictures_comments']['width'] = 300;
	$grid_dimensions['pictures_comments']['height'] = 240;
	$grid_dimensions['pictures_comments']['per_page'] = 24;
	$grid_dimensions['pictures_comments']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['pictures_comments']['id_hidden'] = 'true';
	$grid_dimensions['music']['width'] = 560;
	$grid_dimensions['music']['height'] = 540;
	$grid_dimensions['music']['per_page'] = 24;
	$grid_dimensions['music']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['music']['id_hidden'] = 'true';
	$grid_dimensions['music_comments']['width'] = 300;
	$grid_dimensions['music_comments']['height'] = 240;
	$grid_dimensions['music_comments']['per_page'] = 24;
	$grid_dimensions['music_comments']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['music_comments']['id_hidden'] = 'true';
	$grid_dimensions['videos']['width'] = 560;
	$grid_dimensions['videos']['height'] = 540;
	$grid_dimensions['videos']['per_page'] = 24;
	$grid_dimensions['videos']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['videos']['id_hidden'] = 'true';
	$grid_dimensions['videos_comments']['width'] = 300;
	$grid_dimensions['videos_comments']['height'] = 240;
	$grid_dimensions['videos_comments']['per_page'] = 24;
	$grid_dimensions['videos_comments']['row_list'] = array(
			24,
			48,
			72
	);
	$grid_dimensions['videos_comments']['id_hidden'] = 'true';
}
$Registry->grid_dimensions = $grid_dimensions;
$Registry->validRoutes = $validRoutesAdmin;
$Registry->isAdmin = TRUE;
$Registry->language = $languages;
$Registry->form_validators = $form_validators;
$Registry->form_validators_js_ajax = $form_validators_js_ajax;
$Registry->default_admin_theme = $default_admin_theme;
$Registry->user_pictures_settings = $Settings->getUserPicturesSettings();
(new SplAutoloader('lib\Router', array(
		'lib/Router'
)) )->register();

$Router = new lib\Router\Router();
// print
// $Router->setRouteType('GET')->routerFactory()->setValidRoutes($validRoutes)->findRoute()->getPage();
$Router->findRoute()->Dispatch();

