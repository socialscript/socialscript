<div id="show_matches"  class="accordion"  >
	<div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#best_friends" href="#collapseBlogs">{$languages->matches_title}</a>
		</div>
    <div id="collapseBlogs" class="accordion-body collapse in">
      <div class="accordion-inner">
      
      
	<div class="middle_min_height">{foreach from=$matches item=profile}
		{include file="$tpl_dir/home/boxes/profile_box.tpl"} {foreachelse}
		{$languages->no_results_matches} {/foreach}</div>
</div>
</div>
</div>

