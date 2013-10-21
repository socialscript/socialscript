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

class UserMusic {
	function __construct() {
	}

	static function getMusicFile($siteUrl,$music)
	{
	$music_dir_path = $music->user_key . DIRECTORY_SEPARATOR . 'music' . DIRECTORY_SEPARATOR . md5($music->gallery_name) . DIRECTORY_SEPARATOR;
		$dir_path = USER_DATA_DIR . $music_dir_path;
		$file = '';
	if(is_file($dir_path . $music->file_name . '.mp4')) {
			$file = $siteUrl . 'data/uploads/' . str_replace('\\', '/', $music_dir_path) . $music->file_name . '.mp4';
		}
		return $file;
	}

	static function getMusicPlaylist($siteUrl, $music,$sameUserMusic, $sameGalleryMusic, $relatedMusic) {
		$playlist = '<?xml version="1.0" encoding="UTF-8"?><videos width="600" height="300">';

		$music_dir_path = $music->user_key . DIRECTORY_SEPARATOR . 'music' . DIRECTORY_SEPARATOR . md5($music->gallery_name) . DIRECTORY_SEPARATOR;
		$dir_path = USER_DATA_DIR . $music_dir_path;
		 /*
		if(count($sameUserMusic) > 0) {
			foreach($sameUserMusic as $k => $v) {
				$music_dir_path = $v->user_key . DIRECTORY_SEPARATOR . 'music' . DIRECTORY_SEPARATOR . md5($v->gallery_name) . DIRECTORY_SEPARATOR;
				$dir_path = USER_DATA_DIR . $music_dir_path;
				$playlist .= '<same_user_item>
		<title>' . $v->title . '</title>';
				/*
				if(is_file($dir_path . $v->file_name . '.mp3')) {
					$playlist .= '<mp3>' . $siteUrl . 'data/uploads/' . str_replace('\\', '/', $music_dir_path) . $v->file_name . '.mp3</mp3>';
				}
				if(is_file($dir_path . $v->file_name . '.ogg')) {
					$playlist .= '<ogg>' . $siteUrl . 'data/uploads/' . str_replace('\\', '/', $music_dir_path) . $v->file_name . '.ogg</ogg>';
				}

				if(is_file($dir_path . $v->file_name . '.mp4')) {
					$playlist .= '<mp4>' . $siteUrl . 'data/uploads/' . str_replace('\\', '/', $music_dir_path) . $v->file_name . '.mp4</mp4>';
				}
				$playlist .= '
						<id>'. $v->id . '</id>
		<description><br />Tags: ' . $v->tags . '<br />' . $v->description . '</description>
	</same_user_item>';
			}
		}
		*/
		if(count($sameGalleryMusic) > 0) {
			foreach($sameGalleryMusic as $k => $v) {
				$music_dir_path = $v->user_key . DIRECTORY_SEPARATOR . 'music' . DIRECTORY_SEPARATOR . md5($v->gallery_name) . DIRECTORY_SEPARATOR;
				$dir_path = USER_DATA_DIR . $music_dir_path;

				$playlist .= '<same_gallery_item>
		<title>' . $v->title . '</title>';
				/*
				if(is_file($dir_path . $v->file_name . '.mp3')) {
					$playlist .= '<mp3>' . $siteUrl . 'data/uploads/' . str_replace('\\', '/', $music_dir_path) . $v->file_name . '.mp3</mp3>';
				}
				if(is_file($dir_path . $v->file_name . '.ogg')) {
					$playlist .= '<ogg>' . $siteUrl . 'data/uploads/' . str_replace('\\', '/', $music_dir_path) . $v->file_name . '.ogg</ogg>';
				}
*/
if(is_file($dir_path . $v->file_name . '.mp4')) {
					$playlist .= '<mp4>' . $siteUrl . 'data/uploads/' . str_replace('\\', '/', $music_dir_path) . $v->file_name . '.mp4</mp4>';
				}
				$playlist .= '
						<id>'. $v->id . '</id>
		<description><br />Tags: ' . $v->tags . '<br />' . $v->description . '</description>
	</same_gallery_item>';
			}
		}

		if(count($relatedMusic) > 0) {
			foreach($relatedMusic as $k => $v) {
				$music_dir_path = $v->user_key . DIRECTORY_SEPARATOR . 'music' . DIRECTORY_SEPARATOR . md5($v->gallery_name) . DIRECTORY_SEPARATOR;
				$dir_path = USER_DATA_DIR . $music_dir_path;

				$playlist .= '<related_item>
		<title>' . $v->title . '</title>';
				/*
				if(is_file($dir_path . $v->file_name . '.mp3')) {
					$playlist .= '<mp3>' . $siteUrl . 'data/uploads/' . str_replace('\\', '/', $music_dir_path) . $v->file_name . '.mp3</mp3>';
				}
				if(is_file($dir_path . $v->file_name . '.ogg')) {
					$playlist .= '<ogg>' . $siteUrl . 'data/uploads/' . str_replace('\\', '/', $music_dir_path) . $v->file_name . '.ogg</ogg>';
				}
				*/
				if(is_file($dir_path . $v->file_name . '.mp4')) {
					$playlist .= '<mp4>' . $siteUrl . 'data/uploads/' . str_replace('\\', '/', $music_dir_path) . $v->file_name . '.mp4</mp4>';
				}
				$playlist .= '
						<id>'. $v->id . '</id>
		<description><br />Tags: ' . $v->tags . '<br />' . $v->description . '</description>
	</related_item>';
			}
		}
		// $playlist .= '</music>';
		return preg_replace("/\s\s+/", " ", $playlist);
	}
	static function getGroupMusicFiles($siteUrl, $groupName, $fileName) {
		$files = array();
		$dir_path = USER_DATA_DIR . 'groups' . DIRECTORY_SEPARATOR . $groupName . DIRECTORY_SEPARATOR . 'music' . DIRECTORY_SEPARATOR;
		// p($dir_path);
		/*
		if(is_file($dir_path . $fileName . '.mp3')) {
			$files[0]['type'] = 'video/mp3';
			$files[0]['file'] = $siteUrl . 'data/uploads/' . str_replace('\\', '/', str_replace(USER_DATA_DIR, '', $dir_path)) . $fileName . '.mp3';
		}
		if(is_file($dir_path . $fileName . '.ogg')) {
			$files[0]['type'] = 'video/ogg';
			$files[0]['file'] = $siteUrl . 'data/uploads/' . str_replace('\\', '/', str_replace(USER_DATA_DIR, '', $dir_path)) . $fileName . '.ogg';
		}
		*/
		if(is_file($dir_path . $fileName . '.mp4')) {
			$files[0]['type'] = 'audio/mp4';
			$files[0]['file'] = $siteUrl . 'data/uploads/' . str_replace('\\', '/', str_replace(USER_DATA_DIR, '', $dir_path)) . $fileName . '.mp4';
		}
		return $files;
	}
}

?>