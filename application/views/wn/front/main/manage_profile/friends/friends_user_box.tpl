<div id="{$profile->user_key}" class="profile_box  ui-widget-header">
	<div class="profile_box_pic">
		<a onclick="view_profile('{$profile->user_key}')">{$profile->profile_pic}</a>
	</div>
	<div class="user_profile_box_right">
		<a {if
			$no_ajax=='yes'}href="{$settings->site_url}profile/{$profile->username}"
			{else}onclick="view_profile('{$profile->user_key}')"{/if}><b>{$profile->username}</b></a>
		<br />{$languages->gender}:{$profile->gender|ucfirst}
		<!-- {$profile->field}:{$profile->value}-->
		<br /> <br /> {if isset($new_requests)}
		<div class="profile_i">
			<a
				onclick="user_interaction('{$profile->friend_key}','accept_friend_request')">{$languages->accept_friend_request}</a> - 
		</div>
		<div class="profile_i">
			<a
				onclick="user_interaction('{$profile->friend_key}','deny_friend_request')">{$languages->deny_friend_request}</a> - 
		</div>
		{/if}
		<div class="profile_i">
			<a onclick="user_interaction('{$profile->user_key}','say_hello')">{$languages->say_hello}</a> - 
		</div>
		<!--
		<div class="profile_i">
			<a onclick="ask_question('{$profile->user_key}')">{$languages->ask_question}</a>
		</div>
		-->
		<div class="profile_i">
			<a
				onclick="user_interaction('{$profile->user_key}','mark_interested_in')">{$languages->mark_interested_in}</a> - 
		</div>
		<div class="profile_i">
			<a onclick="send_message('{$profile->user_key}')">{$languages->send_message}</a> - 
		</div>
		<div class="profile_i">
			<a onclick="invite_to_event('{$profile->user_key}')">{$languages->invite_to_event}</a> - 
		</div>
		<div class="profile_i">
			<a
				onclick="view_user_section('users_content','view_pictures','{$profile->user_key}','{$languages->view_pictures}')">{$languages->view_pictures}</a> - 
		</div>
		<div class="profile_i">
			<a
				onclick="view_user_section('users_content','view_videos','{$profile->user_key}','{$languages->view_videos}')">{$languages->view_videos}</a> - 
		</div>
			<div class="profile_i">
			<a
				onclick="view_user_section('users_content','view_music','{$profile->user_key}','{$languages->view_music}')">{$languages->view_music}</a> - 
		</div>
		<div class="profile_i">
			<a
				onclick="view_user_section('users_content','view_blogs','{$profile->user_key}','{$languages->view_blogs}')">{$languages->view_blogs}</a> - 
		</div>
		<div class="profile_i">
			<a
				onclick="view_user_section('users_content','view_events','{$profile->user_key}','{$languages->view_events}')">{$languages->view_events}</a> - 
		</div>
		<div class="profile_i">
			<a
				onclick="view_user_section('users_content','view_groups','{$profile->user_key}','{$languages->view_groups}')">{$languages->view_groups}</a> - 
		</div>
		{if !isset($best_friends_page) && !isset($family_friends_page) &&
		!isset($new_requests)}
		<div class="profile_i">
			<a
				onclick="user_interaction('{$profile->friend_key}','mark_best_friend')">{$languages->mark_best_friend}</a> - 
		</div>
		<div class="profile_i">
			<a onclick="user_interaction('{$profile->friend_key}','mark_family')">{$languages->mark_as_family}</a> - 
		</div>
		{/if}
		{if isset($best_friends_page)}
		<div class="profile_i">
			<a
				onclick="user_interaction('{$profile->friend_key}','unmark_best_friend')">{$languages->unmark_best_friend}</a> - 
		</div>
		{/if}
		{if isset($family_friends_page)}
		<div class="profile_i">
			<a
				onclick="user_interaction('{$profile->friend_key}','unmark_family_friend')">{$languages->unmark_family_friend}</a>
		</div>
		{/if}
	</div>
</div>
<div class="clear"></div>

<div class="profile_separator"></div>
