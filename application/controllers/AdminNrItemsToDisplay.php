<?php

namespace controllers;

use lib\Core\Controller;
use lib\Core\Registry;
use lib\JQGrid\JQGrid;

class AdminNrItemsToDisplay extends Controller {
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
		$JQGrid->setElementId("nr_items_to_display");
		$JQGrid->setEditUrl("index_admin.php?route=nr_items_to_display&action=edit");
		$JQGrid->setWidth(820);
		$JQGrid->setHeight(300);
		$JQGrid->setDataType("local");
		$JQGrid->setData(json_encode($this->model->getNrItemsToDisplay()));
		$JQGrid->setColNames(array(
				'Id',
				'Name',
				'Value',
				'Actions'
		));
		$JQGrid->setColModel(array(
				"{name:'id',index:'id', width:65},
				{name:'name',index:'name', width:220},
				{name:'value',index:'value', width:220,editable:true,editrules: { required: true,integer: true} },
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
		$JQGrid->setPager("#nr_items_to_displaypager");
		$JQGrid->setSortName("id");
		$JQGrid->setViewRecords("true");
		// $JQGrid->setToolbar('true,"top"');
		$JQGrid->setSortOrder("desc");
		$JQGrid->setCaption("nr_items_to_display");
		
		$JQGrid->setGridComplete("function()
		{
				var ids = jQuery(\"#nr_items_to_display\").jqGrid(\"getDataIDs\");
				for(var i=0;i < ids.length;i++)
				{
				var cl = ids[i];
				be = \"<span class='ui-icon ui-icon-pencil floatleft floatleft_margin' title='Edit' onclick=\\\"jQuery('#nr_items_to_display').jqGrid('editRow','\"+cl+\"',true,function(cl){if(cl == 1) { $('#'+cl+'_value').html('<select></select>'); } });\\\"  /></span>\";
				se = \"<span class='ui-icon ui-icon-check floatleft_margin'   title='Save' onclick=\\\"jQuery('#nr_items_to_display').jqGrid('saveRow','\"+cl+\"');\\\"  /></span><span class='clear'></span>\";

				jQuery(\"#nr_items_to_display\").jqGrid('setRowData',ids[i],{act:be+se});

	}
	}");
		
		$JQGrid->setOnSelectRow(" function(id){
				if(id && id!==lastsel){
				jQuery('#nr_items_to_display').jqGrid('restoreRow',lastsel);
				jQuery('#nr_items_to_display').jqGrid('editRow',id,true);
				lastsel=id;
	}
	}");
		$JQGrid->setCustom('jQuery("#nr_items_to_display").jqGrid("navGrid","#nr_items_to_displaypager",{edit:false,add:false,del:false},{reloadAfterSubmit:false},{reloadAfterSubmit:false});');
		
		$this->view->assign('grid', $JQGrid->generateGrid());
		$this->view->assign('items_to_display_left_text', $this->Registry->language['items_to_display_left_text']);
		unset($JQGrid);
		unset($this->Registry->language);
		$this->view->display('nr_items_to_display.tpl');
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