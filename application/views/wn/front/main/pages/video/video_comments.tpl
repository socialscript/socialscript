
<div id="left_details"  class="accordion"  >
	<div class="accordion-group"> 
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#left_details" href="#collapseEventsDetails">{$languages->comments_title}</a>
		</div>
    <div id="collapseEventsDetails" class="accordion-body collapse in" style="min-height:400px;">
      <div class="accordion-inner">
		<div id="comments_list_details">{include
			file="$tpl_dir/pages/video/comments.tpl"}</div>

		<br />
		<textarea name="video_comment" id="video_comment"
			class="comments_textarea"></textarea>
		<input type="button" name="submit"
			onclick="add_video_comment({$video_id})" value="Submit"
			class="btn">
	</div>
	</div>
	</div>
</div>

<div class="box_separator">&nbsp;</div>