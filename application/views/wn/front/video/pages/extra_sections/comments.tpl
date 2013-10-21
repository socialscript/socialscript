{foreach from=$extra_sections_comments item=comment}
<div class="comment_text   ui-widget-header">
		{$comment->comment}
		<br />
		<div class="comment_info ">
		{$languages->by}: <a {if $settings->only_logged_in_users_can_view_profile_info ==
							'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
							{else}{if
							$no_ajax=='yes'}href="{$settings->site_url}profile/{$comment->username}"
							{else}onclick="view_profile('{$comment->user_key}')"{/if}{/if}>{$comment->username}</a> {$comment->timestamp|date_format:$settings->date_format}
		</div>
		</div>


		{foreachelse}
		{$languages->comments_no_results}
		{/foreach}

