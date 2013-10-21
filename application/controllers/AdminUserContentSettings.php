<?php

namespace controllers;

use lib\Core\Controller;
use lib\Core\Registry;
use lib\JQGrid\JQGrid;

class AdminUserContentSettings extends Controller {
	function __construct() {
		parent::__construct();
		
		$this->Registry = Registry::getInstance();
		
		(new \SplAutoloader('models', array(
				'models'
		)) )->register();
		
		$model = 'models\Model' . $this->Registry->controllerName;
		$this->model = new $model();
	}
	function picturesSettings() {
		(new \SplAutoloader('lib\JQGrid', array(
				'lib\JQGrid'
		)) )->register();
		
		$JQGrid = new JQGrid();
		
		$JQGrid->setAntets("var lastsel;");
		$JQGrid->setElementId("user_pictures_settings");
		$JQGrid->setEditUrl("index_admin.php?route=user_content_settings&action=edit_pictures_settings");
		$JQGrid->setWidth(820);
		$JQGrid->setHeight(300);
		$JQGrid->setDataType("local");
		$JQGrid->setData(json_encode($this->model->getUserPicturesSettings()));
		$JQGrid->setColNames(array(
				'Id',
				'Name',
				'Value',
				'Actions'
		));
		$JQGrid->setColModel(array(
				"{name:'id',index:'id', width:65},
				{name:'name',index:'name', width:220},
				{name:'value',index:'value', width:220,editable:true,editrules: { required: true} },
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
		$JQGrid->setPager("#user_pictures_settingspager");
		$JQGrid->setSortName("id");
		$JQGrid->setViewRecords("true");
		// $JQGrid->setToolbar('true,"top"');
		$JQGrid->setSortOrder("desc");
		$JQGrid->setCaption("user_pictures_settings");
		
		$JQGrid->setGridComplete("function()
		{
				var ids = jQuery(\"#user_pictures_settings\").jqGrid(\"getDataIDs\");
				for(var i=0;i < ids.length;i++)
				{
				var cl = ids[i];
				be = \"<span class='ui-icon ui-icon-pencil floatleft floatleft_margin' title='Edit' onclick=\\\"jQuery('#user_pictures_settings').jqGrid('editRow','\"+cl+\"',true,function(cl){if(cl == 1) { $('#'+cl+'_value').html('<select></select>'); } });\\\"  /></span>\";
				se = \"<span class='ui-icon ui-icon-check floatleft_margin'   title='Save' onclick=\\\"jQuery('#user_pictures_settings').jqGrid('saveRow','\"+cl+\"');\\\"  /></span><span class='clear'></span>\";

				jQuery(\"#user_pictures_settings\").jqGrid('setRowData',ids[i],{act:be+se});

	}
	}");
		
		$JQGrid->setOnSelectRow(" function(id){
				if(id && id!==lastsel){
				jQuery('#user_pictures_settings').jqGrid('restoreRow',lastsel);
				jQuery('#user_pictures_settings').jqGrid('editRow',id,true);
				lastsel=id;
	}
	}");
		$JQGrid->setCustom('jQuery("#user_pictures_settings").jqGrid("navGrid","#user_pictures_settingspager",{edit:false,add:false,del:false},{reloadAfterSubmit:false},{reloadAfterSubmit:false});');
		
		$this->view->assign('grid', $JQGrid->generateGrid());
		$this->view->assign('user_pictures_settings_left_text', $this->Registry->language['user_pictures_settings_left_text']);
		unset($JQGrid);
		unset($this->Registry->language);
		$this->view->display('user_pictures_settings.tpl');
	}
	function editPicturesSettings() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(isset($this->POST['oper'])) {
			if($this->POST['oper'] == 'edit') {
				unset($this->POST['oper']);
				$this->Id = $this->POST['id'];
				unset($this->POST['id']);
				$this->model->updatePicturesSettings($this->POST, $this->Id);
				unset($this->POST);
			}
		}
	}
	function videosSettings() {
		(new \SplAutoloader('lib\JQGrid', array(
				'lib\JQGrid'
		)) )->register();
		
		$JQGrid = new JQGrid();
		
		$JQGrid->setAntets("var lastsel;");
		$JQGrid->setElementId("user_videos_settings");
		$JQGrid->setEditUrl("index_admin.php?route=user_content_settings&action=edit_videos_settings");
		$JQGrid->setWidth(820);
		$JQGrid->setHeight(300);
		$JQGrid->setDataType("local");
		$JQGrid->setData(json_encode($this->model->getUserVideosSettings()));
		$JQGrid->setColNames(array(
				'Id',
				'Name',
				'Value',
				'Actions'
		));
		$JQGrid->setColModel(array(
				"{name:'id',index:'id', width:65},
				{name:'name',index:'name', width:220},
				{name:'value',index:'value', width:220,editable:true,editrules: { required: true} },
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
		$JQGrid->setPager("#user_videos_settingspager");
		$JQGrid->setSortName("id");
		$JQGrid->setViewRecords("true");
		// $JQGrid->setToolbar('true,"top"');
		$JQGrid->setSortOrder("desc");
		$JQGrid->setCaption("user_videos_settings");
		
		$JQGrid->setGridComplete("function()
		{
				var ids = jQuery(\"#user_videos_settings\").jqGrid(\"getDataIDs\");
				for(var i=0;i < ids.length;i++)
				{
				var cl = ids[i];
				be = \"<span class='ui-icon ui-icon-pencil floatleft floatleft_margin' title='Edit' onclick=\\\"jQuery('#user_videos_settings').jqGrid('editRow','\"+cl+\"',true,function(cl){if(cl == 1) { $('#'+cl+'_value').html('<select></select>'); } });\\\"  /></span>\";
				se = \"<span class='ui-icon ui-icon-check floatleft_margin'   title='Save' onclick=\\\"jQuery('#user_videos_settings').jqGrid('saveRow','\"+cl+\"');\\\"  /></span><span class='clear'></span>\";

				jQuery(\"#user_videos_settings\").jqGrid('setRowData',ids[i],{act:be+se});

	}
	}");
		
		$JQGrid->setOnSelectRow(" function(id){
				if(id && id!==lastsel){
				jQuery('#user_videos_settings').jqGrid('restoreRow',lastsel);
				jQuery('#user_videos_settings').jqGrid('editRow',id,true);
				lastsel=id;
	}
	}");
		$JQGrid->setCustom('jQuery("#user_videos_settings").jqGrid("navGrid","#user_videos_settingspager",{edit:false,add:false,del:false},{reloadAfterSubmit:false},{reloadAfterSubmit:false});');
		
		$this->view->assign('grid', $JQGrid->generateGrid());
		$this->view->assign('user_videos_settings_left_text', $this->Registry->language['user_videos_settings_left_text']);
		unset($JQGrid);
		unset($this->Registry->language);
		$this->view->display('user_videos_settings.tpl');
	}
	function editVideosSettings() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(isset($this->POST['oper'])) {
			if($this->POST['oper'] == 'edit') {
				unset($this->POST['oper']);
				$this->Id = $this->POST['id'];
				unset($this->POST['id']);
				$this->model->updateVideosSettings($this->POST, $this->Id);
				unset($this->POST);
			}
		}
	}
}

?>