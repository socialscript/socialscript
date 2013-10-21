{foreach from=$group_blogs item=group_blog}
<div class="blogs_left label label-info ">
	<a onclick="view_group_blog('{$group_blog->id}')">{$group_blog->title}</a>
	<div class="blogs_info ">
	{if $group_blog->edit == 'yes'}<a onclick="edit_group_blog({$group_blog->id})">{$languages->edit}</a> &nbsp;&nbsp;{/if}
		{$languages->by}: <a {if $settings->only_logged_in_users_can_view_profile_info
			==
			'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
			{else}{if
			$no_ajax=='yes'}href="{$settings->site_url}profile/{$group_blog->username}"
			{else}onclick="view_profile('{$group_blog->user_key}')"{/if}{/if}>{$group_blog->username}</a>
		{$group_blog->timestamp|date_format:$settings->date_format}
	</div>
</div>
{foreachelse} {$languages->blogs_no_results}{/foreach}

