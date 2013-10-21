{foreach from=$group_musics item=music}
<div class="ui-widget-header group_musics_music">
	<a onclick="show_music('{$music->id}','{$music->group_id}')">{$music->title}</a>
	<br />{if $music->delete == 'yes'}<a onclick="delete_group_music({$music->id})">{$languages->delete}</a> &nbsp;&nbsp;{/if}
	 {$languages->by}: <a {if $settings->only_logged_in_users_can_view_profile_info
		==
		'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
		{else}{if
		$no_ajax=='yes'}href="{$settings->site_url}profile/{$music->username}"
		{else}onclick="view_profile('{$music->user_key}')"{/if}{/if}>{$music->username}</a>
	{$music->timestamp|date_format:$settings->date_format}
</div>
{foreachelse} {$languages->music_no_results} {/foreach}
