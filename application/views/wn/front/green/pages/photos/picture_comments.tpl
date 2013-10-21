<div id="details_left">
	<h3>
		<a href="#">{$languages->comments_title}</a>
	</h3>
	<div>
		<div id="comments_list_details">{include
			file="$tpl_dir/pages/photos/comments.tpl"}</div>
		<br />
		<textarea name="picture_comment" id="picture_comment"
			class="comments_textarea"></textarea>
		<input type="button" name="submit"
			onclick="add_picture_comment({$p_id})" value="Submit"
			class="ui-widget-header input">
	</div>
</div>
<div class="box_separator">&nbsp;</div>
