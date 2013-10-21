<div id="show_all_users">
	<h3>
		<a href="#">{$languages->all_users}</a>
	</h3>
	<div class="middle_min_height" id="all_users">
		{foreach from=$users item=profile} {include
		file="$tpl_dir/home/boxes/profile_box.tpl"} {foreachelse}
		{$languages->no_results} {/foreach} {if isset($pagination)}
		<div class="pagination">{$pagination}</div>
		{/if}

	</div>
</div>