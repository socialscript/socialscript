<div id="{$profile->user_key}" class="profile_box_vertical  label label-info">
	<div >
		<a {if $settings->only_logged_in_users_can_view_profile_info ==
			'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
			{else}{if
			$no_ajax=='yes'}href="{$settings->site_url}profile/{$profile->username}"
			{else}onclick="view_profile('{$profile->user_key}')"{/if}{/if}>{$profile->profile_pic}</a>
	</div>
	<div >
		<a {if $settings->only_logged_in_users_can_view_profile_info ==
			'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
			{else}{if
			$no_ajax=='yes'}href="{$settings->site_url}profile/{$profile->username}"
			{else}onclick="view_profile('{$profile->user_key}')"{/if}{/if}><b>{$profile->username}</b>
		</a> <br />{$languages->gender}:{$profile->gender|ucfirst}
		<!-- {$profile->field}:{$profile->value}-->
		<br />  

		<div class="profile_i">
			<a onclick="user_interaction('{$profile->user_key}','add_friend')">{$languages->add_friend}</a>
		</div>
		<div class="profile_i">
			<a onclick="user_interaction('{$profile->user_key}','say_hello')">{$languages->say_hello}</a>
		</div>
		 

	</div>
</div>
 