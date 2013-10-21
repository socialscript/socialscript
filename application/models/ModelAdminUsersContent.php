<?php

namespace models;

use lib\Core\Model;
use lib\Core\Registry;

class ModelAdminUsersContent extends Model {
	function __construct() {
		parent::__construct();
		$this->Registry = Registry::getInstance();
		(new \SplAutoloader('models', array(
				'models'
		)) )->register();
	}
	function getPictures() {
		$pictures = $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT  ' . $this->table_prefix . '_pictures.*,' . $this->table_prefix . '_users.username,' . $this->table_prefix . '_users.user_key,' . $this->table_prefix . '_galleries.gallery_name FROM ' . $this->table_prefix . '_pictures
				LEFT JOIN ' . $this->table_prefix . '_galleries
				ON ' . $this->table_prefix . '_pictures.gallery_id=' . $this->table_prefix . '_galleries.id
			 		LEFT JOIN ' . $this->table_prefix . '_users
			 			ON ' . $this->table_prefix . '_galleries.user_key=' . $this->table_prefix . '_users.user_key
					 ORDER BY
				' . $this->table_prefix . '_pictures.id DESC');

		foreach($pictures as $k => &$v) {
			$v->image = \classes\UserPictures::getPictureForGrid($v->user_key, $v->file_name, md5($v->gallery_name), 70, 60);
		}

		return $pictures;
	}
	function getPicturesComments($Fields) {
		$result = $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setPreparedValues(array(
				$Fields
		))->setFetchMode('FETCH_OBJ')->executeQuery('SELECT ' . $this->table_prefix . '_pictures_comments.id,' . $this->table_prefix . '_pictures_comments.comment,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_pictures_comments
				LEFT JOIN ' . $this->table_prefix . '_users ON
				' . $this->table_prefix . '_pictures_comments.user_key= ' . $this->table_prefix . '_users.user_key
				WHERE ' . $this->table_prefix . '_pictures_comments.pic_id = ? ORDER BY ' . $this->table_prefix . '_pictures_comments.id DESC');
		/*foreach($result as $k => &$v)
		{
			$v->text = substr(strip_tags($v->text),0,100);
		}*/
		return $result;
	}
	function getPicture($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->setFetchMode('FETCH_OBJ')->executeQuery('SELECT  ' . $this->table_prefix . '_pictures.*,' . $this->table_prefix . '_users.username,' . $this->table_prefix . '_users.user_key,' . $this->table_prefix . '_galleries.gallery_name FROM ' . $this->table_prefix . '_pictures
				LEFT JOIN ' . $this->table_prefix . '_galleries
				ON ' . $this->table_prefix . '_pictures.gallery_id=' . $this->table_prefix . '_galleries.id
			 		LEFT JOIN ' . $this->table_prefix . '_users
			 			ON ' . $this->table_prefix . '_galleries.user_key=' . $this->table_prefix . '_users.user_key
					 WHERE
				' . $this->table_prefix . '_pictures.id=?')[0];
	}
	function updatePicture($Fields, $Id) {
		return $this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues(array_pad(array_values($Fields), count($Fields) + 1, $Id))->executeQuery('UPDATE ' . $this->table_prefix . '_pictures SET ' . implode(array_keys($Fields), '=?,') . ' =? WHERE id = ? ');
	}
	function deletePicture($Fields) {
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues(array(
				$Fields
		))->executeQuery('DELETE FROM ' . $this->table_prefix . '_pictures WHERE id = ? ');
	}
	function updatePictureComments($Fields, $Id) {
		return $this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues(array_pad(array_values($Fields), count($Fields) + 1, $Id))->executeQuery('UPDATE ' . $this->table_prefix . '_pictures_comments SET ' . implode(array_keys($Fields), '=?,') . ' =? WHERE id = ? ');
	}
	function deletePictureComments($Fields) {
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues(array(
				$Fields
		))->executeQuery('DELETE FROM ' . $this->table_prefix . '_pictures_comments WHERE id = ? ');
	}
	function getAllMusic() {
		$result = $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT  ' . $this->table_prefix . '_music_files.*,' . $this->table_prefix . '_users.username,' . $this->table_prefix . '_users.user_key,' . $this->table_prefix . '_music_galleries.gallery_name FROM ' . $this->table_prefix . '_music_files
				LEFT JOIN ' . $this->table_prefix . '_music_galleries
				ON ' . $this->table_prefix . '_music_files.gallery_id=' . $this->table_prefix . '_music_galleries.id
			 		LEFT JOIN ' . $this->table_prefix . '_users
			 			ON ' . $this->table_prefix . '_music_galleries.user_key=' . $this->table_prefix . '_users.user_key
					 ORDER BY
				' . $this->table_prefix . '_music_files.id DESC');
		/*foreach($result as $k => &$v)
		{
			$v->text = substr(strip_tags($v->text),0,100);
		}*/
		return $result;
	}
	function getMusic($Fields) {
		$result = $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->setFetchMode('FETCH_OBJ')->executeQuery('SELECT  ' . $this->table_prefix . '_music_files.*,' . $this->table_prefix . '_users.username,' . $this->table_prefix . '_users.user_key,' . $this->table_prefix . '_music_galleries.gallery_name FROM ' . $this->table_prefix . '_music_files
				LEFT JOIN ' . $this->table_prefix . '_music_galleries
				ON ' . $this->table_prefix . '_music_files.gallery_id=' . $this->table_prefix . '_music_galleries.id
			 		LEFT JOIN ' . $this->table_prefix . '_users
			 			ON ' . $this->table_prefix . '_music_galleries.user_key=' . $this->table_prefix . '_users.user_key
					 WHERE
				' . $this->table_prefix . '_music_files.id=?')[0];
		/*foreach($result as $k => &$v)
		{
			$v->text = substr(strip_tags($v->text),0,100);
		}*/
		return $result;
	}
	function updateMusic($Fields, $Id) {
		return $this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues(array_pad(array_values($Fields), count($Fields) + 1, $Id))->executeQuery('UPDATE ' . $this->table_prefix . '_music SET ' . implode(array_keys($Fields), '=?,') . ' =? WHERE id = ? ');
	}
	function deleteMusic($Fields) {
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues(array(
				$Fields
		))->executeQuery('DELETE FROM ' . $this->table_prefix . '_music WHERE id = ? ');
	}
	function updateMusicComments($Fields, $Id) {
		return $this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues(array_pad(array_values($Fields), count($Fields) + 1, $Id))->executeQuery('UPDATE ' . $this->table_prefix . '_music_comments SET ' . implode(array_keys($Fields), '=?,') . ' =? WHERE id = ? ');
	}
	function deleteMusicComments($Fields) {
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues(array(
				$Fields
		))->executeQuery('DELETE FROM ' . $this->table_prefix . '_music_comments WHERE id = ? ');
	}
	function getMusicComments($Fields) {
		$result = $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setPreparedValues(array(
				$Fields
		))->setFetchMode('FETCH_OBJ')->executeQuery('SELECT ' . $this->table_prefix . '_music_comments.id,' . $this->table_prefix . '_music_comments.comment,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_music_comments
				LEFT JOIN ' . $this->table_prefix . '_users ON
				' . $this->table_prefix . '_music_comments.user_key= ' . $this->table_prefix . '_users.user_key
				WHERE ' . $this->table_prefix . '_music_comments.music_id = ? ORDER BY ' . $this->table_prefix . '_music_comments.id DESC');
	/*	foreach($result as $k => &$v)
		{
			$v->text = substr(strip_tags($v->text),0,100);
		}*/
		return $result;
	}
	function getVideos() {
		$result = $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT  ' . $this->table_prefix . '_videos.*,' . $this->table_prefix . '_users.username,' . $this->table_prefix . '_users.user_key,' . $this->table_prefix . '_galleries.gallery_name FROM ' . $this->table_prefix . '_videos
				LEFT JOIN ' . $this->table_prefix . '_galleries
				ON ' . $this->table_prefix . '_videos.gallery_id=' . $this->table_prefix . '_galleries.id
			 		LEFT JOIN ' . $this->table_prefix . '_users
			 			ON ' . $this->table_prefix . '_galleries.user_key=' . $this->table_prefix . '_users.user_key
					 ORDER BY
				' . $this->table_prefix . '_videos.id DESC');
		/*foreach($result as $k => &$v)
		{
			$v->text = substr(strip_tags($v->text),0,100);
		}*/
		return $result;
	}
	function getVideosComments($Fields) {
		$result = $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setPreparedValues(array(
				$Fields
		))->setFetchMode('FETCH_OBJ')->executeQuery('SELECT ' . $this->table_prefix . '_videos_comments.id,' . $this->table_prefix . '_videos_comments.comment,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_videos_comments
				LEFT JOIN ' . $this->table_prefix . '_users ON
				' . $this->table_prefix . '_videos_comments.user_key= ' . $this->table_prefix . '_users.user_key
				WHERE ' . $this->table_prefix . '_videos_comments.video_id = ? ORDER BY ' . $this->table_prefix . '_videos_comments.id DESC');
		/*foreach($result as $k => &$v)
		{
			$v->text = substr(strip_tags($v->text),0,100);
		}*/
		return $result;
	}
	function getVideo($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->setFetchMode('FETCH_OBJ')->executeQuery('SELECT  ' . $this->table_prefix . '_videos.*,' . $this->table_prefix . '_users.username,' . $this->table_prefix . '_users.user_key,' . $this->table_prefix . '_galleries.gallery_name FROM ' . $this->table_prefix . '_videos
				LEFT JOIN ' . $this->table_prefix . '_galleries
				ON ' . $this->table_prefix . '_videos.gallery_id=' . $this->table_prefix . '_galleries.id
			 		LEFT JOIN ' . $this->table_prefix . '_users
			 			ON ' . $this->table_prefix . '_galleries.user_key=' . $this->table_prefix . '_users.user_key
					 WHERE
				' . $this->table_prefix . '_videos.id=?')[0];
	}
	function updateVideo($Fields, $Id) {
		return $this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues(array_pad(array_values($Fields), count($Fields) + 1, $Id))->executeQuery('UPDATE ' . $this->table_prefix . '_videos SET ' . implode(array_keys($Fields), '=?,') . ' =? WHERE id = ? ');
	}
	function deleteVideo($Fields) {
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues(array(
				$Fields
		))->executeQuery('DELETE FROM ' . $this->table_prefix . '_videos WHERE id = ? ');
	}
	function updateVideoComments($Fields, $Id) {
		return $this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues(array_pad(array_values($Fields), count($Fields) + 1, $Id))->executeQuery('UPDATE ' . $this->table_prefix . '_videos_comments SET ' . implode(array_keys($Fields), '=?,') . ' =? WHERE id = ? ');
	}
	function deleteVideoComments($Fields) {
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues(array(
				$Fields
		))->executeQuery('DELETE FROM ' . $this->table_prefix . '_videos_comments WHERE id = ? ');
	}
	function getGames() {
		$result = $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->table_prefix . '_flash_games ORDER BY id desc');
	/*	foreach($result as $k => &$v)
		{
			$v->text = substr(strip_tags($v->text),0,100);
		}*/
		return $result;
	}
	function editGames($Fields, $Id) {
		return $this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues(array_pad(array_values($Fields), count($Fields) + 1, $Id))->executeQuery('UPDATE ' . $this->table_prefix . '_flash_games SET ' . implode(array_keys($Fields), '=?,') . ' =? WHERE id = ? ');
	}
	function addGames($Fields) {
		return $this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues(array_values($Fields))->executeQuery('INSERT INTO ' . $this->table_prefix . '_flash_games( `title`, `description`, `tags`, `code`) VALUES(?,?,?,?) ');
	}
	function deleteGames($Fields) {
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues(array_values($Fields))->executeQuery('DELETE FROM ' . $this->table_prefix . '_flash_games WHERE id = ? ');
	}
}

?>