 	<div id="show_videos"  class="accordion"  >
	<div class="accordion-group"> 
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#show_videos" href="#collapseVideos">
	 {$languages->videos}</a>
	</div>
    <div id="collapseVideos" class="accordion-body collapse in">
      <div class="accordion-inner">
	<div class="middle_min_height" id="videos">{include
		file="$tpl_dir/pages/video/video.tpl"}</div>
</div>
</div>
</div>

