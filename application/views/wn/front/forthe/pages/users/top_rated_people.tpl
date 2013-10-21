<div id="show_top_rated_people">
	<h3>
		<a href="#">{$languages->top_rated_people}</a>
	</h3>
	<div class="middle_min_height" id="top_rated_people">

		{foreach from=$users item=profile} {include
		file="$tpl_dir/home/boxes/profile_box.tpl"} {foreachelse}
		{$languages->no_results} {/foreach} {if isset($pagination)}
		<div class="pagination">{$pagination}</div>
		{/if}

	</div>
</div>