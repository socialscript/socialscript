{foreach from=$blogs item=blog}
<div class="blogs_left label label-info">
	<a onclick="show_blog('{$blog->id}','{$blog->user_key}')">{$blog->title}</a><br />
	<a {if $settings->only_logged_in_users_can_view_profile_info ==
		'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
		{else}{if
		$no_ajax=='yes'}href="{$settings->site_url}profile/{$blog->username}"
		{else}onclick="view_profile('{$blog->user_key}')"{/if}{/if}>{$blog->username}</a>
	{$blog->timestamp|date_format:$settings->date_format}
</div>
{foreachelse} {$languages->blogs_no_results} {/foreach}
{if
isset($pagination)}
<div class="pagination">{$pagination}</div>
{/if}