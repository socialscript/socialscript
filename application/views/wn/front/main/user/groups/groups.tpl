{foreach from=$groups item=group}
<div class="events_left label label-info">
<a {if
		$no_ajax=='yes'}href="{$settings->site_url}group/{$group->safe_seo_url}/{$group->id}"
		{else}onclick="group_details('{$group->id}','{$group->user_key}')"{/if}
		>{$group->group_name}</a>
,{$group->group_location}
 - <a onclick="join_group('{$group->id}','{$group->user_key}')">{$languages->join}</a>
</div>
{foreachelse} {$languages->groups_no_results} {/foreach}
{if
isset($pagination)}
<div class="pagination">{$pagination}</div>
{/if}