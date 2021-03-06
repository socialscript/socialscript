<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<title>{$settings->site_title}</title>
<meta name="keywords" content="on line dating">
<meta name="description" content="On line dating site">
<base href="{$settings->site_url}">
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
</head>
<body>

	<div id="full-page-container" class="hidden">
		<div id="loading" class="hidden">
			<div class="loading_text floatleft">Loading...</div>
			<div id="notifications" class="floatright"></div>
		</div>

		{include file="$tpl_dir/header.tpl"}
		<div id="content">
			<div class="floatleft left_boxes hidden" id="left_sections_top"></div>
			<div class="separator">&nbsp;</div>
			<div id="middle_top" class="floatleft hidden"></div>
			<div class="separator">&nbsp;</div>
			<div id="right_top" class="floatleft hidden"></div>
			<div class="clear"></div>
			<div id="view_top" {if $page !='user/profile/profile.tpl'
				}class="hidden"{/if}>{if $page ==
				'user/profile/profile.tpl'}{include file="$tpl_dir/$page"}{/if}</div>
			<div class="clear"></div>
			<div id="view_groups" {if $page !='pages/groups/group_details.tpl'
				}class="hidden"{/if}>{if $page ==
				'pages/groups/group_details.tpl'}{include
				file="$tpl_dir/$page"}{/if}</div>
			<div class="clear"></div>
			<section>{include file="$tpl_dir/home/left_boxes.tpl"}</section>
			<div class="separator">&nbsp;</div>
			<section>
			<script type="text/javascript"><!--
google_ad_client = "ca-pub-0056216336604218";
/* dating top */
google_ad_slot = "5316160535";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
				<div class="floatleft" id="middle">
					<div id="middle_default">
						<div id="middle_boxes">{if $page == 'user/profile/profile.tpl'}
							{include file="$tpl_dir/home/home.tpl"} {elseif $page ==
							'pages/groups/group_details.tpl'} {include
							file="$tpl_dir/home/home.tpl"} {else} {include
							file="$tpl_dir/$page"} {/if}</div>
					</div>
				</div>
			</section>
			<div class="separator">&nbsp;</div>
			<section>{include file="$tpl_dir/home/right_boxes.tpl"}</section>
			<div class="separator">&nbsp;</div>
		</div>

		<div id="footer">{include file="$tpl_dir/footer.tpl"}</div>
	</div>
	<script type="text/javascript"
		src="{$settings->resources_url}/resources/js/js2_1.0.min.js"></script>
</body>
</html>
<div id="view_user_section"></div>

