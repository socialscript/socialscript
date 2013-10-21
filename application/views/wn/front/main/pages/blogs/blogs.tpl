<div id="show_blogs"  class="accordion"  >
	<div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#show_blogs" href="#collapseBlogs">{$languages->blogs}</a>
		</div>
    <div id="collapseBlogs" class="accordion-body collapse in">
      <div class="accordion-inner">
	<div class="middle_min_height" id="blogs">{include
		file="$tpl_dir/pages/blogs/blogs_layout.tpl"}</div>

</div>
</div>
</div>
