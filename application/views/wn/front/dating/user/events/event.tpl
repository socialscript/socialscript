<div id="details_right">
	<h3>
		<a href="#">{$event->title}</a>
	</h3>
	<div>
		{$event->event_date} <br /> {$event->location} <br /> {$event->text} <br />
		{$languages->attending}: {foreach from=$attending item=user}
		{$user.user} {foreachelse} {$languages->events_no_results} {/foreach}
	</div>
</div>