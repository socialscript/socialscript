{foreach from=$group_events item=group_event}
	<div class="group_events_event ui-widget-header">
		<a onclick="view_group_event('{$group_event->id}')">{$group_event->title}</a>
	</div>
	{foreachelse} {$languages->events_no_results}{/foreach}