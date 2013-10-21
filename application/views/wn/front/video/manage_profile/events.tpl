	{foreach from=$events item=event}
	<div>
		<a onclick="edit_event('{$event->id}')">{$event->title}</a>
	</div>
	{foreachelse} {$languages->events_no_results}  {/foreach}