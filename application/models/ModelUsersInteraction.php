<?php

namespace models;

use lib\Core\Model as Model;

class ModelUsersInteraction extends Model {
	function addFriend($Fields) {
		$friend_exist = $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues(array_merge(array_values(array_slice($Fields, 0, 2)), array_values(array_slice($Fields, 0, 2))))->executeQueryNrRows('SELECT * FROM ' . $this->table_prefix . '_friends
				WHERE (user_key= ? AND friend_key = ?) OR (friend_key= ? AND user_key = ?)');
		if($friend_exist < 1) {
			$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues(array_values($Fields))->executeQuery('INSERT INTO ' . $this->table_prefix . '_friends(user_key,friend_key,status)
				VALUES(' . implode(array_map(function ($value) {
				return '?';
			}, $Fields), ',') . ')');
			return TRUE;
		} else {
			return FALSE;
		}
	}
	function sayHello($Fields) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues(array_values($Fields))->executeQuery('INSERT INTO ' . $this->table_prefix . '_say_hello(user_key,friend_key,timestamp)
					VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, $Fields), ',') . ')');
		return TRUE;
	}
	function markInterestedIn($Fields) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues(array_values($Fields))->executeQuery('INSERT INTO ' . $this->table_prefix . '_mark_interested_in(user_key,friend_key,timestamp)
				VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, $Fields), ',') . ')');
		return TRUE;
	}
	function askQuestion($Fields) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues(array_values($Fields))->executeQuery('INSERT INTO ' . $this->table_prefix . '_ask_questions(user_key,friend_key,question,timestamp)
				VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, $Fields), ',') . ')');
		return TRUE;
	}
	function getOnlineFriends() {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		))->executeQuery('SELECT * FROM ' . $this->table_prefix . '_friends
				WHERE user_key= ? AND status="1"');
	}
	function subscribeToPictures($Fields) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_pictures_subscribe(to_key,from_key)
				VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, $Fields), ',') . ')');
	}
	function subscribeToEvents($Fields) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_events_subscribe(to_key,from_key)
				VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, $Fields), ',') . ')');
	}
	function subscribeToBlog($Fields) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_blog_subscribe(to_key,from_key)
				VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, $Fields), ',') . ')');
	}
	function getEventsSubscribers($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_events_subscribe
				WHERE to_key= ?');
	}
	function getPicturesSubscribers($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_pictures_subscribe
				WHERE to_key= ?');
	}
	function getAttending($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_events_invites
				WHERE event_id= ? AND status="1"');
	}
	function getBlogSubscribers($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_blog_subscribe
				WHERE to_key= ?');
	}
	function getEventsToInvite($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_events
				WHERE user_key= ? AND event_date > ?');
	}
	function inviteToEvent($Fields) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_events_invites(from_key,to_key,event,status)
				VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, $Fields), ',') . ')');
	}
	function addBlogComment($Fields) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_blogs_comments(blog_id,user_key,comment,timestamp)
				VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, $Fields), ',') . ')');
	}
	function checkEventExists($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT COUNT(id) AS nr_rows FROM ' . $this->table_prefix . '_events
				WHERE user_key= ? AND id = ? LIMIT 1')[0]->nr_rows;
	}
	function checkInvitedToEvent($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT COUNT(id) AS nr_rows FROM ' . $this->table_prefix . '_events_invites
				WHERE from_key= ? AND to_key = ? AND event = ? LIMIT 1')[0]->nr_rows;
	}
	function getPicturesComments($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT   ' . $this->table_prefix . '_pictures_comments.*,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_pictures_comments
				LEFT JOIN ' . $this->table_prefix . '_users ON ' . $this->table_prefix . '_pictures_comments.user_key = ' . $this->table_prefix . '_users.user_key
				WHERE pic_id= ? ORDER BY id DESC');
	}
	function addPictureComment($Fields) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_pictures_comments(pic_id,user_key,comment,timestamp)
				VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, $Fields), ',') . ')');
	}
	function getBlogComments($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT  ' . $this->table_prefix . '_blogs_comments.*,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_blogs_comments
				LEFT JOIN ' . $this->table_prefix . '_users ON ' . $this->table_prefix . '_blogs_comments.user_key = ' . $this->table_prefix . '_users.user_key
				WHERE blog_id= ? ORDER BY id DESC');
	}
	function getEventComments($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT ' . $this->table_prefix . '_events_comments.*,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_events_comments
				LEFT JOIN ' . $this->table_prefix . '_users ON ' . $this->table_prefix . '_events_comments.user_key = ' . $this->table_prefix . '_users.user_key
				WHERE event_id= ? ORDER BY id DESC');
	}
	function addEventComment($Fields) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_events_comments(event_id,user_key,comment,timestamp)
				VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, $Fields), ',') . ')');
	}
	function sendMessage($Fields) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_messages(to_key,from_key,title,message,timestamp)
				VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, $Fields), ',') . ')');
	}
	function getMessages($Fields, $Limit) {
		return array(
				'results' => $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT SQL_CALC_FOUND_ROWS ' . $this->table_prefix . '_messages.*,' . $this->table_prefix . '_users.username,' . $this->table_prefix . '_users.user_key FROM ' . $this->table_prefix . '_messages
			LEFT JOIN ' . $this->table_prefix . '_users	ON ' . $this->table_prefix . '_messages.from_key=' . $this->table_prefix . '_users.user_key WHERE ' . $this->table_prefix . '_messages.to_key = ? ORDER BY ' . $this->table_prefix . '_messages.timestamp DESC LIMIT ' . $Limit),
				'nr_rows' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery("SELECT FOUND_ROWS() AS nr_rows")[0]->nr_rows
		);
	}
	function getHellos($Fields, $Limit) {
		return array(
				'results' => $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT SQL_CALC_FOUND_ROWS ' . $this->table_prefix . '_say_hello.*,' . $this->table_prefix . '_users.username,' . $this->table_prefix . '_users.user_key FROM ' . $this->table_prefix . '_say_hello
			LEFT JOIN ' . $this->table_prefix . '_users	ON ' . $this->table_prefix . '_say_hello.friend_key=' . $this->table_prefix . '_users.user_key WHERE ' . $this->table_prefix . '_say_hello.friend_key = ? ORDER BY ' . $this->table_prefix . '_say_hello.timestamp DESC LIMIT ' . $Limit),
				'nr_rows' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery("SELECT FOUND_ROWS() AS nr_rows")[0]->nr_rows
		);
	}
	function getMarkedInterestedIn($Fields, $Limit) {
		return array(
				'results' => $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT SQL_CALC_FOUND_ROWS ' . $this->table_prefix . '_mark_interested_in.*,' . $this->table_prefix . '_users.username,' . $this->table_prefix . '_users.user_key FROM ' . $this->table_prefix . '_mark_interested_in
			LEFT JOIN ' . $this->table_prefix . '_users	ON ' . $this->table_prefix . '_mark_interested_in.user_key=' . $this->table_prefix . '_users.user_key WHERE ' . $this->table_prefix . '_mark_interested_in.friend_key = ? ORDER BY ' . $this->table_prefix . '_mark_interested_in.timestamp DESC LIMIT ' . $Limit),
				'nr_rows' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery("SELECT FOUND_ROWS() AS nr_rows")[0]->nr_rows
		);
	}
	function getUnreadMessages($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_messages
				WHERE to_key = ? AND message_read = "0" ORDER BY timestamp DESC');
	}
	function deleteMessage($Fields) {
		$this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_messages
				WHERE to_key = ? AND id = ?');
	}
	function markMessageRead($Fields) {
		$this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('UPDATE ' . $this->table_prefix . '_messages
				SET message_read = "1" WHERE to_key = ? AND id = ?');
	}
	function getNewFriendsRequests($Fields, $Limit) {
		return array(
				'results' => $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT SQL_CALC_FOUND_ROWS ' . $this->table_prefix . '_friends.*,' . $this->table_prefix . '_users.username,' . $this->table_prefix . '_users.gender FROM ' . $this->table_prefix . '_friends
				LEFT JOIN ' . $this->table_prefix . '_users	ON ' . $this->table_prefix . '_friends.friend_key=' . $this->table_prefix . '_users.user_key
				WHERE ' . $this->table_prefix . '_friends.user_key = ?  	AND status="0"
				GROUP BY ' . $this->table_prefix . '_friends.user_key LIMIT ' . $Limit),
				'nr_rows' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery("SELECT FOUND_ROWS() AS nr_rows")[0]->nr_rows
		);
	}
	function getNewFriendsRequestsMyAccount($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT  ' . $this->table_prefix . '_friends.*,' . $this->table_prefix . '_users.username,' . $this->table_prefix . '_users.gender FROM ' . $this->table_prefix . '_friends
				LEFT JOIN ' . $this->table_prefix . '_users	ON ' . $this->table_prefix . '_friends.friend_key=' . $this->table_prefix . '_users.user_key
				WHERE ' . $this->table_prefix . '_friends.user_key = ?  	AND status="0"
				GROUP BY ' . $this->table_prefix . '_friends.user_key');
	}
	function getFriends($Fields, $Limit) {
		return array(
				'results' => $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT SQL_CALC_FOUND_ROWS ' . $this->table_prefix . '_friends.*,' . $this->table_prefix . '_users.gender,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_friends
				LEFT JOIN ' . $this->table_prefix . '_users	ON ' . $this->table_prefix . '_friends.friend_key=' . $this->table_prefix . '_users.user_key
				WHERE ' . $this->table_prefix . '_friends.user_key = ?  AND status="1"  LIMIT ' . $Limit),
				'nr_rows' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery("SELECT FOUND_ROWS() AS nr_rows")[0]->nr_rows
		);
	}
	function getFriendsRequests($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_friends
				WHERE user_key = ?  AND status="0" ');
	}
	function acceptFriendRequest($Fields) {
		$this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('UPDATE ' . $this->table_prefix . '_friends
				SET status = "1" WHERE user_key = ? AND friend_key = ?');

		return $this;
	}
	function notifyFriendRequestAccepted($Fields) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_messages(to_key,from_key,title,message,timestamp)
				VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, $Fields), ',') . ')');

		return $this;
	}
	function denyFriendRequest($Fields) {
		$this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_friends
				WHERE user_key = ? AND friend_key = ?');
		return $this;
	}
	function notifyFriendRequestDenied($Fields) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_messages(to_key,from_key,title,message,timestamp)
				VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, $Fields), ',') . ')');
	}
	function addFriend2($Fields) {
		$friend_exist = $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues(array_merge(array_values(array_slice($Fields, 0, 2))))->executeQueryNrRows('SELECT * FROM ' . $this->table_prefix . '_friends
				WHERE user_key= ? AND friend_key = ?');
		if($friend_exist < 1) {
			$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues(array(
					$Fields[1],
					$Fields[0],
					$Fields[2]
			))->executeQuery('INSERT INTO ' . $this->table_prefix . '_friends(user_key,friend_key,status)
				VALUES(?,?,?)');
			return TRUE;
		} else {
			$this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues(array_values(array_slice($Fields, 0, 2)))->executeQuery('UPDATE ' . $this->table_prefix . '_friends
				SET status = "1" WHERE user_key = ? AND friend_key = ?');
		}

		$friend_exist = $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues(array_merge(array_values(array_slice($Fields, 0, 2)), array_values(array_slice($Fields, 0, 2))))->executeQueryNrRows('SELECT * FROM ' . $this->table_prefix . '_friends
				WHERE friend_key= ? AND user_key = ?');
		if($friend_exist < 1) {
			$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues(array(
					$Fields[1],
					$Fields[0],
					$Fields[2]
			))->executeQuery('INSERT INTO ' . $this->table_prefix . '_friends(user_key,friend_key,status)
				VALUES(?,?,?)');
			return TRUE;
		} else {

			$this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues(array_values(array_slice($Fields, 0, 2)))->executeQuery('UPDATE ' . $this->table_prefix . '_friends
				SET status = "1" WHERE user_key = ? AND friend_key = ?');
		}
	}
	function getGroups($Limit) {
		return array(
				'results' => $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->executeQuery('SELECT SQL_CALC_FOUND_ROWS ' . $this->table_prefix . '_groups.*,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_groups
				LEFT JOIN ' . $this->table_prefix . '_users	ON ' . $this->table_prefix . '_groups.user_key=' . $this->table_prefix . '_users.user_key
				  ORDER BY ' . $this->table_prefix . '_groups.timestamp DESC  LIMIT ' . $Limit),
				'nr_rows' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery("SELECT FOUND_ROWS() AS nr_rows")[0]->nr_rows
		);
	}
	function getGroupSubscribers($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_group_subscribe
				WHERE to_key= ?');
	}
	function subscribeToGroup($Fields) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_group_subscribe(to_key,from_key)
				VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, $Fields), ',') . ')');
	}
	function checkIfUserAlreadGroupMember($Fields)
	{
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQueryNrRows('SELECT COUNT(id) FROM ' . $this->table_prefix . '_group_members
				WHERE user_key= ? AND group_id = ?');
	}
	function joinGroup($Fields) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_group_members(group_id,user_key,timestamp)
				VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, $Fields), ',') . ')');
	}
	function getGroupComments($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_groups_comments
				WHERE group_id= ? ORDER BY timestamp DESC');
	}
	function getMembers($userKey,$Fields) {
		return array_merge($this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($userKey)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_users
				WHERE ' . $this->table_prefix . '_users.user_key= ?'),$this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT  ' . $this->table_prefix . '_group_members.*,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_group_members
				LEFT JOIN ' . $this->table_prefix . '_users	ON ' . $this->table_prefix . '_group_members.user_key=' . $this->table_prefix . '_users.user_key
				WHERE group_id= ? ORDER BY timestamp DESC'));
	}
	function addGroupComment($Fields) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_groups_comments(group_id,user_key,comment,timestamp)
				VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, $Fields), ',') . ')');
	}
	function addGroupBlog($Fields) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_group_blogs(user_key,group_id,title,text,timestamp)
				VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, $Fields), ',') . ')');
		return TRUE;
	}
	function getGroupBlogs($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT ' . $this->table_prefix . '_group_blogs.*,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_group_blogs
				LEFT JOIN ' . $this->table_prefix . '_users ON ' . $this->table_prefix . '_group_blogs.user_key = ' . $this->table_prefix . '_users.user_key
				WHERE ' . $this->table_prefix . '_group_blogs.group_id = ? ORDER BY timestamp DESC');
	}
	function getGroupBlog($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT id,title,text FROM ' . $this->table_prefix . '_group_blogs
				WHERE  id = ? LIMIT 1')[0];
	}
	function getGroupBlogComments($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT ' . $this->table_prefix . '_group_blogs_comments.*,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_group_blogs_comments
				LEFT JOIN ' . $this->table_prefix . '_users ON ' . $this->table_prefix . '_group_blogs_comments.user_key = ' . $this->table_prefix . '_users.user_key
				WHERE blog_id= ? ORDER BY timestamp DESC');
	}
	function addGroupBlogComment($Fields) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_group_blogs_comments(blog_id,user_key,comment,timestamp)
				VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, $Fields), ',') . ')');
	}
	function getGroupPictures($galleryId) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($galleryId)->executeQuery('SELECT ' . $this->table_prefix . '_group_pictures.*,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_group_pictures
				LEFT JOIN ' . $this->table_prefix . '_users ON ' . $this->table_prefix . '_group_pictures.user_key = ' . $this->table_prefix . '_users.user_key
				WHERE ' . $this->table_prefix . '_group_pictures.group_id= ? ORDER BY id DESC');
	}
	function getGroupPicture($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_group_pictures
				WHERE  id = ? LIMIT 1')[0];
	}
	function getGroupPicturesComments($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT   ' . $this->table_prefix . '_group_pictures_comments.*,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_group_pictures_comments
				LEFT JOIN ' . $this->table_prefix . '_users ON ' . $this->table_prefix . '_group_pictures_comments.user_key = ' . $this->table_prefix . '_users.user_key
				WHERE picture_id= ? ORDER BY id DESC');
	}
	function getGroupVideosComments($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT   ' . $this->table_prefix . '_group_videos_comments.*,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_group_videos_comments
				LEFT JOIN ' . $this->table_prefix . '_users ON ' . $this->table_prefix . '_group_videos_comments.user_key = ' . $this->table_prefix . '_users.user_key
				WHERE video_id= ? ORDER BY id DESC');
	}
	function getGroupVideo($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_group_videos
				WHERE  id = ? LIMIT 1')[0];
	}
	function getGroupMusic($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_group_music
				WHERE  id = ? LIMIT 1')[0];
	}
	function getGroup($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_groups
				WHERE  id = ? LIMIT 1')[0];
	}
	function getGroupEvents($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT ' . $this->table_prefix . '_group_events.*,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_group_events
				LEFT JOIN ' . $this->table_prefix . '_users ON ' . $this->table_prefix . '_group_events.user_key = ' . $this->table_prefix . '_users.user_key
				WHERE ' . $this->table_prefix . '_group_events.group_id = ? ORDER BY timestamp DESC');
	}
	function addGroupEvent($Fields) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_group_events(group_id,title,text,location,event_date,user_key,timestamp)
				VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, $Fields), ',') . ')');
		return TRUE;
	}
	function getGroupEvent($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_group_events
				WHERE  id = ? LIMIT 1')[0];
	}
	function getGroupEventComments($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT ' . $this->table_prefix . '_group_events_comments.*,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_group_events_comments
				LEFT JOIN ' . $this->table_prefix . '_users ON ' . $this->table_prefix . '_group_events_comments.user_key = ' . $this->table_prefix . '_users.user_key
				WHERE event_id= ? ORDER BY timestamp DESC');
	}
	function addGroupEventComment($Fields) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_group_events_comments(event_id,user_key,comment,timestamp)
				VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, $Fields), ',') . ')');
	}
	function addGroupPictureComment($Fields) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_group_pictures_comments(picture_id,user_key,comment,timestamp)
				VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, $Fields), ',') . ')');
	}
	function addGroupVideoComment($Fields) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_group_videos_comments(video_id,user_key,comment,timestamp)
				VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, $Fields), ',') . ')');
	}
	function addGroupMusicComment($Fields) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_group_music_comments(music_id,user_key,comment,timestamp)
				VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, $Fields), ',') . ')');
	}
	function getBestFriends($Fields, $Limit) {
		return array(
				'results' => $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT SQL_CALC_FOUND_ROWS ' . $this->table_prefix . '_friends.*,' . $this->table_prefix . '_users.username,' . $this->table_prefix . '_users.gender FROM ' . $this->table_prefix . '_friends
				LEFT JOIN ' . $this->table_prefix . '_users	ON ' . $this->table_prefix . '_friends.friend_key=' . $this->table_prefix . '_users.user_key
				WHERE ' . $this->table_prefix . '_friends.user_key = ?  AND best_friend="1" AND status="1"  LIMIT ' . $Limit),
				'nr_rows' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery("SELECT FOUND_ROWS() AS nr_rows")[0]->nr_rows
		);
	}
	function getFamilyFriends($Fields, $Limit) {
		return array(
				'results' => $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT SQL_CALC_FOUND_ROWS ' . $this->table_prefix . '_friends.*,' . $this->table_prefix . '_users.username,' . $this->table_prefix . '_users.gender FROM ' . $this->table_prefix . '_friends
				LEFT JOIN ' . $this->table_prefix . '_users	ON ' . $this->table_prefix . '_friends.friend_key=' . $this->table_prefix . '_users.user_key
				WHERE ' . $this->table_prefix . '_friends.user_key = ?  AND family="1" AND status="1"  LIMIT ' . $Limit),
				'nr_rows' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery("SELECT FOUND_ROWS() AS nr_rows")[0]->nr_rows
		);
	}
	function markBestFriend($Fields) {
		$this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('UPDATE ' . $this->table_prefix . '_friends
SET best_friend="1" WHERE user_key = ? AND friend_key = ?');
		return TRUE;
	}
	function unmarkBestFriend($Fields) {
		$this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('UPDATE ' . $this->table_prefix . '_friends
SET best_friend="0" WHERE user_key = ? AND friend_key = ?');
		return TRUE;
	}
	function markFamily($Fields) {
		$this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('UPDATE ' . $this->table_prefix . '_friends
				SET family="1" WHERE user_key = ? AND friend_key = ?');
		return TRUE;
	}
	function unmarkFamily($Fields) {
		$this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('UPDATE ' . $this->table_prefix . '_friends
				SET family="0" WHERE user_key = ? AND friend_key = ?');
		return TRUE;
	}
	function getMusic($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT  ' . $this->table_prefix . '_music_files.*,' . $this->table_prefix . '_music_galleries.gallery_name,' . $this->table_prefix . '_music_galleries.user_key FROM ' . $this->table_prefix . '_music_files
				LEFT JOIN ' . $this->table_prefix . '_music_galleries ON ' . $this->table_prefix . '_music_files.gallery_id = ' . $this->table_prefix . '_music_galleries.id
				WHERE  ' . $this->table_prefix . '_music_files.id = ? LIMIT 1')[0];
	}
	function getMusicByName($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT  ' . $this->table_prefix . '_music_files.*,' . $this->table_prefix . '_music_galleries.gallery_name,' . $this->table_prefix . '_music_galleries.user_key FROM ' . $this->table_prefix . '_music_files
				LEFT JOIN ' . $this->table_prefix . '_music_galleries ON ' . $this->table_prefix . '_music_files.gallery_id = ' . $this->table_prefix . '_music_galleries.id
				WHERE  ' . $this->table_prefix . '_music_files.title = ? LIMIT 1')[0];
	}
	function getTotalNrFriends($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQueryNrRows('SELECT COUNT(id) FROM ' . $this->table_prefix . '_friends
				WHERE user_key= ? AND best_friend="0" AND family="0" AND status="1"');
	}
	function getTotalNrBestFriends($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQueryNrRows('SELECT COUNT(id)  FROM ' . $this->table_prefix . '_best_friends
				WHERE user_key= ? AND best_friend="1" AND family="0" AND status="1"');
	}
	function getTotalNrFamily($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQueryNrRows('SELECT COUNT(id)  FROM ' . $this->table_prefix . '_best_friends
				WHERE user_key= ? AND best_friend="0" AND family="1" AND status="1"');
	}
	function getTotalUserGroups($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQueryNrRows('SELECT COUNT(id)  FROM ' . $this->table_prefix . '_groups
				WHERE user_key= ? ');
	}
	function getTotalUserEvents($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQueryNrRows('SELECT COUNT(id) FROM ' . $this->table_prefix . '_events
				WHERE user_key= ? ');
	}
	function getTotalUserBlogs($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQueryNrRows('SELECT COUNT(id) FROM ' . $this->table_prefix . '_blogs
				WHERE user_key= ? ');
	}
	function getUserUpcomingEvents($Fields) {
		$result =  $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT id,title,location,user_key FROM ' . $this->table_prefix . '_events
				WHERE user_key = ? AND event_date >  "' . date('Y-m-d') . '"  ORDER BY timestamp DESC');
			foreach($result as $k => &$v) {

			$v->safe_seo_url = \helpers\Utils::safe_url($v->title);
		}
		return $result;
	}
	function getUserUpcomingEventsToAttend($Fields) {
		$result =  $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT ' . $this->table_prefix . '_events.* FROM ' . $this->table_prefix . '_events_invites
				LEFT JOIN ' . $this->table_prefix . '_events
				ON ' . $this->table_prefix . '_events_invites.event=' . $this->table_prefix . '_events.id
				WHERE ' . $this->table_prefix . '_events_invites.to_key = ? AND ' . $this->table_prefix . '_events.event_date >  "' . date('Y-m-d') . '" AND ' . $this->table_prefix . '_events_invites.status="1"  ORDER BY ' . $this->table_prefix . '_events.timestamp DESC');
			foreach($result as $k => &$v) {

			$v->safe_seo_url = \helpers\Utils::safe_url($v->title);
		}
		return $result;
	}
	function getMatches($profileFields, $matchesLimit) {
		$profile = array();
		foreach($profileFields as $k => $v) {
			// p($v->id . ' ' .
			// '%' . $v->value . '%');
			$result = $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues(array(
					$v->id,
					'%' . $v->value . '%'
			))->executeQuery('SELECT user_id FROM ' . $this->table_prefix . '_users_extra
				WHERE field = ? AND value LIKE ?')[0];
			// var_dump($result);
			if(is_object($result)) {
				$profile[] = $result->user_id;
				// pd();
				// pr($profile);
			}
		}
		// var_dump($profile);
		$profile = array_unique($profile);
		$key = array_search($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key, $profile);
		if($key !== FALSE) {
			unset($profile[$key]);
		}
		if(count($profile) > 0) {

			foreach($profile as $k => $v) {
				$users[] = $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues(array(
						$v
				))->executeQuery('SELECT * FROM ' . $this->table_prefix . '_users
						LEFT JOIN ' . $this->table_prefix . '_users_extra
			ON ' . $this->table_prefix . '_users.id=' . $this->table_prefix . '_users_extra.user_id
				WHERE user_key = ? LIMIT 1')[0];
			}

			return array_slice(array_values($users), 0, str_replace('0,', '', $matchesLimit));
		} else {
			$users = $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setPreparedValues(array(
					$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
			))->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->table_prefix . '_users
					LEFT JOIN ' . $this->table_prefix . '_users_extra
			ON ' . $this->table_prefix . '_users.id=' . $this->table_prefix . '_users_extra.user_id
				WHERE user_key != ? 	 ORDER BY RAND() LIMIT ' . $matchesLimit);
			return $users;
		}
	}
	function getMatchesNotLogged($matchesLimit) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(FALSE)->setFetchMode('FETCH_OBJ')->executeQuery('SELECT  * FROM ' . $this->table_prefix . '_users

				 	 ORDER BY RAND() LIMIT ' . $matchesLimit);
	}
	function getLatestMusicFiles($Limit) {
		return array(
				'results' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT SQL_CALC_FOUND_ROWS ' . $this->table_prefix . '_music_files.*,' . $this->table_prefix . '_users.user_key,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_music_files
				LEFT JOIN ' . $this->table_prefix . '_music_galleries ON ' . $this->table_prefix . '_music_files.gallery_id = ' . $this->table_prefix . '_music_galleries.id
				LEFT JOIN ' . $this->table_prefix . '_users ON ' . $this->table_prefix . '_music_galleries.user_key = ' . $this->table_prefix . '_users.user_key
						WHERE ' . $this->table_prefix . '_music_files.encode_status="completed"
				  ORDER BY ' . $this->table_prefix . '_music_files.id DESC LIMIT ' . $Limit),
				'nr_rows' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery("SELECT FOUND_ROWS() AS nr_rows")[0]->nr_rows
		);
	}
	function getMusicFiles($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_music_files
				WHERE  id = ? LIMIT 1')[0];
	}
	function getMusicFilesComments($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT ' . $this->table_prefix . '_music_files_comments.*,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_music_files_comments
				LEFT JOIN ' . $this->table_prefix . '_users ON ' . $this->table_prefix . '_music_files_comments.user_key = ' . $this->table_prefix . '_users.user_key
				WHERE music_id= ? ORDER BY timestamp DESC');
	}
	function addMusicFilesComment($Fields) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_music_files_comments(music_id,user_key,comment,timestamp)
				VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, $Fields), ',') . ')');
	}
	function getLatestVideo($Limit) {
		return array(
				'results' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT SQL_CALC_FOUND_ROWS ' . $this->table_prefix . '_videos.*,' . $this->table_prefix . '_users.user_key,' . $this->table_prefix . '_users.username,' . $this->table_prefix . '_videos_galleries.gallery_name FROM ' . $this->table_prefix . '_videos
				LEFT JOIN ' . $this->table_prefix . '_videos_galleries ON ' . $this->table_prefix . '_videos.gallery_id = ' . $this->table_prefix . '_videos_galleries.id
				LEFT JOIN ' . $this->table_prefix . '_users ON ' . $this->table_prefix . '_videos_galleries.user_key = ' . $this->table_prefix . '_users.user_key
						WHERE ' . $this->table_prefix . '_videos.encode_status="completed"
				  ORDER BY ' . $this->table_prefix . '_videos.id DESC LIMIT ' . $Limit),
				'nr_rows' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery("SELECT FOUND_ROWS() AS nr_rows")[0]->nr_rows
		);
	}
	function getVideo($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT ' . $this->table_prefix . '_videos.*,' . $this->table_prefix . '_videos_galleries.gallery_name,' . $this->table_prefix . '_videos_galleries.user_key FROM ' . $this->table_prefix . '_videos
				LEFT JOIN ' . $this->table_prefix . '_videos_galleries ON ' . $this->table_prefix . '_videos.gallery_id = ' . $this->table_prefix . '_videos_galleries.id
				WHERE  ' . $this->table_prefix . '_videos.id = ? LIMIT 1')[0];
	}
	function getVideoByName($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT ' . $this->table_prefix . '_videos.*,' . $this->table_prefix . '_videos_galleries.gallery_name,' . $this->table_prefix . '_videos_galleries.user_key FROM ' . $this->table_prefix . '_videos
				LEFT JOIN ' . $this->table_prefix . '_videos_galleries ON ' . $this->table_prefix . '_videos.gallery_id = ' . $this->table_prefix . '_videos_galleries.id
				WHERE  ' . $this->table_prefix . '_videos.title = ? LIMIT 1')[0];
	}
	function getVideoComments($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT ' . $this->table_prefix . '_videos_comments.*,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_videos_comments
				LEFT JOIN ' . $this->table_prefix . '_users ON ' . $this->table_prefix . '_videos_comments.user_key = ' . $this->table_prefix . '_users.user_key
				WHERE video_id= ? ORDER BY timestamp DESC');
	}
	function addVideoComment($Fields) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_videos_comments(video_id,user_key,comment,timestamp)
				VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, $Fields), ',') . ')');
	}
	function getSameUserVideoPlaylist($Fields, $Limit) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->setFetchMode('FETCH_OBJ')->executeQuery('SELECT ' . $this->table_prefix . '_videos.*,' . $this->table_prefix . '_videos_galleries.gallery_name,' . $this->table_prefix . '_videos_galleries.user_key FROM ' . $this->table_prefix . '_videos
				LEFT JOIN ' . $this->table_prefix . '_videos_galleries ON ' . $this->table_prefix . '_videos.gallery_id = ' . $this->table_prefix . '_videos_galleries.id
				WHERE ' . $this->table_prefix . '_videos_galleries.user_key = ?
				  ORDER BY RAND() DESC LIMIT ' . $Limit);
	}
	function getSameGalleryVideoPlaylist($Fields, $Limit) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->setFetchMode('FETCH_OBJ')->executeQuery('SELECT ' . $this->table_prefix . '_videos.*,' . $this->table_prefix . '_videos_galleries.gallery_name,' . $this->table_prefix . '_videos_galleries.user_key FROM ' . $this->table_prefix . '_videos
				LEFT JOIN ' . $this->table_prefix . '_videos_galleries ON ' . $this->table_prefix . '_videos.gallery_id = ' . $this->table_prefix . '_videos_galleries.id
				WHERE ' . $this->table_prefix . '_videos_galleries.user_key = ? AND ' . $this->table_prefix . '_videos_galleries.gallery_name = ?
				  ORDER BY ' . $this->table_prefix . '_videos.id DESC LIMIT ' . $Limit);
	}
	function getRelatedVideosPlaylist($Fields, $Limit) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->setFetchMode('FETCH_OBJ')->executeQuery('SELECT ' . $this->table_prefix . '_videos.*,' . $this->table_prefix . '_videos_galleries.gallery_name,' . $this->table_prefix . '_videos_galleries.user_key FROM ' . $this->table_prefix . '_videos
				LEFT JOIN ' . $this->table_prefix . '_videos_galleries ON ' . $this->table_prefix . '_videos.gallery_id = ' . $this->table_prefix . '_videos_galleries.id
				WHERE ' . $this->table_prefix . '_videos.tags LIKE ?
				  ORDER BY ' . $this->table_prefix . '_videos.id DESC LIMIT ' . $Limit);
	}
	function getSameUserMusicPlaylist($Fields, $Limit) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->setFetchMode('FETCH_OBJ')->executeQuery('SELECT ' . $this->table_prefix . '_music_files.*,' . $this->table_prefix . '_music_galleries.gallery_name,' . $this->table_prefix . '_music_galleries.user_key FROM ' . $this->table_prefix . '_music_files
				LEFT JOIN ' . $this->table_prefix . '_music_galleries ON ' . $this->table_prefix . '_music_files.gallery_id = ' . $this->table_prefix . '_music_galleries.id
				WHERE ' . $this->table_prefix . '_music_galleries.user_key = ?
				  ORDER BY RAND() DESC LIMIT ' . $Limit);
	}
	function getSameGalleryMusicPlaylist($Fields, $Limit) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->setFetchMode('FETCH_OBJ')->executeQuery('SELECT ' . $this->table_prefix . '_music_files.*,' . $this->table_prefix . '_music_galleries.gallery_name,' . $this->table_prefix . '_music_galleries.user_key FROM ' . $this->table_prefix . '_music_files
				LEFT JOIN ' . $this->table_prefix . '_music_galleries ON ' . $this->table_prefix . '_music_files.gallery_id = ' . $this->table_prefix . '_music_galleries.id
				WHERE ' . $this->table_prefix . '_music_galleries.user_key = ? AND ' . $this->table_prefix . '_music_galleries.gallery_name = ?
				  ORDER BY ' . $this->table_prefix . '_music_files.id DESC LIMIT ' . $Limit);
	}
	function getRelatedMusicPlaylist($Fields, $Limit) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->setFetchMode('FETCH_OBJ')->executeQuery('SELECT ' . $this->table_prefix . '_music_files.*,' . $this->table_prefix . '_music_galleries.gallery_name,' . $this->table_prefix . '_music_galleries.user_key FROM ' . $this->table_prefix . '_music_files
				LEFT JOIN ' . $this->table_prefix . '_music_galleries ON ' . $this->table_prefix . '_music_files.gallery_id = ' . $this->table_prefix . '_music_galleries.id
				WHERE ' . $this->table_prefix . '_music.tags LIKE ?
				  ORDER BY ' . $this->table_prefix . '_music_files.id DESC LIMIT ' . $Limit);
	}
	function getLatestExtraSections($Type, $Limit) {
		return array(
				'results' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT SQL_CALC_FOUND_ROWS ' . $this->table_prefix . '_' . $Type . '.*,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_' . $Type . '
				LEFT JOIN ' . $this->table_prefix . '_users ON ' . $this->table_prefix . '_' . $Type . '.user_key = ' . $this->table_prefix . '_users.user_key
				  ORDER BY ' . $this->table_prefix . '_' . $Type . '.timestamp DESC LIMIT ' . $Limit),
				'nr_rows' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery("SELECT FOUND_ROWS() AS nr_rows")[0]->nr_rows
		);
	}
	function getExtraSectionDetails($Type, $Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues(array(
				$Fields
		))->executeQuery('SELECT * FROM ' . $this->table_prefix . '_' . $Type . '
				WHERE  id = ? LIMIT 1')[0];
	}
	function getExtraSectionDetailsByName($Type, $Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues(array(
				$Fields
		))->executeQuery('SELECT * FROM ' . $this->table_prefix . '_' . $Type . '
				WHERE  title = ? LIMIT 1')[0];
	}
	function getExtraSectionsComments($Type, $Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues(array(
				$Fields
		))->executeQuery('SELECT  ' . $this->table_prefix . '_' . $Type . '_comments.*,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_' . $Type . '_comments
				LEFT JOIN ' . $this->table_prefix . '_users ON ' . $this->table_prefix . '_' . $Type . '_comments.user_key = ' . $this->table_prefix . '_users.user_key
				WHERE ' . $Type . '_id= ? ORDER BY id DESC');
	}

	function getExtraSectionsComment($Type, $Fields) {

		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues(array(
				$Fields
		))->executeQuery('SELECT  comment FROM ' . $this->table_prefix . '_' . $Type . '_comments
				WHERE id= ? LIMIT 1')[0];
	}


	function editExtraSectionCommentText($Type,$Fields)
	{
		$this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('UPDATE ' . $this->table_prefix . '_' . $Type . '_comments
SET comment=?  WHERE id=? AND user_key = ?');
		return TRUE;

	}

	function addExtraSectionComment($Type, $Fields) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_' . $Type . '_comments(' . $Type . '_id,user_key,comment,timestamp)
				VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, $Fields), ',') . ')');
	}
	function addExtraSections($Type, $Fields) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_' . $Type . '(user_key,title,text,timestamp)
				VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, $Fields), ',') . ')');
		return TRUE;
	}
	function getPicture($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT  ' . $this->table_prefix . '_pictures.*,' . $this->table_prefix . '_galleries.gallery_name,' . $this->table_prefix . '_galleries.user_key FROM ' . $this->table_prefix . '_pictures
				LEFT JOIN ' . $this->table_prefix . '_galleries ON ' . $this->table_prefix . '_pictures.gallery_id = ' . $this->table_prefix . '_galleries.id
				WHERE  ' . $this->table_prefix . '_pictures.id = ? LIMIT 1')[0];
	}
	function getPictureByName($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT  ' . $this->table_prefix . '_pictures.*,' . $this->table_prefix . '_galleries.gallery_name,' . $this->table_prefix . '_galleries.user_key FROM ' . $this->table_prefix . '_pictures
				LEFT JOIN ' . $this->table_prefix . '_galleries ON ' . $this->table_prefix . '_pictures.gallery_id = ' . $this->table_prefix . '_galleries.id
				WHERE  ' . $this->table_prefix . '_pictures.title = ? LIMIT 1')[0];
	}
	function checkIfGroupMember($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQueryNrRows('SELECT COUNT(id) FROM ' . $this->table_prefix . '_group_members
				WHERE group_id= ? AND user_key = ? LIMIT 1');
	}
	function getGroupVideos($galleryId) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($galleryId)->executeQuery('SELECT ' . $this->table_prefix . '_group_videos.*,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_group_videos
				LEFT JOIN ' . $this->table_prefix . '_users ON ' . $this->table_prefix . '_group_videos.user_key = ' . $this->table_prefix . '_users.user_key
				WHERE ' . $this->table_prefix . '_group_videos.group_id= ? ORDER BY ' . $this->table_prefix . '_group_videos.id DESC');
	}
	function getGroupMusics($galleryId) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($galleryId)->executeQuery('SELECT ' . $this->table_prefix . '_group_music.*,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_group_music
				LEFT JOIN ' . $this->table_prefix . '_users ON ' . $this->table_prefix . '_group_music.user_key = ' . $this->table_prefix . '_users.user_key
				WHERE ' . $this->table_prefix . '_group_music.group_id= ? ORDER BY id DESC');
	}
	function getGroupMusicComments($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT   ' . $this->table_prefix . '_group_music_comments.*,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_group_music_comments
				LEFT JOIN ' . $this->table_prefix . '_users ON ' . $this->table_prefix . '_group_music_comments.user_key = ' . $this->table_prefix . '_users.user_key
				WHERE music_id= ? ORDER BY id DESC');
	}

	function editGroupBlog($Fields)
	{
			$this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('UPDATE ' . $this->table_prefix . '_group_blogs
SET title=?,text=? WHERE id=? AND user_key = ?');
			return TRUE;

	}
	function editGroupEvent($Fields)
	{
		$this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('UPDATE ' . $this->table_prefix . '_group_events
SET title=?,text=?,location=?,event_date=? WHERE id=? AND user_key = ?');
		return TRUE;

	}

	function deleteGroupVideo($Fields) {
		$this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_group_videos
				WHERE user_key = ? AND id = ?');
	}
	function deleteGroupMusic($Fields) {
		$this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_group_music
				WHERE user_key = ? AND id = ?');
	}
	function deleteGroupPicture($Fields) {
		$this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_group_pictures
								WHERE user_key = ? AND id = ?');
	}

	function getVideosSubscribers($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_video_subscribe
				WHERE to_key= ?');
	}

	function subscribeToVideos($Fields) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_videos_subscribe(to_key,from_key)
				VALUES(' . implode(array_map(function ($value) {
						return '?';
					}, $Fields), ',') . ')');
	}

	function getMusicSubscribers($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT * FROM ' . $this->table_prefix . '_music_subscribe
				WHERE to_key= ?');
	}

	function subscribeToMusic($Fields) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_music_subscribe(to_key,from_key)
				VALUES(' . implode(array_map(function ($value) {
						return '?';
					}, $Fields), ',') . ')');
	}

}

?>
