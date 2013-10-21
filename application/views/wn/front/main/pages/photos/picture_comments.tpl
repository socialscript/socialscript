<div id="details_left"  class="accordion"  >
	<div class="accordion-group"> 
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#details_left" href="#collapsePicComments">{$languages->comments_title}</a>
	</div>
    <div id="collapsePicComments" class="accordion-body collapse in">
      <div class="accordion-inner">
		<div id="comments_list_details">{include
			file="$tpl_dir/pages/photos/comments.tpl"}</div>
		<br />
		<textarea name="picture_comment" id="picture_comment"
			class="comments_textarea"></textarea>
		<input type="button" name="submit"
			onclick="add_picture_comment({$p_id})" value="Submit"
			class="btn ">
	</div>
</div>
</div>
</div>
<div class="box_separator">&nbsp;</div>
