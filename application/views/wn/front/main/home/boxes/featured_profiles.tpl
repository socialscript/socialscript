		<div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle btn-success" data-toggle="collapse" data-parent="#middle_boxes" href="#collapseFeaturedOne">{$languages->featured_profiles_title}</a>
	</div>
	  <div id="collapseFeaturedOne" class="accordion-body collapse in">
      <div class="accordion-inner">
	<div class="middle_min_height">{foreach from=$featured_profiles
		item=profile} {include file="$tpl_dir/home/boxes/profile_box.tpl"}
		{foreachelse} None yet {/foreach}</div>
</div>
</div>
</div>