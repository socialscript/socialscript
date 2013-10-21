
<div id="details_right">
	<h3>
		<a href="#">{$picture->title}</a>
	</h3>
	<div>
	<div class="floatleft picture_details_picture">{$thumb}</div>
	<div class="floatleft picture_details_text">
		{$picture->description} <br /> {$picture->tags}
	</div>
	<div class="clear"></div>
	</div>
</div>

<div class="separator_vertical clear">&nbsp;</div>
<div id="details_left" style="margin-top:30px">
<h3 >
		<a href="#">{$languages->comments_title}</a>
		</h3>
		<div>
		<div id="comments_list_details">
		{include file="$tpl_dir/pages/photos/comments.tpl"}
</div>
<br />
<textarea name="picture_comment" id="picture_comment" class="comments_textarea_big"></textarea>
<input type="button" name="submit" onclick="add_picture_comment({$picture->id})" value="Submit" class="ui-widget-header input">
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
$('#picture_comment').wysiwyg({dialog:"jqueryui",formWidth:300});
$(".wysiwyg").addClass('comments_textarea_big');
$("#picture_comment-wysiwyg-iframe").addClass('comments_textarea_big');
});
</script>
{/literal}
