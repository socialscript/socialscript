<div id="my_account">
	<h2 class="box_header  ui-widget-header">{$languages->my_account}</h2>
	<div id="my_account_box">
		<div>
			<h3>
				<a href="#">{$languages->user_status}</a>
			</h3>
			<div style="min-height: 80px;">
				<blockquote class="example-obtuse speech_bubble"
					{if $user|is_object}onclick="change_status()"{/if}>{if
					$user|is_object}{$user->changing_status}{else}{$languages->you_need_to_login_to_change_your_status}{/if}
				</blockquote>
				<div id="change_status" class="hidden">
					<div class="floatleft">
						<textarea name="status" id="status" class="status_textarea"></textarea>
					</div>
					<div class="floatleft">
						<input type="button" onclick="save_status()" value="Save">
					</div>
					<div class="clear"></div>
				</div>


			</div>
		</div>
		<div>
			<h3>
				<a href="#">{$languages->friend_requests_title}</a>
			</h3>
			<div>
				{if $user_logged === FALSE}
				{$languages->you_need_to_login_to_access_this_section} {else}
				{foreach from=$friends_requests item=profile}
				<div id="{$profile->friend_key}"
					class="profile_box  ui-widget-header">
					<div class="profile_pic">{$profile->username}</div>

					<div class="profile_data">{$profile->field}:{$profile->value}</div>
					<div class="clear"></div>

					<div class="profile_i">
						<a
							onclick="user_interaction('{$profile->user_key}','accept_friend_request')">{$languages->accept_friend_request}</a>
					</div>
					<div class="profile_i">
						<a
							onclick="user_interaction('{$profile->user_key}','deny_friend_requests')">{$languages->deny_friend_request}</a>
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
			<div>
				{if $user_logged === FALSE}
				{$languages->you_need_to_login_to_access_this_section} {else}
				{foreach from=$online_friends item=friend} <a
					onclick="view_profile('{$friend->user_key}')">{$friend->username}</a>
				{foreachelse} None {/foreach} {/if}
			</div>
		</div>
		<div>
			<h3>
				<a href="#">{$languages->my_stats}</a>
			</h3>
			<div>
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

			<div>{if $user_logged === FALSE}
				{$languages->you_need_to_login_to_access_this_section} {else}
				{foreach from=$upcoming_events item=upcoming_event}
				{$upcoming_event->title} {foreachelse}
				{$languages->no_upcoming_events} {/foreach} {/if}</div>
		</div>
		<div>
			<h3>
				<a href="#">{$languages->upcoming_events_to_attend}</a>
			</h3>
			<div>{if $user_logged === FALSE}
				{$languages->you_need_to_login_to_access_this_section} {else}
				{foreach from=$upcoming_events_to_attend
				item=upcoming_event_to_attend} {$upcoming_event_to_attend->title}
				{foreachelse} {$languages->no_upcoming_events_to_attend} {/foreach}
				{/if}</div>
		</div>
	</div>

	<div class="box_separator">&nbsp;</div>
	<div id="left_default"></div>
</div>
<div class="separator">&nbsp;</div>