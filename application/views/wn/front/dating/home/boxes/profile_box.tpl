<div id="{$profile->user_key}" class="wide-member-box">
	<div class="profile_box_pic">
		<a {if $settings->only_logged_in_users_can_view_profile_info ==
			'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
			{else}{if
			$no_ajax=='yes'}href="{$settings->site_url}profile/{$profile->username}"
			{else}onclick="view_profile('{$profile->user_key}')"{/if}{/if}>{$profile->profile_pic}</a>
	</div>
	<div class="user_profile_box_right">
		<img src='resources/images/{$profile->gender}.png' /> <a {if $settings->only_logged_in_users_can_view_profile_info ==
			'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
			{else}{if
			$no_ajax=='yes'}href="{$settings->site_url}profile/{$profile->username}"
			{else}onclick="view_profile('{$profile->user_key}')"{/if}{/if} class='featured_member_title'><b>{$profile->username}</b>
		</a><!--  <br />{$languages->gender}:{$profile->gender|ucfirst}-->
		<!-- {$profile->field}:{$profile->value}-->
		<div style="padding-top:10px;">
		<div class="profile_i">
			<a onclick="user_interaction('{$profile->user_key}','add_friend')" title="{$languages->add_friend}" ><img class="a-img-border" src='resources/images/fi-add.png' /></a>
		</div>
		<div class="profile_i">
			<a onclick="user_interaction('{$profile->user_key}','say_hello')" title="{$languages->say_hello}"><img class="a-img-border" src='resources/images/fi-chat.png' /></a>
		</div>
		<div class="profile_i">
			<a onclick="ask_question('{$profile->user_key}')" title="{$languages->ask_question}"><img class="a-img-border" src='resources/images/fi-ask.png' /></a>
		</div>
		<div class="profile_i">
			<a
				onclick="user_interaction('{$profile->user_key}','mark_interested_in')" title="{$languages->mark_interested_in}"><img class="a-img-border" src='resources/images/fi-mark.png' /></a>
		</div>
		<div class="profile_i">
			<a onclick="send_message('{$profile->user_key}')" title="{$languages->send_message}"><img class="a-img-border" src='resources/images/fi-message.png' /></a>
		</div>
		<div class="profile_i">
			<a onclick="invite_to_event('{$profile->user_key}')" title="{$languages->invite_to_event}"><img class="a-img-border" src='resources/images/fi-invite.png' /></a>
		</div>

		<div class="profile_i">
			<a
				onclick="view_user_section('users_content','view_pictures','{$profile->user_key}','Pictures')" title="{$languages->view_pictures}"><img class="a-img-border" src='resources/images/fi-photos.png' /></a>
		</div>
		<div class="profile_i">
			<a
				onclick="view_user_section('users_content','view_videos','{$profile->user_key}','Videos')" title="{$languages->view_videos}"><img class="a-img-border" src='resources/images/fi-videos.png' /></a>
		</div>
		<div class="profile_i">
			<a
				onclick="view_user_section('users_content','view_blogs','{$profile->user_key}','Blogs')" title="{$languages->view_blogs}"><img class="a-img-border" src='resources/images/fi-blogs.png' /></a>
		</div>
		<div class="profile_i">
			<a
				onclick="view_user_section('users_content','view_events','{$profile->user_key}','Events')" title="{$languages->view_events}"><img class="a-img-border" src='resources/images/fi-calendar.png' /></a>
		</div>
		<div class="profile_i">
			<a
				onclick="view_user_section('users_content','view_groups','{$profile->user_key}','Groups')" title="{$languages->view_groups}"><img class="a-img-border" src='resources/images/fi-groups.png' /></a>
		</div>
		{if $profile->webcam == '1'}
		<div class="profile_i">
			<a
				onclick="view_webcam('{$profile->user_key}','{$profile->webcam_session_id}')" title="{$languages->view_webcam}">{$languages->view_webcam}<img class="a-img-border" src='resources/images/fi-webcam.png' /></a>
		</div>
		{/if}
</div>
	</div>
</div>
<div class="profile_separator"></div>
