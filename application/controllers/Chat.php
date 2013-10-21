<?php

namespace controllers;

use helpers\RequestHash;
use lib\Core\Controller;
use lib\Core\Registry;

class Chat extends Controller {
	function __construct() {
		parent::__construct();
		
		$this->Registry = Registry::getInstance();
		
		(new \SplAutoloader('models', array(
				'models'
		)) )->register();
		include HELPERS_DIR . 'RequestHash.php';
		$model = 'models\\Model' . ucfirst(strtolower($this->Registry->controllerName));
		$this->model = new $model();
	}
	function roomChatMessages() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		$this->modelUsers = new \models\ModelUsers();
		$this->Messages = $this->model->getRoomsMessages(array(
				$this->POST['id']
		));
		$this->Messages = array_reverse($this->Messages);
		foreach($this->Messages as $k => $v) {
			$user = $this->modelUsers->getUserByUsername($v->user_from);
			if($this->Registry->Settings->only_logged_in_users_can_view_profile_info == 'yes') {
				$link = 'onclick="show_user_notification(\'' . $this->Registry->languages->user_not_logged . '\')"';
			} else {
				if(NO_AJAX == 'yes') {
					$link = 'href="' . $this->Registry->Settings->site_url . 'profile/' . $user->username . '"';
				} else {
					$link = 'onclick="view_profile(\'' . $user->user_key . '\')"';
				}
			}
			
			echo '<div class="chat_from"><a ' . $link . ' class="label label-info chat_link">' . $user->username . ':</a></div><div class="chat_message">' . $v->message . '</div><div class="chat_message_separator"></div>';
		}
		
		exit();
	}
	function generalMessages() {
		$this->modelUsers = new \models\ModelUsers();
		$this->Messages = $this->model->getGeneralMessages();
		if(count($this->Messages) > 0) {
			$this->Messages = array_reverse($this->Messages);
			foreach($this->Messages as $k => $v) {
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
					echo '<div class="chat_from"><a ' . $link . ' class="label label-info chat_link">' . $user->username . ':</a></div><div class="chat_message">' . $v->message . '</div><div class="chat_message_separator"></div>';
				}
			}
		} else {
			echo $this->Registry->languages->general_chat_no_recent_messages;
		}
		
		exit();
	}
	function sendGeneralMessage() {
		if($this->Registry->Settings->only_logged_users_can_post_on_general_chat == 'yes') {
			if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
				echo json_encode(array(
						'status' => $this->Registry->languages->user_not_logged
				));
				exit();
			}
		}
		
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		$this->model->sendGeneralMessage($this->POST['message']);
		echo json_encode(array(
				'status' => ''
		));
	}
	function friendChatMessages() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		$this->modelUsers = new \models\ModelUsers();
		$this->Messages = $this->model->getFriendsMessages(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->username,
				$this->POST['id'],
				$this->POST['id'],
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->username
		));
		if(count($this->Messages) > 0) {
			$this->Messages = array_reverse($this->Messages);
			foreach($this->Messages as $k => $v) {
				$user = $this->modelUsers->getUserByUsername($v->user_from);
				if($this->Registry->Settings->only_logged_in_users_can_view_profile_info == 'yes') {
					$link = 'onclick="show_user_notification(\'' . $this->Registry->languages->user_not_logged . '\')"';
				} else {
					if(NO_AJAX == 'yes') {
						$link = 'href="' . $this->Registry->Settings->site_url . 'profile/' . $user->username . '"';
					} else {
						$link = 'onclick="view_profile(\'' . $user->user_key . '\')"';
					}
				}
				echo '<div class="chat_from"><a ' . $link . ' class="label label-info chat_link">' . $user->username . ':</a></div><div class="chat_message">' . $v->message . '</div><div class="chat_message_separator"></div>';
			}
		} else {
			echo '<div class="chat_message">Start conversation</div><div class="chat_message_separator"></div>';
		}
		exit();
	}
	function sendFriendMessage() {
		$this->modelUsers = new \models\ModelUsers();
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo json_encode(array(
					'status' => $this->Registry->languages->user_not_logged
			));
			exit();
		}
		if($this->modelUsers->checkUserIsOnlineByUsername($this->POST['id']) == '0') {
			echo json_encode(array(
					'status' => $this->Registry->languages->friend_is_not_logged_in_anymore
			));
			exit();
		}
		
		$this->model->sendFriendMessage(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->username,
				$this->POST['id'],
				0,
				$this->POST['message'],
				time()
		));
		echo json_encode(array(
				'status' => 'sent'
		));
	}
	function sendRoomMessage() {
		$this->modelUsers = new \models\ModelUsers();
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE && $this->Registry->Settings->only_logged_users_can_post_on_chatrooms == 'yes') {
			echo json_encode(array(
					'status' => $this->Registry->languages->user_not_logged
			));
			exit();
		}
		
		if($this->Registry->Settings->only_logged_users_can_post_on_chatrooms == 'yes' && (new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			$user_from = 'unknown';
		} else {
			$user_from = $_SESSION['user_' . $_SERVER['SERVER_NAME']]->username;
		}
		
		$this->model->sendRoomMessage(array(
				$user_from,
				'',
				$this->POST['id'],
				$this->POST['message'],
				time()
		));
		echo json_encode(array(
				'status' => ''
		));
	}
	function getChat() {
		if($this->Registry->Settings->enable_chat == 'yes') {
			$this->user_logged = (new \lib\RBAC\RBACSystem() )->CheckAccess();
			$this->modelUsers = new \models\ModelUsers();
			$this->modelUsersInteraction = new \models\ModelUsersInteraction();
			$this->chat_messages = '';
			$this->friends = array();
			$this->chatMessages = $this->model->getGeneralMessages();
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
			
			$this->view->assign('chatrooms', $this->model->getChatrooms());
			if($this->user_logged === TRUE) {
				
				$this->online_friends = $this->modelUsersInteraction->getOnlineFriends();
				foreach($this->online_friends as $k => $v) {
					if($v->friend_key == $_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key) {
						$v->friend_key = $v->user_key;
					}
					$this->friends[] = $this->modelUsers->getUserByUserKey($v->friend_key);
				}
			}
			$this->view->assign('user_logged', $this->user_logged);
			$this->view->assign('chat_messages', $this->chat_messages);
			$this->view->assign('online_friends', $this->friends);
			define('IGNORE_NO_AJAX', 'yes');
			$this->view->display('chat/chat.tpl');
		}
	}
}

?>