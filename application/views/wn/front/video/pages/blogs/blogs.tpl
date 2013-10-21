<div id="show_blogs">
				<h3>
					<a href="#">{$languages->blogs}</a>
				</h3>
				<div class="middle_min_height">

{foreach from=$blogs item=blog}
<div class="blogs_left ui-widget-header">
		<a {if $no_ajax=='yes'}href="{$settings->site_url}blog/{$blog->safe_seo_url}/{$blog->id}"
				{else}onclick="show_blog_details('{$blog->id}','{$blog->user_key}')"{/if}>{$blog->title}</a>
<br />		<div class="blogs_info ">
		By: <a {if $settings->only_logged_in_users_can_view_profile_info == 'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
{else}{if $no_ajax=='yes'}href="{$settings->site_url}profile/{$blog->username}"
				{else}onclick="view_profile('{$blog->user_key}')"{/if}{/if}>{$blog->username}</a> {$blog->timestamp|date_format:$settings->date_format}
		</div>
</div>

		{foreachelse}
		{$languages->blogs_no_results}
		{/foreach}

<br />

				</div>
		<div id="view_blogs_profile_page">
		<div id="blogs_comments"></div>
		<div id="blogs_profile_page"></div>
		</div>
</div>
