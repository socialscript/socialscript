<div id="show_events">
				<h3>
					<a href="#">{$languages->events}</a>
				</h3>
				<div class="middle_min_height">

{foreach from=$events item=event}
<div style="padding-top:10px;">
		<a class="new-event-title" {if $no_ajax=='yes'}href="{$settings->site_url}event/{$event->safe_seo_url}/{$event->id}"
				{else}onclick="show_event_details('{$event->id}','{$event->user_key}')"{/if}>{$event->title}<br />{$event->location},{$event->event_date}</a>
		<br />
		<div class="new-event-holder">
		{$languages->by}: <a class="new-event-user" {if $settings->only_logged_in_users_can_view_profile_info == 'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
{else}{if $no_ajax=='yes'}href="{$settings->site_url}profile/{$event->username}"
				{else}onclick="view_profile('{$event->user_key}')"{/if}{/if}>{$event->username}</a> {$event->timestamp|date_format:$settings->date_format}
		</div>
		</div>
		{foreachelse}
		{$languages->events_no_results}
		{/foreach}

<br />

				</div>
		<div id="view_events_profile_page">
		<div id="events_comments"></div>
		<div id="events_profile_page"></div>
		</div>
</div>
