 {foreach from=$groups item=group}
<div class="group   ui-widget-header">
	<a {if $settings->only_logged_in_users_can_view_group_info ==
		'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
		{else}{if
		$no_ajax=='yes'}href="{$settings->site_url}group/{$group->safe_seo_url}/{$group->id}"
		{else}onclick="group_details('{$group->id}','{$group->user_key}')"{/if}{/if}
		>{$group->group_name}</a>,{$group->group_location} <br />
	<div class="comment_info ">
		{$languages->creator}: <a {if $settings->only_logged_in_users_can_view_profile_info
			==
			'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
			{else}{if
			$no_ajax=='yes'}href="{$settings->site_url}profile/{$group->username}"
			{else}onclick="view_profile('{$group->user_key}')"{/if}{/if}>{$group->username}</a>
		{$group->timestamp|date_format:$settings->date_format}
	</div>
</div>
{foreachelse} {$languages->groups_no_results} {/foreach} {if
isset($pagination)}
<div class="pagination">{$pagination}</div>
{/if}
