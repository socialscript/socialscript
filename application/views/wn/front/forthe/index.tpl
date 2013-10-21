<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<title>{$settings->site_title}</title>
<link rel="stylesheet" type="text/css" id="jquery_ui_theme_loader"
	href="{$settings->resources_url}/resources/themes/wn/ui-themes/{$wn_theme}/jquery-ui-1.8.18.custom.css">
<link type="text/css"
	href="{$settings->resources_url}/resources/css/{$settings->default_layout}/style.css"
	rel="stylesheet" />
<script type="text/javascript"
	src="{$settings->resources_url}/resources/js/js_1.0.min.js"></script>
{literal}
<script type="text/javascript">
		var enable_custom_scrollbar = '{/literal}{$settings->enable_custom_scrollbar}{literal}';
		var r_h = '{/literal}{$request_hash}{literal}';
		var thumbnail_width = '{/literal}{$thumbnail_width}{literal}';
		var thumbnail_height = '{/literal}{$thumbnail_height}{literal}';
		var large_image_width = '{/literal}{$large_image_width}{literal}';
		var large_image_height = '{/literal}{$large_image_height}{literal}';
		var width_big_profile_picture = '{/literal}{$width_big_profile_picture}{literal}';
		var height_big_profile_picture = '{/literal}{$height_big_profile_picture}{literal}';
		var comment_empty = '{/literal}{$languages->comment_is_empty}{literal}';
		var all_fields_required = '{/literal}{$languages->all_fields_required}{literal}';
		var empty_chat_message = '{/literal}{$languages->empty_chat_message}{literal}';
		var field_is_required = '{/literal}{$languages->field_is_required}{literal}';
		var site_url = '{/literal}{$settings->site_url}{literal}';
		var no_ajax = '{/literal}{$no_ajax}{literal}';
		{/literal}{if isset($not_load_middle_default)}{literal}var not_load_middle_default = true;{/literal}{else}{literal}var not_load_middle_default = false;{/literal}{/if}{literal}
		var user_logged = '{/literal}{$user_logged}{literal}';
		</script>
{/literal} {$settings->analytics_code}
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-33796192-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<body>

	<div id="full-page-container" class="hidden">
		<div id="loading" class="hidden">
			<div class="loading_text floatleft">Loading...</div>
			<div id="notifications" class="floatright"></div>
		</div>

		{include file="$tpl_dir/header.tpl"}
		<div id="content">{include file="$tpl_dir/layout.tpl"}</div>
	</div>
	<div id="footer">{include file="$tpl_dir/footer.tpl"}</div>
	<script type="text/javascript"
		src="{$settings->resources_url}/resources/js/js2_1.0.js"></script>

</body>
</html>
<div id="view_user_section"></div>

