		<div id="middle_boxes">
		asdadina
			<div>{include file="$tpl_dir/front_boxes/boxes/featured_profiles.tpl"}</div>
					<div>{include file="$tpl_dir/front_boxes/boxes/latest_people.tpl"}</div>
					<div>{include file="$tpl_dir/front_boxes/boxes/top_rated_people.tpl"}</div>
			</div>
<div class="separator_vertical">&nbsp;</div>
		<div id="middle_matches">
<h3><a href="#">{$languages->matches_title}</a></h3>
<div>
{foreach from=$matches item=profile}
				{include file="$tpl_dir/front_boxes/boxes/profile_box.tpl"}
				{foreachelse}
				{$languages->no_results_matches}
				{/foreach}

				</div>
				</div>
