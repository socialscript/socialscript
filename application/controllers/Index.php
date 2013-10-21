<?php

namespace controllers;

use lib\Form\FormValidator;
use helpers\RequestHash;
use lib\Core\Controller;
use lib\Core\Registry;

class Index extends Controller {
	function __construct() {
		parent::__construct();

		$this->Registry = Registry::getInstance();

		(new \SplAutoloader('models', array(
				'models'
		)) )->register();

		$model = 'models\\Model' . ucfirst(strtolower($this->Registry->controllerName));
		$this->model = new $model();
	}
	function Index() {
		// include HELPERS_DIR . 'RequestHash.php';
		$this->modelUsers = new \models\ModelUsers();
		$this->modelUsersContent = new \models\ModelUsersContent();
		$this->modelUsersInteraction = new \models\ModelUsersInteraction();
		$this->user_logged = (new \lib\RBAC\RBACSystem() )->CheckAccess();

		if($this->Registry->Settings->enable_chat == 'yes') {
			$this->chat_messages = '';
			$this->friends = array();
			$this->modelChat = new \models\ModelChat();
			$this->chatMessages = $this->modelChat->getGeneralMessages();

			$this->chatMessages = array_reverse($this->chatMessages);
			foreach($this->chatMessages as $k => $v) {
				$user = $this->modelUsers->getUserByUsername($v->user_from);
				if(isset($user)) {
					if($this->Registry->Settings->only_logged_in_users_can_view_profile_info == 'yes') {
						$link = 'onclick="show_user_notification(\'' . $this->Registry->languages->user_not_logged . '\')"';
					} else {
						if(NO_AJAX == 'yes') {
							$link = 'href="' . $this->Registry->Settings->site_url . 'profile/' . $user->username . '"';
						} else {
							$link = 'onclick="view_profile(\'' . $user->user_key . '\')"';
						}
					}
					$this->chat_messages .= '<div class="chat_from"><a ' . $link . ' class="label label-info chat_link">' . $user->username . ':</a></div><div class="chat_message">' . $v->message . '</div><div class="chat_message_separator"></div>';
				}
			}
			unset($user);
			$matchesLimit = '0,' . $this->Registry->nr_items_to_display->logged_out_matches;
			$this->view->assign('chatrooms', $this->modelChat->getChatrooms());
			unset($this->modelChat);
			if($this->user_logged === TRUE) {

				$matchesLimit = '0,' . $this->Registry->nr_items_to_display->logged_in_matches;
				$extra_fields = $this->modelUsers->getUserExtraFields($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key);

				\classes\FormFieldManager::generateFormFields($extra_fields, 'register');

				$extra_fields_profile = $this->modelUsers->getUserExtraFieldsProfile($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key);
				\classes\FormFieldManager::generateFormFields($extra_fields_profile, 'user_profile');

				$profile_fields = array_merge($extra_fields, $extra_fields_profile);

				$this->online_friends = $this->modelUsersInteraction->getOnlineFriends();
				foreach($this->online_friends as $k => $v) {
					if($v->friend_key == $_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key) {
						$v->friend_key = $v->user_key;
					}
					$this->friends[] = $this->modelUsers->getUserByUserKey($v->friend_key);
				}
				unset($k);
				unset($v);
			}
			$this->view->assign('online_friends', $this->friends);
		}

		$latestBlogsLimit = '0,' . $this->Registry->nr_items_to_display->latest_blogs_menu;
		$latestEventsLimit = '0,' . $this->Registry->nr_items_to_display->latest_events_menu;
		$latestGroupsLimit = '0,' . $this->Registry->nr_items_to_display->latest_groups_menu;
		$latestPicturesLimit = '0,' . $this->Registry->nr_items_to_display->latest_pictures_menu;
		$latestVideosLimit = '0,' . $this->Registry->nr_items_to_display->latest_videos_menu;
		$latestMusicLimit = '0,' . $this->Registry->nr_items_to_display->latest_music_menu;
		$latest_profiles = $this->modelUsers->getAllUsers('0,' . $this->Registry->nr_items_to_display->latest_profiles)['results'];
		foreach($latest_profiles as $k => &$v) {
			$v->profile_pic = \classes\UserPictures::getProfilePicture($v->user_key, $this->Registry->user_pictures_settings->thumbnail_width, $this->Registry->user_pictures_settings->thumbnail_height);
		}

		unset($k);
		unset($v);
		$latest_profiles_scroller = $this->modelUsers->getAllUsers('0,' . $this->Registry->nr_items_to_display->latest_profiles_scroller)['results'];
		foreach($latest_profiles_scroller as $k => &$v) {
			$v->profile_pic = \classes\UserPictures::getProfilePicture($v->user_key, $this->Registry->user_pictures_settings->thumbnail_width, $this->Registry->user_pictures_settings->thumbnail_height);
		}

		unset($k);
		unset($v);
		$featured_profiles = $this->modelUsers->getFeaturedUsers('0,' . $this->Registry->nr_items_to_display->featured_profiles)['results'];
		foreach($featured_profiles as $k => &$v) {
			$v->profile_pic = \classes\UserPictures::getProfilePicture($v->user_key, $this->Registry->user_pictures_settings->thumbnail_width, $this->Registry->user_pictures_settings->thumbnail_height);
		}
		unset($k);
		unset($v);
		$top_rated_profiles = $this->modelUsers->getTopRatedUsers('0,' . $this->Registry->nr_items_to_display->top_rated_profiles)['results'];
		foreach($top_rated_profiles as $k => &$v) {
			$v->profile_pic = \classes\UserPictures::getProfilePicture($v->user_key, $this->Registry->user_pictures_settings->thumbnail_width, $this->Registry->user_pictures_settings->thumbnail_height);
		}
		unset($k);
		unset($v);
		$matches = (isset($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key)) ? $this->modelUsersInteraction->getMatches($profile_fields, $matchesLimit) : $this->modelUsersInteraction->getMatchesNotLogged($matchesLimit);
		foreach($matches as $k => &$v) {
			$v->profile_pic = \classes\UserPictures::getProfilePicture($v->user_key, $this->Registry->user_pictures_settings->thumbnail_width, $this->Registry->user_pictures_settings->thumbnail_height);
		}
		unset($k);
		unset($v);
		$latest_blogs = $this->modelUsersContent->getBlogs($latestBlogsLimit)['results'];
		foreach($latest_blogs as $k => &$v) {
			$v->safe_seo_url = \helpers\Utils::safe_url($v->title);
		}
		unset($k);
		unset($v);
		$latest_events = $this->modelUsersContent->getEvents($latestEventsLimit)['results'];
		foreach($latest_events as $k => &$v) {
			$v->safe_seo_url = \helpers\Utils::safe_url($v->title);
		}
		unset($k);
		unset($v);
		$latest_groups = $this->modelUsersInteraction->getGroups($latestGroupsLimit)['results'];
		foreach($latest_groups as $k => &$v) {

			$v->safe_seo_url = \helpers\Utils::safe_url($v->group_name);
		}
		unset($k);
		unset($v);

		$latest_pictures = array();
		$pictures = $this->modelUsersContent->getPictures($latestPicturesLimit)['results'];
		$i = 0;
		foreach($pictures as $k => $v) {
			$latest_pictures[$i]['image'] = \classes\UserPictures::getPicture($v->user_key, $v->file_name, md5($v->gallery_name), $this->Registry->user_pictures_settings->thumbnail_width, $this->Registry->user_pictures_settings->thumbnail_height);
			$latest_pictures[$i]['id'] = $v->id;
			$latest_pictures[$i]['pic_name'] = $v->file_name;
			$latest_pictures[$i]['gallery_id'] = $v->gallery_id;
			$latest_pictures[$i]['gallery_name'] = md5($v->gallery_name);
			$latest_pictures[$i]['user_key'] = $v->user_key;
			$latest_pictures[$i]['username'] = $v->username;
			$latest_pictures[$i]['tags'] = $v->tags;
			$latest_pictures[$i]['title'] = $v->title;
			$latest_pictures[$i]['safe_seo_url'] = \helpers\Utils::safe_url($v->title);
			$latest_pictures[$i]['timestamp'] = $v->timestamp;
			$i ++;
		}
		unset($pictures);
		unset($k);
		unset($v);
		$latest_videos = $this->modelUsersInteraction->getLatestVideo($latestVideosLimit)['results'];
		foreach($latest_videos as $k => &$v) {
			$v->thumb = \classes\UserVideo::getVideoThumb($v->user_key, $v->gallery_name, $v->file_name, $this->Registry->user_pictures_settings->thumbnail_width, $this->Registry->user_pictures_settings->thumbnail_height);
			$v->safe_seo_url = \helpers\Utils::safe_url($v->title);
		}

		unset($k);
		unset($v);
		$latest_music = $this->modelUsersInteraction->getLatestMusicFiles($latestMusicLimit)['results'];
		foreach($latest_music as $k => &$v) {
			// $v->thumb =
			// \classes\UserVideo::getVideoThumb($v->user_key,$v->gallery_name,$v->file_name,$this->Registry->user_pictures_settings->thumbnail_width,$this->Registry->user_pictures_settings->thumbnail_height);
			$v->safe_seo_url = \helpers\Utils::safe_url($v->title);
		}
		unset($k);
		unset($v);

		$this->view->assign('wn_theme', isset($this->Registry->COOKIE['jquery-ui-theme']) ? $this->Registry->COOKIE['jquery-ui-theme'] : $this->Registry->Settings->default_theme);
		$this->view->assign('user_logged', $this->user_logged);
		$this->view->assign('profiles_right',array('0' => array_merge(array('type' => 'video'),(array)$latest_videos[0]),'2' => array_merge(array('type' => 'picture'),(array)$latest_pictures[0]),'6' => array_merge(array('type' => 'user'),(array)$latest_profiles[0]))) ;
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->assign('chat_messages', $this->chat_messages);
		$this->view->assign('latest_profiles', $latest_profiles);
		$this->view->assign('latest_profiles_scroller', $latest_profiles_scroller);
		$this->view->assign('featured_profiles', $featured_profiles);
		$this->view->assign('top_rated_profiles', $top_rated_profiles);
		$this->view->assign('themes', (new \classes\Themes\Themes() )->getThemesAr());
		$this->view->assign('latest_events', $latest_events);

		$this->view->assign('groups', $latest_groups);
		$this->view->assign('blogs', $latest_blogs);
		$this->view->assign('pictures', $latest_pictures);
		$this->view->assign('music', $latest_music);
		$this->view->assign('video', $latest_videos);
		(isset($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key)) ? $this->view->assign('unread_messages', count((array) $this->modelUsersInteraction->getUnreadMessages(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		)))) : NULL;
		(isset($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key)) ? $this->view->assign('nr_friend_requests', count((array) $this->modelUsersInteraction->getFriendsRequests(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		)))) : NULL;

		(isset($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key)) ? $this->view->assign('friends_requests', $this->modelUsersInteraction->getNewFriendsRequestsMyAccount(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		))) : NULL;

		(isset($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key)) ? $this->view->assign('stats_nr_friends', $this->modelUsersInteraction->getTotalNrFriends(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		))) : NULL;
		(isset($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key)) ? $this->view->assign('stats_nr_best_friends', $this->modelUsersInteraction->getTotalNrBestFriends(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		))) : NULL;
		(isset($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key)) ? $this->view->assign('stats_nr_family', $this->modelUsersInteraction->getTotalNrFamily(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		))) : NULL;
		(isset($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key)) ? $this->view->assign('stats_nr_groups', $this->modelUsersInteraction->getTotalUserGroups(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		))) : NULL;
		(isset($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key)) ? $this->view->assign('stats_nr_events', $this->modelUsersInteraction->getTotalUserEvents(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		))) : NULL;
		(isset($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key)) ? $this->view->assign('stats_nr_blogs', $this->modelUsersInteraction->getTotalUserBlogs(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		))) : NULL;
		(isset($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key)) ? $this->view->assign('upcoming_events', $this->modelUsersInteraction->getUserUpcomingEvents(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		))) : NULL;
		(isset($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key)) ? $this->view->assign('upcoming_events_to_attend', $this->modelUsersInteraction->getUserUpcomingEventsToAttend(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		))) : NULL;
		$this->view->assign('matches', $matches);
		(isset($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key)) ? $this->view->assign('user', $this->modelUsers->getUserByUserKey($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key)) : $this->view->assign('user', '');
		$this->view->assign('thumbnail_width', $this->Registry->user_pictures_settings->thumbnail_width);
		$this->view->assign('thumbnail_height', $this->Registry->user_pictures_settings->thumbnail_height);
		$this->view->assign('large_image_width', $this->Registry->user_pictures_settings->large_image_width);
		$this->view->assign('large_image_height', $this->Registry->user_pictures_settings->large_image_height);
		$this->view->assign('width_big_profile_picture', $this->Registry->user_pictures_settings->width_of_big_profile_picture);
		$this->view->assign('height_big_profile_picture', $this->Registry->user_pictures_settings->height_of_big_profile_picture);
		$this->view->assign('footer_pages', $this->model->getTextPages('footer'));
		($this->Registry->Settings->enable_multiple_languages == 'yes') ? $this->view->assign('all_languages', $this->model->getAllLanguages()) : array();
		(! isset($_SESSION['user_' . $_SERVER['SERVER_NAME']])) ? $this->view->assign('user', '') : $this->view->assign('user', $this->modelUsers->getUserByUserKey($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key));
		$this->view->assign('resolution',explode('x', $this->Registry->COOKIE['users_resolution']));
		
		if(NO_AJAX == 'yes') {
			$this->view->assign('not_load_middle_default', true);
			$this->view->display('home/home.tpl');
		} else {
			$this->view->display('index.tpl');
		}
	}
	function Home() {
		$this->modelUsers = new \models\ModelUsers();
		$this->modelUsersContent = new \models\ModelUsersContent();
		$this->modelUsersInteraction = new \models\ModelUsersInteraction();
		$this->user_logged = (new \lib\RBAC\RBACSystem() )->CheckAccess();

		$matchesLimit = '0,' . $this->Registry->nr_items_to_display->logged_out_matches;
		if($this->user_logged === TRUE) {

			$matchesLimit = '0,' . $this->Registry->nr_items_to_display->logged_in_matches;
			$extra_fields = $this->modelUsers->getUserExtraFields($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key);

			\classes\FormFieldManager::generateFormFields($extra_fields, 'register');

			$extra_fields_profile = $this->modelUsers->getUserExtraFieldsProfile($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key);
			\classes\FormFieldManager::generateFormFields($extra_fields_profile, 'user_profile');

			$profile_fields = array_merge($extra_fields, $extra_fields_profile);
		}

		$latest_profiles = $this->modelUsers->getAllUsers('0,' . $this->Registry->nr_items_to_display->latest_profiles)['results'];
		foreach($latest_profiles as $k => &$v) {
			$v->profile_pic = \classes\UserPictures::getProfilePicture($v->user_key, $this->Registry->user_pictures_settings->thumbnail_width, $this->Registry->user_pictures_settings->thumbnail_height);
		}

		$featured_profiles = $this->modelUsers->getFeaturedUsers('0,' . $this->Registry->nr_items_to_display->featured_profiles)['results'];
		foreach($featured_profiles as $k => &$v) {
			$v->profile_pic = \classes\UserPictures::getProfilePicture($v->user_key, $this->Registry->user_pictures_settings->thumbnail_width, $this->Registry->user_pictures_settings->thumbnail_height);
		}
		$top_rated_profiles = $this->modelUsers->getTopRatedUsers('0,' . $this->Registry->nr_items_to_display->top_rated_profiles)['results'];
		foreach($top_rated_profiles as $k => &$v) {
			$v->profile_pic = \classes\UserPictures::getProfilePicture($v->user_key, $this->Registry->user_pictures_settings->thumbnail_width, $this->Registry->user_pictures_settings->thumbnail_height);
		}
		$matches = (isset($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key)) ? $this->modelUsersInteraction->getMatches($profile_fields, $matchesLimit) : $this->modelUsersInteraction->getMatchesNotLogged($matchesLimit);
		foreach($matches as $k => &$v) {
			$v->profile_pic = \classes\UserPictures::getProfilePicture($v->user_key, $this->Registry->user_pictures_settings->thumbnail_width, $this->Registry->user_pictures_settings->thumbnail_height);
		}

		$this->view->assign('user_logged', $this->user_logged);
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->assign('latest_profiles', $latest_profiles);
		$this->view->assign('featured_profiles', $featured_profiles);
		$this->view->assign('top_rated_profiles', $top_rated_profiles);
		$this->view->assign('matches', $matches);
		if(NO_AJAX == 'yes') {
			$this->view->assign('not_load_middle_default', true);
		}
	
		$this->view->display('home/home.tpl');
	}
	function indexNoAjax() {
		// /include HELPERS_DIR . 'RequestHash.php';
		$this->model = new \models\ModelIndex();
		$this->modelUsersContent = new \models\ModelUsersContent();
		$this->modelUsers = new \models\ModelUsers();
		$this->modelUsersInteraction = new \models\ModelUsersInteraction();
		$this->user_logged = (new \lib\RBAC\RBACSystem() )->CheckAccess();

		if($this->Registry->Settings->enable_chat == 'yes') {
			$this->chat_messages = '';
			$this->friends = array();
			$this->modelChat = new \models\ModelChat();
			$this->chatMessages = $this->modelChat->getGeneralMessages();
			$this->chatMessages = array_reverse($this->chatMessages);
			foreach($this->chatMessages as $k => $v) {
				$user = $this->modelUsers->getUserByUsername($v->user_from);
				 
					
				 
				if(isset($user)) {
					if($this->Registry->Settings->only_logged_in_users_can_view_profile_info == 'yes') {
						$link = 'onclick="show_user_notification(\'' . $this->Registry->languages->user_not_logged . '\')"';
					} else {
						if(NO_AJAX == 'yes') {
							$link = 'href="' . $this->Registry->Settings->site_url . 'profile/' . $user->username . '"';
						} else {
							$link = 'onclick="view_profile(\'' . $user->user_key . '\')"';
						}
					}
				}
					$this->chat_messages .= '<div class="chat_from"><a '.$link.'  class="label label-info chat_link">' . $user->username . ':</a></div><div class="chat_message">' . $v->message . '</div><div class="chat_message_separator"></div>'; 
				}
			

			$matchesLimit = '0,' . $this->Registry->nr_items_to_display->logged_out_matches;
			$this->view->assign('chatrooms', $this->modelChat->getChatrooms());
			if($this->user_logged === TRUE) {

				$matchesLimit = '0,' . $this->Registry->nr_items_to_display->logged_in_matches;
				$extra_fields = $this->modelUsers->getUserExtraFields($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key);

				\classes\FormFieldManager::generateFormFields($extra_fields, 'register');

				$extra_fields_profile = $this->modelUsers->getUserExtraFieldsProfile($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key);
				\classes\FormFieldManager::generateFormFields($extra_fields_profile, 'user_profile');

				$profile_fields = array_merge($extra_fields, $extra_fields_profile);

				$this->online_friends = $this->modelUsersInteraction->getOnlineFriends();
				foreach($this->online_friends as $k => $v) {
					if($v->friend_key == $_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key) {
						$v->friend_key = $v->user_key;
					}
					$this->friends[] = $this->modelUsers->getUserByUserKey($v->friend_key);
				}
			}
			$this->view->assign('online_friends', $this->friends);
		}

		$latestBlogsLimit = '0,' . $this->Registry->nr_items_to_display->latest_blogs_menu;
		$latestEventsLimit = '0,' . $this->Registry->nr_items_to_display->latest_events_menu;
		$latestGroupsLimit = '0,' . $this->Registry->nr_items_to_display->latest_groups_menu;
		$latestPicturesLimit = '0,' . $this->Registry->nr_items_to_display->latest_pictures_menu;
		$latestVideosLimit = '0,' . $this->Registry->nr_items_to_display->latest_videos_menu;
		$latestMusicLimit = '0,' . $this->Registry->nr_items_to_display->latest_music_menu;
		$latest_profiles = $this->modelUsers->getAllUsers('0,' . $this->Registry->nr_items_to_display->latest_profiles)['results'];
		foreach($latest_profiles as $k => &$v) {
			$v->profile_pic = \classes\UserPictures::getProfilePicture($v->user_key, $this->Registry->user_pictures_settings->thumbnail_width, $this->Registry->user_pictures_settings->thumbnail_height);
		}
		unset($k);
		unset($v);
		$latest_profiles_scroller = $this->modelUsers->getAllUsers('0,' . $this->Registry->nr_items_to_display->latest_profiles_scroller)['results'];
		foreach($latest_profiles_scroller as $k => &$v) {
			$v->profile_pic = \classes\UserPictures::getProfilePicture($v->user_key, $this->Registry->user_pictures_settings->thumbnail_width, $this->Registry->user_pictures_settings->thumbnail_height);
		}

		unset($k);
		unset($v);
		$featured_profiles = $this->modelUsers->getFeaturedUsers('0,' . $this->Registry->nr_items_to_display->featured_profiles)['results'];
		foreach($featured_profiles as $k => &$v) {
			$v->profile_pic = \classes\UserPictures::getProfilePicture($v->user_key, $this->Registry->user_pictures_settings->thumbnail_width, $this->Registry->user_pictures_settings->thumbnail_height);
		}
		unset($k);
		unset($v);
		$top_rated_profiles = $this->modelUsers->getTopRatedUsers('0,' . $this->Registry->nr_items_to_display->top_rated_profiles)['results'];
		foreach($top_rated_profiles as $k => &$v) {
			$v->profile_pic = \classes\UserPictures::getProfilePicture($v->user_key, $this->Registry->user_pictures_settings->thumbnail_width, $this->Registry->user_pictures_settings->thumbnail_height);
		}
		unset($k);
		unset($v);
		$matches = (isset($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key)) ? $this->modelUsersInteraction->getMatches($profile_fields, $matchesLimit) : $this->modelUsersInteraction->getMatchesNotLogged($matchesLimit);
		foreach($matches as $k => &$v) {
			$v->profile_pic = \classes\UserPictures::getProfilePicture($v->user_key, $this->Registry->user_pictures_settings->thumbnail_width, $this->Registry->user_pictures_settings->thumbnail_height);
		}
		unset($k);
		unset($v);
		$latest_blogs = $this->modelUsersContent->getBlogs($latestBlogsLimit)['results'];
		foreach($latest_blogs as $k => &$v) {
			$v->safe_seo_url = \helpers\Utils::safe_url($v->title);
		}
		unset($k);
		unset($v);
		$latest_events = $this->modelUsersContent->getEvents($latestEventsLimit)['results'];
		foreach($latest_events as $k => &$v) {
			$v->safe_seo_url = \helpers\Utils::safe_url($v->title);
		}
		unset($k);
		unset($v);
		$latest_groups = $this->modelUsersInteraction->getGroups($latestGroupsLimit)['results'];
		foreach($latest_groups as $k => &$v) {
			$v->safe_seo_url = \helpers\Utils::safe_url($v->group_name);
		}
		unset($k);
		unset($v);
		$pictures = $this->modelUsersContent->getPictures($latestPicturesLimit)['results'];
		$latest_pictures = array();
		$i = 0;
		foreach($pictures as $k => $v) {
			$latest_pictures[$i]['image'] = \classes\UserPictures::getPicture($v->user_key, $v->file_name, md5($v->gallery_name), $this->Registry->user_pictures_settings->thumbnail_width, $this->Registry->user_pictures_settings->thumbnail_height);
			$latest_pictures[$i]['id'] = $v->id;
			$latest_pictures[$i]['pic_name'] = $v->file_name;
			$latest_pictures[$i]['gallery_id'] = $v->gallery_id;
			$latest_pictures[$i]['gallery_name'] = md5($v->gallery_name);
			$latest_pictures[$i]['user_key'] = $v->user_key;
			$latest_pictures[$i]['username'] = $v->username;
			$latest_pictures[$i]['tags'] = $v->tags;
			$latest_pictures[$i]['title'] = $v->title;
			$latest_pictures[$i]['safe_seo_url'] = \helpers\Utils::safe_url($v->title);
			$latest_pictures[$i]['timestamp'] = $v->timestamp;
			$i ++;
		}
		unset($k);
		unset($v);
		$latest_videos = $this->modelUsersInteraction->getLatestVideo($latestVideosLimit)['results'];
		foreach($latest_videos as $k => &$v) {
			$v->thumb = \classes\UserVideo::getVideoThumb($v->user_key, $v->gallery_name, $v->file_name, $this->Registry->user_pictures_settings->thumbnail_width, $this->Registry->user_pictures_settings->thumbnail_height);
			$v->safe_seo_url = \helpers\Utils::safe_url($v->title);
		}

		unset($k);
		unset($v);
		$latest_music = $this->modelUsersInteraction->getLatestMusicFiles($latestMusicLimit)['results'];
		foreach($latest_music as $k => &$v) {
			// $v->thumb =
			// \classes\UserVideo::getVideoThumb($v->user_key,$v->gallery_name,$v->file_name,$this->Registry->user_pictures_settings->thumbnail_width,$this->Registry->user_pictures_settings->thumbnail_height);
			$v->safe_seo_url = \helpers\Utils::safe_url($v->title);
		}

		unset($k);
		unset($v);
		$this->view->assign('wn_theme', isset($this->Registry->COOKIE['jquery-ui-theme']) ? $this->Registry->COOKIE['jquery-ui-theme'] : $this->Registry->Settings->default_theme);
		$this->view->assign('user_logged', $this->user_logged);
		$this->view->assign('profiles_right',array('0' => array_merge(array('type' => 'video'),(array)$latest_videos[0]),'2' => array_merge(array('type' => 'picture'),(array)$latest_pictures[0]),'6' => array_merge(array('type' => 'user'),(array)$latest_profiles[0]))) ;
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->assign('chat_messages', $this->chat_messages);
		$this->view->assign('latest_profiles', $latest_profiles);
		$this->view->assign('latest_profiles_scroller', $latest_profiles_scroller);
		$this->view->assign('featured_profiles', $featured_profiles);
		$this->view->assign('top_rated_profiles', $top_rated_profiles);
		$this->view->assign('themes', (new \classes\Themes\Themes() )->getThemesAr());
		$this->view->assign('blogs', $latest_blogs);
		$this->view->assign('latest_events', $latest_events);
		$this->view->assign('groups', $latest_groups);
		$this->view->assign('pictures', $latest_pictures);
		$this->view->assign('music', $latest_music);
		$this->view->assign('video', $latest_videos);
		(isset($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key)) ? $this->view->assign('unread_messages', count((array) $this->modelUsersInteraction->getUnreadMessages(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		)))) : NULL;
		(isset($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key)) ? $this->view->assign('nr_friend_requests', count((array) $this->modelUsersInteraction->getFriendsRequests(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		)))) : NULL;

		(isset($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key)) ? $this->view->assign('friends_requests', $this->modelUsersInteraction->getNewFriendsRequestsMyAccount(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		))) : NULL;

		(isset($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key)) ? $this->view->assign('stats_nr_friends', $this->modelUsersInteraction->getTotalNrFriends(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		))) : NULL;
		(isset($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key)) ? $this->view->assign('stats_nr_best_friends', $this->modelUsersInteraction->getTotalNrBestFriends(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		))) : NULL;
		(isset($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key)) ? $this->view->assign('stats_nr_family', $this->modelUsersInteraction->getTotalNrFamily(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		))) : NULL;
		(isset($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key)) ? $this->view->assign('stats_nr_groups', $this->modelUsersInteraction->getTotalUserGroups(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		))) : NULL;
		(isset($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key)) ? $this->view->assign('stats_nr_events', $this->modelUsersInteraction->getTotalUserEvents(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		))) : NULL;
		(isset($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key)) ? $this->view->assign('stats_nr_blogs', $this->modelUsersInteraction->getTotalUserBlogs(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		))) : NULL;
		(isset($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key)) ? $this->view->assign('upcoming_events', $this->modelUsersInteraction->getUserUpcomingEvents(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		))) : NULL;
		(isset($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key)) ? $this->view->assign('upcoming_events_to_attend', $this->modelUsersInteraction->getUserUpcomingEventsToAttend(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		))) : NULL;
		$this->view->assign('matches', $matches);
		(isset($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key)) ? $this->view->assign('user', $this->modelUsers->getUserByUserKey($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key)) : $this->view->assign('user', '');
		$this->view->assign('thumbnail_width', $this->Registry->user_pictures_settings->thumbnail_width);
		$this->view->assign('thumbnail_height', $this->Registry->user_pictures_settings->thumbnail_height);
		$this->view->assign('large_image_width', $this->Registry->user_pictures_settings->large_image_width);
		$this->view->assign('large_image_height', $this->Registry->user_pictures_settings->large_image_height);
		$this->view->assign('width_big_profile_picture', $this->Registry->user_pictures_settings->width_of_big_profile_picture);
		$this->view->assign('height_big_profile_picture', $this->Registry->user_pictures_settings->height_of_big_profile_picture);
		($this->Registry->Settings->enable_multiple_languages == 'yes') ? $this->view->assign('all_languages', $this->model->getAllLanguages()) : array();

		(! isset($_SESSION['user_' . $_SERVER['SERVER_NAME']])) ? $this->view->assign('user', '') : $this->view->assign('user', $this->modelUsers->getUserByUserKey($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key));
				$this->view->assign('resolution',explode('x', $this->Registry->COOKIE['users_resolution']));

		$this->view->assign('footer_pages', $this->model->getTextPages('footer'));
		return $this->view;
	}
	function textPage() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		$this->view->assign('page_text', $this->model->getTextPage($this->GET['id']));
		$this->view->display('pages/text_pages/text_page.tpl');
	}
}

?>