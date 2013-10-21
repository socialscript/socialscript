<?php
namespace controllers;

use lib\Core\Controller as Controller;
use lib\Core\Registry;
use lib\JQGrid\JQGrid;
use models\ModelAdminForms;

class AdminUsersInteraction extends Controller {
	function __construct() {
		parent::__construct();
		$this->Registry = Registry::getInstance();
		(new \SplAutoloader('models', array(
				'models'
		)) )->register();

		$model = 'models\Model' . $this->Registry->controllerName;
		$this->model = new $model();

		(new \SplAutoloader('classes', array(
				'classes'
		)) )->register();

		$this->gridDimensions = $this->Registry->grid_dimensions;
	}
	function manageExtraSections() {
		(new \SplAutoloader('lib\JQGrid', array(
				'lib\JQGrid'
		)) )->register();
		$this->GET = $this->Registry->GET;
		$this->COOKIE = $this->Registry->COOKIE;
		unset($this->Registry->COOKIE);

		$JQGrid = new JQGrid();
		$JQGrid->setAntets("var lastsel;");
		$JQGrid->setElementId($this->GET['type']);
		// $JQGrid->setUrl("index_admin.php?route=settings");
		$JQGrid->setEditUrl("index_admin.php?route=users_interaction&action=edit_extra_sections&type=" . $this->GET['type']);
		$JQGrid->setWidth($this->gridDimensions['extra_sections']['width']);
		$JQGrid->setHeight($this->gridDimensions['extra_sections']['height']);
		$JQGrid->setDataType("local");
		$JQGrid->setData(json_encode($this->model->getExtraSections($this->GET['type'])));
		$JQGrid->setColNames(array(
				'Id',
				'Title',
				'Text',
				'User'
		));
		$JQGrid->setColModel(array(
				"{name:'id',index:'id', width:65},
				{name:'title',index:'title',editable:true, width:100,editrules:{required: true}},
				{name:'text',index:'text', width:200,editable:true,edittype:'textarea',editoptions: {rows:'20',cols:'60'},hidden:true, editrules:{edithidden:true} },
				{name:'username',index:'username',width:100},

				"
		));
		$JQGrid->setRowNum($this->gridDimensions['extra_sections']['per_page']);
		$JQGrid->setMType("POST");
		$JQGrid->setRowList($this->gridDimensions['extra_sections']['row_list']);
		$JQGrid->setPager("#" . $this->GET['type'] . "pager");
		$JQGrid->setSortName("id");
		$JQGrid->setViewRecords("true");
		// $JQGrid->setToolbar('true,"top"');
		$JQGrid->setSortOrder("desc");
		$JQGrid->setCaption(ucfirst($this->GET['type']));
		$JQGrid->setMultiselect("true");
		$JQGrid->setOnSelectRow(' function(ids) {
		if(ids == null) {
			ids=0;
			if(jQuery("#' . $this->GET['type'] . '_comments").jqGrid("getGridParam","records") >0 )
			{
				jQuery("#' . $this->GET['type'] . '_comments").jqGrid("setGridParam",{url:"index_admin.php?route=users_interaction&action=extra_sections_comments&type=' . $this->GET['type'] . '&id="+ids,datatype:"json"}).trigger("reloadGrid");
			}
		} else {
			jQuery("#' . $this->GET['type'] . '_comments").jqGrid("setGridParam",{url:"index_admin.php?route=users_interaction&action=extra_sections_comments&type=' . $this->GET['type'] . '&id="+ids, datatype: "json"}).trigger("reloadGrid");
		}
	}');
		$JQGrid->setCustom('jQuery("#' . $this->GET['type'] . '").jqGrid("navGrid","#' . $this->GET['type'] . 'pager",{edit:true,add:false,del:true},{
    //   afterSubmit: function () {  $("#events").trigger("reloadGrid")},
				recreateForm:true,

				afterShowForm:  function (formid) {
$("textarea").tinymce({
			script_url : "resources/js/tiny_mce/tiny_mce.js",

			theme : "simple",editor_deselector : "mceNoEditor",
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			//content_css : "css/content.css",

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",

			// Replace values for the template plugin
			template_replace_values : {
				username : "Some User",
				staffid : "991234"
			}
		});
	 },
        closeAfterAdd: true,
        closeAfterEdit: true,
        reloadAfterSubmit:true,
    },
    {
       // afterSubmit: function () {  $("#events").trigger("reloadGrid")},
				recreateForm:true,
				afterShowForm:  function (formid) {
$("textarea").tinymce({
			script_url : "resources/js/tiny_mce/tiny_mce.js",

			theme : "simple",editor_deselector : "mceNoEditor",
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			//content_css : "css/content.css",

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",

			// Replace values for the template plugin
			template_replace_values : {
				username : "Some User",
				staffid : "991234"
			}
		});
	 },

        closeAfterAdd: true,
        closeAfterEdit: true,
        reloadAfterSubmit:true,
    },
    {
        closeAfterAdd: true,
        closeAfterEdit: true,
        reloadAfterSubmit:true
    },{reloadAfterSubmit:true});');
		$this->view->assign('grid', $JQGrid->generateGrid());

		$JQGrid = NULL;
		$JQGrid = new JQGrid();
		// $JQGrid->setAntets("var lastsel;");
		$JQGrid->setElementId($this->GET['type'] . "_comments");
		$JQGrid->setEditUrl("index_admin.php?route=users_interaction&action=manage_extra_sections_comments&type=" . $this->GET['type']);
		$JQGrid->setWidth($this->gridDimensions['extra_sections_comments']['width']);
		$JQGrid->setHeight($this->gridDimensions['extra_sections_comments']['height']);
		$JQGrid->setDataType("json");
		$JQGrid->setColNames(array(
				'Id',
				'Comment',
				'User'
		));
		$JQGrid->setColModel(array(
				"{name:'id',index:'id', width:25,searchrules:{integer:true},hidden:" . $this->gridDimensions['events_comments']['id_hidden'] . "},
				{name:'comment',index:'comment', width:150,editable:true,edittype:'textarea',editoptions: {rows:'20',cols:'40'},},
				{name:'username',index:'username', width:60 },
				"
		));
		$JQGrid->setRowNum($this->gridDimensions['extra_sections_comments']['per_page']);
		$JQGrid->setMType("POST");
		$JQGrid->setRowList($this->gridDimensions['extra_sections_comments']['row_list']);
		$JQGrid->setPager('#' . $this->GET['type'] . "_commentspager");
		$JQGrid->setMultiselect("true");
		$JQGrid->setSortName("id");
		$JQGrid->setViewRecords("true");
		$JQGrid->setSortOrder("desc");
		$JQGrid->setCaption("Comments");
		$JQGrid->setLoadonce("true");
		$JQGrid->setCustom('jQuery("#' . $this->GET['type'] . '_comments").jqGrid("navGrid","#' . $this->GET['type'] . '_commentspager",{edit:true,add:false,del:true},{
    //   afterSubmit: function () {  $("#events").trigger("reloadGrid")},
				recreateForm:true,

				afterShowForm:  function (formid) {
$("textarea").tinymce({
			script_url : "resources/js/tiny_mce/tiny_mce.js",

			theme : "simple",editor_deselector : "mceNoEditor",
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			//content_css : "css/content.css",

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",

			// Replace values for the template plugin
			template_replace_values : {
				username : "Some User",
				staffid : "991234"
			}
		});
	 },
        closeAfterAdd: true,
        closeAfterEdit: true,
        reloadAfterSubmit:true,
    },
    {
       // afterSubmit: function () {  $("#events").trigger("reloadGrid")},
				recreateForm:true,
				afterShowForm:  function (formid) {
$("textarea").tinymce({
			script_url : "resources/js/tiny_mce/tiny_mce.js",

			theme : "simple",editor_deselector : "mceNoEditor",
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			//content_css : "css/content.css",

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",

			// Replace values for the template plugin
			template_replace_values : {
				username : "Some User",
				staffid : "991234"
			}
		});
	 },

        closeAfterAdd: true,
        closeAfterEdit: true,
        reloadAfterSubmit:true,
    },
    {
        closeAfterAdd: true,
        closeAfterEdit: true,
        reloadAfterSubmit:true
    },{reloadAfterSubmit:true},{},
{multipleSearch:true, multipleGroup:true});');

		$this->view->assign('grid_comments', $JQGrid->generateGrid());

		$this->view->assign('left_text', $this->Registry->language[$this->GET['type'] . '_page_left_text']);
		$this->view->assign('type', $this->GET['type']);
		unset($JQGrid);
		unset($this->Registry->language);
		$this->view->display('extra_sections/extra_sections.tpl');
	}
	function EditExtraSections() {
		$this->POST = $this->Registry->POST;
		$this->GET = $this->Registry->GET;
		unset($this->Registry->POST);
		unset($this->Registry->GET);
		if(isset($this->POST['oper'])) {
			if($this->POST['oper'] == 'edit') {
				unset($this->POST['oper']);
				$this->Id = $this->POST['id'];
				unset($this->POST['id']);
				$this->model->UpdateExtraSections($this->POST, $this->Id, $this->GET['type']);
				unset($this->POST);
			} else {
				unset($this->POST['oper']);
				if(strpos($this->Id, ',') !== FALSE) {
					$ids = explode(',', $this->POST['id']);
					unset($this->POST['id']);
					foreach($ids as $k => $v) {
						$this->model->DeleteExtraSections($v, $this->GET['type']);
					}
					unset($this->POST);
				} else {
					$this->Id = $this->POST['id'];
					unset($this->POST['id']);
					$this->model->DeleteExtraSections($this->Id, $this->GET['type']);
					unset($this->POST);
				}
			}
		}
	}
	function extraSectionsComments() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);

		$result = $this->model->getExtraSectionsComments($this->GET['id'], $this->GET['type']);
		$to_json['page'] = '1';
		$to_json['total'] = '5';
		$to_json['records'] = 15;
		$i = 0;
		foreach($result as $k => $v) {
			$to_json['rows'][$i]['id'] = $v->id;
			$to_json['rows'][$i]['cell'] = array(
					$v->id,
					$v->comment,
					$v->username
			);
			$i ++;
		}

		echo json_encode($to_json);
	}
	function manageExtraSectionsComments() {
		$this->POST = $this->Registry->POST;
		$this->GET = $this->Registry->GET;
		unset($this->Registry->POST);
		unset($this->Registry->GET);
		if(isset($this->POST['oper'])) {
			if($this->POST['oper'] == 'edit') {
				unset($this->POST['oper']);
				$this->Id = $this->POST['id'];
				unset($this->POST['id']);
				$this->model->updateExtraSectionsComment($this->POST, $this->Id, $this->GET['type']);
				unset($this->POST);
			} else {
				unset($this->POST['oper']);
				$this->Id = $this->POST['id'];
				if(strpos($this->Id, ',') !== FALSE) {
					$ids = explode(',', $this->POST['id']);
					unset($this->POST['id']);
					foreach($ids as $k => $v) {
						$this->model->deleteExtraSectionsComment($v, $this->GET['type']);
					}
					unset($this->POST);
				} else {
					unset($this->POST['id']);
					$this->model->deleteExtraSectionsComment($this->Id, $this->GET['type']);
					unset($this->POST);
				}
			}
		}
	}
	function getEvents() {
		(new \SplAutoloader('lib\JQGrid', array(
				'lib\JQGrid'
		)) )->register();

		$JQGrid = new JQGrid();

		$JQGrid->setAntets("var lastsel;");

		$JQGrid->setElementId("events");

		$JQGrid->setEditUrl("index_admin.php?route=users_interaction&action=manage_event");
		$JQGrid->setWidth($this->gridDimensions['events']['width']);
		$JQGrid->setHeight($this->gridDimensions['events']['height']);
		$JQGrid->setDataType("local");
		$JQGrid->setData(json_encode($this->model->getEvents()));
		$JQGrid->setColNames(array(
				'Id',
				'Title',
				'Text',
				'Location',
				'Event Date',
				'User'
		));
		$JQGrid->setColModel(array(
				"{name:'id',index:'id', width:25,searchrules:{integer:true},hidden:" . $this->gridDimensions['events']['id_hidden'] . "},
				{name:'title',index:'title', width:150,editable:true,editrules:{required:true}},
				{name:'text',index:'text', width:250,editable:true,edittype:'textarea',editoptions: {rows:'20',cols:'60'},hidden:true, editrules:{edithidden:true} },
				{name:'location',index:'location', width:100,editable:true},
				{name:'event_date',index:'event_date', width:50,searchrules:{dataInit: function(elem) {\$(elem).datepicker()}}, search:true},
 				{name:'username',index:'username', width:60},
				"
		));
		$JQGrid->setRowNum($this->gridDimensions['events']['per_page']);
		$JQGrid->setMType("POST");
		$JQGrid->setRowList($this->gridDimensions['events']['row_list']);
		$JQGrid->setPager("#eventspager");
		$JQGrid->setMultiselect("true");
		$JQGrid->setSortName("id");
		$JQGrid->setViewRecords("true");
		// //$JQGrid->setToolbar('true,"top"');
		$JQGrid->setSortOrder("desc");
		$JQGrid->setCaption("Events");

		$JQGrid->setOnSelectRow(' function(ids) {
		if(ids == null) {
			ids=0;
			if(jQuery("#events_comments").jqGrid("getGridParam","records") >0 )
			{
				jQuery("#events_comments").jqGrid("setGridParam",{url:"index_admin.php?route=users_interaction&action=event_comments&id="+ids,datatype:"json"}).trigger("reloadGrid");
			}
		} else {
			jQuery("#events_comments").jqGrid("setGridParam",{url:"index_admin.php?route=users_interaction&action=event_comments&id="+ids, datatype: "json"}).trigger("reloadGrid");
		}
	}');
		$JQGrid->setCustom('jQuery("#events").jqGrid("navGrid","#eventspager",{edit:true,add:false,del:true},{
      // afterSubmit: function () {  $("#events").trigger("reloadGrid") },
				recreateForm:true,
				afterShowForm:  function (formid) {
$("textarea").tinymce({
			script_url : "resources/js/tiny_mce/tiny_mce.js",

			theme : "simple",editor_deselector : "mceNoEditor",
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			//content_css : "css/content.css",

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",

			// Replace values for the template plugin
			template_replace_values : {
				username : "Some User",
				staffid : "991234"
			}
		});
	 },
        closeAfterAdd: true,
        closeAfterEdit: true,
        reloadAfterSubmit:true,
    },
    {
     //   afterSubmit: function () {  $("#events").trigger("reloadGrid")},
				recreateForm:true,
				afterShowForm:  function (formid) {
$("textarea").tinymce({
			script_url : "resources/js/tiny_mce/tiny_mce.js",

			theme : "simple",editor_deselector : "mceNoEditor",
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			//content_css : "css/content.css",

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",

			// Replace values for the template plugin
			template_replace_values : {
				username : "Some User",
				staffid : "991234"
			}
		});
	 },

        closeAfterAdd: true,
        closeAfterEdit: true,
        reloadAfterSubmit:true,
    },
    {
        closeAfterAdd: true,
        closeAfterEdit: true,
        reloadAfterSubmit:true
    },{reloadAfterSubmit:true},{},
{multipleSearch:true, multipleGroup:true})');
		$this->view->assign('grid', $JQGrid->generateGrid());

		$JQGrid = NULL;
		$JQGrid = new JQGrid();
		// $JQGrid->setAntets("var lastsel;");
		$JQGrid->setElementId("events_comments");
		$JQGrid->setEditUrl("index_admin.php?route=users_interaction&action=manage_event_comments");
		$JQGrid->setWidth($this->gridDimensions['events_comments']['width']);
		$JQGrid->setHeight($this->gridDimensions['events_comments']['height']);
		$JQGrid->setDataType("json");
		$JQGrid->setColNames(array(
				'Id',
				'Comment',
				'User'
		));
		$JQGrid->setColModel(array(
				"{name:'id',index:'id', width:25,searchrules:{integer:true},hidden:" . $this->gridDimensions['events_comments']['id_hidden'] . "},
				{name:'comment',index:'comment', width:150,editable:true,edittype:'textarea',editoptions: {rows:'20',cols:'40'}},
				{name:'username',index:'username', width:60 },
				"
		));
		$JQGrid->setRowNum($this->gridDimensions['events_comments']['per_page']);
		$JQGrid->setMType("POST");
		$JQGrid->setRowList($this->gridDimensions['events_comments']['row_list']);
		$JQGrid->setPager("#events_commentspager");
		$JQGrid->setMultiselect("true");
		$JQGrid->setSortName("id");
		$JQGrid->setViewRecords("true");
		$JQGrid->setSortOrder("desc");
		$JQGrid->setCaption("Comments");
		$JQGrid->setLoadonce("true");
		$JQGrid->setCustom('jQuery("#events_comments").jqGrid("navGrid","#events_commentspager",{edit:true,add:false,del:true},{
    //   afterSubmit: function () {  $("#events").trigger("reloadGrid")},
				recreateForm:true,

				afterShowForm:  function (formid) {
$("textarea").tinymce({
			script_url : "resources/js/tiny_mce/tiny_mce.js",

			theme : "simple",editor_deselector : "mceNoEditor",
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			//content_css : "css/content.css",

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",

			// Replace values for the template plugin
			template_replace_values : {
				username : "Some User",
				staffid : "991234"
			}
		});
	 },
        closeAfterAdd: true,
        closeAfterEdit: true,
        reloadAfterSubmit:true,
    },
    {
       // afterSubmit: function () {  $("#events").trigger("reloadGrid")},
				recreateForm:true,
				afterShowForm:  function (formid) {
$("textarea").tinymce({
			script_url : "resources/js/tiny_mce/tiny_mce.js",

			theme : "simple",editor_deselector : "mceNoEditor",
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			//content_css : "css/content.css",

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",

			// Replace values for the template plugin
			template_replace_values : {
				username : "Some User",
				staffid : "991234"
			}
		});
	 },

        closeAfterAdd: true,
        closeAfterEdit: true,
        reloadAfterSubmit:true,
    },
    {
        closeAfterAdd: true,
        closeAfterEdit: true,
        reloadAfterSubmit:true
    },{reloadAfterSubmit:true},{reloadAfterSubmit:true},{},
{multipleSearch:true, multipleGroup:true});');

		$this->view->assign('grid_comments', $JQGrid->generateGrid());

		$this->view->assign('eventsText', $this->Registry->language['events_page_left_text']);
		unset($JQGrid);
		unset($this->Registry->language);
		$this->view->display('events.tpl');
	}
	function manageEvent() {
		$this->POST = $this->Registry->POST;
		$this->GET = $this->Registry->GET;
		unset($this->Registry->POST);
		unset($this->Registry->GET);
		if(isset($this->POST['oper'])) {
			if($this->POST['oper'] == 'edit') {
				unset($this->POST['oper']);
				$this->Id = $this->POST['id'];
				unset($this->POST['id']);
				$this->model->UpdateEvent($this->POST, $this->Id);
				unset($this->POST);
			} else {
				unset($this->POST['oper']);
				$this->Id = $this->POST['id'];
				if(strpos($this->Id, ',') !== FALSE) {
					$ids = explode(',', $this->POST['id']);
					unset($this->POST['id']);
					foreach($ids as $k => $v) {
						$this->model->DeleteEvent($v);
					}
					unset($this->POST);
				} else {
					unset($this->POST['id']);
					$this->model->DeleteEvent($this->Id);
					unset($this->POST);
				}
			}
		}
	}
	function eventComments() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);

		$result = $this->model->getEventComments($this->GET['id']);
		$to_json['page'] = '1';
		$to_json['total'] = '5';
		$to_json['records'] = 15;
		$i = 0;
		foreach($result as $k => $v) {
			$to_json['rows'][$i]['id'] = $v->id;
			$to_json['rows'][$i]['cell'] = array(
					$v->id,
					$v->comment,
					$v->username
			);
			$i ++;
		}

		echo json_encode($to_json);
	}
	function manageEventComments() {
		$this->POST = $this->Registry->POST;
		$this->GET = $this->Registry->GET;
		unset($this->Registry->POST);
		unset($this->Registry->GET);
		if(isset($this->POST['oper'])) {
			if($this->POST['oper'] == 'edit') {
				unset($this->POST['oper']);
				$this->Id = $this->POST['id'];
				unset($this->POST['id']);
				$this->model->updateEventComment($this->POST, $this->Id);
				unset($this->POST);
			} else {
				unset($this->POST['oper']);
				$this->Id = $this->POST['id'];
				if(strpos($this->Id, ',') !== FALSE) {
					$ids = explode(',', $this->POST['id']);
					unset($this->POST['id']);
					foreach($ids as $k => $v) {
						$this->model->deleteEventComment($v);
					}
					unset($this->POST);
				} else {
					unset($this->POST['id']);
					$this->model->deleteEventComment($this->Id);
					unset($this->POST);
				}
			}
		}
	}
	function getBlogs() {
		(new \SplAutoloader('lib\JQGrid', array(
				'lib\JQGrid'
		)) )->register();

		$JQGrid = new JQGrid();

		$JQGrid->setAntets("var lastsel;");

		$JQGrid->setElementId("blogs");

		$JQGrid->setEditUrl("index_admin.php?route=users_interaction&action=manage_blog");
		$JQGrid->setWidth($this->gridDimensions['blogs']['width']);
		$JQGrid->setHeight($this->gridDimensions['blogs']['height']);
		$JQGrid->setDataType("local");
		$JQGrid->setData(json_encode($this->model->getBlogs()));
		$JQGrid->setColNames(array(
				'Id',
				'Title',
				'Text',
				'User'
		));
		$JQGrid->setColModel(array(
				"{name:'id',index:'id', width:20,hidden:" . $this->gridDimensions['blogs']['id_hidden'] . "},
				{name:'title',index:'title', width:150,editable:true,editrules:{required:true}},
				{name:'text',index:'text', width:150,editable:true,  edittype:'textarea',editoptions: {rows:'20',cols:'60'},hidden:true, editrules:{edithidden:true} },
 				{name:'username',index:'username', width:60},
				"
		));
		$JQGrid->setRowNum($this->gridDimensions['blogs']['per_page']);
		$JQGrid->setMType("POST");
		$JQGrid->setRowList($this->gridDimensions['blogs']['row_list']);
		$JQGrid->setPager("#blogspager");
		$JQGrid->setMultiselect("true");
		$JQGrid->setSortName("id");
		$JQGrid->setViewRecords("true");
		// //$JQGrid->setToolbar('true,"top"');
		$JQGrid->setSortOrder("desc");
		$JQGrid->setCaption("Blogs");
		$JQGrid->setOnSelectRow(' function(ids) {
		if(ids == null) {
			ids=0;
			if(jQuery("#blogs_comments").jqGrid("getGridParam","records") >0 )
			{
				jQuery("#blogs_comments").jqGrid("setGridParam",{url:"index_admin.php?route=users_interaction&action=blog_comments&id="+ids,datatype:"json"}).trigger("reloadGrid");
			}
		} else {
			jQuery("#blogs_comments").jqGrid("setGridParam",{url:"index_admin.php?route=users_interaction&action=blog_comments&id="+ids, datatype: "json"}).trigger("reloadGrid");
		}
	}');
		$JQGrid->setCustom('jQuery("#blogs").jqGrid("navGrid","#blogspager",{edit:true,add:false,del:true},{
    //   afterSubmit: function () {  $("#events").trigger("reloadGrid")},
				recreateForm:true,

				afterShowForm:  function (formid) {
$("textarea").tinymce({
			script_url : "resources/js/tiny_mce/tiny_mce.js",

			theme : "simple",editor_deselector : "mceNoEditor",
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			//content_css : "css/content.css",

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",

			// Replace values for the template plugin
			template_replace_values : {
				username : "Some User",
				staffid : "991234"
			}
		});
	 },
        closeAfterAdd: true,
        closeAfterEdit: true,
        reloadAfterSubmit:true,
    },
    {
       // afterSubmit: function () {  $("#events").trigger("reloadGrid")},
				recreateForm:true,
				afterShowForm:  function (formid) {
$("textarea").tinymce({
			script_url : "resources/js/tiny_mce/tiny_mce.js",

			theme : "simple",editor_deselector : "mceNoEditor",
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			//content_css : "css/content.css",

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",

			// Replace values for the template plugin
			template_replace_values : {
				username : "Some User",
				staffid : "991234"
			}
		});
	 },

        closeAfterAdd: true,
        closeAfterEdit: true,
        reloadAfterSubmit:true,
    },
    {
        closeAfterAdd: true,
        closeAfterEdit: true,
        reloadAfterSubmit:true
    },{reloadAfterSubmit:true},{},
{multipleSearch:true, multipleGroup:true});');
		$this->view->assign('grid', $JQGrid->generateGrid());

		$JQGrid = NULL;
		$JQGrid = new JQGrid();
		// $JQGrid->setAntets("var lastsel;");
		$JQGrid->setElementId("blogs_comments");

		// $JQGrid->setUrl("index_admin.php?route=users_interaction&action=blog_comments&id=2");
		$JQGrid->setEditUrl("index_admin.php?route=users_interaction&action=manage_blog_comments");
		$JQGrid->setWidth($this->gridDimensions['blogs_comments']['width']);
		$JQGrid->setHeight($this->gridDimensions['blogs_comments']['height']);
		// $JQGrid->setData();
		// $JQGrid->setData('');
		$JQGrid->setDataType("local");
		$JQGrid->setColNames(array(
				'Id',
				'Comment',
				'User'
		));
		$JQGrid->setColModel(array(
				"{name:'id',index:'id', width:20,hidden:" . $this->gridDimensions['blogs_comments']['id_hidden'] . "},
				{name:'comment',index:'comment', width:150,editable:true,edittype:'textarea',editoptions: {rows:'20',cols:'40'}},
				{name:'username',index:'username', width:60 },
				"
		));
		$JQGrid->setRowNum($this->gridDimensions['blogs_comments']['per_page']);
		$JQGrid->setMType("POST");
		$JQGrid->setRowList($this->gridDimensions['blogs_comments']['row_list']);
		$JQGrid->setPager("#blogs_commentspager");
		$JQGrid->setMultiselect("true");
		$JQGrid->setSortName("id");
		$JQGrid->setViewRecords("true");
		$JQGrid->setSortOrder("desc");
		$JQGrid->setCaption("Comments");
		$JQGrid->setLoadonce("true");
		$JQGrid->setCustom('jQuery("#blogs_comments").jqGrid("navGrid","#blogs_commentspager",{edit:true,add:false,del:true},{
    //   afterSubmit: function () {  $("#events").trigger("reloadGrid")},
				recreateForm:true,

				afterShowForm:  function (formid) {
$("textarea").tinymce({
			script_url : "resources/js/tiny_mce/tiny_mce.js",

			theme : "simple",editor_deselector : "mceNoEditor",
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			//content_css : "css/content.css",

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",

			// Replace values for the template plugin
			template_replace_values : {
				username : "Some User",
				staffid : "991234"
			}
		});
	 },
        closeAfterAdd: true,
        closeAfterEdit: true,
        reloadAfterSubmit:true,
    },
    {
       // afterSubmit: function () {  $("#events").trigger("reloadGrid")},
				recreateForm:true,
				afterShowForm:  function (formid) {
$("textarea").tinymce({
			script_url : "resources/js/tiny_mce/tiny_mce.js",

			theme : "simple",editor_deselector : "mceNoEditor",
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			//content_css : "css/content.css",

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",

			// Replace values for the template plugin
			template_replace_values : {
				username : "Some User",
				staffid : "991234"
			}
		});
	 },

        closeAfterAdd: true,
        closeAfterEdit: true,
        reloadAfterSubmit:true,
    },
    {
        closeAfterAdd: true,
        closeAfterEdit: true,
        reloadAfterSubmit:true
    },{reloadAfterSubmit:true},{},
{multipleSearch:true, multipleGroup:true});');

		$this->view->assign('grid_comments', $JQGrid->generateGrid());

		$this->view->assign('blogsText', $this->Registry->language['blogs_page_left_text']);
		unset($JQGrid);
		unset($this->Registry->language);
		$this->view->display('blogs.tpl');
	}
	function manageBlog() {
		$this->POST = $this->Registry->POST;
		$this->GET = $this->Registry->GET;
		unset($this->Registry->POST);
		unset($this->Registry->GET);
		if(isset($this->POST['oper'])) {
			if($this->POST['oper'] == 'edit') {
				unset($this->POST['oper']);
				$this->Id = $this->POST['id'];
				unset($this->POST['id']);
				$this->model->UpdateBlog($this->POST, $this->Id);
				unset($this->POST);
			} else {
				unset($this->POST['oper']);
				$this->Id = $this->POST['id'];
				if(strpos($this->Id, ',') !== FALSE) {
					$ids = explode(',', $this->POST['id']);
					unset($this->POST['id']);
					foreach($ids as $k => $v) {
						$this->model->DeleteBlog($v);
					}
					unset($this->POST);
				} else {
					unset($this->POST['id']);
					$this->model->DeleteBlog($this->Id);
					unset($this->POST);
				}
			}
		}
	}
	function blogComments() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);

		$result = $this->model->getBlogComments($this->GET['id']);
		$to_json['page'] = '1';
		$to_json['total'] = '5';
		$to_json['records'] = 15;
		$i = 0;
		foreach($result as $k => $v) {
			$to_json['rows'][$i]['id'] = $v->id;
			$to_json['rows'][$i]['cell'] = array(
					$v->id,
					$v->comment,
					$v->username
			);
			$i ++;
		}

		echo json_encode($to_json);
	}
	function manageBlogComments() {
		$this->POST = $this->Registry->POST;
		$this->GET = $this->Registry->GET;
		unset($this->Registry->POST);
		unset($this->Registry->GET);
		if(isset($this->POST['oper'])) {
			if($this->POST['oper'] == 'edit') {
				unset($this->POST['oper']);
				$this->Id = $this->POST['id'];
				unset($this->POST['id']);
				$this->model->updateBlogComment($this->POST, $this->Id);
				unset($this->POST);
			} else {
				unset($this->POST['oper']);
				$this->Id = $this->POST['id'];
				if(strpos($this->Id, ',') !== FALSE) {
					$ids = explode(',', $this->POST['id']);
					unset($this->POST['id']);
					foreach($ids as $k => $v) {
						$this->model->deleteBlogComment($v);
					}
					unset($this->POST);
				} else {
					unset($this->POST['id']);
					$this->model->deleteBlogComment($this->Id);
					unset($this->POST);
				}
			}
		}
	}
	function getGroups() {
		(new \SplAutoloader('lib\JQGrid', array(
				'lib\JQGrid'
		)) )->register();

		$JQGrid = new JQGrid();

		$JQGrid->setAntets("var lastsel;");

		$JQGrid->setElementId("groups");

		$JQGrid->setEditUrl("index_admin.php?route=users_interaction&action=get_groups");
		$JQGrid->setWidth($this->gridDimensions['groups']['width']);
		$JQGrid->setHeight($this->gridDimensions['groups']['height']);
		$JQGrid->setDataType("local");
		$JQGrid->setData(json_encode($this->model->getGroups()));
		$JQGrid->setColNames(array(
				'Id',
				'Name',
				'Description',
				'Location',
				'User'
		));
		$JQGrid->setColModel(array(
				"{name:'id',index:'id', width:20,hidden:" . $this->gridDimensions['groups']['id_hidden'] . "},
				{name:'group_name',index:'group_name', width:200,editable:true,editrules:{required:true}},
				{name:'group_description',index:'group_description', width:150,editable:true,edittype:'textarea',editoptions: {rows:'20',cols:'60'} },
				{name:'group_location',index:'group_location', width:120,editable:true},
 				{name:'username',index:'username', width:120},
				"
		));
		$JQGrid->setRowNum($this->gridDimensions['groups']['per_page']);
		$JQGrid->setMType("POST");
		$JQGrid->setRowList($this->gridDimensions['groups']['row_list']);
		$JQGrid->setPager("#groupspager");
		$JQGrid->setMultiselect("true");
		$JQGrid->setSortName("id");
		$JQGrid->setViewRecords("true");
		// //$JQGrid->setToolbar('true,"top"');
		$JQGrid->setSortOrder("desc");
		$JQGrid->setCaption("Groups");
		$JQGrid->setOnSelectRow(' function(ids) {
		if(ids == null) {
			ids=0;
			if(jQuery("#groups_blogs").jqGrid("getGridParam","records") >0 )
			{
				jQuery("#groups_blogs").jqGrid("setGridParam",{url:"index_admin.php?route=users_interaction&action=groups_blogs&id="+ids,datatype:"json"}).trigger("reloadGrid");
			}
				if(jQuery("#groups_images").jqGrid("getGridParam","records") >0 )
			{
				jQuery("#groups_images").jqGrid("setGridParam",{url:"index_admin.php?route=users_interaction&action=groups_images&id="+ids,datatype:"json"}).trigger("reloadGrid");
			}
				if(jQuery("#groups_events").jqGrid("getGridParam","records") >0 )
			{
				jQuery("#groups_events").jqGrid("setGridParam",{url:"index_admin.php?route=users_interaction&action=groups_events&id="+ids,datatype:"json"}).trigger("reloadGrid");
			}
		}
	else {
			jQuery("#groups_blogs").jqGrid("setGridParam",{url:"index_admin.php?route=users_interaction&action=groups_blogs&id="+ids, datatype: "json"}).trigger("reloadGrid");
				jQuery("#groups_images").jqGrid("setGridParam",{url:"index_admin.php?route=users_interaction&action=groups_images&id="+ids, datatype: "json"}).trigger("reloadGrid");
				jQuery("#groups_events").jqGrid("setGridParam",{url:"index_admin.php?route=users_interaction&action=groups_events&id="+ids, datatype: "json"}).trigger("reloadGrid");
		}



	}');
		$JQGrid->setCustom('jQuery("#groups").jqGrid("navGrid","#groupspager",{edit:true,add:false,del:true},{reloadAfterSubmit:true},{reloadAfterSubmit:true},{},
{multipleSearch:true, multipleGroup:true});');
		$this->view->assign('grid', $JQGrid->generateGrid());

		$JQGrid = NULL;
		$JQGrid = new JQGrid();
		$JQGrid->setElementId("groups_blogs");
		$JQGrid->setEditUrl("index_admin.php?route=users_interaction&action=manage_groups_blogs");
		$JQGrid->setWidth($this->gridDimensions['groups_blogs']['width']);
		$JQGrid->setHeight($this->gridDimensions['groups_blogs']['height']);
		$JQGrid->setDataType("local");
		$JQGrid->setColNames(array(
				'Id',
				'Title',
				'Text',
				'User'
		));
		$JQGrid->setColModel(array(
				"{name:'id',index:'id', width:20,hidden:" . $this->gridDimensions['groups_blogs']['id_hidden'] . "},
				{name:'title',index:'title', width:150,editable:true},
				{name:'text',index:'text', width:150,editable:true,edittype:'textarea',editoptions: {rows:'20',cols:'60'},hidden:true, editrules:{edithidden:true} },
				{name:'username',index:'username', width:60 },
				"
		));
		$JQGrid->setRowNum($this->gridDimensions['groups_blogs']['per_page']);
		$JQGrid->setMType("POST");
		$JQGrid->setRowList($this->gridDimensions['groups_blogs']['row_list']);
		$JQGrid->setPager("#groups_blogspager");
		$JQGrid->setMultiselect("true");
		$JQGrid->setSortName("id");
		$JQGrid->setViewRecords("true");
		$JQGrid->setSortOrder("desc");
		$JQGrid->setCaption("Groups Blogs");
		$JQGrid->setLoadonce("true");
		$JQGrid->setCustom('jQuery("#groups_blogs").jqGrid("navGrid","#groups_blogspager",{edit:true,add:false,del:true},{
    //   afterSubmit: function () {  $("#events").trigger("reloadGrid")},
				recreateForm:true,

				afterShowForm:  function (formid) {
$("textarea").tinymce({
			script_url : "resources/js/tiny_mce/tiny_mce.js",

			theme : "simple",editor_deselector : "mceNoEditor",
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			//content_css : "css/content.css",

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",

			// Replace values for the template plugin
			template_replace_values : {
				username : "Some User",
				staffid : "991234"
			}
		});
	 },
        closeAfterAdd: true,
        closeAfterEdit: true,
        reloadAfterSubmit:true

    },{reloadAfterSubmit:true},{},
{multipleSearch:true, multipleGroup:true});');
		$this->view->assign('grid_groups_blogs', $JQGrid->generateGrid());

		$JQGrid = NULL;
		$JQGrid = new JQGrid();
		$JQGrid->setElementId("groups_images");
		$JQGrid->setEditUrl("index_admin.php?route=users_interaction&action=manage_groups_images");
		$JQGrid->setWidth($this->gridDimensions['groups_images']['width']);
		$JQGrid->setHeight($this->gridDimensions['groups_images']['height']);
		$JQGrid->setDataType("local");
		$JQGrid->setColNames(array(
				'Id',
				'Picture',
				'Description',
				'User'
		));
		$JQGrid->setColModel(array(
				"{name:'id',index:'id', width:20,hidden:" . $this->gridDimensions['groups_images']['id_hidden'] . "},
				{name:'pic_name',index:'pic_name', width:150,editable:true},
				{name:'pic_description',index:'pic_description', width:150,editable:true},
				{name:'username',index:'username', width:60 },
				"
		));
		$JQGrid->setRowNum($this->gridDimensions['groups_images']['per_page']);
		$JQGrid->setMType("POST");
		$JQGrid->setRowList($this->gridDimensions['groups_images']['row_list']);
		$JQGrid->setPager("#groups_imagespager");
		$JQGrid->setMultiselect("true");
		$JQGrid->setSortName("id");
		$JQGrid->setViewRecords("true");
		$JQGrid->setSortOrder("desc");
		$JQGrid->setCaption("Groups Images");
		$JQGrid->setLoadonce("true");
		$JQGrid->setCustom('jQuery("#groups_images").jqGrid("navGrid","#groups_imagespager",{edit:true,add:false,del:true},{reloadAfterSubmit:true},{reloadAfterSubmit:true},{},
{multipleSearch:true, multipleGroup:true});');
		$this->view->assign('grid_groups_images', $JQGrid->generateGrid());

		$JQGrid = NULL;
		$JQGrid = new JQGrid();
		$JQGrid->setElementId("groups_events");
		$JQGrid->setEditUrl("index_admin.php?route=users_interaction&action=manage_groups_events");
		$JQGrid->setWidth($this->gridDimensions['groups_events']['width']);
		$JQGrid->setHeight($this->gridDimensions['groups_events']['height']);
		$JQGrid->setDataType("local");
		$JQGrid->setColNames(array(
				'Id',
				'Title',
				'Text',
				'Location',
				'Date',
				'User'
		));
		$JQGrid->setColModel(array(
				"{name:'id',index:'id', width:20,hidden:" . $this->gridDimensions['groups_events']['id_hidden'] . "},
				{name:'title',index:'title', width:150,editable:true},
				{name:'text',index:'text', width:100,editable:true,edittype:'textarea',editoptions: {rows:'20',cols:'60'},hidden:true, editrules:{edithidden:true} },
				{name:'location',index:'location', width:100,editable:true},
				{name:'event_date',index:'event_date', width:60,editable:true},
				{name:'username',index:'username', width:60 },
				"
		));
		$JQGrid->setRowNum($this->gridDimensions['groups_events']['per_page']);
		$JQGrid->setMType("POST");
		$JQGrid->setRowList($this->gridDimensions['groups_events']['row_list']);
		$JQGrid->setPager("#groups_eventspager");
		$JQGrid->setMultiselect("true");
		$JQGrid->setSortName("id");
		$JQGrid->setViewRecords("true");
		$JQGrid->setSortOrder("desc");
		$JQGrid->setCaption("Groups Events");
		$JQGrid->setLoadonce("true");
		$JQGrid->setCustom('jQuery("#groups_events").jqGrid("navGrid","#groups_eventspager",{edit:true,add:false,del:true},{
    //   afterSubmit: function () {  $("#events").trigger("reloadGrid")},
				recreateForm:true,

				afterShowForm:  function (formid) {
$("textarea").tinymce({
			script_url : "resources/js/tiny_mce/tiny_mce.js",

			theme : "simple",editor_deselector : "mceNoEditor",
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			//content_css : "css/content.css",

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",

			// Replace values for the template plugin
			template_replace_values : {
				username : "Some User",
				staffid : "991234"
			}
		});
	 },
        closeAfterAdd: true,
        closeAfterEdit: true,
        reloadAfterSubmit:true,

    },
    {reloadAfterSubmit:true},{},
{multipleSearch:true, multipleGroup:true});');
		$this->view->assign('grid_groups_events', $JQGrid->generateGrid());

		$this->view->assign('groupsText', $this->Registry->language['groups_page_left_text']);
		unset($JQGrid);
		unset($this->Registry->language);
		$this->view->display('groups.tpl');
	}
	function groupsBlogs() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);

		$result = $this->model->getGroupsBlogs($this->GET['id']);
		$to_json['page'] = '1';
		$to_json['total'] = '5';
		$to_json['records'] = 15;
		$i = 0;
		foreach($result as $k => $v) {
			$to_json['rows'][$i]['id'] = $v->id;
			$to_json['rows'][$i]['cell'] = array(
					$v->id,
					$v->title,
					$v->text,
					$v->username
			);
			$i ++;
		}

		echo json_encode($to_json);
	}
	function groupsImages() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);

		$result = $this->model->getGroupsImages($this->GET['id']);
		$to_json['page'] = '1';
		$to_json['total'] = '5';
		$to_json['records'] = 15;
		$i = 0;
		foreach($result as $k => $v) {
			$to_json['rows'][$i]['id'] = $v->id;
			$to_json['rows'][$i]['cell'] = array(
					$v->id,
					$v->pic_name,
					$v->pic_description
			);
			$i ++;
		}

		echo json_encode($to_json);
	}
	function groupsEvents() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);

		$result = $this->model->getGroupsEvents($this->GET['id']);
		$to_json['page'] = '1';
		$to_json['total'] = '5';
		$to_json['records'] = 15;
		$i = 0;
		foreach($result as $k => $v) {
			$to_json['rows'][$i]['id'] = $v->id;
			$to_json['rows'][$i]['cell'] = array(
					$v->id,
					$v->title,
					$v->text,
					$v->location,
					$v->event_date,
					$v->username
			);
			$i ++;
		}

		echo json_encode($to_json);
	}
	function manageGroupsBlogs() {
		$this->POST = $this->Registry->POST;
		$this->GET = $this->Registry->GET;
		unset($this->Registry->POST);
		unset($this->Registry->GET);
		if(isset($this->POST['oper'])) {
			if($this->POST['oper'] == 'edit') {
				unset($this->POST['oper']);
				$this->Id = $this->POST['id'];
				unset($this->POST['id']);
				$this->model->updateGroupBlog($this->POST, $this->Id);
				unset($this->POST);
			} else {
				unset($this->POST['oper']);
				$this->Id = $this->POST['id'];
				if(strpos($this->Id, ',') !== FALSE) {
					$ids = explode(',', $this->POST['id']);
					unset($this->POST['id']);
					foreach($ids as $k => $v) {
						$this->model->deleteGroupBlog($v);
					}
					unset($this->POST);
				} else {
					unset($this->POST['id']);
					$this->model->deleteGroupBlog($this->Id);
					unset($this->POST);
				}
			}
		}
	}
	function manageGroupsImages() {
		$this->POST = $this->Registry->POST;
		$this->GET = $this->Registry->GET;
		unset($this->Registry->POST);
		unset($this->Registry->GET);
		if(isset($this->POST['oper'])) {
			if($this->POST['oper'] == 'edit') {
				unset($this->POST['oper']);
				$this->Id = $this->POST['id'];
				unset($this->POST['id']);
				$this->model->updateGroupImage($this->POST, $this->Id);
				unset($this->POST);
			} else {
				unset($this->POST['oper']);
				$this->Id = $this->POST['id'];
				if(strpos($this->Id, ',') !== FALSE) {
					$ids = explode(',', $this->POST['id']);
					unset($this->POST['id']);
					foreach($ids as $k => $v) {
						$this->model->deleteGroupImage($v);
					}
					unset($this->POST);
				} else {
					unset($this->POST['id']);
					$this->model->deleteGroupImage($this->Id);
					unset($this->POST);
				}
			}
		}
	}
	function manageGroupsEvents() {
		$this->POST = $this->Registry->POST;
		$this->GET = $this->Registry->GET;
		unset($this->Registry->POST);
		unset($this->Registry->GET);
		if(isset($this->POST['oper'])) {
			if($this->POST['oper'] == 'edit') {
				unset($this->POST['oper']);
				$this->Id = $this->POST['id'];
				unset($this->POST['id']);
				$this->model->updateGroupEvent($this->POST, $this->Id);
				unset($this->POST);
			} else {
				unset($this->POST['oper']);
				$this->Id = $this->POST['id'];
				if(strpos($this->Id, ',') !== FALSE) {
					$ids = explode(',', $this->POST['id']);
					unset($this->POST['id']);
					foreach($ids as $k => $v) {
						$this->model->deleteGroupEvent($v);
					}
					unset($this->POST);
				} else {
					unset($this->POST['id']);
					$this->model->deleteGroupEvent($this->Id);
					unset($this->POST);
				}
			}
		}
	}
	function getTrade() {
		(new \SplAutoloader('lib\JQGrid', array(
				'lib\JQGrid'
		)) )->register();

		$JQGrid = new JQGrid();

		$JQGrid->setAntets("var lastsel;");

		$JQGrid->setElementId("trade");

		$JQGrid->setEditUrl("index_admin.php?route=users_interaction&action=get_trade");
		$JQGrid->setWidth($this->gridDimensions['trade']['width']);
		$JQGrid->setHeight($this->gridDimensions['trade']['height']);
		$JQGrid->setDataType("local");
		$JQGrid->setData(json_encode($this->model->getTrade()));
		$JQGrid->setColNames(array(
				'Id',
				'Title',
				'Text',
				'User'
		));
		$JQGrid->setColModel(array(
				"{name:'id',index:'id', width:20,hidden:" . $this->gridDimensions['groups']['id_hidden'] . "},
				{name:'title',index:'title', width:200,editable:true,editrules:{required:true}},
				{name:'text',index:'text', width:150,editable:true,edittype:'textarea',editoptions: {rows:'20',cols:'60'} },
 				{name:'username',index:'username', width:120},
				"
		));
		$JQGrid->setRowNum($this->gridDimensions['trade']['per_page']);
		$JQGrid->setMType("POST");
		$JQGrid->setRowList($this->gridDimensions['trade']['row_list']);
		$JQGrid->setPager("#tradepager");
		$JQGrid->setMultiselect("true");
		$JQGrid->setSortName("id");
		$JQGrid->setViewRecords("true");
		// //$JQGrid->setToolbar('true,"top"');
		$JQGrid->setSortOrder("desc");
		$JQGrid->setCaption("Trade");
		$JQGrid->setOnSelectRow(' function(ids) {
		if(ids == null) {
			ids=0;
			if(jQuery("#trade_questions").jqGrid("getGridParam","records") >0 )
			{
				jQuery("#trade_questions").jqGrid("setGridParam",{url:"index_admin.php?route=users_interaction&action=get_trade_questions&id="+ids,datatype:"json"}).trigger("reloadGrid");
			}

		}
	else {
			jQuery("#trade_questions").jqGrid("setGridParam",{url:"index_admin.php?route=users_interaction&action=get_trade_questions&id="+ids, datatype: "json"}).trigger("reloadGrid");

		}



	}');
		$JQGrid->setCustom('jQuery("#trade").jqGrid("navGrid","#tradepager",{edit:true,add:false,del:true},{
    //   afterSubmit: function () {  $("#events").trigger("reloadGrid")},
				recreateForm:true,

				afterShowForm:  function (formid) {
$("textarea").tinymce({
			script_url : "resources/js/tiny_mce/tiny_mce.js",

			theme : "simple",editor_deselector : "mceNoEditor",
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			//content_css : "css/content.css",

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",

			// Replace values for the template plugin
			template_replace_values : {
				username : "Some User",
				staffid : "991234"
			}
		});
	 },
        closeAfterAdd: true,
        closeAfterEdit: true,
        reloadAfterSubmit:true,
    },
    {
       // afterSubmit: function () {  $("#events").trigger("reloadGrid")},
				recreateForm:true,
				afterShowForm:  function (formid) {
$("textarea").tinymce({
			script_url : "resources/js/tiny_mce/tiny_mce.js",

			theme : "simple",editor_deselector : "mceNoEditor",
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			//content_css : "css/content.css",

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",

			// Replace values for the template plugin
			template_replace_values : {
				username : "Some User",
				staffid : "991234"
			}
		});
	 },

        closeAfterAdd: true,
        closeAfterEdit: true,
        reloadAfterSubmit:true,
    },
    {
        closeAfterAdd: true,
        closeAfterEdit: true,
        reloadAfterSubmit:true
    },{reloadAfterSubmit:true},{},
{multipleSearch:true, multipleGroup:true});');
		$this->view->assign('grid', $JQGrid->generateGrid());

		$JQGrid = NULL;
		$JQGrid = new JQGrid();
		$JQGrid->setElementId("trade_questions");
		$JQGrid->setEditUrl("index_admin.php?route=users_interaction&action=manage_trade_questions");
		$JQGrid->setWidth($this->gridDimensions['trade_questions']['width']);
		$JQGrid->setHeight($this->gridDimensions['trade_questions']['height']);
		$JQGrid->setDataType("local");
		$JQGrid->setColNames(array(
				'Id',
				'Question',
				'User'
		));
		$JQGrid->setColModel(array(
				"{name:'id',index:'id', width:20,hidden:" . $this->gridDimensions['trade_questions']['id_hidden'] . "},
				{name:'question',index:'question', width:150,editable:true},
				{name:'username',index:'username', width:60 },
				"
		));
		$JQGrid->setRowNum($this->gridDimensions['trade_questions']['per_page']);
		$JQGrid->setMType("POST");
		$JQGrid->setRowList($this->gridDimensions['trade_questions']['row_list']);
		$JQGrid->setPager("#trade_questionspager");
		$JQGrid->setMultiselect("true");
		$JQGrid->setSortName("id");
		$JQGrid->setViewRecords("true");
		$JQGrid->setSortOrder("desc");
		$JQGrid->setCaption("Trade Questions");
		$JQGrid->setLoadonce("true");
		$JQGrid->setCustom('jQuery("#trade_questions").jqGrid("navGrid","#trade_questionspager",{edit:true,add:false,del:true},{
    //   afterSubmit: function () {  $("#events").trigger("reloadGrid")},
				recreateForm:true,

				afterShowForm:  function (formid) {
$("textarea").tinymce({
			script_url : "resources/js/tiny_mce/tiny_mce.js",

			theme : "simple",editor_deselector : "mceNoEditor",
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			//content_css : "css/content.css",

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",

			// Replace values for the template plugin
			template_replace_values : {
				username : "Some User",
				staffid : "991234"
			}
		});
	 },
        closeAfterAdd: true,
        closeAfterEdit: true,
        reloadAfterSubmit:true,
    },
    {
       // afterSubmit: function () {  $("#events").trigger("reloadGrid")},
				recreateForm:true,
				afterShowForm:  function (formid) {
$("textarea").tinymce({
			script_url : "resources/js/tiny_mce/tiny_mce.js",

			theme : "simple",editor_deselector : "mceNoEditor",
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			//content_css : "css/content.css",

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",

			// Replace values for the template plugin
			template_replace_values : {
				username : "Some User",
				staffid : "991234"
			}
		});
	 },

        closeAfterAdd: true,
        closeAfterEdit: true,
        reloadAfterSubmit:true,
    },
    {
        closeAfterAdd: true,
        closeAfterEdit: true,
        reloadAfterSubmit:true
    },{reloadAfterSubmit:true},{},
{multipleSearch:true, multipleGroup:true});');
		$this->view->assign('grid_trade_questions', $JQGrid->generateGrid());

		$this->view->assign('tradeText', $this->Registry->language['trade_page_left_text']);
		unset($JQGrid);
		unset($this->Registry->language);
		$this->view->display('trade.tpl');
	}
	function getTradeQuestions() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);

		$result = $this->model->getTradeQuestions($this->GET['id']);
		$to_json['page'] = '1';
		$to_json['total'] = '5';
		$to_json['records'] = 15;
		$i = 0;
		foreach($result as $k => $v) {
			$to_json['rows'][$i]['id'] = $v->id;
			$to_json['rows'][$i]['cell'] = array(
					$v->id,
					$v->question,
					$v->username
			);
			$i ++;
		}

		echo json_encode($to_json);
	}
	function manageTradeQuestions() {
		$this->POST = $this->Registry->POST;
		$this->GET = $this->Registry->GET;
		unset($this->Registry->POST);
		unset($this->Registry->GET);
		if(isset($this->POST['oper'])) {
			if($this->POST['oper'] == 'edit') {
				unset($this->POST['oper']);
				$this->Id = $this->POST['id'];
				unset($this->POST['id']);
				$this->model->updateTradeQuestion($this->POST, $this->Id);
				unset($this->POST);
			} else {
				unset($this->POST['oper']);
				$this->Id = $this->POST['id'];
				if(strpos($this->Id, ',') !== FALSE) {
					$ids = explode(',', $this->POST['id']);
					unset($this->POST['id']);
					foreach($ids as $k => $v) {
						$this->model->deleteTradeQuestion($v);
					}
					unset($this->POST);
				} else {
					unset($this->POST['id']);
					$this->model->deleteTradeQuestion($this->Id);
					unset($this->POST);
				}
			}
		}
	}
}

?>