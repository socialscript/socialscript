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

use \lib\Core\Registry;

class Encoder {
	function __construct() {
		$this->Registry = Registry::getInstance();
		$this->table_prefix = $this->Registry->table_prefix;
		$this->DB = $this->Registry->DB;
	}
	function getVideoEncodingSettings() {
		$result = $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT id,name,value FROM ' . $this->Registry->table_prefix . '_encode_settings');
		$this->encodeSettings = new \stdClass();
		foreach($result as $k => $v) {
			$id = strtolower(str_replace(' ', '_', $v->name));
			$this->encodeSettings->$id = $v->value;
		}
	}
	function Run() {
		self::getVideoEncodingSettings();
		self::checkRunningProcesses();
		if(count($this->processes) < 1) {
			self::encodeVideo();
			self::encodeAudio();
		}
	}
	function encodeVideo() {
		$this->video_to_encode = $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->table_prefix . '_videos
				 					WHERE encode_status="pending" ORDER BY id ASC LIMIT 1');

		if(isset($this->video_to_encode[0])) {
			$this->video = $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setPreparedValues(array(
					$this->video_to_encode[0]->id
			))->setFetchMode('FETCH_OBJ')->executeQuery('SELECT  ' . $this->table_prefix . '_videos.*,' . $this->table_prefix . '_users.username,' . $this->table_prefix . '_users.user_key,' . $this->table_prefix . '_videos_galleries.gallery_name FROM ' . $this->table_prefix . '_videos
				LEFT JOIN ' . $this->table_prefix . '_videos_galleries
				ON ' . $this->table_prefix . '_videos.gallery_id=' . $this->table_prefix . '_videos_galleries.id
			 		LEFT JOIN ' . $this->table_prefix . '_users
			 			ON ' . $this->table_prefix . '_videos_galleries.user_key=' . $this->table_prefix . '_users.user_key
					 WHERE
				' . $this->table_prefix . '_videos.id=?')[0];
			$this->videoPath = USER_DATA_DIR . $this->video->user_key . DIRECTORY_SEPARATOR . 'videos' . DIRECTORY_SEPARATOR . md5($this->video->gallery_name) . DIRECTORY_SEPARATOR . $this->video->file_name;
			$this->videoPath = $this->videoPath . '.mp4';
			if(is_file($this->videoPath)) {
				$this->outputFileName = md5($this->video->gallery_name . $this->video->user_key . $this->video->id . time());
				$this->outputFile = USER_DATA_DIR . $this->video->user_key . DIRECTORY_SEPARATOR . 'videos' . DIRECTORY_SEPARATOR . md5($this->video->gallery_name) . DIRECTORY_SEPARATOR . $this->outputFileName;
				//self::encodeVideoOgg();
				//self::encodeVideoWebm();
				self::encodeVideoMp4();
				self::generateThumbnail();
				$this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues(array(
						$this->outputFileName,
						$this->video->id
				))->executeQuery('UPDATE ' . $this->table_prefix . '_videos SET file_name=?,encode_status="completed" WHERE id = ? ');
			//unlink($this->videoPath);
			} else {
				// self::Run();
			}
		} else {
			// exit();
		}
	}
	function encodeAudio() {
		$this->video_to_encode = $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->table_prefix . '_music_files
				 					WHERE encode_status="pending" ORDER BY id ASC LIMIT 1');

		if(isset($this->video_to_encode[0])) {
			$this->music = $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setPreparedValues(array(
					$this->video_to_encode[0]->id
			))->setFetchMode('FETCH_OBJ')->executeQuery('SELECT  ' . $this->table_prefix . '_music_files.*,' . $this->table_prefix . '_users.username,' . $this->table_prefix . '_users.user_key,' . $this->table_prefix . '_music_galleries.gallery_name FROM ' . $this->table_prefix . '_music_files
				LEFT JOIN ' . $this->table_prefix . '_music_galleries
				ON ' . $this->table_prefix . '_music_files.gallery_id=' . $this->table_prefix . '_music_galleries.id
			 		LEFT JOIN ' . $this->table_prefix . '_users
			 			ON ' . $this->table_prefix . '_music_galleries.user_key=' . $this->table_prefix . '_users.user_key
					 WHERE
				' . $this->table_prefix . '_music_files.id=?')[0];

			$this->musicPath = USER_DATA_DIR . $this->music->user_key . DIRECTORY_SEPARATOR . 'music' . DIRECTORY_SEPARATOR . md5($this->music->gallery_name) . DIRECTORY_SEPARATOR . $this->music->file_name;
			$this->musicPath = $this->musicPath . '.mp3';
			if(is_file($this->musicPath)) {

				$this->outputFileName = md5($this->music->gallery_name . $this->music->user_key . $this->music->id . time());
				$this->outputFile = USER_DATA_DIR . $this->music->user_key . DIRECTORY_SEPARATOR . 'music' . DIRECTORY_SEPARATOR . md5($this->music->gallery_name) . DIRECTORY_SEPARATOR . $this->outputFileName;
				// p($this->outputFile);
			//	self::encodeMusicOgg();
				//self::encodeMusicMp3();
				self::encodeMusicMp4();
				$this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues(array(
						$this->outputFileName,
						$this->music->id
				))->executeQuery('UPDATE ' . $this->table_prefix . '_music_files SET file_name=?,encode_status="completed" WHERE id = ? ');
				unlink($this->musicPath);
			} else {
				// self::Run();
			}
		} else {
			// exit();
		}
	}
	function encodeVideoOgg() {
		$this->Command = $this->encodeSettings->ffmpeg_path . ' -i ' . $this->videoPath . '  -acodec libvorbis -ac 2 -ab ' . $this->encodeSettings->video_ogv_audio_bitrate . 'k -ar 44100 -b ' . $this->encodeSettings->video_ogv_video_bitrate . 'k -s ' . $this->encodeSettings->video_ogv_resolution . '   ' . $this->outputFile . '.ogv';
		// p($this->Command);
		exec($this->Command);
	}
	function encodeVideoWebm() {
		$this->Command = $this->encodeSettings->ffmpeg_path . ' -i ' . $this->videoPath . '  -acodec libvorbis -ac 2 -ab ' . $this->encodeSettings->video_webm_audio_bitrate . 'k -ar 44100 -b ' . $this->encodeSettings->video_webm_video_bitrate . 'k -s ' . $this->encodeSettings->video_webm_resolution . ' ' . $this->outputFile . '.webm';
		// p($this->Command);
		exec($this->Command);
	}
	function encodeVideoMp4() {
		$this->Command = $this->encodeSettings->ffmpeg_path . ' -i ' . $this->videoPath . '   -acodec libfaac -ab ' . $this->encodeSettings->video_mp4_audio_bitrate . 'k -ac 2 -ar 22050 -vcodec libx264  -vpre default  -b ' . $this->encodeSettings->video_mp4_video_bitrate . 'k -s ' . $this->encodeSettings->video_mp4_resolution . ' ' . $this->outputFile . '.mp4';
		p($this->Command);
		exec($this->Command);
	}
	function generateThumbnail() {
		$this->Command = $this->encodeSettings->ffmpeg_path . ' -i ' . $this->videoPath . ' -s ' . $this->encodeSettings->video_thumbnail_width . 'x' . $this->encodeSettings->video_thumbnail_height . ' -r 1 -ss 00:00:01 -t 00:00:01 ' . $this->outputFile . '.jpg';
		p($this->Command);
		exec($this->Command);
	}
	function encodeMusicOgg() {
		$this->Command = $this->encodeSettings->ffmpeg_path . ' -i ' . $this->musicPath . '  -acodec vorbis -strict experimental -aq ' . $this->encodeSettings->audio_ogg_audio_bitrate . ' ' . $this->outputFile . '.ogg';
		p($this->Command);
		exec($this->Command);
	}
	function encodeMusicMp3() {
		$this->Command = $this->encodeSettings->ffmpeg_path . ' -i ' . $this->musicPath . '  -acodec libmp3lame -ab ' . $this->encodeSettings->audio_mp3_audio_bitrate . 'k ' . $this->outputFile . '.mp3';
		p($this->Command);
		exec($this->Command);
	}
	function encodeMusicMp4() {
		$this->Command = $this->encodeSettings->ffmpeg_path . ' -i ' . $this->musicPath . '  -acodec libfaac -ab ' . $this->encodeSettings->audio_mp3_audio_bitrate . 'k ' . $this->outputFile . '.mp4';
		p($this->Command);
		exec($this->Command);
	}
	function checkEmptyValue($processes) {
		foreach($processes as $k => $v) {
			if($v == '') {
				unset($processes[$k]);
			}
		}
		return $processes;
	}
	function checkRunningProcesses() {
		$processes = `ps aux r | grep ffmpeg`;

		$processes = explode("\n", $processes);
		$this->processes = self::checkEmptyValue($processes);
	}
}

?>