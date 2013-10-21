<div id="{$profile->friend_key}" class="profile_box  ui-widget-header">
	<div class="profile_pic">{$profile->username}</div>

	<div class="clear"></div>


	<div class="profile_i">
		<a onclick="user_interaction('{$profile->user_key}','say_hello')">{$languages->say_hello}</a>
	</div>
	<div class="profile_i">
		<a onclick="user_interaction('{$profile->user_key}','ask_question')">{$languages->ask_question}</a>
	</div>
	<div class="profile_i">
		<a
			onclick="user_interaction('{$profile->user_key}','mark_interested_in')">{$languages->mark_interested_in}</a>
	</div>
	<div class="profile_i">
		<a onclick="invite_to_event('{$profile->user_key}')">{$languages->invite_to_event}</a>
	</div>
	<div class="clear"></div>
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
	<div class="profile_i">
		<a onclick="send_message('{$profile->user_key}')">{$languages->send_message}</a>
	</div>
	<div class="clear"></div>

</div>
<div class="profile_separator"></div>
