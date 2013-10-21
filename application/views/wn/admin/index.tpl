<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>{$settings->site_title}</title>
<link rel="stylesheet" type="text/css" id="jquery_ui_theme_loader"
	href="{$settings->resources_url}/resources/themes/wn/ui-themes/{$wn_theme}/jquery-ui-1.8.18.custom.css">
<link type="text/css"
	href="{$settings->site_url}/resources/js/jquery_window/css/jquery.window.css"
	rel="stylesheet" />
<link type="text/css"
	href="{$settings->site_url}/resources/css/style.admin.css"
	rel="stylesheet" />

<script type="text/javascript"
	src="{$settings->site_url}/resources/js/jquery-1.7.1.min.js"></script>

	<script
	src="{$settings->site_url}/resources/js/tiny_mce/jquery.tinymce.js"
	type="text/javascript"></script>
	<script


<script type="text/javascript"
	src="{$settings->site_url}/resources/js/jquery-ui-1.8.18.custom.min.js"></script>
<script type="text/javascript"
	src="{$settings->site_url}/resources/js/jquery_window/jquery.window.js"></script>
<script type="text/javascript"
	src="{$settings->site_url}/resources/js/jquery_window/common.js"></script>
<link rel="stylesheet" type="text/css" media="screen"
	href="{$settings->site_url}/resources/js/jquery.jqGrid/css/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" media="screen"
	href="{$settings->site_url}/resources/js/jquery.jqGrid/css/ui.multiselect.css" />

<script
	src="{$settings->site_url}/resources/js/jquery.jqGrid/js/i18n/grid.locale-en.js"
	type="text/javascript"></script>
{literal}
<script type="text/javascript">
	$.jgrid.no_legacy_api = true;
	$.jgrid.useJSON = true;
</script>
{/literal}
<!--
<script
	src="{$settings->site_url}/resources/js/jquery.jqGrid/js/jquery.jqGrid.min.js"
	type="text/javascript"></script>
	-->
<script
	src="{$settings->site_url}/resources/js/jquery.jqGrid/js/jquery.jqGrid.src.js"
	type="text/javascript"></script>
<script
	src="{$settings->site_url}/resources/js/jquery.jqGrid/js/jquery.contextmenu.js"
	type="text/javascript"></script>
<script
	src="{$settings->site_url}/resources/js/jquery.jqGrid/js/ui.multiselect.js"
	type="text/javascript"></script>
<script
	src="{$settings->site_url}/resources/js/jquery.jqGrid/js/jquery.tablednd.js"
	type="text/javascript"></script>
<script src="{$settings->site_url}/resources/js/jquery.cookie.js"
	type="text/javascript"></script>
</head>
<body>{include file="$tpl_dir/login.tpl"}
</body>
</html>

