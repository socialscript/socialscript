<?php
<?php

namespace controllers;

use lib\Core\Controller as Controller;
use lib\Core\Registry;
use lib\JQGrid\JQGrid;

class AdminUsersContent extends Controller {
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
	function Pictures() {
		(new \SplAutoloader('lib\JQGrid', array(
				'lib\JQGrid'
		)) )->register();
		$this->GET = $this->Registry->GET;
		$this->COOKIE = $this->Registry->COOKIE;
		unset($this->Registry->COOKIE);

		$JQGrid = new JQGrid();
		$JQGrid->setAntets("var lastsel;");
		$JQGrid->setElementId('pictures');
		// $JQGrid->setUrl("index_admin.php?route=settings");
		$JQGrid->setEditUrl("index_admin.php?route=users_content&action=manage_picture");
		$JQGrid->setWidth($this->gridDimensions['pictures']['width']);
		$JQGrid->setHeight($this->gridDimensions['pictures']['height']);
		$JQGrid->setDataType("local");
		$JQGrid->setData(json_encode($this->model->getPictures()));
		$JQGrid->setColNames(array(
				'Id',
				'Image',
				'Title',
				'Description',
				'Tags',
				'User'
		));
		$JQGrid->setColModel(array(
				"{name:'id',index:'id', width:60},
				{name:'image',index:'image', width:60},
				{name:'title',index:'title',editable:true, width:100,editrules:{required: true}},
				{name:'description',index:'text', width:200,editable:true,editrules: { edittype:'textarea'},editoptions: {rows:'10',cols:'10'} },
				{name:'tags',index:'tags',width:100,editable:true, width:100,editrules:{required: true}},
{name:'username',index:'username',width:60},
				"
		));
		$JQGrid->setRowNum($this->gridDimensions['pictures']['per_page']);
		$JQGrid->setMType("POST");
		$JQGrid->setRowList($this->gridDimensions['pictures']['row_list']);
		$JQGrid->setPager("#picturespager");
		$JQGrid->setSortName("id");
		$JQGrid->setViewRecords("true");
		// $JQGrid->setToolbar('true,"top"');
		$JQGrid->setSortOrder("desc");
		$JQGrid->setCaption('Pictures');
		$JQGrid->setMultiselect("true");
		$JQGrid->setOnSelectRow(' function(ids) {
		if(ids == null) {
			ids=0;
			if(jQuery("#pictures_comments").jqGrid("getGridParam","records") >0 )
			{
				jQuery("#pictures_comments").jqGrid("setGridParam",{url:"index_admin.php?route=users_content&action=pictures_comments&id="+ids,datatype:"json"}).trigger("reloadGrid");
				$("#picture").load("index_admin.php?route=users_content&action=view_picture&id="+ids);
			}
		} else {
			jQuery("#pictures_comments").jqGrid("setGridParam",{url:"index_admin.php?route=users_content&action=pictures_comments&id="+ids, datatype: "json"}).trigger("reloadGrid");
				$("#picture").load("index_admin.php?route=users_content&action=view_picture&id="+ids);
		}
	}');
		$JQGrid->setCustom('jQuery("#pictures").jqGrid("navGrid","#picturespager",{edit:true,add:false,del:true},{reloadAfterSubmit:false},{reloadAfterSubmit:false});');
		$JQGrid->setFormatter('function imageFormatter(cellvalue, options, rowObject) {
      //return "<img src=\'"+cellvalue+"\' />";
				return cellvalue;
  }; ');
		$this->view->assign('grid', $JQGrid->generateGrid());

		$JQGrid = NULL;
		$JQGrid = new JQGrid();
		// $JQGrid->setAntets("var lastsel;");
		$JQGrid->setElementId("pictures_comments");
		$JQGrid->setEditUrl("index_admin.php?route=users_content&action=manage_pictures_comments");
		$JQGrid->setWidth($this->gridDimensions['pictures_comments']['width']);
		$JQGrid->setHeight($this->gridDimensions['pictures_comments']['height']);
		$JQGrid->setDataType("json");
		$JQGrid->setColNames(array(
				'Id',
				'Comment',
				'User'
		));
		$JQGrid->setColModel(array(
				"{name:'id',index:'id', width:25,searchrules:{integer:true},hidden:" . $this->gridDimensions['pictures_comments']['id_hidden'] . "},
				{name:'comment',index:'comment', width:150,editable:true},
				{name:'username',index:'username', width:60 },
				"
		));
		$JQGrid->setRowNum($this->gridDimensions['pictures_comments']['per_page']);
		$JQGrid->setMType("POST");
		$JQGrid->setRowList($this->gridDimensions['pictures_comments']['row_list']);
		$JQGrid->setPager('#pictures_commentspager');
		$JQGrid->setMultiselect("true");
		$JQGrid->setSortName("id");
		$JQGrid->setViewRecords("true");
		$JQGrid->setSortOrder("desc");
		$JQGrid->setCaption("Comments");
		$JQGrid->setLoadonce("true");
		$JQGrid->setCustom('jQuery("#pictures_comments").jqGrid("navGrid","#pictures_commentspager",{edit:true,add:false,del:true},{reloadAfterSubmit:false},{reloadAfterSubmit:false},{},
{multipleSearch:true, multipleGroup:true});');

		$this->view->assign('grid_comments', $JQGrid->generateGrid());

		$this->view->assign('left_text', $this->Registry->language['pictures_page_left_text']);
		unset($JQGrid);
		unset($this->Registry->language);
		$this->view->display('pictures.tpl');
	}
	function picturesComments() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);

		$result = $this->model->getPicturesComments($this->GET['id']);
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
	function viewPicture() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		$picture = $this->model->getPicture(array(
				$this->GET['id']
		));
		echo \classes\UserPictures::getPictureForGrid($picture->user_key, $picture->file_name, md5($picture->gallery_name), 400, 300);
	}
	function managePicture() {
		$this->POST = $this->Registry->POST;
		$this->GET = $this->Registry->GET;
		unset($this->Registry->POST);
		unset($this->Registry->GET);
		if(isset($this->POST['oper'])) {
			if($this->POST['oper'] == 'edit') {
				unset($this->POST['oper']);
				$this->Id = $this->POST['id'];
				unset($this->POST['id']);
				$this->model->updatePicture($this->POST, $this->Id);
				unset($this->POST);
			} else {
				unset($this->POST['oper']);
				$this->Id = $this->POST['id'];
				if(strpos($this->Id, ',') !== FALSE) {
					$ids = explode(',', $this->POST['id']);
					unset($this->POST['id']);
					foreach($ids as $k => $v) {
						$this->model->deletePicture($v);
					}
					unset($this->POST);
				} else {
					unset($this->POST['id']);
					$this->model->deletePicture($this->Id);
					unset($this->POST);
				}
			}
		}
	}
	function managePicturesComments() {
		$this->POST = $this->Registry->POST;
		$this->GET = $this->Registry->GET;
		unset($this->Registry->POST);
		unset($this->Registry->GET);
		if(isset($this->POST['oper'])) {
			if($this->POST['oper'] == 'edit') {
				unset($this->POST['oper']);
				$this->Id = $this->POST['id'];
				unset($this->POST['id']);
				$this->model->updatePictureComments($this->POST, $this->Id);
				unset($this->POST);
			} else {
				unset($this->POST['oper']);
				$this->Id = $this->POST['id'];
				if(strpos($this->Id, ',') !== FALSE) {
					$ids = explode(',', $this->POST['id']);
					unset($this->POST['id']);
					foreach($ids as $k => $v) {
						$this->model->deletePictureComments($v);
					}
					unset($this->POST);
				} else {
					unset($this->POST['id']);
					$this->model->deletePictureComments($this->Id);
					unset($this->POST);
				}
			}
		}
	}
	function Music() {
		(new \SplAutoloader('lib\JQGrid', array(
				'lib\JQGrid'
		)) )->register();
		$this->GET = $this->Registry->GET;
		$this->COOKIE = $this->Registry->COOKIE;
		unset($this->Registry->COOKIE);

		$JQGrid = new JQGrid();
		$JQGrid->setAntets("var lastsel;");
		$JQGrid->setElementId('musics');
		// $JQGrid->setUrl("index_admin.php?route=settings");
		$JQGrid->setEditUrl("index_admin.php?route=users_content&action=manage_music");
		$JQGrid->setWidth($this->gridDimensions['music']['width']);
		$JQGrid->setHeight($this->gridDimensions['music']['height']);
		$JQGrid->setDataType("local");
		$JQGrid->setData(json_encode($this->model->getAllMusic()));
		$JQGrid->setColNames(array(
				'Id',
				'Title',
				'Description',
				'Tags',
				'User'
		));
		$JQGrid->setColModel(array(
				"{name:'id',index:'id', width:30},
				{name:'title',index:'title',editable:true, width:100,editrules:{required: true}},
				{name:'description',index:'text', width:100,editable:true,editrules: { edittype:'textarea'},editoptions: {rows:'10',cols:'10'} },
				{name:'tags',index:'tags',width:100,editable:true, width:100,editrules:{required: true}},
{name:'username',index:'username',width:60},
				"
		));
		$JQGrid->setRowNum($this->gridDimensions['music']['per_page']);
		$JQGrid->setMType("POST");
		$JQGrid->setRowList($this->gridDimensions['music']['row_list']);
		$JQGrid->setPager("#musicpager");
		$JQGrid->setSortName("id");
		$JQGrid->setViewRecords("true");
		// $JQGrid->setToolbar('true,"top"');
		$JQGrid->setSortOrder("desc");
		$JQGrid->setCaption('Music');
		$JQGrid->setMultiselect("true");
		$JQGrid->setOnSelectRow(' function(ids) {
		if(ids == null) {
			ids=0;
			if(jQuery("#music_comments").jqGrid("getGridParam","records") >0 )
			{
				jQuery("#music_comments").jqGrid("setGridParam",{url:"index_admin.php?route=users_content&action=music_comments&id="+ids,datatype:"json"}).trigger("reloadGrid");
				$("#music").load("index_admin.php?route=users_content&action=view_music&id="+ids);
			}
		} else {
			jQuery("#music_comments").jqGrid("setGridParam",{url:"index_admin.php?route=users_content&action=music_comments&id="+ids, datatype: "json"}).trigger("reloadGrid");
				$("#music").load("index_admin.php?route=users_content&action=view_music&id="+ids);
		}
	}');
		$JQGrid->setCustom('jQuery("#musics").jqGrid("navGrid","#musicpager",{edit:true,add:false,del:true},{reloadAfterSubmit:false},{reloadAfterSubmit:false});');

		$this->view->assign('grid', $JQGrid->generateGrid());

		$JQGrid = NULL;
		$JQGrid = new JQGrid();
		// $JQGrid->setAntets("var lastsel;");
		$JQGrid->setElementId("music_comments");
		$JQGrid->setEditUrl("index_admin.php?route=users_content&action=manage_music_comments");
		$JQGrid->setWidth($this->gridDimensions['music_comments']['width']);
		$JQGrid->setHeight($this->gridDimensions['music_comments']['height']);
		$JQGrid->setDataType("json");
		$JQGrid->setColNames(array(
				'Id',
				'Comment',
				'User'
		));
		$JQGrid->setColModel(array(
				"{name:'id',index:'id', width:25,searchrules:{integer:true},hidden:" . $this->gridDimensions['music_comments']['id_hidden'] . "},
				{name:'comment',index:'comment', width:150,editable:true},
				{name:'username',index:'username', width:60 },
				"
		));
		$JQGrid->setRowNum($this->gridDimensions['music_comments']['per_page']);
		$JQGrid->setMType("POST");
		$JQGrid->setRowList($this->gridDimensions['music_comments']['row_list']);
		$JQGrid->setPager('#music_commentspager');
		$JQGrid->setMultiselect("true");
		$JQGrid->setSortName("id");
		$JQGrid->setViewRecords("true");
		$JQGrid->setSortOrder("desc");
		$JQGrid->setCaption("Comments");
		$JQGrid->setLoadonce("true");
		$JQGrid->setCustom('jQuery("#music_comments").jqGrid("navGrid","#music_commentspager",{edit:true,add:false,del:true},{reloadAfterSubmit:false},{reloadAfterSubmit:false},{},
{multipleSearch:true, multipleGroup:true});');

		$this->view->assign('grid_comments', $JQGrid->generateGrid());

		$this->view->assign('left_text', $this->Registry->language['music_page_left_text']);
		unset($JQGrid);
		unset($this->Registry->language);
		$this->view->display('music.tpl');
	}
	function musicComments() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);

		$result = $this->model->getMusicComments($this->GET['id']);
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
	function viewMusic() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		$music = $this->model->getMusic(array(
				$this->GET['id']
		));

		$music_dir_path = $music->user_key . DIRECTORY_SEPARATOR . 'videos' . DIRECTORY_SEPARATOR . md5($music->gallery_name) . DIRECTORY_SEPARATOR;
		$dir_path = USER_DATA_DIR . $music_dir_path;
		$source = '';
		if(is_file($dir_path . $music->file_name . '.mp3')) {
			$source .= '<source src="' . str_replace('public/', 'data/', $this->Registry->Settings->site_url) . 'uploads/' . str_replace('\\', '/', $music_dir_path) . $music->file_name . '.mp4" type="audio/mpeg" />';
		}
		if(is_file($dir_path . $music->file_name . '.ogg')) {
			$source .= '<source src="' . str_replace('public/', 'data/', $this->Registry->Settings->site_url) . 'uploads/' . str_replace('\\', '/', $music_dir_path) . $music->file_name . '.mp4" type="audio/ogg" />';
		}

		echo '<audio controls="controls">' . $source . '
  Your browser does not support the audio element.
</audio>';
	}
	function manageMusic() {
		$this->POST = $this->Registry->POST;
		$this->GET = $this->Registry->GET;
		unset($this->Registry->POST);
		unset($this->Registry->GET);
		if(isset($this->POST['oper'])) {
			if($this->POST['oper'] == 'edit') {
				unset($this->POST['oper']);
				$this->Id = $this->POST['id'];
				unset($this->POST['id']);
				$this->model->updateMusic($this->POST, $this->Id);
				unset($this->POST);
			} else {
				unset($this->POST['oper']);
				$this->Id = $this->POST['id'];
				if(strpos($this->Id, ',') !== FALSE) {
					$ids = explode(',', $this->POST['id']);
					unset($this->POST['id']);
					foreach($ids as $k => $v) {
						$this->model->deleteMusic($v);
					}
					unset($this->POST);
				} else {
					unset($this->POST['id']);
					$this->model->deleteMusic($this->Id);
					unset($this->POST);
				}
			}
		}
	}
	function manageMusicComments() {
		$this->POST = $this->Registry->POST;
		$this->GET = $this->Registry->GET;
		unset($this->Registry->POST);
		unset($this->Registry->GET);
		if(isset($this->POST['oper'])) {
			if($this->POST['oper'] == 'edit') {
				unset($this->POST['oper']);
				$this->Id = $this->POST['id'];
				unset($this->POST['id']);
				$this->model->updateMusicComments($this->POST, $this->Id);
				unset($this->POST);
			} else {
				unset($this->POST['oper']);
				$this->Id = $this->POST['id'];
				if(strpos($this->Id, ',') !== FALSE) {
					$ids = explode(',', $this->POST['id']);
					unset($this->POST['id']);
					foreach($ids as $k => $v) {
						$this->model->deleteMusicComments($v);
					}
					unset($this->POST);
				} else {
					unset($this->POST['id']);
					$this->model->deleteMusicComments($this->Id);
					unset($this->POST);
				}
			}
		}
	}
	function Videos() {
		(new \SplAutoloader('lib\JQGrid', array(
				'lib\JQGrid'
		)) )->register();
		$this->GET = $this->Registry->GET;
		$this->COOKIE = $this->Registry->COOKIE;
		unset($this->Registry->COOKIE);

		$JQGrid = new JQGrid();
		$JQGrid->setAntets("var lastsel;");
		$JQGrid->setElementId('videos');
		// $JQGrid->setUrl("index_admin.php?route=settings");
		$JQGrid->setEditUrl("index_admin.php?route=users_content&action=manage_video");
		$JQGrid->setWidth($this->gridDimensions['videos']['width']);
		$JQGrid->setHeight($this->gridDimensions['videos']['height']);
		$JQGrid->setDataType("local");
		$JQGrid->setData(json_encode($this->model->getVideos()));
		$JQGrid->setColNames(array(
				'Id',
				'Title',
				'Description',
				'Tags',
				'User'
		));
		$JQGrid->setColModel(array(
				"{name:'id',index:'id', width:60},
				{name:'title',index:'title',editable:true, width:100,editrules:{required: true}},
				{name:'description',index:'text', width:200,editable:true,editrules: { edittype:'textarea'},editoptions: {rows:'10',cols:'10'} },
				{name:'tags',index:'tags',width:100,editable:true, width:100,editrules:{required: true}},
{name:'username',index:'username',width:60},
				"
		));
		$JQGrid->setRowNum($this->gridDimensions['videos']['per_page']);
		$JQGrid->setMType("POST");
		$JQGrid->setRowList($this->gridDimensions['videos']['row_list']);
		$JQGrid->setPager("#videospager");
		$JQGrid->setSortName("id");
		$JQGrid->setViewRecords("true");
		// $JQGrid->setToolbar('true,"top"');
		$JQGrid->setSortOrder("desc");
		$JQGrid->setCaption('Videos');
		$JQGrid->setMultiselect("true");
		$JQGrid->setOnSelectRow(' function(ids) {
		if(ids == null) {
			ids=0;
			if(jQuery("#videos_comments").jqGrid("getGridParam","records") >0 )
			{
				jQuery("#videos_comments").jqGrid("setGridParam",{url:"index_admin.php?route=users_content&action=videos_comments&id="+ids,datatype:"json"}).trigger("reloadGrid");
				$("#video").load("index_admin.php?route=users_content&action=view_video&id="+ids);
			}
		} else {
			jQuery("#videos_comments").jqGrid("setGridParam",{url:"index_admin.php?route=users_content&action=videos_comments&id="+ids, datatype: "json"}).trigger("reloadGrid");
				$("#video").load("index_admin.php?route=users_content&action=view_video&id="+ids);
		}
	}');
		$JQGrid->setCustom('jQuery("#videos").jqGrid("navGrid","#videospager",{edit:true,add:false,del:true},{reloadAfterSubmit:false},{reloadAfterSubmit:false});');
		$JQGrid->setFormatter('function imageFormatter(cellvalue, options, rowObject) {
      //return "<img src=\'"+cellvalue+"\' />";
				return cellvalue;
  }; ');
		$this->view->assign('grid', $JQGrid->generateGrid());

		$JQGrid = NULL;
		$JQGrid = new JQGrid();
		// $JQGrid->setAntets("var lastsel;");
		$JQGrid->setElementId("videos_comments");
		$JQGrid->setEditUrl("index_admin.php?route=users_content&action=manage_videos_comments");
		$JQGrid->setWidth($this->gridDimensions['videos_comments']['width']);
		$JQGrid->setHeight($this->gridDimensions['videos_comments']['height']);
		$JQGrid->setDataType("json");
		$JQGrid->setColNames(array(
				'Id',
				'Comment',
				'User'
		));
		$JQGrid->setColModel(array(
				"{name:'id',index:'id', width:25,searchrules:{integer:true},hidden:" . $this->gridDimensions['videos_comments']['id_hidden'] . "},
				{name:'comment',index:'comment', width:150,editable:true},
				{name:'username',index:'username', width:60 },
				"
		));
		$JQGrid->setRowNum($this->gridDimensions['videos_comments']['per_page']);
		$JQGrid->setMType("POST");
		$JQGrid->setRowList($this->gridDimensions['videos_comments']['row_list']);
		$JQGrid->setPager('#videos_commentspager');
		$JQGrid->setMultiselect("true");
		$JQGrid->setSortName("id");
		$JQGrid->setViewRecords("true");
		$JQGrid->setSortOrder("desc");
		$JQGrid->setCaption("Comments");
		$JQGrid->setLoadonce("true");
		$JQGrid->setCustom('jQuery("#videos_comments").jqGrid("navGrid","#videos_commentspager",{edit:true,add:false,del:true},{reloadAfterSubmit:false},{reloadAfterSubmit:false},{},
{multipleSearch:true, multipleGroup:true});');

		$this->view->assign('grid_comments', $JQGrid->generateGrid());

		$this->view->assign('left_text', $this->Registry->language['videos_page_left_text']);
		unset($JQGrid);
		unset($this->Registry->language);
		$this->view->display('videos.tpl');
	}
	function videosComments() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);

		$result = $this->model->getVideosComments($this->GET['id']);
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
	function viewVideo() {
		$this->GET = $this->Registry->GET;
		unset($this->Registry->GET);
		$video = $this->model->getVideo(array(
				$this->GET['id']
		));

		$video_dir_path = $video->user_key . DIRECTORY_SEPARATOR . 'videos' . DIRECTORY_SEPARATOR . md5($video->gallery_name) . DIRECTORY_SEPARATOR;
		$dir_path = USER_DATA_DIR . $video_dir_path;
		$source = '';
		if(is_file($dir_path . $video->file_name . '.mp4')) {
			$source .= '<source src="' . str_replace('public/', 'data/', $this->Registry->Settings->site_url) . 'uploads/' . str_replace('\\', '/', $video_dir_path) . $video->file_name . '.mp4" type="audio/ogg" />';
		}
		if(is_file($dir_path . $video->file_name . '.ogg')) {
			$source .= '<source src="' . str_replace('public/', 'data/', $this->Registry->Settings->site_url) . 'uploads/' . str_replace('\\', '/', $video_dir_path) . $video->file_name . '.mp4" type="audio/ogg" />';
		}
		if(is_file($dir_path . $video->file_name . '.webm')) {
			$source .= '<source src="' . str_replace('public/', 'data/', $this->Registry->Settings->site_url) . 'uploads/' . str_replace('\\', '/', $video_dir_path) . $video->file_name . '.webm" type="audio/webm" />';
		}

		echo '<video controls="controls" width="400" height="270">
  ' . $source . '
  Your browser does not support the audio element.
</video>';
	}
	function manageVideo() {
		$this->POST = $this->Registry->POST;
		$this->GET = $this->Registry->GET;
		unset($this->Registry->POST);
		unset($this->Registry->GET);
		if(isset($this->POST['oper'])) {
			if($this->POST['oper'] == 'edit') {
				unset($this->POST['oper']);
				$this->Id = $this->POST['id'];
				unset($this->POST['id']);
				$this->model->updateVideo($this->POST, $this->Id);
				unset($this->POST);
			} else {
				unset($this->POST['oper']);
				$this->Id = $this->POST['id'];
				if(strpos($this->Id, ',') !== FALSE) {
					$ids = explode(',', $this->POST['id']);
					unset($this->POST['id']);
					foreach($ids as $k => $v) {
						$this->model->deleteVideo($v);
					}
					unset($this->POST);
				} else {
					unset($this->POST['id']);
					$this->model->deleteVideo($this->Id);
					unset($this->POST);
				}
			}
		}
	}
	function manageVideosComments() {
		$this->POST = $this->Registry->POST;
		$this->GET = $this->Registry->GET;
		unset($this->Registry->POST);
		unset($this->Registry->GET);
		if(isset($this->POST['oper'])) {
			if($this->POST['oper'] == 'edit') {
				unset($this->POST['oper']);
				$this->Id = $this->POST['id'];
				unset($this->POST['id']);
				$this->model->updateVideoComments($this->POST, $this->Id);
				unset($this->POST);
			} else {
				unset($this->POST['oper']);
				$this->Id = $this->POST['id'];
				if(strpos($this->Id, ',') !== FALSE) {
					$ids = explode(',', $this->POST['id']);
					unset($this->POST['id']);
					foreach($ids as $k => $v) {
						$this->model->deleteVideoComments($v);
					}
					unset($this->POST);
				} else {
					unset($this->POST['id']);
					$this->model->deleteVideoComments($this->Id);
					unset($this->POST);
				}
			}
		}
	}
	function Games() {
		(new \SplAutoloader('lib\JQGrid', array(
				'lib\JQGrid'
		)) )->register();
		$this->GET = $this->Registry->GET;
		$this->COOKIE = $this->Registry->COOKIE;
		unset($this->Registry->COOKIE);

		$games = $this->model->getGames();
		foreach($games as $k => &$v) {
			$v->code = strip_tags($v->code);
		}
		$JQGrid = new JQGrid();
		$JQGrid->setAntets("var lastsel;");
		$JQGrid->setElementId('games');
		// $JQGrid->setUrl("index_admin.php?route=settings");
		$JQGrid->setEditUrl("index_admin.php?route=users_content&action=edit_games");
		$JQGrid->setWidth($this->gridDimensions['pictures']['width']);
		$JQGrid->setHeight($this->gridDimensions['pictures']['height']);
		$JQGrid->setDataType("local");
		$JQGrid->setData(json_encode($games));
		$JQGrid->setColNames(array(
				'Id',
				'Title',
				'Description',
				'Tags',
				'Code'
		));
		$JQGrid->setColModel(array(
				"{name:'id',index:'id', width:60},
				{name:'title',index:'title',width:100,editable:true, width:100,editrules:{required: true}},
				{name:'description',index:'text', width:200,editable:true,editrules: { edittype:'textarea'},editoptions: {rows:'10',cols:'10'} },
				{name:'tags',index:'tags',width:100,editable:true, width:100,editrules:{required: true}},
				{name:'code',index:'code',width:100,editable:true, width:100,editrules:{required: true}},
				"
		));
		$JQGrid->setRowNum($this->gridDimensions['pictures']['per_page']);
		$JQGrid->setMType("POST");
		$JQGrid->setRowList($this->gridDimensions['pictures']['row_list']);
		$JQGrid->setPager("#gamespager");
		$JQGrid->setSortName("id");
		$JQGrid->setViewRecords("true");
		// $JQGrid->setToolbar('true,"top"');
		$JQGrid->setSortOrder("desc");
		$JQGrid->setCaption('Games');
		$JQGrid->setMultiselect("true");

		$JQGrid->setCustom('jQuery("#games").jqGrid("navGrid","#gamespager",{edit:false,add:true,del:true},{reloadAfterSubmit:false},{reloadAfterSubmit:false});');
		$JQGrid->setFormatter('function imageFormatter(cellvalue, options, rowObject) {
      //return "<img src=\'"+cellvalue+"\' />";
				return cellvalue;
  }; ');
		$this->view->assign('grid', $JQGrid->generateGrid());

		$this->view->assign('games_text', $this->Registry->language['games_page_left_text']);
		unset($JQGrid);
		unset($this->Registry->language);
		$this->view->display('games.tpl');
	}
	function editGames() {
		$this->POST = $this->Registry->POST;
		unset($this->Registry->POST);
		if(isset($this->POST['oper'])) {
			if($this->POST['oper'] == 'edit') {
				unset($this->POST['oper']);
				$this->Id = $this->POST['id'];
				unset($this->POST['id']);
				$this->model->editGames($this->POST, $this->Id);
				unset($this->POST);
			} elseif($this->POST['oper'] == 'add') {
				unset($this->POST['oper']);
				unset($this->POST['id']);
				$this->model->addGames($this->POST);
				unset($this->POST);
			} elseif($this->POST['oper'] == 'del') {
				unset($this->POST['oper']);
				$this->model->deleteGames($this->POST);
				unset($this->POST);
			}
		}
	}
}

?>