<div class="vertical_separator">&nbsp;</div>
<div id="left_bottom_box">
		<h3>
			<a href="#">{$languages->matches_title}</a>
		</h3>
		<div class="my_account_min_height">{foreach from=$matches item=profile} {include
				file="$tpl_dir/home/boxes/profile_box_vertical.tpl"} {foreachelse}
				{$languages->no_results_matches} {/foreach}
				<div class="clear"></div>
				</div>
	</div>





