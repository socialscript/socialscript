	<div id="show_photos"  class="accordion"  >
	<div class="accordion-group"> 
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#show_photos" href="#collapsePhotos">
	 {$languages->photos}</a>
	</div>
    <div id="collapsePhotos" class="accordion-body collapse in">
      <div class="accordion-inner">
	<div class="middle_min_height" id="photos">{include
		file="$tpl_dir/pages/photos/pictures.tpl"}</div>

</div>
</div>
</div>
