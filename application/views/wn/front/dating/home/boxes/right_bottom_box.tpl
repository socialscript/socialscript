
<div id="right_bottom_box" >
	<h3>
		<a href="#">{$languages->top_rated_people}</a>
	</h3>
	<div class="my_account_min_height">{foreach from=$top_rated_profiles
		item=profile} {include file="$tpl_dir/home/boxes/profile_box_vertical.tpl"}
		{foreachelse} {$languages->no_results_top_rated} {/foreach}
		<div class="clear"></div>
		</div>

</div>
<script type="text/javascript"><!--
google_ad_client = "ca-pub-0056216336604218";
/* dating */
google_ad_slot = "7577052359";
google_ad_width = 336;
google_ad_height = 280;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>
{literal}
<script type="text/javascript">
$("#right_bottom_box").accordion({
	header : "h3",
	 fillSpace: true

});
 
</script>
{/literal}

