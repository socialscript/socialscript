<div id="show_people_by_country">
	<h3>
		<a href="#">{$languages->peoples_by_country}: {$country_name->country}</a>
	</h3>
	<div class="middle_min_height" id="people_by_country">

		{foreach from=$users item=profile} {include
		file="$tpl_dir/home/boxes/profile_box.tpl"} {foreachelse}
		{$languages->no_results} {/foreach} {if isset($pagination)}
		<div class="pagination">{$pagination}</div>
		{/if}

	</div>
</div>