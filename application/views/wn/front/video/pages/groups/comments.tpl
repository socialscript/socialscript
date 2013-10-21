{foreach from=$comments item=comment}
<div class="comment_text   ui-widget-header">
		{$comment->comment}
		</div>
		<div class="comment_info ">
		By: <a onclick="view_profile('{$comment->user_key}')">{$comment->username}</a> {$comment->timestamp|date_format:$settings->date_format}
		</div>

		{foreachelse}
		{$languages->comments_no_results}
		{/foreach}

