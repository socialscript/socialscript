<div id="details_left">
<div>
<h3 >
		<a href="#">{$languages->comments_title}</a>
		</h3>
		<div>
		<div id="comments_list_details">
{include file="$tpl_dir/user/events/comments.tpl"}
</div>
		<br />
<textarea name="event_comment" id="event_comment" class="comments_textarea"></textarea>
<input type="button" name="submit" onclick="add_event_comment()" value="Submit" class="ui-widget-header input">
</div>
</div>