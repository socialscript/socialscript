	{foreach from=$video item=thevideo}
			<div class="thevideo  ui-widget-header">
			<div class="video_thumb_pic"><a {if $no_ajax=='yes'}href="{$settings->site_url}video/{$thevideo->safe_seo_url}/{$thevideo->id}"
				{else}onclick="video_details('{$thevideo->id}','{$thevideo->user_key}')"{/if}>{$thevideo->thumb}</a></div>
			<div class="video_box_right">
		<a {if $no_ajax=='yes'}href="{$settings->site_url}video/{$thevideo->safe_seo_url}/{$thevideo->id}"
				{else}onclick="video_details('{$thevideo->id}','{$thevideo->user_key}')"{/if}>{$thevideo->title}</a><br />
{$thevideo->tags}
		<br />
		{$languages->by}: <a {if $settings->only_logged_in_users_can_view_profile_info == 'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
{else}{if $no_ajax=='yes'}href="{$settings->site_url}profile/{$thevideo->username}"
				{else}onclick="view_profile('{$thevideo->user_key}')"{/if}{/if}>{$thevideo->username}</a><br />
		</div>

		</div>
		<div class="clear"></div>
		{foreachelse}
		{$languages->no_results}
		{/foreach}