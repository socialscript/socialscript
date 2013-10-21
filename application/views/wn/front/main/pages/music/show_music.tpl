<div id="show_music_files"  class="accordion"  >
	<div class="accordion-group"> 
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#show_music_files" href="#collapseMusic">
	{$languages->music}</a>
	</div>
    <div id="collapseMusic" class="accordion-body collapse in">
      <div class="accordion-inner">
	<div class="middle_min_height" id="music_files">{include
		file="$tpl_dir/pages/music/music.tpl"}</div>
</div>
</div>
</div>
