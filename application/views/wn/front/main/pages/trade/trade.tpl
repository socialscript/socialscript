 {foreach from=$trade item=thetrade}
<div class="thetrade  label label-info">
	<a {if $no_ajax==
		'yes'}href="{$settings->site_url}trade/{$thetrade->title}/{$thetrade->id}"
		{else}onclick="trade_details('{$thetrade->id}','{$thetrade->user_key}')"{/if}>{$thetrade->title}</a>
	<div class="events_info ">
		{$languages->by}: <a {if $settings->only_logged_in_users_can_view_profile_info
			==
			'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
			{else}{if
			$no_ajax=='yes'}href="{$settings->site_url}profile/{$thetrade->username}"
			{else}onclick="view_profile('{$thetrade->user_key}')"{/if}{/if}>{$thetrade->username}</a>
		{$thetrade->timestamp|date_format:$settings->date_format}
	</div>
</div>


{foreachelse} {$languages->trade_no_results} {/foreach} {if
isset($pagination)}
<div class="pagination">{$pagination}</div>
{/if}
