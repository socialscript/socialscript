
<div class="separator_vertical">&nbsp;</div>
<div id="search_results_results">
	<div id="search_results_results"  class="accordion"  >
	<div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#search_results_results" href="#collapseSearchResultsResults">{$languages->search_results_title}</a>
	</div>
    <div id="collapseSearchResultsResults" class="accordion-body collapse in">
      <div class="accordion-inner">
	<div class="middle_min_height">

		{foreach from=$users item=profile} {include
		file="$tpl_dir/home/boxes/profile_box.tpl"} {foreachelse}
		{$languages->search_results_no_results} {/foreach} <br />

	</div>
</div>
</div>
</div>