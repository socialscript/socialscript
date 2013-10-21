<div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle btn-success" data-toggle="collapse" data-parent="#middle_boxes" href="#collapseFeaturedTwo">{$languages->latest_people_title}</a>
	</div>
	  <div id="collapseFeaturedTwo" class="accordion-body collapse">
      <div class="accordion-inner">
	<div class="middle_min_height">{foreach from=$latest_profiles
		item=profile} {include file="$tpl_dir/home/boxes/profile_box.tpl"}
		{foreachelse} None yet {/foreach}</div>

</div>
</div>
</div>