<div id="show_events"  class="accordion"  >
	<div class="accordion-group"> 
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#show_events" href="#collapseEvents">{$languages->events}</a>
		</div>
    <div id="collapseEvents" class="accordion-body collapse in">
      <div class="accordion-inner">
	<div class="middle_min_height" id="events">{include
		file="$tpl_dir/pages/events/events_layout.tpl"}</div>

</div>
</div>
</div>


