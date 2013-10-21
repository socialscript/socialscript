	<div id="show_top_rated_people"  class="accordion"  >
	<div class="accordion-group"> 
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#show_top_rated_people" href="#collapseTopRatedPeople">
 {$languages->top_rated_people}</a>
	</div>
    <div id="collapseTopRatedPeople" class="accordion-body collapse in">
      <div class="accordion-inner">
	<div class="middle_min_height" id="top_rated_people">

		{foreach from=$users item=profile} {include
		file="$tpl_dir/home/boxes/profile_box.tpl"} {foreachelse}
		{$languages->no_results} {/foreach} {if isset($pagination)}
		<div class="pagination">{$pagination}</div>
		{/if}

	</div>
</div>
</div>
</div>