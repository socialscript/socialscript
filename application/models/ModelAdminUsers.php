<?php

namespace models;

use lib\Core\Model;

class ModelAdminUsers extends Model {
	function getUsers() {
		$result = $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT
				id,user_key,username,password,email,country,featured,rating,role,registered_date FROM ' . $this->table_prefix . '_users');
		foreach($result as $k => &$v) {
			$v->password = '******';
		}
		return $result;
	}
	function getUser($Id) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setPreparedValues(array(
				$Id
		))->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->table_prefix . '_users_extra WHERE user_id=?');
	}
	function UpdateExtra($Fields) {
		return $this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('UPDATE ' . $this->table_prefix . '_users_extra SET value=? WHERE id = ? ');
	}
	function Update($Fields, $Id) {
		return $this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues(array_pad(array_values($Fields), count($Fields) + 1, $Id))->executeQuery('UPDATE ' . $this->table_prefix . '_users SET ' . implode(array_keys($Fields), '=?,') . ' =? WHERE id = ? ');
	}
	function getExtraFields($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setPreparedValues(array(
				$Fields
		))->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->table_prefix . '_users_extra WHERE user_id=?');
	}
	function getUserById($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setPreparedValues(array(
				$Fields
		))->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->table_prefix . '_users WHERE id=?')[0];
	}
	function getExtraFieldName($Fields) {
		$result = $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setPreparedValues(array(
				$Fields
		))->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->table_prefix . '_forms WHERE id=?');
		if(isset($result[0])) {
			return $result[0]->name;
		} else {
			return '';
		}
	}
	function deleteUserBlogsCategories($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_blog_categories WHERE user_key = ? ');
	}
	function deleteUserBlogsSubscribe($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_blog_subscribe WHERE to_key = ? OR from_key = ?');
	}
	function deleteUserBlogs($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_blogs WHERE user_key = ? ');
	}
	function deleteUserBlogsComments($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_blogs_comments WHERE user_key = ? ');
	}
	function deleteUserBusiness($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_business WHERE user_key = ? ');
	}
	function deleteUserBusinessComments($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_business_comments WHERE user_key = ? ');
	}
	function deleteUserChat($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_chat WHERE user_from = ? OR user_to = ?');
	}
	function deleteUserCars($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_cars WHERE user_key = ? ');
	}
	function deleteUserCarsComments($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_cars_comments WHERE user_key = ? ');
	}
	function deleteUserEvents($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_events WHERE user_key = ? ');
	}
	function deleteUserEventsComments($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_events_comments WHERE user_key = ? ');
	}
	function deleteUserEventsInvites($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_events_invites WHERE from_key = ? OR to_key = ?');
	}
	function deleteUserEventsSubscribe($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_events_subscribe WHERE from_key = ? OR to_key = ?');
	}
	function deleteUserFashion($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_fashion WHERE user_key = ? ');
	}
	function deleteUserFashionComments($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_fashion_comments WHERE user_key = ? ');
	}
	function deleteUserFinance($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_fashion WHERE user_key = ? ');
	}
	function deleteUserFinanceComments($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_fashion_comments WHERE user_key = ? ');
	}
	function deleteUserFoods($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_foods WHERE user_key = ? ');
	}
	function deleteUserFoodsComments($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_foods_comments WHERE user_key = ? ');
	}
	function deleteUserFriends($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_friends WHERE user_key = ? OR friend_key = ? ');
	}
	function deleteUserGalleries($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_galleries WHERE user_key = ?  ');
	}
	function deleteUserGossip($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_gossip WHERE user_key = ? ');
	}
	function deleteUserGossipComments($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_gossip_comments WHERE user_key = ? ');
	}
	function deleteUserGroups($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_groups WHERE user_key = ? ');
	}
	function deleteUserGroupBlogs($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_group_blogs WHERE user_key = ? ');
	}
	function deleteUserGroupBlogsComments($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_group_blogs_comments WHERE user_key = ? ');
	}
	function deleteUserGroupEvents($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_group_blogs WHERE user_key = ? ');
	}
	function deleteUserGroupEventsComments($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_group_blogs_comments WHERE user_key = ? ');
	}
	function deleteUserGroupMembers($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_group_members WHERE user_key = ? ');
	}
	function deleteUserGroupMusic($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_group_music WHERE user_key = ? ');
	}
	function deleteUserGroupMusicComments($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_group_music_comments WHERE user_key = ? ');
	}
	function deleteUserGroupPictures($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_group_pictures WHERE user_key = ? ');
	}
	function deleteUserGroupPicturesComments($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_group_pictures_comments WHERE user_key = ? ');
	}
	function deleteUserGroupSubscribe($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_group_subscribe WHERE to_key = ? OR from_key = ?');
	}
	function deleteUserGroupVideos($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_group_videos WHERE user_key = ? ');
	}
	function deleteUserGroupVideosComments($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_group_videos_comments WHERE user_key = ? ');
	}
	function deleteUserMarkedInterestedIn($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_mark_interested_in WHERE user_key = ? OR friend_key = ? ');
	}
	function deleteUserMessages($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_messages WHERE to_key = ? OR from_key = ? ');
	}
	function deleteUserMovies($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_movies WHERE user_key = ? ');
	}
	function deleteUserMoviesComments($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_movies_comments WHERE user_key = ? ');
	}
	function deleteUserMusic($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_music WHERE user_key = ? ');
	}
	function deleteUserMusicComments($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_music_comments WHERE user_key = ? ');
	}
	function deleteUserMusicFiles($Fields){
		//return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_music_files WHERE user_key = ? ');
	}
	function deleteUserMusicFilesComments($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_music_files_comments WHERE user_key = ? ');
	}
	function deleteUserMusicGalleries($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_music_galleries WHERE user_key = ? ');
	}
	function deleteUserNews($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_news WHERE user_key = ? ');
	}
	function deleteUserNewsComments($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_news_comments WHERE user_key = ? ');
	}
	function deleteUserPictures($Fields){
		//return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_pictures WHERE user_key = ? ');
	}
	function deleteUserPicturesComments($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_pictures_comments WHERE user_key = ? ');
	}
	function deleteUserPicturesSubscribe($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_pictures_subscribe WHERE to_key = ? OR from_key = ? ');
	}
	function deleteUserSayHello($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_say_hello WHERE user_key = ? OR friend_key = ? ');
	}
	function deleteUserSports($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_sports WHERE user_key = ? ');
	}
	function deleteUserSportsComments($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_sports_comments WHERE user_key = ? ');
	}
	function deleteUserTechnology($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_technology WHERE user_key = ? ');
	}
	function deleteUserTechnologyComments($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_technology_comments WHERE user_key = ? ');
	}
	function deleteUserTrade($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_trade WHERE user_key = ? ');
	}
	function deleteUserTradeQuestions($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_trade_questions WHERE user_key = ? ');
	}
	function deleteUserTravel($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_travel WHERE user_key = ? ');
	}
	function deleteUserTravelComments($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_travel_comments WHERE user_key = ? ');
	}
	function deleteUserVideos($Fields){
	//	return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_videos WHERE user_key = ? ');
	}
	function deleteUserVideosComments($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_videos_comments WHERE user_key = ? ');
	}
	function deleteUserVideosGalleries($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_videos_galleries WHERE user_key = ? ');
	}
	function deleteUserWhatshot($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_whatshot WHERE user_key = ? ');
	}
	function deleteUserWhatshotComments($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_whatshot_comments WHERE user_key = ? ');
	}
	function deleteUserExtra($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_users_extra WHERE user_id = ? ');
	}
	function deleteUser($Fields){
		return $this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_users WHERE user_key = ? ');
		}

}

?>