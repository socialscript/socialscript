{foreach from=$group_events item=group_event}
<div class="group_events_event label label-info">
	<a onclick="view_group_event('{$group_event->id}')">{$group_event->title}</a>
	<div class="blogs_info ">{if $group_event->edit == 'yes'}<a onclick="edit_group_event({$group_event->id})">{$languages->edit}</a> &nbsp;&nbsp;{/if}
		{$languages->by}: <a {if $settings->only_logged_in_users_can_view_profile_info
			==
			'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
			{else}{if
			$no_ajax=='yes'}href="{$settings->site_url}profile/{$blog->username}"
			{else}onclick="view_profile('{$group_event->user_key}')"{/if}{/if}>{$group_event->username}</a>
		{$group_event->timestamp|date_format:$settings->date_format}
	</div>
</div>
{foreachelse} {$languages->events_no_results}{/foreach}

