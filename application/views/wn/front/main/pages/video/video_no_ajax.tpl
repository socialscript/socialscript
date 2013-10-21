{include
		file="$tpl_dir/pages/video/video_inner.tpl"}
<div id="player_box" class="label label-info" style="width:99%;">
	<div id="left_player"><div id="player"></div>
	<div id="description_player"></div></div>
	<!--
	<div id="right_player">
		<div id='playlist'></div>
	</div>
	-->
</div>
<div class="clear"></div>

<div class="separator_vertical clear">&nbsp;</div>
<div id="left_details"  class="accordion"  >
	<div class="accordion-group"> 
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#left_details" href="#collapseEventsDetails">{$languages->comments_title}</a>
		</div>
    <div id="collapseEventsDetails" class="accordion-body collapse in">
      <div class="accordion-inner">
			<div id="comments_list_details">{include
				file="$tpl_dir/pages/video/comments.tpl"}</div>
			<br />
			<textarea name="video_comment" id="video_comment"
				class="comments_textarea"></textarea>
			<input type="button" name="submit"
				onclick="add_video_comment({$video->id})" value="Submit"
				class="btn"> 
		</div>
	</div>
</div>
</div>
</div>

<div class="box_separator">&nbsp;</div>

{literal}
<script type="text/javascript">
var xml = {/literal}'{$video_playlist}'{literal};
$(function() {

	init_player();
$("#left_details").collapse();
tiny_mce();
$("#video_comment").addClass('comments_textarea_big');
});
</script>
{/literal}
