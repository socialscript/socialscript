<?php

namespace controllers;

use lib\Core\Controller;
use lib\Core\Registry;
use lib\JQGrid\JQGrid;
use lib\PasswordEncryption\PasswordEncryption;

class AdminUsers extends Controller {
	function __construct() {
		parent::__construct();

		$this->Registry = Registry::getInstance();

		(new \SplAutoloader('models', array(
				'models'
		)) )->register();

		$model = 'models\Model' . $this->Registry->controllerName;
		$this->model = new $model();
		$this->gridDimensions = $this->Registry->grid_dimensions;
		// pr($this->gridDimensions);
	}
	function Index() {
		(new \SplAutoloader('lib\JQGrid', array(
				'lib\JQGrid'
		)) )->register();

		$JQGrid = new JQGrid();

		$JQGrid->setAntets("var lastsel;");
		$JQGrid->setElementId("users");
		$JQGrid->setEditUrl("index_admin.php?route=users&action=edit");
		$JQGrid->setWidth($this->gridDimensions['users']['width']);
		$JQGrid->setHeight($this->gridDimensions['users']['height']);
		$JQGrid->setDataType("local");
		$JQGrid->setData(json_encode($this->model->getUsers()));
		$JQGrid->setColNames(array(
				'Id',
				'User Key',
				'Username',
				'Password',
				'Email',
				'Country',
				'Featured',
				'Rating',
				'Role',
				'Registered'
		));
		$JQGrid->setColModel(array(
				"{name:'id',index:'id', width:20,searchrules:{integer:true}},
				{name:'user_key',index:'user_key', width:180},
				{name:'username',index:'username', width:100,editable:true,editrules:{required:true}},
				{name:'password',index:'password', width:50,editable:true,editrules:{required:true}},
				{name:'email',index:'email', width:120,editable:true,searchrules:{email:true},editrules:{required:true,email:true}},
						{name:'country',index:'country', width:30,editable:true},
					{name:'featured',index:'featured', width:50,editable:true,editrules:{required:true}},
				{name:'rating',index:'rating', width:40,editable:true,editrules:{required:true},editable:true,edittype:'select',editoptions:{value:'0:0;1:1;2:2;3:3;4:4;5:5'}},
				{name:'role',index:'role', width:60,editable:true,edittype:'select',editoptions:
  { value:'free_user:free_user;paying_user:paying_user;user_all_perms:user_all_perms;admin:admin'},editrules:{required:true}},
 				{name:'registered_date',index:'registered_date', width:70,searchrules:{dataInit: function(elem) {\$(elem).datepicker()}}, search:true},
				"
		));
		$JQGrid->setRowNum($this->gridDimensions['users']['per_page']);
		$JQGrid->setMType("POST");
		$JQGrid->setRowList($this->gridDimensions['users']['row_list']);
		$JQGrid->setPager("#userspager");
		$JQGrid->setSortName("id");
		$JQGrid->setViewRecords("true");
		// $JQGrid->setToolbar('true,"top"');
		$JQGrid->setSortOrder("desc");
		$JQGrid->setCaption("users");

		$JQGrid->setOnSelectRow('function(ids) {
		if(ids == null) {
			ids=0;
			if(jQuery("#users_extra").jqGrid("getGridParam","records") >0 )
			{
				jQuery("#users_extra").jqGrid("setGridParam",{url:"index_admin.php?route=users&action=extra_fields&id="+ids,datatype:"json"}).trigger("reloadGrid");
			}
		} else {
			jQuery("#users_extra").jqGrid("setGridParam",{url:"index_admin.php?route=users&action=extra_fields&id="+ids, datatype: "json"}).trigger("reloadGrid");
		}
	}');
		$JQGrid->setCustom('jQuery("#users").jqGrid("navGrid","#userspager",{edit:true,add:false,del:true},{reloadAfterSubmit:false},{reloadAfterSubmit:false},{},
{multipleSearch:true, multipleGroup:true});');

		$this->view->assign('grid', $JQGrid->generateGrid());

		$JQGrid = NULL;
		$JQGrid = new JQGrid();
		// $JQGrid->setAntets("var lastsel;");
		$JQGrid->setElementId("users_extra");
		$JQGrid->setEditUrl("index_admin.php?route=users&action=manage_users_extra");
		$JQGrid->setWidth($this->gridDimensions['users_extra']['width']);
		$JQGrid->setHeight($this->gridDimensions['users_extra']['height']);
		$JQGrid->setDataType("json");
		$JQGrid->setColNames(array(
				'Id',
				'Field',
				'Value'
		));
		$JQGrid->setColModel(array(
				"{name:'id',index:'id', width:25,hidden:" . $this->gridDimensions['users_extra']['id_hidden'] . "},
				{name:'field',index:'field', width:150},
				{name:'value',index:'value', width:60,editable:true },
				"
		));
		$JQGrid->setRowNum($this->gridDimensions['users_extra']['per_page']);
		$JQGrid->setMType("POST");
		$JQGrid->setRowList($this->gridDimensions['users_extra']['row_list']);
		$JQGrid->setPager('#users_extrapager');
		$JQGrid->setMultiselect("true");
		$JQGrid->setSortName("id");
		$JQGrid->setViewRecords("true");
		$JQGrid->setSortOrder("desc");
		$JQGrid->setCaption("Extra Fields");
		$JQGrid->setLoadonce("true");
		$JQGrid->setCustom('jQuery("#users_extra").jqGrid("navGrid","#users_extrapager",{edit:true,add:false,del:false},{reloadAfterSubmit:false},{reloadAfterSubmit:false},{},
{multipleSearch:true, multipleGroup:true});');

		$this->view->assign('grid_users_extra', $JQGrid->generateGrid());

		$this->view->assign('usersText', $this->Registry->language['users_page_left_text']);
		$this->view->assign('usersRightText', $this->Registry->language['users_page_right_text']);
		unset($JQGrid);
		unset($this->Registry->language);
		$this->view->display('users.tpl');
	}
	function extraFields() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);

		$user = $this->model->getUserById($this->GET['id']);
		$result = $this->model->getExtraFields($user->user_key);
		$to_json['page'] = '1';
		$to_json['total'] = '5';
		$to_json['records'] = 15;
		$i = 0;
		foreach($result as $k => $v) {
			if(strpos($v->value, '|') !== FALSE) {
				$v->value = str_replace('|', ',', $v->value);
			}
			$to_json['rows'][$i]['id'] = $v->id;
			$to_json['rows'][$i]['cell'] = array(
					$v->id,
					$this->model->getExtraFieldName($v->field),
					$v->value
			);
			$i ++;
		}

		echo json_encode($to_json);
	}
	function getUser() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		for($i = 1950; $i < 2010; $i ++) {
			$this->year_dropdown[$i] = $i;
		}
		for($i = 1; $i <= 31; $i ++) {
			$this->days_dropdown[$i] = $i;
		}
		for($i = 1; $i <= 12; $i ++) {
			$this->months_dropdown[$i] = $i;
		}

		$this->view->assign('days_dropdown', $this->days_dropdown);
		$this->view->assign('months_dropdown', $this->months_dropdown);
		$this->view->assign('years_dropdown', $this->year_dropdown);
		$this->view->assign('user_id', $this->POST['id']);
		$this->view->assign('user', $this->model->getUser($this->POST['id']));
		$this->view->display('user.tpl');
	}
	function Edit() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(isset($this->POST['oper'])) {
			if($this->POST['oper'] == 'edit') {
				unset($this->POST['oper']);
				$this->Id = $this->POST['id'];
				unset($this->POST['id']);
				if($this->POST['password'] != '******') {
					(new \SplAutoloader('lib\PasswordEncryption', array(
							'lib/PasswordEncryption'
					)) )->register();
					$password = (new PasswordEncryption() )->setPassword($this->POST['password'])->setEncryptMethod('crypt')->setEncryptionAlgorithm('CRYPT_BLOWFISH')->Encrypt();
					$this->POST['password'] = $password['password'];
					$this->POST['salt'] = $password['salt'];
				} else {
					unset($this->POST['password']);
				}
				$this->model->Update($this->POST, $this->Id);
				unset($this->POST);
			}

			elseif($this->POST['oper'] == 'del') {
				unset($this->POST['oper']);
				$user = $this->model->getUserById($this->POST['id']);
				$this->model->deleteUserBlogsCategories(array($user->user_key));
				$this->model->deleteUserBlogsSubscribe(array($user->user_key,$user->user_key));
				$this->model->deleteUserBlogs(array($user->user_key));
				$this->model->deleteUserBlogsComments(array($user->user_key));
				$this->model->deleteUserChat(array($user->user_key,$user->user_key));
				$this->model->deleteUserBusinessComments(array($user->user_key));
				$this->model->deleteUserBusiness(array($user->user_key));
				$this->model->deleteUserBusinessComments(array($user->user_key));
				$this->model->deleteUserCars(array($user->user_key));
				$this->model->deleteUserCarsComments(array($user->user_key));
				$this->model->deleteUserEvents(array($user->user_key));
				$this->model->deleteUserEventsComments(array($user->user_key));
				$this->model->deleteUserEventsInvites(array($user->user_key,$user->user_key));
				$this->model->deleteUserEventsSubscribe(array($user->user_key,$user->user_key));

				$this->model->deleteUserFashion(array($user->user_key));
				$this->model->deleteUserFashionComments(array($user->user_key));

				$this->model->deleteUserFinance(array($user->user_key));
				$this->model->deleteUserFinanceComments(array($user->user_key));
				$this->model->deleteUserFoods(array($user->user_key));
				$this->model->deleteUserFoodsComments(array($user->user_key));
				$this->model->deleteUserFriends(array($user->user_key,$user->user_key));

				$this->model->deleteUserGalleries(array($user->user_key));
				$this->model->deleteUserGossip(array($user->user_key));
				$this->model->deleteUserGossipComments(array($user->user_key));
				$this->model->deleteUserGroups(array($user->user_key));
				$this->model->deleteUserGroupBlogs(array($user->user_key));
				$this->model->deleteUserGroupBlogsComments(array($user->user_key));
				$this->model->deleteUserGroupEvents(array($user->user_key));
				$this->model->deleteUserGroupEventsComments(array($user->user_key));
				$this->model->deleteUserGroupMembers(array($user->user_key));
				$this->model->deleteUserGroupMusic(array($user->user_key));

				$this->model->deleteUserGroupMusicComments(array($user->user_key));
				$this->model->deleteUserGroupPictures(array($user->user_key));
				$this->model->deleteUserGroupPicturesComments(array($user->user_key));
				$this->model->deleteUserGroupSubscribe(array($user->user_key,$user->user_key));
				$this->model->deleteUserGroupVideos(array($user->user_key));
				$this->model->deleteUserGroupVideosComments(array($user->user_key));
				$this->model->deleteUserMarkedInterestedIn(array($user->user_key,$user->user_key));
				$this->model->deleteUserMessages(array($user->user_key,$user->user_key));
				$this->model->deleteUserMovies(array($user->user_key));
				$this->model->deleteUserMoviesComments(array($user->user_key));
				$this->model->deleteUserMusic(array($user->user_key));
				$this->model->deleteUserMusicComments(array($user->user_key));

				$this->model->deleteUserMusicFiles(array($user->user_key));
				$this->model->deleteUserMusicFilesComments(array($user->user_key));
				$this->model->deleteUserMusicGalleries(array($user->user_key));
				$this->model->deleteUserNews(array($user->user_key));
				$this->model->deleteUserNewsComments(array($user->user_key));
				$this->model->deleteUserPictures(array($user->user_key));
				$this->model->deleteUserPicturesComments(array($user->user_key));
				$this->model->deleteUserPicturesSubscribe(array($user->user_key,$user->user_key));
				$this->model->deleteUserSayHello(array($user->user_key,$user->user_key));
				$this->model->deleteUserSports(array($user->user_key));
				$this->model->deleteUserSportsComments(array($user->user_key));
				$this->model->deleteUserTechnology(array($user->user_key));
				$this->model->deleteUserTechnologyComments(array($user->user_key));
				$this->model->deleteUserTrade(array($user->user_key));
				$this->model->deleteUserTradeQuestions(array($user->user_key));
				$this->model->deleteUserTravel(array($user->user_key));
				$this->model->deleteUserTravelComments(array($user->user_key));
				$this->model->deleteUserVideos(array($user->user_key));
				$this->model->deleteUserVideosComments(array($user->user_key));
				$this->model->deleteUserVideosGalleries(array($user->user_key));
				$this->model->deleteUserWhatshot(array($user->user_key));
				$this->model->deleteUserWhatshotComments(array($user->user_key));
				$this->model->deleteUserExtra(array($user->user_key));
				$this->model->deleteUser(array($user->user_key));
				unset($this->POST);
			}

		}
		echo 'success';
		exit();
	}
	function manageUsersExtra() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);

		if($_SERVER['REQUEST_METHOD'] === 'POST') {

			$this->model->UpdateExtra(array(
					$this->POST['value'],
					$this->POST['id']
			));

			unset($this->POST);
		}

		echo 'success';
		exit();
	}
}

?>
