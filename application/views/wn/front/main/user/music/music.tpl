{foreach from=$music item=the_music}
<div class="the_musics_left label label-info">
	<a onclick="show_music('{$the_music->id}')">{$the_music->title}</a><br />
	<a {if $settings->only_logged_in_users_can_view_profile_info ==
		'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
		{else}{if
		$no_ajax=='yes'}href="{$settings->site_url}profile/{$the_music->username}"
		{else}onclick="view_profile('{$the_music->user_key}')"{/if}{/if}>{$the_music->username}</a>
	{$the_music->timestamp|date_format:$settings->date_format}
</div>
{foreachelse} {$languages->no_results} {/foreach}
{if
isset($pagination)}
<div class="pagination">{$pagination}</div>
{/if}