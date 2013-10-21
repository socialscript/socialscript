{foreach from=$events item=event}
<div style="padding-top:10px;">
<div>
		<a class="new-event-title" onclick="show_event('{$event->id}','{$event->user_key}')">{$event->title}<br />{$event->location},{$event->event_date}</a>
		</div>
		<div class="new-event-holder">
		{$languages->by}:<a class="new-event-user" {if $settings->only_logged_in_users_can_view_profile_info == 'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
{else}{if $no_ajax=='yes'}href="{$settings->site_url}profile/{$event->username}"
				{else}onclick="view_profile('{$event->user_key}')"{/if}{/if}>{$event->username}</a>  {$event->timestamp|date_format:$settings->date_format}
				</div>
				</div>
				
		{foreachelse}
		{$languages->events_no_results}
		{/foreach}