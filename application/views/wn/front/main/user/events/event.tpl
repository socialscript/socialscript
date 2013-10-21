<div id="details_right"  class="accordion"  >
	<div class="accordion-group"> 
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#details_right" href="#collapseEventsDetails">{$event->title}</a>
		</div>
    <div id="collapseEventsDetails" class="accordion-body collapse in" style="min-height:400px;">
      <div class="accordion-inner">
		{$event->event_date} <br /> {$event->location} <br /> {$event->text} <br />
		{$languages->attending}: {foreach from=$attending item=user}
		{$user.user} {foreachelse} {$languages->attending_no_results} {/foreach}
	</div>
</div>
</div>
</div>