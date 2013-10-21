<div id="chat_friends_messages">
	<div id="chat_friends_default">{if $user_logged === FALSE}
		{$languages->you_need_to_login_to_see_your_friends}{elseif
		$online_friends|count > 0}{$languages->chat_choose_a_friend}
		{else}{/if}</div>
</div>
<div class="ui-widget-header chat_vertical_separator">&nbsp;</div>
<div id="chat_friends">
	<div id="active_chat_friend" class="hidden"></div>
	{foreach from=$online_friends item=friend} {if $friend->online == 1}<a
		onclick="friend_chat('{$friend->username}')">{$friend->username}</a><br />{/if}
	{foreachelse} {$languages->no_online_friends} {/foreach}
</div>

