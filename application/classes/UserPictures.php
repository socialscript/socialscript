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

class UserPictures {
	function __construct() {
	}
	static function getProfilePicture($UserKey, $Width, $Height) {
		$user_photo_dir = USER_DATA_DIR . $UserKey . DIRECTORY_SEPARATOR . 'photos' . DIRECTORY_SEPARATOR;

		if(is_file($user_photo_dir . 'profile.jpg')) {
			return '<img src="' . SITE_URL . 'image.php?src=' . str_replace('\\', '/', str_replace(USER_DATA_DIR, '', $user_photo_dir)) . 'profile.jpg&w=' . $Width . '&h=' . $Height . '&aoe=1&zc=1" class="img-rounded">';
		} else {
			return '<img src="' . SITE_URL . 'image.php?src=../../resources/images/profile.jpg&w=' . $Width . '&h=' . $Height . '&aoe=1&zc=1" class="img-rounded">';
		}
	}
	static function getPicture($userKey, $picName, $galleryName, $Width, $Height) {
		$user_photo_dir = USER_DATA_DIR . $userKey . DIRECTORY_SEPARATOR . 'photos' . DIRECTORY_SEPARATOR . $galleryName . DIRECTORY_SEPARATOR;

		if(is_file($user_photo_dir . $picName)) {
			return '<img src="' . SITE_URL . 'image.php?src=' . str_replace(USER_DATA_DIR, '', $user_photo_dir) . $picName . '&w=' . $Width . '&h=' . $Height . '&aoe=1&zc=1" class="img-rounded">';
		}
	}
	static function getGroupPicture($picName, $galleryName, $Width, $Height) {
		$user_photo_dir = USER_DATA_DIR . 'groups' . DIRECTORY_SEPARATOR . $galleryName . DIRECTORY_SEPARATOR . 'photos' . DIRECTORY_SEPARATOR;

		if(is_file($user_photo_dir . $picName)) {
			return '<img src="' . SITE_URL . 'image.php?src=' . str_replace(USER_DATA_DIR, '', $user_photo_dir) . $picName . '&w=' . $Width . '&h=' . $Height . '&aoe=1&zc=1" class="img-rounded">';
		}
	}
	static function getPictureForGrid($userKey, $picName, $galleryName, $Width, $Height) {
		$user_photo_dir = USER_DATA_DIR . $userKey . DIRECTORY_SEPARATOR . 'photos' . DIRECTORY_SEPARATOR . $galleryName . DIRECTORY_SEPARATOR;

		if(is_file($user_photo_dir . $picName)) {
			return str_replace('\\', "/", '<img src="' . SITE_URL . 'image.php?src=' . str_replace(USER_DATA_DIR, '', $user_photo_dir) . $picName . '&w=' . $Width . '&h=' . $Height . '&aoe=1&zc=1" class="img-rounded">');
		}
	}
}

?>