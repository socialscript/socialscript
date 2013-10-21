{foreach from=$events item=event}
<a onclick="show_event('{$event->id}','{$event->user_key}')">{$event->title}<br />{$event->location},{$event->event_date}
</a>
<br />
{foreachelse} {$languages->events_no_results} {/foreach}
