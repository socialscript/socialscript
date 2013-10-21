<?php

namespace controllers;

use lib\Form\FormValidator;
use lib\Core\Controller as Controller;
use lib\Core\Registry;
use lib\JQGrid\JQGrid;
use helpers\RequestHash;
use lib\PasswordEncryption\PasswordEncryption;

class AdminIndex extends Controller {
	function __construct() {
		parent::__construct();

		$this->Registry = Registry::getInstance();

		(new \SplAutoloader('models', array(
				'models'
		)) )->register();
		$model = 'models\Model' . $this->Registry->controllerName;
		$this->model = new $model();
	}
	function Index() {
		$this->view->assign('r_h', RequestHash::Generate());
		$this->view->assign('wn_theme', isset($this->Registry->COOKIE['jquery-ui-theme-admin']) ? $this->Registry->COOKIE['jquery-ui-theme-admin'] : $this->Registry->default_admin_theme);
		$this->view->display('index.tpl');
	}
	function IndexInner() {
		$this->view->assign('r_h', RequestHash::Generate());
		$this->view->assign('wn_theme', isset($this->Registry->COOKIE['jquery-ui-theme-admin']) ? $this->Registry->COOKIE['jquery-ui-theme-admin'] : $this->Registry->default_admin_theme);
		$this->view->display('login.tpl');
	}
	function Home() {
		$this->view->assign('wn_theme', isset($this->Registry->COOKIE['jquery-ui-theme-admin']) ? $this->Registry->COOKIE['jquery-ui-theme-admin'] : $this->Registry->default_admin_theme);
		$this->view->assign('themes', (new \classes\Themes\Themes() )->getThemesAr());
		$this->view->assign('resolution', $this->Registry->resolution);
		$this->view->assign('nr_users', $this->model->getTotalNrUsers());
		$this->view->assign('nr_users_females', $this->model->getTotalNrUsersFemales());
		$this->view->assign('nr_users_males', $this->model->getTotalNrUsersMales());
		$this->view->assign('nr_videos', $this->model->getTotalNrVideos());
		$this->view->assign('nr_music', $this->model->getTotalNrMusic());
		$this->view->assign('nr_pictures', $this->model->getTotalNrPictures());
		$this->view->assign('nr_blogs', $this->model->getTotalNrPictures());
		$this->view->assign('nr_events', $this->model->getTotalNrEvents());
		$this->view->assign('nr_groups', $this->model->getTotalNrGroups());
		$this->view->display('home.tpl');
	}
	function Login() {
		if($_SERVER['REQUEST_METHOD'] === 'POST') {
			(new \SplAutoloader('lib\PasswordEncryption', array(
					'lib/PasswordEncryption'
			)) )->register();

			$this->POST = $this->Registry->POST;
			unset($this->Registry->POST);
			if(RequestHash::validateHash($this->POST['r_h']) === FALSE) {
				echo json_encode(array(
						'status' => $this->Registry->languages->user_wrong_request
				));
				exit();
			}
			$nr_rows = $this->model->Login($this->POST['username'], (new PasswordEncryption() )->setPassword($this->POST['password'])->setSalt((new \models\ModelUsers() )->getUserSalt($this->POST['username'])->salt)->setEncryptMethod('crypt')->setEncryptionAlgorithm('CRYPT_BLOWFISH')->Encrypt()['password']);
			if($nr_rows == 1) {

				$user = $this->model->getUserByUsername($this->POST['username']);
				(new \models\ModelUsers() )->setUserOnline($this->POST['username']);
				unset($this->POST);
				(new \lib\RBAC\RBACSystem() )->CreateSession($user[0]);
				echo json_encode(array(
						'status' => true
				));
			} else {
				echo json_encode(array(
						'status' => false
				));
			}
			exit();
		} else {

			echo json_encode(array(
					'status' => false
			));
		}
	}
	function analyticsLatest() {
		(new \SplAutoloader('lib\Gapi', array(
				'lib/Gapi'
		)) )->register();
		$ga = new \lib\Gapi\Gapi($this->Registry->google_analytics['email'], $this->Registry->google_analytics['password']);
		$ga->requestReportData($this->Registry->google_analytics['profile_id'], array(
				'visitCount',
				'source',
				'keyword',
				'browser',
				'operatingSystem',
				'country',
				'city'
		), array(
				'newVisits',
				'exitRate',
				'avgTimeOnPage'
		));
		$this->view->assign('results', $ga->getResults());
		$this->view->display('analytics_latest.tpl');
	}
	function Logout() {
		(new \lib\RBAC\RBACSystem() )->DeleteSession();
	}
	function analytics2() {
		(new \SplAutoloader('lib\Gapi', array(
				'lib/Gapi'
		)) )->register();
		$ga = new \lib\Gapi\Gapi($this->Registry->google_analytics['email'], $this->Registry->google_analytics['password']);
		$ga->requestReportData($this->Registry->google_analytics['profile_id'], array(
				'date'
		), array(
				'pageviews'
		), 'date');

		$results = $ga->getResults();
		foreach($results as $k => $v) {
			$v->date = date('M j', strtotime($v->getDate()));
		}
		$this->view->assign('results', $results);
		$this->view->assign('last_month', date('M j, Y', strtotime('-30 day')) . ' - ' . date('M j, Y'));
		$this->view->assign('resolution', $this->Registry->resolution);
		$this->view->display('analytics_2.tpl');
	}
	function Contact() {
		if($_SERVER['REQUEST_METHOD'] === 'POST') {

			$this->POST = $this->Registry->POST;
			unset($this->Registry->POST);
			if(RequestHash::validateHash($this->POST['r_h']) === FALSE) {
				echo json_encode(array(
						'status' => $this->Registry->languages->user_wrong_request
				));
				exit();
			}

			if(@mail('contact@widgetic.co.uk', 'Message from ' . $_SERVER['SERVER_NAME'] . ' ' . $_SERVER['SERVER_ADDR'], $this->POST['message'], "MIME-Version: 1.0\r\n" . "Content-type: text/html; charset=iso-8859-1\r\n" . "From: " . $this->POST['email'] . "<" . $this->POST['email'] . ">\r\n" . "X-Mailer: PHP/" . phpversion())) {
				echo json_encode(array(
						'status' => true
				));
			} else {
				echo json_encode(array(
						'status' => false
				));
			}
		}
	}
	function serverInfo() {
		$this->view->display('server_info.tpl');
	}
	function phpInf() {
		echo '<div style="width:100%;height:100%;overflow:auto;">';
		phpinfo();
		echo '</div>';
	}
	function Admins() {
		(new \SplAutoloader('lib\JQGrid', array(
				'lib\JQGrid'
		)) )->register();

		$JQGrid = new JQGrid();

		$JQGrid->setAntets("var lastsel;");
		$JQGrid->setElementId("admins");
		// $JQGrid->setUrl("index_admin.php?route=settings");
		$JQGrid->setEditUrl("index_admin.php?route=index&action=edit_admins");
		$JQGrid->setWidth(820);
		$JQGrid->setHeight(300);
		$JQGrid->setDataType("local");
		$JQGrid->setData(json_encode($this->model->getAdmins()));
		$JQGrid->setColNames(array(
				'Id',
				'Username',
				'Password'
		));
		$JQGrid->setColModel(array(
				"{name:'id',index:'id', hidden:true},
				{name:'username',index:'username', width:220,  editable:true,editrules: { required: true}},
				{name:'password',index:'password', width:220,  editable:true,edittype:'password',editrules: { required: true}},
				"
		));
		$JQGrid->setRowNum(10);
		$JQGrid->setMType("POST");
		$JQGrid->setRowList(array(
				10,
				20,
				30
		));
		$JQGrid->setPager("#adminspager");
		$JQGrid->setSortName("id");
		// /$JQGrid->setCellEdit("true");
		$JQGrid->setViewRecords("true");
		// $JQGrid->setToolbar('true,"top"');
		$JQGrid->setSortOrder("desc");
		$JQGrid->setCaption("Admins");

		$JQGrid->setCustom('jQuery("#admins").jqGrid("navGrid","#adminspager",{edit:true,add:true,del:true},{reloadAfterSubmit:false},{reloadAfterSubmit:false});');

		$this->view->assign('grid', $JQGrid->generateGrid());
		$this->view->assign('admins_page_left_text', $this->Registry->language['admins_page_left_text']);
		unset($JQGrid);
		unset($this->Registry->language);
		$this->view->display('admins.tpl');
	}
	function editAdmins() {
		(new \SplAutoloader('lib\PasswordEncryption', array(
				'lib/PasswordEncryption'
		)) )->register();
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(isset($this->POST['oper'])) {
			if($this->POST['oper'] == 'edit') {
				if($this->POST['password'] != '******') {
					$password_encrypted =   (new PasswordEncryption() )->setPassword($this->POST['password'])->setEncryptMethod('crypt')->setEncryptionAlgorithm('CRYPT_BLOWFISH')->Encrypt();
					$this->POST['password'] = $password_encrypted['password'];
					$this->POST['salt'] = $password_encrypted['salt'];
				} else {
					unset($this->POST['password']);
				}
				unset($this->POST['oper']);
				$this->model->editAdmin($this->POST, $this->POST['id']);
				unset($this->POST);
			} elseif($this->POST['oper'] == 'add') {

					$user_key = md5($this->POST['username'] . time() . $_SERVER['REMOTE_ADDR']);
					$password_encryption = (new PasswordEncryption() )->setPassword($this->POST['password'])->setEncryptMethod('crypt')->setEncryptionAlgorithm('CRYPT_BLOWFISH')->Encrypt();
					$this->POST['password'] = $password_encryption['password'];
					$main_fields =array(
							'user_key' => $user_key,
					 'username' => $this->POST['username'],
							'password' => $this->POST['password'],
							'email' => '',
							'salt' => $password_encryption['salt'],
							'country' => '',
							'role' => 'admin',
							'gender' => 'male',
							'featured' => 0,
							'birthday' => strtotime(date('Y-m-d')),
							'last_login' => strtotime(date('Y-m-d')),
							'rating' => 0,
							'changing_status' => '',
							'online' => 0,
							'webcam' => 0,
							'webcam_session_id' => '',
							'registered_date' => date('Y-m-d')
					);
				unset($this->POST['oper']);
				unset($this->POST['id']);
				(new \lib\RBAC\RBACAdministration() )->AddUser($main_fields, array());
				//$this->model->addAdmin($this->POST);
				unset($this->POST);
			} elseif($this->POST['oper'] == 'del') {
				unset($this->POST['oper']);
				$this->model->deleteAdmin($this->POST);
				unset($this->POST);
			}
		}
	}
	function textPages() {
		(new \SplAutoloader('lib\JQGrid', array(
				'lib\JQGrid'
		)) )->register();

		$JQGrid = new JQGrid();

		$JQGrid->setAntets("var lastsel;");
		$JQGrid->setElementId("text_pages");
		// $JQGrid->setUrl("index_admin.php?route=settings");
		$JQGrid->setEditUrl("index_admin.php?route=index&action=edit_text_pages");
		$JQGrid->setWidth(820);
		$JQGrid->setHeight(300);
		$JQGrid->setDataType("local");
		$JQGrid->setData(json_encode($this->model->getTextPages()));
		$JQGrid->setColNames(array(
				'Id',
				'Section',
				'Title',
				'Url',
				'Text'
		));
		$JQGrid->setColModel(array(
				"{name:'id',index:'id', hidden:true},
				{name:'section',index:'section', width:220,  editable:true,editrules: { required: true}},
				{name:'name',index:'name', width:220,  editable:true,editrules: { required: true}},
					{name:'url',index:'url', width:220,  editable:true,editrules: { required: true}},
				{name:'text',index:'text', width:220,  editable:true,edittype:'textarea',editoptions: {rows:'20',cols:'60'},editrules: { required: true}},
				"
		));
		$JQGrid->setRowNum(10);
		$JQGrid->setMType("POST");
		$JQGrid->setRowList(array(
				10,
				20,
				30
		));
		$JQGrid->setPager("#text_pagespager");
		$JQGrid->setSortName("id");
		// /$JQGrid->setCellEdit("true");
		$JQGrid->setViewRecords("true");
		// $JQGrid->setToolbar('true,"top"');
		$JQGrid->setSortOrder("desc");
		$JQGrid->setCaption("Text Pages");

		$JQGrid->setCustom('jQuery("#text_pages").jqGrid("navGrid","#text_pagespager",{edit:true,add:true,del:true},{reloadAfterSubmit:false},{reloadAfterSubmit:false});');

		$this->view->assign('grid', $JQGrid->generateGrid());
		$this->view->assign('text_pages_page_left_text', $this->Registry->language['text_pages_page_left_text']);
		unset($JQGrid);
		unset($this->Registry->language);
		$this->view->display('text_pages.tpl');
	}
	function editTextPages() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(isset($this->POST['oper'])) {
			if($this->POST['oper'] == 'edit') {
				unset($this->POST['oper']);
				$this->Id = $this->POST['id'];
				unset($this->POST['id']);
				$this->model->editTextPages($this->POST, $this->Id);
				unset($this->POST);
			} elseif($this->POST['oper'] == 'add') {
				unset($this->POST['oper']);
				unset($this->POST['id']);
				$this->model->addTextPages($this->POST);
				unset($this->POST);
			} elseif($this->POST['oper'] == 'del') {
				unset($this->POST['oper']);
				$this->model->deleteTextPages($this->POST);
				unset($this->POST);
			}
		}
	}
	function Banners() {
		(new \SplAutoloader('lib\JQGrid', array(
				'lib\JQGrid'
		)) )->register();

		$banners = $this->model->getBanners();
		foreach($banners as $k => &$v) {
			$v->code = str_replace('script','',$v->code);
		}
		$JQGrid = new JQGrid();

		$JQGrid->setAntets("var lastsel;");
		$JQGrid->setElementId("banners");
		// $JQGrid->setUrl("index_admin.php?route=settings");
		$JQGrid->setEditUrl("index_admin.php?route=index&action=edit_banners");
		$JQGrid->setWidth(820);
		$JQGrid->setHeight(300);
		$JQGrid->setDataType("local");
		$JQGrid->setData(json_encode($banners));
		$JQGrid->setColNames(array(
				'Id',
				'Section',
				'Code'
		));
		$JQGrid->setColModel(array(
				"{name:'id',index:'id', hidden:true},
				{name:'section',index:'section', width:220,  editable:false},
				{name:'code',index:'code', width:220,  editable:true,edittype:'textarea',editoptions: {rows:'20',cols:'60'},hidden:true, editrules:{edithidden:true} },
				"
		));
		$JQGrid->setRowNum(10);
		$JQGrid->setMType("POST");
		$JQGrid->setRowList(array(
				10,
				20,
				30
		));
		$JQGrid->setPager("#bannerspager");
		$JQGrid->setSortName("id");
		// /$JQGrid->setCellEdit("true");
		$JQGrid->setViewRecords("true");
		// $JQGrid->setToolbar('true,"top"');
		$JQGrid->setSortOrder("desc");
		$JQGrid->setCaption("Banners");

		$JQGrid->setCustom('jQuery("#banners").jqGrid("navGrid","#bannerspager",{edit:true,add:false,del:false},{reloadAfterSubmit:false},{reloadAfterSubmit:false});');

		$this->view->assign('grid', $JQGrid->generateGrid());
		$this->view->assign('banners_page_left_text', $this->Registry->language['banners_page_left_text']);
		unset($JQGrid);
		unset($this->Registry->language);
		$this->view->display('banners.tpl');
	}
	function editBanners() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(isset($this->POST['oper'])) {
			if($this->POST['oper'] == 'edit') {
				unset($this->POST['oper']);
				$this->Id = $this->POST['id'];
				unset($this->POST['id']);
				$this->model->editBanners($this->POST, $this->Id);
				unset($this->POST);
			}
		}
	}
}

?>