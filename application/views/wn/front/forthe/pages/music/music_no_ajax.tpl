<div id="player_box">
	<div id="left_player"></div>
	<div id="right_player">
		<div id='playlist'></div>
	</div>
	<div id="description_player"></div>
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
				file="$tpl_dir/pages/music/comments.tpl"}</div>
			<br />
			<textarea name="music_comment" id="music_comment"
				class="comments_textarea"></textarea>
			<input type="button" name="submit"
				onclick="add_music_comment({$music->id})" value="Submit"
				class="ui-widget-header input">
		</div>
	</div>
</div>
<div class="box_separator">&nbsp;</div>


{literal}
<script type="text/javascript">
var xml = {/literal}'{$music_playlist}'{literal};
		var width = 460;
		var height = 100;

$(function() {

	init_player_audio();
$("#left_details").accordion({
	header : "h3",
	 fillSpace: true
});
$('#music_comment').wysiwyg({dialog:"jqueryui"});
$(".wysiwyg").addClass('comments_textarea_big');
$("#music_comment-wysiwyg-iframe").addClass('comments_textarea_big');
});
</script>
{/literal}
