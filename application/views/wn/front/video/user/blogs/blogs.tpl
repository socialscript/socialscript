{foreach from=$blogs item=blog}
<div style="padding-top:10px;">
	<div><img src='resources/images/blog-entry-icon.png' /><a class="new-blog-title" onclick="show_blog('{$blog->id}','{$blog->user_key}')">{$blog->title}</a></div>
		<div class="new-blog-holder">
		
		{$languages->by|lcfirst}:<a class="new-blog-user" {if $settings->only_logged_in_users_can_view_profile_info == 'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
{else}{if $no_ajax=='yes'}href="{$settings->site_url}profile/{$blog->username}"
				{else}onclick="view_profile('{$blog->user_key}')"{/if}{/if}>{$blog->username}</a>, at {$blog->timestamp|date_format:$settings->date_format}
		</div>				
</div>
		{foreachelse}
		{$languages->blogs_no_results}
		{/foreach}