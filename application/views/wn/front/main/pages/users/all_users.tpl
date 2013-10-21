<div id="show_all_users"  class="accordion"  >
	<div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#show_all_users" href="#collapseAllUsers">{$languages->all_users}</a>
		</div>
    <div id="collapseAllUsers" class="accordion-body collapse in">
      <div class="accordion-inner">
	<div class="middle_min_height" id="all_users">
		{foreach from=$users item=profile} {include
		file="$tpl_dir/home/boxes/profile_box.tpl"} {foreachelse}
		{$languages->no_results} {/foreach} {if isset($pagination)}
		<div class="pagination">{$pagination}</div>
		{/if}

	</div>
	</div>
	</div>
</div>