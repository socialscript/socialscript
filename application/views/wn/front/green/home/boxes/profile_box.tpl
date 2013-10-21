<div id="{$profile->user_key}" class="profile_box  ui-widget-header">
	<div class="profile_box_pic">
		<a {if $settings->only_logged_in_users_can_view_profile_info ==
			'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
			{else}{if
			$no_ajax=='yes'}href="{$settings->site_url}profile/{$profile->username}"
			{else}onclick="view_profile('{$profile->user_key}')"{/if}{/if}>{$profile->profile_pic}</a>
	</div>
	<div class="user_profile_box_right">
		<a {if $settings->only_logged_in_users_can_view_profile_info ==
			'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
			{else}{if
			$no_ajax=='yes'}href="{$settings->site_url}profile/{$profile->username}"
			{else}onclick="view_profile('{$profile->user_key}')"{/if}{/if}><b>{$profile->username}</b>
		</a> <br />{$languages->gender}:{$profile->gender|ucfirst}
		<!-- {$profile->field}:{$profile->value}-->
		<br /> <br /> <br />

		<div class="profile_i">
			<a onclick="user_interaction('{$profile->user_key}','add_friend')">{$languages->add_friend}</a>
		</div>
		<div class="profile_i">
			<a onclick="user_interaction('{$profile->user_key}','say_hello')">{$languages->say_hello}</a>
		</div>
		<div class="profile_i">
			<a onclick="ask_question('{$profile->user_key}')">{$languages->ask_question}</a>
		</div>
		<div class="profile_i">
			<a
				onclick="user_interaction('{$profile->user_key}','mark_interested_in')">{$languages->mark_interested_in}</a>
		</div>
		<div class="profile_i">
			<a onclick="send_message('{$profile->user_key}')">{$languages->send_message}</a>
		</div>
		<div class="profile_i">
			<a onclick="invite_to_event('{$profile->user_key}')">{$languages->invite_to_event}</a>
		</div>

		<div class="profile_i">
			<a
				onclick="view_user_section('users_content','view_pictures','{$profile->user_key}','Pictures')">{$languages->view_pictures}</a>
		</div>
		<div class="profile_i">
			<a
				onclick="view_user_section('users_content','view_videos','{$profile->user_key}','Videos')">{$languages->view_videos}</a>
		</div>
		<div class="profile_i">
			<a
				onclick="view_user_section('users_content','view_blogs','{$profile->user_key}','Blogs')">{$languages->view_blogs}</a>
		</div>
		<div class="profile_i">
			<a
				onclick="view_user_section('users_content','view_events','{$profile->user_key}','Events')">{$languages->view_events}</a>
		</div>
		<div class="profile_i">
			<a
				onclick="view_user_section('users_content','view_groups','{$profile->user_key}','Groups')">{$languages->view_groups}</a>
		</div>
		{if $profile->webcam == '1'}
		<div class="profile_i">
			<a
				onclick="view_webcam('{$profile->user_key}','{$profile->webcam_session_id}')">{$languages->view_webcam}</a>
		</div>
		{/if}

	</div>
</div>
<div class="profile_separator"></div>
