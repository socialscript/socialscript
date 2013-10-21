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

use models\ModelUsersContent;
use lib\Core\Registry;

class Upload {

	/*
	 * jQuery File Upload Plugin PHP Class 5.9.2
	 * https://github.com/blueimp/jQuery-File-Upload Copyright 2010, Sebastian
	 * Tschan https://blueimp.net Licensed under the MIT license:
	 * http://www.opensource.org/licenses/MIT
	 */
	protected $options;
	function __construct($options = null) {
		$this->Registry = Registry::getInstance();
		$this->FILES = $this->Registry->FILES;
		$dirIterator = new \DirectoryIterator("resources/themes/wn/ui-themes/");
		$this->options = array(
				'script_url' => $this->getFullUrl() . '/index.php?route=users_content&action=delete_pic&',
				'upload_dir' => dirname($_SERVER['SCRIPT_FILENAME']) . '/files/',
				'upload_url' => $this->getFullUrl() . '/files/',
				'param_name' => 'files',
				// Set the following option to 'POST', if your server does not
				// support
				// DELETE requests. This is a parameter sent to the client:
				'delete_type' => 'POST',
				// The php.ini settings upload_max_filesize and post_max_size
				// take precedence over the following max_file_size setting:
				'max_file_size' => null,
				'min_file_size' => 1,
				'accept_file_types' => '/.+$/i',
				'max_number_of_files' => null,
				// Set the following option to false to enable resumable
				// uploads:
				'discard_aborted_uploads' => true,
				// Set to true to rotate images based on EXIF meta data, if
				// available:
				'orient_image' => false,
				'image_versions' => array(
						// Uncomment the following version to restrict the size
						// of
						// uploaded images. You can also add additional versions
						// with
						// their own upload directories:

						'large' => array(
								'upload_dir' => dirname($_SERVER['SCRIPT_FILENAME']) . '/files/',
								'upload_url' => $this->getFullUrl() . '/files/',
								'max_width' => 1920,
								'max_height' => 1200,
								'jpeg_quality' => 95
						),
/*
						'thumbnail' => array(
								'upload_dir' => dirname($_SERVER['SCRIPT_FILENAME']) . '/thumbnails/',
								'upload_url' => $this->getFullUrl() . '/thumbnails/',
								'max_width' => 80,
								'max_height' => 80
						)
						*/
				),
				'pic_name' => '',
				'gallery_id' => '',
				'group_id' => '',
				'type' => '',
				'additional_data' => ''
		);

		if($options) {
			$this->options = array_replace_recursive($this->options, $options);
		}
	}
	protected function getFullUrl() {
		return (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . (isset($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'] . '@' : '') . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'] . (isset($_SERVER['HTTPS']) && $_SERVER['SERVER_PORT'] === 443 || $_SERVER['SERVER_PORT'] === 80 ? '' : ':' . $_SERVER['SERVER_PORT']))) . substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/'));
	}
	protected function set_file_delete_url($file) {
		// $file->delete_url = $this->options['script_url'] . '?file=' .
		// rawurlencode($file->name);
		// $file->delete_type = $this->options['delete_type'];
		// if($file->delete_type !== 'DELETE') {
		// $file->delete_url .= '&_method=DELETE';
		// }
	}
	protected function get_file_object($file_name) {
		// var_dump($file_name);
		$file_path = $this->options['upload_dir'] . $file_name->file_name;
		if(is_file($file_path)) {
			$file = new \stdClass();
			$file->name = $file_name->file_name;
			$file->size = filesize($file_path);
			if($this->options['type'] == 'picture' || $this->options['type'] == 'group_picture') {
				$file->url = $this->options['upload_url'] . rawurlencode($file->name);
			} else {
				$file->url = '';
			}
			foreach($this->options['image_versions'] as $version => $options) {
				if(is_file($options['upload_dir'] . $file_name->file_name)) {
					$file->{$version . '_url'} = $options['upload_url'] . rawurlencode($file->name);
				}
			}
			$file->title = $file_name->title;
			$file->description = $file_name->description;
			$file->tags = $file_name->tags;
			switch ($this->options['type']) {
				case 'video' :
					$file->delete_url = 'index.php?route=users_content&action=delete_video&id=' . $file_name->id . '&g_id=' . $this->options['gallery_id'] . '&rh=' . \helpers\RequestHash::Generate();
					break;
				case 'music' :
					$file->delete_url = 'index.php?route=users_content&action=delete_music&id=' . $file_name->id . '&g_id=' . $this->options['gallery_id'] . '&rh=' . \helpers\RequestHash::Generate();
					break;
				case 'picture' :
					$file->delete_url = 'index.php?route=users_content&action=delete_picture&id=' . $file_name->id . '&g_id=' . $this->options['gallery_id'] . '&rh=' . \helpers\RequestHash::Generate();
					break;
				case 'group_picture' :
					$file->delete_url = 'index.php?route=users_content&action=delete_group_picture&id=' . $file_name->id . '&g_id=' . $this->options['gallery_id'] . '&rh=' . \helpers\RequestHash::Generate();
					break;
				case 'group_video' :
					$file->delete_url = 'index.php?route=users_content&action=delete_group_video&id=' . $file_name->id . '&g_id=' . $this->options['gallery_id'] . '&rh=' . \helpers\RequestHash::Generate();
					break;
				case 'group_music' :
					$file->delete_url = 'index.php?route=users_content&action=delete_group_music&id=' . $file_name->id . '&g_id=' . $this->options['gallery_id'] . '&rh=' . \helpers\RequestHash::Generate();
					break;
			}

			$file->edit_id = $file_name->id;
			$file->gallery_id = $this->options['gallery_id'];
			return $file;
		}
		return null;
	}
	protected function get_file_objects() {

		/*
		 * return array_values(array_filter(array_map(array( $this,
		 * 'get_file_object' ), scandir($this->options['upload_dir']))));
		 */

		switch ($this->options['type']) {
			case 'video' :
				return array_values(array_filter(array_map(array(
						$this,
						'get_file_object'
				), (new ModelUsersContent() )->getVideosByGallery(array(
						$this->options['gallery_id']
				)))));
				break;
			case 'music' :
				return array_values(array_filter(array_map(array(
						$this,
						'get_file_object'
				), (new ModelUsersContent() )->getMusicByGallery(array(
						$this->options['gallery_id']
				)))));
				break;
			case 'picture' :
				return array_values(array_filter(array_map(array(
						$this,
						'get_file_object'
				), (new ModelUsersContent() )->getPicturesByGallery(array(
						$this->options['gallery_id']
				)))));
				break;
			case 'group_picture' :
				return array_values(array_filter(array_map(array(
						$this,
						'get_file_object'
				), (new ModelUsersContent() )->getGroupPicturesByGallery(array(
						$this->options['gallery_id']
				)))));
				break;
			case 'group_video' :
				return array_values(array_filter(array_map(array(
						$this,
						'get_file_object'
				), (new ModelUsersContent() )->getGroupVideosByGallery(array(
						$this->options['gallery_id']
				)))));
				break;
			case 'group_music' :
				return array_values(array_filter(array_map(array(
						$this,
						'get_file_object'
				), (new ModelUsersContent() )->getGroupMusicByGallery(array(
						$this->options['gallery_id']
				)))));
				break;
		}
	}
	protected function create_scaled_image($file_name, $options) {
		$file_path = $this->options['upload_dir'] . $file_name;
		$new_file_path = $options['upload_dir'] . $file_name;
		list($img_width, $img_height) = @getimagesize($file_path);
		if(! $img_width || ! $img_height) {
			return false;
		}
		$scale = min($options['max_width'] / $img_width, $options['max_height'] / $img_height);
		if($scale >= 1) {
			if($file_path !== $new_file_path) {
				return copy($file_path, $new_file_path);
			}
			return true;
		}
		$new_width = $img_width * $scale;
		$new_height = $img_height * $scale;
		$new_img = @imagecreatetruecolor($new_width, $new_height);
		switch (strtolower(substr(strrchr($file_name, '.'), 1))) {
			case 'jpg' :
			case 'jpeg' :
				$src_img = @imagecreatefromjpeg($file_path);
				$write_image = 'imagejpeg';
				$image_quality = isset($options['jpeg_quality']) ? $options['jpeg_quality'] : 75;
				break;
			case 'gif' :
				@imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
				$src_img = @imagecreatefromgif($file_path);
				$write_image = 'imagegif';
				$image_quality = null;
				break;
			case 'png' :
				@imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
				@imagealphablending($new_img, false);
				@imagesavealpha($new_img, true);
				$src_img = @imagecreatefrompng($file_path);
				$write_image = 'imagepng';
				$image_quality = isset($options['png_quality']) ? $options['png_quality'] : 9;
				break;
			default :
				$src_img = null;
		}
		$success = $src_img && @imagecopyresampled($new_img, $src_img, 0, 0, 0, 0, $new_width, $new_height, $img_width, $img_height) && $write_image($new_img, $new_file_path, $image_quality);
		// Free up memory (imagedestroy does not delete files):
		@imagedestroy($src_img);
		@imagedestroy($new_img);
		return $success;
	}
	protected function has_error($uploaded_file, $file, $error) {
		// var_dump($this->FILES);
		// p($this->FILES['files']['name'][0]);
		if($error) {
			return $error;
		}
		// p($this->options['accept_file_types']);
		// p($file->name);
		// var_dump(preg_match($this->options['accept_file_types'],
		// $file->name));
		if(! preg_match($this->options['accept_file_types'], $this->FILES['files']['name'][0])) {
			return 'acceptFileTypes';
		}
		if($uploaded_file && is_uploaded_file($uploaded_file)) {
			$file_size = filesize($uploaded_file);
		} else {
			$file_size = $_SERVER['CONTENT_LENGTH'];
		}
		if($this->options['max_file_size'] && ($file_size > $this->options['max_file_size'] || $file->size > $this->options['max_file_size'])) {
			return 'maxFileSize';
		}
		if($this->options['min_file_size'] && $file_size < $this->options['min_file_size']) {
			return 'minFileSize';
		}
		if(is_int($this->options['max_number_of_files']) && (count($this->get_file_objects()) >= $this->options['max_number_of_files'])) {
			return 'maxNumberOfFiles';
		}
		return $error;
	}
	protected function upcount_name_callback($matches) {
		$index = isset($matches[1]) ? intval($matches[1]) + 1 : 1;
		$ext = isset($matches[2]) ? $matches[2] : '';
		return ' (' . $index . ')' . $ext;
	}
	protected function upcount_name($name) {
		return preg_replace_callback('/(?:(?: \(([\d]+)\))?(\.[^.]+))?$/', array(
				$this,
				'upcount_name_callback'
		), $name, 1);
	}
	protected function trim_file_name($name, $type) {
		// Remove path information and dots around the filename, to prevent
		// uploading
		// into different directories or replacing hidden system files.
		// Also remove control characters and spaces (\x00..\x20) around the
		// filename:
		$file_name = trim(basename(stripslashes($name)), ".\x00..\x20");
		// Add missing file extension for known image types:
		if(strpos($file_name, '.') === false && preg_match('/^image\/(gif|jpe?g|png)/', $type, $matches)) {
			$file_name .= '.' . $matches[1];
		}
		if($this->options['discard_aborted_uploads']) {
			while ( is_file($this->options['upload_dir'] . $file_name) ) {
				$file_name = $this->upcount_name($file_name);
			}
		}
		return $file_name;
	}
	protected function orient_image($file_path) {
		$exif = @exif_read_data($file_path);
		if($exif === false) {
			return false;
		}
		$orientation = intval(@$exif['Orientation']);
		if(! in_array($orientation, array(
				3,
				6,
				8
		))) {
			return false;
		}
		$image = @imagecreatefromjpeg($file_path);
		switch ($orientation) {
			case 3 :
				$image = @imagerotate($image, 180, 0);
				break;
			case 6 :
				$image = @imagerotate($image, 270, 0);
				break;
			case 8 :
				$image = @imagerotate($image, 90, 0);
				break;
			default :
				return false;
		}
		$success = imagejpeg($image, $file_path);
		// Free up memory (imagedestroy does not delete files):
		@imagedestroy($image);
		return $success;
	}
	protected function handle_file_upload($uploaded_file, $name, $size, $type, $error) {
		$file = new \stdClass();
		$file->name = $this->trim_file_name($name, $type);
		$file->size = intval($size);
		$file->type = $type;
		$error = $this->has_error($uploaded_file, $file, $error);
		if(! $error && $file->name) {
			$file_path = $this->options['upload_dir'] . $file->name;
			$append_file = ! $this->options['discard_aborted_uploads'] && is_file($file_path) && $file->size > filesize($file_path);
			clearstatcache();
			if($uploaded_file && is_uploaded_file($uploaded_file)) {
				// multipart/formdata uploads (POST method uploads)
				if($append_file) {
					file_put_contents($file_path, fopen($uploaded_file, 'r'), FILE_APPEND);
				} else {
					if($this->options['type'] == 'picture') {
						$this->last_id = (new ModelUsersContent() )->insertPic(array(
								$this->options['gallery_id'],
								$file->name,
								$this->options['additional_data']['title_'.str_replace(array(' ','.'),array('','_'),$this->FILES['files']['name'][0])],
								$this->options['additional_data']['description_'.str_replace(array(' ','.'),array('','_'),$this->FILES['files']['name'][0])],
								$this->options['additional_data']['tags_'.str_replace(array(' ','.'),array('','_'),$this->FILES['files']['name'][0])],
								time()
						));
					} elseif($this->options['type'] == 'group') {
						$this->last_id = (new ModelUsersContent() )->insertGroupPic(array(
								$this->options['group_id'],
								$file->name,
								''
						));
					} elseif($this->options['type'] == 'music') {
						$this->last_id = (new ModelUsersContent() )->insertMusic(array(
								$this->options['gallery_id'],
								substr($file->name, 0, strrpos($file->name, '.')),
								$this->options['additional_data']['title_'.str_replace(array(' ','.'),array('','_'),$this->FILES['files']['name'][0])],
								$this->options['additional_data']['description_'.str_replace(array(' ','.'),array('','_'),$this->FILES['files']['name'][0])],
								$this->options['additional_data']['tags_'.str_replace(array(' ','.'),array('','_'),$this->FILES['files']['name'][0])],
								time()
						));
					} elseif($this->options['type'] == 'video') {
						$this->last_id = (new ModelUsersContent() )->insertVideo(array(
								$this->options['gallery_id'],
								substr($file->name, 0, strrpos($file->name, '.')),
								$this->options['additional_data']['title_'.str_replace(array(' ','.'),array('','_'),$this->FILES['files']['name'][0])],
								$this->options['additional_data']['description_'.str_replace(array(' ','.'),array('','_'),$this->FILES['files']['name'][0])],
								$this->options['additional_data']['tags_'.str_replace(array(' ','.'),array('','_'),$this->FILES['files']['name'][0])],
								time()
						));
					} elseif($this->options['type'] == 'group_picture') {
						$this->last_id = (new ModelUsersContent() )->insertGroupPic(array(
								$this->options['gallery_id'],
								$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
								$file->name,
								$this->options['additional_data']['title_'.str_replace(array(' ','.'),array('','_'),$this->FILES['files']['name'][0])],
								$this->options['additional_data']['description_'.str_replace(array(' ','.'),array('','_'),$this->FILES['files']['name'][0])],
								$this->options['additional_data']['tags_'.str_replace(array(' ','.'),array('','_'),$this->FILES['files']['name'][0])],
								time()
						));
					} elseif($this->options['type'] == 'group_video') {
						$this->last_id = (new ModelUsersContent() )->insertGroupVideo(array(
								$this->options['gallery_id'],
								$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
								substr($file->name, 0, strrpos($file->name, '.')),
								$this->options['additional_data']['title_'.str_replace(array(' ','.'),array('','_'),$this->FILES['files']['name'][0])],
								$this->options['additional_data']['description_'.str_replace(array(' ','.'),array('','_'),$this->FILES['files']['name'][0])],
								$this->options['additional_data']['tags_'.str_replace(array(' ','.'),array('','_'),$this->FILES['files']['name'][0])],
								time()
						));
					} elseif($this->options['type'] == 'group_music') {
						$this->last_id = (new ModelUsersContent() )->insertGroupMusic(array(
								$this->options['gallery_id'],
								$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
								substr($file->name, 0, strrpos($file->name, '.')),
								$this->options['additional_data']['title_'.str_replace(array(' ','.'),array('','_'),$this->FILES['files']['name'][0])],
								$this->options['additional_data']['description_'.str_replace(array(' ','.'),array('','_'),$this->FILES['files']['name'][0])],
								$this->options['additional_data']['tags_'.str_replace(array(' ','.'),array('','_'),$this->FILES['files']['name'][0])],
								time()
						));
					}
					move_uploaded_file($uploaded_file, $file_path);
				}
			} else {
				// Non-multipart uploads (PUT method support)
				// file_put_contents($file_path, fopen('php://input', 'r'),
				// $append_file ? FILE_APPEND : 0);
			}
			$file_size = filesize($file_path);
			if($file_size === $file->size) {
				if($this->options['orient_image']) {
					$this->orient_image($file_path);
				}
				if($this->options['type'] == 'picture' || $this->options['type'] == 'group_picture') {
					$file->url = $this->options['upload_url'] . rawurlencode($file->name);
				} else {
					$file->url = '';
				}
				foreach($this->options['image_versions'] as $version => $options) {
					if($this->create_scaled_image($file->name, $options)) {
						if($this->options['upload_dir'] !== $options['upload_dir']) {
							$file->{$version . '_url'} = $options['upload_url'] . rawurlencode($file->name);
						} else {
							clearstatcache();
							$file_size = filesize($file_path);
						}
					}
				}

				switch ($this->options['type']) {
					case 'video' :
						$file = (new ModelUsersContent() )->getVideo(array(
								$this->last_id,
								$this->options['gallery_id']
						));
						$file->file_name = $file->file_name . '.mp4';
						break;
					case 'music' :
						$file = (new ModelUsersContent() )->getMusic(array(
								$this->last_id,
								$this->options['gallery_id']
						));
						$file->file_name = $file->file_name . '.mp3';
						break;
					case 'picture' :
						$file = (new ModelUsersContent() )->getPicture(array(
								$this->last_id,
								$this->options['gallery_id']
						));
						break;
					case 'group_picture' :
						$file = (new ModelUsersContent() )->getGroupPicture(array(
								$this->last_id,
								$this->options['gallery_id']
						));
						break;
					case 'group_video' :
						$file = (new ModelUsersContent() )->getGroupVideo(array(
								$this->last_id,
								$this->options['gallery_id']
						));
						$file->file_name = $file->file_name . '.mp4';
						break;
					case 'group_music' :
						$file = (new ModelUsersContent() )->getGroupMusic(array(
								$this->last_id,
								$this->options['gallery_id']
						));
						$file->file_name = $file->file_name . '.mp4';
						break;
				}
			} else if($this->options['discard_aborted_uploads']) {
				unlink($file_path);
				$file->error = 'abort';
			}
			$file->size = $file_size;
			$this->set_file_delete_url($file);
		} else {
			$file->error = $error;
			echo '[' . json_encode($file) . ']';
			exit();
		}

		$info = $this->get_file_object($file);

		header('Content-type: application/json');
		echo '[' . json_encode($info) . ']';
		exit();
	}
	public function get() {
		$file_name = isset($_REQUEST['file']) ? basename(stripslashes($_REQUEST['file'])) : null;
		if($file_name) {
			switch ($this->options['type']) {
				case 'video' :
					$file = (new ModelUsersContent() )->getVideo(array(
							$this->last_id,
							$this->options['gallery_id']
					));
					break;
				case 'music' :
					$file = (new ModelUsersContent() )->getMusic(array(
							$this->last_id,
							$this->options['gallery_id']
					));
					break;
				case 'picture' :
					$file = (new ModelUsersContent() )->getPicture(array(
							$this->last_id,
							$this->options['gallery_id']
					));
					break;
				case 'group_picture' :
					$file = (new ModelUsersContent() )->getGroupPicture(array(
							$this->last_id,
							$this->options['gallery_id']
					));
					break;
				case 'group_video' :
					$file = (new ModelUsersContent() )->getGroupVideo(array(
							$this->last_id,
							$this->options['gallery_id']
					));
					break;
				case 'group_music' :
					$file = (new ModelUsersContent() )->getGroupMusic(array(
							$this->last_id,
							$this->options['gallery_id']
					));
					break;
			}
			$info = $this->get_file_object($file);
		} else {
			$info = $this->get_file_objects();
		}
		header('Content-type: application/json');
		echo json_encode($info);
	}
	public function post() {
		$upload = isset($this->FILES[$this->options['param_name']]) ? $this->FILES[$this->options['param_name']] : null;
		$info = array();

		if($upload && is_array($upload['tmp_name'])) {
			// param_name is an array identifier like "files[]",
			// $this->FILES is a multi-dimensional array:
			foreach($upload['tmp_name'] as $index => $value) {
				$info[] = $this->handle_file_upload($upload['tmp_name'][$index], isset($_SERVER['HTTP_X_FILE_NAME']) ? $_SERVER['HTTP_X_FILE_NAME'] : $this->options['pic_name'], isset($_SERVER['HTTP_X_FILE_SIZE']) ? $_SERVER['HTTP_X_FILE_SIZE'] : $upload['size'][$index], isset($_SERVER['HTTP_X_FILE_TYPE']) ? $_SERVER['HTTP_X_FILE_TYPE'] : $upload['type'][$index], $upload['error'][$index]);
			}
		} elseif($upload || isset($_SERVER['HTTP_X_FILE_NAME'])) {
			// param_name is a single object identifier like "file",
			// $this->FILES is a one-dimensional array:
			$info[] = $this->handle_file_upload(isset($upload['tmp_name']) ? $upload['tmp_name'] : null, isset($_SERVER['HTTP_X_FILE_NAME']) ? $_SERVER['HTTP_X_FILE_NAME'] : (isset($upload['name']) ? $upload['name'] : null), isset($_SERVER['HTTP_X_FILE_SIZE']) ? $_SERVER['HTTP_X_FILE_SIZE'] : (isset($upload['size']) ? $upload['size'] : null), isset($_SERVER['HTTP_X_FILE_TYPE']) ? $_SERVER['HTTP_X_FILE_TYPE'] : (isset($upload['type']) ? $upload['type'] : null), isset($upload['error']) ? $upload['error'] : null);
		}

		header('Vary: Accept');
		$json = json_encode($info);
		$redirect = isset($_REQUEST['redirect']) ? stripslashes($_REQUEST['redirect']) : null;
		if($redirect) {
			header('Location: ' . sprintf($redirect, rawurlencode($json)));
			return;
		}
		if(isset($_SERVER['HTTP_ACCEPT']) && (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
			header('Content-type: application/json');
		} else {
			header('Content-type: text/plain');
		}
		echo $json;
	}
	public function delete() {
		$file_name = isset($_REQUEST['file']) ? basename(stripslashes($_REQUEST['file'])) : null;
		$file_path = $this->options['upload_dir'] . $file_name;
		$success = is_file($file_path) && $file_name[0] !== '.' && unlink($file_path);
		if($success) {
			foreach($this->options['image_versions'] as $version => $options) {
				$file = $options['upload_dir'] . $file_name;
				if(is_file($file)) {
					unlink($file);
				}
			}
		}
		header('Content-type: application/json');
		echo json_encode($success);
	}
}

?>