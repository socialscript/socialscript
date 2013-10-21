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

class UserVideo {
	function __construct() {
	}

	static function getVideoFile($siteUrl,$video)
	{

		$video_dir_path = $video->user_key . DIRECTORY_SEPARATOR . 'videos' . DIRECTORY_SEPARATOR . md5($video->gallery_name) . DIRECTORY_SEPARATOR;
		$dir_path = USER_DATA_DIR . $video_dir_path;
		$file = '';
		//p($dir_path . $video->file_name . '.mp4');
		if(is_file($dir_path . $video->file_name . '.mp4')) {
			//p($dir_path . $video->file_name . '.mp4');
			$file =   $siteUrl . 'data/uploads/' . str_replace('\\', '/', $video_dir_path) . $video->file_name . '.mp4';
		}
		return $file;
	}
	static function getVideoPlaylist($siteUrl,$video, $sameUserVideos, $sameGalleryVideos, $relatedVideos) {
		$playlist = '<?xml version="1.0" encoding="UTF-8"?><videos width="600" height="300">';

/*

		if(count($sameUserVideos) > 0) {
			foreach($sameUserVideos as $k => $v) {
				$video_dir_path = $v->user_key . DIRECTORY_SEPARATOR . 'videos' . DIRECTORY_SEPARATOR . md5($v->gallery_name) . DIRECTORY_SEPARATOR;
				$dir_path = USER_DATA_DIR . $video_dir_path;
				$playlist .= '<same_user_item>
		<title>' . $v->title . '</title>';
			//	p($dir_path . $v->file_name);
				if(is_file($dir_path . $v->file_name . '.mp4')) {
					//p($dir_path . $v->file_name . '.mp4');
					$playlist .= '<mp4>' . $siteUrl . 'data/uploads/' . str_replace('\\', '/', $video_dir_path) . $v->file_name . '.mp4</mp4>';
				}
				if(is_file($dir_path . $v->file_name . '.ogv')) {
					$playlist .= '<ogv>' . $siteUrl . 'data/uploads/' . str_replace('\\', '/', $video_dir_path) . $v->file_name . '.ogv</ogv>';
					//p($dir_path . $v->file_name . '.ogv');
				}
				if(is_file($dir_path . $v->file_name . '.webm')) {
					//p($dir_path . $v->file_name . '.webm');
					$playlist .= '<webm>' . $siteUrl . 'data/uploads/' . str_replace('\\', '/', $video_dir_path) . $v->file_name . '.webm</webm>';
				}
				$playlist .= '
		<description><br />Tags: ' . $v->tags . '<br />' . $v->description . '</description>
	</same_user_item>';
			}
		}
		*/
		if(count($sameGalleryVideos) > 0) {
			foreach($sameGalleryVideos as $k => $v) {
				$video_dir_path = $v->user_key . DIRECTORY_SEPARATOR . 'videos' . DIRECTORY_SEPARATOR . md5($v->gallery_name) . DIRECTORY_SEPARATOR;
				$dir_path = USER_DATA_DIR . $video_dir_path;

				$playlist .= '<same_gallery_item>
		<title>' . $v->title . '</title>';
				if(is_file($dir_path . $v->file_name . '.mp4')) {
					$playlist .= '<mp4>' . $siteUrl . 'data/uploads/' . str_replace('\\', '/', $video_dir_path) . $v->file_name . '.mp4</mp4>';
				}
				if(is_file($dir_path . $v->file_name . '.ogv')) {
					$playlist .= '<ogv>' . $siteUrl . 'data/uploads/' . str_replace('\\', '/', $video_dir_path) . $v->file_name . '.ogv</ogv>';
				}
				if(is_file($dir_path . $v->file_name . '.webm')) {
					$playlist .= '<webm>' . $siteUrl . 'data/uploads/' . str_replace('\\', '/', $video_dir_path) . $v->file_name . '.webm</webm>';
				}
				$playlist .= '
						<id>'. $v->id . '</id>
		<description><br />Tags: ' . $v->tags . '<br />' . $v->description . '</description>
	</same_gallery_item>';
			}
		}

		if(count($relatedVideos) > 0) {
			foreach($relatedVideos as $k => $v) {
				$video_dir_path = $v->user_key . DIRECTORY_SEPARATOR . 'videos' . DIRECTORY_SEPARATOR . md5($v->gallery_name) . DIRECTORY_SEPARATOR;
				$dir_path = USER_DATA_DIR . $video_dir_path;

				$playlist .= '<related_item>
		<title>' . $v->title . '</title>';
				if(is_file($dir_path . $v->file_name . '.mp4')) {
					$playlist .= '<mp4>' . $siteUrl . 'data/uploads/' . str_replace('\\', '/', $video_dir_path) . $v->file_name . '.mp4</mp4>';
				}
				if(is_file($dir_path . $v->file_name . '.ogv')) {
					$playlist .= '<ogv>' . $siteUrl . 'data/uploads/' . str_replace('\\', '/', $video_dir_path) . $v->file_name . '.ogv</ogv>';
				}
				if(is_file($dir_path . $v->file_name . '.webm')) {
					$playlist .= '<webm>' . $siteUrl . 'data/uploads/' . str_replace('\\', '/', $video_dir_path) . $v->file_name . '.webm</webm>';
				}
				$playlist .= '
							<id>'. $v->id . '</id>
		<description><br />Tags: ' . $v->tags . '<br />' . $v->description . '</description>
	</related_item>';
			}
		}
		// $playlist .= '</videos>';
		return preg_replace("/\s\s+/", " ", $playlist);
	}
	static function getVideoThumb($userKey, $galleryName, $fileName, $Width, $Height) {
		$video_dir_path = $userKey . DIRECTORY_SEPARATOR . 'videos' . DIRECTORY_SEPARATOR . md5($galleryName) . DIRECTORY_SEPARATOR;
		$dir_path = USER_DATA_DIR . $video_dir_path;

		if(is_file($dir_path . $fileName . '.jpg')) {
			return '<img src="' . SITE_URL . 'image.php?src=' . str_replace(USER_DATA_DIR, '', $dir_path) . $fileName . '.jpg' . '&w=' . $Width . '&h=' . $Height . '&aoe=1" class="img-rounded">';
		} else {
			return '<img src="' . SITE_URL . 'image.php?src=../../resources/images/video_thumb.jpg&w=' . $Width . '&h=' . $Height . '&aoe=1&zc=1" class="img-rounded">';
		}
	}
	static function getGroupVideoFiles($siteUrl, $groupName, $fileName) {
		$files = array();
		$dir_path = USER_DATA_DIR . 'groups' . DIRECTORY_SEPARATOR . $groupName . DIRECTORY_SEPARATOR . 'videos' . DIRECTORY_SEPARATOR;
		// p($dir_path);
		if(is_file($dir_path . $fileName . '.mp4')) {
			$files[0]['type'] = 'video/mp4';
			$files[0]['file'] = $siteUrl . 'data/uploads/' . str_replace('\\', '/', str_replace(USER_DATA_DIR, '', $dir_path)) . $fileName . '.mp4';
		}
		if(is_file($dir_path . $fileName . '.ogv')) {
			$files[0]['type'] = 'video/ogv';
			$files[0]['file'] = $siteUrl . 'data/uploads/' . str_replace('\\', '/', str_replace(USER_DATA_DIR, '', $dir_path)) . $fileName . '.ogv';
		}
		if(is_file($dir_path . $fileName . '.webm')) {
			$files[0]['type'] = 'video/webm';
			$files[0]['file'] = $siteUrl . 'data/uploads/' . str_replace('\\', '/', str_replace(USER_DATA_DIR, '', $dir_path)) . $fileName . '.webm';
		}

		return $files;
	}
	static function getGroupVideoThumb($groupName, $fileName, $Width, $Height) {
		$dir_path = USER_DATA_DIR . 'groups' . DIRECTORY_SEPARATOR . $groupName . DIRECTORY_SEPARATOR . 'videos' . DIRECTORY_SEPARATOR;
		if(is_file($dir_path . $fileName . '.jpg')) {
			return '<img src="' . SITE_URL . 'image.php?src=' . INSTALLATION_DIR . str_replace(USER_DATA_DIR, '', $dir_path) . $fileName . '.jpg' . '&w=' . $Width . '&h=' . $Height . '&aoe=1&zc=1" class="img-rounded">';
		} else {
			return '';
		}
	}
}

?>