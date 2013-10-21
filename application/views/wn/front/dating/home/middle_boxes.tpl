<section>
	<div class="floatleft" id="middle">
		<div id="middle_default">
			<div id="middle_boxes"  style="min-height:450px;max-height:450px;">
				<div>{include file="$tpl_dir/home/boxes/featured_profiles.tpl"}</div>
			</div>
		</div>
		<div class="separator_vertical">&nbsp;</div>
		<div id="middle_matches" style="margin-top: 35px;min-height:150px;max-height:150px;">
			<h3>
				<a href="#">{$languages->latest_people_title}</a>
			</h3>
			<div style="min-height:185px;max-height:185px;"> 
				{foreach from=$latest_profiles item=profile} {include
				file="$tpl_dir/home/boxes/profile_box_vertical.tpl"} {foreachelse}
				{$languages->no_results_matches} {/foreach}
				<div></div>

			</div>
		</div>


	</div> 
</section>

{literal}
<script type="text/javascript">
$("#middle_matches").accordion({
	header : "h3",
	 animated: 'bounceslide',
	 fillSpace: true

});
</script>
{/literal}
