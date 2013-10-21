
	<div id="chat" >
		<ul class="new-ul-right">
			<li class="new-li-right"><a href="#chat-1">{$languages->chat_tab_1}</a></li>
			<li class="new-li-right"><a href="#chat-2">{$languages->chat_tab_2}</a></li>
			{if $chatrooms|count > 0}
			<li class="new-li-right"><a href="#chat-3">{$languages->chat_tab_3}</a></li>
			{/if}
		</ul>

		<div id="chat-1">{include file="$tpl_dir/chat/general_chat.tpl"}</div>
		<div id="chat-2">{include file="$tpl_dir/chat/friends_chat.tpl"}</div>
		{if $chatrooms|count > 0}
		<div id="chat-3">{include file="$tpl_dir/chat/rooms_chat.tpl"}</div>
		{/if}

	</div>

