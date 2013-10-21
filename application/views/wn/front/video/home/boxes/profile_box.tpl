<div id="{$profile->user_key}" class="profile_box">
<div class="profile_box_pic"><a {if $settings->only_logged_in_users_can_view_profile_info == 'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
{else}{if $no_ajax=='yes'}href="{$settings->site_url}profile/{$profile->username}"
				{else}onclick="view_profile('{$profile->user_key}')"{/if}{/if}>{$profile->profile_pic}</a></div>
<div class="user_profile_box_right">
<a {if $settings->only_logged_in_users_can_view_profile_info == 'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
{else}{if $no_ajax=='yes'}href="{$settings->site_url}profile/{$profile->username}"
				{else}onclick="view_profile('{$profile->user_key}')"{/if}{/if}><b>{$profile->username}</b></a>
<br />{$languages->gender}:{$profile->gender|ucfirst}<!-- {$profile->field}:{$profile->value}-->
<br />
<br />
<br />

				<div class="profile_i"><a onclick="user_interaction('{$profile->user_key}','add_friend')" class="member-action-icon" title="{$languages->add_friend}"><img style="border:none;" src='resources/images/member-icon-add.png' /></a></div>
				<div class="profile_i"><a onclick="user_interaction('{$profile->user_key}','say_hello')" class="member-action-icon" title="{$languages->say_hello}"><img style="border:none;" src='resources/images/member-icon-hello.png' /></a></div>
				<div class="profile_i"><a onclick="ask_question('{$profile->user_key}')" class="member-action-icon" title="{$languages->ask_question}"><img style="border:none;" src='resources/images/member-icon-ask.png' /></a></div>
			<div class="profile_i"><a onclick="user_interaction('{$profile->user_key}','mark_interested_in')" class="member-action-icon" title="{$languages->mark_interested_in}"><img style="border:none;" src='resources/images/member-icon-interest.png' /></a></div>
			<div class="profile_i"><a onclick="send_message('{$profile->user_key}')" class="member-action-icon" title="{$languages->send_message}"><img style="border:none;" src='resources/images/member-icon-message.png' /></a></div>
				<div class="profile_i"><a onclick="invite_to_event('{$profile->user_key}')" class="member-action-icon" title="{$languages->invite_to_event}"><img style="border:none;" src='resources/images/member-icon-invite.png' /></a></div>

<div class="profile_i"><a onclick="view_user_section('users_content','view_pictures','{$profile->user_key}','Pictures')" class="member-action-icon" title="{$languages->view_pictures}"><img style="border:none;" src='resources/images/member-icon-pictures.png' /></a></div>
<div class="profile_i"><a onclick="view_user_section('users_content','view_videos','{$profile->user_key}','Videos')" class="member-action-icon" title="{$languages->view_videos}"><img style="border:none;" src='resources/images/member-icon-videos.png' /></a></div>
<div class="profile_i"><a onclick="view_user_section('users_content','view_blogs','{$profile->user_key}','Blogs')" class="member-action-icon" title="{$languages->view_blogs}"><img style="border:none;" src='resources/images/member-icon-blogs.png' /></a></div>
<div class="profile_i"><a onclick="view_user_section('users_content','view_events','{$profile->user_key}','Events')" class="member-action-icon" title="{$languages->view_events}"><img style="border:none;" src='resources/images/member-icon-events.png' /></a></div>
<div class="profile_i"><a onclick="view_user_section('users_content','view_groups','{$profile->user_key}','Groups')" class="member-action-icon" title="{$languages->view_groups}"><img style="border:none;" src='resources/images/member-icon-groups.png' /></a></div>
{if $profile->webcam == '1'}<div class="profile_i"><a onclick="view_webcam('{$profile->user_key}','{$profile->webcam_session_id}')" class="member-action-icon" title="{$languages->view_webcam}"><img style="border:none;" src='resources/images/member-icon-webcam.png' /></a></div>{/if}

</div>
</div>
<div class="profile_separator"></div>
