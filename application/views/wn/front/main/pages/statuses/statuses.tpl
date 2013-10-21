<div id="show_statuses"  class="accordion"  >
	<div class="accordion-group"> 
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#show_statuses" href="#collapseStatuses">{$languages->latest_statuses}</a>
		</div>
    <div id="collapseStatuses" class="accordion-body collapse in">
      <div class="accordion-inner">
		<div class="middle_min_height">



			<div id="latest_statuses">
				{foreach from=$statuses item=status}
				<blockquote class="example-obtuse speech_bubble">{$status->status}</blockquote>
				<p>{$languages->by}: {$status->username}</p>
				{foreachelse} {$languages->no_statuses} {/foreach}
			</div>

			<div class="clear"></div>
		</div>
	</div>
</div>
</div>
</div>
