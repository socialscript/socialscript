<?php

namespace controllers;

use lib\Core\Registry;
use models\ModelIndex;
use models\ModelAjax;
use helpers\RequestHash;
use lib\PasswordEncryption\PasswordEncryption;
use lib\Core\Controller;
use helpers\Utils;

class UsersContent extends Controller {
	function __construct() {
		parent::__construct();
		$this->Registry = Registry::getInstance();
		(new \SplAutoloader('models', array()) )->register();

		$model = 'models\Model' . $this->Registry->controllerName;
		$this->model = new $model();
	}
	function uploadPictures() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		if(! isset($this->GET['gallery'])) {
			exit();
		}
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		$gallery_name = md5($this->model->getPicturesGalleryUpload($this->GET['gallery'])->gallery_name);

		$upload_handler = new \classes\Upload(array(
				'script_url' => 'index.php?route=users_content&action=delete_pic&gallery=' . $gallery_name . '&',
				'upload_dir' => USER_DATA_DIR . $_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key . '/photos/' . $gallery_name . '/',
				'upload_url' => 'image.php?aoe=1&w=' . $this->Registry->user_pictures_settings->thumbnail_width . '&h=' . $this->Registry->user_pictures_settings->thumbnail_height . '&src=' . $_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key . '/photos/' . $gallery_name . '/',
				'max_file_size' => $this->Registry->user_pictures_settings->maximum_file_size,
				'max_number_of_files' => $this->Registry->user_pictures_settings->maximum_number_of_files,
				'accept_file_types' => '/.(' . str_replace(',', '|', $this->Registry->user_pictures_settings->photo_formats_accepted) . ')$/i',
				'image_versions' => array(
						'large' => array(
								'upload_dir' => USER_DATA_DIR . $_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key . '/photos/' . $gallery_name . '/',
								'upload_url' => 'index.php?route=users_content&action=get_image_large',
								'max_width' => $this->Registry->user_pictures_settings->large_image_width,
								'max_height' => $this->Registry->user_pictures_settings->large_image_height
						)
				),
				'pic_name' => ($this->model->getLatestPic(array(
						$this->GET['gallery']
				)) + 1) . '.jpg',
				'gallery_id' => $this->GET['gallery'],
				'type' => 'picture',
				'additional_data' => $this->POST
		));

		header('Pragma: no-cache');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Content-Disposition: inline; filename="files.json"');
		header('X-Content-Type-Options: nosniff');
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT, DELETE');
		header('Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size');

		switch ($_SERVER['REQUEST_METHOD']) {

			case 'GET' :
				$upload_handler->get();
				break;
			case 'POST' :

				$upload_handler->post();
				break;

			default :
				header('HTTP/1.1 405 Method Not Allowed');
		}
	}
	function uploadGroupPictures() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		if(! isset($this->GET['group'])) {
			exit();
		}

		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}

		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		$group = $this->model->getGroup(array(
				$this->GET['group']
		));
		if((new \models\ModelUsersInteraction() )->checkIfGroupMember(array(
				$this->GET['group'],
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		)) < 1 && ($group->privacy == 2 || $group->privacy == 3)) {

			echo 'not a group member';

			exit();
		}
		$group_name = md5($group->group_name);

		$upload_handler = new \classes\Upload(array(
				'script_url' => 'index.php?route=users_content&action=delete_group_pic&gallery=' . $group_name . '&',
				'upload_dir' => USER_DATA_DIR . 'groups/' . $group_name . '/photos/',
				'upload_url' => 'image.php?aoe=1&w=' . $this->Registry->user_pictures_settings->thumbnail_width . '&h=' . $this->Registry->user_pictures_settings->thumbnail_height . '&src=' . 'groups/' . $group_name . '/photos/',
				'max_file_size' => $this->Registry->user_pictures_settings->maximum_file_size,
				'max_number_of_files' => $this->Registry->user_pictures_settings->maximum_number_of_files,
				'accept_file_types' => '/.(' . str_replace(',', '|', $this->Registry->user_pictures_settings->photo_formats_accepted) . ')$/i',
				'image_versions' => array(
						'large' => array(
								'upload_dir' => USER_DATA_DIR . 'groups/' . $group_name . '/photos/',
								'upload_url' => 'index.php?route=users_content&action=get_group_image_large',
								'max_width' => $this->Registry->user_pictures_settings->large_image_width,
								'max_height' => $this->Registry->user_pictures_settings->large_image_height
						)
				),
				'pic_name' => ($this->model->getLatestGroupPic(array(
						$this->GET['group']
				)) + 1) . '.jpg',
				'additional_data' => $this->POST,
				'gallery_id' => $this->GET['group'],
				'type' => 'group_picture'
		));

		header('Pragma: no-cache');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Content-Disposition: inline; filename="files.json"');
		header('X-Content-Type-Options: nosniff');
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT, DELETE');
		header('Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size');

		switch ($_SERVER['REQUEST_METHOD']) {

			case 'GET' :
				$upload_handler->get();
				break;
			case 'POST' :
				$upload_handler->post();

				break;

			default :
				header('HTTP/1.1 405 Method Not Allowed');
		}
	}
	function uploadGroupVideos() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		if(! isset($this->GET['group'])) {
			exit();
		}

		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}

		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		$group = $this->model->getGroup(array(
				$this->GET['group']
		));
		if((new \models\ModelUsersInteraction() )->checkIfGroupMember(array(
				$this->GET['group'],
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		)) < 1 && ($group->privacy == 2 || $group->privacy == 3)) {

			echo 'not a group member';

			exit();
		}
		$group_name = md5($group->group_name);

		$upload_handler = new \classes\Upload(array(
				'script_url' => 'index.php?route=users_content&action=delete_group_video&gallery=' . $group_name . '&',
				'upload_dir' => USER_DATA_DIR . 'groups/' . $group_name . '/videos/',
				'upload_url' => '',
				'max_file_size' => $this->Registry->user_videos_settings->maximum_file_size,
				'max_number_of_files' => $this->Registry->user_videos_settings->maximum_number_of_files,
				'accept_file_types' => '/.(' . str_replace(',', '|', $this->Registry->user_videos_settings->video_formats_accepted) . ')$/i',
				'image_versions' => array(
						'large' => array()
				),
				'pic_name' => ($this->model->getLatestGroupVideo(array(
						$this->GET['group']
				)) + 1) . '.mp4',
				'additional_data' => $this->POST,
				'gallery_id' => $this->GET['group'],
				'type' => 'group_video'
		));

		header('Pragma: no-cache');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Content-Disposition: inline; filename="files.json"');
		header('X-Content-Type-Options: nosniff');
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT, DELETE');
		header('Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size');

		switch ($_SERVER['REQUEST_METHOD']) {

			case 'GET' :
				$upload_handler->get();
				break;
			case 'POST' :
				$upload_handler->post();

				break;

			default :
				header('HTTP/1.1 405 Method Not Allowed');
		}
	}
	function uploadGroupMusics() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		if(! isset($this->GET['group'])) {
			exit();
		}

		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}

		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		$group = $this->model->getGroup(array(
				$this->GET['group']
		));
		if((new \models\ModelUsersInteraction() )->checkIfGroupMember(array(
				$this->GET['group'],
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		)) < 1 && ($group->privacy == 2 || $group->privacy == 3)) {

			echo 'not a group member';

			exit();
		}
		$group_name = md5($group->group_name);

		$upload_handler = new \classes\Upload(array(
				'script_url' => 'index.php?route=users_content&action=delete_group_video&gallery=' . $group_name . '&',
				'upload_dir' => USER_DATA_DIR . 'groups/' . $group_name . '/music/',
				'upload_url' => '',
				'max_file_size' => $this->Registry->user_videos_settings->maximum_file_size,
				'max_number_of_files' => $this->Registry->user_videos_settings->maximum_number_of_files,
				'accept_file_types' => '/.(' . str_replace(',', '|', $this->Registry->user_music_settings->music_formats_accepted) . ')$/i',
				'image_versions' => array(
						'large' => array()
				),
				'pic_name' => ($this->model->getLatestGroupMusic(array(
						$this->GET['group']
				)) + 1) . '.mp3',
				'additional_data' => $this->POST,
				'gallery_id' => $this->GET['group'],
				'type' => 'group_music'
		));

		header('Pragma: no-cache');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Content-Disposition: inline; filename="files.json"');
		header('X-Content-Type-Options: nosniff');
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT, DELETE');
		header('Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size');

		switch ($_SERVER['REQUEST_METHOD']) {

			case 'GET' :
				$upload_handler->get();
				break;
			case 'POST' :
				$upload_handler->post();

				break;

			default :
				header('HTTP/1.1 405 Method Not Allowed');
		}
	}
	function uploadMusic() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		if(! isset($this->GET['gallery'])) {
			exit();
		}

		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		$gallery_name = md5($this->model->getMusicGalleryUpload($this->GET['gallery'])->gallery_name);
		$upload_handler = new \classes\Upload(array(
				'script_url' => 'index.php?route=users_content&action=delete_music&gallery=' . $gallery_name . '&',
				'upload_dir' => USER_DATA_DIR . $_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key . '/music/' . $gallery_name . '/',
				'upload_url' => '',
				'max_file_size' => $this->Registry->user_music_settings->maximum_file_size,
				'max_number_of_files' => $this->Registry->user_music_settings->maximum_number_of_files,
				'accept_file_types' => '/.(' . str_replace(',', '|', $this->Registry->user_music_settings->music_formats_accepted) . ')$/i',
				'image_versions' => array(
						'large' => array()
				)
				,
				'pic_name' => ($this->model->getLatestMusic(array(
						$this->GET['gallery']
				)) + 1) . '.mp3',
				'gallery_id' => $this->GET['gallery'],
				'type' => 'music',
				'additional_data' => $this->POST
		));

		header('Pragma: no-cache');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Content-Disposition: inline; filename="files.json"');
		header('X-Content-Type-Options: nosniff');
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT, DELETE');
		header('Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size');

		switch ($_SERVER['REQUEST_METHOD']) {

			case 'GET' :
				$upload_handler->get();
				break;
			case 'POST' :

				$upload_handler->post();

				break;

			default :
				header('HTTP/1.1 405 Method Not Allowed');
		}
	}
	function editMusic() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}

		$this->model->editMusic(array(
				$this->POST['title'],
				$this->POST['description'],
				$this->POST['tags'],
				$this->POST['id'],
				$this->POST['g_id']
		));
		echo json_encode(array(
				'status' => 'edited'
		));
		exit();
	}
	function addPicturesGallery() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}

		if($this->model->checkPicturesGalleryExists(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
				$this->POST['gallery']
		)) < 1) {
			$this->model->addPicturesGallery(array(
					$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
					$this->POST['gallery']
			));
			(new \helpers\DirOperator() )->create(USER_DATA_DIR . $_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key . DIRECTORY_SEPARATOR . 'photos' . DIRECTORY_SEPARATOR . md5($this->POST['gallery']), 0777);
			echo json_encode(array(
					'status' => 'added'
			));
		} else {
			echo json_encode(array(
					'status' => 'Already exists'
			));
		}
		exit();
	}
	function picturesGalleriesDropdown() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}

		$added_gallery_id = $this->model->getPicturesGalleryByName(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
				md5($this->POST['gallery'])
		))->id;
		$galleries = $this->model->getUserPicturesGalleries();
		$select = '<select name="galleries" id="select_galleries" class="ui-widget-header select ui-corner-all">';
		foreach($galleries as $k => $v) {
			$select .= '<option value="' . $v->id . '"';
			if($added_gallery_id == $v->id) {
				$select .= 'selected="selected"';
			}
			$select .= '>' . $v->gallery_name . '</option>';
		}
		$select .= '</select>';

		echo json_encode(array(
				'select' => $select,
				'id' => $added_gallery_id
		));
		exit();
	}
	function managePictures() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}
		$pictures_gallery = $this->model->getPicturesByGallery(array(
				$this->model->getPicturesGalleryByName(array(
						$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
						md5('Default')
				))->id
		));
		$pictures = array();

		$i = 0;

		foreach($pictures_gallery as $k => $v) {

			$pictures[$i]['pic_name'] = $v->file_name;
			$pictures[$i]['pic_description'] = $v->description;
			$pictures[$i]['gallery'] = md5($this->model->getPicturesGalleryById(array(
					$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
					$v->gallery_id
			))->gallery_name);
			$pictures[$i]['user_key'] = $_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key;
			$pictures[$i]['file_size'] = \helpers\Utils::getFileSize(UPLOADS_DIR . $_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key . DIRECTORY_SEPARATOR . 'photos' . DIRECTORY_SEPARATOR . $pictures[$i]['gallery'] . DIRECTORY_SEPARATOR . $v->file_name);
			$i ++;
		}

		$this->view->assign('pictures', $pictures);
		$this->view->assign('user_galleries', $this->model->getUserPicturesGalleries());
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->assign('default_pictures_gallery_id', $this->model->getPicturesGalleryByName(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
				md5('Default')
		))->id);
		define('IGNORE_NO_AJAX', 'yes');
		$this->view->display('manage_profile/manage_pictures.tpl');
	}
	function getGalleryPictures() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}
		$pictures_gallery = $this->model->getPicturesByGallery(array(
				$this->POST['gallery']
		));
		$pictures = array();

		$i = 0;

		foreach($pictures_gallery as $k => $v) {

			$pictures[$i]['pic_name'] = $v->title;
			$pictures[$i]['id'] = $v->id;
			$pictures[$i]['pic_description'] = $v->description;
			$pictures[$i]['pic_tags'] = $v->tags;
			$pictures[$i]['gallery'] = md5($this->model->getPicturesGalleryById(array(
					$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
					$v->gallery_id
			))->gallery_name);
			$pictures[$i]['gallery_id'] = $v->gallery_id;
			$pictures[$i]['file_name'] = $v->file_name;
			$pictures[$i]['user_key'] = $_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key;
			$pictures[$i]['file_size'] = \helpers\Utils::getFileSize(UPLOADS_DIR . $_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key . DIRECTORY_SEPARATOR . 'photos' . DIRECTORY_SEPARATOR . $pictures[$i]['gallery'] . DIRECTORY_SEPARATOR . $v->file_name);
			$i ++;
		}

		$this->view->assign('pictures', $pictures);
		$this->view->assign('request_hash', RequestHash::Generate());

		$this->view->display('manage_profile/pictures_gallery_edit.tpl');
	}
	function deletePicture() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		if(RequestHash::validateHash($this->GET['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;
			exit();
		}
		$picture = $this->model->getPicture(array(
				$this->GET['id'],
				$this->GET['g_id']
		));
		$file_path = UPLOADS_DIR . $_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key . DIRECTORY_SEPARATOR . 'photos' . DIRECTORY_SEPARATOR . md5($this->model->getPictureGalleryById(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
				$this->GET['g_id']
		))->gallery_name) . DIRECTORY_SEPARATOR . $picture->file_name;
		(new \helpers\DirOperator() )->deleteFile($file_path);
		$this->model->deletePicture(array(
				$this->GET['g_id'],
				$this->GET['id']
		));
	}
	function deleteGroupPicture() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		if(RequestHash::validateHash($this->GET['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;
			exit();
		}
		$picture = $this->model->getGroupPicture(array(
				$this->GET['id'],
				$this->GET['g_id']
		));
		$group = $this->model->getGroup(array(
				$this->GET['g_id']
		));
		$file_path = USER_DATA_DIR . 'groups/' . md5($group->group_name) . DIRECTORY_SEPARATOR . 'photos' . DIRECTORY_SEPARATOR . $picture->file_name;
		(new \helpers\DirOperator() )->deleteFile($file_path);
		$this->model->deleteGroupPicture(array(
				$this->GET['g_id'],
				$this->GET['id']
		));
	}
	function deleteGroupVideo() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		if(RequestHash::validateHash($this->GET['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;
			exit();
		}
		$video = $this->model->getGroupVideo(array(
				$this->GET['id'],
				$this->GET['g_id']
		));
		$group = $this->model->getGroup(array(
				$this->GET['g_id']
		));
		$file_path = USER_DATA_DIR . 'groups/' . md5($group->group_name) . DIRECTORY_SEPARATOR . 'videos' . DIRECTORY_SEPARATOR . $video->file_name;
		(new \helpers\DirOperator() )->deleteFile($file_path);
		$this->model->deleteGroupVideo(array(
				$this->GET['g_id'],
				$this->GET['id']
		));
	}
	function deleteGroupMusic() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		if(RequestHash::validateHash($this->GET['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;
			exit();
		}
		$video = $this->model->getGroupMusic(array(
				$this->GET['id'],
				$this->GET['g_id']
		));
		$group = $this->model->getGroup(array(
				$this->GET['g_id']
		));
		$file_path = USER_DATA_DIR . 'groups/' . md5($group->group_name) . DIRECTORY_SEPARATOR . 'music' . DIRECTORY_SEPARATOR . $video->file_name;
		(new \helpers\DirOperator() )->deleteFile($file_path);
		$this->model->deleteGroupMusic(array(
				$this->GET['g_id'],
				$this->GET['id']
		));
	}
	function addBlogCategory() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}
		$this->model->addBlogCategory(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
				$this->POST['blog_category']
		));
		echo json_encode(array(
				'status' => 'added'
		));
		exit();
	}
	function blogCategoriesDropdown() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);

		$added_category_id = $this->model->getCategoryByName(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
				$this->POST['blog_category']
		))->id;
		$blog_categories = $this->model->getBlogCategories($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key);
		$select = '<select name="galleries" id="select_galleries" class="ui-widget-header select ui-corner-all">';
		foreach($blog_categories as $k => $v) {
			$select .= '<option value="' . $v->id . '"';
			if($added_category_id == $v->id) {
				$select .= 'selected="selected"';
			}
			$select .= '>' . $v->category . '</option>';
		}
		$select .= '</select>';

		echo json_encode(array(
				'select' => $select,
				'id' => $added_category_id
		));
		exit();
	}
	function manageBlogs() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}
		$this->view->assign('user_blog_categories', $this->model->getBlogCategories($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key));
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->assign('blogs', $this->model->getDefaultBlogs(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
				$this->model->getDefaultBlogCategory(array(
						$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
				))
		)));
		define('IGNORE_NO_AJAX', 'yes');
		$this->view->display('manage_profile/add_blogs.tpl');
	}
	function addBlog() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}

		$this->model->addBlog(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
				$this->POST['category_id'],
				$this->POST['blog_title'],
				$this->POST['blog_text'],
				time()
		));
		echo json_encode(array(
				'status' => 'added'
		));
		exit();
	}
	function userBlogs() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->assign('blogs', $this->model->getUserBlogs(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
				$this->POST['blog_category']
		)));
		define('IGNORE_NO_AJAX', 'yes');
		$this->view->display('manage_profile/blogs.tpl');
	}
	function getBlog() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}
		$blog = $this->model->getBlog(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
				$this->POST['blog_id']
		));
		echo (json_encode($blog));
		exit();
	}
	function editBlog() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}

		$this->model->editBlog(array(
				$this->POST['blog_title'],
				$this->POST['blog_text'],
				$this->POST['blog_id'],
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		));
		echo json_encode(array(
				'status' => 'edited'
		));
		exit();
	}
	function manageEvents() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->assign('events', $this->model->getUserEvents(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		)));
		define('IGNORE_NO_AJAX', 'yes');
		$this->view->display('manage_profile/manage_events.tpl');
	}
	function addEvent() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}

		$this->model->addEvent(array(
				$this->POST['event_title'],
				$this->POST['event_text'],
				$this->POST['event_location'],
				$this->POST['event_date'],
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
				time()
		));
		echo json_encode(array(
				'status' => 'added'
		));
		exit();
	}
	function userEvents() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->assign('events', $this->model->getUserEvents(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		)));
		define('IGNORE_NO_AJAX', 'yes');
		$this->view->display('manage_profile/events.tpl');
	}
	function getEvent() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}
		$event = $this->model->getEvent(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
				$this->POST['event_id']
		));
		echo (json_encode($event));
		exit();
	}
	function editEvent() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}

		$this->model->editEvent(array(
				$this->POST['event_title'],
				$this->POST['event_text'],
				$this->POST['event_location'],
				$this->POST['event_date'],
				$this->POST['event_id'],
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		));
		echo json_encode(array(
				'status' => 'edited'
		));
		exit();
	}
	function uploadVideos() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		if(! isset($this->GET['gallery'])) {
			exit();
		}
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		/*
		 * if(RequestHash::validateHash($this->POST['rh']) === FALSE) { echo
		 * $this->Registry->languages->user_wrong_request; exit(); }
		 */

		$gallery_name = md5($this->model->getVideosGalleryUpload($this->GET['gallery'])->gallery_name);
		$upload_handler = new \classes\Upload(array(
				'script_url' => 'index.php?route=users_content&action=delete_video&gallery=' . $gallery_name . '&',
				'upload_dir' => USER_DATA_DIR . $_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key . '/videos/' . $gallery_name . '/',
				'upload_url' => 'image.php?aoe=1&w=' . $this->Registry->user_videos_settings->thumbnail_width . '&h=' . $this->Registry->user_videos_settings->thumbnail_height . '&src=' . $_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key . '/videos/' . $gallery_name . '/',
				'max_file_size' => $this->Registry->user_videos_settings->maximum_file_size,
				'max_number_of_files' => $this->Registry->user_videos_settings->maximum_number_of_files,
				'accept_file_types' => '/.(' . str_replace(',', '|', $this->Registry->user_videos_settings->video_formats_accepted) . ')$/i',
				'image_versions' => array(
						'large' => array(
								'upload_dir' => USER_DATA_DIR . $_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key . '/videos/' . $gallery_name . '/',
								'upload_url' => 'index.php?route=users_content&action=get_image_large'
						)
				),
				'pic_name' => ($this->model->getLatestVideo(array(
						$this->GET['gallery']
				)) + 1) . '.mp4',
				'gallery_id' => $this->GET['gallery'],
				'type' => 'video',
				'additional_data' => $this->POST
		));

		header('Pragma: no-cache');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Content-Disposition: inline; filename="files.json"');
		header('X-Content-Type-Options: nosniff');
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT, DELETE');
		header('Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size');

		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET' :
				$upload_handler->get();
				break;
			case 'POST' :

				$upload_handler->post();

				break;

			default :
				header('HTTP/1.1 405 Method Not Allowed');
		}
	}
	function editVideo() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}

		$this->model->editVideo(array(
				$this->POST['title'],
				$this->POST['description'],
				$this->POST['tags'],
				$this->POST['id'],
				$this->POST['g_id']
		));
		echo json_encode(array(
				'status' => 'edited'
		));
		exit();
	}
	function manageVideos() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}
		$videos_gallery = $this->model->getVideosByGallery(array(
				$this->model->getVideoGalleryByName(array(
						$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
						md5('Default')
				))->id
		));
		$videos = array();

		$i = 0;

		foreach($videos_gallery as $k => $v) {

			$videos[$i]['video_name'] = $v->file_name;
			$videos[$i]['title'] = $v->title;
			$videos[$i]['description'] = $v->description;
			$videos[$i]['tags'] = $v->tags;
			$videos[$i]['gallery'] = md5($this->model->getVideoGalleryById(array(
					$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
					$v->gallery_id
			))->gallery_name);
			$videos[$i]['user_key'] = $_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key;
			$videos[$i]['file_size'] = \helpers\Utils::getFileSize(UPLOADS_DIR . $_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key . DIRECTORY_SEPARATOR . 'videos' . DIRECTORY_SEPARATOR . $videos[$i]['gallery'] . DIRECTORY_SEPARATOR . $v->file_name . '.mp4');
			$i ++;
		}

		$this->view->assign('videos', $videos);
		$this->view->assign('user_galleries', $this->model->getUserVideosGalleries());
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->assign('default_videos_gallery_id', $this->model->getVideosGalleryByName(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
				md5('Default')
		))->id);
		define('IGNORE_NO_AJAX', 'yes');
		$this->view->display('manage_profile/manage_videos.tpl');
	}
	function getGalleryVideos() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}
		$videos_gallery = $this->model->getVideosByGallery(array(
				$this->POST['gallery']
		));
		$videos = array();

		$i = 0;

		foreach($videos_gallery as $k => $v) {

			$videos[$i]['video_name'] = $v->title . '.mp4';
			$videos[$i]['id'] = $v->id;
			$videos[$i]['video_description'] = $v->description;
			$videos[$i]['video_tags'] = $v->tags;
			$videos[$i]['gallery'] = md5($this->model->getVideoGalleryById(array(
					$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
					$v->gallery_id
			))->gallery_name);
			$videos[$i]['gallery_id'] = $v->gallery_id;
			$videos[$i]['user_key'] = $_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key;
			$videos[$i]['file_size'] = \helpers\Utils::getFileSize(UPLOADS_DIR . $_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key . DIRECTORY_SEPARATOR . 'videos' . DIRECTORY_SEPARATOR . $videos[$i]['gallery'] . DIRECTORY_SEPARATOR . $v->file_name . '.mp4');
			$i ++;
		}

		$this->view->assign('videos', $videos);
		$this->view->assign('request_hash', RequestHash::Generate());
		define('IGNORE_NO_AJAX', 'yes');
		$this->view->display('manage_profile/videos_gallery_edit.tpl');
	}
	function deleteVideo() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		if(RequestHash::validateHash($this->GET['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;
			exit();
		}
		$video = $this->model->getVideo(array(
				$this->GET['id'],
				$this->GET['g_id']
		));
		$file_path = UPLOADS_DIR . $_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key . DIRECTORY_SEPARATOR . 'videos' . DIRECTORY_SEPARATOR . md5($this->model->getVideoGalleryById(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
				$this->GET['g_id']
		))->gallery_name) . DIRECTORY_SEPARATOR . $video->file_name;
		(new \helpers\DirOperator() )->deleteFile($file_path);
		$this->model->deleteVideo(array(
				$this->GET['g_id'],
				$this->GET['id']
		));
	}
	function addVideosGallery() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}
		$this->model->addVideosGallery(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
				$this->POST['gallery']
		));
		(new \helpers\DirOperator() )->create(USER_DATA_DIR . $_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key . DIRECTORY_SEPARATOR . 'videos' . DIRECTORY_SEPARATOR . md5($this->POST['gallery']), 0777);
		echo json_encode(array(
				'status' => 'added'
		));
		exit();
	}
	function videosGalleriesDropdown() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);

		/*
		 * if(RequestHash::validateHash($this->POST['rh']) === FALSE) { echo
		 * $this->Registry->languages->user_wrong_request; exit(); }
		 */

		$added_gallery_id = $this->model->getVideosGalleryByName(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
				md5($this->POST['gallery'])
		))->id;
		$galleries = $this->model->getUserVideosGalleries();
		$select = '<select name="galleries" id="select_galleries" class="ui-widget-header select ui-corner-all">';
		foreach($galleries as $k => $v) {
			$select .= '<option value="' . $v->id . '"';
			if($added_gallery_id == $v->id) {
				$select .= 'selected="selected"';
			}
			$select .= '>' . $v->gallery_name . '</option>';
		}
		$select .= '</select>';

		echo json_encode(array(
				'select' => $select,
				'id' => $added_gallery_id
		));
		exit();
	}
	function viewPictures() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);

		$this->ModelUsers = new \models\ModelUsers();
		$this->ModelUsersInteraction = new \models\ModelUsersInteraction();
		$pictures_subscribers = $this->ModelUsersInteraction->getPicturesSubscribers(array(
				$this->POST['id']
		));
		$subscribers = array();
		$i = 0;
		foreach($pictures_subscribers as $k => $v) {
			$subscribers[$i]['user'] = $this->ModelUsers->getUserByUserKey($v->from_key)->username;
			$i ++;
		}
		$this->view->assign('pictures_subscribers', $subscribers);

		$this->view->assign('pictures_galleries', $this->model->getPicturesGalleries(array(
				$this->POST['id']
		)));

		$Limit = 0 . ',' . $this->Registry->nr_items_to_display->profile_overlay_pictures;

		$default_gallery_id = $this->model->getPicturesGalleryByName(array(
				$this->POST['id'],
				md5('Default')
		))->id;
		$pictures = $this->model->getPicturesByGalleryLimit(array(
				$default_gallery_id
		), $Limit);
		$pictures_2 = array();
		$i = 0;
		foreach($pictures['results'] as $k => $v) {
			$pictures_2[$i]['image'] = \classes\UserPictures::getPicture($this->POST['id'], $v->file_name, md5('Default'), $this->Registry->user_pictures_settings->thumbnail_width, $this->Registry->user_pictures_settings->thumbnail_height);
			$pictures_2[$i]['id'] = $v->id;
			$pictures_2[$i]['pic_name'] = $v->file_name;
			$pictures_2[$i]['gallery_id'] = $v->gallery_id;
			$pictures_2[$i]['gallery_name'] = md5('Default');
			$pictures_2[$i]['user_key'] = $this->POST['id'];
			$i ++;
		}

		$this->view->assign('pagination', \classes\Pagination::Generate($page, $this->Registry->nr_items_to_display->profile_overlay_pictures, $pictures['nr_rows'], 'route=users_content&action=view_pictures_gallery&g_id=' . $default_gallery_id . '&u_id=' . $this->POST['id'] . '&rh=' . RequestHash::Generate(), 'gallery_pictures'));

		$this->view->assign('pictures', $pictures_2);
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->assign('large_image_width', $this->Registry->user_pictures_settings->large_image_width);
		$this->view->assign('large_image_height', $this->Registry->user_pictures_settings->large_image_height);
		$this->view->assign('picture_user_key', $this->POST['id']);
		define('IGNORE_NO_AJAX', 'yes');
		$this->view->display('user/pictures/view_pictures.tpl');
	}
	function viewPicturesGallery() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		if(RequestHash::validateHash($this->GET['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}

		$from = ! isset($this->GET["pag"]) ? 1 : $this->GET["pag"];
		$page = $from - 1;
		$limit_start = $page * $this->Registry->nr_items_to_display->profile_overlay_pictures;

		$Limit = $limit_start . ',' . $this->Registry->nr_items_to_display->profile_overlay_pictures;

		$pictures = $this->model->getPicturesByGalleryLimit(array(
				$this->GET['g_id']
		), $Limit);
		$pictures_2 = array();
		$i = 0;
		foreach($pictures['results'] as $k => $v) {
			$pictures_2[$i]['image'] = \classes\UserPictures::getPicture($this->GET['u_id'], $v->file_name, md5($this->model->getPicturesGalleryById(array(
					$this->GET['u_id'],
					$this->GET['g_id']
			))->gallery_name), $this->Registry->user_pictures_settings->thumbnail_width, $this->Registry->user_pictures_settings->thumbnail_height);
			$pictures_2[$i]['id'] = $v->id;
			$pictures_2[$i]['pic_name'] = $v->file_name;
			$pictures_2[$i]['gallery_id'] = $v->gallery_id;
			$pictures_2[$i]['gallery_name'] = md5('Default');
			$pictures_2[$i]['user_key'] = $this->GET['u_id'];
			$i ++;
		}
		$this->view->assign('pagination', \classes\Pagination::Generate($page, $this->Registry->nr_items_to_display->profile_overlay_pictures, $pictures['nr_rows'], 'route=users_content&action=view_pictures_gallery&u_id=' . $this->GET['u_id'] . '&g_id=' . $this->GET['g_id'] . '&rh=' . RequestHash::Generate(), 'gallery_pictures'));

		$this->view->assign('pictures', $pictures_2);
		define('IGNORE_NO_AJAX', 'yes');
		$this->view->display('user/pictures/gallery_pictures.tpl');
	}
	function editPicture() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}

		$this->model->editPicture(array(
				$this->POST['title'],
				$this->POST['description'],
				$this->POST['tags'],
				$this->POST['id'],
				$this->POST['g_id']
		));
		echo json_encode(array(
				'status' => 'edited'
		));
		exit();
	}
	function manageMusic() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}
		$music_gallery = $this->model->getMusicByGallery(array(
				$this->model->getMusicGalleryByName(array(
						$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
						md5('Default')
				))->id
		));
		$music = array();

		$i = 0;

		foreach($music_gallery as $k => $v) {

			$music[$i]['file_name'] = $v->file_name;
			$music[$i]['description'] = $v->description;
			$music[$i]['gallery'] = md5($this->model->getMusicGalleryById(array(
					$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
					$v->gallery_id
			))->gallery_name);
			$music[$i]['user_key'] = $_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key;
			// $music[$i]['file_size'] = \helpers\Utils::getFileSize(UPLOADS_DIR
			// . $_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key .
			// DIRECTORY_SEPARATOR . 'music' . DIRECTORY_SEPARATOR .
			// $music_gallery[$i]['gallery'] . DIRECTORY_SEPARATOR .
			// $v->file_name);
			$i ++;
		}

		$this->view->assign('music', $music);
		$this->view->assign('user_galleries', $this->model->getUserMusicGalleries());
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->assign('default_music_gallery_id', $this->model->getMusicGalleryByName(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
				md5('Default')
		))->id);
		define('IGNORE_NO_AJAX', 'yes');
		$this->view->display('manage_profile/manage_music.tpl');
	}
	function addMusicGallery() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}
		$this->model->addMusicGallery(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
				$this->POST['gallery']
		));
		(new \helpers\DirOperator() )->create(USER_DATA_DIR . $_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key . DIRECTORY_SEPARATOR . 'music' . DIRECTORY_SEPARATOR . md5($this->POST['gallery']), 0777);
		echo json_encode(array(
				'status' => 'added'
		));
		exit();
	}
	function musicGalleriesDropdown() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}

		$added_gallery_id = $this->model->getMusicGalleryByName(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
				md5($this->POST['gallery'])
		))->id;
		$galleries = $this->model->getUserMusicGalleries();
		$select = '<select name="galleries" id="select_galleries" class="ui-widget-header select ui-corner-all">';
		foreach($galleries as $k => $v) {
			$select .= '<option value="' . $v->id . '"';
			if($added_gallery_id == $v->id) {
				$select .= 'selected="selected"';
			}
			$select .= '>' . $v->gallery_name . '</option>';
		}
		$select .= '</select>';

		echo json_encode(array(
				'select' => $select,
				'id' => $added_gallery_id
		));
		exit();
	}
	function getGalleryMusic() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}
		$music_gallery = $this->model->getMusicByGallery(array(
				$this->POST['gallery']
		));
		$music = array();

		$i = 0;

		foreach($music_gallery as $k => $v) {

			$music[$i]['id'] = $v->id;
			$music[$i]['file_name'] = $v->file_name . '.mp3';
			$music[$i]['title'] = $v->title;
			$music[$i]['description'] = $v->description;
			$music[$i]['tags'] = $v->tags;
			$music[$i]['gallery'] = md5($this->model->getMusicGalleryById(array(
					$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
					$v->gallery_id
			))->gallery_name);
			$music[$i]['gallery_id'] = $v->gallery_id;
			$music[$i]['user_key'] = $_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key;
			$music[$i]['file_size'] = \helpers\Utils::getFileSize(UPLOADS_DIR . $_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key . DIRECTORY_SEPARATOR . 'music' . DIRECTORY_SEPARATOR . $music[$i]['gallery'] . DIRECTORY_SEPARATOR . $v->file_name . '.mp3');
			$i ++;
		}

		$this->view->assign('musics', $music);
		$this->view->assign('request_hash', RequestHash::Generate());

		$this->view->display('manage_profile/music_gallery_edit.tpl');
	}
	function deleteMusic() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		if(RequestHash::validateHash($this->GET['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;
			exit();
		}
		$video = $this->model->getMusic(array(
				$this->GET['id'],
				$this->GET['g_id']
		));
		$file_path = UPLOADS_DIR . $_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key . DIRECTORY_SEPARATOR . 'music' . DIRECTORY_SEPARATOR . md5($this->model->getMusicGalleryById(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
				$this->GET['g_id']
		))->gallery_name) . DIRECTORY_SEPARATOR . $video->file_name;
		(new \helpers\DirOperator() )->deleteFile($file_path);
		$this->model->deleteMusic(array(
				$this->GET['g_id'],
				$this->GET['id']
		));
	}
	function viewBlogs() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}
		$this->ModelUsers = new \models\ModelUsers();
		$this->ModelUsersInteraction = new \models\ModelUsersInteraction();
		$blog_subscribers = $this->ModelUsersInteraction->getBlogSubscribers(array(
				$this->POST['id']
		));
		$subscribers = array();
		$i = 0;
		foreach($blog_subscribers as $k => $v) {
			$subscribers[$i]['user'] = $this->ModelUsers->getUserByUserKey($v->from_key)->username;
			$i ++;
		}

		$Limit = 0 . ',' . $this->Registry->nr_items_to_display->profile_overlay_blogs;

		$default_category_id = $this->model->getDefaultBlogCategory(array(
				$this->POST['id']
		));
		$blogs = $this->model->getDefaultBlogsLimit(array(
				$this->POST['id'],
				$default_category_id
		), $Limit);

			foreach($blogs['results'] as $k => &$v)
			{
							$v->title = \helpers\Utils::limit_text($v->title,20);
			}
		$this->view->assign('user_blog_categories', $this->model->getBlogCategories($this->POST['id']));
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->assign('blogs', $blogs['results']);

		$this->view->assign('pagination', \classes\Pagination::Generate($page, $this->Registry->nr_items_to_display->profile_overlay_blogs, $blogs['nr_rows'], 'route=users_content&action=view_blogs_by_category&c_id=' . $default_category_id . '&u_id=' . $this->POST['id'] . '&rh=' . RequestHash::Generate(), 'blogs'));
		$this->view->assign('blog_subscribers', $subscribers);
		$this->view->assign('blogs_user_key', $this->POST['id']);
		define('IGNORE_NO_AJAX', 'yes');
		$this->view->display('user/blogs/view_blogs.tpl');
	}
	function viewBlog() {
		// header('Content-type: text/html');
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		if(isset($this->GET['blog'])) {
			$blog = $this->model->getBlogById(array(
					$this->GET['id']
			));
		} else {
			$blog = $this->model->getBlog(array(
					$this->GET['u_k'],
					$this->GET['id']
			));
		}
		$this->view->assign('blog', $blog);
		$this->view->assign('request_hash', RequestHash::Generate());
		if(! isset($this->GET['n_a'])) {
			if(NO_AJAX == 'yes') {
				$this->view->assign('blogs_comments', (new \models\ModelUsersInteraction() )->getBlogComments(array(
						$blog->id
				)));
				$this->view->assign('not_load_middle_default', true);
				$this->view->display('user/blogs/blog_no_ajax.tpl');
			} else {
				$this->view->display('user/blogs/blog.tpl');
			}
		} else {
			if(isset($this->GET['n_a'])) {
				define('IGNORE_NO_AJAX', 'yes');
			}
			$this->view->display('user/blogs/blog.tpl');
		}
		unset($this->GET);

		unset($this->view);
	}
	function viewBlogsByCategory() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		if(RequestHash::validateHash($this->GET['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}

		$from = ! isset($this->GET["pag"]) ? 1 : $this->GET["pag"];
		$page = $from - 1;
		$limit_start = $page * $this->Registry->nr_items_to_display->profile_overlay_blogs;

		$Limit = $limit_start . ',' . $this->Registry->nr_items_to_display->profile_overlay_blogs;

		$blogs = $this->model->getUserBlogsLimit(array(
				$this->GET['u_id'],
				$this->GET['c_id']
		), $Limit);
		$this->view->assign('blogs', $blogs['results']);
		$this->view->assign('pagination', \classes\Pagination::Generate($page, $this->Registry->nr_items_to_display->profile_overlay_blogs, $blogs['nr_rows'], 'route=users_content&action=view_blogs_by_category&c_id=' . $this->GET['c_id'] . '&u_id=' . $this->GET['u_id'] . '&rh=' . RequestHash::Generate(), 'blogs'));
				define('IGNORE_NO_AJAX', 'yes');

		$this->view->display('user/blogs/blogs.tpl');
	}
	function viewVideos() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}
		$this->ModelUsers = new \models\ModelUsers();
		$this->ModelUsersInteraction = new \models\ModelUsersInteraction();
		$videos_subscribers = $this->ModelUsersInteraction->getVideosSubscribers(array(
				$this->POST['id']
		));
		$subscribers = array();
		$i = 0;
		foreach($videos_subscribers as $k => $v) {
			$subscribers[$i]['user'] = $this->ModelUsers->getUserByUserKey($v->from_key)->username;
			$i ++;
		}

		$default_gallery_id = $this->model->getDefaultVideosGallery(array(
				$this->POST['id']
		));
		$Limit = 0 . ',' . $this->Registry->nr_items_to_display->profile_overlay_videos;

		$videos = $this->model->getDefaultVideosLimit(array(
				$default_gallery_id
		), $Limit);
		$this->view->assign('user_video_galleries', $this->model->getVideosGalleries($this->POST['id']));
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->assign('videos', $videos['results']);
		$this->view->assign('pagination', \classes\Pagination::Generate($page, $this->Registry->nr_items_to_display->profile_overlay_videos, $videos['nr_rows'], 'route=users_content&action=view_videos_by_category&c_id=' . $default_gallery_id . '&u_id=' . $this->POST['id'], 'videos'));
		$this->view->assign('video_subscribers', $subscribers);
		$this->view->assign('videos_user_key', $this->POST['id']);
		define('IGNORE_NO_AJAX', 'yes');
		$this->view->display('user/videos/view_videos.tpl');
	}
	function viewVideosByCategory() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		if(RequestHash::validateHash($this->GET['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}
		$from = ! isset($this->GET["pag"]) ? 1 : $this->GET["pag"];
		$page = $from - 1;
		$limit_start = $page * $this->Registry->nr_items_to_display->profile_overlay_videos;

		$Limit = $limit_start . ',' . $this->Registry->nr_items_to_display->profile_overlay_videos;
		$videos = $this->model->getUserVideosLimit(array(
				$this->GET['c_id'],
				$this->GET['u_id']
		), $Limit);
		$this->view->assign('videos', $videos['results']);
		$this->view->assign('pagination', \classes\Pagination::Generate($page, $this->Registry->nr_items_to_display->profile_overlay_videos, $videos['nr_rows'], 'route=users_content&action=view_videos_by_category&c_id=' . $this->GET['c_id'] . '&u_id=' . $this->GET['u_id'], 'videos'));
		$this->view->display('user/videos/videos.tpl');
	}
	function viewMusic() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}
		$this->ModelUsers = new \models\ModelUsers();
		$this->ModelUsersInteraction = new \models\ModelUsersInteraction();
		$music_subscribers = $this->ModelUsersInteraction->getMusicSubscribers(array(
				$this->POST['id']
		));
		$subscribers = array();
		$i = 0;
		foreach($music_subscribers as $k => $v) {
			$subscribers[$i]['user'] = $this->ModelUsers->getUserByUserKey($v->from_key)->username;
			$i ++;
		}

		$default_gallery_id = $this->model->getDefaultMusicGallery(array(
						$this->POST['id']
				));
		$Limit = 0 . ',' . $this->Registry->nr_items_to_display->profile_overlay_music;

$music = $this->model->getDefaultMusicLimit(array(
				$default_gallery_id
		),$Limit);
		$this->view->assign('user_music_galleries', $this->model->getMusicGalleries($this->POST['id']));
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->assign('music', $music['results']);
		$this->view->assign('pagination', \classes\Pagination::Generate($page, $this->Registry->nr_items_to_display->profile_overlay_music, $music['nr_rows'], 'route=users_content&action=view_music_by_category&c_id=' . $default_gallery_id . '&u_id=' . $this->POST['id'], 'the_musics'));
		$this->view->assign('music_subscribers', $subscribers);
		$this->view->assign('music_user_key', $this->POST['id']);
		define('IGNORE_NO_AJAX', 'yes');
		$this->view->display('user/music/view_music.tpl');
	}
	function viewMusicByCategory() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		if(RequestHash::validateHash($this->GET['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}
		$from = ! isset($this->GET["pag"]) ? 1 : $this->GET["pag"];
		$page = $from - 1;
		$limit_start = $page * $this->Registry->nr_items_to_display->profile_overlay_music;

		$Limit = $limit_start . ',' . $this->Registry->nr_items_to_display->profile_overlay_music;
$music = $this->model->getUserMusicLimit(array(
				$this->GET['c_id'],
				$this->GET['u_id']
		),$Limit);
		$this->view->assign('music',$music['results'] );
		$this->view->assign('pagination', \classes\Pagination::Generate($page, $this->Registry->nr_items_to_display->profile_overlay_music, $music['nr_rows'], 'route=users_content&action=view_music_by_category&c_id=' . $this->GET['c_id'] . '&u_id=' . $this->GET['u_id'], 'the_musics'));
		$this->view->display('user/music/music.tpl');
	}
	function viewEvents() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}

		$this->ModelUsers = new \models\ModelUsers();
		$this->ModelUsersInteraction = new \models\ModelUsersInteraction();
		$events_subscribers = $this->ModelUsersInteraction->getEventsSubscribers(array(
				$this->POST['id']
		));
		$subscribers = array();
		$i = 0;
		foreach($events_subscribers as $k => $v) {
			$subscribers[$i]['user'] = $this->ModelUsers->getUserByUserKey($v->from_key)->username;
			$i ++;
		}

		$Limit = 0 . ',' . $this->Registry->nr_items_to_display->profile_overlay_events;

		$events = $this->model->getUserEventsLimit(array(
				$this->POST['id']
		), $Limit);
			foreach($events['results'] as $k => &$v)
			{
							$v->title = \helpers\Utils::limit_text($v->title,30);
			}
		$this->view->assign('events_subscribers', $subscribers);
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->assign('events', $events['results']);
		$this->view->assign('pagination', \classes\Pagination::Generate($page, $this->Registry->nr_items_to_display->profile_overlay_events, $events['nr_rows'], 'route=users_content&action=view_events_pagination&u_id=' . $this->POST['id'], 'events'));
		$this->view->assign('event_user_key', $this->POST['id']);
		define('IGNORE_NO_AJAX', 'yes');
		$this->view->display('user/events/view_events.tpl');
	}
	function viewEventsPagination() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		if(RequestHash::validateHash($this->GET['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}

		$this->ModelUsers = new \models\ModelUsers();
		$this->ModelUsersInteraction = new \models\ModelUsersInteraction();

		$from = ! isset($this->GET["pag"]) ? 1 : $this->GET["pag"];
		$page = $from - 1;
		$limit_start = $page * $this->Registry->nr_items_to_display->profile_overlay_events;

		$Limit = $limit_start . ',' . $this->Registry->nr_items_to_display->profile_overlay_events;

		$events = $this->model->getUserEventsLimit(array(
				$this->GET['u_id']
		), $Limit);
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->assign('events', $events['results']);
		$this->view->assign('pagination', \classes\Pagination::Generate($page, $this->Registry->nr_items_to_display->profile_overlay_events, $events['nr_rows'], 'route=users_content&action=view_events_pagination&u_id=' . $this->GET['u_id'], 'events'));
		$this->view->assign('event_user_key', $this->GET['u_id']);
		define('IGNORE_NO_AJAX', 'yes');
		$this->view->display('user/events/events.tpl');
	}
	function viewEvent() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);

		$this->ModelUsers = new \models\ModelUsers();
		$this->ModelUsersInteraction = new \models\ModelUsersInteraction();
		if(isset($this->GET['event'])) {
			$event = $this->model->getEventById(array(
					$this->GET['id']
			));
		} else {
			$event = $this->model->getEvent(array(
					$this->GET['u_k'],
					$this->GET['id']
			));
		}
		$attending_to_event = $this->ModelUsersInteraction->getAttending(array(
				$event->id
		));
		$attending = array();
		$i = 0;
		foreach($attending_to_event as $k => $v) {
			$attending[$i]['user'] = $this->ModelUsers->getUserByUserKey($v->to_key)->username;
			$i ++;
		}
		$this->view->assign('attending', $attending);
		$this->view->assign('event', $event);
		$this->view->assign('request_hash', RequestHash::Generate());
		if(! isset($this->GET['n_a'])) {
			if(NO_AJAX == 'yes') {
				$this->view->assign('events_comments', $this->ModelUsersInteraction->getEventComments(array(
						$event->id
				)));
				$this->view->assign('not_load_middle_default', true);
				$this->view->display('user/events/event_no_ajax.tpl');
			} else {
				$this->view->display('user/events/event.tpl');
			}
		} else {
			if(isset($this->GET['n_a'])) {
				define('IGNORE_NO_AJAX', 'yes');
			}
			$this->view->display('user/events/event.tpl');
		}
	}
	function manageGroups() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo json_encode(array(
					'status' => $this->Registry->languages->user_not_logged
			));

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo json_encode(array(
					'status' => $this->Registry->languages->user_wrong_request
			));

			exit();
		}
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->assign('groups', $this->model->getUserGroups(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		)));
		define('IGNORE_NO_AJAX', 'yes');
		$this->view->display('manage_profile/manage_groups.tpl');
	}
	function addGroup() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}
		if($this->model->checkGroupExists(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
				$this->POST['group_name']
		)) > 0) {
			echo json_encode(array(
					'status' => $this->Registry->languages->already_have_a_group_with_this_name
			));
			exit();
		}
		$this->model->addGroup(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
				$this->POST['group_name'],
				$this->POST['group_description'],
				$this->POST['group_privacy'],
				$this->POST['group_location'],
				time()
		));

		$group_name = md5($this->POST['group_name'] . $_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key);
		$dirOperator = new \helpers\DirOperator();
		$dirOperator->create(USER_DATA_DIR . 'groups/' . $group_name . DIRECTORY_SEPARATOR, 0777);
		$dirOperator->create(USER_DATA_DIR . 'groups/' . $group_name . DIRECTORY_SEPARATOR . 'videos' . DIRECTORY_SEPARATOR, 0777);
		$dirOperator->create(USER_DATA_DIR . 'groups/' . $group_name . DIRECTORY_SEPARATOR . 'photos' . DIRECTORY_SEPARATOR, 0777);
		$dirOperator->create(USER_DATA_DIR . 'groups/' . $group_name . DIRECTORY_SEPARATOR . 'music' . DIRECTORY_SEPARATOR, 0777);
		echo json_encode(array(
				'status' => 'added'
		));
		exit();
	}
	function userGroups() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->assign('groups', $this->model->getUserGroups(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		)));
		define('IGNORE_NO_AJAX', 'yes');
		$this->view->display('manage_profile/groups.tpl');
	}
	function getGroup() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}
		$this->view->assign('group', $this->model->getGroup(array(
				$this->POST['group_id']
		)));
		define('IGNORE_NO_AJAX', 'yes');
		$this->view->display('manage_profile/edit_group.tpl');
	}
	function editGroup() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}

		$this->model->editGroup(array(
				$this->POST['group_name'],
				$this->POST['group_description'],
				$this->POST['group_privacy'],
				$this->POST['group_location'],
				$this->POST['group_id'],
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		));
		echo json_encode(array(
				'status' => 'edited'
		));
		exit();
	}
	function viewGroups() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}
		$this->ModelUsers = new \models\ModelUsers();
		$this->ModelUsersInteraction = new \models\ModelUsersInteraction();
		$group_subscribers = $this->ModelUsersInteraction->getGroupSubscribers(array(
				$this->POST['id']
		));
		$subscribers = array();
		$i = 0;
		foreach($group_subscribers as $k => $v) {
			$subscribers[$i]['user'] = $this->ModelUsers->getUserByUserKey($v->from_key)->username;
			$i ++;
		}

		$Limit = 0 . ',' . $this->Registry->nr_items_to_display->profile_overlay_groups;

		$groups = $this->model->getGroupsLimit(array(
				$this->POST['id']
		),$Limit);
		foreach($groups['results'] as $k => &$v)
		{
			$v->safe_seo_url = \helpers\Utils::safe_url($v->group_name);
		}
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->assign('groups', $groups['results']);
		$this->view->assign('pagination', \classes\Pagination::Generate($page, $this->Registry->nr_items_to_display->profile_overlay_groups, $groups['nr_rows'], 'route=users_content&action=view_groups_pagination&u_id='.$this->POST['id'].'&rh=' . RequestHash::Generate(), 'groups'));
		$this->view->assign('group_subscribers', $subscribers);
		$this->view->assign('group_user_key', $this->POST['id']);
		define('IGNORE_NO_AJAX', 'yes');
		$this->view->display('user/groups/view_groups.tpl');
	}
	function viewGroupsPagination() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		if(RequestHash::validateHash($this->GET['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}
		$this->ModelUsers = new \models\ModelUsers();
		$this->ModelUsersInteraction = new \models\ModelUsersInteraction();


			$from = ! isset($this->GET["pag"]) ? 1 : $this->GET["pag"];
		$page = $from - 1;
		$limit_start = $page * $this->Registry->nr_items_to_display->profile_overlay_groups;

		$Limit = $limit_start . ',' . $this->Registry->nr_items_to_display->profile_overlay_groups;

		$groups = $this->model->getGroupsLimit(array(
				$this->GET['u_id']
		),$Limit);
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->assign('groups', $groups['results']);
		$this->view->assign('pagination', \classes\Pagination::Generate($page, $this->Registry->nr_items_to_display->profile_overlay_groups, $groups['nr_rows'], 'route=users_content&action=view_groups_pagination&u_id='.$this->GET['u_id'].'&rh=' . RequestHash::Generate(), 'groups'));
		$this->view->assign('group_user_key', $this->GET['u_id']);
		define('IGNORE_NO_AJAX', 'yes');
		$this->view->display('user/groups/groups.tpl');
	}
	function viewGroup() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}
		$this->ModelUsers = new \models\ModelUsers();
		$this->ModelUsersInteraction = new \models\ModelUsersInteraction();
		$members = $this->ModelUsersInteraction->getMembers(array(
				$this->POST['id']
		));
		$attending = array();
		// $i = 0;
		// foreach($attending_to_event as $k => $v)
		// {
		// $attending[$i]['user'] =
		// $this->ModelUsers->getUserByUserKey($v->to_key)->username;
		// $i++;
		// }
		$this->view->assign('members', $members);
		$this->view->assign('group', $this->model->getGroup(array(
				$this->POST['id']
		)));
		$this->view->display('user/groups/group.tpl');
	}
	function showPhotos() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);

		$from = ! isset($this->GET["pag"]) ? 1 : $this->GET["pag"];
		$page = $from - 1;
		$limit_start = $page * $this->Registry->nr_items_to_display->photos_page;

		$picturesLimit = $limit_start . ',' . $this->Registry->nr_items_to_display->photos_page;
		$pictures = $this->model->getPictures($picturesLimit);
		$pictures_2 = array();
		$i = 0;
		foreach($pictures['results'] as $k => $v) {
			$pictures_2[$i]['image'] = \classes\UserPictures::getPicture($v->user_key, $v->file_name, md5($v->gallery_name), $this->Registry->user_pictures_settings->thumbnail_width, $this->Registry->user_pictures_settings->thumbnail_height);
			$pictures_2[$i]['id'] = $v->id;
			$pictures_2[$i]['pic_name'] = $v->file_name;
			$pictures_2[$i]['gallery_id'] = $v->gallery_id;
			$pictures_2[$i]['gallery_name'] = md5($v->gallery_name);
			$pictures_2[$i]['user_key'] = $v->user_key;
			$pictures_2[$i]['username'] = $v->username;
			$pictures_2[$i]['tags'] = $v->tags;
			$pictures_2[$i]['title'] = $v->title;
			$pictures_2[$i]['safe_seo_url'] = \helpers\Utils::safe_url($v->title);
			$pictures_2[$i]['timestamp'] = $v->timestamp;
			$i ++;
		}
		$this->view->assign('all_pictures', $pictures_2);
		$this->view->assign('pagination', \classes\Pagination::Generate($page, $this->Registry->nr_items_to_display->photos_page, $pictures['nr_rows'], 'route=users_content&action=show_photos', 'photos'));
		if(! isset($this->GET["pag"])) {
			$this->view->display('pages/photos/photos.tpl');
		} else {
			define('IGNORE_NO_AJAX','yes');
			$this->view->display('pages/photos/pictures.tpl');
		}
	}
	function showEvents() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);

		$from = ! isset($this->GET["pag"]) ? 1 : $this->GET["pag"];
		$page = $from - 1;
		$limit_start = $page * $this->Registry->nr_items_to_display->events_page;

		$eventsLimit = $Limit = $limit_start . ',' . $this->Registry->nr_items_to_display->events_page;
		$events = $this->model->getEvents($eventsLimit);
		foreach($events['results'] as $k => &$v) {
			$v->safe_seo_url = \helpers\Utils::safe_url($v->title);
		}

		$this->view->assign('events', $events['results']);
		$this->view->assign('pagination', \classes\Pagination::Generate($page, $this->Registry->nr_items_to_display->events_page, $events['nr_rows'], 'route=users_content&action=show_events', 'events'));
		if(! isset($this->GET["pag"])) {
			$this->view->display('pages/events/events.tpl');
		} else {
			$this->view->display('pages/events/events_layout.tpl');
		}
	}
	function showBlogs() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);

		$from = ! isset($this->GET["pag"]) ? 1 : $this->GET["pag"];
		$page = $from - 1;
		$limit_start = $page * $this->Registry->nr_items_to_display->blogs_page;

		$blogsLimit = $Limit = $limit_start . ',' . $this->Registry->nr_items_to_display->blogs_page;
		$blogs = $this->model->getBlogs($blogsLimit);
		foreach($blogs['results'] as $k => &$v) {
			$v->safe_seo_url = \helpers\Utils::safe_url($v->title);
		}
		$this->view->assign('latest_blogs', $blogs['results']);
		$this->view->assign('pagination', \classes\Pagination::Generate($page, $this->Registry->nr_items_to_display->blogs_page, $blogs['nr_rows'], 'route=users_content&action=show_blogs', 'blogs'));
		if(! isset($this->GET["pag"])) {
			$this->view->display('pages/blogs/blogs.tpl');
		} else {
			$this->view->display('pages/blogs/blogs_layout.tpl');
		}
	}
	function uploadProfilePicture() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo json_encode(array(
					'status' => $this->Registry->languages->user_not_logged
			));
			exit();
		}
		define('IGNORE_NO_AJAX', 'yes');
		if(count($this->Registry->FILES) > 0) {
			$this->FILES = $this->Registry->FILES;
			// pr($this->FILES);
			unset($this->Registry->Files);
			if($this->Registry->FILES['picture']['type'] == 'image/png' || $this->Registry->FILES['picture']['type'] == 'image/jpeg' || $this->Registry->FILES['picture']['type'] == 'image/gif') {
				move_uploaded_file($this->FILES['picture']['tmp_name'], USER_DATA_DIR . $_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key . DIRECTORY_SEPARATOR . 'photos' . DIRECTORY_SEPARATOR . 'profile.jpg');
				$this->view->assign('status', 'uploaded');
			} else {
				$this->view->assign('status', 'Invalid file type,needs to be a .jpg,.png or .gif');
			}

			$this->view->display('manage_profile/upload_profile_picture_submit.tpl');
			exit();
		}
		$this->view->display('manage_profile/upload_profile_picture.tpl');
	}
	function showGames() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);

		$flashGamesLimit = $Limit = '0,' . $this->Registry->nr_items_to_display->flash_games_page;
		$games = $this->model->getGames($flashGamesLimit)['results'];
		foreach($games as $k => &$v) {
			$v->safe_seo_url = \helpers\Utils::safe_url($v->title);
		}
		$this->view->assign('games', $games);
		$this->view->display('pages/games/games.tpl');
	}
	function viewGame() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);

		$game = $this->model->getGame(array(
				$this->GET['id']
		));
		$this->view->assign('game', $game);
		$this->view->assign('request_hash', RequestHash::Generate());

		if(isset($this->GET['n_a'])) {
			define('IGNORE_NO_AJAX', 'yes');
		}
		$this->view->display('pages/games/game.tpl');

		unset($this->GET);

		unset($this->view);
	}
	function manageExtraSections() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo json_encode(array(
					'status' => $this->Registry->languages->user_not_logged
			));

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo json_encode(array(
					'status' => $this->Registry->languages->user_wrong_request
			));

			exit();
		}
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->assign('extra_sections', $this->model->getUserExtraSections($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key, $this->POST['type']));
		define('IGNORE_NO_AJAX', 'yes');
		$this->view->assign('type', $this->POST['type']);
		$this->view->display('manage_profile/extra_sections.tpl');
	}
	function getExtraSection() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo json_encode(array(
					'status' => $this->Registry->languages->user_not_logged
			));

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo json_encode(array(
					'status' => $this->Registry->languages->user_wrong_request
			));

			exit();
		}
		$extra_section = $this->model->getExtraSection($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key, $this->POST['extra_section_id'], $this->POST['type']);
		echo (json_encode($extra_section));
		exit();
	}
	function editExtraSection() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo json_encode(array(
					'status' => $this->Registry->languages->user_not_logged
			));

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}

		$this->model->editExtraSection(array(
				$this->POST['extra_section_title'],
				$this->POST['extra_section_text'],
				$this->POST['extra_section_id'],
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		), $this->POST['type']);
		echo json_encode(array(
				'status' => 'edited'
		));
		exit();
	}
	function userExtraSections() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo json_encode(array(
					'status' => $this->Registry->languages->user_not_logged
			));

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo json_encode(array(
					'status' => $this->Registry->languages->user_wrong_request
			));

			exit();
		}
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->assign('extra_sections', $this->model->getUserExtraSections($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key, $this->POST['type']));
		define('IGNORE_NO_AJAX', 'yes');
		$this->view->display('manage_profile/extra_sections_inner.tpl');
	}
}

?>