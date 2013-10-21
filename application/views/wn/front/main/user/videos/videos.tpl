{foreach from=$videos item=video}
<div class="videos_left label label-info">
	<a onclick="show_video('{$video->id}')">{$video->title}</a><br />
	<a {if $settings->only_logged_in_users_can_view_profile_info ==
		'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
		{else}{if
		$no_ajax=='yes'}href="{$settings->site_url}profile/{$video->username}"
		{else}onclick="view_profile('{$video->user_key}')"{/if}{/if}>{$video->username}</a>
	{$video->timestamp|date_format:$settings->date_format}
</div>
{foreachelse} {$languages->videos_no_results} {/foreach}
{if
isset($pagination)}
<div class="pagination">{$pagination}</div>
{/if}