{if $events|count > 0}
<select name="events_to_invite" id="invite_to_event_id_{$id}"> {foreach
	from=$events item=event}
	<option value="{$event->id}">{$event->title}</option> {/foreach}
</select>
<input type='button' value='Invite' onclick="invite_to_event_2('{$id}')">
{else} {$languages->no_future_events} {/if}

