{foreach from=$events item=event}
<div class="events_left  ui-widget-header">
	<a {if $no_ajax==
		'yes'}href="{$settings->site_url}event/{$event->safe_seo_url}/{$event->id}"
		{else}onclick="show_event_details('{$event->id}','{$event->user_key}')"{/if}>{$event->title}<br />{$event->location},{$event->event_date}
	</a> <br />
	<div class="events_info ">
		{$languages->by}: <a {if $settings->only_logged_in_users_can_view_profile_info
			==
			'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
			{else}{if
			$no_ajax=='yes'}href="{$settings->site_url}profile/{$event->username}"
			{else}onclick="view_profile('{$event->user_key}')"{/if}{/if}>{$event->username}</a>
		{$event->timestamp|date_format:$settings->date_format}
	</div>
</div>
{foreachelse} {$languages->events_no_results} {/foreach}
<div class="clear"></div>
{if isset($pagination)}
<div class="pagination">{$pagination}</div>
{/if}
