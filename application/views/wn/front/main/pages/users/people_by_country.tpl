	<div id="show_people_by_country"  class="accordion"  >
	<div class="accordion-group"> 
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#show_people_by_country" href="#collapsePeopleByCountry">
	 {$languages->peoples_by_country}: {$country_name->country}</a>

	</div>
    <div id="collapsePeopleByCountry" class="accordion-body collapse in">
      <div class="accordion-inner">
      
      
	<div class="middle_min_height" id="people_by_country">

		{foreach from=$users item=profile} {include
		file="$tpl_dir/home/boxes/profile_box.tpl"} {foreachelse}
		{$languages->no_results} {/foreach} {if isset($pagination)}
		<div class="pagination">{$pagination}</div>
		{/if}

	</div>
</div>
</div>
</div>