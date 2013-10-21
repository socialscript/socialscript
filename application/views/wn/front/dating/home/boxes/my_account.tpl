{if $user_logged === FALSE} {include
		file="$tpl_dir/home/boxes/login.tpl"}
		{else}<div id="my_account" style="margin-top:-30px;">
	<h2 class="box_header  ui-widget-header">{$languages->my_account}</h2>
	<div id="my_account_box">
		<div>
			<h3>
				<a href="#">{$languages->user_status}</a>
			</h3>
			<div class="my_account_min_height">
				<blockquote class="triangle-border speech_bubble"
					{if $user_logged=== TRUE}onclick="change_status()"{/if}>{if
					$user|is_object}{$user->changing_status}{else}{$languages->you_need_to_login_to_change_your_status}{/if}
				</blockquote>
				<div id="change_status" class="hidden">
					<div class="floatleft">
						<textarea name="status" id="status"
							class="status_textarea ui-widget-header"></textarea>
					</div>
					<div class="floatleft">
						<input type="button" onclick="save_status()"
							class="ui-widget-header" value="Save">
					</div>
					<div class="clear"></div>
				</div>
			</div>
		</div>
		<div>
			<h3>
				<a href="#">{$languages->friend_requests_title}</a>
			</h3>
			<div class="my_account_min_height">
				{if $user_logged === FALSE}
				{$languages->you_need_to_login_to_access_this_section} {else}
				{foreach from=$friends_requests item=profile}
				<div id="{$profile->friend_key}"
					class="profile_box  ui-widget-header">
					<div class="profile_pic">
						<a {if $settings->only_logged_in_users_can_view_profile_info ==
							'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
							{else}{if
							$no_ajax=='yes'}href="{$settings->site_url}profile/{$profile->username}"
							{else}onclick="view_profile('{$profile->user_key}')"{/if}{/if}>{$profile->username}</a>
					</div>

					<div class="clear"></div>

					<div class="profile_i">
						<a
							onclick="user_interaction('{$profile->friend_key}','accept_friend_request')">{$languages->accept_friend_request}</a>
					</div>
					<div class="profile_i">
						<a
							onclick="user_interaction('{$profile->friend_key}','deny_friend_request')">{$languages->deny_friend_request}</a>
					</div>
					<div class="clear"></div>

				</div>
				<div class="profile_separator"></div>

				{foreachelse} {$languages->no_friend_requests} {/foreach} {/if}
			</div>
		</div>
		<div>
			<h3>
				<a href="#">Online Friends</a>
			</h3>
			<div class="my_account_min_height">
				{if $user_logged === FALSE}
				{$languages->you_need_to_login_to_access_this_section} {else}
				{foreach from=$online_friends item=friend} <a {if $settings->only_logged_in_users_can_view_profile_info
					==
					'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
					{else}{if
					$no_ajax=='yes'}href="{$settings->site_url}profile/{$friend->username}"
					{else}onclick="view_profile('{$friend->user_key}')"{/if}{/if}>{$friend->username}</a>
				{foreachelse} None {/foreach} {/if}
			</div>
		</div>
		<div>
			<h3>
				<a href="#">{$languages->my_stats}</a>
			</h3>
			<div class="my_account_min_height">
				{if $user_logged === FALSE}
				{$languages->you_need_to_login_to_access_this_section} {else}
				{$languages->you_have}<br /> <a
					onclick="show_center('users_interaction','friends')">{$stats_nr_friends}
					{$languages->stats_friends}</a><br /> <a
					onclick="show_center('users_interaction','best_friends')">{$stats_nr_best_friends}
					{$languages->stats_best_friends}</a> <br /> <a
					onclick="show_center('users_interaction','family_friends')">{$stats_nr_family}
					{$languages->stats_family_friends}</a> <br /> {$stats_nr_events}
				{$languages->stats_events} <br /> {$languages->stats_you_created} <br />
				{$stats_nr_groups} {$languages->stats_groups} <br />
				{$stats_nr_blogs} {$languages->stats_blogs} <br /> {/if}
			</div>
		</div>
		<div>
			<h3>
				<a href="#">{$languages->upcoming_events}</a>
			</h3>

			<div class="my_account_min_height">
				{if $user_logged === FALSE}
				{$languages->you_need_to_login_to_access_this_section} {else}
				{foreach from=$upcoming_events item=upcoming_event} <a
					{if $no_ajax==
					'yes'}href="{$settings->site_url}event/{$upcoming_event->safe_seo_url}"
					{else}onclick="show_event_details('{$upcoming_event->id}','{$upcoming_event->user_key}')"{/if}>{$upcoming_event->title}</a>
				{foreachelse} {$languages->no_upcoming_events} {/foreach} {/if}

			</div>
		</div>
		<div>
			<h3>
				<a href="#">{$languages->upcoming_events_to_attend}</a>
			</h3>
			<div class="my_account_min_height">
				{if $user_logged === FALSE}
				{$languages->you_need_to_login_to_access_this_section} {else}
				{foreach from=$upcoming_events_to_attend
				item=upcoming_event_to_attend} <a {if $no_ajax==
					'yes'}href="{$settings->site_url}event/{$upcoming_event->safe_seo_url}"
					{else}onclick="show_event_details('{$upcoming_event->id}','{$upcoming_event->user_key}')"{/if}>{$upcoming_event_to_attend->title}</a>
				{foreachelse} {$languages->no_upcoming_events_to_attend} {/foreach}
				{/if}
			</div>
		</div>
	</div>

	<div id="left_default"></div>
</div>

{/if}