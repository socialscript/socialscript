<section>
	<div class="floatleft" id="middle">
		<div id="middle_default">
			<div id="middle_boxes"> 
				<div>{include file="$tpl_dir/home/boxes/latest_people.tpl"}</div>
				<div>{include file="$tpl_dir/home/boxes/top_rated_people.tpl"}</div>
			</div>
		</div>
		<div class="separator_vertical">&nbsp;</div>
		<div id="middle_matches" style="margin-top: 100px;">
			<h3>
				<a href="#">{$languages->matches_title}</a>
			</h3>
			<div>
				{foreach from=$matches item=profile} {include
				file="$tpl_dir/home/boxes/profile_box.tpl"} {foreachelse}
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
