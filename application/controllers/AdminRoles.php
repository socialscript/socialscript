<?php

namespace controllers;

use lib\Core\Controller;
use lib\Core\Registry;
use lib\JQGrid\JQGrid;

class AdminRoles extends Controller {
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
		$JQGrid->setElementId("role");
		$JQGrid->setEditUrl("index_admin.php?route=roles&action=edit");
		$JQGrid->setWidth(820);
		$JQGrid->setHeight(300);
		$JQGrid->setDataType("local");
		$JQGrid->setData(json_encode($this->model->getRoles()));
		$JQGrid->setColNames(array(
				'Id',
				'Role',
				'Add Photo',
				'Add Video',
				'Add Event',
				'Create Groups',
				'Use Agenda',
				'Add Widgets',
				'Actions'
		));
		$JQGrid->setColModel(array(
				"{name:'id',index:'id', width:20},
				{name:'role',index:'role', width:60},
				 {name:'add_photo',index:'add_photo', width:60,editable:true, edittype:'checkbox', editoptions: { value:'Yes:No' }},
				 {name:'add_video',index:'add_video', width:60,editable:true, edittype:'checkbox', editoptions: { value:'Yes:No' }},
				 {name:'add_event',index:'add_event', width:60,editable:true, edittype:'checkbox', editoptions: { value:'Yes:No' }},
				 {name:'create_groups',index:'create_groups', width:60,editable:true, edittype:'checkbox', editoptions: { value:'Yes:No' }},
				 {name:'use_agenda',index:'use_agenda', width:60,editable:true, edittype:'checkbox', editoptions: { value:'Yes:No' }},
				 {name:'add_widgets',index:'add_widgets', width:60,editable:true, edittype:'checkbox', editoptions: { value:'Yes:No' }},
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
		$JQGrid->setPager("#rolepager");
		$JQGrid->setSortName("id");
		$JQGrid->setViewRecords("true");
		// $JQGrid->setToolbar('true,"top"');
		$JQGrid->setSortOrder("desc");
		$JQGrid->setCaption("role");
		
		$JQGrid->setGridComplete("function()
		{
				var ids = jQuery(\"#role\").jqGrid(\"getDataIDs\");
				for(var i=0;i < ids.length;i++)
				{
				var cl = ids[i];
				be = \"<span class='ui-icon ui-icon-pencil floatleft floatleft_margin' title='Edit' onclick=\\\"jQuery('#role').jqGrid('editRow','\"+cl+\"',true,function(cl){if(cl == 1) { $('#'+cl+'_value').html('<select></select>'); } });\\\"  /></span>\";
				se = \"<span class='ui-icon ui-icon-check floatleft_margin'   title='Save' onclick=\\\"jQuery('#role').jqGrid('saveRow','\"+cl+\"');\\\"  /></span><span class='clear'></span>\";

				jQuery(\"#role\").jqGrid('setRowData',ids[i],{act:be+se});

	}
	}");
		
		$JQGrid->setOnSelectRow(" function(id){
				if(id && id!==lastsel){
				jQuery('#role').jqGrid('restoreRow',lastsel);
				jQuery('#role').jqGrid('editRow',id,true);
				lastsel=id;
	}
	}");
		$JQGrid->setCustom('jQuery("#role").jqGrid("navGrid","#rolepager",{edit:false,add:false,del:false},{reloadAfterSubmit:false},{reloadAfterSubmit:false});');
		
		$this->view->assign('grid', $JQGrid->generateGrid());
		$this->view->assign('roleText', $this->Registry->language['role_page_left_text']);
		unset($JQGrid);
		unset($this->Registry->language);
		$this->view->display('roles.tpl');
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
}

?>