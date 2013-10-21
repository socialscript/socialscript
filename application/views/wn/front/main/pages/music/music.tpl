 {foreach from=$music item=themusic}
<div class="themusic  label label-info">
	<a {if $no_ajax==
		'yes'}href="{$settings->site_url}music/{$themusic->safe_seo_url}/{$themusic->id}"
		{else}onclick="music_details('{$themusic->id}','{$themusic->user_key}')"{/if}>{$themusic->title}</a><br />
	{$languages->tags}: {$themusic->tags}
	<div class="music_info">
		{$languages->by}: <a {if $settings->only_logged_in_users_can_view_profile_info
			==
			'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
			{else}{if
			$no_ajax=='yes'}href="{$settings->site_url}profile/{$themusic->username}"
			{else}onclick="view_profile('{$themusic->user_key}')"{/if}{/if}>{$themusic->username}</a>
		{$themusic->timestamp|date_format:$settings->date_format}
	</div>
</div>
{foreachelse} {$languages->music_no_results} {/foreach} {if
isset($pagination)}
<div class="pagination">{$pagination}</div>
{/if}
