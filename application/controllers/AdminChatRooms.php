<?php

namespace controllers;

use lib\Core\Controller;
use lib\Core\Registry;
use lib\JQGrid\JQGrid;

class AdminChatrooms extends Controller {
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
		(new \SplAutoloader('lib\JQGrid', array(
				'lib\JQGrid'
		)) )->register();

		$JQGrid = new JQGrid();

		$JQGrid->setAntets("var lastsel;");
		$JQGrid->setElementId("chatrooms");
		// $JQGrid->setUrl("index_admin.php?route=settings");
		$JQGrid->setEditUrl("index_admin.php?route=chat_rooms&action=edit");
		$JQGrid->setWidth(820);
		$JQGrid->setHeight(300);
		$JQGrid->setDataType("local");
		$JQGrid->setData(json_encode($this->model->getChatrooms()));
		$JQGrid->setColNames(array(
				'Id',
				'Name',
		));
		$JQGrid->setColModel(array(
				"{name:'id',index:'id', hidden:true},
				{name:'room_name',index:'name', width:220,  editable:true,editrules: { required: true}},
				"
		));
		$JQGrid->setRowNum(10);
		$JQGrid->setMType("POST");
		$JQGrid->setRowList(array(
				10,
				20,
				30
		));
		$JQGrid->setPager("#chatroomspager");
		$JQGrid->setSortName("id");
		// /$JQGrid->setCellEdit("true");
		$JQGrid->setViewRecords("true");
		// $JQGrid->setToolbar('true,"top"');
		$JQGrid->setSortOrder("desc");
		$JQGrid->setCaption("chatrooms");



		$JQGrid->setCustom('jQuery("#chatrooms").jqGrid("navGrid","#chatroomspager",{edit:true,add:true,del:true},{reloadAfterSubmit:false},{reloadAfterSubmit:false});');

		$this->view->assign('grid', $JQGrid->generateGrid());
		$this->view->assign('chatrooms_page_left_text', $this->Registry->language['chatrooms_page_left_text']);
		unset($JQGrid);
		unset($this->Registry->language);
		$this->view->display('chatrooms.tpl');
	}
	function Edit() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(isset($this->POST['oper'])) {
			if($this->POST['oper'] == strtolower(__FUNCTION__)) {
				unset($this->POST['oper']);
				$this->Id = $this->POST['id'];
				unset($this->POST['id']);
				$this->model->Update($this->POST, $this->Id);
				unset($this->POST);
			} elseif($this->POST['oper'] == 'add') {
				unset($this->POST['oper']);
				unset($this->POST['id']);
				$this->model->Add($this->POST);
				unset($this->POST);
			} elseif($this->POST['oper'] == 'del') {
				unset($this->POST['oper']);
				$this->model->Delete($this->POST);
				unset($this->POST);
			}
		}
	}
}

?>