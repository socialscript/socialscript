<div id="left_bottom_box">
<h2 class="box_header   ui-widget-header">{$languages->left_box_whats_happening_lately}</h2>
	<div>
		<h3>
			<a href="#">{$languages->latest_blogs_title}</a>
		</h3>
		<div class="my_account_min_height">
			{foreach from=$latest_blogs item=blog}
			<div class="blogs_left ui-widget-header">
		<a {if $no_ajax=='yes'}href="{$settings->site_url}blog/{$blog->safe_seo_url}/{$blog->id}"
				{else}onclick="show_blog_details('{$blog->id}','{$blog->user_key}')"{/if}>{$blog->title}</a>
				<br />
		<div class="blogs_info ">
		{$languages->by}: <a {if $settings->only_logged_in_users_can_view_profile_info == 'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
{else}{if $no_ajax=='yes'}href="{$settings->site_url}profile/{$blog->username}"
				{else}onclick="view_profile('{$blog->user_key}')"{/if}{/if}>{$blog->username}</a> {$blog->timestamp|date_format:$settings->date_format}
		</div>
		</div>
			{foreachelse} {$languages->blogs_no_results} {/foreach}
		</div>
	</div>
	<div>
		<h3>
			<a href="#">{$languages->latest_events_title}</a>
		</h3>
		<div class="my_account_min_height">
			{foreach from=$latest_events item=event}
			<div class="events_left ui-widget-header">
				<a  {if $no_ajax=='yes'}href="{$settings->site_url}event/{$event->safe_seo_url}/{$event->id}"
				{else}onclick="show_event_details('{$event->id}','{$event->user_key}')"{/if}>{$event->title}<br />{$event->location},{$event->event_date}</a>
		<br />
		<div class="events_info ">
		{$languages->by}: <a {if $settings->only_logged_in_users_can_view_profile_info == 'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
{else}{if $no_ajax=='yes'}href="{$settings->site_url}profile/{$event->username}"
				{else}onclick="view_profile('{$event->user_key}')"{/if}{/if}>{$event->username}</a> {$event->timestamp|date_format:$settings->date_format}
		</div>
		</div>
			{foreachelse} {$languages->events_no_results} {/foreach}
		</div>
	</div>
	<div>
		<h3>
			<a href="#">{$languages->latest_groups_title}</a>
		</h3>
		<div class="my_account_min_height">
			{foreach from=$latest_groups item=group}
	<div class="group   ui-widget-header">
		<a {if $settings->only_logged_in_users_can_view_group_info == 'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
{else}{if $no_ajax=='yes'}href="{$settings->site_url}group/{$group->safe_seo_url}/{$group->id}"
				{else}onclick="group_details('{$group->id}','{$group->user_key}')"{/if}{/if}>{$group->group_name}</a>,{$group->group_location}
<br />
		<div class="comment_info ">
		{$languages->creator}: <a {if $settings->only_logged_in_users_can_view_profile_info == 'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
{else}{if $no_ajax=='yes'}href="{$settings->site_url}profile/{$group->username}"
				{else}onclick="view_profile('{$group->user_key}')"{/if}{/if}>{$group->username}</a> {$group->timestamp|date_format:$settings->date_format}
		</div>
		</div>
			{foreachelse} {$languages->groups_no_results} {/foreach}
		</div>
	</div>
	<!--
	<div>
		<h3>
			<a href="#">{$languages->latest_pictures_title}</a>
		</h3>
		<div></div>
	</div>
	-->
</div>


zz