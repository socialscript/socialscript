<?php

namespace controllers;

use lib\Core\Controller;
use lib\Core\Registry;
use helpers\RequestHash;

class UsersInteraction extends Controller {
	function __construct() {
		parent::__construct();
		$this->Registry = Registry::getInstance();
		(new \SplAutoloader('models', array(
		'models'
		)) )->register();

		$model = 'models\Model' . $this->Registry->controllerName;
		$this->model = new $model();
	}
	function addFriend() {
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

		if($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key == $this->POST['id']) {
			echo json_encode(array(
			'status' => $this->Registry->languages->user_cannot_add_himself_as_friend
			));
			exit();
		}

		$this->modelUsers = new \models\ModelUsers();
		if($this->modelUsers->checkUserExists($this->POST['id']) == 1) {
			if($this->model->addFriend(array(
			$this->POST['id'],
			$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
			'0'
			)) === FALSE) {
				echo json_encode(array(
				'status' => $this->Registry->languages->user_already_added_as_friend
				));
				exit();
			} else {
				echo json_encode(array(
				'status' => $this->Registry->languages->user_succesfully_added_as_friend
				));
				exit();
			}
		} else {
			echo json_encode(array(
			'status' => $this->Registry->languages->user_does_not_exist
			));
			exit();
		}
	}
	function sayHello() {
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

		if($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key == $this->POST['id']) {
			echo json_encode(array(
			'status' => $this->Registry->languages->user_cannot_say_hello_to_himself
			));
			exit();
		}
		$this->modelUsers = new \models\ModelUsers();
		if($this->modelUsers->checkUserExists($this->POST['id']) == 1) {
			if($this->model->sayHello(array(
			$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
			$this->POST['id'],
			time()
			)) === TRUE) {
				echo json_encode(array(
				'status' => $this->Registry->languages->user_succesfully_said_hello
				));
				exit();
			}
		} else {
			echo json_encode(array(
			'status' => $this->Registry->languages->user_does_not_exist
			));
			exit();
		}
	}
	function markInterestedIn() {
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

		if($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key == $this->POST['id']) {
			echo json_encode(array(
			'status' => $this->Registry->languages->user_cannot_mark_himself_interested
			));
			exit();
		}
		$this->modelUsers = new \models\ModelUsers();
		if($this->modelUsers->checkUserExists($this->POST['id']) == 1) {
			if($this->model->markInterestedIn(array(
			$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
			$this->POST['id'],
			time()
			)) === TRUE) {
				echo json_encode(array(
				'status' => $this->Registry->languages->user_succesfully_marked_interested_in
				));
				exit();
			}
		} else {
			echo json_encode(array(
			'status' => $this->Registry->languages->user_does_not_exist
			));
			exit();
		}
	}
	function askQuestion() {
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

		if($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key == $this->POST['id']) {
			echo json_encode(array(
			'status' => $this->Registry->languages->user_cannot_ask_question_to_himself
			));
			exit();
		}
		$this->modelUsers = new \models\ModelUsers();
		if($this->modelUsers->checkUserExists($this->POST['id']) == 1) {
			if($this->model->askQuestion(array(
			$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
			$this->POST['id'],
			$this->POST['question'],
			time()
			)) === TRUE) {
				echo json_encode(array(
				'status' => $this->Registry->languages->user_succesfully_asked_question
				));
				exit();
			}
		} else {
			echo json_encode(array(
			'status' => $this->Registry->languages->user_does_not_exist
			));
			exit();
		}
	}
	function subscribeToEvents() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo json_encode(array(
			'status' => $this->Registry->languages->user_not_logged
			));

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);

		if($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key == $this->POST['u_k']) {
			echo json_encode(array(
			'status' => 'You cannot subscribe to yourself'
			));
			exit();
		}

		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo json_encode(array(
			'status' => $this->Registry->languages->user_wrong_request
			));

			exit();
		}

		$this->model->subscribeToEvents(array(
		$this->POST['u_k'],
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		));

		echo json_encode(array(
		'status' => 'subscribed'
		));
	}
	function subscribeToPictures() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo json_encode(array(
			'status' => $this->Registry->languages->user_not_logged
			));

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);

		if($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key == $this->POST['u_k']) {
			echo json_encode(array(
			'status' => 'You cannot subscribe to yourself'
			));
			exit();
		}

		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo json_encode(array(
			'status' => $this->Registry->languages->user_wrong_request
			));

			exit();
		}

		$this->model->subscribeToPictures(array(
		$this->POST['u_k'],
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		));

		echo json_encode(array(
		'status' => 'subscribed'
		));
	}

	function subscribeToVideos() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo json_encode(array(
			'status' => $this->Registry->languages->user_not_logged
			));

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);

		if($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key == $this->POST['u_k']) {
			echo json_encode(array(
			'status' => 'You cannot subscribe to yourself'
			));
			exit();
		}

		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo json_encode(array(
			'status' => $this->Registry->languages->user_wrong_request
			));

			exit();
		}

		$this->model->subscribeToPictures(array(
		$this->POST['u_k'],
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		));

		echo json_encode(array(
		'status' => 'subscribed'
		));
	}
	function subscribeToMusic() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo json_encode(array(
			'status' => $this->Registry->languages->user_not_logged
			));

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);

		if($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key == $this->POST['u_k']) {
			echo json_encode(array(
			'status' => 'You cannot subscribe to yourself'
			));
			exit();
		}

		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo json_encode(array(
			'status' => $this->Registry->languages->user_wrong_request
			));

			exit();
		}

		$this->model->subscribeToMusic(array(
		$this->POST['u_k'],
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		));

		echo json_encode(array(
		'status' => 'subscribed'
		));
	}
	function subscribeToBlog() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo json_encode(array(
			'status' => $this->Registry->languages->user_not_logged
			));

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);

		if($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key == $this->POST['u_k']) {
			echo json_encode(array(
			'status' => 'You cannot subscribe to yourself'
			));
			exit();
		}

		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo json_encode(array(
			'status' => $this->Registry->languages->user_wrong_request
			));

			exit();
		}

		$this->model->subscribeToBlog(array(
		$this->POST['u_k'],
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		));

		echo json_encode(array(
		'status' => 'subscribed'
		));
	}
	function inviteToEvent() {
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

		if(! isset($this->POST['event'])) {
			echo json_encode(array(
			'status' => 'No event selected'
			));
			exit();
		}
		if($this->model->checkEventExists(array(
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
		$this->POST['event']
		)) > 0) {
			if($this->model->checkInvitedToEvent(array(
			$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
			$this->POST['id'],
			$this->POST['event']
			)) < 1) {
				$this->model->inviteToEvent(array(
				$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
				$this->POST['id'],
				$this->POST['event'],
				'0'
				));
				echo json_encode(array(
				'status' => 'Succesfully invited to event'
				));
			} else {
				echo json_encode(array(
				'status' => 'You already invited this user to event'
				));
			}
		} else {
			echo json_encode(array(
			'status' => 'Not an event'
			));
			exit();
		}
	}
	function getEventsToInvite() {
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

		if($this->GET['id'] == $_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key) {
			echo 'You cannot invite yourself to event';

			exit();
		} 

		$this->view->assign('events', $this->model->getEventsToInvite(array(
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
		date('Y-m-d')
		)));
		define('IGNORE_NO_AJAX', 'yes');

		$this->view->assign('id', $this->GET['id']);
		$this->view->display('user/events_to_invite.tpl');
	}
	function addBlogComment() {
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

		$this->model->addBlogComment(array(
		$this->POST['id'],
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
		$this->POST['comment'],
		time()
		));

		echo json_encode(array(
		'status' => 'added'
		));
	}
	function viewBlogComments() {
		// header('Content-type: text/html');
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		unset($this->Registry);

		$this->view->assign('blogs_comments', $this->model->getBlogComments(array(
		$this->GET['id']
		)));
		unset($this->model);
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->assign('blog_id', $this->GET['id']);
		unset($this->GET);
		define('IGNORE_NO_AJAX', 'yes');
		$this->view->display('user/blogs/view_blogs_comments.tpl');
		unset($this->view);
	}
	function getBlogComments() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		if(RequestHash::validateHash($this->GET['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}

		$this->view->assign('blogs_comments', $this->model->getBlogComments(array(
		$this->GET['id']
		)));
		$this->view->assign('id', $this->GET['id']);
		$this->view->assign('request_hash', RequestHash::Generate());
		define('IGNORE_NO_AJAX', 'yes');
		$this->view->display('user/blogs/comments.tpl');
	}
	function viewPicturesAllComments() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		$this->view->assign('pictures_comments', $this->model->getPicturesComments(array(
		$this->GET['id']
		)));
		$this->view->assign('p_id', $this->GET['id']);
		$this->view->assign('request_hash', RequestHash::Generate());
		define('IGNORE_NO_AJAX', 'yes');
		$this->view->display('pages/photos/picture_comments.tpl');
	}
	function viewPicturesComments() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		$this->view->assign('pictures_comments', $this->model->getPicturesComments(array(
		$this->GET['id']
		)));
		$this->view->assign('p_id', $this->GET['id']);
		$this->view->assign('request_hash', RequestHash::Generate());
		define('IGNORE_NO_AJAX', 'yes');
		$this->view->display('pages/photos/comments.tpl');
	}
	function viewGroupPicturesComments() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		$this->view->assign('comments', $this->model->getGroupPicturesComments(array(
		$this->GET['id']
		)));
		$this->view->assign('p_id', $this->GET['id']);
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->display('pages/groups/view_group_pictures_comments.tpl');
	}
	function getGroupPictureComments() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		$this->view->assign('comments', $this->model->getGroupPicturesComments(array(
		$this->GET['id']
		)));
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->display('pages/groups/comments.tpl');
	}
	function viewGroupVideosComments() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		$this->view->assign('comments', $this->model->getGroupVideosComments(array(
		$this->GET['id']
		)));
		$this->view->assign('p_id', $this->GET['id']);
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->display('pages/groups/view_group_videos_comments.tpl');
	}
	function getGroupVideoComments() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		$this->view->assign('comments', $this->model->getGroupVideosComments(array(
		$this->GET['id']
		)));
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->display('pages/groups/comments.tpl');
	}
	function getGroupMusicComments() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		$this->view->assign('comments', $this->model->getGroupMusicComments(array(
		$this->GET['id']
		)));
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->display('pages/groups/comments.tpl');
	}
	function viewGroupMusicComments() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		$this->view->assign('comments', $this->model->getGroupMusicComments(array(
		$this->GET['id']
		)));
		$this->view->assign('p_id', $this->GET['id']);
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->display('pages/groups/view_group_musics_comments.tpl');
	}

	function deleteGroupVideo()
	{
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

		$this->model->deleteGroupVideo(array(
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
		$this->POST['id']
		));

		echo json_encode(array(
		'status' => 'deleted'
		));
	}

	function deleteGroupMusic()
	{
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

		$this->model->deleteGroupMusic(array(
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
		$this->POST['id']
		));

		echo json_encode(array(
		'status' => 'deleted'
		));
	}
	function deleteGroupPicture()
	{
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

		$this->model->deleteGroupPicture(array(
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
		$this->POST['id']
		));

		echo json_encode(array(
		'status' => 'deleted'
		));
	}

	function addPictureComment() {
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

		$this->model->addPictureComment(array(
		$this->POST['id'],
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
		$this->POST['comment'],
		time()
		));

		echo json_encode(array(
		'status' => 'added'
		));
	}
	function getPictureComments() {
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

		$this->view->assign('pictures_comments', $this->model->getPicturesComments(array(
		$this->POST['p_id']
		)));
		$this->view->assign('p_id', $this->POST['p_id']);
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->display('user/pictures/pictures_comments.tpl');
	}
	function viewEventComments() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		$this->view->assign('events_comments', $this->model->getEventComments(array(
		$this->POST['id']
		)));
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->assign('event_id', $this->POST['id']);
		define('IGNORE_NO_AJAX', 'yes');
		$this->view->display('user/events/view_events_comments.tpl');
	}
	function getEventComments() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);

		$this->view->assign('events_comments', $this->model->getEventComments(array(
		$this->GET['id']
		)));
		$this->view->assign('id', $this->GET['id']);
		$this->view->assign('request_hash', RequestHash::Generate());
		define('IGNORE_NO_AJAX', 'yes');
		$this->view->display('user/events/comments.tpl');
	}
	function addEventComment() {
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

		$this->model->addEventComment(array(
		$this->POST['id'],
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
		$this->POST['comment'],
		time()
		));

		echo json_encode(array(
		'status' => 'added'
		));
	}
	function sendMessage() {
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

		$this->model->sendMessage(array(
		$this->POST['id'],
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
		$this->POST['title'],
		$this->POST['message'],
		time()
		));

		echo json_encode(array(
		'status' => 'sent'
		));
	}
	function Messages() {
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

		$from = ! isset($this->GET["pag"]) ? 1 : $this->GET["pag"];
		$page = $from - 1;
		$limit_start = $page * $this->Registry->nr_items_to_display->messages;

		$Limit = $limit_start . ',' . $this->Registry->nr_items_to_display->messages;
		$messages = $this->model->getMessages(array(
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		), $Limit);

		$hellos = $this->model->getHellos(array(
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		), $Limit);

		$marked_interested_in = $this->model->getMarkedInterestedIn(array(
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		), $Limit);

		$this->view->assign('messages', $messages['results']);
		$this->view->assign('hellos', $hellos['results']);
		$this->view->assign('marked_interested_in', $marked_interested_in['results']);
		$this->view->assign('pagination', \classes\Pagination::Generate($page, $this->Registry->nr_items_to_display->messages, $messages['nr_rows'], 'route=users_interaction&action=messages&rh=' . RequestHash::Generate(), 'messages_list'));
		if(! isset($this->GET["pag"])) {
			$this->view->display('manage_profile/messages.tpl');
		} else {
			$this->view->display('manage_profile/messages_inner.tpl');
		}
	}
	function deleteMessage() {
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

		$this->model->deleteMessage(array(
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
		$this->POST['id']
		));

		echo json_encode(array(
		'status' => 'deleted'
		));
	}
	function markMessageRead() {
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

		$this->model->markMessageRead(array(
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
		$this->POST['id']
		));
		exit();
	}
	function Friends() {
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
		$from = ! isset($this->GET["pag"]) ? 1 : $this->GET["pag"];
		$page = $from - 1;
		$limit_start = $page * $this->Registry->nr_items_to_display->friends_page;

		$Limit = $limit_start . ',' . $this->Registry->nr_items_to_display->friends_page;

		$friends_requests = $this->model->getNewFriendsRequests(array(
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		), $Limit);
		foreach($friends_requests['results'] as $k => &$v) {
			$v->profile_pic = \classes\UserPictures::getProfilePicture($v->friend_key, $this->Registry->user_pictures_settings->thumbnail_width, $this->Registry->user_pictures_settings->thumbnail_height);
		}
		$friends = $this->model->getFriends(array(
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		), $Limit);
		foreach($friends['results'] as $k => &$v) {
			$v->profile_pic = \classes\UserPictures::getProfilePicture($v->friend_key, $this->Registry->user_pictures_settings->thumbnail_width, $this->Registry->user_pictures_settings->thumbnail_height);
			$v->user_key = $v->friend_key;
		}
		$this->view->assign('friends_requests', $friends_requests['results']);
		$this->view->assign('friends', $friends['results']);
		$this->view->assign('pagination', \classes\Pagination::Generate($page, $this->Registry->nr_items_to_display->friends_page, $friends['nr_rows'], 'route=users_interaction&action=friends', 'friends_list'));
		if(! isset($this->GET["pag"])) {
			$this->view->display('manage_profile/friends/friends.tpl');
		} else {
			$this->view->display('manage_profile/friends/friends_inner.tpl');
		}
	}
	function acceptFriendRequest() {
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

		$this->model->acceptFriendRequest(array(
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
		$this->POST['id']
		))->notifyFriendRequestAccepted(array(
		$this->POST['id'],
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
		$this->Registry->languages->friend_request_accepted_title,
		$this->Registry->languages->friend_request_accepted_text,
		time()
		))->addFriend2(array(
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
		$this->POST['id'],
		'1'
		));
		echo json_encode(array(
		'status' => 'accepted'
		));
		exit();
	}
	function denyFriendRequest() {
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

		$this->model->denyFriendRequest(array(
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
		$this->POST['id']
		))->notifyFriendRequestDenied(array(
		$this->POST['id'],
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
		$this->Registry->languages->friend_request_denied_title,
		$this->Registry->languages->friend_request_denied_text,
		time()
		));
		echo json_encode(array(
		'status' => 'denied'
		));
		exit();
	}
	function subscribeToGroups() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo json_encode(array(
			'status' => $this->Registry->languages->user_not_logged
			));

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);

		if($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key == $this->POST['u_k']) {
			echo json_encode(array(
			'status' => 'You cannot subscribe to yourself'
			));
			exit();
		}

		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo json_encode(array(
			'status' => $this->Registry->languages->user_wrong_request
			));

			exit();
		}

		$this->model->subscribeToGroup(array(
		$this->POST['u_k'],
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		));

		echo json_encode(array(
		'status' => 'subscribed'
		));
	}
	function joinGroup() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo json_encode(array('status' => $this->Registry->languages->user_not_logged));

			exit();
		}
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);

		if($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key == $this->POST['u_k']) {
			echo json_encode(array(
			'status' => 'You cannot join to your own group'
			));
			exit();
		}

		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo json_encode(array('status' => $this->Registry->languages->user_wrong_request));

			exit();
		}

		if($this->model->checkIfUserAlreadGroupMember(array($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,$this->POST['id'])) > 0) {
			echo json_encode(array('status' => $this->Registry->languages->already_group_member));

			exit();
		}


		$this->model->joinGroup(array(
		$this->POST['id'],
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
		time()
		));

		echo json_encode(array(
		'status' => 'joined'
		));
	}
	function viewGroupComments() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		$this->ModelUsersContent = new \models\ModelUsersContent();
		$this->view->assign('group', $this->ModelUsersContent->getGroup(array(
		$this->POST['id']
		)));

		$this->view->assign('groups_comments', $this->model->getGroupComments(array(
		$this->POST['id']
		)));
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->assign('group_id', $this->POST['id']);
		$this->view->display('user/groups/view_groups_comments.tpl');
	}
	function addGroupComment() {
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

		$this->model->addGroupComment(array(
		$this->POST['id'],
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
		$this->POST['comment'],
		time()
		));

		echo json_encode(array(
		'status' => 'added'
		));
	}
	function getGroupComments() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}

		$this->modelUsersContent = new \models\ModelUsersContent();
		$this->view->assign('groups_comments', $this->model->getGroupComments(array(
		$this->POST['id']
		)));
		$this->view->assign('id', $this->POST['id']);
		$this->view->assign('group', $this->modelUsersContent->getGroup(array(
		$this->POST['id']
		)));
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->display('user/groups/groups_comments.tpl');
	}
	function showGroups() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);

		$this->ModelUsers = new \models\ModelUsers();
		$this->ModelUsersInteraction = new \models\ModelUsersInteraction();

		$from = ! isset($this->GET["pag"]) ? 1 : $this->GET["pag"];
		$page = $from - 1;
		$limit_start = $page * $this->Registry->nr_items_to_display->groups_page;

		$Limit = $limit_start . ',' . $this->Registry->nr_items_to_display->groups_page;

		$groups = $this->model->getGroups($Limit);
		foreach($groups['results'] as $k => &$v) {
			$v->safe_seo_url = \helpers\Utils::safe_url($v->group_name);
		}
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->assign('groups', $groups['results']);
		$this->view->assign('pagination', \classes\Pagination::Generate($page, $this->Registry->nr_items_to_display->groups_page, $groups['nr_rows'], 'route=users_interaction&action=show_groups', 'groups'));
		if(! isset($this->GET["pag"])) {
			$this->view->display('pages/groups/show_groups.tpl');
		} else {
			$this->view->display('pages/groups/groups.tpl');
		}
	}
	function groupDetails() {
		if($this->Registry->Settings->only_logged_in_users_can_view_group_info == 'yes') {
			if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
				echo $this->Registry->languages->user_not_logged;

				exit();
			}
		}
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);

		$this->modelUsersContent = new \models\ModelUsersContent();
		$this->ModelUsers = new \models\ModelUsers();

		$request_hash = RequestHash::Generate();
		$group = $this->modelUsersContent->getGroup(array(
		$this->GET['id']
		));

		$members = $this->model->getMembers(array(
		$group->user_key
		), array(
		$group->id
		));

		$videos = $this->model->getGroupVideos(array(
		$group->id
		));
		$music = $this->model->getGroupMusics(array(
		$group->id
		));
		$pictures = $this->model->getGroupPictures(array(
		$group->id
		));

		$pictures_2 = array();
		$i = 0;
		foreach($pictures as $k => $v) {
			$pictures_2[$i]['image'] = \classes\UserPictures::getGroupPicture($v->file_name, md5($group->group_name), $this->Registry->user_pictures_settings->group_picture_thumbnail_width, $this->Registry->user_pictures_settings->group_picture_thumbnail_height);
			$pictures_2[$i]['id'] = $v->id;
			$pictures_2[$i]['file_name'] = $v->file_name;
			$pictures_2[$i]['group_id'] = $v->group_id;
			$pictures_2[$i]['user_key'] = $group->id;
			$pictures_2[$i]['delete'] = '';
			if(isset($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key)) {
			($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key == $v->user_key) ? $pictures_2[$i]['delete'] = 'yes' : NULL;
			}
			$i ++;
		}
		unset($k);
		unset($v);
		foreach($videos as $k => &$v) {
			$v->thumb = \classes\UserVideo::getGroupVideoThumb(md5($group->group_name), $v->file_name, $this->Registry->user_videos_settings->group_thumbnail_width, $this->Registry->user_videos_settings->group_thumbnail_height);
			$v->delete = '';
			if(isset($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key)) {
			($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key == $v->user_key) ? $v->delete = 'yes' : NULL;
			}
		}
		unset($k);
		unset($v);
		foreach($music as $k => &$v) {
			$v->delete = '';
			if(isset($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key)) {
			($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key == $v->user_key) ? $v->delete = 'yes' : NULL;
			}
		}
		unset($k);
		unset($v);
		$blogs = $this->model->getGroupBlogs(array(
		$group->id
		));
		foreach($blogs as $k => &$v) {
			$v->edit = '';
			if(isset($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key)) {
			($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key == $v->user_key) ? $v->edit = 'yes' : NULL;
			}
		}

		$events = $this->model->getGroupEvents(array(
		$group->id
		));
		unset($k);
		unset($v);
		foreach($events as $k => &$v) {
			$v->edit = '';
			if(isset($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key)) {
			($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key == $v->user_key) ? $v->edit = 'yes' : NULL;
			}
		}

		$this->view->assign('groups_pictures', $pictures_2);
		$this->view->assign('group_videos', $videos);
		$this->view->assign('group_musics', $music);
		$this->view->assign('request_hash', $request_hash);
		$this->view->assign('large_image_width', $this->Registry->user_pictures_settings->large_image_width);
		$this->view->assign('large_image_height', $this->Registry->user_pictures_settings->large_image_height);
		$this->view->assign('picture_user_key', $group->id);

		$this->view->assign('group_id', $group->id);
		$this->view->assign('members', $members);
		$this->view->assign('group', $group);
		$this->view->assign('group_blogs', $blogs);
		$this->view->assign('group_events', $events);
		$this->view->assign('user_logged', (new \lib\RBAC\RBACSystem() )->CheckAccess());
		$this->view->display('pages/groups/group_details.tpl');
	}
	function addGroupBlog() {
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
		$group = $this->model->getGroup(array(
		$this->POST['group_id']
		));
		if($this->model->checkIfGroupMember(array(
		$this->POST['group_id'],
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		)) < 1 && ($group->privacy == 2 || $group->privacy == 3)) {

			echo json_encode(array(
			'status' => 'not a group member'
			));

			exit();
		}
		$this->model->addGroupBlog(array(
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
		$this->POST['group_id'],
		$this->POST['group_blog_title'],
		$this->POST['group_blog_text'],
		time()
		));
		echo json_encode(array(
		'status' => 'added'
		));
		exit();
	}
	function getGroupBlogEdit() {
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

		$blog = $this->model->getGroupBlog(array(
		$this->POST['id']
		));
		echo json_encode($blog);
	}
	function editGroupBlog() {
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
		$group = $this->model->getGroup(array(
		$this->POST['group_id']
		));
		if($this->model->checkIfGroupMember(array(
		$this->POST['group_id'],
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		)) < 1 && ($group->privacy == 2 || $group->privacy == 3)) {

			echo json_encode(array(
			'status' => 'not a group member'
			));

			exit();
		}
		$this->model->editGroupBlog(array(
		$this->POST['group_blog_title'],
		$this->POST['group_blog_text'],
		$this->POST['group_blog_id'],
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		));
		echo json_encode(array(
		'status' => 'edited'
		));
		exit();
	}
	function groupBlogs() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}

		$blogs = $this->model->getGroupBlogs(array(
		$this->POST['group_id']
		));

		$this->view->assign('request_hash', RequestHash::Generate());
		foreach($blogs as $k => &$v) {
			$v->edit = '';
			if(isset($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key)) {
			($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key == $v->user_key) ? $v->edit = 'yes' : NULL;
			}
		}

		$this->view->assign('group_blogs', $blogs);
		$this->view->display('pages/groups/blogs.tpl');
	}
	function getGroupBlog() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}
		$blog = $this->model->getGroupBlog(array(
		$this->POST['blog_id']
		));
		echo (json_encode($blog));
		exit();
	}
	function viewGroupBlogComments() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		$this->view->assign('comments', $this->model->getGroupBlogComments(array(
		$this->POST['id']
		)));
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->assign('blog_id', $this->POST['id']);
		define('IGNORE_NO_AJAX', 'yes');
		$this->view->display('pages/groups/view_group_blogs_comments.tpl');
	}
	function addGroupBlogComment() {
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

		$this->model->addGroupBlogComment(array(
		$this->POST['id'],
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
		$this->POST['comment'],
		time()
		));

		echo json_encode(array(
		'status' => 'added'
		));
	}
	function getGroupBlogComments() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}

		$this->view->assign('comments', $this->model->getGroupBlogComments(array(
		$this->POST['id']
		)));
		$this->view->assign('id', $this->POST['id']);
		$this->view->assign('request_hash', RequestHash::Generate());
		define('IGNORE_NO_AJAX', 'yes');
		$this->view->display('pages/groups/comments.tpl');
	}
	function getGroupPicture() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo json_encode(array(
			'status' => $this->Registry->languages->user_wrong_request
			));

			exit();
		}
		$picture = $this->model->getGroupPicture(array(
		$this->POST['p_id']
		));
		$group = $this->model->getGroup(array(
		$this->POST['g_id']
		));
		$picture->image = \classes\UserPictures::getGroupPicture($picture->file_name, md5($group->group_name), $this->Registry->user_pictures_settings->group_picture_large_width, $this->Registry->user_pictures_settings->group_picture_large_height);
		echo (json_encode($picture));
		exit();
	}
	function getGroupVideo() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo json_encode(array(
			'status' => $this->Registry->languages->user_wrong_request
			));

			exit();
		}
		$video = $this->model->getGroupVideo(array(
		$this->POST['id']
		));
		$group = $this->model->getGroup(array(
		$this->POST['g_id']
		));
		$video->files = \classes\UserVideo::getGroupVideoFiles($this->Registry->Settings->site_url, md5($group->group_name), $video->file_name);
		$video->thumb = \classes\UserVideo::getGroupVideoThumb(md5($group->group_name), $video->file_name, $this->Registry->user_videos_settings->group_thumbnail_width, $this->Registry->user_videos_settings->group_thumbnail_height);
		// $picture->image =
		// \classes\UserPictures::getGroupPicture($picture->file_name,
		// md5($group->group_name),
		// $this->Registry->user_pictures_settings->group_picture_large_width,
		// $this->Registry->user_pictures_settings->group_picture_large_height);
		$this->view->assign('video_player_width', $this->Registry->user_videos_settings->group_video_player_width);
		$this->view->assign('video_player_height', $this->Registry->user_videos_settings->group_video_player_height);
		$this->view->assign('video', $video);
		$this->view->display('pages/groups/video.tpl');
	}
	function getGroupMusic() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo json_encode(array(
			'status' => $this->Registry->languages->user_wrong_request
			));

			exit();
		}
		$music = $this->model->getGroupMusic(array(
		$this->POST['id']
		));
		$group = $this->model->getGroup(array(
		$this->POST['g_id']
		));
		$music->files = \classes\UserMusic::getGroupMusicFiles($this->Registry->Settings->site_url, md5($group->group_name), $music->file_name);
		$this->view->assign('music_player_width', $this->Registry->user_music_settings->group_music_player_width);
		$this->view->assign('music_player_height', $this->Registry->user_music_settings->group_music_player_height);
		$this->view->assign('music', $music);
		$this->view->display('pages/groups/music.tpl');
	}
	function addPictures() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		$this->view->assign('group_id', $this->GET['id']);
		define('IGNORE_NO_AJAX', 'yes');
		$this->view->display('pages/groups/add_picture.tpl');
	}
	function addVideos() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		$this->view->assign('group_id', $this->GET['id']);
		define('IGNORE_NO_AJAX', 'yes');
		$this->view->display('pages/groups/add_video.tpl');
	}
	function addMusics() {
		if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
			echo $this->Registry->languages->user_not_logged;

			exit();
		}
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		$this->view->assign('group_id', $this->GET['id']);
		define('IGNORE_NO_AJAX', 'yes');
		$this->view->display('pages/groups/add_music.tpl');
	}
	function addGroupEvent() {
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
		$group = $this->model->getGroup(array(
		$this->POST['group_id']
		));
		if($this->model->checkIfGroupMember(array(
		$this->POST['group_id'],
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		)) < 1 && ($group->privacy == 2 || $group->privacy == 3)) {

			echo json_encode(array(
			'status' => 'not a group member'
			));

			exit();
		}

		$this->model->addGroupEvent(array(
		$this->POST['group_id'],
		$this->POST['group_event_title'],
		$this->POST['group_event_text'],
		$this->POST['group_event_location'],
		$this->POST['group_event_date'],
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
		time()
		));
		echo json_encode(array(
		'status' => 'added'
		));
		exit();
	}
	function editGroupEvent() {
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
		$group = $this->model->getGroup(array(
		$this->POST['group_id']
		));
		if($this->model->checkIfGroupMember(array(
		$this->POST['group_id'],
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		)) < 1 && ($group->privacy == 2 || $group->privacy == 3)) {

			echo json_encode(array(
			'status' => 'not a group member'
			));

			exit();
		}
		$this->model->editGroupEvent(array(

		$this->POST['group_event_title'],
		$this->POST['group_event_text'],
		$this->POST['group_event_location'],
		$this->POST['group_event_date'],
		$this->POST['group_event_id'],
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		));
		echo json_encode(array(
		'status' => 'edited'
		));
		exit();
	}
	function groupEvents() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}
		$events = $this->model->getGroupEvents(array(
		$this->POST['group_id']
		));
		foreach($events as $k => $v) {
			$v->edit = '';
			if(isset($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key)) {
			($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key == $v->user_key) ? $v->edit = 'yes' : NULL;
			}
		}
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->assign('group_events', $events);
		define('IGNORE_NO_AJAX', 'yes');
		$this->view->display('pages/groups/events.tpl');
	}
	function getGroupEvent() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo json_encode(array(
			'status' => $this->Registry->languages->user_wrong_request
			));

			exit();
		}
		$event = $this->model->getGroupEvent(array(
		$this->POST['event_id']
		));
		echo (json_encode($event));
		exit();
	}
	function viewGroupEventComments() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		$this->view->assign('comments', $this->model->getGroupEventComments(array(
		$this->POST['id']
		)));
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->assign('group_event_id', $this->POST['id']);
		define('IGNORE_NO_AJAX', 'yes');
		$this->view->display('pages/groups/view_group_events_comments.tpl');
	}
	function getGroupEventComments() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}

		$this->view->assign('comments', $this->model->getGroupEventComments(array(
		$this->POST['id']
		)));
		$this->view->assign('id', $this->POST['id']);
		$this->view->assign('request_hash', RequestHash::Generate());
		define('IGNORE_NO_AJAX', 'yes');
		$this->view->display('pages/groups/comments.tpl');
	}
	function addGroupEventComment() {
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

		$this->model->addGroupEventComment(array(
		$this->POST['id'],
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
		$this->POST['comment'],
		time()
		));

		echo json_encode(array(
		'status' => 'added'
		));
	}
	function addGroupPictureComment() {
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

		$this->model->addGroupPictureComment(array(
		$this->POST['id'],
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
		$this->POST['comment'],
		time()
		));

		echo json_encode(array(
		'status' => 'added'
		));
	}
	function addGroupVideoComment() {
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

		$this->model->addGroupvideoComment(array(
		$this->POST['id'],
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
		$this->POST['comment'],
		time()
		));

		echo json_encode(array(
		'status' => 'added'
		));
	}
	function addGroupMusicComment() {
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

		$this->model->addGroupMusicComment(array(
		$this->POST['id'],
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
		$this->POST['comment'],
		time()
		));

		echo json_encode(array(
		'status' => 'added'
		));
	}
	function bestFriends() {
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
		$from = ! isset($this->GET["pag"]) ? 1 : $this->GET["pag"];
		$page = $from - 1;
		$limit_start = $page * $this->Registry->nr_items_to_display->friends_page;

		$Limit = $limit_start . ',' . $this->Registry->nr_items_to_display->friends_page;

		$best_friends = $this->model->getBestFriends(array(
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		), $Limit);
		foreach($best_friends['results'] as $k => &$v) {
			$v->profile_pic = \classes\UserPictures::getProfilePicture($v->friend_key, $this->Registry->user_pictures_settings->thumbnail_width, $this->Registry->user_pictures_settings->thumbnail_height);
			$v->user_key = $v->friend_key;
		}

		$this->view->assign('best_friends', $best_friends['results']);
		$this->view->assign('pagination', \classes\Pagination::Generate($page, $this->Registry->nr_items_to_display->friends_page, $best_friends['nr_rows'], 'route=users_interaction&action=best_friends', 'best_friends_list'));
		if(! isset($this->GET["pag"])) {
			$this->view->display('manage_profile/friends/best_friends.tpl');
		} else {
			$this->view->display('manage_profile/friends/best_friends_inner.tpl');
		}
	}
	function familyFriends() {
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
		$from = ! isset($this->GET["pag"]) ? 1 : $this->GET["pag"];
		$page = $from - 1;
		$limit_start = $page * $this->Registry->nr_items_to_display->friends_page;

		$Limit = $limit_start . ',' . $this->Registry->nr_items_to_display->friends_page;
		$family_friends = $this->model->getFamilyFriends(array(
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
		), $Limit);
		foreach($family_friends['results'] as $k => &$v) {
			$v->profile_pic = \classes\UserPictures::getProfilePicture($v->friend_key, $this->Registry->user_pictures_settings->thumbnail_width, $this->Registry->user_pictures_settings->thumbnail_height);
			$v->user_key = $v->friend_key;
		}
		$this->view->assign('family_friends', $family_friends['results']);
		$this->view->assign('pagination', \classes\Pagination::Generate($page, $this->Registry->nr_items_to_display->friends_page, $family_friends['nr_rows'], 'route=users_interaction&action=family_friends', 'family_friends_inner'));
		if(! isset($this->GET["pag"])) {
			$this->view->display('manage_profile/friends/family_friends.tpl');
		} else {
			$this->view->display('manage_profile/friends/family_friends_inner.tpl');
		}
	}
	function markBestFriend() {
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

		$this->modelUsers = new \models\ModelUsers();
		if($this->modelUsers->checkUserExists($this->POST['id']) == 1) {
			if($this->model->markBestFriend(array(
			$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
			$this->POST['id']
			)) === TRUE) {
				echo json_encode(array(
				'status' => $this->Registry->languages->user_succesfully_marked_as_best_friend
				));
				exit();
			}
		} else {
			echo json_encode(array(
			'status' => $this->Registry->languages->user_does_not_exist
			));
			exit();
		}
	}
	function markFamily() {
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

		$this->modelUsers = new \models\ModelUsers();
		if($this->modelUsers->checkUserExists($this->POST['id']) == 1) {
			if($this->model->markFamily(array(
			$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
			$this->POST['id']
			)) === TRUE) {
				echo json_encode(array(
				'status' => $this->Registry->languages->user_succesfully_marked_as_family
				));
				exit();
			}
		} else {
			echo json_encode(array(
			'status' => $this->Registry->languages->user_does_not_exist
			));
			exit();
		}
	}

	function unmarkBestFriend() {
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

		$this->modelUsers = new \models\ModelUsers();
		if($this->modelUsers->checkUserExists($this->POST['id']) == 1) {
			if($this->model->unmarkBestFriend(array(
			$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
			$this->POST['id']
			)) === TRUE) {
				echo json_encode(array(
				'status' => $this->Registry->languages->user_succesfully_unmarked_as_best_friend
				));
				exit();
			}
		} else {
			echo json_encode(array(
			'status' => $this->Registry->languages->user_does_not_exist
			));
			exit();
		}
	}
	function unmarkFamilyFriend() {
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

		$this->modelUsers = new \models\ModelUsers();
		if($this->modelUsers->checkUserExists($this->POST['id']) == 1) {
			if($this->model->unmarkFamily(array(
			$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
			$this->POST['id']
			)) === TRUE) {
				echo json_encode(array(
				'status' => $this->Registry->languages->user_succesfully_unmarked_as_family
				));
				exit();
			}
		} else {
			echo json_encode(array(
			'status' => $this->Registry->languages->user_does_not_exist
			));
			exit();
		}
	}

	function showMatches() {
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

		$this->usersModel = new \models\ModelUsers();
		$Limit = '0,' . $this->Registry->nr_items_to_display->logged_in_matches;
		$extra_fields = $this->usersModel->getUserExtraFields($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key);

		\classes\FormFieldManager::generateFormFields($extra_fields, 'register');

		$extra_fields_profile = $this->usersModel->getUserExtraFieldsProfile($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key);
		\classes\FormFieldManager::generateFormFields($extra_fields_profile, 'user_profile');

		$profile_fields = array_merge($extra_fields, $extra_fields_profile);

		$matches = $this->model->getMatches($profile_fields, $Limit);
		foreach($matches as $k => &$v) {
			$v->profile_pic = \classes\UserPictures::getProfilePicture($v->user_key, $this->Registry->user_pictures_settings->thumbnail_width, $this->Registry->user_pictures_settings->thumbnail_height);
		}
		$this->view->assign('matches', $matches);
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->display('user/matches/matches.tpl');
	}
	function showMusicFiles() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);

		$from = ! isset($this->GET["pag"]) ? 1 : $this->GET["pag"];
		$page = $from - 1;
		$limit_start = $page * $this->Registry->nr_items_to_display->music_page;

		$Limit = $limit_start . ',' . $this->Registry->nr_items_to_display->music_page;
		$music = $this->model->getLatestMusicFiles($Limit);
		foreach($music['results'] as $k => &$v) {
			$v->safe_seo_url = \helpers\Utils::safe_url($v->title);
		}
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->assign('music', $music['results']);
		$this->view->assign('pagination', \classes\Pagination::Generate($page, $this->Registry->nr_items_to_display->music_page, $music['nr_rows'], 'route=users_interaction&action=show_music_files', 'music_files'));
		if(! isset($this->GET["pag"])) {
			$this->view->display('pages/music/show_music.tpl');
		} else {
			$this->view->display('pages/music/music.tpl');
		}
	}
	function getLatestMusicFiles() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}
		$Limit = '0,' . $this->Registry->nr_items_to_display->music_page;
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->assign('music', $this->model->getLatestMusicFiles($Limit));
		$this->view->display('pages/music/music.tpl');
	}
	function getMusicFiles() {
		$this->GET = $this->Registry->GET;

		$this->view->assign('music', $this->model->getMusic(array(
		$_GET['music_id']
		)));
		$this->view->assign('music_comments', $this->model->getMusicFilesComments(array(
		$_GET['music_id']
		)));
		$this->view->assign('music_id', $_GET['music_id']);
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->display('pages/music/music_details.tpl');
	}
	function addMusicFilesComment() {
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

		$this->model->addMusicFilesComment(array(
		$this->POST['id'],
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
		$this->POST['comment'],
		time()
		));

		echo json_encode(array(
		'status' => 'added'
		));
	}
	function getMusicFilesComments() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}

		$this->view->assign('music_comments', $this->model->getMusicFilesComments(array(
		$this->POST['id']
		)));
		$this->view->assign('music_id', $this->POST['id']);
		$this->view->assign('request_hash', RequestHash::Generate());
		define('IGNORE_NO_AJAX', 'yes');
		$this->view->display('pages/music/comments.tpl');
	}
	function showVideos() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		$from = ! isset($this->GET["pag"]) ? 1 : $this->GET["pag"];
		$page = $from - 1;
		$limit_start = $page * $this->Registry->nr_items_to_display->video_page;

		$Limit = $limit_start . ',' . $this->Registry->nr_items_to_display->video_page;
		$videos = $this->model->getLatestVideo($Limit);
		foreach($videos['results'] as $k => &$v) {
			$v->thumb = \classes\UserVideo::getVideoThumb($v->user_key, $v->gallery_name, $v->file_name, $this->Registry->user_pictures_settings->thumbnail_width, $this->Registry->user_pictures_settings->thumbnail_height);
			$v->safe_seo_url = \helpers\Utils::safe_url($v->title);
		}

		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->assign('video', $videos['results']);
		$this->view->assign('pagination', \classes\Pagination::Generate($page, $this->Registry->nr_items_to_display->video_page, $videos['nr_rows'], 'route=users_interaction&action=show_videos', 'videos'));
		if(! isset($this->GET["pag"])) {
			$this->view->display('pages/video/show_video.tpl');
		} else {
			$this->view->display('pages/video/video.tpl');
		}
	}
	function getLatestVideo() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}
		$Limit = '0,' . $this->Registry->nr_items_to_display->video_page;
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->assign('video', $this->model->getLatestVideo($Limit));
		$this->view->display('pages/video/video.tpl');
	}
	function getVideo() {
		$this->GET = $this->Registry->GET;

		$this->view->assign('video', $this->model->getVideo(array(
		$_GET['video_id']
		)));
		$this->view->assign('video_comments', $this->model->getVideoComments(array(
		$_GET['video_id']
		)));
		$this->view->assign('video_id', $_GET['video_id']);
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->display('pages/video/video_details.tpl');
	}
	function addVideoComment() {
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

		$this->model->addVideoComment(array(
		$this->POST['id'],
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
		$this->POST['comment'],
		time()
		));

		echo json_encode(array(
		'status' => 'added'
		));
	}
	function getVideoComments() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}

		$this->view->assign('video_comments', $this->model->getVideoComments(array(
		$this->POST['id']
		)));
		$this->view->assign('video_id', $this->POST['id']);
		$this->view->assign('request_hash', RequestHash::Generate());
		define('IGNORE_NO_AJAX', 'yes');
		$this->view->display('pages/video/comments.tpl');
	}
	function musicDetails() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);

		$music = $this->model->getMusic(array(
		$this->GET['id']
		));
		//$music->file = \classes\UserMusic::getMusicFile($this->Registry->Settings->site_url, $music);
		$LimitSameUserPlaylist = '0,' . $this->Registry->nr_items_to_display->by_same_user_music_playlist;
		$LimitSameGalleryPlaylist = '0,' . $this->Registry->nr_items_to_display->in_same_gallery_music_playlist;
		$LimitRelatedMusicPlaylist = '0,' . $this->Registry->nr_items_to_display->related_music_playlist;

		$this->view->assign('music', $music);
		$this->view->assign('music_file', \classes\UserMusic::getMusicFile($this->Registry->Settings->site_url, $music));
		$this->view->assign('music_playlist', \classes\UserMusic::getMusicPlaylist($this->Registry->Settings->site_url, $music, $this->model->getSameUserMusicPlaylist(array(
		$music->user_key
		), $LimitSameUserPlaylist), $this->model->getSameGalleryMusicPlaylist(array(
		$music->user_key,
		$music->gallery_name
		), $LimitSameGalleryPlaylist), $this->model->getRelatedMusicPlaylist(array(
		$music->tags
		), $LimitRelatedMusicPlaylist)));
		$this->view->assign('request_hash', RequestHash::Generate());
		if(NO_AJAX == 'yes') {
			$this->view->assign('music_comments', $this->model->getMusicFilesComments(array(
			$music->id
			)));
			$this->view->assign('not_load_middle_default', true);
			$this->view->display('pages/music/music_no_ajax.tpl');
		} else {
			$this->view->display('pages/music/music_details.tpl');
		}
	}
	function musicDetailsInner() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);

		$music = $this->model->getMusic(array(
		$this->GET['id']
		));
		$music->file = \classes\UserMusic::getMusicFile($this->Registry->Settings->site_url, $music);

		$this->view->assign('music', $music);

		$this->view->assign('not_load_middle_default', true);
		$this->view->display('pages/music/music_inner.tpl');
	}
	function musicFilesComments() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);

		$Limit = '0,' . $this->Registry->nr_items_to_display->by_same_user_music_playlist;

		$this->view->assign('music_comments', $this->model->getMusicFilesComments(array(
		$this->GET['id']
		)));
		$this->view->assign('music_id', $this->GET['id']);
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->display('pages/music/music_comments.tpl');
	}
	function videoDetails() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);

		$video = $this->model->getVideo(array(
		$this->GET['id']
		));
		$LimitSameUserPlaylist = '0,' . $this->Registry->nr_items_to_display->by_same_user_video_playlist;
		$LimitSameGalleryPlaylist = '0,' . $this->Registry->nr_items_to_display->in_same_gallery_video_playlist;
		$LimitRelatedVideosPlaylist = '0,' . $this->Registry->nr_items_to_display->related_videos_playlist;
		$video->file = \classes\UserVideo::getVideoFile($this->Registry->Settings->site_url, $video);
		$this->view->assign('video', $video);
		$this->view->assign('video_playlist', \classes\UserVideo::getVideoPlaylist($this->Registry->Settings->site_url, $video, $this->model->getSameUserVideoPlaylist(array(
		$video->user_key
		), $LimitSameUserPlaylist), $this->model->getSameGalleryVideoPlaylist(array(
		$video->user_key,
		$video->gallery_name
		), $LimitSameGalleryPlaylist), $this->model->getRelatedVideosPlaylist(array(
		$video->tags
		), $LimitRelatedVideosPlaylist)));
		$this->view->assign('user_video_settings', $this->Registry->user_videos_settings);
		$this->view->assign('request_hash', RequestHash::Generate());

		if(NO_AJAX == 'yes') {
			$this->view->assign('video_comments', $this->model->getVideoComments(array(
			$video->id
			)));

			$this->view->assign('request_hash', RequestHash::Generate());
			$this->view->assign('not_load_middle_default', true);
			$this->view->display('pages/video/video_no_ajax.tpl');
		} else {
			$this->view->display('pages/video/video_details.tpl');
		}
	}
	function videoDetailsInner() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);

		$video = $this->model->getVideo(array(
		$this->GET['id']
		));

		$video->file = \classes\UserVideo::getVideoFile($this->Registry->Settings->site_url, $video);
		$this->view->assign('video', $video);

		$this->view->assign('user_video_settings', $this->Registry->user_videos_settings);
		$this->view->assign('request_hash', RequestHash::Generate());

		$this->view->assign('not_load_middle_default', true);
		$this->view->display('pages/video/video_inner.tpl');
	}
	function videoComments() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		if(RequestHash::validateHash($this->GET['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}

		$Limit = '0,' . $this->Registry->nr_items_to_display->by_same_user_music_playlist;

		$this->view->assign('video_comments', $this->model->getVideoComments(array(
		$this->GET['id']
		)));
		$this->view->assign('video_id', $this->GET['id']);
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->display('pages/video/video_comments.tpl');
	}
	function showExtraSections() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		$from = ! isset($this->GET["pag"]) ? 1 : $this->GET["pag"];
		$page = $from - 1;
		$limit_start = $page * $this->Registry->nr_items_to_display->extra_sections_page;

		$Limit = $limit_start . ',' . $this->Registry->nr_items_to_display->extra_sections_page;
		$extra_sections = $this->model->getLatestExtraSections($this->GET['type'], $Limit);
		foreach($extra_sections['results'] as $k => &$v) {
						$v->safe_seo_url = \helpers\Utils::safe_url($v->title);

		
			$v->title = \helpers\Utils::limit_text(strip_tags($v->title),100);
			$v->text = \helpers\Utils::limit_text(strip_tags($v->text),100);
		} 

		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->assign('type', $this->GET['type']);
		$this->view->assign('extra_sections', $extra_sections['results']);
		$this->view->assign('pagination', \classes\Pagination::Generate($page, $this->Registry->nr_items_to_display->extra_sections_page, $extra_sections['nr_rows'], 'route=users_interaction&action=show_extra_sections&type=' . $this->GET['type'], 'latest_extra_sections'));
		if(! isset($this->GET["pag"])) {
			$this->view->display('pages/extra_sections/show.tpl');
		} else {
			$this->view->display('pages/extra_sections/list.tpl');
		}
	}
	function extraSectionDetails() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);

		$extra_section = $this->model->getExtraSectionDetails($this->GET['type'], $this->GET['id']);
		$extra_section->text = strip_tags($extra_section->text);
		$this->view->assign('extra_section', $extra_section);
		// $this->view->assign('id', $this->GET['id']);
		$this->view->assign('type', $this->GET['type']);
		$this->view->assign('request_hash', RequestHash::Generate());

		if(NO_AJAX == 'yes') {
			$this->view->assign('extra_sections_comments', $this->model->getExtraSectionsComments($this->GET['type'], $extra_section->id));

			$this->view->assign('not_load_middle_default', true);
			$this->view->display('pages/extra_sections/details_no_ajax.tpl');
		} else {
			$this->view->display('pages/extra_sections/details.tpl');
		}
	}
	function getExtraSectionsAllComments() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		if(RequestHash::validateHash($this->GET['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}

		$comments = $this->model->getExtraSectionsComments($this->GET['type'], $this->GET['id']);
		foreach($comments as $k => &$v)
		{
			$v->edit = '';
			if(isset($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key))
			{
				if($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key == $v->user_key)
				{
					$v->edit = '<a onclick="edit_extra_section_comment(\''.$this->GET['type'].'\',\''.$v->id.'\',\''.$this->GET['id'].'\')">Edit</a>';
				}
			}
		}
		$this->view->assign('extra_sections_comments', $comments);
		$this->view->assign('id', $this->GET['id']);
		$this->view->assign('type', $this->GET['type']);
		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->display('pages/extra_sections/view_comments.tpl');
	}
	function addExtraSectionComment() {
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

		$this->model->addExtraSectionComment($this->POST['type'], array(
		$this->POST['id'],
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
		$this->POST['comment'],
		time()
		));

		echo json_encode(array(
		'status' => 'added'
		));
	}
	function getExtraSectionsComments() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		if(RequestHash::validateHash($this->GET['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}

		$comments = $this->model->getExtraSectionsComments($this->GET['type'], $this->GET['id']);
		foreach($comments as $k => &$v)
		{
			$v->edit = '';
			if(isset($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key))
			{
				if($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key == $v->user_key)
				{
					$v->edit = '<a onclick="edit_extra_section_comment(\''.$this->GET['type'].'\',\''.$v->id.'\',\''.$this->GET['id'].'\')">Edit</a>';
				}
			}
		}
		$this->view->assign('extra_sections_comments', $comments);
		$this->view->assign('id', $this->GET['id']);
		$this->view->assign('type', $this->GET['type']);
		$this->view->assign('request_hash', RequestHash::Generate());
		define('IGNORE_NO_AJAX', 'yes');
		$this->view->display('pages/extra_sections/comments.tpl');
	}


	function editExtraSectionComment() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo json_encode(array('status' => $this->Registry->languages->user_wrong_request));

			exit();
		}

		echo json_encode(array('comment' => $this->model->getExtraSectionsComment( $this->POST['type'], $this->POST['id'])->comment));
	}
	function editExtraSectionCommentText() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo json_encode(array('status' => $this->Registry->languages->user_wrong_request));

			exit();
		}

		$this->model->editExtraSectionCommentText($this->POST['type'],array($this->POST['comment'],$this->POST['id'],$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key));
		echo json_encode(array('status' => 'edited'));
	}


	function addExtraSectionsForm() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		$this->view->assign('type', $this->GET['type']);
		define('IGNORE_NO_AJAX', 'yes');
		$this->view->display('pages/extra_sections/add.tpl');
	}
	function addExtraSections() {
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

		$this->model->addExtraSections($this->POST['type'], array(
		$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
		$this->POST['extra_sections_title'],
		$this->POST['extra_sections_text'],
		time()
		));
		echo json_encode(array(
		'status' => 'added'
		));
		exit();
	}
	function getLatestExtraSections() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
			echo $this->Registry->languages->user_wrong_request;

			exit();
		}
		$from = ! isset($this->GET["pag"]) ? 1 : $this->GET["pag"];
		$page = $from - 1;
		$limit_start = $page * $this->Registry->nr_items_to_display->extra_sections_page;

		$Limit = $limit_start . ',' . $this->Registry->nr_items_to_display->extra_sections_page;
		$extra_sections = $this->model->getLatestExtraSections($this->POST['type'], $Limit);
		foreach($extra_sections['results'] as $k => &$v) {
			$v->text = \helpers\Utils::limit_text(strip_tags($v->text),200);
			$v->safe_seo_url = \helpers\Utils::safe_url($v->title);
		}

		$this->view->assign('request_hash', RequestHash::Generate());
		$this->view->assign('type', $this->POST['type']);
		$this->view->assign('extra_sections', $extra_sections['results']);
		$this->view->assign('pagination', \classes\Pagination::Generate($page, $this->Registry->nr_items_to_display->extra_sections_page, $extra_sections['nr_rows'], 'route=users_interaction&action=show_extra_sections&type=' . $this->POST['type'], 'latest_extra_sections'));

		define('IGNORE_NO_AJAX', 'yes');
		$this->view->display('pages/extra_sections/list.tpl');
	}
	function pictureDetails() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);

		$picture = $this->model->getPicture(array(
		$this->GET['id']
		));
$tags = explode(',',$picture->tags);
 foreach($tags as $k => $v)
 {
 	$tags_2 = '<span class="btn btn-danger">' . $v . '</span>'; 
 }
 $picture->tags = $tags_2;
		$this->view->assign('picture', $picture);
		$this->view->assign('thumb', \classes\UserPictures::getPicture($picture->user_key, $picture->file_name, md5($picture->gallery_name), $this->Registry->user_pictures_settings->large_image_width, $this->Registry->user_pictures_settings->large_image_height));
		$this->view->assign('request_hash', RequestHash::Generate());
		if(! isset($this->GET['n_a'])) {
			if(NO_AJAX == 'yes') {
				$this->view->assign('pictures_comments', $this->model->getPicturesComments(array(
				$picture->id
				)));
				$this->view->assign('not_load_middle_default', true);

				$this->view->display('pages/photos/picture_no_ajax.tpl');
			} else {
				if(isset($this->GET['n_a'])) {
					define('IGNORE_NO_AJAX', 'yes');
				}
				$this->view->display('pages/photos/picture_details.tpl');
			}
		} else {
			if(isset($this->GET['n_a'])) {
				define('IGNORE_NO_AJAX', 'yes');
			}
			$this->view->display('pages/photos/picture_details.tpl');
		}
	}
	function sendMessageForm() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		$this->view->assign('id', $this->GET['id']);
		define('IGNORE_NO_AJAX', 'yes');
		$this->view->display('user/send_message.tpl');
	}
	function askQuestionForm() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		$this->view->assign('id', $this->GET['id']);
		define('IGNORE_NO_AJAX', 'yes');
		$this->view->display('user/ask_question.tpl');
	}
}

?>