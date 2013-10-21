<?php

namespace controllers;

use lib\Form\FormValidator;
use lib\Core\Controller;
use lib\Core\Registry;
use lib\JQGrid\JQGrid;

class AdminSettings extends Controller {
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

		$JQGrid->setAntets("var lastsel;jQuery.extend(jQuery.jgrid.edit, {recreateForm: true});");
		$JQGrid->setElementId("ads");
		// $JQGrid->setUrl("index_admin.php?route=settings");
		$JQGrid->setEditUrl("index_admin.php?route=settings&action=edit");
		$JQGrid->setWidth(820);
		$JQGrid->setHeight(500);
		$JQGrid->setDataType("local");
		$JQGrid->setData(json_encode($this->model->getSettings()));
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
		$JQGrid->setRowNum(20);
		$JQGrid->setMType("POST");
		$JQGrid->setRowList(array(
				10,
				20,
				30
		));
		$JQGrid->setPager("#asdpager");
		$JQGrid->setSortName("id");
		// /$JQGrid->setCellEdit("true");
		$JQGrid->setViewRecords("true");
		// $JQGrid->setToolbar('true,"top"');
		$JQGrid->setSortOrder("desc");
		$JQGrid->setCaption("Settings");

		$JQGrid->setGridComplete("function()
			{
					var ids = jQuery(\"#ads\").jqGrid(\"getDataIDs\");
					for(var i=0;i < ids.length;i++)
					{
					var c1 = ids[i];
				 //	be = \"<span class='ui-icon ui-icon-pencil floatleft floatleft_margin' title='Edit' onclick=\\\"jQuery('#ads').jqGrid('editRow','\"+c1+\"',true);\\\"  /></span>\";
					se = \"<span class='ui-icon ui-icon-check floatleft_margin'   title='Save' onclick=\\\"jQuery('#ads').jqGrid('saveRow','\"+c1+\"');\\\"  /></span><span class='clear'></span>\";

					jQuery(\"#ads\").jqGrid('setRowData',ids[i],{act:se});

			}
			}");

		$JQGrid->setOnSelectRow(" function(id,status){



			jQuery('#ads').jqGrid('restoreRow',lastsel);

	if(id && id!==lastsel){

				 if( id >=  10 && id <= 18){   $('#ads').jqGrid('setColProp','value', { edittype:'select',editoptions: { value:{Yes:'Yes',No:'No' }} });}
				 else if( id == 2){   $('#ads').jqGrid('setColProp','value', { edittype:'select',editoptions: { value:{Yes:'Yes',No:'No' }} });}
				else if(  id >= 20 && id <= 22 ){  $('#ads').jqGrid('setColProp','value', { edittype:'select',editoptions: { value:{Yes:'Yes',No:'No' }} });}
				else if( id >= 5 && id <= 7){   $('#ads').jqGrid('setColProp','value', { edittype:'select',editoptions: { value:{Yes:'Yes',No:'No' }} });}
				 else if(id == 4){   $('#ads').jqGrid('setColProp','value', { edittype:'select',editoptions: { value:{Php:'Php',Database:'Database' }} })}
				else if(id == 1 || id == 19 || id == 23 || id == 24 || id== 25 || id == 8 || id == 9 || id == 29 || id == 27 || id == 28) {
				 $('#ads').jqGrid('setColProp','value', { edittype:'text',value: function() { return $(this).parent().attr('title');}})
	 }


jQuery('#ads').jqGrid('editRow',id,{recreateForm: true});



			lastsel=id;
		}
	}");
/*
		$JQGrid->setBeforeSelectRow(' function(row_id,e) {
			var rowData = 	$("#ads").jqGrid("getRowData",row_id);
				var id= rowData["id"];
				 if( id >=  10 && id <= 18){  $("#ads").jqGrid("setColProp","value", { edittype:"select",editoptions: { value:{Yes:"Yes",No:"No" }} });}
				else if(  id >= 20 && id <= 22 ){   $("#ads").jqGrid("setColProp","value", { edittype:"select",editoptions: { value:{Yes:"Yes",No:"No" }} });}
				else if( id >= 5 && id <= 7){   $("#ads").jqGrid("setColProp","value", { edittype:"select",editoptions: { value:{Yes:"Yes",No:"No" }} });}
				 else if(id == 4){ $("#ads").jqGrid("setColProp","value", { edittype:"select",editoptions: { value:{Php:"Php",Database:"Database" }} })}
			//	else if(id == 19) {   $("#ads").jqGrid("setColProp","value", { edittype:"text"}) }
				return true;
				}');
*/

		$JQGrid->setCustom('jQuery("#ads").jqGrid("navGrid","#asdpager",{edit:false,add:false,del:false},{reloadAfterSubmit:false},{reloadAfterSubmit:false});');
		// p($JQGrid->generateGrid());
		// pr($JQGrid->getColNames());
		// p($JQGrid->run());

		$this->view->assign('grid', $JQGrid->generateGrid());
		$this->view->assign('settingsText', $this->Registry->language['settings_page_left_text']);
		unset($JQGrid);
		unset($this->Registry->language);
		$this->view->display('settings.tpl');
		/*
		 * $JQGrid->setGridComplete("function() { var ids =
		 * jQuery(\"#ads\").jqGrid(\"getDataIDs\"); for(var i=0;i <
		 * ids.length;i++) { var cl = ids[i]; be = \"<img
		 * src='resources/themes/wn/images/edit.png' width='20'
		 * style='cursor:pointer'
		 * onclick=\\\"jQuery('#ads').jqGrid('editRow','\"+cl+\"');\\\" />\"; se
		 * = \"<img src='resources/themes/wn/images/save.png' width='20'
		 * style='cursor:pointer'
		 * onclick=\\\"jQuery('#ads').jqGrid('saveRow','\"+cl+\"');\\\" />\"; ce
		 * = \"<img src='resources/themes/wn/images/back.png' width='20'
		 * style='cursor:pointer'
		 * onclick=\\\"jQuery('#ads').jqGrid('restoreRow','\"+cl+\"');\\\" />\";
		 * de = \"<img src='resources/themes/wn/images/close.png' width='20'
		 * style='cursor:pointer'
		 * onclick=\\\"jQuery('#ads').jqGrid('delGridRow','\"+cl+\"');\\\" />\";
		 * jQuery(\"#ads\").jqGrid('setRowData',ids[i],{act:be+se+ce+de}); }
		 * }");
		 */
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
	function AvailableCountries() {
		(new \SplAutoloader('lib\JQGrid', array(
				'lib\JQGrid'
		)) )->register();

		$JQGrid = new JQGrid();

		$JQGrid->setAntets("var lastsel;");
		$JQGrid->setElementId("available_countries");
		// $JQGrid->setUrl("index_admin.php?route=settings");
		$JQGrid->setEditUrl("index_admin.php?route=settings&action=edit_availability");
		$JQGrid->setWidth(820);
		$JQGrid->setHeight(300);
		$JQGrid->setDataType("local");
		$JQGrid->setData(json_encode($this->model->getAvailableCountries()));
		$JQGrid->setColNames(array(
				'Code',
				'country',
				'Available',
				'Actions'
		));
		$JQGrid->setColModel(array(
				"{name:'code',index:'code', width:65, key: true },
				{name:'country',index:'country', width:220},
				{name:'available',index:'available', width:220,editable:true, edittype:'checkbox', editoptions: { value:'yes:no' } },
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
		$JQGrid->setPager("#available_countriespager");
		$JQGrid->setSortName("id");
		// /$JQGrid->setCellEdit("true");
		$JQGrid->setViewRecords("true");
		// $JQGrid->setToolbar('true,"top"');
		$JQGrid->setSortOrder("desc");
		$JQGrid->setCaption("available_countries");

		$JQGrid->setGridComplete("function()
		{
				var ids = jQuery(\"#available_countries\").jqGrid(\"getDataIDs\");
				for(var i=0;i < ids.length;i++)
				{
				var cl = ids[i];
				be = \"<span class='ui-icon ui-icon-pencil floatleft floatleft_margin' title='Edit' onclick=\\\"jQuery('#available_countries').jqGrid('editRow','\"+cl+\"',true,function(cl){if(cl == 1) { $('#'+cl+'_value').html('<select></select>'); } });\\\"  /></span>\";
				se = \"<span class='ui-icon ui-icon-check floatleft_margin'   title='Save' onclick=\\\"jQuery('#available_countries').jqGrid('saveRow','\"+cl+\"');\\\"  /></span><span class='clear'></span>\";

				jQuery(\"#available_countries\").jqGrid('setRowData',ids[i],{act:be+se});

	}
	}");

		$JQGrid->setOnSelectRow(" function(id){
				if(id && id!==lastsel){
				jQuery('#available_countries').jqGrid('restoreRow',lastsel);
				jQuery('#available_countries').jqGrid('editRow',id,true);
				lastsel=id;
	}
	}");
		$JQGrid->setCustom('jQuery("#available_countries").jqGrid("navGrid","#available_countriespager",{edit:false,add:false,del:false},{reloadAfterSubmit:false},{reloadAfterSubmit:false});');
		// p($JQGrid->generateGrid());
		// pr($JQGrid->getColNames());
		// p($JQGrid->run());

		$this->view->assign('grid', $JQGrid->generateGrid());
		$this->view->assign('available_countries_left_text', $this->Registry->language['available_countries_left_text']);
		unset($JQGrid);
		unset($this->Registry->language);
		$this->view->display('available_countries.tpl');
	}
	function editAvailability() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(isset($this->POST['oper'])) {

			unset($this->POST['oper']);
			$this->Id = $this->POST['id'];
			unset($this->POST['id']);
			$this->model->updateAvailability($this->POST, $this->Id);
			unset($this->POST);
		}
	}
	function Analytics() {
		(new \SplAutoloader('lib\JQGrid', array(
				'lib\JQGrid'
		)) )->register();

		$JQGrid = new JQGrid();

		$JQGrid->setAntets("var lastsel;");
		$JQGrid->setElementId("analytics");
		// $JQGrid->setUrl("index_admin.php?route=settings");
		$JQGrid->setEditUrl("index_admin.php?route=settings&action=edit_analytics");
		$JQGrid->setWidth(820);
		$JQGrid->setHeight(300);
		$JQGrid->setDataType("local");
		$JQGrid->setData(json_encode($this->model->getAnalyticsCode()));
		$JQGrid->setColNames(array(
				'Id',
				'Code'
		));
		$JQGrid->setColModel(array(
				"{name:'id',index:'id', hidden:false},
				{name:'code',index:'code', width:220,  editable:true,editrules: { required: true},edittype:'textarea',editoptions: {rows:'20',cols:'60'} },
				"
		));
		$JQGrid->setRowNum(10);
		$JQGrid->setMType("POST");
		$JQGrid->setRowList(array(
				10,
				20,
				30
		));
		$JQGrid->setPager("#analyticspager");
		$JQGrid->setSortName("id");
		// /$JQGrid->setCellEdit("true");
		$JQGrid->setViewRecords("true");
		// $JQGrid->setToolbar('true,"top"');
		$JQGrid->setSortOrder("desc");
		$JQGrid->setCaption("analytics");

		$JQGrid->setCustom('jQuery("#analytics").jqGrid("navGrid","#analyticspager",{edit:true,add:false,del:false},{reloadAfterSubmit:false},{reloadAfterSubmit:false});');

		$this->view->assign('grid', $JQGrid->generateGrid());
		$this->view->assign('analytics_page_left_text', $this->Registry->language['analytics_page_left_text']);
		unset($JQGrid);
		unset($this->Registry->language);
		$this->view->display('analytics_code.tpl');
	}
	function editAnalytics() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(isset($this->POST['oper'])) {

			unset($this->POST['oper']);
			$this->Id = $this->POST['id'];
			unset($this->POST['id']);
			$this->model->editAnalytics($this->POST, $this->Id);
			unset($this->POST);
		}
	}
}

?>