<div id="messages">
<h3><a href="#">{$languages->messages}</a></h3>
<div class="middle_min_height">
{foreach from=$messages item=message}
<div id="message_{$message->id}" class="message  ui-widget-header">
<div class="floatleft message_horizontal_separator">
<a onclick="show_message('{$message->id}','{$message->message_read}')">{$message->title}</a>
</div>
<div class="floatright message_horizontal_separator">
{$languages->from}:<a onclick="view_profile('{$message->user_key}')"><strong>{$message->username}</strong></a>
</div>
<div class="floatright message_horizontal_separator">
{$message->timestamp|date_format}
</div>
<div class="floatright message_horizontal_separator">
<a onclick="delete_message('{$message->id}')">{$languages->delete}</a>
</div>
<div class="clear"></div>
<div id="message_text_{$message->id}" class="message hidden">{$message->message}</div>
</div>
{foreachelse}
{$languages->messages_no_results}
{/foreach}
</div>
</div>
