 {foreach from=$events item=event}
<div class="edit_event_left label label-info">
	<a onclick="edit_event('{$event->id}')">{$event->title}</a>
</div>
{foreachelse} {$languages->events_no_results} {/foreach}
