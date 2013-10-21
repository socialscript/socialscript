
<div id="details_right">
	<h3>
					<a href="#">{$extra_section->title}</a>
				</h3>
		<div id="extra_sections_details">
			{$extra_section->text}
		</div>
		</div>

 <div class="separator_vertical clear">&nbsp;</div>
	<div id="details_left"  style="margin-top:30px;">

<h3>
		<a href="#">{$languages->comments_title}</a>
		</h3>
<div>
		<div id="comments_list_details">
		{include file="$tpl_dir/pages/extra_sections/comments.tpl"}
		</div>
<br />
<form id="extra_sections_form">

<textarea name="extra_sections_comment" id="extra_sections_comment" class="comments_textarea_big"></textarea>
<input type="button" name="submit" onclick="add_extra_sections_comment('{$type}','{$extra_section->id}')" value="Submit" class="ui-widget-header  input">

</form>
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
$('#extra_sections_comment').wysiwyg({dialog:"jqueryui",formWidth:300});
$(".wysiwyg").addClass('comments_textarea_big');
$("#extra_sections_comment-wysiwyg-iframe").addClass('comments_textarea_big');
});
</script>
{/literal}