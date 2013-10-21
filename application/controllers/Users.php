<?php
namespace controllers;

	use models\ModelUsersContent;
	use lib\Core\Registry;
	use models\ModelIndex;
	use helpers\RequestHash;
	use lib\PasswordEncryption\PasswordEncryption;
	use lib\Core\Controller;

	class Users extends Controller {
		function __construct() {
			parent::__construct();
			$this->Registry = Registry::getInstance();
			(new \SplAutoloader('models', array(
					'models'
			)) )->register();

			$model = 'models\Model' . $this->Registry->controllerName;
			$this->model = new $model();
		}
		function registerForm() {
			for($i = 1950; $i < 2010; $i ++) {
				$this->year_dropdown[$i] = $i;
			}
			for($i = 1; $i <= 31; $i ++) {
				 $this->days_dropdown[$i] = ($i < 10) ?  '0' . $i : $i;
			}
			for($i = 1; $i <= 12; $i ++) {
				$this->months_dropdown[$i] = ($i < 10) ? '0' . $i : $i;
			}

			$this->view->assign('days_dropdown', $this->days_dropdown);
			$this->view->assign('months_dropdown', $this->months_dropdown);
			$this->view->assign('years_dropdown', $this->year_dropdown);
			$this->view->assign('form_validators_js', $this->Registry->form_validators_js);
			$this->view->assign('form_fields', $this->model->getFormFieldsRegister());
			$this->view->assign('request_hash', RequestHash::Generate());
			($this->Registry->Settings->show_countries_dropdown_on_register == 'yes' && ! isset($_SESSION['user_' . $_SERVER['SERVER_NAME']])) ? $this->view->assign('countries', (new \classes\Countries() )->getAllCountries()) : NULL;
			(! isset($_SESSION['user_' . $_SERVER['SERVER_NAME']])) ? $this->view->assign('user_country', (new \classes\Countries() )->getCountry()) : NULL;
			$this->view->display('home/boxes/register.tpl');
		}
		function Register() {
			if($_SERVER['REQUEST_METHOD'] === 'POST') {

				include HELPERS_DIR . 'form_filters.php';
				(new \SplAutoloader('lib\Form', array(
						'lib\Form'
				)) )->register();

				(new \SplAutoloader('lib\PasswordEncryption', array(
						'lib/PasswordEncryption'
				)) )->register();
				$this->POST = $this->Registry->POST;
				unset($this->Registry->POST);

				if(isset($this->POST['password2'])) {
					unset($this->POST['password2']);
				}

				(isset($this->POST['female'])) ? $gender = 'female' : $gender = 'male';
				unset($this->POST['male']);
				unset($this->POST['female']);
				$formFields = $this->model->getFormFieldsNoDefaultRegister();
				$formValidator = new \lib\Form\formValidator\FormValidator();
				$response = array();
				if(count($formFields) > 0) {
					$this->validation = $formValidator->setArrayToFilter($this->POST)->setArrayFilters($formValidator->createValidationArray($formFields))->validateArray();

					unset($formValidator);

					foreach($this->validation as $k => $v) {
						if($v === FALSE || $v === NULL) {
							$response[] = array(
									$k,
									false,
									$k . ' is not valid'
							);
						}
					}
					unset($this->validation);
					foreach($formFields as $k => $v) {
						$v->name = strtolower($v->name);
						if($v->validation_ajax == 'username_already_exists') {
							if($this->model->usernameExists($this->POST[$v->name]) > 0) {
								$response[] = array(
										$v->name,
										false,
										$v->name . ' already exists'
								);
							}
						} elseif($v->validation_ajax == 'email_already_exists') {
							if($this->model->emailExists($this->POST[$v->name]) > 0) {
								$response[] = array(
										$v->name,
										false,
										$v->name . ' already exists'
								);
							}
						}
					}
				}
				unset($formFields);
				if(count($response) > 0) {
					echo json_encode($response);
					exit();
				}
				$user_key = md5($this->POST['username'] . time() . $_SERVER['REMOTE_ADDR']);
				$password_encryption = (new PasswordEncryption() )->setPassword($this->POST['password'])->setEncryptMethod('crypt')->setEncryptionAlgorithm('CRYPT_BLOWFISH')->Encrypt();
				$this->POST['password'] = $password_encryption['password'];
				$main_fields = array_merge(array(
						'user_key' => $user_key
				), array_slice($this->POST, 0, 3), array(
						'salt' => $password_encryption['salt'],
						'country' => $this->POST['country'],
						'role' => 'free_user',
						'gender' => $gender,
						'featured' => 0,
						'birthday' => strtotime($this->POST['year'] . '-' . $this->POST['month'] . '-' . $this->POST['day']),
						'rating' => 0,
						'changing_status' => '',
						'online' => 0,
						'webcam' => 0,
						'webcam_session_id' => '',
						'registered_date' => date('Y-m-d')
				));
				unset($password_encryption);
				$extra_fields_2 = array();
				if(count($this->POST) > 5) {
					$extra_fields = array_slice($this->POST, 6, count($this->POST) - 3);
					$checkbox_values = '';
					$option_ar = array();
					foreach($extra_fields as $k => $v) {
						if(strpos($k, 'radio_') !== FALSE) {
							$extra_fields_2[$v] = next($extra_fields);
						} elseif(strpos($k, 'dropdown_') !== FALSE) {
							$extra_fields_2[$v] = next($extra_fields);
						} elseif(strpos($k, 'checkbox_') !== FALSE) {
							$field = $this->model->getUserExtraFieldById($v);
							$options_ar = explode('|', $field->options);
							foreach($options_ar as $k2 => $v2) {
								$option_ar = explode(':', $v2);
								if(isset($extra_fields[$option_ar[0]])) {
									$checkbox_values .= $option_ar[0] . '|';
								}
							}
							$extra_fields_2[$v] = $checkbox_values;
						} elseif(! in_array($v, $option_ar)) {
							$extra_fields_2[$this->model->getUserExtraField($k)] = $v;
						}
					}
				}
				// pr($extra_fields_2);
				(new \lib\RBAC\RBACAdministration() )->AddUser($main_fields, $extra_fields_2);
	$dirOperator =new \helpers\DirOperator() ;
				$dirOperator->create(USER_DATA_DIR . $user_key . DIRECTORY_SEPARATOR, 0777);
				$dirOperator->create(USER_DATA_DIR . $user_key . DIRECTORY_SEPARATOR . 'videos' . DIRECTORY_SEPARATOR, 0777);
				$dirOperator->create(USER_DATA_DIR . $user_key . DIRECTORY_SEPARATOR . 'videos' . DIRECTORY_SEPARATOR . md5('Default'), 0777);
				$dirOperator->create(USER_DATA_DIR . $user_key . DIRECTORY_SEPARATOR . 'photos' . DIRECTORY_SEPARATOR, 0777);
				$dirOperator->create(USER_DATA_DIR . $user_key . DIRECTORY_SEPARATOR . 'photos' . DIRECTORY_SEPARATOR . md5('Default'), 0777);
				$dirOperator->create(USER_DATA_DIR . $user_key . DIRECTORY_SEPARATOR . 'music' . DIRECTORY_SEPARATOR, 0777);
				$dirOperator->create(USER_DATA_DIR . $user_key . DIRECTORY_SEPARATOR . 'music' . DIRECTORY_SEPARATOR . md5('Default'), 0777);
				$this->modelUsersContent = new \models\ModelUsersContent() ;
				$this->modelUsersContent->addPicturesGallery(array(
						$user_key,
						'Default'
				));
				$this->modelUsersContent->addVideosGallery(array(
						$user_key,
						'Default'
				));
				$this->modelUsersContent->addMusicGallery(array(
						$user_key,
						'Default'
				));
				$this->modelUsersContent->addBlogCategory(array(
						$user_key,
						'Default'
				));
				unset($this->POST);
				unset($main_fields);
				unset($extra_fields);
				echo json_encode(array(
						'status' => true
				));
				exit();
			}
		}
		function RegisterCheckUsername() {
			if($_SERVER['REQUEST_METHOD'] === 'POST') {
				$this->POST = $this->Registry->POST;
				if($this->model->usernameExists($this->POST['fieldValue']) < 1) {
					echo json_encode(array(
							$this->POST['fieldId'],
							TRUE,
							'Username available'
					));
				} else {
					echo json_encode(array(
							$this->POST['fieldId'],
							FALSE,
							'Username is already taken'
					));
				}
			}
		}
		function RegisterCheckEmail() {
			if($_SERVER['REQUEST_METHOD'] === 'POST') {
				$this->POST = $this->Registry->POST;
				if($this->model->emailExists($this->POST['fieldValue']) < 1) {
					echo json_encode(array(
							$this->POST['fieldId'],
							TRUE,
							'Email available'
					));
				} else {
					echo json_encode(array(
							$this->POST['fieldId'],
							FALSE,
							'Email is already taken'
					));
				}
			}
		}
		function Login() {
			$this->POST = $this->Registry->POST;
			unset($this->Registry->POST);
			(new \SplAutoloader('lib\PasswordEncryption', array(
					'lib/PasswordEncryption'
			)) )->register();

			$nr_rows = $this->model->Login($this->POST['username_login'], (new PasswordEncryption() )->setPassword($this->POST['password_login'])->setSalt($this->model->getUserSalt($this->POST['username_login'])->salt)->setEncryptMethod('crypt')->setEncryptionAlgorithm('CRYPT_BLOWFISH')->Encrypt()['password']);

			if($nr_rows == 1) {

				$user = $this->model->getUserByUsername($this->POST['username_login']);
				$this->model->setUserOnline($this->POST['username_login']);
				unset($this->POST);
				(new \lib\RBAC\RBACSystem() )->CreateSession($user);
				echo json_encode(array(
						'status' => true
				));
			} else {
				echo json_encode(array(
						'status' => false
				));
			}
		}


		function Logout() {
			$this->model->setUserOffline($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key);
			(new \lib\RBAC\RBACSystem() )->DeleteSession();

			$this->indexModel = new ModelIndex();
			($this->Registry->Settings->enable_multiple_languages == 'yes') ? $this->view->assign('all_languages', $this->indexModel->getAllLanguages()) : array();
			for($i = 1950; $i < 2010; $i ++) {
				$this->year_dropdown[$i] = $i;
			}
			for($i = 1; $i <= 31; $i ++) {
				$this->days_dropdown[$i] = ($i < 10) ? '0' .$i : $i;
			}
			for($i = 1; $i <= 12; $i ++) {
				$this->months_dropdown[$i] = ($i < 10) ? '0' . $i : $i;
			}

			$this->view->assign('wn_theme', isset($this->Registry->COOKIE['jquery-ui-theme']) ? $this->Registry->COOKIE['jquery-ui-theme'] : $this->Registry->Settings->default_theme);
			$this->view->assign('days_dropdown', $this->days_dropdown);
			$this->view->assign('months_dropdown', $this->months_dropdown);
			$this->view->assign('years_dropdown', $this->year_dropdown);
			$this->view->assign('form_validators_js', $this->Registry->form_validators_js);
			$this->view->assign('languages', $this->Registry->languages);
			$this->view->assign('form_fields', $this->model->getFormFields());
			$this->view->assign('request_hash', RequestHash::Generate());
			$this->view->assign('themes', (new \classes\Themes\Themes() )->getThemesAr());
			($this->Registry->Settings->enable_multiple_languages == 'yes') ? $this->view->assign('all_languages', $this->indexModel->getAllLanguages()) : array();
			define('IGNORE_NO_AJAX', 'yes');
			$this->view->display('header_not_logged.tpl');
		}
		function Welcome() {
			$this->indexModel = new ModelIndex();
			$this->modelUsersInteraction = new \models\ModelUsersInteraction();
			$this->view->assign('wn_theme', isset($this->Registry->COOKIE['jquery-ui-theme']) ? $this->Registry->COOKIE['jquery-ui-theme'] : $this->Registry->Settings->default_theme);
			($this->Registry->Settings->enable_multiple_languages == 'yes') ? $this->view->assign('all_languages', $this->indexModel->getAllLanguages()) : array();
			$this->view->assign('unread_messages', count((array) $this->modelUsersInteraction->getUnreadMessages(array(
					$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
			))));
			$this->view->assign('nr_friend_requests', count((array) $this->modelUsersInteraction->getFriendsRequests(array(
					$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
			))));
			$this->view->assign('user', $_SESSION['user_' . $_SERVER['SERVER_NAME']]);
			$this->view->assign('themes', (new \classes\Themes\Themes() )->getThemesAr());
			$this->view->assign('languages', $this->Registry->languages);
			define('IGNORE_NO_AJAX', 'yes');
			$this->view->display('header_logged.tpl');
		}
		function getMyAccount() {
			$this->modelUsers = new \models\ModelUsers();
			$this->modelUsersInteraction = new \models\ModelUsersInteraction();

			$this->user_logged = (new \lib\RBAC\RBACSystem() )->CheckAccess();
			if($this->user_logged === TRUE) {
				$this->friends = array();

				$this->online_friends = $this->modelUsersInteraction->getOnlineFriends();
				foreach($this->online_friends as $k => $v) {
					if($v->friend_key == $_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key) {
						$v->friend_key = $v->user_key;
					}
					$this->friends[] = $this->modelUsers->getUserByUserKey($v->friend_key);
				}
				$this->view->assign('online_friends', $this->friends);
			}
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
			(! isset($_SESSION['user_' . $_SERVER['SERVER_NAME']])) ? $this->view->assign('user_country', (new \classes\Countries() )->getCountry()) : NULL;
			(! isset($_SESSION['user_' . $_SERVER['SERVER_NAME']])) ? $this->view->assign('user', '') : $this->view->assign('user', $this->modelUsers->getUserByUserKey($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key));
			$this->view->assign('user_logged', $this->user_logged);
			define('IGNORE_NO_AJAX', 'yes');
			$this->view->display('home/boxes/my_account.tpl');
		}
		function Profile() {
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
			$this->modelUserContent = new \models\ModelUsersContent();

			$extra_fields = $this->model->getUserExtraFields($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key);
			foreach($extra_fields as $k => &$v) {
				if($v->field_type == 'checkbox') {
					$v->value = substr(str_replace('|', ',', $v->value),0,-1);
				}
			}


			$this->view->assign('user', $_SESSION['user_' . $_SERVER['SERVER_NAME']]);

			$this->view->assign('user_pic', \classes\UserPictures::getProfilePicture($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key, $this->Registry->user_pictures_settings->thumbnail_width, $this->Registry->user_pictures_settings->thumbnail_height));
			$this->view->assign('age', \helpers\Utils::getAge(date('Y-m-d',$_SESSION['user_' . $_SERVER['SERVER_NAME']]->birthday)));
			$this->view->assign('extra_fields', $extra_fields);
			$this->view->assign('request_hash', RequestHash::Generate());

			$this->view->display('manage_profile/profile.tpl');
		}
		function saveUserStatus() {
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

			$this->model->saveUserStatus(array(
					$this->POST['status'],
					$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
			), array(
					$_SESSION['user_' . $_SERVER['SERVER_NAME']]->username,
					$this->POST['status']
			));
		}
		function editProfile() {
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

			$this->modelUserContent = new \models\ModelUsersContent();

			for($i = 1950; $i < 2010; $i ++) {
				$this->year_dropdown[$i] = $i;
			}
			for($i = 1; $i <= 31; $i ++) {
				$this->days_dropdown[$i] = ($i < 10) ? '0' . $i : $i;
			}
			for($i = 1; $i <= 12; $i ++) {
				$this->months_dropdown[$i] = ($i < 10) ? '0' . $i : $i;
			}
			$extra_fields = $this->model->getUserExtraFields($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key);
			\classes\FormFieldManager::generateFormFields($extra_fields, 'register');

		//	$extra_fields_profile = $this->model->getUserExtraFieldsProfile($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key);
			//\classes\FormFieldManager::generateFormFields($extra_fields_profile, 'user_profile');

			//$profile_fields = array_merge($extra_fields, $extra_fields_profile);
			$this->view->assign('days_dropdown', $this->days_dropdown);
			$this->view->assign('months_dropdown', $this->months_dropdown);
			$this->view->assign('years_dropdown', $this->year_dropdown);
			$this->view->assign('user', $_SESSION['user_' . $_SERVER['SERVER_NAME']]);
			$this->view->assign('extra_fields', $extra_fields);
			$this->view->assign('birthday',explode('-',date('Y-m-d',$_SESSION['user_' . $_SERVER['SERVER_NAME']]->birthday)));
			$this->view->assign('form_validators_js',$this->Registry->form_validators_js);
			$this->view->assign('request_hash', RequestHash::Generate());
			define('IGNORE_NO_AJAX', 'yes');
			$this->view->display('manage_profile/edit_profile.tpl');
		}
		function saveEditProfile() {
			if($_SERVER['REQUEST_METHOD'] === 'POST') {

				include HELPERS_DIR . 'form_filters.php';
				(new \SplAutoloader('lib\Form', array(
						'lib\Form'
				)) )->register();


				(new \SplAutoloader('lib\PasswordEncryption', array(
						'lib/PasswordEncryption'
				)) )->register();
				$this->POST = $this->Registry->POST;
				unset($this->Registry->POST);

				if(isset($this->POST['password2'])) {
					unset($this->POST['password2']);
				}
				// $this->POST['password'] = $this->POST['register_password'];
				// pr($this->POST);
				$formFields = $this->model->getFormFieldsEditProfile();
				// pr($formFields);
				$formValidator = new \lib\Form\formValidator\FormValidator();

				$this->validation = $formValidator->setArrayToFilter($this->POST)->setArrayFilters($formValidator->createValidationArray($formFields))->validateArray();
				unset($formValidator);
				$response = array();
				foreach($this->validation as $k => $v) {
					if($v === FALSE || $v === NULL) {
						$response[] = array(
								$k,
								false,
								$k . ' is not valid'
						);
					}
				}
				unset($this->validation);

				unset($formFields);
				if(count($response) > 0) {
					echo json_encode($response);
					exit();
				}
				$password_encryption = array();
				if($this->POST['password'] != 'as23xjshA') {

					$password_encryption = (new PasswordEncryption() )->setPassword($this->POST['password'])->setEncryptMethod('crypt')->setEncryptionAlgorithm('CRYPT_BLOWFISH')->Encrypt();
				}
				unset($this->POST['password']);
				unset($this->POST['password2']);

				$extra_fields = \classes\FormFieldManager::prepareFieldsForUpdate($this->POST);
				// pr($extra_fields);
				// pr($extra_fields_2);
				(new \lib\RBAC\RBACAdministration() )->EditUser($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key, $password_encryption,strtotime($this->POST['year'] . '-' . $this->POST['month'] . '-' . $this->POST['day']), $extra_fields);

				unset($this->POST);
				unset($main_fields);
				unset($extra_fields);
				echo json_encode(array(
						'response' => true,
						'status' => 'Profile updated'
				));
				exit();
			}
		}
		function viewProfile() {
			if($this->Registry->Settings->only_logged_in_users_can_view_profile_info == 'yes') {
				if((new \lib\RBAC\RBACSystem() )->CheckAccess() === FALSE) {
					echo $this->Registry->languages->user_not_logged;

					exit();
				}
			}

			$this->GET = $this->Registry->GET;
			unset($this->Registry->GET);

			$this->modelUserContent = new \models\ModelUsersContent();
			$this->ModelUsersInteraction = new \models\ModelUsersInteraction();
			if(isset($this->GET['username'])) {
				$user = $this->model->getUserByUsername($this->GET['username']);
			} else {
				$user = $this->model->getUserByUserKey($this->GET['id']);
			}

			$latestPicturesLimit = $Limit = '0,' . $this->Registry->nr_items_to_display->latest_pictures_profile_page;
			$latestGroupsLimit = $Limit = '0,' . $this->Registry->nr_items_to_display->latest_groups_profile_page;
			$latestBlogsLimit = $Limit = '0,' . $this->Registry->nr_items_to_display->latest_blogs_profile_page;
			$latestEventsLimit = $Limit = '0,' . $this->Registry->nr_items_to_display->latest_events_profile_page;

			$extra_fields = $this->model->getUserExtraFields($user->user_key);
			foreach($extra_fields as $k => &$v) {
				if($v->field_type == 'checkbox') {
					$v->value = substr(str_replace('|', ',', $v->value),0,-1);
				}
			}
			unset($k);
			unset($v);
			$pictures = $this->model->getUserLatestPictures($user->user_key, $latestPicturesLimit);
			$pictures_2 = array();
			$i = 0;
			foreach($pictures as $k => $v) {
				$pictures_2[$i]['image'] = \classes\UserPictures::getPicture($user->user_key, $v->file_name, md5($v->gallery_name), $this->Registry->user_pictures_settings->thumbnail_width, $this->Registry->user_pictures_settings->thumbnail_height);
				$pictures_2[$i]['id'] = $v->id;
				$pictures_2[$i]['pic_name'] = $v->file_name;
				$pictures_2[$i]['gallery_id'] = $v->gallery_id;
				$pictures_2[$i]['gallery_name'] = md5($v->gallery_name);
				$pictures_2[$i]['user_key'] = $user->user_key;
				$i ++;
			}

			$subscribers = $this->ModelUsersInteraction->getPicturesSubscribers(array(
					$user->user_key
			));
			$pictures_subscribers = array();
			$i = 0;
			foreach($subscribers as $k => $v) {
				$pictures_subscribers[$i]['user'] = $this->model->getUserByUserKey($v->from_key)->username;
				$i ++;
			}

			$subscribers = $this->ModelUsersInteraction->getGroupSubscribers(array(
					$user->user_key
			));
			$group_subscribers = array();
			$i = 0;
			foreach($subscribers as $k => $v) {
				$group_subscribers[$i]['user'] = $this->model->getUserByUserKey($v->from_key)->username;
				$i ++;
			}

			$subscribers = $this->ModelUsersInteraction->getBlogSubscribers(array(
					$user->user_key
			));
			$blog_subscribers = array();
			$i = 0;
			foreach($subscribers as $k => $v) {
				$blog_subscribers[$i]['user'] = $this->model->getUserByUserKey($v->from_key)->username;
				$i ++;
			}

			$subscribers = $this->ModelUsersInteraction->getEventsSubscribers(array(
					$user->user_key
			));
			$events_subscribers = array();
			$i = 0;
			foreach($events_subscribers as $k => $v) {
				$events_subscribers[$i]['user'] = $this->model->getUserByUserKey($v->from_key)->username;
				$i ++;
			}
			$groups = $this->model->getUserLatestGroups($user->user_key, $latestGroupsLimit);
			foreach($groups as $k => &$v)
			{
							$v->safe_seo_url = \helpers\Utils::safe_url($v->group_name);
			}
			unset($k);
			unset($v);
			$blogs = $this->model->getUserLatestBlogs($user->user_key, $latestBlogsLimit);
			foreach($blogs as $k => &$v)
			{
							$v->title = \helpers\Utils::limit_text($v->title,50);
			}
			$this->view->assign('age', \helpers\Utils::getAge(date('Y-m-d',$_SESSION['user_' . $_SERVER['SERVER_NAME']]->birthday)));
			$this->view->assign('groups_profile',$groups );
			$this->view->assign('group_subscribers', $group_subscribers);
			$this->view->assign('blog_subscribers', $blog_subscribers);
			$this->view->assign('blogs_profile', $blogs); 
			$this->view->assign('events_subscribers', $events_subscribers);
			$this->view->assign('events_profile', $this->model->getUserLatestEvents($user->user_key, $latestEventsLimit));
			$this->view->assign('pictures_subscribers', $pictures_subscribers);
			$this->view->assign('pictures_profile', $pictures_2);
			$this->view->assign('user_profile', $user);
			$this->view->assign('user_pic', \classes\UserPictures::getProfilePicture($user->user_key, $this->Registry->user_pictures_settings->thumbnail_width, $this->Registry->user_pictures_settings->thumbnail_height));
			$this->view->assign('extra_fields', $extra_fields);
			$this->view->assign('request_hash', RequestHash::Generate());
			$this->view->display('user/profile/profile.tpl');
		}
		function showPeopleByCountry() {
			$this->GET = $this->Registry->GET;
			unset($this->Registry->GET);

			$countries = (new \classes\Countries() )->getAllCountries();
			foreach($countries as $k => &$v) {
				$v->users = $this->model->getUsersNrByCountry($v->iso_code_2);
				$v->safe_seo_url = \helpers\Utils::safe_url($v->iso_country);
			}
			$this->view->assign('countries', $countries);
			$this->view->display('pages/users/countries.tpl');
		}
		function peopleByCountry() {
			$this->GET = $this->Registry->GET;
			unset($this->Registry->GET);

			$from = ! isset($this->GET["pag"]) ? 1 : $this->GET["pag"];
			$page = $from - 1;
			$limit_start = $page * $this->Registry->nr_items_to_display->peoples_by_country;

			$country = (new \classes\Countries() )->getCountryNameByCode($this->GET['country']);
			$peopleByCountryLimit = $limit_start . ',' . $this->Registry->nr_items_to_display->peoples_by_country;
			$users = $this->model->getUsersByCountry($country->iso_code_2, $peopleByCountryLimit);
			foreach($users['results'] as $k => &$v) {
				$v->profile_pic = \classes\UserPictures::getProfilePicture($v->user_key, $this->Registry->user_pictures_settings->thumbnail_width, $this->Registry->user_pictures_settings->thumbnail_height);
			}
			$this->view->assign('country_name', $country);
			$this->view->assign('users', $users['results']);
			$this->view->assign('pagination', \classes\Pagination::Generate($page, $this->Registry->nr_items_to_display->peoples_by_country, $users['nr_rows'], 'route=users&action=people_by_country&country=' . $this->GET['country'], 'people_by_country'));
			if(! isset($this->GET["pag"])) {
				$this->view->display('pages/users/people_by_country.tpl');
			} else {
				define('IGNORE_NO_AJAX', 'yes');
				$this->view->display('pages/users/users_inner.tpl');
			}
		}
		function showOnlinePeople() {
			$this->GET = $this->Registry->GET;
			unset($this->Registry->GET);

			$from = ! isset($this->GET["pag"]) ? 1 : $this->GET["pag"];
			$page = $from - 1;
			$limit_start = $page * $this->Registry->nr_items_to_display->online_people_page;

			$onlinePeopleLimit = $limit_start . ',' . $this->Registry->nr_items_to_display->online_people_page;
			$online = $this->model->getOnlineUsers($onlinePeopleLimit);
			foreach($online['results'] as $k => &$v) {
				$v->profile_pic = \classes\UserPictures::getProfilePicture($v->user_key, $this->Registry->user_pictures_settings->thumbnail_width, $this->Registry->user_pictures_settings->thumbnail_height);
			}
			$this->view->assign('users', $online['results']);
			$this->view->assign('pagination', \classes\Pagination::Generate($page, $this->Registry->nr_items_to_display->peoples_by_country, $online['nr_rows'], 'route=users&action=show_online_people', 'online_people'));
			if(! isset($this->GET["pag"])) {
				$this->view->display('pages/users/online_users.tpl');
			} else {
				define('IGNORE_NO_AJAX', 'yes');
				$this->view->display('pages/users/users_inner.tpl');
			}
		}
		function showTopRatedPeople() {
			$this->GET = $this->Registry->GET;
			unset($this->Registry->GET);
			$from = ! isset($this->GET["pag"]) ? 1 : $this->GET["pag"];
			$page = $from - 1;
			$limit_start = $page * $this->Registry->nr_items_to_display->online_people_page;

			$topRatedPeopleLimit = $limit_start . ',' . $this->Registry->nr_items_to_display->top_rated_people_page;
			$top_rated_people = $this->model->getTopRatedUsers($topRatedPeopleLimit);
			foreach($top_rated_people['results'] as $k => &$v) {
				$v->profile_pic = \classes\UserPictures::getProfilePicture($v->user_key, $this->Registry->user_pictures_settings->thumbnail_width, $this->Registry->user_pictures_settings->thumbnail_height);
			}
			$this->view->assign('users', $top_rated_people['results']);
			$this->view->assign('pagination', \classes\Pagination::Generate($page, $this->Registry->nr_items_to_display->top_rated_people_page, $top_rated_people['nr_rows'], 'route=users&action=show_top_rated_people', 'top_rated_people'));

			if(! isset($this->GET["pag"])) {
				$this->view->display('pages/users/top_rated_people.tpl');
			} else {
				define('IGNORE_NO_AJAX', 'yes');
				$this->view->display('pages/users/users_inner.tpl');
			}
		}
		function showAllUsers() {
			$this->GET = $this->Registry->GET;
			unset($this->Registry->GET);
			$from = ! isset($this->GET["pag"]) ? 1 : $this->GET["pag"];
			$page = $from - 1;
			$limit_start = $page * $this->Registry->nr_items_to_display->all_users_page;
			$allUsersLimit = $limit_start . ',' . $this->Registry->nr_items_to_display->all_users_page;
			$all_users = $this->model->getAllUsers($allUsersLimit);
			foreach($all_users['results'] as $k => &$v) {
				$v->profile_pic = \classes\UserPictures::getProfilePicture($v->user_key, $this->Registry->user_pictures_settings->thumbnail_width, $this->Registry->user_pictures_settings->thumbnail_height);
			}
			$this->view->assign('users', $all_users['results']);
			$this->view->assign('pagination', \classes\Pagination::Generate($page, $this->Registry->nr_items_to_display->all_users_page, $all_users['nr_rows'], 'route=users&action=show_all_users', 'all_users'));
			if(! isset($this->GET["pag"])) {
				$this->view->display('pages/users/all_users.tpl');
			} else {
				define('IGNORE_NO_AJAX', 'yes');
				$this->view->display('pages/users/users_inner.tpl');
			}
		}
		function showTrade() {
			$this->GET = $this->Registry->GET;
			unset($this->Registry->GET);

			$from = ! isset($this->GET["pag"]) ? 1 : $this->GET["pag"];
			$page = $from - 1;
			$limit_start = $page * $this->Registry->nr_items_to_display->trade_page;

			$Limit = $limit_start . ',' . $this->Registry->nr_items_to_display->trade_page;
			$trade = $this->model->getTrades($Limit);
			$this->view->assign('request_hash', RequestHash::Generate());
			$this->view->assign('trade', $trade['results']);
			$this->view->assign('pagination', \classes\Pagination::Generate($page, $this->Registry->nr_items_to_display->trade_page, $trade['nr_rows'], 'route=users&action=show_trade', 'trade'));
			if(! isset($this->GET["pag"])) {
				$this->view->display('pages/trade/show_trade.tpl');
			} else {
				define('IGNORE_NO_AJAX', 'yes');
				$this->view->display('pages/trade/trade.tpl');
			}
		}
		function addTradeForm() {
			define('IGNORE_NO_AJAX', 'yes');
			$this->view->display('pages/trade/add_trade.tpl');
		}
		function addTrade() {
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

			$this->model->addTrade(array(
					$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
					$this->POST['trade_title'],
					$this->POST['trade_text'],
					time()
			));
			echo json_encode(array(
					'status' => 'added'
			));
			exit();
		}
		function getLatestTrade() {
			$this->POST = $this->Registry->POST;
			unset($this->Registry->POST);
			if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
				echo $this->Registry->languages->user_wrong_request;

				exit();
			}
			$Limit = '0,' . $this->Registry->nr_items_to_display->trade_page;
			$this->view->assign('trade', $this->model->getTrades($Limit)['results']);
			define('IGNORE_NO_AJAX', 'yes');
			$this->view->display('pages/trade/trade.tpl');
		}
		function getTrade() {
			$this->GET = $this->Registry->GET;

			$trade = $this->model->getTrade(array(
					$this->GET['trade_id']
			));

			$this->view->assign('trade', $trade);
			$this->view->assign('request_hash', RequestHash::Generate());
			if(NO_AJAX == 'yes') {
				$this->view->assign('trade_questions', $this->model->getTradeQuestions(array(
						$trade->id
				)));

				$this->view->assign('request_hash', RequestHash::Generate());
				$this->view->assign('not_load_middle_default', true);
				$this->view->display('pages/trade/trade_no_ajax.tpl');
			} else {
				$this->view->display('pages/trade/trade_details.tpl');
			}
		}
		function addTradeQuestion() {
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

			$this->model->addTradeQuestion(array(
					$this->POST['id'],
					$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key,
					$this->POST['question'],
					time()
			));

			echo json_encode(array(
					'status' => 'added'
			));
		}
		function getAllTradeQuestions() {
			$this->POST = $this->Registry->POST;
			unset($this->Registry->POST);
			if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
				echo $this->Registry->languages->user_wrong_request;

				exit();
			}

			$this->view->assign('trade_questions', $this->model->getTradeQuestions(array(
					$this->POST['id']
			)));
			$this->view->assign('trade_id', $this->POST['id']);
			$this->view->assign('request_hash', RequestHash::Generate());
			$this->view->display('pages/trade/trade_questions.tpl');
		}
		function getTradeQuestions() {
			$this->POST = $this->Registry->POST;
			unset($this->Registry->POST);
			if(RequestHash::validateHash($this->POST['rh']) === FALSE) {
				echo $this->Registry->languages->user_wrong_request;

				exit();
			}

			$this->view->assign('trade_questions', $this->model->getTradeQuestions(array(
					$this->POST['id']
			)));
			$this->view->assign('trade_id', $this->POST['id']);
			$this->view->assign('request_hash', RequestHash::Generate());
			define('IGNORE_NO_AJAX', 'yes');
			$this->view->display('pages/trade/questions.tpl');
		}
		function showStatuses() {
			$this->GET = $this->Registry->GET;
			unset($this->Registry->GET);

			$this->view->assign('statuses', $this->model->getStatuses());
			$this->view->assign('request_hash', RequestHash::Generate());
			$this->view->display('pages/statuses/statuses.tpl');
		}
		function showSearch() {
			$this->view->assign('countries', (new \classes\Countries() )->getAllCountries());
			$this->view->assign('user_country', (new \classes\Countries() )->getCountry());
			$this->view->assign('request_hash', RequestHash::Generate());
			$this->view->display('pages/search/search.tpl');
		}
		function Search() {
			$this->GET = $this->Registry->GET;
			unset($this->Registry->GET);

			$Limit = '0,' . $this->Registry->nr_items_to_display->search_results;
			$Where = '';
			$where_next = ' WHERE ';
			if(trim($this->GET['username']) != '') {
				$Where .= $where_next . $this->Registry->table_prefix . '_users.username LIKE "%' . $this->GET['username'] . '%"';
				$where_next = ' AND ';
			}
			if(isset($this->GET['featured']) && $this->GET['featured'] == 1) {
				$Where .= $where_next . $this->Registry->table_prefix . '_users.featured="1"';
			}
			if(isset($this->GET['online']) && $this->GET['online'] == 1) {
				$Where .= $where_next . $this->Registry->table_prefix . '_users.online="1"';
			}
			if(! (isset($this->GET['male']) && $this->GET['male'] == 'checked') || ! (isset($this->GET['female']) && $this->GET['female'] == 'checked')) {
				if(isset($this->GET['male']) && $this->GET['male'] == 'checked') {
					$Where .= $where_next . $this->Registry->table_prefix . '_users.gender="male"';
				}
				if(isset($this->GET['female']) && $this->GET['female'] == 'checked') {
					$Where .= $where_next . $this->Registry->table_prefix . '_users.gender="female"';
				}
			}
			if(isset($this->GET['country']) && $this->GET['country'] != 1) {
				$Where .= $where_next . $this->Registry->table_prefix . '_users.country= "' . mysql_real_escape_string($this->GET['country']) . '"';
			}
			// trim($this->GET['online_with_picture']) == '1' ? $Where .=

			switch ($this->GET['order_by']) {
				case 'username_asc' :
					$OrderBy = 'ORDER BY ' . $this->Registry->table_prefix . '_users.username ASC';
					break;
				case 'username_desc' :
					$OrderBy = 'ORDER BY ' . $this->Registry->table_prefix . '_users.username DESC';
					break;
				case 'registered_date_asc' :
					$OrderBy = 'ORDER BY ' . $this->Registry->table_prefix . '_users.id ASC';
					break;
				case 'registered_date_desc' :
					$OrderBy = 'ORDER BY ' . $this->Registry->table_prefix . '_users.id DESC';
					break;
				case 'rating_desc' :
					$OrderBy = 'ORDER BY ' . $this->Registry->table_prefix . '_users.rating DESC';
					break;
			}
			$search = $this->model->Search($Where, $OrderBy, $Limit)['results'];
			foreach($search as $k => &$v) {
				$v->profile_pic = \classes\UserPictures::getProfilePicture($v->user_key, $this->Registry->user_pictures_settings->thumbnail_width, $this->Registry->user_pictures_settings->thumbnail_height);
			}
			$this->view->assign('users', $search);
			$this->view->assign('request_hash', RequestHash::Generate());
			$this->view->display('pages/search/search_results.tpl');
		}
		function startWebcam() {
			include LIBS_DIR . 'OpenTok/OpenTokSDK.php';
			// Creating an OpenTok Object in Staging
			$apiObj = new \OpenTokSDK($this->Registry->Settings->opentok_api_key, $this->Registry->Settings->opentok_secret);
			// Creating an OpenTok Object in Production
			// $apiObj = new OpenTokSDK('11421872',
			// '296cebc2fc4104cd348016667ffa2a3909ec636f', TRUE);
			// Creating Simple Session object, passing IP address to determine
			// closest production server
			// Passing IP address to determine closest production server
			$session = $apiObj->createSession($_SERVER["REMOTE_ADDR"]);
			// Creating Simple Session object
			// Enable p2p connections
			// $session = $apiObj->createSession( $_SERVER["REMOTE_ADDR"],
			// array(SessionPropertyConstants::P2P_PREFERENCE=> "enabled") );
			// Getting sessionId from Sessions
			// Option 1: Call getSessionId()
			$sessionId = $session->getSessionId();
			// $token = $apiObj->generateToken($sessionId);
			$this->view->assign('sessionId', $sessionId);
			$this->model->startWebcam(array(
					$sessionId,
					$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
			));
			$this->view->assign('token', $apiObj->generateToken($sessionId, "publisher", null, "publisher"));
			$this->view->display('user/webcam/webcam.tpl');
		}
		function connectToWebcam() {
			$this->GET = $this->Registry->GET;
			unset($this->Registry->GET);

			include LIBS_DIR . 'OpenTok/OpenTokSDK.php';
			// Creating an OpenTok Object in Staging
			$apiObj = new \OpenTokSDK($this->Registry->Settings->opentok_api_key, $this->Registry->Settings->opentok_secret);
			// Creating an OpenTok Object in Production
			// $apiObj = new OpenTokSDK('11421872',
			// '296cebc2fc4104cd348016667ffa2a3909ec636f', TRUE);
			// Creating Simple Session object, passing IP address to determine
			// closest production server
			// Passing IP address to determine closest production server
			// $session = $apiObj->createSession( $_SERVER["REMOTE_ADDR"] );
			// Creating Simple Session object
			// Enable p2p connections
			// $session = $apiObj->createSession( $_SERVER["REMOTE_ADDR"],
			// array(SessionPropertyConstants::P2P_PREFERENCE=> "enabled") );
			// Getting sessionId from Sessions
			// Option 1: Call getSessionId()
			// $sessionId = $session->getSessionId();
			$sessionId = $this->GET['id'];
			// $token = $apiObj->generateToken($sessionId);
			$this->view->assign('sessionId', $sessionId);
			$this->view->assign('moderator', 1);
			$this->view->assign('token', $apiObj->generateToken($sessionId, "moderator", null, "moderator"));
			$this->view->display('user/webcam/webcam.tpl');
		}
		function disconnectWebcam() {
			$this->model->disconnectWebcam(array(
					$_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key
			));
		}
		function getWebcamId() {
			echo json_encode(array(
					'webcam_id' => $this->model->getUserByUserKey($_SESSION['user_' . $_SERVER['SERVER_NAME']]->user_key)->webcam_session_id
			));
		}
	}

	?>