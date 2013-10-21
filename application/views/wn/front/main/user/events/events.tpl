{foreach from=$events item=event}
<div class="events_left label label-info">
<a onclick="show_event('{$event->id}','{$event->user_key}')">{$event->title}<br />{$event->location},{$event->event_date}
</a>
</div>
{foreachelse} {$languages->events_no_results} {/foreach}
{if
isset($pagination)}
<div class="pagination">{$pagination}</div>
{/if}