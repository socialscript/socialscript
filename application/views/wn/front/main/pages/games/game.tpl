
<div id="details_right"  class="accordion"  >
	<div class="accordion-group"> 
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#details_right" href="#collapseEventsDetails">{$game->title}</a>
		</div>
    <div id="collapseEventsDetails" class="accordion-body collapse in" style="min-height:400px;">
      <div class="accordion-inner">
	<div class="middle_min_height">


		{$game->code} <br /> {$languages->tags}: {$game->tags} <br />
		{$game->description}
	</div>
</div>
</div>
</div>