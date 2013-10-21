<section>
	<div class="floatleft" id="middle">
		<div id="middle_default">
			<div id="middle_boxes" class="accordion"  style="min-height:560px;">
	
				{include file="$tpl_dir/home/boxes/featured_profiles.tpl"}
				{*include file="$tpl_dir/home/boxes/latest_people.tpl"*}
				{*include file="$tpl_dir/home/boxes/top_rated_people.tpl"*}
			</div>
		</div> 
		<div class="separator_vertical">&nbsp;</div>
		<div id="middle_matches" class="accordion"  style="min-height:185px;">
		<div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle btn-success" data-toggle="collapse" data-parent="#my_account_box" href="#collapseOne">{$languages->matches_title}</a>
			</div>
			 <div id="collapseOne" class="accordion-body collapse in">
      <div class="accordion-inner">
				{foreach from=$matches item=profile} {include
				file="$tpl_dir/home/boxes/profile_box_vertical.tpl"} {foreachelse}
				{$languages->no_results_matches} {/foreach}
				<div></div>

			</div></div>

			</div>
			</div>
		</div>


	</div>
</section>

{literal}
<script type="text/javascript">
$("#middle_matches").collapse();
</script>
{/literal}
