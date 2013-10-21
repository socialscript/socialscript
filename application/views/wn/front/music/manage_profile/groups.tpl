 {foreach from=$groups item=group}
<div class="edit_event_left ui-widget-header">
	<a onclick="edit_group('{$group->id}')">{$group->group_name}</a>
</div>
{foreachelse} {$languages->groups_no_results} {/foreach}
