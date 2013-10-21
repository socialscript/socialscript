<div id="chat_rooms_messages">
	<div id="chat_rooms_default">{if $user_logged === FALSE &&
		$settings->only_logged_users_can_post_on_chatrooms == 'yes'}
		{$languages->you_need_to_login_to_chat_in_chatrooms}{else}{$languages->chat_choose_a_chatroom}{/if}</div>
</div>
<div class="ui-widget-header btn-danger chat_vertical_separator">&nbsp;</div>
<div id="chat_rooms">
	<div id="active_chat_rooms" class="hidden"></div>
	{foreach from=$chatrooms item=chatroom} <a
		onclick="chatroom_chat('{$chatroom->id}')">{$chatroom->room_name}</a><br />
	{foreachelse} {/foreach}
</div>

