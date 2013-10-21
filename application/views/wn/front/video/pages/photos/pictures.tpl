{foreach from=$pictures item=picture}
<div class="photos_left ui-widget-header">
		<a {if $no_ajax=='yes'}href="{$settings->site_url}photo/{$picture.safe_seo_url}/{$picture.id}"
				{else}onclick="show_picture_details('{$picture.id}','{$picture.gallery_id}','{$picture.gallery_name}','{$picture.user_key}','{$picture.pic_name}')"{/if}>{$picture.image}</a>
		<br />
<a {if $no_ajax=='yes'}href="{$settings->site_url}photo/{$picture.safe_seo_url}/{$picture.id}"
				{else}onclick="show_picture_details('{$picture.id}','{$picture.gallery_id}','{$picture.gallery_name}','{$picture.user_key}','{$picture.pic_name}')"{/if}>{$picture.title}</a>
<br />
{$picture.tags}
		<br />
		 <a {if $settings->only_logged_in_users_can_view_profile_info == 'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
{else}{if $no_ajax=='yes'}href="{$settings->site_url}profile/{$picture.username}"
				{else}onclick="view_profile('{$picture.user_key}')"{/if}{/if}>{$picture.username}</a> <br />
		</div>
		{foreachelse}
		{$languages->no_results_pictures}
		{/foreach}