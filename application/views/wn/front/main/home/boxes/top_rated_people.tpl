	<div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle btn-success" data-toggle="collapse" data-parent="#middle_boxes" href="#collapseFeaturedThree">{$languages->top_rated_people}</a>
	</div>
	  <div id="collapseFeaturedThree" class="accordion-body collapse">
      <div class="accordion-inner">
	<div class="middle_min_height">{foreach from=$top_rated_profiles
		item=profile} {include file="$tpl_dir/home/boxes/profile_box.tpl"}
		{foreachelse} {$languages->no_results_top_rated} {/foreach}</div>
</div>
</div>
</div>