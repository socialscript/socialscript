<div id="show_friends"  class="accordion"  >
	<div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#show_friends" href="#collapseBlogs">{$languages->friends}</a>
		</div>
    <div id="collapseBlogs" class="accordion-body collapse in">
      <div class="accordion-inner">

 
		<div class="middle_min_height" id="friends_list">{include
			file="$tpl_dir/manage_profile/friends/friends_inner.tpl"}</div>
</div>
</div>
</div>
	<div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#show_friends" href="#collapseBlogs">{$languages->new_requests}</a>
		</div>
    <div id="collapseBlogs" class="accordion-body collapse in">
      <div class="accordion-inner">

			<div class="middle_min_height">{assign var="new_requests" value="1"}
				{foreach from=$friends_requests item=profile} {include
				file="$tpl_dir/manage_profile/friends/friends_user_box.tpl"}
				{foreachelse} {$languages->no_results} {/foreach}</div>
		</div>

	</div>

</div>