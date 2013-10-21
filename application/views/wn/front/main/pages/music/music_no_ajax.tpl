{include
		file="$tpl_dir/pages/music/music_inner.tpl"}
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
<div id="left_details">
		<div id="details_left"  class="accordion"  >
	<div class="accordion-group"> 
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#details_left" href="#collapseEventsDetails">{$languages->comments_title}</a>
		</div>
		
		 <div id="collapseEventsDetails" class="accordion-body collapse in" style="min-height:400px;">
      <div class="accordion-inner">
			<div id="comments_list_details">{include
				file="$tpl_dir/pages/music/comments.tpl"}</div>
			<br />
			<textarea name="music_comment" id="music_comment"
				class="comments_textarea"></textarea>
			<input type="button" name="submit"
				onclick="add_music_comment({$music->id})" value="Submit"
				class="btn">
		</div>
	</div>
</div>
</div>
</div>
<div class="box_separator">&nbsp;</div>


{literal}
<script type="text/javascript">
var xml = {/literal}'{$music_playlist}'{literal};

$(function() {

	init_player_audio();
$("#left_details").accordion({
	header : "h3",
	 fillSpace: true
});
tiny_mce();
$("#music_comment").addClass('comments_textarea_big');
});
</script>
{/literal}
