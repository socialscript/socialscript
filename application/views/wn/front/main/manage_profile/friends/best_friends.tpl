<div id="best_friends"  class="accordion"  >
	<div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#best_friends" href="#collapseBlogs">{$languages->best_friends}</a>
		</div>
    <div id="collapseBlogs" class="accordion-body collapse in">
      <div class="accordion-inner">
      
     
	<div class="middle_min_height" id="best_friends_list">{assign
		var="best_friends_page" value="1"} {include
		file="$tpl_dir/manage_profile/friends/best_friends_inner.tpl"}</div>

</div>
</div>
</div>