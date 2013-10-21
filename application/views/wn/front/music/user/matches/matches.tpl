<div id="show_matches">
	<h3>
		<a href="#">{$languages->matches_title}</a>
	</h3>
	<div class="middle_min_height">{foreach from=$matches item=profile}
		{include file="$tpl_dir/home/boxes/profile_box.tpl"} {foreachelse}
		{$languages->no_results_matches} {/foreach}</div>
</div>
