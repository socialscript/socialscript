<?php

namespace models;

use lib\Core\Model as Model;

class ModelUsersContent extends Model {
	function getUserPicturesGalleries() {
		return $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->table_prefix . '_galleries WHERE user_key="' . $_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key . '" ORDER BY gallery_name ASC');
	}
	function getPicturesGalleries($Fields) {
		return $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_galleries WHERE user_key= ? ORDER BY gallery_name ASC');
	}
	function getBlogCategories($userKey) {
		return $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->table_prefix . '_blog_categories WHERE user_key="' . $userKey . '" ORDER BY category ASC');
	}

	function getVideosGalleries($userKey) {
		return $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->table_prefix . '_videos_galleries WHERE user_key="' . $userKey . '" ORDER BY gallery_name ASC');
	}

	function getDefaultVideosGallery($userKey) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($userKey)->executeQuery('SELECT id FROM ' . $this->table_prefix . '_videos_galleries
				WHERE user_key = ? ORDER BY id ASC LIMIT 1')[0]->id;
	}

	function getDefaultVideos($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT ' . $this->table_prefix . '_videos.id,' . $this->table_prefix . '_videos.title,' . $this->table_prefix . '_videos.timestamp,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_videos
					LEFT JOIN ' . $this->table_prefix . '_videos_galleries
				ON ' . $this->table_prefix . '_videos.gallery_id=' . $this->table_prefix . '_videos_galleries.id
			 		LEFT JOIN ' . $this->table_prefix . '_users
			 			ON ' . $this->table_prefix . '_videos_galleries.user_key=' . $this->table_prefix . '_users.user_key
				WHERE  '. $this->table_prefix . '_videos.gallery_id = ? ORDER BY ' . $this->table_prefix . '_videos.timestamp DESC');
	}

	function getDefaultVideosLimit($Fields,$Limit) {
		return array('results' => $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT SQL_CALC_FOUND_ROWS ' . $this->table_prefix . '_videos.id,' . $this->table_prefix . '_videos.title,' . $this->table_prefix . '_videos.timestamp,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_videos
					LEFT JOIN ' . $this->table_prefix . '_videos_galleries
				ON ' . $this->table_prefix . '_videos.gallery_id=' . $this->table_prefix . '_videos_galleries.id
			 		LEFT JOIN ' . $this->table_prefix . '_users
			 			ON ' . $this->table_prefix . '_videos_galleries.user_key=' . $this->table_prefix . '_users.user_key
				WHERE  '. $this->table_prefix . '_videos.gallery_id = ? ORDER BY ' . $this->table_prefix . '_videos.timestamp DESC LIMIT ' . $Limit),
		'nr_rows' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery("SELECT FOUND_ROWS() AS nr_rows")[0]->nr_rows);
	}


	function getUserVideos($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT ' . $this->table_prefix . '_videos.id,' . $this->table_prefix . '_videos.title,' . $this->table_prefix . '_videos.timestamp,' . $this->table_prefix . '_users.username,' . $this->table_prefix . '_users.user_key FROM ' . $this->table_prefix . '_videos
					LEFT JOIN ' . $this->table_prefix . '_videos_galleries
				ON ' . $this->table_prefix . '_videos.gallery_id=' . $this->table_prefix . '_videos_galleries.id
			 		LEFT JOIN ' . $this->table_prefix . '_users
			 			ON ' . $this->table_prefix . '_videos_galleries.user_key=' . $this->table_prefix . '_users.user_key
				WHERE  '. $this->table_prefix . '_videos.gallery_id = ? AND
				'. $this->table_prefix . '_videos_galleries.user_key  = ? ORDER BY ' . $this->table_prefix . '_videos.timestamp DESC');
	}

	function getUserVideosLimit($Fields,$Limit) {
		return array('results' => $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT SQL_CALC_FOUND_ROWS ' . $this->table_prefix . '_videos.id,' . $this->table_prefix . '_videos.title,' . $this->table_prefix . '_videos.timestamp,' . $this->table_prefix . '_users.username,' . $this->table_prefix . '_users.user_key FROM ' . $this->table_prefix . '_videos
					LEFT JOIN ' . $this->table_prefix . '_videos_galleries
				ON ' . $this->table_prefix . '_videos.gallery_id=' . $this->table_prefix . '_videos_galleries.id
			 		LEFT JOIN ' . $this->table_prefix . '_users
			 			ON ' . $this->table_prefix . '_videos_galleries.user_key=' . $this->table_prefix . '_users.user_key
				WHERE  '. $this->table_prefix . '_videos.gallery_id = ? AND
				'. $this->table_prefix . '_videos_galleries.user_key  = ? ORDER BY ' . $this->table_prefix . '_videos.timestamp DESC LIMIT ' . $Limit),
				'nr_rows' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery("SELECT FOUND_ROWS() AS nr_rows")[0]->nr_rows);
	}

	function addPicturesGallery($Fields) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_galleries(user_key,gallery_name)
					VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, $Fields), ',') . ')');
		return TRUE;
	}
	function addBlogCategory($Fields) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_blog_categories(user_key,category)
				VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, $Fields), ',') . ')');
		return TRUE;
	}
	function checkGroupExists($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT COUNT(id) AS nr_rows FROM ' . $this->table_prefix . '_groups
				WHERE user_key= ? AND group_name = ? LIMIT 1')[0]->nr_rows;
	}
	function checkPicturesGalleryExists($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT COUNT(id) AS nr_rows FROM ' . $this->table_prefix . '_galleries
				WHERE user_key= ? AND gallery_name = ? LIMIT 1')[0]->nr_rows;
	}
	function getPicturesGalleryByName($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_galleries
			WHERE user_key= ? AND MD5(gallery_name) = ?')[0];
	}
	function getPicturesGalleryById($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_galleries
				WHERE user_key= ? AND id = ?')[0];
	}
	function getPicturesGalleryUpload($galleryId) {
		if($galleryId == 0) {
			return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues(array(
					$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
					'Default'
			))->executeQuery('SELECT * FROM ' . $this->table_prefix . '_galleries
					WHERE user_key= ? AND gallery_name = ?')[0];
		} else {
			return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues(array(
					$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
					$galleryId
			))->executeQuery('SELECT * FROM ' . $this->table_prefix . '_galleries
			 WHERE user_key= ? AND id = ?')[0];
		}
	}
	function getLatestPic($galleryId) {
		if($this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($galleryId)->executeQueryNrRows('SELECT id FROM ' . $this->table_prefix . '_pictures
			WHERE gallery_id= ?') < 1) {
			return 0;
		} else {

			return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($galleryId)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_pictures
			WHERE gallery_id= ? ORDER BY id DESC LIMIT 1')[0]->id;
		}
	}
	function insertPic($Fields) {
		return $this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_pictures(gallery_id,file_name,title,description,tags,timestamp)
					VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, $Fields), ',') . ')');
	}
	function getPicturesByGallery($galleryId) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($galleryId)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_pictures
				WHERE gallery_id= ? ORDER BY id DESC');
	}
	function getPicturesByGalleryLimit($galleryId,$Limit) {

		return array( 'results' => $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($galleryId)->executeQuery('SELECT SQL_CALC_FOUND_ROWS * FROM ' . $this->table_prefix . '_pictures
				WHERE gallery_id= ? ORDER BY id DESC LIMIT ' . $Limit),
		'nr_rows' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery("SELECT FOUND_ROWS() AS nr_rows")[0]->nr_rows);
	}
	function deletePicture($Fields) {
		$this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_pictures
				WHERE gallery_id = ? AND id = ?');
		return TRUE;
	}
	function deleteGroupPicture($Fields) {
		$this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_group_pictures
				WHERE group_id = ? AND id = ?');
		return TRUE;
	}
	function deleteGroupVideo($Fields) {
		$this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_group_videos
				WHERE group_id = ? AND id = ?');
		return TRUE;
	}
	function deleteGroupMusic($Fields) {
		$this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_group_music
				WHERE group_id = ? AND id = ?');
		return TRUE;
	}
	function addMusicGallery($Fields) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_music_galleries(user_key,gallery_name)
					VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, $Fields), ',') . ')');
		return TRUE;
	}
	function getMusicByGallery($galleryId) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($galleryId)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_music_files
				WHERE gallery_id= ? ORDER BY id DESC');
	}
	function getMusicGalleryByName($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_music_galleries
			WHERE user_key= ? AND MD5(gallery_name) = ?')[0];
	}
	function getMusicGalleryById($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_music_galleries
				WHERE user_key= ? AND id = ?')[0];
	}
	function getUserMusicGalleries() {
		return $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->table_prefix . '_music_galleries WHERE user_key="' . $_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key . '" ORDER BY gallery_name ASC');
	}
	function getMusicGalleryUpload($galleryId) {
		if($galleryId == 0) {
			return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues(array(
					$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
					'Default'
			))->executeQuery('SELECT * FROM ' . $this->table_prefix . '_music_galleries
					WHERE user_key= ? AND gallery_name = ?')[0];
		} else {
			return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues(array(
					$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
					$galleryId
			))->executeQuery('SELECT * FROM ' . $this->table_prefix . '_music_galleries
			 WHERE user_key= ? AND id = ?')[0];
		}
	}
	function getLatestMusic($galleryId) {
		if($this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($galleryId)->executeQueryNrRows('SELECT id FROM ' . $this->table_prefix . '_music_files
			WHERE gallery_id= ?') < 1) {
			return 0;
		} else {

			return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($galleryId)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_music_files
			WHERE gallery_id= ? ORDER BY id DESC LIMIT 1')[0]->id;
		}
	}
	function editMusic($Fields) {
		$this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('UPDATE ' . $this->table_prefix . '_music_files SET title = ?,description = ?,tags=?
			WHERE id = ? AND gallery_id = ?');
		return TRUE;
	}
	function deleteMusic($Fields) {
		$this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_music_files
				WHERE gallery_id = ? AND id = ?');
		return TRUE;
	}
	function getCategoryByName($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_blog_categories
				WHERE user_key= ? AND category = ?')[0];
	}
	function addBlog($Fields) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_blogs(user_key,category_id,title,text,timestamp)
				VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, $Fields), ',') . ')');
		return TRUE;
	}
	function getDefaultBlogCategory($userKey) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($userKey)->executeQuery('SELECT id FROM ' . $this->table_prefix . '_blog_categories
				WHERE user_key = ? ORDER BY id ASC LIMIT 1')[0]->id;
	}
	function getDefaultBlogs($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT ' . $this->table_prefix . '_blogs.id,' . $this->table_prefix . '_blogs.title,' . $this->table_prefix . '_blogs.user_key,' . $this->table_prefix . '_blogs.timestamp,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_blogs
				LEFT JOIN ' . $this->table_prefix . '_users	ON ' . $this->table_prefix . '_blogs.user_key=' . $this->table_prefix . '_users.user_key
				WHERE ' . $this->table_prefix . '_blogs.user_key= ? AND ' . $this->table_prefix . '_blogs.category_id = ? ORDER BY ' . $this->table_prefix . '_blogs.timestamp DESC');
	}
	function getDefaultBlogsLimit($Fields,$Limit) {
		return array('results' => $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT SQL_CALC_FOUND_ROWS ' . $this->table_prefix . '_blogs.id,' . $this->table_prefix . '_blogs.title,' . $this->table_prefix . '_blogs.user_key,' . $this->table_prefix . '_blogs.timestamp,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_blogs
				LEFT JOIN ' . $this->table_prefix . '_users	ON ' . $this->table_prefix . '_blogs.user_key=' . $this->table_prefix . '_users.user_key
				WHERE ' . $this->table_prefix . '_blogs.user_key= ? AND ' . $this->table_prefix . '_blogs.category_id = ? ORDER BY ' . $this->table_prefix . '_blogs.timestamp DESC LIMIT ' . $Limit),
		'nr_rows' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery("SELECT FOUND_ROWS() AS nr_rows")[0]->nr_rows
		);
	}
	function getUserBlogs($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT id,title,user_key,timestamp FROM ' . $this->table_prefix . '_blogs
				WHERE user_key= ? AND category_id = ? ORDER BY timestamp DESC');
	}
	function getUserBlogsLimit($Fields,$Limit) {
		return array('results' => $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT SQL_CALC_FOUND_ROWS id,title,user_key,timestamp FROM ' . $this->table_prefix . '_blogs
				WHERE user_key= ? AND category_id = ? ORDER BY timestamp DESC LIMIT ' . $Limit),
				'nr_rows' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery("SELECT FOUND_ROWS() AS nr_rows")[0]->nr_rows
				);
	}
	function getBlog($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT id,title,text FROM ' . $this->table_prefix . '_blogs
				WHERE user_key= ? AND id = ? LIMIT 1')[0];
	}
	function getBlogById($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT id,title,text FROM ' . $this->table_prefix . '_blogs
				WHERE  id = ? LIMIT 1')[0];
	}
	function getEventById($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT id,title,text FROM ' . $this->table_prefix . '_events
				WHERE  id = ? LIMIT 1')[0];
	}
	function getBlogByName($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->pexecuteQuery('SELECT id,title,text FROM ' . $this->table_prefix . '_blogs
				WHERE title LIKE ? LIMIT 1')[0];
	}
	function editBlog($Fields) {
		$this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('UPDATE ' . $this->table_prefix . '_blogs SET title = ?,text = ?
			WHERE id = ? AND user_key = ?');
		return TRUE;
	}
	function getUserEvents($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_events
				WHERE user_key= ?  ORDER BY timestamp DESC');
	}
	function getUserEventsLimit($Fields,$Limit) {
		return array('results' => $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT SQL_CALC_FOUND_ROWS * FROM ' . $this->table_prefix . '_events
				WHERE user_key= ?  ORDER BY timestamp DESC LIMIT ' . $Limit),
				'nr_rows' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery("SELECT FOUND_ROWS() AS nr_rows")[0]->nr_rows
				);
	}

	function addEvent($Fields) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_events(title,text,location,event_date,user_key,timestamp)
				VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, $Fields), ',') . ')');
		return TRUE;
	}
	function getEvent($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT id,title,text,location,event_date FROM ' . $this->table_prefix . '_events
				WHERE user_key= ? AND id = ? LIMIT 1')[0];
	}
	function getEventByName($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT id,title,text FROM ' . $this->table_prefix . '_events
				WHERE title= ? LIMIT 1')[0];
	}
	function editEvent($Fields) {
		$this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('UPDATE ' . $this->table_prefix . '_events SET title = ?,text = ?,location = ?,event_date = ?
				WHERE id = ? AND user_key = ?');
		return TRUE;
	}
	function getUserVideosGalleries() {
		return $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->table_prefix . '_videos_galleries WHERE user_key="' . $_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key . '" ORDER BY gallery_name ASC');
	}
	function getVideosByGallery($galleryId) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($galleryId)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_videos
				WHERE gallery_id= ? ORDER BY id DESC');
	}
	function getVideoGalleryByName($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_videos_galleries
				WHERE user_key= ? AND MD5(gallery_name) = ?')[0];
	}
	function getVideoGalleryById($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_videos_galleries
				WHERE user_key= ? AND id = ?')[0];
	}
	function addVideosGallery($Fields) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_videos_galleries(user_key,gallery_name)
				VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, $Fields), ',') . ')');
		return TRUE;
	}
	function getVideosGalleryUpload($galleryId) {
		if($galleryId == 0) {
			return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues(array(
					$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
					'Default'
			))->executeQuery('SELECT * FROM ' . $this->table_prefix . '_videos_galleries
					WHERE user_key= ? AND gallery_name = ?')[0];
		} else {
			return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues(array(
					$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
					$galleryId
			))->executeQuery('SELECT * FROM ' . $this->table_prefix . '_videos_galleries
				 WHERE user_key= ? AND id = ?')[0];
		}
	}
	function getLatestVideo($galleryId) {
		if($this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($galleryId)->executeQueryNrRows('SELECT id FROM ' . $this->table_prefix . '_videos
				WHERE gallery_id= ?') < 1) {
			return 0;
		} else {

			return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($galleryId)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_videos
					WHERE gallery_id= ? ORDER BY id DESC LIMIT 1')[0]->id;
		}
	}
	function insertVideo($Fields) {
		return $this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_videos(gallery_id,file_name,title,description,tags,timestamp)
				VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, $Fields), ',') . ')');
	}
	function deleteVideo($Fields) {
		$this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_videos
				WHERE gallery_id = ? AND id = ?');
		return TRUE;
	}
	function getVideosGalleryByName($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_videos_galleries
				WHERE user_key= ? AND MD5(gallery_name) = ?')[0];
	}
	function getVideo($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_videos
				WHERE id= ? AND gallery_id = ?')[0];
	}
	function editVideo($Fields) {
		$this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('UPDATE ' . $this->table_prefix . '_videos SET title = ?,description = ?,tags=?
			WHERE id = ? AND gallery_id = ?');
		return TRUE;
	}
	function getUserGroups($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_groups
				WHERE user_key= ?  ORDER BY timestamp DESC');
	}
	function addGroup($Fields) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_groups(user_key,group_name,group_description,privacy,group_location,timestamp)
				VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, $Fields), ',') . ')');
		return TRUE;
	}
	function getGroup($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_groups
				WHERE  id = ? LIMIT 1')[0];
	}
	function getGroupByName($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_groups
				WHERE  group_name = ? LIMIT 1')[0];
	}
	function editGroup($Fields) {
		$this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('UPDATE ' . $this->table_prefix . '_groups SET group_name = ?,group_description = ?,privacy = ?,group_location = ?
				WHERE id = ? AND user_key = ?');
		return TRUE;
	}
	function getGroups($Fields) {
		return array(
				'results' => $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT SQL_CALC_FOUND_ROWS * FROM ' . $this->table_prefix . '_groups
				WHERE user_key = ? ORDER BY timestamp DESC'),
				'nr_rows' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery("SELECT FOUND_ROWS() AS nr_rows")[0]->nr_rows
		);
	}
	function getGroupsLimit($Fields,$Limit) {
		return array(
				'results' => $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT SQL_CALC_FOUND_ROWS * FROM ' . $this->table_prefix . '_groups
				WHERE user_key = ? ORDER BY timestamp DESC LIMIT ' . $Limit),
				'nr_rows' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery("SELECT FOUND_ROWS() AS nr_rows")[0]->nr_rows
		);
	}
	function getLatestGroupPic($groupId) {
		if($this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($groupId)->executeQueryNrRows('SELECT id FROM ' . $this->table_prefix . '_group_pictures
			WHERE group_id= ?') < 1) {
			return 0;
		} else {

			return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($groupId)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_group_pictures
			WHERE group_id= ? ORDER BY id DESC LIMIT 1')[0]->id;
		}
	}
	function insertGroupPic($Fields) {
		return $this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_group_pictures(group_id,user_key,file_name,title,description,tags,timestamp)
					VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, $Fields), ',') . ')');
	}
	function getLatestGroupVideo($groupId) {
		if($this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($groupId)->executeQueryNrRows('SELECT id FROM ' . $this->table_prefix . '_group_videos
			WHERE group_id= ?') < 1) {
			return 0;
		} else {

			return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($groupId)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_group_videos
			WHERE group_id= ? ORDER BY id DESC LIMIT 1')[0]->id;
		}
	}
	function insertGroupVideo($Fields) {
		return $this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_group_videos(group_id,user_key,file_name,title,description,tags,timestamp)
					VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, $Fields), ',') . ')');
	}
	function getLatestGroupMusic($groupId) {
		if($this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($groupId)->executeQueryNrRows('SELECT id FROM ' . $this->table_prefix . '_group_music
			WHERE group_id= ?') < 1) {
			return 0;
		} else {

			return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($groupId)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_group_music
			WHERE group_id= ? ORDER BY id DESC LIMIT 1')[0]->id;
		}
	}
	function insertGroupMusic($Fields) {
		return $this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_group_music(group_id,user_key,file_name,title,description,tags,timestamp)
					VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, $Fields), ',') . ')');
	}
	function getPictures($Limit) {
		return array(
				'results' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT SQL_CALC_FOUND_ROWS ' . $this->table_prefix . '_pictures.*,' . $this->table_prefix . '_users.username,' . $this->table_prefix . '_users.user_key,' . $this->table_prefix . '_galleries.gallery_name FROM ' . $this->table_prefix . '_pictures
				LEFT JOIN ' . $this->table_prefix . '_galleries
				ON ' . $this->table_prefix . '_pictures.gallery_id=' . $this->table_prefix . '_galleries.id
			 		LEFT JOIN ' . $this->table_prefix . '_users
			 			ON ' . $this->table_prefix . '_galleries.user_key=' . $this->table_prefix . '_users.user_key
					 ORDER BY
				' . $this->table_prefix . '_pictures.id DESC LIMIT ' . $Limit),
				'nr_rows' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery("SELECT FOUND_ROWS() AS nr_rows")[0]->nr_rows
		);
	}
	function getEvents($Limit) {
		return array(
				'results' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT SQL_CALC_FOUND_ROWS ' . $this->table_prefix . '_events.*,' . $this->table_prefix . '_users.user_key,' . $this->table_prefix . '_users.username FROM  ' . $this->table_prefix . '_events
			 		LEFT JOIN ' . $this->table_prefix . '_users
			 			ON ' . $this->table_prefix . '_events.user_key=' . $this->table_prefix . '_users.user_key
					 ORDER BY
				' . $this->table_prefix . '_events.id DESC LIMIT ' . $Limit),
				'nr_rows' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery("SELECT FOUND_ROWS() AS nr_rows")[0]->nr_rows
		);
	}
	function getBlogs($Limit) {
		return array(
				'results' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT  SQL_CALC_FOUND_ROWS ' . $this->table_prefix . '_blogs.*,' . $this->table_prefix . '_users.username FROM  ' . $this->table_prefix . '_blogs
			 		LEFT JOIN ' . $this->table_prefix . '_users
			 			ON ' . $this->table_prefix . '_blogs.user_key=' . $this->table_prefix . '_users.user_key
					 ORDER BY
				' . $this->table_prefix . '_blogs.id DESC LIMIT ' . $Limit),
				'nr_rows' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery("SELECT FOUND_ROWS() AS nr_rows")[0]->nr_rows
		);
	}
	function insertMusic($Fields) {
		return $this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_music_files(gallery_id,file_name,title,description,tags,timestamp)
					VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, $Fields), ',') . ')');
	}
	function getMusic($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_music_files
				WHERE id= ? AND gallery_id = ?')[0];
	}
	function getPicture($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_pictures
				WHERE id= ? AND gallery_id = ?')[0];
	}
	function getGroupPicture($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_group_pictures
				WHERE id= ? AND group_id = ?')[0];
	}
	function getGroupVideo($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_group_videos
				WHERE id= ? AND group_id = ?')[0];
	}
	function editPicture($Fields) {
		$this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('UPDATE ' . $this->table_prefix . '_pictures SET title = ?,description = ?,tags=?
			WHERE id = ? AND gallery_id = ?');
		return TRUE;
	}
	function getPictureGalleryById($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->pexecuteQuery('SELECT * FROM ' . $this->table_prefix . '_galleries
				WHERE user_key= ? AND id = ?')[0];
	}
	function getGroupPicturesByGallery($galleryId) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($galleryId)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_group_pictures
				WHERE group_id= ? ORDER BY id DESC');
	}
	function getGroupVideosByGallery($galleryId) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($galleryId)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_group_videos
				WHERE group_id= ? ORDER BY id DESC');
	}
	function getGroupMusicByGallery($galleryId) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($galleryId)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_group_music
				WHERE group_id= ? ORDER BY id DESC');
	}
	function getGroupMusic($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_group_music
				WHERE id= ? AND group_id = ?')[0];
	}
	function getGames($Limit) {
		return array(
				'results' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->table_prefix . '_flash_games ORDER BY id desc LIMIT ' . $Limit),
				'nr_rows' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery("SELECT FOUND_ROWS() AS nr_rows")[0]->nr_rows
		);
	}
	function getGame($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_flash_games
				WHERE  id = ? LIMIT 1')[0];
	}
	function getUserExtraSections($userId,$Type) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues(array($userId))->executeQuery('SELECT * FROM ' . $this->table_prefix . '_' . $Type . '
				WHERE user_key= ? ORDER BY id DESC');
	}
	function getExtraSection($userId,$Id,$Type) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues(array($userId,$Id))->executeQuery('SELECT id,title,text FROM ' . $this->table_prefix . '_' . $Type . '
				WHERE user_key = ? AND  id= ? LIMIT 1')[0];
	}
	function editExtraSection($Fields,$Type) {
		$this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('UPDATE ' . $this->table_prefix . '_' . $Type . ' SET title = ?,text = ?
			WHERE id = ? AND user_key = ?');
		return TRUE;
	}


	function getMusicGalleries($userKey) {
		return $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->table_prefix . '_music_galleries WHERE user_key="' . $userKey . '" ORDER BY gallery_name ASC');
	}

	function getDefaultMusicGallery($userKey) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($userKey)->executeQuery('SELECT id FROM ' . $this->table_prefix . '_music_galleries
				WHERE user_key = ? ORDER BY id ASC LIMIT 1')[0]->id;
	}

	function getDefaultMusic($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT ' . $this->table_prefix . '_music_files.id,' . $this->table_prefix . '_music_files.title,' . $this->table_prefix . '_music_files.timestamp,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_music_files
					LEFT JOIN ' . $this->table_prefix . '_music_galleries
				ON ' . $this->table_prefix . '_music_files.gallery_id=' . $this->table_prefix . '_music_galleries.id
			 		LEFT JOIN ' . $this->table_prefix . '_users
			 			ON ' . $this->table_prefix . '_music_galleries.user_key=' . $this->table_prefix . '_users.user_key
				WHERE  '. $this->table_prefix . '_music_files.gallery_id = ? ORDER BY ' . $this->table_prefix . '_music_files.timestamp DESC');
	}

	function getDefaultMusicLimit($Fields,$Limit) {
		return array('results' => $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT SQL_CALC_FOUND_ROWS ' . $this->table_prefix . '_music_files.id,' . $this->table_prefix . '_music_files.title,' . $this->table_prefix . '_music_files.timestamp,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_music_files
					LEFT JOIN ' . $this->table_prefix . '_music_galleries
				ON ' . $this->table_prefix . '_music_files.gallery_id=' . $this->table_prefix . '_music_galleries.id
			 		LEFT JOIN ' . $this->table_prefix . '_users
			 			ON ' . $this->table_prefix . '_music_galleries.user_key=' . $this->table_prefix . '_users.user_key
				WHERE  '. $this->table_prefix . '_music_files.gallery_id = ? ORDER BY ' . $this->table_prefix . '_music_files.timestamp DESC LIMIT ' . $Limit),
				'nr_rows' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery("SELECT FOUND_ROWS() AS nr_rows")[0]->nr_rows);
	}


	function getUserMusic($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT ' . $this->table_prefix . '_music_files.id,' . $this->table_prefix . '_music_files.title,' . $this->table_prefix . '_music_files.timestamp,' . $this->table_prefix . '_users.username,' . $this->table_prefix . '_users.user_key FROM ' . $this->table_prefix . '_music_files
					LEFT JOIN ' . $this->table_prefix . '_music_galleries
				ON ' . $this->table_prefix . '_music_files.gallery_id=' . $this->table_prefix . '_music_galleries.id
			 		LEFT JOIN ' . $this->table_prefix . '_users
			 			ON ' . $this->table_prefix . '_music_galleries.user_key=' . $this->table_prefix . '_users.user_key
				WHERE  '. $this->table_prefix . '_music_files.gallery_id = ? AND
				'. $this->table_prefix . '_music_galleries.user_key  = ? ORDER BY ' . $this->table_prefix . '_music_files.timestamp DESC');
	}

	function getUserMusicLimit($Fields,$Limit) {
		return array('results' => $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT SQL_CALC_FOUND_ROWS ' . $this->table_prefix . '_music_files.id,' . $this->table_prefix . '_music_files.title,' . $this->table_prefix . '_music_files.timestamp,' . $this->table_prefix . '_users.username,' . $this->table_prefix . '_users.user_key FROM ' . $this->table_prefix . '_music_files
					LEFT JOIN ' . $this->table_prefix . '_music_galleries
				ON ' . $this->table_prefix . '_music_files.gallery_id=' . $this->table_prefix . '_music_galleries.id
			 		LEFT JOIN ' . $this->table_prefix . '_users
			 			ON ' . $this->table_prefix . '_music_galleries.user_key=' . $this->table_prefix . '_users.user_key
				WHERE  '. $this->table_prefix . '_music_files.gallery_id = ? AND
				'. $this->table_prefix . '_music_galleries.user_key  = ? ORDER BY ' . $this->table_prefix . '_music_files.timestamp DESC LIMIT ' . $Limit ),
				'nr_rows' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery("SELECT FOUND_ROWS() AS nr_rows")[0]->nr_rows);


	}
}

?>