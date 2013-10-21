<?php

namespace controllers;

use lib\Core\Controller;
use lib\Core\Registry;
use lib\JQGrid\JQGrid;

class AdminLanguages extends Controller {
	function __construct() {
		parent::__construct();
		
		$this->Registry = Registry::getInstance();
		
		(new \SplAutoloader('models', array(
				'models'
		)) )->register();
		
		$model = 'models\Model' . $this->Registry->controllerName;
		$this->model = new $model();
		(new \SplAutoloader('lib\JQGrid', array(
				'lib\JQGrid'
		)) )->register();
	}
	function Index() {
		$this->loadLanguage = (! isset($this->Registry->GET['lang'])) ? 'en' : $this->Registry->GET['lang'];
		$this->view->assign('languages', $this->model->getAllLanguages());
		$this->view->assign('languagesText', $this->Registry->language['languages_left_text']);
		$this->view->assign('add_new_language_text', $this->Registry->language['languages_add_language']);
		$this->view->assign('grid', self::generateGrid());
		unset($this->Registry->language);
		$this->view->display('languages.tpl');
	}
	function generateGrid() {
		$JQGrid = new JQGrid();
		$JQGrid->setAntets("var lastsel;");
		$JQGrid->setElementId("languages");
		// $JQGrid->setUrl("index_admin.php?route=settings");
		$JQGrid->setEditUrl("index_admin.php?route=languages&action=edit");
		$JQGrid->setWidth(820);
		$JQGrid->setHeight(300);
		$JQGrid->setDataType("local");
		$JQGrid->setData(json_encode($this->model->getTexts($this->loadLanguage)));
		$JQGrid->setColNames(array(
				'Id',
				'Name',
				'Value',
				'Lang',
				'Actions'
		));
		$JQGrid->setColModel(array(
				"{name:'id',index:'id', width:65},
				{name:'name',index:'name', width:100},
				{name:'value',index:'value', width:200,editable:true,editrules: { required: true,edittype:'textarea'},editoptions: {rows:'3',cols:'10'} },
				{name:'language',language:'value',width:20},
				{name:'act',index:'act', width:35,sortable:false},

				"
		));
		$JQGrid->setRowNum(10);
		$JQGrid->setMType("POST");
		$JQGrid->setRowList(array(
				10,
				20,
				30
		));
		$JQGrid->setPager("#languagespager");
		$JQGrid->setSortName("id");
		// /$JQGrid->setCellEdit("true");
		$JQGrid->setViewRecords("true");
		// $JQGrid->setToolbar('true,"top"');
		$JQGrid->setSortOrder("desc");
		$JQGrid->setCaption("languages");
		
		$JQGrid->setGridComplete("function()
		{
				var ids = jQuery(\"#languages\").jqGrid(\"getDataIDs\");
				for(var i=0;i < ids.length;i++)
				{
				var cl = ids[i];
				be = \"<span class='ui-icon ui-icon-pencil floatleft floatleft_margin' title='Edit' onclick=\\\"jQuery('#languages').jqGrid('editRow','\"+cl+\"',true,function(cl){if(cl == 1) { $('#'+cl+'_value').html('<select></select>'); } });\\\"  /></span>\";
				se = \"<span class='ui-icon ui-icon-check floatleft_margin'   title='Save' onclick=\\\"jQuery('#languages').jqGrid('saveRow','\"+cl+\"');\\\"  /></span><span class='clear'></span>\";

				jQuery(\"#languages\").jqGrid('setRowData',ids[i],{act:be+se});

		}
		}");
		
		$JQGrid->setOnSelectRow(" function(id){
				if(id && id!==lastsel){
				jQuery('#languages').jqGrid('restoreRow',lastsel);
				jQuery('#languages').jqGrid('editRow',id,true);
				lastsel=id;
		}
		}");
		$JQGrid->setCustom('jQuery("#languages").jqGrid("navGrid","#languagespager",{edit:false,add:false,del:false},{reloadAfterSubmit:false},{reloadAfterSubmit:false});');
		// p($JQGrid->generateGrid());
		// pr($JQGrid->getColNames());
		// p($JQGrid->run());
		
		return $JQGrid->generateGrid();
	}
	function LoadLanguage() {
		$this->loadLanguage = (! isset($this->Registry->GET['lang'])) ? 'en' : $this->Registry->GET['lang'];
		echo self::generateGrid();
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
			}
		}
	}
	function Add() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		
		if($this->model->Add($this->POST['new_language'])) {
			unset($this->POST);
			echo json_encode(array(
					'status' => 'success'
			));
			exit();
		}
	}
}

?>