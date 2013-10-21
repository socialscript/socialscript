<?php

namespace models;

use lib\Core\Model;

class ModelAdminUsersInteraction extends Model {
	function __construct() {
		parent::__construct();
	}
	function getExtraSections($Type) {
		$result = $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT ' . $this->table_prefix . '_' . $Type . '.id,' . $this->table_prefix . '_' . $Type . '.title,' . $this->table_prefix . '_' . $Type . '.text,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_' . $Type . '
				LEFT JOIN ' . $this->table_prefix . '_users ON
				' . $this->table_prefix . '_' . $Type . '.user_key= ' . $this->table_prefix . '_users.user_key ORDER BY id DESC');
		/*foreach($result as $k => &$v)
		{
			$v->text = substr(strip_tags($v->text),0,100);
		}*/
		return $result;
	}
	function UpdateExtraSections($Fields, $Id, $Type) {
		return $this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues(array_pad(array_values($Fields), count($Fields) + 1, $Id))->executeQuery('UPDATE ' . $this->table_prefix . '_' . $Type . ' SET ' . implode(array_keys($Fields), '=?,') . ' =? WHERE id = ? ');
	}
	function DeleteExtraSections($Fields, $Type) {
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues(array(
				$Fields
		))->executeQuery('DELETE FROM ' . $this->table_prefix . '_' . $Type . ' WHERE id = ? ');
	}
	function updateExtraSectionsComment($Fields, $Id, $Type) {
		return $this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues(array_pad(array_values($Fields), count($Fields) + 1, $Id))->executeQuery('UPDATE ' . $this->table_prefix . '_' . $Type . '_comments SET ' . implode(array_keys($Fields), '=?,') . ' =? WHERE id = ? ');
	}
	function DeleteExtraSectionsComment($Fields, $Type) {
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues(array(
				$Fields
		))->executeQuery('DELETE FROM ' . $this->table_prefix . '_' . $Type . '_comments WHERE id = ? ');
	}
	function getEvents() {
		$result = $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT ' . $this->table_prefix . '_events.id,' . $this->table_prefix . '_events.title,' . $this->table_prefix . '_events.text,' . $this->table_prefix . '_events.location,' . $this->table_prefix . '_events.event_date,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_events
				LEFT JOIN ' . $this->table_prefix . '_users ON
				' . $this->table_prefix . '_events.user_key= ' . $this->table_prefix . '_users.user_key ORDER BY id DESC');
		//foreach($result as $k => &$v)
		//{
			//$v->text = substr(strip_tags($v->text),0,100);
		//}
		return $result;
	}
	function updateEvent($Fields, $Id) {
		return $this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues(array_pad(array_values($Fields), count($Fields) + 1, $Id))->executeQuery('UPDATE ' . $this->table_prefix . '_events SET ' . implode(array_keys($Fields), '=?,') . ' =? WHERE id = ? ');
	}
	function deleteEvent($Fields) {
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues(array(
				$Fields
		))->executeQuery('DELETE FROM ' . $this->table_prefix . '_events WHERE id = ? ');
	}
	function getEventComments($Fields) {
		$result = $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setPreparedValues(array(
				$Fields
		))->setFetchMode('FETCH_OBJ')->executeQuery('SELECT ' . $this->table_prefix . '_events_comments.id,' . $this->table_prefix . '_events_comments.comment,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_events_comments
				LEFT JOIN ' . $this->table_prefix . '_users ON
				' . $this->table_prefix . '_events_comments.user_key= ' . $this->table_prefix . '_users.user_key
				WHERE ' . $this->table_prefix . '_events_comments.event_id = ? ORDER BY ' . $this->table_prefix . '_events_comments.id DESC');
		foreach($result as $k => &$v)
		{
			$v->text = substr(strip_tags($v->text),0,100);
		}
		return $result;
	}
	function updateEventComment($Fields, $Id) {
		return $this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues(array_pad(array_values($Fields), count($Fields) + 1, $Id))->executeQuery('UPDATE ' . $this->table_prefix . '_events_comments SET ' . implode(array_keys($Fields), '=?,') . ' =? WHERE id = ? ');
	}
	function deleteEventComment($Fields) {
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues(array(
				$Fields
		))->executeQuery('DELETE FROM ' . $this->table_prefix . '_events_comments WHERE id = ? ');
	}
	function getBlogs() {
		$result = $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT ' . $this->table_prefix . '_blogs.id,' . $this->table_prefix . '_blogs.title,' . $this->table_prefix . '_blogs.text,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_blogs
				LEFT JOIN ' . $this->table_prefix . '_users ON
				' . $this->table_prefix . '_blogs.user_key= ' . $this->table_prefix . '_users.user_key ORDER BY id DESC');
		foreach($result as $k => &$v)
		{
			$v->text = substr(strip_tags($v->text),0,100);
		}
		return $result;
	}
	function updateBlog($Fields, $Id) {
		return $this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues(array_pad(array_values($Fields), count($Fields) + 1, $Id))->executeQuery('UPDATE ' . $this->table_prefix . '_blogs SET ' . implode(array_keys($Fields), '=?,') . ' =? WHERE id = ? ');
	}
	function deleteBlog($Fields) {
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues(array(
				$Fields
		))->executeQuery('DELETE FROM ' . $this->table_prefix . '_blogs WHERE id = ? ');
	}
	function getBlogComments($Fields) {
		$result = $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setPreparedValues(array(
				$Fields
		))->setFetchMode('FETCH_OBJ')->executeQuery('SELECT ' . $this->table_prefix . '_blogs_comments.id,' . $this->table_prefix . '_blogs_comments.comment,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_blogs_comments
				LEFT JOIN ' . $this->table_prefix . '_users ON
				' . $this->table_prefix . '_blogs_comments.user_key= ' . $this->table_prefix . '_users.user_key
				WHERE ' . $this->table_prefix . '_blogs_comments.blog_id = ? ORDER BY ' . $this->table_prefix . '_blogs_comments.id DESC');
		//foreach($result as $k => &$v)
		//{
			//$v->text = substr(strip_tags($v->text),0,100);
		//}
		return $result;
	}
	function updateBlogComment($Fields, $Id) {
		return $this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues(array_pad(array_values($Fields), count($Fields) + 1, $Id))->executeQuery('UPDATE ' . $this->table_prefix . '_blogs_comments SET ' . implode(array_keys($Fields), '=?,') . ' =? WHERE id = ? ');
	}
	function deleteBlogComment($Fields) {
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues(array(
				$Fields
		))->executeQuery('DELETE FROM ' . $this->table_prefix . '_blogs_comments WHERE id = ? ');
	}
	function getExtraSectionsComments($Fields, $Type) {
		$result = $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setPreparedValues(array(
				$Fields
		))->setFetchMode('FETCH_OBJ')->executeQuery('SELECT ' . $this->table_prefix . '_' . $Type . '_comments.id,' . $this->table_prefix . '_' . $Type . '_comments.comment,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_' . $Type . '_comments
				LEFT JOIN ' . $this->table_prefix . '_users ON
				' . $this->table_prefix . '_' . $Type . '_comments.user_key= ' . $this->table_prefix . '_users.user_key
				WHERE ' . $this->table_prefix . '_' . $Type . '_comments.' . $Type . '_id = ? ORDER BY ' . $this->table_prefix . '_' . $Type . '_comments.id DESC');
		/*foreach($result as $k => &$v)
		{
			$v->text = substr(strip_tags($v->text),0,100);
		}
		*/
		return $result;
	}
	function getGroups() {
		$result = $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT ' . $this->table_prefix . '_groups.id,' . $this->table_prefix . '_groups.group_name,' . $this->table_prefix . '_groups.group_description,' . $this->table_prefix . '_groups.group_location,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_groups
				LEFT JOIN ' . $this->table_prefix . '_users ON
				' . $this->table_prefix . '_groups.user_key= ' . $this->table_prefix . '_users.user_key ORDER BY id DESC');
	/*	foreach($result as $k => &$v)
		{
			$v->text = substr(strip_tags($v->text),0,100);
		}*/
		return $result;
	}
	function getGroupsBlogs($Fields) {
		$result = $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setPreparedValues(array(
				$Fields
		))->setFetchMode('FETCH_OBJ')->executeQuery('SELECT ' . $this->table_prefix . '_group_blogs.id,' . $this->table_prefix . '_group_blogs.title,' . $this->table_prefix . '_group_blogs.text,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_group_blogs
				LEFT JOIN ' . $this->table_prefix . '_users ON
				' . $this->table_prefix . '_group_blogs.user_key= ' . $this->table_prefix . '_users.user_key
				WHERE ' . $this->table_prefix . '_group_blogs.group_id = ? ORDER BY ' . $this->table_prefix . '_group_blogs.id DESC');
		foreach($result as $k => &$v)
		{
			$v->text = substr(strip_tags($v->text),0,100);
		}
		return $result;
	}
	function getGroupsImages($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setPreparedValues(array(
				$Fields
		))->setFetchMode('FETCH_OBJ')->executeQuery('SELECT ' . $this->table_prefix . '_group_pictures.id,' . $this->table_prefix . '_group_pictures.pic_name,' . $this->table_prefix . '_group_pictures.pic_description FROM ' . $this->table_prefix . '_group_pictures

				WHERE ' . $this->table_prefix . '_group_pictures.group_id = ? ORDER BY ' . $this->table_prefix . '_group_pictures.id DESC');
	}
	function getGroupsEvents($Fields) {
		$result = $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setPreparedValues(array(
				$Fields
		))->setFetchMode('FETCH_OBJ')->executeQuery('SELECT ' . $this->table_prefix . '_group_events.id,' . $this->table_prefix . '_group_events.title,' . $this->table_prefix . '_group_events.text,' . $this->table_prefix . '_group_events.location,' . $this->table_prefix . '_group_events.event_date,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_group_events
				LEFT JOIN ' . $this->table_prefix . '_users ON
				' . $this->table_prefix . '_group_events.user_key= ' . $this->table_prefix . '_users.user_key
				WHERE ' . $this->table_prefix . '_group_events.group_id = ? ORDER BY id DESC');
		foreach($result as $k => &$v)
		{
			$v->text = substr(strip_tags($v->text),0,100);
		}
		return $result;
	}
	function updateGroupBlog($Fields, $Id) {
		return $this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues(array_pad(array_values($Fields), count($Fields) + 1, $Id))->executeQuery('UPDATE ' . $this->table_prefix . '_group_blogs SET ' . implode(array_keys($Fields), '=?,') . ' =? WHERE id = ? ');
	}
	function deleteGroupBlog($Fields) {
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues(array(
				$Fields
		))->executeQuery('DELETE FROM ' . $this->table_prefix . '_group_blogs WHERE id = ? ');
	}
	function updateGroupEvent($Fields, $Id) {
		return $this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues(array_pad(array_values($Fields), count($Fields) + 1, $Id))->executeQuery('UPDATE ' . $this->table_prefix . '_group_events SET ' . implode(array_keys($Fields), '=?,') . ' =? WHERE id = ? ');
	}
	function deleteGroupEvent($Fields) {
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues(array(
				$Fields
		))->executeQuery('DELETE FROM ' . $this->table_prefix . '_group_events WHERE id = ? ');
	}
	function updateGroupImage($Fields, $Id) {
		return $this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues(array_pad(array_values($Fields), count($Fields) + 1, $Id))->executeQuery('UPDATE ' . $this->table_prefix . '_group_pictures SET ' . implode(array_keys($Fields), '=?,') . ' =? WHERE id = ? ');
	}
	function deleteGroupImage($Fields) {
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues(array(
				$Fields
		))->executeQuery('DELETE FROM ' . $this->table_prefix . '_group_pictures WHERE id = ? ');
	}
	function getTrade() {
		$result = $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT ' . $this->table_prefix . '_trade.id,' . $this->table_prefix . '_trade.title,' . $this->table_prefix . '_trade.text,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_trade
				LEFT JOIN ' . $this->table_prefix . '_users ON
				' . $this->table_prefix . '_trade.user_key= ' . $this->table_prefix . '_users.user_key ORDER BY id DESC');
		/*foreach($result as $k => &$v)
		{
			$v->text = substr(strip_tags($v->text),0,100);
		}*/
		return $result;
	}
	function getTradeQuestions($Fields) {
		$result = $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setPreparedValues(array(
				$Fields
		))->setFetchMode('FETCH_OBJ')->executeQuery('SELECT ' . $this->table_prefix . '_trade_questions.id,' . $this->table_prefix . '_trade_questions.question,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_trade_questions
				LEFT JOIN ' . $this->table_prefix . '_users ON
				' . $this->table_prefix . '_trade_questions.user_key= ' . $this->table_prefix . '_users.user_key
				WHERE ' . $this->table_prefix . '_trade_questions.trade_id = ? ORDER BY ' . $this->table_prefix . '_trade_questions.id DESC');

		foreach($result as $k => &$v)
		{
			$v->text = substr(strip_tags($v->text),0,100);
		}
		return $result;
	}
	function updateTradeQuestion($Fields, $Id) {
		return $this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues(array_pad(array_values($Fields), count($Fields) + 1, $Id))->executeQuery('UPDATE ' . $this->table_prefix . '_trade_questions SET ' . implode(array_keys($Fields), '=?,') . ' =? WHERE id = ? ');
	}
	function deleteTradeQuestion($Fields) {
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues(array(
				$Fields
		))->executeQuery('DELETE FROM ' . $this->table_prefix . '_trade_questions WHERE id = ? ');
	}
}

?>