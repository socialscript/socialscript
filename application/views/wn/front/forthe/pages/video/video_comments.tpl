<div id="left_details">
	<h3>
		<a href="#">{$languages->comments_title}</a>
	</h3>
	<div>
		<div id="comments_list_details">{include
			file="$tpl_dir/pages/video/comments.tpl"}</div>

		<br />
		<textarea name="video_comment" id="video_comment"
			class="comments_textarea"></textarea>
		<input type="button" name="submit"
			onclick="add_video_comment({$video_id})" value="Submit"
			class="ui-widget-header input">
	</div>
</div>

<div class="box_separator">&nbsp;</div>