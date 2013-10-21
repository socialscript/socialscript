{foreach from=$group_videos item=video}
<div class="ui-widget-header group_videos_video">
	{$video->thumb} <br /> <a
		onclick="show_video('{$video->id}','{$video->group_id}')">{$video->title}</a>
	<br />{if $video->delete == 'yes'}<a onclick="delete_group_video({$video->id})">{$languages->delete}</a> &nbsp;&nbsp;{/if}
	 {$languages->by}: <a {if $settings->only_logged_in_users_can_view_profile_info
		==
		'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
		{else}{if
		$no_ajax=='yes'}href="{$settings->site_url}profile/{$thevideo->username}"
		{else}onclick="view_profile('{$video->user_key}')"{/if}{/if}>{$video->username}</a>
	{$video->timestamp|date_format:$settings->date_format}
</div>
{foreachelse} {$languages->videos_no_results} {/foreach}
