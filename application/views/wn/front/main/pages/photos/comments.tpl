
	{foreach from=$pictures_comments item=comment}
	<div class="comment_text  label label-info">
		{$comment->comment}

		<div class="comment_info ">
			{$languages->by}: <a onclick="view_profile('{$comment->user_key}')">{$comment->username}</a>
			{$comment->timestamp|date_format:$settings->date_format}
		</div>
	</div>
	{foreachelse} {$languages->comments_no_results} {/foreach}
