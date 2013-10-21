
<div id="details_right"  class="accordion"  >
	<div class="accordion-group"> 
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#details_right" href="#collapsePicDetals">{$picture->title}</a>
	</div>
    <div id="collapsePicDetals" class="accordion-body collapse in">
      <div class="accordion-inner">
	<div style="width: 91.5%;">
		<div class="picture_details_picture">{$thumb}</div>
		<div class="picture_details_text" style="width:100%;">
			{$picture->description} <br /> <div class="floatleft" style="margin-right:5px;"><span class="btn btn-warning">{$languages->tags}:</span></div> <div class="floatleft">{$picture->tags}</div>
					<div class="clear"></div>

		</div>
		<div class="clear"></div>
	</div>
</div>
</div>
</div>
