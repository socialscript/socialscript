{foreach from=$group_events item=group_event}
<div class="group_events_event ui-widget-header">
	<a onclick="view_group_event('{$group_event->id}')">{$group_event->title}</a>
	<div class="blogs_info ">
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

