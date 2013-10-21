<div id="middle_home"  class="accordion"  style="min-height:600px;">

	<div>{include file="$tpl_dir/home/boxes/featured_profiles.tpl"}</div>
	<div>{*include file="$tpl_dir/home/boxes/latest_people.tpl"*}</div>
	<div>{*include file="$tpl_dir/home/boxes/top_rated_people.tpl"*}</div>
</div>
</div>
<div class="separator_vertical">&nbsp;</div>

<div id="middle_matches" class="accordion"  style="min-height:185px;{if $no_ajax == 'yes'}margin-top:-150px;{/if} ">
		<div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle btn-success" data-toggle="collapse" data-parent="#my_account_box" href="#collapseOne">{$languages->matches_title}</a>
			</div>
			 <div id="collapseOne" class="accordion-body collapse in">
      <div class="accordion-inner">
				{foreach from=$matches item=profile} {include
				file="$tpl_dir/home/boxes/profile_box_vertical.tpl"} {foreachelse}
				{$languages->no_results_matches} {/foreach} 
				<div>
	</div>
</div>
</div>
</div>

{literal}
<script type="text/javascript">
$("#middle_home").collapse();
$("#middle_matches").collapse();
</script>
{/literal}
