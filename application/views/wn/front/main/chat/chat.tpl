
<div id="chat">
	<ul class="nav nav-tabs" id="chat_tabs">
		<li class="active"  ><a href="#chat-1" data-toggle="tab">{$languages->chat_tab_1}</a></li>
		<li><a href="#chat-2" data-toggle="tab">{$languages->chat_tab_2}</a></li> {if
		$chatrooms|count > 0}
		<li><a href="#chat-3" data-toggle="tab">{$languages->chat_tab_3}</a></li> {/if}
	</ul>
<div class="tab-content">
	<div class="tab-pane active" id="chat-1">{include file="$tpl_dir/chat/general_chat.tpl"}</div>
	<div class="tab-pane" id="chat-2">{include file="$tpl_dir/chat/friends_chat.tpl"}</div>
	{if $chatrooms|count > 0}
	<div class="tab-pane" id="chat-3">{include file="$tpl_dir/chat/rooms_chat.tpl"}</div>
	{/if}

</div>
</div>
 
