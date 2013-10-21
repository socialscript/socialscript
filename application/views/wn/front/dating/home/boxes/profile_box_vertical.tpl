<div id="{$profile->user_key}" class="profile_box_vertical  ui-widget-header" style="text-align:center;">
	<div>
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
			{else}onclick="view_profile('{$profile->user_key}')"{/if}{/if}><img src='resources/images/{$profile->gender}.png' />&nbsp;<b>{$profile->username}</b>
		</a> 
		<br /> 

	</div>
	<div style="text-align:center;">
		<div class="profile_i" style="float:left;">
			<a onclick="user_interaction('{$profile->user_key}','add_friend')" title="{$languages->add_friend}"><img style="border:none;" src="resources/images/add.png" /></a>&nbsp;
		</div>
		<div class="profile_i" style="float:left;">
			&nbsp;<a onclick="user_interaction('{$profile->user_key}','say_hello')" title="{$languages->say_hello}"><img style="border:none;" src="resources/images/hi.png" /></a>
		</div>
		<div style="clear:both;"></div>
	</div>
</div>
