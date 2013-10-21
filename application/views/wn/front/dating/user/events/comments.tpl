{foreach from=$events_comments item=comment}
<div class="comment_text   ui-widget-header">
	{$comment->comment}

	<div class="comment_info ">
		{$languages->by}: <a onclick="view_profile('{$comment->user_key}')">{$comment->username}</a>
		{$comment->timestamp|date_format:$settings->date_format}
	</div>
</div>

{foreachelse} {$languages->comments_no_results} {/foreach}
