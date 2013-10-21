{foreach from=$hellos item=message}
<div id="message_{$message->id}" class="message  label label-info">

	<div class="floatleft message_horizontal_separator">
		{$languages->from}:<a onclick="view_profile('{$message->user_key}')"><strong>{$message->username}</strong></a>
	</div>
	<div class="floatright message_horizontal_separator">
		{$message->timestamp|date_format}</div>
<!--
	<div class="floatright message_horizontal_separator">
		<a onclick="delete_message('{$message->id}')">{$languages->delete}</a>
	</div>
	-->
	<div class="floatright message_horizontal_separator">
		<a onclick="send_message('{$message->user_key}')">{$languages->reply}</a>
	</div>
	<div class="clear"></div>
</div>
{foreachelse} {$languages->messages_no_results} {/foreach}

<div class="pagination">{$pagination}</div>