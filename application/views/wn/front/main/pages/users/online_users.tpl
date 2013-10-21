	<div id="show_online_people"  class="accordion"  >
	<div class="accordion-group"> 
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#show_online_people" href="#collapseOnlineUsers">{$languages->online_users}</a>
	</div>
    <div id="collapseOnlineUsers" class="accordion-body collapse in">
      <div class="accordion-inner">
	<div class="middle_min_height" id="online_people">

		{foreach from=$users item=profile} {include
		file="$tpl_dir/home/boxes/profile_box.tpl"} {foreachelse}
		{$languages->no_results} {/foreach} {if isset($pagination)}
		<div class="pagination">{$pagination}</div>
		{/if}

	</div>
	</div>
	</div>
</div>