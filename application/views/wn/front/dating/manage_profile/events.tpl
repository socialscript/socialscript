 {foreach from=$events item=event}
<div class="edit_event_left ui-widget-header">
	<a onclick="edit_event('{$event->id}')">{$event->title}</a>
</div>
{foreachelse} {$languages->events_no_results} {/foreach}
