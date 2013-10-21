
<div id="details_right"  class="accordion"  >
	<div class="accordion-group"> 
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#details_right" href="#collapsePicDetails">{$picture->title}</a>
	</div>
    <div id="collapsePicDetails" class="accordion-body collapse in">
      <div class="accordion-inner">
		<div class="picture_details_picture">{$thumb}</div>
		<div class="picture_details_text">
			{$picture->description} <br />  <div class="floatleft" style="margin-right:10px;"><span class="btn btn-warning">{$languages->tags}:</span></div> <div class="floatleft"> {$picture->tags}</div>
		</div>
		<div class="clear"></div>
	</div>
</div>
</div>
</div>

<div class="separator_vertical clear">&nbsp;</div>

<div id="details_left"  class="accordion"  >
	<div class="accordion-group"> 
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#details_left" href="#collapsePicDetailsComments">{$languages->comments_title}</a>
	</div>
    <div id="collapsePicDetailsComments" class="accordion-body collapse in">
      <div class="accordion-inner">
		<div id="comments_list_details">{include
			file="$tpl_dir/pages/photos/comments.tpl"}</div>
		<br />
		<textarea name="picture_comment" id="picture_comment"
			class="comments_textarea_big"></textarea>
		<input type="button" name="submit"
			onclick="add_picture_comment({$picture->id})" value="Submit"
			class="ui-widget-header input">
	</div>
	</div>
	</div>
</div>
<div class="box_separator">&nbsp;</div>


{literal}
<script type="text/javascript">
$(function() {
$("#details_right").accordion({
	header : "h3",
	 fillSpace: true
});

$("#details_left").accordion({
	header : "h3",
	 fillSpace: true
});
tiny_mce();
$("#picture_comment").addClass('comments_textarea_big');

});
</script>
{/literal}
