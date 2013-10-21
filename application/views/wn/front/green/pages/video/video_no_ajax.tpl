<div id="player_box">
	<div id="left_player"></div>
	<div id="right_player">
		<div id='playlist'></div>
	</div>
</div>
<div class="clear"></div>

<div class="separator_vertical clear">&nbsp;</div>
<div id="left_details">
	<div>
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
				onclick="add_video_comment({$video->id})" value="Submit"
				class="ui-widget-header input">
		</div>
	</div>
</div>

<div class="box_separator">&nbsp;</div>

{literal}
<script type="text/javascript">
var xml = {/literal}'{$video_playlist}'{literal};
		var width = {/literal}{$user_video_settings->video_player_width}{literal};
				var height = {/literal}{$user_video_settings->video_player_height}{literal};
$(function() {

	init_player();
$("#left_details").accordion({
	header : "h3",
	 fillSpace: true
});
$('#video_comment').wysiwyg({dialog:"jqueryui"});
$(".wysiwyg").addClass('comments_textarea_big');
$("#video_comment-wysiwyg-iframe").addClass('comments_textarea_big');
});
</script>
{/literal}
