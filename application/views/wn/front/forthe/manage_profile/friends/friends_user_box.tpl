<div id="{$profile->user_key}" class="profile_box  ui-widget-header">
	<div class="profile_box_pic">
		<a onclick="view_profile('{$profile->user_key}')">{$profile->profile_pic}</a>
	</div>
	<div class="user_profile_box_right">
		<a onclick="view_profile('{$profile->user_key}')"><b>{$profile->username}</b></a>
		<br />{$languages->gender}:{$profile->gender|ucfirst}
		<!-- {$profile->field}:{$profile->value}-->
		<br /> <br /> {if isset($new_requests)}
		<div class="profile_i">
			<a
				onclick="user_interaction('{$profile->friend_key}','accept_friend_request')">{$languages->accept_friend_request}</a>
		</div>
		<div class="profile_i">
			<a
				onclick="user_interaction('{$profile->friend_key}','deny_friend_request')">{$languages->deny_friend_request}</a>
		</div>
		{/if}
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
		{if !isset($best_friends_page) && !isset($family_friends_page) &&
		!isset($new_requests)}
		<div class="profile_i">
			<a
				onclick="user_interaction('{$profile->friend_key}','mark_best_friend')">{$languages->mark_best_friend}</a>
		</div>
		 
		{/if}
	</div>
</div>
<div class="clear"></div>

<div class="profile_separator"></div>
