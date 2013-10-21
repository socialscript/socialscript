<h3>
					<a href="#">{$languages->top_rated_people}</a>
				</h3>
				<div>
				{foreach from=$top_rated_profiles item=profile}
				{include file="$tpl_dir/front_boxes/boxes/profile_box.tpl"}
				{foreachelse}
				{$languages->no_results_top_rated}
				{/foreach}

</div>