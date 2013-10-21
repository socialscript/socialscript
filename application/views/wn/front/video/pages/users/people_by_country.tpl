<div id="show_people_by_country">
				<h3>
					<a href="#">{$languages->peoples_by_country}: {$country_name->country}</a>
				</h3>
				<div class="middle_min_height">

{foreach from=$users item=profile}
				{include file="$tpl_dir/home/boxes/profile_box.tpl"}
				{foreachelse}
				{$languages->no_results}
				{/foreach}

<br />

				</div>
</div>