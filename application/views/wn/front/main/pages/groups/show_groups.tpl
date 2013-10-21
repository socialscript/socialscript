<div id="show_groups"  class="accordion"  >
	<div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#show_groups" href="#collapseBlogs">
	{$languages->groups}</a>
			</div>
    <div id="collapseBlogs" class="accordion-body collapse in">
      <div class="accordion-inner">
		<div class="middle_min_height" id="groups">{include
			file="$tpl_dir/pages/groups/groups.tpl"}</div>
	</div>
</div>
</div>
</div>
