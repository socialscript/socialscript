<div id="middle_home">
	<div>{include file="$tpl_dir/home/boxes/featured_profiles.tpl"}</div>
	<div>{include file="$tpl_dir/home/boxes/latest_people.tpl"}</div>
	<div>{include file="$tpl_dir/home/boxes/top_rated_people.tpl"}</div>
</div>
</div>
<div class="separator_vertical">&nbsp;</div>
<div id="middle_matches"  >
	<div>
		<h3>
			<a href="#">{$languages->matches_title}</a>
		</h3>
		<div  class="middle_min_height">{foreach from=$matches item=profile} {include
			file="$tpl_dir/home/boxes/profile_box.tpl"} {foreachelse}
			{$languages->no_results_matches} {/foreach}</div>
	</div>
</div>

{literal}
<script type="text/javascript">
$("#middle_home").accordion({
	header : "h3",
	 animated: 'bounceslide',
	 fillSpace: true
});
$("#middle_matches").accordion({
	header : "h3",
	 fillSpace: true

});
</script>
{/literal}
