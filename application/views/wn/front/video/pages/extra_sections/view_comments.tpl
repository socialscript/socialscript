
	<div id="details_left">

<h3>
		<a href="#">{$languages->comments_title}</a>
		</h3>
<div>
		<div id="comments_list_details">
		{include file="$tpl_dir/pages/extra_sections/comments.tpl"}
		</div>

<form id="extra_sections_form">
<br />
<textarea name="extra_sections_comment" id="extra_sections_comment" class="comments_textarea validate[required]"></textarea>
<input type="button" name="submit" onclick="add_extra_sections_comment('{$type}','{$id}')" value="Submit" class="ui-widget-header  input">

</form>
</div>
</div>


<div class="box_separator">&nbsp;</div>