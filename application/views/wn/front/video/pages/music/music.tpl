{foreach from=$music item=themusic}
			<div class="new-music-box">
		<div><a {if $no_ajax=='yes'} href="{$settings->site_url}music/{$themusic->safe_seo_url}/{$themusic->id}"
				{else}onclick="music_details('{$themusic->id}','{$themusic->user_key}')"{/if} class="new-music-title">{$themusic->title}</a></div>
		
		<div class="new-music-uploader-line">{$languages->by}:  <a class="new-music-uploader" {if $settings->only_logged_in_users_can_view_profile_info == 'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
{else}{if $no_ajax=='yes'}href="{$settings->site_url}profile/{$themusic->username}"
				{else}onclick="view_profile('{$themusic->user_key}')"{/if}{/if}>{$themusic->username}</a></div>
				
				<div class="new-music-tags">{$themusic->tags}</div>
				</div>
		{foreachelse}
		{$languages->music_no_results}
		{/foreach}