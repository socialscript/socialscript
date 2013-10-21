
<div class="separator_vertical">&nbsp;</div>
<div id="search_results_results">
	<h3>
		<a href="#">{$languages->search_results_title}</a>
	</h3>
	<div class="middle_min_height">

		{foreach from=$users item=profile} {include
		file="$tpl_dir/home/boxes/profile_box.tpl"} {foreachelse}
		{$languages->search_results_no_results} {/foreach} <br />

	</div>
</div>